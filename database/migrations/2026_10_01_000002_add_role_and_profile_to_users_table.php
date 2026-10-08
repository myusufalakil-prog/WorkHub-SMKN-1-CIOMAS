<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('siswa')->after('password'); // 'siswa', 'osis', 'guru'
            $table->string('nisn_nip', 30)->nullable()->after('role');
            $table->string('kelas', 30)->nullable()->after('nisn_nip'); // e.g. XI PPLG 1 (untuk siswa/osis)
            $table->foreignId('jurusan_id')->nullable()->after('kelas')->constrained('jurusans')->nullOnDelete();
            $table->string('jabatan', 100)->nullable()->after('jurusan_id'); // e.g. "Ketua Divisi IT OSIS", "Guru Produktif PPLG"
            $table->text('bio')->nullable()->after('jabatan');
            $table->string('avatar')->nullable()->after('bio');
            $table->string('phone', 25)->nullable()->after('avatar');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['jurusan_id']);
            $table->dropColumn(['role', 'nisn_nip', 'kelas', 'jurusan_id', 'jabatan', 'bio', 'avatar', 'phone']);
        });
    }
};
