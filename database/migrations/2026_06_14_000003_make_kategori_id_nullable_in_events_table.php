<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // agar tidak gagal bila kategori_id tidak terisi (mencegah default error)
            if (Schema::hasColumn('events', 'kategori_id')) {
                $table->foreignId('kategori_id')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'kategori_id')) {
                $table->foreignId('kategori_id')->nullable(false)->change();
            }
        });
    }
};
