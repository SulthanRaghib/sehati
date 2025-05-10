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
                    <h3>Data Agama</h3>

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
                        <p class="text-subtitle text-muted">Manage Data Agama</p>
                        <a href="{{ route('admin.agama.create') }}" class="btn btn-primary">Add Agama</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if ($agama->count() == 0)
                            <div class="alert alert-info">
                                Data Agama belum ada. Silahkan tambahkan data agama baru.
                            </div>
                        @else
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th class="col-1">No</th>
                                        <th>Nama Agama</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agama as $a)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $a->nama }}</td>
                                            <td>
                                                <a href="{{ route('admin.agama.edit', $a->id) }}"
                                                    class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('admin.agama.destroy', $a->id) }}" method="POST"
                                                    class="d-inline form-delete">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button" class="btn btn-sm btn-danger btn-delete"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Hapus Agama">
                                                        <i class="bi bi-trash"></i>
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
                                                                    text: "Data Agama ini akan dihapus secara permanen!",
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
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
