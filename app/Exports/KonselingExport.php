<?php

namespace App\Exports;

use App\Models\Konseling;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;


class KonselingExport implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function collection()
    {
        return Konseling::with(['siswa', 'kategoriKonseling', 'jawaban', 'jawaban.ratings'])
            ->when($this->filters['today'] ?? null, function ($q) {
                if ($this->filters['today'] == '1') {
                    $q->whereDate('tanggal_konseling', today());
                } elseif ($this->filters['today'] == '7') {
                    $q->whereDate('tanggal_konseling', '>=', \Carbon\Carbon::now()->subDays(7));
                }
            })
            ->when($this->filters['bulan'] ?? null, fn($q) => $q->whereMonth('tanggal_konseling', $this->filters['bulan']))
            ->when($this->filters['tahun'] ?? null, fn($q) => $q->whereYear('tanggal_konseling', $this->filters['tahun']))
            ->when($this->filters['kelas'] ?? null, fn($q) => $q->whereHas('siswa', fn($q) => $q->where('kelas_id', $this->filters['kelas'])))
            ->when($this->filters['kategori'] ?? null, fn($q) => $q->where('kategori_konseling_id', $this->filters['kategori']))
            ->get()
            ->map(function ($item) {
                return [
                    'Tanggal' => \Carbon\Carbon::parse($item->tanggal_konseling)->format('Y-m-d'),
                    'Nama Siswa' => $item->siswa->nama ?? 'N/A',
                    'Kelas' => $item->siswa->kelas->tingkat ?? 'N/A',
                    'Kategori Konseling' => $item->kategoriKonseling->nama_kategori ?? 'N/A',
                    'Isi Jawaban' => strip_tags($item->jawaban->isi_jawaban ?? 'Belum ada jawaban'),
                    'Penjawab' => $item->jawaban->guru->nama ?? 'N/A',
                    'Rating dan Komentar' => '1/' . ($item->jawaban->ratings->rating ?? 'Belum ada Rating') . ', ' . ($item->jawaban->ratings->komentar ?? 'Tidak berkomentar'),
                ];
            });
    }

    public function headings(): array
    {
        return ['Tanggal', 'Nama Siswa', 'Kelas', 'Kategori Konseling', 'Isi Jawaban', 'Penjawab', 'Rating dan Komentar'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Judul utama
                $event->sheet->mergeCells('A1:G1');
                $event->sheet->setCellValue('A1', 'Riwayat Konseling');
                $event->sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $event->sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

                // Baris kedua: info filter
                $infoFilter = [];
                // jika tidak ada filter, tampilkan semua data
                if (empty($this->filters)) {
                    $infoFilter[] = 'Semua Data';
                }

                if ($this->filters['today'] ?? false) {
                    $infoFilter[] = 'Hari Ini';
                }

                if ($this->filters['bulan'] ?? false) {
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
                    $bulan = (int) $this->filters['bulan'];
                    $filterBulan = 'Bulan: ' . ($namaBulan[$bulan] ?? '-');
                    if ($this->filters['tahun'] ?? false) {
                        $filterBulan .= ' ' . $this->filters['tahun'];
                    }
                    $infoFilter[] = $filterBulan;
                } elseif ($this->filters['tahun'] ?? false) {
                    $infoFilter[] = 'Tahun: ' . $this->filters['tahun'];
                }

                if ($this->filters['kelas'] ?? false) {
                    $kelas = \App\Models\Kelas::find($this->filters['kelas']);
                    $infoFilter[] = 'Kelas: ' . ($kelas->tingkat ?? '-');
                }

                if ($this->filters['kategori'] ?? false) {
                    $kategori = \App\Models\KategoriKonseling::find($this->filters['kategori']);
                    $infoFilter[] = 'Kategori: ' . ($kategori->nama_kategori ?? '-');
                }

                $filterText = implode(' | ', $infoFilter);
                $event->sheet->mergeCells('A2:G2');
                $event->sheet->setCellValue('A2', $filterText);
                $event->sheet->getStyle('A2')->getFont()->setItalic(true);
                $event->sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

                // Bold header (baris 3)
                $event->sheet->getStyle('A3:G3')->getFont()->setBold(true);
            },
        ];
    }
}
