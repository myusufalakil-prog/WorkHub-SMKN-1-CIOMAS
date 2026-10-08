<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Files / Dokumen & Aset
        Schema::create('project_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('uploader_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('file_path')->nullable();
            $table->string('size', 30)->default('1.0 MB');
            $table->string('type', 30)->default('Document'); // Figma, 3D Asset, Video, Document, etc.
            $table->timestamps();
        });

        // Activity Logs
        Schema::create('project_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('action'); // 'menyelesaikan tugas', 'mengunggah file baru', dll
            $table->string('target'); // 'Prototipe Figma', dll
            $table->timestamps();
        });

        // Messages / Chat Tim Realtime
        Schema::create('project_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('message');
            $table->string('attachment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_messages');
        Schema::dropIfExists('project_activities');
        Schema::dropIfExists('project_files');
    }
};
