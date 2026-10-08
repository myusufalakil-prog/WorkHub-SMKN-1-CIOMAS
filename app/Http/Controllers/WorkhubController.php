<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Jurusan;
use App\Models\Task;
use App\Models\Skill;
use App\Models\Notification;
use App\Models\StudentAchievement;
use App\Models\StudentPortfolio;

class WorkhubController extends Controller
{
    /**
     * Landing Page / Welcome
     */
    public function welcome()
    {
        $projects = Project::with(['jurusans', 'lead', 'members'])->latest()->take(2)->get();
        $candidates = User::where('role', 'siswa')->with(['jurusan', 'skills'])->take(2)->get();
        $jurusans = Jurusan::all();

        return view('welcome', compact('projects', 'candidates', 'jurusans'));
    }

    /**
     * Dedicated Role Gateway Portal
     */
    public function portal()
    {
        $student = User::where('role', 'siswa')->first();
        $osis = User::where('role', 'osis')->first();

        return view('portal', compact('student', 'osis'));
    }

    /**
     * Generic Dashboard router or Siswa Dashboard
     */
    public function dashboard(Request $request)
    {
        $role = $request->query('role', 'siswa');

        if ($role === 'osis') {
            return $this->dashboardOsis();
        }

        return $this->dashboardSiswa();
    }

    /**
     * Dedicated SISWA Dashboard
     */
    public function dashboardSiswa()
    {
        // Siswa aktif (default Raka Pratama dari database)
        $student = User::where('role', 'siswa')->with(['jurusan', 'skills'])->first();
        $projects = Project::with(['jurusans', 'lead', 'members'])->latest()->get();
        $candidates = User::where('role', 'siswa')
            ->where('id', '!=', $student->id ?? 0)
            ->with(['jurusan', 'skills'])
            ->take(4)
            ->get();

        $urgentTasks = Task::with('project')
            ->where('assignee_id', $student->id ?? 0)
            ->where('status', '!=', 'done')
            ->latest()
            ->take(4)
            ->get();

        return view('dashboard', [
            'role' => 'siswa',
            'student' => $student,
            'projects' => $projects,
            'candidates' => $candidates,
            'urgentTasks' => $urgentTasks,
        ]);
    }

    /**
     * Dedicated OSIS Dashboard
     */
    public function dashboardOsis()
    {
        return redirect()->route('osis.dashboard');
    }

    /**
     * Dedicated GURU PEMBIMBING Dashboard
     */
    public function dashboardGuru()
    {
        return redirect()->route('guru.dashboard');
    }

    /**
     * Projects Catalog with real DB filter
     */
    public function projects(Request $request)
    {
        $jurusanFilter = $request->query('jurusan', 'Semua');
        $statusFilter = $request->query('status', 'Semua');
        $search = $request->query('q');

        $query = Project::with(['jurusans', 'lead', 'members']);

        if ($jurusanFilter && $jurusanFilter !== 'Semua') {
            $query->whereHas('jurusans', function ($q) use ($jurusanFilter) {
                $q->where('kode', $jurusanFilter);
            });
        }

        if ($statusFilter && $statusFilter !== 'Semua') {
            $query->where('status', $statusFilter);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $projects = $query->latest()->get();
        $jurusans = Jurusan::all();

        return view('projects.index', [
            'projects' => $projects,
            'currentJurusan' => $jurusanFilter,
            'currentStatus' => $statusFilter,
            'search' => $search ?? '',
            'jurusans' => $jurusans,
        ]);
    }

    public function createProject()
    {
        $jurusans = Jurusan::all();
        return view('projects.create', compact('jurusans'));
    }

    public function storeProject(Request $request)
    {
        $lead = User::where('role', 'siswa')->first();
        $guru = User::where('role', 'guru')->first();

        $project = Project::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'lead_id' => $lead->id ?? 1,
            'guru_id' => $guru->id ?? null,
            'target_members' => (int) $request->input('members_target', 6),
            'deadline' => $request->input('deadline', now()->addDays(30)),
            'progress' => 10,
            'status' => 'Open Recruitment',
            'category' => 'Kolaborasi Siswa',
        ]);

        if ($request->has('jurusan')) {
            $jurusanIds = Jurusan::whereIn('kode', $request->input('jurusan'))
                ->orWhereIn('id', $request->input('jurusan'))
                ->pluck('id');
            $project->jurusans()->sync($jurusanIds);
        }

        // Tambahkan lead sebagai member pertama
        if ($lead) {
            $project->members()->attach($lead->id, ['role_in_project' => 'Project Lead', 'status' => 'active']);
        }

        return redirect()->route('projects.index')->with('success', 'Proyek baru berhasil disimpan ke database dan siap menerima kolaborator!');
    }

    public function showProject($id)
    {
        $project = Project::with(['jurusans', 'lead', 'guru', 'members', 'tasks'])->findOrFail($id);
        return view('projects.show', compact('project'));
    }

    public function workspace(Request $request, $id = 1)
    {
        return redirect()->route('siswa.workspace', $id);
    }

    public function match()
    {
        $candidates = User::where('role', 'siswa')->with(['jurusan', 'skills'])->get();
        return view('match.index', compact('candidates'));
    }

    public function profile($id = null)
    {
        $student = $id ? User::find($id) : User::where('role', 'siswa')->first();
        if (!$student) {
            $student = User::first();
        }

        $student->load(['jurusan', 'skills', 'projectsLed.jurusans', 'projectsJoined.jurusans', 'achievements', 'portfolios']);

        return view('profile.show', compact('student'));
    }

    public function notifications()
    {
        $user = User::where('role', 'siswa')->first();
        $notifications = Notification::where('user_id', $user->id ?? 1)->latest()->get();

        if ($notifications->isEmpty()) {
            $notifications = Notification::latest()->get();
        }

        return view('notifications.index', compact('notifications'));
    }

    public function showcase()
    {
        $projects = Project::with(['jurusans', 'lead', 'members'])
            ->where('is_showcase', true)
            ->orWhere('status', 'Selesai')
            ->orWhere('progress', '>=', 70)
            ->latest()
            ->get();

        return view('showcase.index', compact('projects'));
    }
}
