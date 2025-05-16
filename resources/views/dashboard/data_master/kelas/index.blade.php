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
                    <h3>Data Kelas</h3>

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
                        <p class="text-subtitle text-muted">Manage Data Kelas</p>
                        <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary">Add Kelas</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if ($kelas->count() == 0)
                            <div class="alert alert-info">
                                Data Kelas belum ada. Silahkan tambahkan data kelas baru.
                            </div>
                        @else
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th class="col-1">No</th>
                                        <th>Tingkat Kelas</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kelas as $a)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $a->tingkat }}</td>
                                            <td>
                                                <a href="{{ route('admin.kelas.edit', $a->id) }}"
                                                    class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Edit Kelas"><i
                                                        data-feather="edit"></i></a>
                                                <form action="{{ route('admin.kelas.destroy', $a->id) }}" method="POST"
                                                    class="d-inline form-delete">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button" class="btn btn-sm btn-danger btn-delete"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Hapus Kelas"><i data-feather="trash"></i></button>

                                                    <script>
                                                        document.querySelectorAll('.btn-delete').forEach(button => {
                                                            button.addEventListener('click', function(e) {
                                                                e.preventDefault(); // Mencegah form langsung terkirim

                                                                const form = this.closest('.form-delete');

                                                                // Konfirmasi Pertama
                                                                Swal.fire({
                                                                    title: 'Yakin ingin menghapus?',
                                                                    text: "Menghapus KELAS ini juga akan menghapus SEMUA SISWA yang terkait!",
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
