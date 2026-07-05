<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>

        body{
            font-family: DejaVu Sans;
            font-size:12px;
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
        }

        h2{
            text-align:center;
        }

    </style>
</head>

<body>

<h2>KARTU RENCANA STUDI (KRS)</h2>

<p>
<b>Nama :</b> {{ $mahasiswa->user->name }}
</p>

<p>
<b>NIM :</b> {{ $mahasiswa->nim }}
</p>

<p>
<b>Tahun Akademik :</b>
{{ $tahunAkademikAktif->tahun }}
-
{{ $tahunAkademikAktif->semester }}
</p>

<table>

<tr>
    <th>No</th>
    <th>Kode</th>
    <th>Mata Kuliah</th>
    <th>SKS</th>
    <th>Dosen</th>
</tr>

@foreach($krs as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $item->mataKuliah->kode }}</td>

<td>{{ $item->mataKuliah->nama }}</td>

<td>{{ $item->mataKuliah->sks }}</td>

<td>{{ $item->mataKuliah->dosen->user->name }}</td>

</tr>

@endforeach

</table>

</body>

</html>