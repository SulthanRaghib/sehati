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
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
            })
        </script>
    @endif
    @if (session('tahun-akademik-not-found'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('tahun-akademik-not-found') }}',
                showCancelButton: true,
                confirmButtonText: 'Atur Sekarang',
                cancelButtonText: 'Nanti Saja'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('admin.tahunAkademik') }}";
                }
            });
        </script>
    @endif


    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Siswa</h3>

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
                    <div class="d-flex justify-content-between align-items-center" style="gap: 10px">
                        <div>
                            <p class="text-subtitle text-muted">Manage Data Siswa</p>
                            <form method="GET" action="{{ route('admin.siswa') }}" class="mb-4">
                                <div class="row g-2 align-items-end">
                                    <div class="col-md-8">
                                        <label for="kelas_id" class="form-label">Filter Kelas</label>
                                        <select name="kelas_id" id="kelas_id" class="form-select">
                                            <option value="">-- Semua Kelas --</option>
                                            @foreach ($kelasList as $kelas)
                                                <option value="{{ $kelas->id }}"
                                                    {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                                    {{ $kelas->tingkat }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary" style="width: 130px">
                                            <i class="bi bi-funnel-fill"></i>
                                            Terapkan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">Add Siswa</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if ($siswa->count() == 0)
                            <div class="alert alert-info">
                                Data Siswa belum ada. Silahkan tambahkan data siswa baru.
                            </div>
                        @else
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th class="col-1">No</th>
                                        <th>NISN</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Kelas</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($siswa as $s)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $s->nisn }}</td>
                                            <td>{{ $s->nama }}</td>
                                            <td>
                                                @if ($s->jenis_kelamin == 'L')
                                                    Laki-laki
                                                @else
                                                    Perempuan
                                                @endif
                                            <td>{!! $s->kelas->tingkat ?? '<span class="text-danger">Belum ada kelas</span>' !!}</td>
                                            <td>
                                                <a href="{{ route('admin.siswa.detailKonseling', $s->id) }}"
                                                    class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Lihat Riwayat Konseling">
                                                    <i class="bi bi-chat-left-text-fill"></i>
                                                </a>
                                                <a href="{{ route('admin.siswa.show', $s->id) }}"
                                                    class="btn btn-sm btn-info" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Lihat Detail Siswa">
                                                    <i class="bi bi-eye-fill"></i>
                                                </a>
                                                <a href="{{ route('admin.siswa.edit', $s->id) }}"
                                                    class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Edit Siswa">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>
                                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'developer')
                                                    <form action="{{ route('admin.siswa.destroy', $s->id) }}"
                                                        method="post" class="d-inline form-delete">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="button" class="btn btn-sm btn-danger btn-delete"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Hapus Siswa"><i class="bi bi-trash-fill"></i></button>

                                                        <script>
                                                            document.querySelectorAll('.btn-delete').forEach(button => {
                                                                button.addEventListener('click', function(e) {
                                                                    e.preventDefault(); // Mencegah form langsung terkirim

                                                                    const form = this.closest('.form-delete');

                                                                    // Konfirmasi Pertama
                                                                    Swal.fire({
                                                                        title: 'Yakin ingin menghapus siswa ini?',
                                                                        text: "Menghapus siswa akan menghapus semua data KONSELING yang terkait!",
                                                                        icon: 'warning',
                                                                        showCancelButton: true,
                                                                        confirmButtonColor: '#d33',
                                                                        cancelButtonColor: '#3085d6',
                                                                        confirmButtonText: 'Lanjutkan',
                                                                        cancelButtonText: 'Batal'
                                                                    }).then((firstResult) => {
                                                                        if (firstResult.isConfirmed) {
                                                                            // Konfirmasi Kedua
                                                                            Swal.fire({
                                                                                title: 'Konfirmasi Terakhir!',
                                                                                text: "Data akan dihapus permanen. Anda tidak bisa mengembalikannya!",
                                                                                icon: 'error',
                                                                                showCancelButton: true,
                                                                                confirmButtonColor: '#d33',
                                                                                cancelButtonColor: '#6c757d',
                                                                                confirmButtonText: 'Ya, Hapus Sekarang!',
                                                                                cancelButtonText: 'Batal'
                                                                            }).then((secondResult) => {
                                                                                if (secondResult.isConfirmed) {
                                                                                    form.submit(); // Submit form jika benar-benar yakin
                                                                                }
                                                                            });
                                                                        }
                                                                    });
                                                                });
                                                            });
                                                        </script>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
