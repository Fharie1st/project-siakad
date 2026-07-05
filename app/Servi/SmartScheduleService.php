<?php

namespace App\Services;

use App\Models\JadwalKuliah;
use App\Models\JadwalUjian;
use App\Models\Ruangan;

class SmartScheduleService
{
    /**
     * Cari rekomendasi jadwal kuliah
     */
    public function rekomendasiKuliah(array $data)
    {
        $hariList = [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu'
        ];

        $slotJam = [
            ['07:30', '09:10'],
            ['09:20', '11:00'],
            ['13:00', '14:40'],
            ['15:00', '16:40'],
        ];

        $ruanganList = Ruangan::orderBy('kode')->get();

        foreach ($hariList as $hari) {

            foreach ($slotJam as $slot) {

                foreach ($ruanganList as $ruangan) {

                    $bentrok = JadwalKuliah::where('hari', $hari)
                        ->where('tahun_akademik_id', $data['tahun_akademik_id'])
                        ->where('ruangan_id', $ruangan->id)
                        ->where(function ($query) use ($slot) {

                            $query
                                ->where('jam_mulai', '<', $slot[1])
                                ->where('jam_selesai', '>', $slot[0]);

                        })
                        ->exists();

                    if (!$bentrok) {

                        return [
                            'hari' => $hari,
                            'jam_mulai' => $slot[0],
                            'jam_selesai' => $slot[1],
                            'ruangan_id' => $ruangan->id,
                            'ruangan' => $ruangan->kode,
                            'alasan' => 'Slot pertama yang tersedia tanpa bentrok.'
                        ];

                    }

                }

            }

        }

        return null;
    }

    /**
     * Cari rekomendasi jadwal ujian
     */
    public function rekomendasiUjian(array $data)
    {
        $slotJam = [
            ['08:00', '10:00'],
            ['10:30', '12:30'],
            ['13:30', '15:30'],
        ];

        $ruanganList = Ruangan::orderBy('kode')->get();

        foreach ($slotJam as $slot) {

            foreach ($ruanganList as $ruangan) {

                $bentrok = JadwalUjian::where('tanggal', $data['tanggal'])
                    ->where('ruangan_id', $ruangan->id)
                    ->where(function ($query) use ($slot) {

                        $query
                            ->where('jam_mulai', '<', $slot[1])
                            ->where('jam_selesai', '>', $slot[0]);

                    })
                    ->exists();

                if (!$bentrok) {

                    return [
                        'tanggal' => $data['tanggal'],
                        'jam_mulai' => $slot[0],
                        'jam_selesai' => $slot[1],
                        'ruangan_id' => $ruangan->id,
                        'ruangan' => $ruangan->kode,
                        'alasan' => 'Slot pertama yang tersedia tanpa bentrok.'
                    ];

                }

            }

        }

        return null;
    }
}