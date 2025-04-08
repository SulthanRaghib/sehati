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
                        @endif
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
                                        @php
                                            if ($a->tingkat == '10') {
                                                $kelas = '1 SMA';
                                            } elseif ($a->tingkat == '11') {
                                                $kelas = '2 SMA';
                                            } elseif ($a->tingkat == '12') {
                                                $kelas = '3 SMA';
                                            } else {
                                                $kelas = 'Tidak Diketahui';
                                            }
                                        @endphp
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $a->tingkat }} ({{ $kelas }})</td>
                                        <td>
                                            <a href="{{ route('admin.kelas.edit', $a->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('admin.kelas.destroy', $a->id) }}" method="POST"
                                                class="d-inline form-delete">
                                                @csrf
                                                @method('delete')
                                                <button type="button"
                                                    class="btn btn-sm btn-danger btn-delete">Delete</button>

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
                                                                text: "Data Kelas ini akan dihapus secara permanen!",
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
    </div>
@endsection
