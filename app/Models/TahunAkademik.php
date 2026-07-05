<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunAkademik extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun',
        'semester',
        'is_aktif',
    ];

    protected function casts(): array
    {
        return [
            'is_aktif' => 'boolean',
        ];
    }

    public function jadwalKuliahs(): HasMany
    {
        return $this->hasMany(JadwalKuliah::class);
    }

    public function jadwalUjians(): HasMany
    {
        return $this->hasMany(JadwalUjian::class);
    }

    public function krs(): HasMany
    {
        return $this->hasMany(Krs::class);
    }
}