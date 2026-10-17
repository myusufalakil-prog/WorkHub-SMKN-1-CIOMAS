<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Skill;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Master Data 12 Domain Keahlian Multidisiplin Universal
        $domains = [
            ['kode' => 'TECH', 'nama_lengkap' => 'Software Engineering & Web Development', 'deskripsi' => 'Pengembangan web, mobile app, backend APIs, dan arsitektur sistem komputasi modern.', 'color_accent' => '#2563EB'],
            ['kode' => 'MEDIA', 'nama_lengkap' => 'Creative Media, Film & Broadcasting', 'deskripsi' => 'Produksi video sinematik, editing, motion graphics, audio visual sound design, podcast & studio broadcasting.', 'color_accent' => '#9333EA'],
            ['kode' => 'DESIGN', 'nama_lengkap' => 'UI/UX & Digital Product Design', 'deskripsi' => 'Desain interaksi antarmuka pengguna, user research, wireframing, prototyping Figma, dan design system visual.', 'color_accent' => '#F59E0B'],
            ['kode' => 'ENG', 'nama_lengkap' => 'Robotics, Mechatronics & IoT Hardware', 'deskripsi' => 'Rekayasa perangkat keras, mikrokontroler (Arduino/ESP32), otomasi industri, dan integrasi robotika modern.', 'color_accent' => '#E11D48'],
            ['kode' => 'BIZ', 'nama_lengkap' => 'Digital Business & Product Strategy', 'deskripsi' => 'Manajemen produk, strategi pemasaran digital, riset pasar, sales funnel, dan inkubasi startup digital.', 'color_accent' => '#0891B2'],
            ['kode' => 'AI-DATA', 'nama_lengkap' => 'Data Science & Artificial Intelligence', 'deskripsi' => 'Machine learning, computer vision, data analytics, predictive modeling, serta integrasi LLM & AI agent.', 'color_accent' => '#4F46E5'],
            ['kode' => 'CYBER', 'nama_lengkap' => 'Cloud Infrastructure & Cyber Security', 'deskripsi' => 'Keamanan jaringan informasi, ethical hacking, DevSecOps, arsitektur cloud server (AWS/GCP), dan sysadmin.', 'color_accent' => '#0F172A'],
            ['kode' => '3D-GAME', 'nama_lengkap' => '3D Art, Animation & Game Development', 'deskripsi' => 'Asset modeling 3D Blender/Maya, rigging, animasi karakter, dan game engine Unity/Unreal Engine.', 'color_accent' => '#7C3AED'],
            ['kode' => 'FIN', 'nama_lengkap' => 'Fintech, Accounting & Financial Analysis', 'deskripsi' => 'Analisis kelayakan finansial proyek, budgeting, pembukuan digital, payment gateway, dan fintech logic.', 'color_accent' => '#059669'],
            ['kode' => 'HEALTH', 'nama_lengkap' => 'Health Informatics & Biotechnology', 'deskripsi' => 'Solusi teknologi medis, sistem rekam medis digital, bioinformatika, dan teknologi kesehatan preventif.', 'color_accent' => '#0D9488'],
            ['kode' => 'ENV', 'nama_lengkap' => 'Environmental Science & Green Tech', 'deskripsi' => 'Energi terbarukan, pemantauan kualitas lingkungan berbasis sensor IoT, dan inovasi keberlanjutan bumi.', 'color_accent' => '#16A34A'],
            ['kode' => 'COMM', 'nama_lengkap' => 'Digital Communication, Law & Public Policy', 'deskripsi' => 'Hukum siber & privasi data, jurnalisme digital, komunikasi publik, copy engineering, dan advokasi sosial.', 'color_accent' => '#0284C7'],
        ];

        foreach ($domains as $d) {
            Jurusan::updateOrCreate(['kode' => $d['kode']], $d);
        }

        $tech = Jurusan::where('kode', 'TECH')->first();
        $biz = Jurusan::where('kode', 'BIZ')->first();

        // 2. Master Data Referensi Skills Multidisiplin
        Skill::create(['name' => 'Frontend & Web App', 'category' => 'Technology']);
        Skill::create(['name' => 'Backend & API Architecture', 'category' => 'Technology']);
        Skill::create(['name' => 'Machine Learning & AI', 'category' => 'Technology']);
        Skill::create(['name' => 'Mobile App (Flutter/React Native)', 'category' => 'Technology']);
        Skill::create(['name' => 'Video Editing & Motion Graphics', 'category' => 'Media']);
        Skill::create(['name' => 'Audio Production & Sound Design', 'category' => 'Media']);
        Skill::create(['name' => 'UI/UX & Product Design', 'category' => 'Design']);
        Skill::create(['name' => '3D Blender & Asset Modeling', 'category' => 'Design']);
        Skill::create(['name' => 'IoT & Microcontroller Firmware', 'category' => 'Engineering']);
        Skill::create(['name' => 'Hardware Prototyping', 'category' => 'Engineering']);
        Skill::create(['name' => 'Product Management & Scrum', 'category' => 'Business']);
        Skill::create(['name' => 'Growth & Digital Marketing', 'category' => 'Business']);

        // 3. Akun Super Admin WORKHUB
        User::create([
            'name' => 'WORKHUB Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'institution' => 'WORKHUB Core Team',
            'headline' => 'Platform Administrator & Tech Lead',
            'kelas' => 'Tech Core',
            'jurusan_id' => $tech->id,
            'jabatan' => 'Administrator Sistem',
            'bio' => 'Akun administrator dengan hak akses penuh ke seluruh portal dan ekosistem kolaborasi WORKHUB.',
            'phone' => '081122334455',
        ]);

        // 4. Akun Community & Event Organizer
        User::create([
            'name' => 'Community Organizer',
            'email' => 'osis@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'osis',
            'institution' => 'Open Innovation Community',
            'headline' => 'Challenge Curator & Event Coordinator',
            'kelas' => 'Community Lead',
            'jurusan_id' => $biz->id,
            'jabatan' => 'Koordinator Event & Kurator Showcase',
            'bio' => 'Mengoordinasikan hackathon, challenge kolaborasi terbuka, dan kurasi showcase proyek unggulan.',
            'phone' => '081298765432',
        ]);

        // 5. Akun Kolaborator / Talenta Utama
        $kreator = User::create([
            'name' => 'Raka Pratama',
            'email' => 'raka@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'institution' => 'Talenta Terbuka / Tech Enthusiast',
            'headline' => 'Fullstack Developer & AI Prototyper',
            'kelas' => 'Developer',
            'jurusan_id' => $tech->id,
            'jabatan' => 'Fullstack Developer',
            'bio' => 'Antusias berkolaborasi membangun produk inovatif nyata bersama desainer, audio-video creator, dan engineer perangkat keras.',
            'phone' => '081234567890',
        ]);
        $kreator->skills()->attach([1, 2, 7]);
    }
}
