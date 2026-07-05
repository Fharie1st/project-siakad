<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('nim', 30)->unique();
            $table->string('prodi');
            $table->year('angkatan');
            $table->text('alamat')->nullable();
            $table->string('telp', 20)->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();

            $table->index('prodi');
            $table->index('angkatan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};