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
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-subtitle text-muted">Manage Data Siswa</p>
                        <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">Add Siswa</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th class="col-1">No</th>
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswa as $s)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $s->nisn }}</td>
                                    <td>{{ $s->nama }}</td>
                                    <td>{{ $s->alamat }}</td>
                                    <td>
                                        <a href="{{ route('admin.siswa.show', $s->id) }}"
                                            class="btn btn-sm btn-info">Detail</a>
                                        <a href="{{ route('admin.siswa.edit', $s->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="post"
                                            class="d-inline form-delete">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-sm btn-danger btn-delete">Delete</button>

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
                                                            text: "Data Siswa ini akan dihapus secara permanen!",
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
        </section>
    </div>
@endsection
