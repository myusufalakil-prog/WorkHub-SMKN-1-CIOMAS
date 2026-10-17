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
        $this->ensureUniversalDomains();

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
        $this->ensureUniversalDomains();

        $student = User::where('role', 'siswa')->first();
        $osis = User::where('role', 'osis')->first();
        $jurusans = Jurusan::all();

        return view('portal', compact('student', 'osis', 'jurusans'));
    }

    /**
     * Auto-migrate and synchronize 12 universal domains to database
     */
    private function ensureUniversalDomains(): void
    {
        try {
            $legacyMap = [
                'PPLG' => 'TECH',
                'BCF' => 'MEDIA',
                'Animasi' => 'DESIGN',
                'TO' => 'ENG',
                'TPFL' => 'BIZ',
            ];

            // 1. Ensure all 12 universal domains exist
            $defaultDomains = [
                ['kode' => 'TECH', 'nama_lengkap' => 'Software Engineering & Web Development', 'deskripsi' => 'Pengembangan web, mobile app, backend APIs, dan arsitektur sistem komputasi modern.', 'color_accent' => '#2563EB'],
                ['kode' => 'MEDIA', 'nama_lengkap' => 'Creative Media, Film & Broadcasting', 'deskripsi' => 'Produksi video sinematik, editing, motion graphics, audio visual sound design, podcast & broadcasting.', 'color_accent' => '#9333EA'],
                ['kode' => 'DESIGN', 'nama_lengkap' => 'UI/UX & Digital Product Design', 'deskripsi' => 'Desain interaksi antarmuka pengguna, user research, wireframing, prototyping Figma, dan visual design system.', 'color_accent' => '#F59E0B'],
                ['kode' => 'ENG', 'nama_lengkap' => 'Robotics, Mechatronics & IoT Hardware', 'deskripsi' => 'Rekayasa perangkat keras, mikrokontroler, otomasi industri, dan integrasi robotika modern.', 'color_accent' => '#E11D48'],
                ['kode' => 'BIZ', 'nama_lengkap' => 'Digital Business & Product Strategy', 'deskripsi' => 'Manajemen produk, strategi pemasaran digital, riset pasar, sales funnel, dan inkubasi startup digital.', 'color_accent' => '#0891B2'],
                ['kode' => 'AI-DATA', 'nama_lengkap' => 'Data Science & Artificial Intelligence', 'deskripsi' => 'Machine learning, computer vision, data analytics, predictive modeling, serta integrasi LLM & AI agent.', 'color_accent' => '#4F46E5'],
                ['kode' => 'CYBER', 'nama_lengkap' => 'Cloud Infrastructure & Cyber Security', 'deskripsi' => 'Keamanan jaringan informasi, ethical hacking, DevSecOps, arsitektur cloud server (AWS/GCP), dan sysadmin.', 'color_accent' => '#0F172A'],
                ['kode' => '3D-GAME', 'nama_lengkap' => '3D Art, Animation & Game Development', 'deskripsi' => 'Asset modeling 3D Blender/Maya, rigging, animasi karakter, dan game engine Unity/Unreal Engine.', 'color_accent' => '#7C3AED'],
                ['kode' => 'FIN', 'nama_lengkap' => 'Fintech, Accounting & Financial Analysis', 'deskripsi' => 'Analisis kelayakan finansial proyek, budgeting, pembukuan digital, payment gateway, dan fintech logic.', 'color_accent' => '#059669'],
                ['kode' => 'HEALTH', 'nama_lengkap' => 'Health Informatics & Biotechnology', 'deskripsi' => 'Solusi teknologi medis, sistem rekam medis digital, bioinformatika, dan teknologi kesehatan preventif.', 'color_accent' => '#0D9488'],
                ['kode' => 'ENV', 'nama_lengkap' => 'Environmental Science & Green Tech', 'deskripsi' => 'Energi terbarukan, pemantauan kualitas lingkungan berbasis sensor IoT, dan inovasi keberlanjutan bumi.', 'color_accent' => '#16A34A'],
                ['kode' => 'COMM', 'nama_lengkap' => 'Digital Communication, Law & Public Policy', 'deskripsi' => 'Hukum siber & privasi data, jurnalisme digital, komunikasi publik, copy engineering, dan advokasi sosial.', 'color_accent' => '#0284C7'],
            ];

            foreach ($defaultDomains as $d) {
                Jurusan::firstOrCreate(['kode' => $d['kode']], $d);
            }

            // 2. Re-link foreign keys from legacy 5 majors to new universal domains, then delete legacy rows
            foreach ($legacyMap as $oldKode => $targetKode) {
                $old = Jurusan::where('kode', $oldKode)->first();
                $target = Jurusan::where('kode', $targetKode)->first();

                if ($old && $target) {
                    User::where('jurusan_id', $old->id)->update(['jurusan_id' => $target->id]);
                    try {
                        \DB::table('project_jurusans')->where('jurusan_id', $old->id)->update(['jurusan_id' => $target->id]);
                    } catch (\Throwable $ignored) {}
                    $old->delete();
                }
            }

            // 3. Purge any remaining unwanted legacy majors so only the 12 domains remain
            Jurusan::whereIn('kode', ['PPLG', 'BCF', 'Animasi', 'TO', 'TPFL'])->delete();
        } catch (\Throwable $e) {
            // Graceful fallback
        }
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
            $rawJurusan = (array) $request->input('jurusan', []);
            $numericIds = [];
            $stringCodes = [];

            foreach ($rawJurusan as $item) {
                if (is_numeric($item)) {
                    $numericIds[] = (int) $item;
                } elseif (is_string($item)) {
                    $clean = trim(explode(' ', trim($item))[0]);
                    if ($clean !== '') {
                        $stringCodes[] = $clean;
                    }
                }
            }

            $query = Jurusan::query();
            if (!empty($stringCodes) && !empty($numericIds)) {
                $query->where(function ($q) use ($stringCodes, $numericIds) {
                    $q->whereIn('kode', $stringCodes)
                      ->orWhereIn('id', $numericIds);
                });
            } elseif (!empty($stringCodes)) {
                $query->whereIn('kode', $stringCodes);
            } elseif (!empty($numericIds)) {
                $query->whereIn('id', $numericIds);
            } else {
                $query->whereRaw('1 = 0');
            }

            $jurusanIds = $query->pluck('id');
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
