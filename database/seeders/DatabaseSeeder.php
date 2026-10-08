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
        // 1. Master Data 5 Jurusan Resmi SMKN 1 Ciomas
        $pplg = Jurusan::create([
            'kode' => 'PPLG',
            'nama_lengkap' => 'Pengembangan Perangkat Lunak dan Gim',
            'deskripsi' => 'Rekayasa perangkat lunak, web engineering, mobile application, dan game development.',
            'color_accent' => '#111111',
        ]);

        $bcf = Jurusan::create([
            'kode' => 'BCF',
            'nama_lengkap' => 'Broadcasting dan Perfilman',
            'deskripsi' => 'Produksi video, sinematografi, audio sound design, dan live streaming acara.',
            'color_accent' => '#222222',
        ]);

        $animasi = Jurusan::create([
            'kode' => 'Animasi',
            'nama_lengkap' => 'Animasi 3D & 2D',
            'deskripsi' => '3D asset modeling, rigging karakter, motion graphic, dan visual effects.',
            'color_accent' => '#181818',
        ]);

        $to = Jurusan::create([
            'kode' => 'TO',
            'nama_lengkap' => 'Teknik Otomotif',
            'deskripsi' => 'Pemeliharaan mesin kendaraan, kelistrikan otomotif, chasis, dan sistem diagnosis kendaraan modern.',
            'color_accent' => '#111111',
        ]);

        $tpfl = Jurusan::create([
            'kode' => 'TPFL',
            'nama_lengkap' => 'Teknik Pengelasan dan Fabrikasi Logam',
            'deskripsi' => 'Pengelasan SMAW/GMAW/GTAW, perancangan konstruksi plat logam, dan fabrikasi mekanik presisi.',
            'color_accent' => '#181818',
        ]);

        // 2. Master Data Referensi Skills Sesuai 5 Jurusan SMKN 1 Ciomas
        Skill::create(['name' => 'Frontend Web & UI', 'category' => 'Code']);
        Skill::create(['name' => 'Backend & Database', 'category' => 'Code']);
        Skill::create(['name' => 'Game Development', 'category' => 'Code']);
        Skill::create(['name' => 'Sinematografi & Kamera', 'category' => 'Media']);
        Skill::create(['name' => 'Video Editing & Audio', 'category' => 'Media']);
        Skill::create(['name' => '3D Blender & Rigging', 'category' => 'Design']);
        Skill::create(['name' => '2D Motion & Animasi', 'category' => 'Design']);
        Skill::create(['name' => 'Diagnosis Mesin Otomotif', 'category' => 'Teknik']);
        Skill::create(['name' => 'Kelistrikan & EFI Otomotif', 'category' => 'Teknik']);
        Skill::create(['name' => 'Pengelasan SMAW / GMAW', 'category' => 'Manufaktur']);
        Skill::create(['name' => 'Fabrikasi Logam & Desain CAD', 'category' => 'Manufaktur']);

        // 3. Akun Super Admin (Akses Penuh Siswa & OSIS)
        User::create([
            'name' => 'Super Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'kelas' => 'Staff IT',
            'jurusan_id' => $pplg->id,
            'jabatan' => 'Administrator Sistem',
            'bio' => 'Akun administrator dengan hak akses penuh ke portal Siswa dan OSIS.',
            'phone' => '081122334455',
        ]);

        // 4. Akun Pengurus OSIS SMKN 1 Ciomas
        User::create([
            'name' => 'Pengurus OSIS',
            'email' => 'osis@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'osis',
            'kelas' => 'XI PPLG 2',
            'jurusan_id' => $pplg->id,
            'jabatan' => 'Divisi IT & Acara OSIS',
            'bio' => 'Pengurus OSIS SMK. Mengoordinasikan event festival tahunan dan kurasi showcase proyek kolaborasi lintas jurusan.',
            'phone' => '081298765432',
        ]);

        // 5. Akun Siswa Teladan / Kolaborator
        $siswa = User::create([
            'name' => 'Raka Pratama',
            'email' => 'raka@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'kelas' => 'XII PPLG 1',
            'jurusan_id' => $pplg->id,
            'jabatan' => 'Fullstack Developer',
            'bio' => 'Siswa PPLG antusias berkolaborasi membangun aplikasi nyata dengan teman lintas jurusan Animasi, BCF, TO, dan TPFL.',
            'phone' => '081234567890',
        ]);
        $siswa->skills()->attach([1, 2]);
    }
}
