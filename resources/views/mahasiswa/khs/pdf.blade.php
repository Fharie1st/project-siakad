<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        body{
            font-family: DejaVu Sans;
            font-size:12px;
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table,th,td{
            border:1px solid black;
        }

        th,td{
            padding:6px;
            text-align:left;
        }

        .info{
            margin-bottom:15px;
        }
    </style>

</head>

<body>

<h2>KARTU HASIL STUDI (KHS)</h2>

<div class="info">

<p>
<b>Nama :</b> {{ $mahasiswa->user->name }}
</p>

<p>
<b>NIM :</b> {{ $mahasiswa->nim }}
</p>

<p>
<b>Tahun Akademik :</b>
{{ $tahunAkademikDipilih->tahun }}
-
{{ $tahunAkademikDipilih->semester }}
</p>

<p>
<b>IPS :</b>
{{ number_format($ips,2) }}
</p>

</div>

<table>

<tr>
    <th>No</th>
    <th>Kode</th>
    <th>Mata Kuliah</th>
    <th>SKS</th>
    <th>UTS</th>
    <th>UAS</th>
    <th>Tugas</th>
    <th>Nilai Akhir</th>
    <th>Grade</th>
</tr>

@foreach($dataKhs as $krs)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $krs->mataKuliah->kode }}</td>

<td>{{ $krs->mataKuliah->nama }}</td>

<td>{{ $krs->mataKuliah->sks }}</td>

<td>{{ $krs->nilai->nilai_uts }}</td>

<td>{{ $krs->nilai->nilai_uas }}</td>

<td>{{ $krs->nilai->nilai_tugas }}</td>

<td>{{ number_format($krs->nilai->nilai_akhir,2) }}</td>

<td>{{ $krs->nilai->grade }}</td>

</tr>

@endforeach

</table>

</body>
</html>