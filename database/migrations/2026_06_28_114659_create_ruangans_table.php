<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ruangans', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30)->unique();
            $table->unsignedSmallInteger('kapasitas');
            $table->string('gedung');
            $table->timestamps();

            $table->index('gedung');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ruangans');
    }
};