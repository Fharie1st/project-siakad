<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tahun_akademiks', function (Blueprint $table) {
            $table->id();
            $table->string('tahun', 20);
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->boolean('is_aktif')->default(false);
            $table->timestamps();

            $table->unique(['tahun', 'semester']);
            $table->index('is_aktif');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tahun_akademiks');
    }
};