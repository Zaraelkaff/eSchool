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
        Schema::table('jadwal', function (Blueprint $table) {
            // Hapus kolom jam_mulai dan jam_selesai
            $table->dropColumn(['jam_mulai', 'jam_selesai']);

            // Tambahkan kolom jam_id
            $table->unsignedBigInteger('jam_id')->after('mapel_id');

            // Foreign key ke tabel jam
            $table->foreign('jam_id')->references('id')->on('jam');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {
            // Drop foreign key dan kolom jam_id
            $table->dropForeign(['jam_id']);
            $table->dropColumn('jam_id');

            // Tambahkan kembali kolom jam_mulai dan jam_selesai
            $table->time('jam_mulai')->after('mapel_id');
            $table->time('jam_selesai')->after('jam_mulai');
        });
    }
};
