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
                    <h3>Data Artikel</h3>

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
                        <p class="text-subtitle text-muted">Manage Data Artikel</p>
                        <a href="{{ route('artikel.create') }}" class="btn btn-primary">Add Artikel</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if ($artikel->count() == 0)
                            <div class="alert alert-info">
                                <strong>Data Kosong!</strong> Data Artikel belum ada. Silahkan tambahkan data artikel baru.
                            </div>
                        @else
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th class="col-1">No</th>
                                        <th>Kategori Artikel</th>
                                        <th>Judul</th>
                                        <th>Tanggal Dibuat</th>
                                        <th class="col-1">Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($artikel as $a)
                                        <tr>
                                            {{-- @dd($a) --}}
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $a->artikelKategori->nama }}</td>
                                            <td>{{ $a->judul }}</td>
                                            @php
                                                $date = \Carbon\Carbon::parse($a->tanggal_terbit);
                                                $formattedDate = $date->translatedFormat('l, d F Y');
                                            @endphp
                                            <td>{{ $formattedDate }}</td>
                                            <td>
                                                @if ($a->status == 'draft')
                                                    <span class="badge bg-warning">Draft</span>
                                                @elseif($a->status == 'publish')
                                                    <span class="badge bg-success">Publish</span>
                                                @else
                                                    <span class="badge bg-danger">Unpublish</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('artikel.show', $a->id) }}"
                                                    class="btn btn-sm btn-info">Detail</a>
                                                <a href="{{ route('artikel.edit', $a->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('artikel.destroy', $a->id) }}" method="POST"
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
                                                                    text: "Data Artikel ini akan dihapus secara permanen!",
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
