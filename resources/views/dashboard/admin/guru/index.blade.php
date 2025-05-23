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
                    <h3>Data Guru</h3>

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
                        <p class="text-subtitle text-muted">Manage Data Guru</p>
                        <a href="{{ route('admin.guru.create') }}" class="btn btn-primary">Add Guru</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if ($guru->count() == 0)
                            <div class="alert alert-info">
                                Data Guru belum ada. Silahkan tambahkan data guru baru.
                            </div>
                        @else
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th class="col-1">No</th>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($guru as $guru)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $guru->nip }}</td>
                                            <td>{{ $guru->nama }}</td>
                                            <td>{{ $guru->alamat }}</td>
                                            <td>
                                                <a href="{{ route('admin.guru.show', $guru->id) }}"
                                                    class="btn btn-sm btn-info" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Lihat Detail Guru">
                                                    <i class="bi bi-eye-fill"></i>
                                                </a>
                                                <a href="{{ route('admin.guru.edit', $guru->id) }}"
                                                    class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Edit Guru">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>
                                                <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="post"
                                                    class="d-inline form-delete">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button" class="btn btn-sm btn-danger btn-delete"
                                                        data-role="{{ $guru->user->role ?? '' }}" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Hapus Guru">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>

                                                    <script>
                                                        document.querySelectorAll('.btn-delete').forEach(button => {
                                                            button.addEventListener('click', function(e) {
                                                                e.preventDefault();

                                                                const form = this.closest('.form-delete');
                                                                const role = this.dataset.role; // Ambil role dari tombol

                                                                if (role === "admin") {
                                                                    // Konfirmasi pertama jika user adalah admin
                                                                    Swal.fire({
                                                                        title: 'Perhatian!',
                                                                        text: "Guru ini memiliki role admin. Anda yakin ingin menghapusnya?",
                                                                        icon: 'warning',
                                                                        showCancelButton: true,
                                                                        confirmButtonColor: '#d33',
                                                                        cancelButtonColor: '#3085d6',
                                                                        confirmButtonText: 'Ya, lanjutkan!',
                                                                        cancelButtonText: 'Batal'
                                                                    }).then((result) => {
                                                                        if (result.isConfirmed) {
                                                                            // Jika user tetap ingin menghapus, munculkan konfirmasi kedua
                                                                            Swal.fire({
                                                                                title: 'Konfirmasi Akhir',
                                                                                text: "Data Guru akan dihapus secara permanen! Anda benar-benar yakin?",
                                                                                icon: 'error',
                                                                                showCancelButton: true,
                                                                                confirmButtonColor: '#d33',
                                                                                cancelButtonColor: '#3085d6',
                                                                                confirmButtonText: 'Ya, hapus!',
                                                                                cancelButtonText: 'Batal'
                                                                            }).then((finalResult) => {
                                                                                if (finalResult.isConfirmed) {
                                                                                    form.submit();
                                                                                }
                                                                            });
                                                                        }
                                                                    });
                                                                } else {
                                                                    // Jika bukan admin, langsung konfirmasi biasa
                                                                    Swal.fire({
                                                                        title: 'Apakah Anda yakin?',
                                                                        text: "Data Guru ini akan dihapus secara permanen!",
                                                                        icon: 'warning',
                                                                        showCancelButton: true,
                                                                        confirmButtonColor: '#d33',
                                                                        cancelButtonColor: '#3085d6',
                                                                        confirmButtonText: 'Ya, hapus!',
                                                                        cancelButtonText: 'Batal'
                                                                    }).then((result) => {
                                                                        if (result.isConfirmed) {
                                                                            form.submit();
                                                                        }
                                                                    });
                                                                }
                                                            });
                                                        });
                                                    </script>
                                                </form>
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
