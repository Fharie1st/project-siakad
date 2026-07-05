<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_kuliahs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('matkul_id')
                ->constrained('mata_kuliahs')
                ->cascadeOnDelete();

            $table->foreignId('ruangan_id')
                ->constrained('ruangans')
                ->restrictOnDelete();

            $table->foreignId('tahun_akademik_id')
                ->constrained('tahun_akademiks')
                ->cascadeOnDelete();

            $table->enum('hari', [
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu',
            ]);

            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();

            $table->index(['hari', 'jam_mulai']);
            $table->index(['tahun_akademik_id', 'matkul_id']);
            $table->index(['ruangan_id', 'hari']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_kuliahs');
    }
};