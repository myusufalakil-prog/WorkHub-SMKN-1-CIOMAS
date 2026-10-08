<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Jurusan;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectCollaborationAndProgressTest extends TestCase
{
    use RefreshDatabase;

    public function test_collaboration_approval_workflow_and_progress_calculation()
    {
        $this->seed(DatabaseSeeder::class);

        // 1. Setup users
        $lead = User::factory()->create([
            'name' => 'Ketua Tim',
            'email' => 'lead@gmail.com',
            'role' => 'siswa',
        ]);

        $applicant = User::factory()->create([
            'name' => 'Calon Anggota',
            'email' => 'applicant@gmail.com',
            'role' => 'siswa',
        ]);

        $jurusan = Jurusan::first();

        // 2. Lead creates project
        $createResponse = $this->actingAs($lead)->post('/siswa/proyek', [
            'title' => 'Game Edukasi Sejarah',
            'description' => 'Kolaborasi PPLG dan Animasi untuk game sejarah.',
            'jurusan' => [$jurusan->id],
            'members_target' => 4,
        ]);
        $createResponse->assertRedirect('/siswa/proyek');

        $project = Project::where('title', 'Game Edukasi Sejarah')->first();
        $this->assertNotNull($project);
        $this->assertEquals(0, $project->progress, 'Initial progress must be 0%');
        $this->assertEquals($lead->id, $project->lead_id);
        $this->assertTrue($project->activeMembers->contains('id', $lead->id));

        // 3. Applicant applies to join
        $applyResponse = $this->actingAs($applicant)->post("/siswa/proyek/{$project->id}/join", [
            'role_in_project' => '2D Asset Designer',
            'join_message' => 'Halo, saya ingin membantu aset grafis 2D.',
        ]);
        $applyResponse->assertRedirect('/siswa/proyek');

        // Verify status is PENDING, NOT active
        $this->assertTrue($project->fresh()->pendingMembers->contains('id', $applicant->id), 'Applicant must be in pending members');
        $this->assertFalse($project->fresh()->activeMembers->contains('id', $applicant->id), 'Applicant must NOT be active before lead approval');

        // 4. Lead approves applicant
        $approveResponse = $this->actingAs($lead)->post("/siswa/proyek/{$project->id}/members/{$applicant->id}/approve");
        $approveResponse->assertStatus(302);

        // Verify status is now ACTIVE
        $this->assertTrue($project->fresh()->activeMembers->contains('id', $applicant->id), 'Applicant must now be active member');
        $this->assertFalse($project->fresh()->pendingMembers->contains('id', $applicant->id), 'Applicant must no longer be pending');

        // 5. Test Progress calculation via tasks
        // Add Task 1
        $this->actingAs($lead)->post("/siswa/workspace/{$project->id}/tugas", [
            'title' => 'Buat Desain Karakter',
            'priority' => 'Tinggi',
        ]);

        $project = $project->fresh();
        $this->assertEquals(1, $project->tasks()->count());
        $this->assertEquals(0, $project->progress, 'Progress with 1 todo task must be 0%');

        $task1 = $project->tasks()->first();

        // Mark Task 1 as Done -> should be 100%
        $this->actingAs($lead)->post("/siswa/workspace/{$project->id}/tugas/{$task1->id}/status", [
            'status' => 'done',
        ]);

        $project = $project->fresh();
        $this->assertEquals(100, $project->progress, 'Progress with 1 done task out of 1 must be 100%');
        $this->assertEquals('Selesai', $project->status);

        // Add Task 2 -> total 2 tasks, 1 done, 1 todo -> progress should be 50%
        $this->actingAs($lead)->post("/siswa/workspace/{$project->id}/tugas", [
            'title' => 'Koding Game Logic',
            'priority' => 'Sedang',
        ]);

        $project = $project->fresh();
        $this->assertEquals(2, $project->tasks()->count());
        $this->assertEquals(50, $project->progress, 'Progress with 1 done out of 2 must be 50%');
        $this->assertEquals('Sedang Berjalan', $project->status);

        // 6. Test Workspace Switcher display
        $workspaceResponse = $this->actingAs($lead)->get("/siswa/workspace/{$project->id}");
        $workspaceResponse->assertStatus(200);
        $workspaceResponse->assertSee('Workspace Saya');
        $workspaceResponse->assertSee('Game Edukasi Sejarah');
    }
}
