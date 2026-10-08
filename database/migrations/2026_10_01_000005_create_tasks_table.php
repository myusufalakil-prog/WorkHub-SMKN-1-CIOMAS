<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('assignee_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('priority', 20)->default('Sedang'); // 'Rendah', 'Sedang', 'Tinggi'
            $table->string('status', 20)->default('todo'); // 'todo', 'in_progress', 'done'
            $table->string('due_text', 50)->nullable(); // e.g. "Besok", "3 Hari"
            $table->date('due_date')->nullable();
            $table->boolean('verified_by_guru')->default(false); // Validasi capaian oleh guru
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
