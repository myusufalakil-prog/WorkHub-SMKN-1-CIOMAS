<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('lead_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('guru_id')->nullable()->constrained('users')->nullOnDelete(); // Guru pembimbing
            $table->integer('target_members')->default(5);
            $table->date('deadline')->nullable();
            $table->integer('progress')->default(0); // 0 - 100
            $table->string('status', 30)->default('Sedang Berjalan'); // 'Open Recruitment', 'Sedang Berjalan', 'Selesai', 'Butuh Review'
            $table->string('category', 50)->default('Umum');
            $table->boolean('is_showcase')->default(false); // diverifikasi untuk showcase
            $table->text('notes_guru')->nullable(); // catatan/feedback bimbingan guru
            $table->timestamps();
        });

        // Pivot: Jurusan yang dibutuhkan dalam proyek
        Schema::create('project_jurusans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('jurusan_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        // Pivot: Anggota tim kolaborasi
        Schema::create('project_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('role_in_project', 50)->default('Member'); // 'Lead', 'UI Designer', 'Backend Dev', '3D Artist', dll
            $table->string('status', 20)->default('active'); // 'active', 'pending'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_members');
        Schema::dropIfExists('project_jurusans');
        Schema::dropIfExists('projects');
    }
};
