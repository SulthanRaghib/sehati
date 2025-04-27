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
    <script>
        // Kirim request tandai sebagai dibaca saat user buka halaman konseling
        fetch('/notifikasi/baca', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        }).then(() => {
            console.log('Semua notifikasi ditandai sebagai dibaca.');
        });
    </script>


    {{-- <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    @vite('resources/js/app.js')
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
                        <a href="javascript:void(0)" class="btn btn-outline-primary" id="tambahKonseling"
                            data-toggle="modal" data-target="#konselingModal">Tambah Konseling</a>
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
                                                    <span class="badge bg-warning text-dark">Belum Dijawab</span>
                                                @elseif($a->status_id == '2')
                                                    <span class="badge bg-info">Dijawab</span>
                                                @elseif($a->status_id == '3')
                                                    <span class="badge bg-success">Selesai</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{-- update a reply jadi modal --}}
                                                @if ($a->status_id == '1')
                                                    <a href="javascript:void(0)" class="btn-reply btn btn-sm btn-primary"
                                                        data-toggle="modal" data-target="#replyModal"
                                                        data-id="{{ $a->id }}" data-judul="{{ $a->judul }}"
                                                        data-konseling="{{ $a->isi_konseling }}"
                                                        data-nama="{{ $a->siswa->nama }}">
                                                        Balas
                                                    </a>
                                                @elseif($a->status_id == '2')
                                                    <a href="javascript:void(0)" class="btn-detail btn btn-sm btn-info"
                                                        data-toggle="modal" data-target="#detailKonseling"
                                                        data-id="{{ $a->id }}" data-judul="{{ $a->judul }}"
                                                        data-konseling="{{ $a->isi_konseling }}"
                                                        data-nama="{{ $a->siswa->nama }}"
                                                        data-jawaban="{{ $a->jawaban->isi_jawaban }}"
                                                        data-tanggal="{{ $a->jawaban->tanggal_jawaban }}">
                                                        Detail
                                                    </a>
                                                @endif
                                                <form action="{{ route('admin.konseling.destroy', $a->id) }}"
                                                    method="POST" class="d-inline form-delete">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button" class="btn btn-sm btn-danger btn-delete">
                                                        Delete
                                                    </button>
                                                    <script>
                                                        // Seleksi semua tombol hapus
                                                        document.querySelectorAll('.btn-delete').forEach(button => {
                                                            button.addEventListener('click', function(e) {
                                                                e.preventDefault(); // Mencegah form langsung terkirim

                                                                // Ambil form terdekat dari tombol
                                                                const form = this.closest('.form-delete');

                                                                // Tampilkan SweetAlert
                                                                Swal.fire({
                                                                    title: 'Apakah Anda yakin?',
                                                                    text: "Data Konseling ini akan dihapus secara permanen!",
                                                                    icon: 'warning',
                                                                    showCancelButton: true,
                                                                    confirmButtonColor: '#d33',
                                                                    cancelButtonColor: '#3085d6',
                                                                    confirmButtonText: 'Ya, Hapus!',
                                                                    cancelButtonText: 'Batal'
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        // Submit form jika dikonfirmasi
                                                                        form.submit();
                                                                    }
                                                                });
                                                            });
                                                        });
                                                    </script>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </section>

        <!-- Modal Reply -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const replyButtons = document.querySelectorAll('.btn-reply');

                replyButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        const judul = this.getAttribute('data-judul');
                        const isiKonseling = this.getAttribute('data-konseling');
                        const nama = this.getAttribute('data-nama');

                        document.getElementById('konseling_id').value = id;
                        document.getElementById('judul').textContent = judul;
                        document.getElementById('isi_konseling').textContent = isiKonseling;
                        document.getElementById('nama').textContent = nama;
                    });
                });
            });
        </script>

        <div class="modal fade text-left" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">
                            Balas Pesan Konseling | {{ $a->siswa->nama }}
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="cancel">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <form action="{{ route('admin.konseling.reply') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="col-md-12">
                                <div class="form-group row align-items-center">
                                    <input type="hidden" name="konseling_id" id="konseling_id">

                                    <div class="col-lg-3 col-3">
                                        <label class="col-form-label">Judul</label>
                                    </div>
                                    <div class="col-lg-9 col-9">
                                        : <span id="judul">{{ $a->judul }}</span>
                                    </div>

                                    <div class="col-lg-3 col-3">
                                        <label class="col-form-label">Pesan Konseling</label>
                                    </div>
                                    <div class="col-lg-9 col-9">
                                        : <span id="isi_konseling">{{ $a->isi_konseling }}</span>
                                    </div>
                                    <div class="col-lg-12 col-12">
                                        <label class="col-form-label">Balas Pesan</label>
                                        <textarea name="isi_jawaban" id="isi_jawaban" class="form-control  @error('isi_jawaban') is-invalid @enderror"
                                            placeholder="Balas Pesan Konseling" rows="10" cols="100" style="resize: none;">{{ old('isi_jawaban') }}</textarea>
                                        @error('isi_jawaban')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- /End Modal Reply --}}

        <!-- Modal Detail Konseling -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const detailButtons = document.querySelectorAll('.btn-detail');

                detailButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const nama = this.getAttribute('data-nama');
                        const judul = this.getAttribute('data-judul');
                        const isiKonseling = this.getAttribute('data-konseling');
                        const jawaban = this.getAttribute('data-jawaban');
                        const tanggal = this.getAttribute('data-tanggal');
                        const formattedDate = new Date(tanggal).toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });

                        document.getElementById('nama_detail').textContent = nama;
                        document.getElementById('judul_detail').textContent = judul;
                        document.getElementById('isi_konseling_detail').textContent = isiKonseling;
                        document.getElementById('isi_jawaban_detail').textContent = jawaban;
                        document.getElementById('tanggal_jawaban_detail').textContent = formattedDate;
                    });
                });
            });
        </script>


        <div class="modal fade text-left" id="detailKonseling" tabindex="-1" role="dialog"
            aria-labelledby="detailModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="detailModalLabel">Detail Konseling</h4>
                        {{-- tanggal  --}}
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group row align-items-center">
                                <div class="col-lg-3 col-3">
                                    <label class="col-form-label">Nama</label>
                                </div>
                                <div class="col-lg-9 col-9">
                                    : <span id="nama_detail"></span>
                                </div>

                                <div class="col-lg-3 col-3">
                                    <label class="col-form-label">Judul</label>
                                </div>
                                <div class="col-lg-9 col-9">
                                    : <span id="judul_detail"></span>
                                </div>

                                <div class="col-lg-3 col-3">
                                    <label class="col-form-label">Pesan Konseling</label>
                                </div>
                                <div class="col-lg-9 col-9">
                                    : <span id="isi_konseling_detail"></span>
                                </div>
                                <div class="col-lg-3 col-3">
                                    <label class="col-form-label">Jawaban</label>
                                </div>
                                <div class="col-lg-9 col-9">
                                    : <span id="isi_jawaban_detail"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- /End Modal Detail Konseling --}}

        <script>
            document.getElementById('tutupModal').addEventListener('click', function(e) {
                e.preventDefault(); // Mencegah modal langsung tertutup

                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Anda akan kehilangan data yang sudah diinput!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#FDAC41',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Lanjutkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Menghapus event listener yang mencegah modal tertutup
                        $('#replyModal').off('hide.bs.modal.preventClose');

                        // Menghapus inputan dalam form sebelum menutup modal
                        document.querySelectorAll('.modal input, .modal textarea, .modal select').forEach(
                            input => input.value = null);

                        // Menutup modal setelah konfirmasi
                        $('#replyModal').modal('hide');
                    }
                });
            });

            // Mencegah modal tertutup saat tombol close diklik tanpa konfirmasi
            $('#replyModal').one('hide.bs.modal.preventClose', function(e) {
                if (Swal.isVisible()) {
                    e.preventDefault();
                }
            });

            // Mendaftarkan ulang event hanya saat modal dibuka kembali
            $('#replyModal').on('show.bs.modal', function() {
                $('#replyModal').one('hide.bs.modal.preventClose', function(e) {
                    if (Swal.isVisible()) {
                        e.preventDefault();
                    }
                });
            });
        </script>


        {{-- Modal Add Konseling --}}
        <div class="modal fade text-left" id="konselingModal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
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
