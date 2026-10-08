<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminAllRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_account_can_access_all_portals()
    {
        $this->seed(DatabaseSeeder::class);
        $admin = User::where('email', 'admin@gmail.com')->first();
        $this->assertNotNull($admin, 'Admin account should exist in database.');
        $this->assertEquals('admin', $admin->role);
        $this->assertTrue($admin->isAdmin());
        $this->assertTrue($admin->isSiswa());
        $this->assertTrue($admin->isOsis());

        // Test login
        $loginResponse = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => 'password',
        ]);
        $loginResponse->assertRedirect('/portal');

        // Test Siswa Portal Access as Admin
        $siswaResponse = $this->actingAs($admin)->get('/siswa/dashboard');
        $siswaResponse->assertStatus(200);

        // Test OSIS Portal Access as Admin
        $osisResponse = $this->actingAs($admin)->get('/osis/dashboard');
        $osisResponse->assertStatus(200);

        // Test Portal Hub Access as Admin
        $portalResponse = $this->actingAs($admin)->get('/portal');
        $portalResponse->assertStatus(200);
        $portalResponse->assertSee('Mode Akun All-Role (Super Administrator) Aktif');
    }
}
