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

    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Detail Data Konseling Siswa</h3>

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
                <div class="row m-3">
                    <div class="col-md-3">
                        <div class="card justify-content-center align-items-center">
                            @if ($siswa->avatar)
                                <img src="{{ asset('') }}" class="card-img-top w-50 card rounded-circle mb-0 mt-4"
                                    alt="avatar-siswa">
                            @else
                                <img src="{{ asset('mine/img/user_default.png') }}"
                                    class="card-img-top w-50 card rounded-circle mb-0 mt-4" alt="avatar-siswa">
                            @endif
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $siswa->nama }}</h5>
                                <p class="card-text">NISN : {{ $siswa->nisn }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group row align-items-center">
                            <div class="col-lg-3 col-3">
                                <label class="col-form-label">Nama</label>
                            </div>
                            <div class="col-lg-9 col-9">
                                <input type="text" class="form-control" value="{{ strtoupper($siswa->nama) }}" readonly>
                            </div>
                            <div class="col-lg-3 col-3">
                                <label class="col-form-label">Jenis Kelamin</label>
                            </div>
                            <div class="col-lg-9 col-9">
                                <input type="text" class="form-control"
                                    value="{{ $siswa->jenis_kelamin == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN' }}" readonly>
                            </div>
                            <div class="col-lg-3 col-3">
                                <label class="col-form-label">Kelas</label>
                            </div>
                            <div class="col-lg-9 col-9">
                                <input type="text" class="form-control" value="{{ $siswa->kelas->tingkat }}" readonly>
                            </div>
                            <div class="col-lg-3 col-3">
                                <label class="col-form-label">Tahun Masuk</label>
                            </div>
                            <div class="col-lg-9 col-9">
                                <input type="text" class="form-control" value="#" readonly>
                            </div>


                        </div>
                    </div>

                    <hr class="mt-4">

                    <h2 class="text-left">Rekap Konseling Siswa</h2>
                    @if ($siswa->konseling->count() == 0)
                        <div class="alert alert-info" role="alert">
                            <strong>Belum ada data konseling</strong>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.siswa') }}" class="btn btn-secondary mt-3">Kembali</a>
                        </div>
                    @else
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th class="col-1">No</th>
                                    <th>Tanggal</th>
                                    <th>Topik Konseling</th>
                                    <th>Pesan Konseling</th>
                                    <th>Status</th>
                                    <th>Jawaban</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswa->konseling as $k)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($k->created_at)->translatedFormat('d F Y') }}
                                        </td>
                                        <td>{{ $k->judul }}</td>
                                        <td>{{ $k->isi_konseling }}</td>
                                        <td>
                                            @if ($k->status_id == 1)
                                                <span class="badge bg-warning text-dark">Belum Dijawab</span>
                                            @elseif($k->status_id == 2)
                                                <span class="badge bg-info">Dijawab</span>
                                            @elseif($k->status_id == 3)
                                                <span class="badge bg-success">Selesai</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($k->status_id == '1')
                                                <a href="javascript:void(0)" class="btn-reply btn btn-sm btn-primary"
                                                    data-toggle="modal" data-target="#replyModal"
                                                    data-id="{{ $k->id }}" data-judul="{{ $k->judul }}"
                                                    data-konseling="{{ $k->isi_konseling }}"
                                                    data-nama="{{ $k->siswa->nama }}">
                                                    Balas
                                                </a>
                                            @elseif($k->status_id == '2')
                                                <a href="javascript:void(0)" class="btn-detail btn btn-sm btn-info"
                                                    data-toggle="modal" data-target="#detailKonseling"
                                                    data-id="{{ $k->id }}" data-judul="{{ $k->judul }}"
                                                    data-konseling="{{ $k->isi_konseling }}"
                                                    data-nama="{{ $k->siswa->nama }}"
                                                    data-jawaban="{{ $k->jawaban->isi_jawaban }}"
                                                    data-tanggal="{{ $k->jawaban->tanggal_jawaban }}">
                                                    Detail
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.siswa') }}" class="btn btn-secondary mt-3">Kembali</a>
                        </div>
                    @endif
                </div>
            </div>
        </section>
        @if ($siswa->konseling->count() == 0)
        @else
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
                                Balas Pesan Konseling | {{ $k->siswa->nama }}
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                id="cancel">
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
                                            : <span id="judul"></span>
                                        </div>

                                        <div class="col-lg-3 col-3">
                                            <label class="col-form-label">Pesan Konseling</label>
                                        </div>
                                        <div class="col-lg-9 col-9">
                                            : <span id="isi_konseling"></span>
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
                                    <hr>
                                    <div class="col-lg-3 col-3">
                                        <label class="col-form-label">Judul</label>
                                    </div>
                                    <div class="col-lg-9 col-9">
                                        : <span id="judul_detail"></span>
                                    </div>
                                    <hr>
                                    <div class="col-lg-3 col-3">
                                        <label class="col-form-label">Pesan Konseling</label>
                                    </div>
                                    <div class="col-lg-9 col-9">
                                        : <span id="isi_konseling_detail"></span>
                                    </div>
                                    <hr>
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
        @endif

    </div>
@endsection
