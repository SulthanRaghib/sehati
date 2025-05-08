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

    @push('scripts')
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
    @endpush

    {{-- <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            forceTLS: true
        });

        var channel = pusher.subscribe('konseling-baru');
        channel.bind('konseling-baru', function(data) {
            console.log("Data Pusher masuk:", data);

            // 1. Tambahkan ke tabel (jika ada)
            const body = document.getElementById('konselingBody');
            if (body) {
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                <td>${data.konseling.judul}</td>
                <td>${data.konseling.isi_konseling}</td>
                <td>${data.konseling.tanggal_konseling}</td>
            `;
                body.prepend(newRow);
            }

            // 2. Update badge notifikasi
            const notifBadge = document.getElementById('notif-count');
            if (notifBadge) {
                let currentCount = parseInt(notifBadge.innerText) || 0;
                notifBadge.innerText = currentCount + data.konseling.jumlah_inbox;
            }

            // 3. Tambahkan notifikasi baru ke list
            const notifList = document.querySelector('.dropdown-menu ul.list-group');
            if (notifList) {
                const newNotif = document.createElement('li');
                newNotif.classList.add('list-group-item', 'border-0', 'align-items-start');
                newNotif.innerHTML = `
                <div class="avatar bg-primary mr-3">
                    <span class="avatar-content"><i data-feather="message-circle"></i></span>
                </div>
                <div>
                    <h6 class="text-bold">Konseling Baru</h6>
                    <p class="text-xs">
                        ${data.konseling.judul}: ${data.konseling.isi_konseling}
                    </p>
                </div>
            `;
                notifList.prepend(newNotif);
            }

            // 4. Refresh feather icon jika pakai feather
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script> --}}


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
                        <p class="text-subtitle text-muted">Manage Data Konseling</p>
                        {{-- <a href="javascript:void(0)" class="btn btn-primary" id="tambahKonseling"
                            data-toggle="modal" data-target="#konselingModal">Tambah Konseling</a> --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th class="col-1">No</th>
                                        <th>Topik</th>
                                        <th>Pesan Konseling</th>
                                        <th>Nama Siswa</th>
                                        <th>Tanggal Konseling</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="konselingBody">
                                    @foreach ($konseling as $a)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $a->judul }}</td>
                                            <td>{{ Str::limit($a->isi_konseling, 40, '...') }}</td>
                                            <td>{{ $a->siswa->nama }}</td>
                                            @php
                                                $date = \Carbon\Carbon::parse($a->tanggal_konseling);
                                                $formattedDate = $date->format('d-m-Y');
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
                                                        class="btn btn-sm btn-primary">
                                                        Balas
                                                    </a>
                                                @elseif($a->status_id == '2')
                                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                        data-bs-target="#detailModal{{ $a->id }}">
                                                        Detail
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
                                                                        data-dismiss="modal" aria-label="Close"
                                                                        id="cancel">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body"
                                                                    style="word-break: break-word; overflow-wrap: break-word;">
                                                                    <table class="table table-borderless">
                                                                        <tr>
                                                                            <th style="width: 25%;">Nama</th>
                                                                            <td>{{ $a->siswa->nama }}</td>
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
                                                                            <td>
                                                                                {!! $a->jawaban->isi_jawaban !!}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Tanggal Jawaban</th>
                                                                            <td>{{ \Carbon\Carbon::parse($a->jawaban->tanggal_jawaban)->format('d-m-Y') }}
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
                                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                        data-bs-target="#ratingModal{{ $a->id }}">
                                                        Detail
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
                                                                        data-dismiss="modal" aria-label="Close"
                                                                        id="cancel">
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
                                                                            <th>Judul</th>
                                                                            <td>{{ $a->judul }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Pesan Konseling</th>
                                                                            <td>
                                                                                {{ $a->isi_konseling }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Jawaban</th>
                                                                            <td>
                                                                                {!! $a->jawaban->isi_jawaban !!}</td>
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
        <div class="modal fade text-left" id="konselingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">
                            Tambah Konseling
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="cancel">
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
