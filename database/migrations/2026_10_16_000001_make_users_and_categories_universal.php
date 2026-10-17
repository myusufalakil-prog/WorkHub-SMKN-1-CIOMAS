<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'institution')) {
                $table->string('institution', 150)->nullable()->after('kelas');
            }
            if (!Schema::hasColumn('users', 'headline')) {
                $table->string('headline', 150)->nullable()->after('jabatan');
            }
            if (!Schema::hasColumn('users', 'portfolio_website')) {
                $table->string('portfolio_website', 255)->nullable()->after('bio');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['institution', 'headline', 'portfolio_website']);
        });
    }
};
