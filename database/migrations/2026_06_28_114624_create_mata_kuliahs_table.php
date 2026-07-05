<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mata_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30)->unique();
            $table->string('nama');
            $table->unsignedTinyInteger('sks');
            $table->unsignedTinyInteger('semester');

            $table->foreignId('dosen_id')
                ->nullable()
                ->constrained('dosens')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('semester');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mata_kuliahs');
    }
};