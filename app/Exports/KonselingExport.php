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
        return 'A4'; // Data dimulai dari A4
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
            ->when($this->filters['status'] ?? null, function ($q) {
                $status = explode(',', $this->filters['status']);
                if (count($status) > 1) {
                    $q->whereIn('status_id', $status);
                } else {
                    $q->where('status_id', $status[0]);
                }
            })

            ->when($this->filters['kategori'] ?? null, fn($q) => $q->where('kategori_konseling_id', $this->filters['kategori']))
            ->get()
            ->map(function ($item) {
                return [
                    'Tanggal' => \Carbon\Carbon::parse($item->tanggal_konseling)->format('Y-m-d'),
                    'Nama Siswa' => $item->siswa->nama ?? 'N/A',
                    'Kelas' => $item->siswa->kelas->tingkat ?? 'N/A',
                    'Kategori Konseling' => $item->kategoriKonseling->nama_kategori ?? 'N/A',
                    'Isi Konseling' => strip_tags($item->isi_konseling ?? '-'),
                    'Jawaban Guru' => strip_tags($item->jawaban->isi_jawaban ?? 'Belum ada jawaban'),
                    'Penjawab' => $item->jawaban->guru->nama ?? 'Belum ada jawaban',
                    'Rating dan Komentar' => $item->jawaban && $item->jawaban->ratings
                        ? "⭐ " . $item->jawaban->ratings->rating . ' / 5, "' . $item->jawaban->ratings->komentar . '"'
                        : 'Belum ada rating atau komentar',
                    'Status Konseling' => $item->status->nama ?? 'Tidak diketahui',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Siswa',
            'Kelas',
            'Kategori Konseling',
            'Isi Konseling',
            'Jawaban Guru',
            'Penjawab',
            'Rating dan Komentar',
            'Status Konseling',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Judul utama
                $event->sheet->mergeCells('A1:I1');
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

                if ($this->filters['status'] ?? false) {
                    $statusLabel = [
                        '1' => 'Belum Dibalas',
                        '2' => 'Sudah Dibalas',
                        '3' => 'Selesai',
                    ];

                    $statusValues = explode(',', $this->filters['status']);
                    $statusNames = collect($statusValues)
                        ->map(fn($val) => $statusLabel[trim($val)] ?? 'Status Tidak Dikenal')
                        ->implode(' & ');

                    $infoFilter[] = 'Status: ' . $statusNames;
                }

                $filterText = implode(' | ', $infoFilter);
                $event->sheet->mergeCells('A2:I2');
                $event->sheet->setCellValue('A2', 'Filter: ' . $filterText);
                $event->sheet->getStyle('A2')->getFont()->setItalic(true);
                $event->sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
                // Set wrap text untuk kolom E (Isi Konseling), F (Jawaban Guru) dan H (Rating dan Komentar)
                $event->sheet->getStyle('E4:E' . ($event->sheet->getHighestRow()))->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('F4:F' . ($event->sheet->getHighestRow()))->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('H4:H' . ($event->sheet->getHighestRow()))->getAlignment()->setWrapText(true);
                // Set lebar kolom
                $event->sheet->getColumnDimension('A')->setWidth(15);
                $event->sheet->getColumnDimension('B')->setWidth(25);
                $event->sheet->getColumnDimension('C')->setWidth(7);
                $event->sheet->getColumnDimension('D')->setWidth(25);
                $event->sheet->getColumnDimension('E')->setWidth(30);
                $event->sheet->getColumnDimension('F')->setWidth(30);
                $event->sheet->getColumnDimension('G')->setWidth(20);
                $event->sheet->getColumnDimension('H')->setWidth(30);
                $event->sheet->getColumnDimension('I')->setWidth(15);
                // Set vertical align top untuk semua data mulai dari baris 4
                $event->sheet->getStyle('A4:I' . ($event->sheet->getHighestRow()))->getAlignment()->setVertical('top');

                // Baris A3 = Tanggal Cetak
                $event->sheet->mergeCells('A3:I3');
                $event->sheet->setCellValue('A3', 'Tanggal Cetak: ' . now()->format('d-m-Y H:i:s'));
                $event->sheet->getStyle('A3')->getAlignment()->setHorizontal('center');

                // Bold header A4
                $event->sheet->getStyle('A4:I4')->getFont()->setBold(true);
            },
        ];
    }
}
