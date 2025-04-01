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
                    <h3>Data Users</h3>

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
                        <p class="text-subtitle text-muted">Manage Data Users</p>
                        @if (Auth::user()->role == 'admin')
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add User</a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th class="col-1">No</th>
                                <th>Pemilik User</th>
                                <th>Email</th>
                                <th>Role</th>
                                @if (Auth::user()->role == 'admin')
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $u)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $u->userable->nama }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>{{ ucfirst($u->role) }}</td>
                                    @if (Auth::user()->role == 'admin')
                                        <td>
                                            <a href="{{ route('admin.users.edit', $u->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="post"
                                                class="d-inline form-delete">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-sm btn-danger btn-delete"
                                                    data-role="{{ $u->role ?? '' }}">Delete</button>

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
                                                                    text: "User ini memiliki role admin. Anda yakin ingin menghapusnya?",
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
                                                                            text: "Data User akan dihapus secara permanen! Anda benar-benar yakin?",
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
                                                                    text: "Data User ini akan dihapus secara permanen!",
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
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
