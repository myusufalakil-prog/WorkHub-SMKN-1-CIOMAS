<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Jurusan;

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
}
