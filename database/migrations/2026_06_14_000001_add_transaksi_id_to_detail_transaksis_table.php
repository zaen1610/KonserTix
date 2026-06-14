<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_transaksis', function (Blueprint $table) {
            // relasi dari detail transaksi ke transaksi
            if (!Schema::hasColumn('detail_transaksis', 'transaksi_id')) {
                $table->foreignId('transaksi_id')
                    ->after('id')
                    ->constrained('transaksis')
                    ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('detail_transaksis', function (Blueprint $table) {
            if (Schema::hasColumn('detail_transaksis', 'transaksi_id')) {
                $table->dropForeign(['transaksi_id']);
                $table->dropColumn('transaksi_id');
            }
        });
    }
};

