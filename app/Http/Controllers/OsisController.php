<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Jurusan;
use App\Models\Notification;
use App\Models\SchoolEvent;

class OsisController extends Controller
{
    public function dashboard()
    {
        $totalProjects = Project::count();
        $totalStudents = User::where('role', 'siswa')->count();
        $projects = Project::with(['jurusans', 'lead', 'members'])->latest()->get();
        $pendingShowcaseProjects = Project::with(['jurusans', 'lead'])->where('is_showcase', false)->take(2)->get();
        $jurusans = Jurusan::withCount('projects')->get();

        return view('osis.dashboard', compact('totalProjects', 'totalStudents', 'projects', 'pendingShowcaseProjects', 'jurusans'));
    }

    public function events()
    {
        $events = SchoolEvent::latest()->get();
        return view('osis.events.index', compact('events'));
    }

    public function storeEvent(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date_text' => 'required|string|max:100',
        ]);

        $event = SchoolEvent::create([
            'title' => $request->title,
            'date_text' => $request->date_text,
            'status' => $request->status ?? 'Open Registrasi',
            'desc' => $request->desc ?? 'Kegiatan festival inovasi dan kompetisi kolaborasi lintas domain.',
            'lead' => $request->lead ?? 'Tim Organizer Hub',
            'participants_info' => $request->participants_info ?? 'Terbuka untuk Seluruh Talenta Komunitas',
            'category' => $request->category ?? 'Festival Inovasi',
        ]);

        // Kirim notifikasi broadcast ke talenta mengenai event baru
        $students = User::where('role', 'siswa')->get();
        foreach ($students as $stu) {
            Notification::create([
                'user_id' => $stu->id,
                'type' => 'Event Baru',
                'title' => "Agenda Komunitas: {$event->title}",
                'desc' => "Event baru dijadwalkan pada {$event->date_text}. Segera daftarkan proyek kolaborasi timmu!",
                'icon' => 'calendar',
                'status' => 'unread',
                'action_text' => 'Lihat Agenda',
                'action_url' => '/osis/events',
            ]);
        }

        return redirect()->route('osis.events')->with('success', "Event '{$event->title}' berhasil dipublikasikan dan diberitahukan ke seluruh talenta!");
    }

    public function projects()
    {
        $projects = Project::with(['jurusans', 'lead', 'guru', 'members'])->latest()->get();
        $jurusans = Jurusan::all();
        return view('osis.projects.index', compact('projects', 'jurusans'));
    }

    public function kurasi()
    {
        $pendingProjects = Project::with(['jurusans', 'lead', 'members'])->where('is_showcase', false)->get();
        $approvedProjects = Project::with(['jurusans', 'lead', 'members'])->where('is_showcase', true)->get();

        return view('osis.kurasi.index', compact('pendingProjects', 'approvedProjects'));
    }

    public function approveKurasi($id)
    {
        $project = Project::findOrFail($id);
        $project->update(['is_showcase' => true]);

        if ($project->lead_id) {
            Notification::create([
                'user_id' => $project->lead_id,
                'type' => 'Kurasi Showcase',
                'title' => "Proyek Masuk Showcase: {$project->title}",
                'desc' => "Selamat! Pengurus OSIS telah menyetujui proyek kolaborasi tim Anda untuk dipamerkan di Showcase Festival Sekolah.",
                'icon' => 'award',
                'status' => 'unread',
                'action_text' => 'Lihat Showcase',
                'action_url' => '/siswa/showcase',
            ]);
        }

        return redirect()->route('osis.kurasi')->with('success', "Proyek '{$project->title}' berhasil disetujui masuk galeri Showcase resmi Festival!");
    }

    public function jurusan()
    {
        $jurusans = Jurusan::with(['projects.members', 'students'])->withCount(['projects', 'students'])->get();
        return view('osis.jurusan.index', compact('jurusans'));
    }

    public function broadcast(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'title' => 'required|string|max:255',
            ]);

            $title = $request->input('title');
            $desc = $request->input('desc') ?? $request->input('message') ?? 'Pengumuman resmi dari tim Organizer.';

            $students = User::where('role', 'siswa')->get();
            foreach ($students as $stu) {
                Notification::create([
                    'user_id' => $stu->id,
                    'type' => 'Pengumuman Komunitas',
                    'title' => $title,
                    'desc' => $desc,
                    'icon' => 'sparkles',
                    'status' => 'unread',
                    'action_text' => 'Lihat Informasi',
                    'action_url' => '/siswa/dashboard',
                ]);
            }

            return redirect()->route('organizer.broadcast')->with('success', 'Pengumuman berhasil disiarkan ke seluruh talenta (' . $students->count() . ' penerima)!');
        }

        // Kelompokkan siaran agar 1 agenda yang dikirim ke banyak talenta hanya muncul sebagai 1 riwayat siaran
        $allBroadcasts = Notification::whereIn('type', ['Pengumuman Komunitas', 'Pengumuman OSIS'])
            ->latest()
            ->get();

        $recentBroadcasts = $allBroadcasts
            ->groupBy(function ($item) {
                return $item->title . '||' . $item->desc;
            })
            ->map(function ($group) {
                $first = $group->first();
                $first->recipient_count = $group->count();
                return $first;
            })
            ->take(5);

        return view('osis.broadcast.index', compact('recentBroadcasts'));
    }
}
