<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Jurusan;
use App\Models\Task;
use App\Models\Skill;
use App\Models\Notification;
use App\Models\ProjectFile;
use App\Models\ProjectActivity;
use App\Models\ProjectMessage;
use App\Models\StudentPortfolio;
use App\Models\SchoolEvent;

class SiswaController extends Controller
{
    protected function getActiveStudent()
    {
        if (auth()->check()) {
            return auth()->user();
        }
        return User::where('role', 'siswa')->with(['jurusan', 'skills'])->first() ?? User::first();
    }

    public function dashboard()
    {
        $student = $this->getActiveStudent();

        // Hanya proyek yang dipimpin atau di mana siswa resmi diterima sebagai anggota aktif
        $myProjects = Project::where('lead_id', $student->id ?? 0)
            ->orWhereHas('members', function ($q) use ($student) {
                $q->where('users.id', $student->id ?? 0)->where('project_members.status', 'active');
            })
            ->with(['jurusans', 'lead', 'members'])
            ->latest()
            ->get();

        // Proyek lain di sekolah untuk opsi eksplorasi bergabung
        $exploreProjects = Project::where('lead_id', '!=', $student->id ?? 0)
            ->whereDoesntHave('members', function ($q) use ($student) {
                $q->where('users.id', $student->id ?? 0);
            })
            ->with(['jurusans', 'lead', 'members'])
            ->latest()
            ->take(4)
            ->get();

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

        $announcements = Notification::where('type', 'Pengumuman OSIS')
            ->latest()
            ->take(2)
            ->get();

        $upcomingEvents = SchoolEvent::latest()
            ->take(2)
            ->get();

        return view('siswa.dashboard', [
            'student' => $student,
            'projects' => $myProjects,
            'exploreProjects' => $exploreProjects,
            'candidates' => $candidates,
            'urgentTasks' => $urgentTasks,
            'announcements' => $announcements,
            'upcomingEvents' => $upcomingEvents,
        ]);
    }

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

