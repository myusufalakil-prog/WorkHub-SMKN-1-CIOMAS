<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type', 50); // Undangan Project, Permintaan bergabung, Anggota baru, Tugas baru, Pesan baru, etc.
            $table->string('title');
            $table->text('desc');
            $table->string('icon', 30)->default('bell');
            $table->string('status', 20)->default('unread'); // unread, read
            $table->string('action_text')->nullable(); // e.g. "Terima Undangan", "Buka Workspace"
            $table->string('action_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
