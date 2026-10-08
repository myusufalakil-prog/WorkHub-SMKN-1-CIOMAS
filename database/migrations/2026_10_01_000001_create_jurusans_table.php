<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jurusans', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique(); // e.g. PPLG, Animasi, BCF, TJKT, DKV
            $table->string('nama_lengkap');
            $table->text('deskripsi')->nullable();
            $table->string('color_accent')->default('#111111');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurusans');
    }
};
