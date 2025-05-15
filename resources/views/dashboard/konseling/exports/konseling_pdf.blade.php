<!DOCTYPE html>
<html>

<head>
    <title>Riwayat Konseling</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h1,
        p {
            text-align: center;
            margin: 0;
            padding: 5px;
        }

        .filter-info {
            margin: 10px 0 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }

        .text-danger {
            color: red;
        }

        .text-success {
            color: green;
        }

        .text-warning {
            color: orange;
        }
    </style>
</head>

<body>
    <h1 style="padding-bottom: 0px; margin-bottom: 0px">Riwayat Konseling</h1>
    {{-- Informasi filter --}}
    <div class="filter-info">
        <p>
            @php
                $today = request()->get('today');
                $bulan = request()->get('bulan');
                $kelas = request()->get('kelas');
                $kategori = request()->get('kategori');
            @endphp

        <p>
            @if ($today)
                Hari ini |
            @endif

            @php
                $namaBulan = [
                    1 => 'Januari',
                    2 => 'Februari',
                    3 => 'Maret',
                    4 => 'April',
                    5 => 'Mei',
                    6 => 'Juni',
                    7 => 'Juli',
                    8 => 'Agustus',
                    9 => 'September',
                    10 => 'Oktober',
                    11 => 'November',
                    12 => 'Desember',
                ];
            @endphp

            @if ($bulan)
                Bulan: {{ $namaBulan[(int) $bulan] ?? '-' }}{{ $tahun ? ' ' . $tahun : '' }}
            @elseif ($tahun)
                Tahun: {{ $tahun }} |
            @endif


            @if ($kelas)
                Kelas: {{ $konseling->first()->siswa->kelas->tingkat ?? '-' }}
            @endif

            @if ($kategori)
                Kategori: {{ $konseling->first()->kategoriKonseling->nama_kategori ?? '-' }}
            @endif
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Kategori Konseling</th>
                <th>Isi Konseling</th>
                <th>Jawaban Guru</th>
                <th>Rating dan Komentar</th>
                <th>Status Konseling</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($konseling as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_konseling)->format('d-m-Y') }}</td>
                    <td>{{ $item->siswa->nama ?? 'N/A' }}</td>
                    <td>{{ $item->siswa->kelas->tingkat ?? 'N/A' }}</td>
                    <td>{{ $item->kategoriKonseling->nama_kategori ?? 'N/A' }}</td>
                    <td>{{ $item->isi_konseling ?? 'Belum ada' }}</td>
                    <td>
                        @if ($item->jawaban)
                            {{ strip_tags($item->jawaban->isi_jawaban) }}
                            <br>dijawab Oleh: {{ $item->jawaban->guru->nama ?? 'Guru tidak diketahui' }}
                        @else
                            <span class="text-danger">Belum ada Jawaban</span>
                        @endif
                    </td>


                    <td>
                        @if ($item->jawaban && $item->jawaban->ratings)
                            1/{{ $item->jawaban->ratings->rating ?? 'Belum ada Rating' }},
                            {{ $item->jawaban->ratings->komentar ?? 'Tidak berkomentar' }}
                        @elseif ($item->jawaban)
                            <span class="text-danger">Belum ada Rating dan Komentar</span>
                        @else
                            <span class="text-danger">Belum ada Jawaban</span>
                        @endif
                    </td>

                    <td>
                        @if ($item->status_id == '1')
                            <span class="text-danger">Belum Dijawab</span>
                        @elseif($item->status_id == '2')
                            <span class="text-success">Sudah Dibalas</span>
                        @elseif($item->status_id == '3')
                            <span class="text-success">Selesai</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