        return view('siswa.projects.index', compact('projects', 'jurusanFilter', 'statusFilter', 'search', 'jurusans'));
    }

    public function createProject()
    {
        $jurusans = Jurusan::all();
        return view('siswa.projects.create', compact('jurusans'));
    }

    public function storeProject(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'jurusan' => 'required|array|min:1',
            'members_target' => 'nullable|integer|min:2|max:30',
            'deadline' => 'nullable|date',
        ]);

        $lead = $this->getActiveStudent();

        $project = Project::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'lead_id' => $lead->id ?? 1,
            'guru_id' => null,
            'target_members' => (int) $request->input('members_target', 6),
            'deadline' => $request->input('deadline', now()->addDays(30)),
            'progress' => 0,
            'status' => 'Open Recruitment',
            'category' => 'Kolaborasi Siswa',
        ]);

        if ($request->has('jurusan')) {
            $jurusanIds = Jurusan::whereIn('kode', $request->input('jurusan'))
                ->orWhereIn('id', $request->input('jurusan'))
                ->pluck('id');
            $project->jurusans()->sync($jurusanIds);
        }

        if ($lead) {
            $project->members()->attach($lead->id, ['role_in_project' => 'Project Lead', 'status' => 'active']);
        }

        ProjectActivity::create([
            'project_id' => $project->id,
            'user_id' => $lead->id ?? 1,
            'action' => 'menginisiasi proyek baru',
            'target' => $project->title,
        ]);

        return redirect()->route('siswa.proyek.index')->with('success', 'Proyek baru berhasil disimpan dan siap menerima kolaborator!');
    }

    public function applyJoinProject(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $user = $this->getActiveStudent();

        // Pembuat proyek tidak bisa melamar ke proyeknya sendiri
        if ($project->lead_id === $user->id) {
            return back()->with('error', 'Anda adalah ketua/pembuat proyek ini.');
        }

        $existingMember = $project->members()->where('user_id', $user->id)->first();
        if ($existingMember) {
            if ($existingMember->pivot->status === 'active') {
                return back()->with('info', 'Anda sudah resmi menjadi anggota aktif dalam proyek ini.');
            }
            return back()->with('info', 'Pengajuan Anda masih dalam status Menunggu Persetujuan dari ketua tim.');
        }

        $roleRequested = $request->input('role_in_project', 'Anggota Kolaborasi');
        $message = $request->input('join_message', 'Saya tertarik untuk berkolaborasi dalam proyek ini.');

        // Simpan sebagai PENDING (harus disetujui oleh ketua tim)
        $project->members()->attach($user->id, [
            'role_in_project' => $roleRequested,
            'status' => 'pending',
        ]);

        ProjectActivity::create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'action' => 'mengajukan diri bergabung sebagai',
            'target' => $roleRequested,
        ]);

        if ($project->lead_id) {
            Notification::create([
                'user_id' => $project->lead_id,
                'type' => 'Pengajuan Kolaborasi',
                'title' => "Pengajuan Kolaborator Baru: {$project->title}",
                'desc' => "{$user->name} ({$user->jurusan?->kode}) mengajukan posisi {$roleRequested}. Silakan buka tab Anggota untuk menyetujui atau menolak.",
                'icon' => 'user-plus',
                'status' => 'unread',
                'action_text' => 'Tinjau Pengajuan',
                'action_url' => "/siswa/workspace/{$project->id}?tab=anggota",
            ]);
        }

        return redirect()->route('siswa.proyek.index')
            ->with('success', "Pengajuan kolaborasi berhasil dikirim! Mohon tunggu konfirmasi persetujuan dari ketua proyek '{$project->title}'.");
    }

    public function approveMember(Request $request, $id, $userId)
    {
        $project = Project::findOrFail($id);
        $currentUser = $this->getActiveStudent();

        if ($project->lead_id !== $currentUser->id && !$currentUser->isAdmin()) {
            return back()->with('error', 'Hanya ketua pembuat proyek yang berhak menyetujui anggota baru.');
        }

        $candidate = User::findOrFail($userId);
        $project->members()->updateExistingPivot($userId, ['status' => 'active']);

        ProjectActivity::create([
            'project_id' => $project->id,
            'user_id' => $currentUser->id,
            'action' => 'menerima anggota baru',
            'target' => "{$candidate->name} ({$candidate->jurusan?->kode})",
        ]);

        Notification::create([
            'user_id' => $candidate->id,
            'type' => 'Pengajuan Diterima',
            'title' => "Selamat! Anda Diterima di: {$project->title}",
            'desc' => "Ketua tim telah menyetujui pengajuan kolaborasi Anda. Sekarang Anda dapat berkolaborasi di Workspace proyek ini.",
            'icon' => 'check-circle',
            'status' => 'unread',
            'action_text' => 'Buka Workspace',
            'action_url' => "/siswa/workspace/{$project->id}?tab=ringkasan",
        ]);

        return back()->with('success', "Anggota {$candidate->name} resmi diterima dan bergabung ke tim!");
    }

    public function rejectMember(Request $request, $id, $userId)
    {
        $project = Project::findOrFail($id);
        $currentUser = $this->getActiveStudent();

        if ($project->lead_id !== $currentUser->id && !$currentUser->isAdmin()) {
            return back()->with('error', 'Hanya ketua pembuat proyek yang berhak mengelola pengajuan anggota.');
        }

        $candidate = User::findOrFail($userId);
        $project->members()->detach($userId);

        Notification::create([
            'user_id' => $candidate->id,
            'type' => 'Pengajuan Ditolak',
            'title' => "Pengajuan Kolaborasi: {$project->title}",
            'desc' => "Mohon maaf, pengajuan Anda untuk proyek ini belum dapat diterima. Silakan cari dan ajukan proyek kolaborasi lainnya!",
            'icon' => 'x-circle',
            'status' => 'unread',
            'action_text' => 'Jelajahi Proyek',
            'action_url' => '/siswa/proyek',
        ]);

        return back()->with('info', "Pengajuan dari {$candidate->name} telah ditolak.");
    }

    public function workspace(Request $request, $id = null)
    {
        $activeTab = $request->query('tab', 'ringkasan');
        $currentUser = $this->getActiveStudent();

        $query = Project::with([
            'jurusans', 
            'lead', 
            'guru', 
            'members.jurusan', 
            'tasks.assignee', 
            'files.uploader', 
            'activities.user', 
            'messages.user.jurusan'
        ]);

        if ($id) {
            $project = $query->find($id);
        } else {
            // Jika ID tidak diberikan (klik menu Workspace di sidebar),
            // cari proyek yang DIPIMPIN atau di mana user adalah ANGGOTA AKTIF
            $project = $query->where(function ($q) use ($currentUser) {
                $q->where('lead_id', $currentUser->id ?? 0)
                  ->orWhereHas('members', function ($m) use ($currentUser) {
                      $m->where('users.id', $currentUser->id ?? 0)
                        ->where('project_members.status', 'active');
                  });
            })->latest()->first();

            // Jika user adalah admin, boleh melihat proyek pertama jika ada
            if (!$project && ($currentUser?->role === 'admin')) {
                $project = $query->first();
            }
        }

        // Ambil semua proyek yang diikuti siswa (sebagai lead atau anggota aktif) untuk Workspace Switcher
        $myProjects = Project::where(function ($q) use ($currentUser) {
            $q->where('lead_id', $currentUser->id ?? 0)
              ->orWhereHas('members', function ($m) use ($currentUser) {
                  $m->where('users.id', $currentUser->id ?? 0)
                    ->where('project_members.status', 'active');
              });
        })->with(['jurusans', 'lead'])->latest()->get();

        if ($myProjects->isEmpty() && ($currentUser?->role === 'admin')) {
            $myProjects = Project::with(['jurusans', 'lead'])->latest()->get();
        }

        if (!$project) {
            return view('siswa.workspace.show', [
                'project' => null,
                'activeTab' => $activeTab,
                'allStudents' => collect(),
                'myProjects' => $myProjects,
            ]);
        }

        $allStudents = User::where('role', 'siswa')->get();

        return view('siswa.workspace.show', compact('project', 'activeTab', 'allStudents', 'myProjects'));
    }

    public function storeTask(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $project = Project::findOrFail($id);
        $user = $this->getActiveStudent();

        $isLead = ($project->lead_id === $user->id);
        $isActive = $project->activeMembers()->where('users.id', $user->id)->exists();
        if (!$isLead && !$isActive && !$user->isAdmin()) {
            return back()->with('error', 'Hanya anggota resmi atau ketua tim yang dapat menambahkan tugas.');
        }

        $task = Task::create([
            'project_id' => $project->id,
            'title' => $request->title,
            'description' => $request->description ?? 'Deskripsi tugas kolaborasi.',
            'assignee_id' => $request->assignee_id ?? $user->id,
            'priority' => $request->priority ?? 'Normal',
            'status' => 'todo',
            'due_text' => $request->due_text ?? '7 Hari',
            'due_date' => $request->due_date ? date('Y-m-d', strtotime($request->due_date)) : now()->addDays(7),
            'verified_by_guru' => false,
        ]);

        ProjectActivity::create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'action' => 'menambahkan tugas baru',
            'target' => $task->title,
        ]);

        $this->syncProjectProgress($project);

        return redirect()->route('siswa.workspace', ['id' => $project->id, 'tab' => 'tugas'])
            ->with('success', "Tugas '{$task->title}' berhasil ditambahkan ke tim!");
    }

    public function updateTaskStatus(Request $request, $id, $taskId)
    {
        $project = Project::findOrFail($id);
        $user = $this->getActiveStudent();

        $isLead = ($project->lead_id === $user->id);
        $isActive = $project->activeMembers()->where('users.id', $user->id)->exists();
        if (!$isLead && !$isActive && !$user->isAdmin()) {
            return back()->with('error', 'Hanya anggota resmi atau ketua tim yang dapat mengubah status tugas.');
        }

        $task = Task::where('project_id', $project->id)->findOrFail($taskId);

        $newStatus = $request->input('status');
        if (!$newStatus) {
            $newStatus = ($task->status === 'done') ? 'todo' : 'done';
        }

        $task->update(['status' => $newStatus]);

        ProjectActivity::create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'action' => ($newStatus === 'done') ? 'menyelesaikan tugas' : 'memperbarui status tugas',
            'target' => $task->title,
        ]);

        $this->syncProjectProgress($project);

        return redirect()->route('siswa.workspace', ['id' => $project->id, 'tab' => 'tugas'])
            ->with('success', "Status tugas '{$task->title}' diperbarui menjadi {$newStatus}!");
    }

    protected function syncProjectProgress(Project $project)
    {
        $total = $project->tasks()->count();
        if ($total > 0) {
            $done = $project->tasks()->where('status', 'done')->count();
            $percentage = min(100, (int) round(($done / $total) * 100));
            $newStatus = ($percentage === 100) ? 'Selesai' : 'Sedang Berjalan';
            $project->update([
                'progress' => $percentage,
                'status' => $newStatus,
            ]);
        } else {
            $project->update([
                'progress' => 0,
                'status' => 'Open Recruitment',
            ]);
        }
    }

    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $project = Project::findOrFail($id);
        $user = $this->getActiveStudent();

        $isLead = ($project->lead_id === $user->id);
        $isActive = $project->activeMembers()->where('users.id', $user->id)->exists();
        if (!$isLead && !$isActive && !$user->isAdmin()) {
            return back()->with('error', 'Hanya anggota resmi atau ketua tim yang dapat mengirim pesan dalam diskusi tim.');
        }

        ProjectMessage::create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'message' => $request->message,
            'attachment' => $request->attachment ?? null,
        ]);

        return redirect()->route('siswa.workspace', ['id' => $project->id, 'tab' => 'chat'])
            ->with('success', 'Pesan berhasil dikirim ke ruang kolaborasi tim!');
    }

    public function storeFile(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $project = Project::findOrFail($id);
        $user = $this->getActiveStudent();

        $isLead = ($project->lead_id === $user->id);
        $isActive = $project->activeMembers()->where('users.id', $user->id)->exists();
        if (!$isLead && !$isActive && !$user->isAdmin()) {
            return back()->with('error', 'Hanya anggota resmi atau ketua tim yang dapat mengunggah berkas.');
        }

        $file = ProjectFile::create([
            'project_id' => $project->id,
            'uploader_id' => $user->id,
            'name' => $request->name,
            'file_path' => $request->file_path ?? '#',
            'size' => $request->size ?? '2.4 MB',
            'type' => $request->type ?? 'Dokumen / Aset',
        ]);

        ProjectActivity::create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'action' => 'mengunggah berkas aset',
            'target' => $file->name,
        ]);

        return redirect()->route('siswa.workspace', ['id' => $project->id, 'tab' => 'file'])
            ->with('success', "Berkas aset '{$file->name}' berhasil ditambahkan ke proyek!");
    }

    public function match(Request $request)
    {
        $kategori = $request->query('kategori', 'Semua');
        $query = User::where('role', 'siswa')->with(['jurusan', 'skills']);

        if ($kategori && $kategori !== 'Semua') {
            $query->whereHas('skills', function ($q) use ($kategori) {
                $q->where('name', 'like', "%{$kategori}%")
                  ->orWhere('category', 'like', "%{$kategori}%");
            });
        }

        $candidates = $query->get();
        return view('siswa.match.index', compact('candidates', 'kategori'));
    }

    public function markAllNotificationsRead()
    {
        $student = $this->getActiveStudent();
        Notification::where('user_id', $student->id ?? 1)->update(['status' => 'read']);

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai sudah dibaca!');
    }

    public function profile($id = null)
    {
        $student = null;
        if ($id && is_numeric($id)) {
            $student = User::find($id);
        }

        if (!$student) {
            $student = $this->getActiveStudent();
        }

        if (!$student) {
            abort(404, 'Profil pengguna tidak ditemukan.');
        }

        $student->load(['jurusan', 'skills', 'projectsLed.jurusans', 'projectsJoined.jurusans', 'achievements', 'portfolios']);

        $availableSkills = Skill::all();
        $jurusans = Jurusan::all();

        return view('siswa.profile.show', compact('student', 'availableSkills', 'jurusans'));
    }

    public function updateProfile(Request $request)
    {
        $user = $this->getActiveStudent();

        $user->update([
            'bio' => $request->input('bio', $user->bio),
            'kelas' => $request->input('kelas', $user->kelas),
            'jabatan' => $request->input('jabatan', $user->jabatan),
        ]);

        return redirect()->back()->with('success', 'Biodata profil siswa berhasil diperbarui!');
    }

    public function storePortfolio(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
        ]);

        $user = $this->getActiveStudent();

        StudentPortfolio::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'category' => $request->category ?? 'Karya Digital Siswa',
            'year' => $request->year ?? '2026',
            'desc' => $request->desc,
            'verified_by_guru_id' => null,
        ]);

        return redirect()->back()->with('success', "Portofolio '{$request->title}' berhasil disimpan dan diajukan ke guru pembimbing!");
    }

    public function storeSkill(Request $request)
    {
        $request->validate([
            'skill_name' => 'required|string|max:100',
        ]);

        $user = $this->getActiveStudent();
        $skill = Skill::firstOrCreate([
            'name' => trim($request->skill_name),
        ], [
            'category' => $request->category ?? 'Teknis',
        ]);

        if ($user && !$user->skills()->where('skills.id', $skill->id)->exists()) {
            $user->skills()->attach($skill->id, [
                'level' => $request->input('level', 'Menengah'),
                'is_verified' => false,
            ]);
        }

        return redirect()->back()->with('success', "Skill '{$skill->name}' berhasil ditambahkan ke profil Anda!");
    }

    public function notifications()
    {
        $student = $this->getActiveStudent();
        $notifications = Notification::where('user_id', $student->id ?? 1)->latest()->get();

        if ($notifications->isEmpty()) {
            $notifications = Notification::latest()->get();
        }

        return view('siswa.notifications.index', compact('notifications'));
    }

    public function showcase()
    {
        $projects = Project::with(['jurusans', 'lead', 'members'])
            ->where('is_showcase', true)
            ->orWhere('status', 'Selesai')
            ->orWhere('progress', '>=', 70)
            ->latest()
            ->get();

        return view('siswa.showcase.index', compact('projects'));
    }
}
