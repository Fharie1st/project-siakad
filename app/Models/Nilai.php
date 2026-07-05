<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'krs_id',
        'nilai_uts',
        'nilai_uas',
        'nilai_tugas',
        'nilai_akhir',
        'grade',
    ];

    protected function casts(): array
    {
        return [
            'nilai_uts' => 'decimal:2',
            'nilai_uas' => 'decimal:2',
            'nilai_tugas' => 'decimal:2',
            'nilai_akhir' => 'decimal:2',
        ];
    }

    public function krs(): BelongsTo
    {
        return $this->belongsTo(Krs::class);
    }
}