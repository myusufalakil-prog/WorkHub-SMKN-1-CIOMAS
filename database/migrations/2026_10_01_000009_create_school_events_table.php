<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('date_text');
            $table->string('status')->default('Open Registrasi');
            $table->text('desc')->nullable();
            $table->string('lead')->nullable();
            $table->string('participants_info')->nullable();
            $table->string('category')->nullable()->default('Festival Sekolah');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_events');
    }
};
