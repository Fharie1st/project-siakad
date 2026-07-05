<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dosens', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('nidn', 30)->unique();
            $table->string('prodi');
            $table->string('jabatan')->nullable();
            $table->string('telp', 20)->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();

            $table->index('prodi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};