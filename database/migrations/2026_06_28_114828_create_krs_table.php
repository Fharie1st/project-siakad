<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('krs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mahasiswa_id')
                ->constrained('mahasiswas')
                ->cascadeOnDelete();

            $table->foreignId('matkul_id')
                ->constrained('mata_kuliahs')
                ->cascadeOnDelete();

            $table->foreignId('tahun_akademik_id')
                ->constrained('tahun_akademiks')
                ->cascadeOnDelete();

            $table->enum('status', [
                'diambil',
                'dibatalkan',
            ])->default('diambil');

            $table->timestamps();

            $table->unique([
                'mahasiswa_id',
                'matkul_id',
                'tahun_akademik_id',
            ]);

            $table->index(['mahasiswa_id', 'status']);
            $table->index(['tahun_akademik_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('krs');
    }
};