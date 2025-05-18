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
    </style>
</head>

<body>
    <h1 style="padding-bottom: 0px; margin-bottom: 0px">Riwayat Konseling</h1>
    {{-- Informasi filter --}}
    <div class="filter-info">
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

            $filters = [];

            if (request()->get('today') == '1') {
                $filters[] = 'Hari ini';
            } elseif (request()->get('today') == '7') {
                $filters[] = '7 Hari Terakhir';
            }

            if (request()->get('bulan')) {
                $bulanInt = (int) request()->get('bulan');
                $filters[] =
                    'Bulan: ' .
                    ($namaBulan[$bulanInt] ?? '-') .
                    (request()->get('tahun') ? ' ' . request()->get('tahun') : '');
            } elseif (request()->get('tahun')) {
                $filters[] = 'Tahun: ' . request()->get('tahun');
            }

            if (request()->get('kelas')) {
                $filters[] = 'Kelas: ' . ($konseling->first()->siswa->kelas->tingkat ?? '-');
            }

            if (request()->get('kategori')) {
                $filters[] = 'Kategori: ' . ($konseling->first()->kategoriKonseling->nama_kategori ?? '-');
            }

            if (request()->get('status')) {
                $statusMap = [
                    '1' => 'Belum Dibalas',
                    '2' => 'Sudah Dibalas',
                    '3' => 'Selesai',
                ];

                $statusValues = explode(',', request()->get('status'));
                $statusLabels = collect($statusValues)->map(fn($s) => $statusMap[$s] ?? $s)->implode(', ');

                $filters[] = 'Status: ' . $statusLabels;
            }
        @endphp

        <p style="margin-bottom: 0px">Filter: {{ implode(' | ', $filters) }}</p>
    </div>
    <p style="margin-top: 0px; padding-top: 0px">Tanggal Cetak: {{ now()->format('d-m-Y H:i:s') }}</p>

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
                            {{ $item->jawaban->ratings->rating }}/5,
                            "{{ $item->jawaban->ratings->komentar ?? 'Tidak berkomentar' }}"
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
