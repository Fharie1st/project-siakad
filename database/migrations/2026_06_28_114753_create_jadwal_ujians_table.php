<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_ujians', function (Blueprint $table) {
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

            $table->enum('jenis', ['UTS', 'UAS']);
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();

            $table->unique([
                'matkul_id',
                'tahun_akademik_id',
                'jenis',
            ]);

            $table->index(['tanggal', 'jam_mulai']);
            $table->index(['ruangan_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_ujians');
    }
};