<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Jadwal Kuliah</title>

    <style>
        body{
            font-family: DejaVu Sans, sans-serif;
            font-size:12px;
        }

        h2{
            text-align:center;
            margin-bottom:5px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        table,th,td{
            border:1px solid #000;
        }

        th{
            background:#eeeeee;
        }

        th,td{
            padding:6px;
            text-align:left;
        }
    </style>
</head>

<body>

<h2>JADWAL KULIAH MAHASISWA</h2>

<p>
<b>Nama :</b> {{ $mahasiswa->user->name }}
</p>

<p>
<b>Tahun Akademik :</b>
{{ $tahunAkademikAktif?->tahun }}
-
{{ $tahunAkademikAktif?->semester }}
</p>

<table>

<thead>

<tr>

<th>No</th>
<th>Hari</th>
<th>Jam</th>
<th>Mata Kuliah</th>
<th>Dosen</th>
<th>Ruangan</th>

</tr>

</thead>

<tbody>

@foreach($jadwalKuliahs as $jadwal)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $jadwal->hari }}</td>

<td>
{{ substr($jadwal->jam_mulai,0,5) }}
-
{{ substr($jadwal->jam_selesai,0,5) }}
</td>

<td>
{{ $jadwal->mataKuliah->nama }}
</td>

<td>
{{ $jadwal->mataKuliah->dosen->user->name }}
</td>

<td>
{{ $jadwal->ruangan->kode }}
</td>

</tr>

@endforeach

</tbody>

</table>

</body>

</html>