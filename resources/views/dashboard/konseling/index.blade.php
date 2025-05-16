@extends('dashboard')
@section('content')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
            })
        </script>
    @endif
    @if (session('no-data'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'No Data',
                text: '{{ session('no-data') }}',
            })
        </script>
    @endif

    {{-- @push('scripts')
        <script>
            // Kirim request tandai sebagai dibaca saat user buka halaman konseling
            fetch('/notifikasi/baca/konseling', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                console.log('Semua notifikasi ditandai sebagai dibaca.');
            });
        </script>
    @endpush --}}

    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Konseling</h3>

                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $title }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-subtitle text-muted mb-0">Filter Data Konseling</p>
                        {{-- <a href="javascript:void(0)" class="btn btn-primary" id="tambahKonseling"
                            data-toggle="modal" data-target="#konselingModal">Tambah Konseling</a> --}}
                    </div>
                    <div class="card shadow-sm rounded-4 mb-4">
                        <form method="GET" action="{{ route('admin.konseling') }}" class="p-4">
                            <div class="row gy-3 gx-4 align-items-end">

                                <div class="col-lg-3 col-md-4">
                                    <label class="form-label">Kategori Konseling</label>
                                    <select name="kategori" class="form-select">
                                        <option value="">Semua Kategori</option>
                                        @foreach ($kategoriList as $kategori)
                                            <option value="{{ $kategori->id }}"
                                                {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-3 col-md-4">
                                    <label class="form-label">Kelas</label>
                                    <select name="kelas" class="form-select">
                                        <option value="">Semua Kelas</option>
                                        @foreach ($kelasList as $kelas)
                                            <option value="{{ $kelas->id }}"
                                                {{ request('kelas') == $kelas->id ? 'selected' : '' }}>
                                                {{ $kelas->tingkat }} {{ $kelas->jurusan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-2 col-md-4">
                                    <label>Tahun</label>
                                    <select name="tahun" class="form-select">
                                        <option value="">Semua Tahun</option>
                                        @php
                                            $tahunSekarang = \Carbon\Carbon::now()->year;
                                            $tahunMulai = $tahunSekarang - 5; // 5 tahun terakhir
                                        @endphp
                                        @for ($tahun = $tahunSekarang; $tahun >= $tahunMulai; $tahun--)
                                            <option value="{{ $tahun }}"
                                                {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                                {{ $tahun }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-lg-2 col-md-4">
                                    <label class="form-label">Bulan</label>
                                    <select name="bulan" class="form-select">
                                        <option value="">Semua Bulan</option>
                                        @foreach (range(1, 12) as $bln)
                                            <option value="{{ $bln }}"
                                                {{ request('bulan') == $bln ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($bln)->translatedFormat('F') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-2 col-md-4">
                                    <label class="form-label">Tanggal</label>
                                    <select name="today" class="form-select">
                                        <option value="">Semua Tanggal</option>
                                        <option value="1" {{ request('today') == '1' ? 'selected' : '' }}>Hari Ini
                                        </option>
                                        <option value="7" {{ request('today') == '7' ? 'selected' : '' }}>7 Hari
                                            Terakhir</option>
                                    </select>
                                </div>

                                {{-- button --}}
                                <div class="col-12 d-flex flex-wrap justify-content-end mt-3" style="gap: 10px">
                                    <button type="submit" class="btn btn-primary d-flex" style="gap: 3px">
                                        <i class="bi bi-filter"></i> Filter
                                    </button>
                                    <a href="{{ route('admin.konseling') }}" class="btn btn-outline-secondary d-flex"
                                        style="gap: 3px">
                                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                                    </a>
                                    <a href="{{ route('admin.konseling.download.excel', request()->query()) }}"
                                        class="btn btn-outline-success d-flex" style="gap: 3px">
                                        <i class="bi bi-file-earmark-excel"></i> Download Excel
                                    </a>
                                    <a href="{{ route('admin.konseling.download.pdf', request()->query()) }}"
                                        target="_blank" class="btn btn-outline-danger d-flex" style="gap: 3px">
                                        <i class="bi bi-file-earmark-pdf"></i> Download PDF
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>


                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th class="col-1">No</th>
                                    <th>Topik Konseling</th>
                                    <th>Pesan Konseling</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Tanggal Konseling</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="konselingBody">
                                @foreach ($konseling as $a)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $a->kategoriKonseling->nama_kategori }}</td>
                                        <td>{{ Str::limit($a->isi_konseling, 40, '...') }}</td>
                                        <td>{!! $a->siswa->nama ?? '<span class="text-danger">Tidak ada siswa</span>' !!}</td>
                                        <td>{!! $a->siswa->kelas->tingkat ?? '<span class="text-danger">Tidak ada kelas</span>' !!}</td>
                                        @php
                                            $date = \Carbon\Carbon::parse($a->tanggal_konseling);
                                            $formattedDate = $date->format('d-M-Y');
                                        @endphp
                                        <td>{{ $formattedDate }}</td>
                                        <td>
                                            @if ($a->status_id == '1')
                                                <span class="badge bg-warning">Belum Dijawab</span>
                                            @elseif($a->status_id == '2')
                                                <span class="badge bg-info">Sudah Dibalas</span>
                                            @elseif($a->status_id == '3')
                                                <span class="badge bg-success">Selesai</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($a->status_id == '1')
                                                <a href="{{ route('admin.konseling.balas', $a->id) }}"
                                                    class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Balas Konseling">
                                                    <i class="bi bi-reply-fill"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Lihat Detail"
                                                    onclick="new bootstrap.Modal(document.getElementById('detailModal{{ $a->id }}')).show()">
                                                    <i class="bi bi-eye-fill"></i>
                                                </button>
                                                <!-- Modal Detail -->
                                                <div class="modal fade" id="detailModal{{ $a->id }}" tabindex="-1"
                                                    aria-labelledby="detailLabel{{ $a->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="detailLabel{{ $a->id }}">Detail
                                                                    Konseling</h5>
                                                                <button type="button" class="close"
                                                                    data-bs-dismiss="modal" aria-label="Close"
                                                                    id="close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>

                                                            </div>
                                                            <div class="modal-body"
                                                                style="word-break: break-word; overflow-wrap: break-word;">
                                                                <table class="table table-borderless">
                                                                    <tr>
                                                                        <th style="width: 25%;">Nama</th>
                                                                        <td>{!! $a->siswa->nama ?? '<span class="text-danger">Tidak ada siswa</span>' !!}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Topik Konseling</th>
                                                                        <td>{{ $a->kategoriKonseling->nama_kategori }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Judul</th>
                                                                        <td>{{ $a->judul }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Pesan Konseling</th>
                                                                        <td>{{ $a->isi_konseling }}</td>
                                                                    </tr>
                                                                </table>

                                                                {{-- alert rating belom ada --}}
                                                                <div class="alert alert-warning mt-3">
                                                                    Mohon segera menjawab konseling ini
                                                                </div>

                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif($a->status_id == '2')
                                                <a href="{{ route('admin.konseling.edit', $a->id) }}"
                                                    class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Edit Jawaban">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <button type="button" class="btn btn-sm btn-info"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail"
                                                    onclick="new bootstrap.Modal(document.getElementById('detailModal{{ $a->id }}')).show()">
                                                    <i class="bi bi-eye-fill"></i>
                                                </button>

                                                <!-- Modal Detail -->
                                                <div class="modal fade" id="detailModal{{ $a->id }}"
                                                    tabindex="-1" aria-labelledby="detailLabel{{ $a->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="detailLabel{{ $a->id }}">Detail
                                                                    Konseling</h5>
                                                                <button type="button" class="close"
                                                                    data-bs-dismiss="modal" aria-label="Close"
                                                                    id="close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body"
                                                                style="word-break: break-word; overflow-wrap: break-word;">
                                                                <table class="table table-borderless">
                                                                    <tr>
                                                                        <th style="width: 25%;">Nama</th>
                                                                        <td>{!! $a->siswa->nama ?? '<span class="text-danger">Tidak ada siswa</span>' !!}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Topik Konseling</th>
                                                                        <td>{{ $a->kategoriKonseling->nama_kategori }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Judul</th>
                                                                        <td>{{ $a->judul }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Pesan Konseling</th>
                                                                        <td>{{ $a->isi_konseling }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Jawaban</th>
                                                                        <td>{!! $a->jawaban->isi_jawaban !!}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Dijawab Oleh</th>
                                                                        <td>{{ $a->jawaban->guru->nama }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Tanggal Jawaban</th>
                                                                        <td>{{ \Carbon\Carbon::parse($a->jawaban->tanggal_jawaban)->format('d-M-Y') }}
                                                                        </td>
                                                                    </tr>
                                                                </table>

                                                                {{-- alert rating belom ada --}}
                                                                <div class="alert alert-warning mt-3">
                                                                    Siswa belum memberikan rating
                                                                </div>

                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif ($a->status_id == '3')
                                                <button class="btn btn-sm btn-success" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Lihat Detail"
                                                    onclick="new bootstrap.Modal(document.getElementById('ratingModal{{ $a->id }}')).show()">
                                                    <i class="bi bi-eye-fill"></i>
                                                </button>

                                                <!-- Modal Rating -->
                                                <div class="modal fade" id="ratingModal{{ $a->id }}"
                                                    tabindex="-1" aria-labelledby="ratingLabel{{ $a->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="ratingLabel{{ $a->id }}">Detail
                                                                    Konseling</h5>
                                                                <button type="button" class="close"
                                                                    data-bs-dismiss="modal" aria-label="Close"
                                                                    id="close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>

                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table table-borderless">
                                                                    <tr>
                                                                        <th style="width: 25%;">Nama</th>
                                                                        <td>{{ $a->siswa->nama }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Topik Konseling</th>
                                                                        <td>{{ $a->kategoriKonseling->nama_kategori }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Judul</th>
                                                                        <td>{{ $a->judul }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Pesan Konseling</th>
                                                                        <td>{{ $a->isi_konseling }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Jawaban</th>
                                                                        <td>{!! $a->jawaban->isi_jawaban !!}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Dijawab Oleh</th>
                                                                        <td>{{ $a->jawaban->guru->nama }}</td>
                                                                    </tr>
                                                                    @php
                                                                        $rating = $a->jawaban->ratings ?? null;
                                                                    @endphp
                                                                    @if ($rating)
                                                                        <tr>
                                                                            <th>Rating</th>
                                                                            <td>
                                                                                @for ($i = 1; $i <= 5; $i++)
                                                                                    @if ($i <= $rating->rating)
                                                                                        <i
                                                                                            class="bi bi-star-fill text-warning"></i>
                                                                                    @else
                                                                                        <i
                                                                                            class="bi bi-star text-secondary"></i>
                                                                                    @endif
                                                                                @endfor
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Komentar</th>
                                                                            <td>{{ $rating->komentar ?? 'Tidak ada komentar' }}
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                </table>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        {{-- Modal Add Konseling --}}
        <div class="modal fade text-left" id="konselingModal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">
                            Tambah Konseling
                        </h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                            id="cancel">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form form-vertical" method="POST" action="{{ route('admin.konseling.store') }}">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="judul">Topik Konseling</label>
                                                <input type="text" id="judul" name="judul"
                                                    class="form-control @error('judul') is-invalid @enderror"
                                                    placeholder="Silahkan isi Topik Konseling"
                                                    value="{{ old('judul') }}">
                                                @error('judul')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="isi_konseling">Pesan Konseling</label>
                                                <textarea id="isi_konseling" name="isi_konseling" class="form-control @error('isi_konseling') is-invalid @enderror"
                                                    placeholder="Silahkan isi Pesan Konseling">{{ old('isi_konseling') }}</textarea>
                                                @error('isi_konseling')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Submit
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
