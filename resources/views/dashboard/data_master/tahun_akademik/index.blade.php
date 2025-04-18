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
                    <h3>Data Tahun Akademik</h3>

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
                        <p class="text-subtitle text-muted">Manage Data Tahun Akademik</p>
                        <a href="{{ route('admin.tahunAkademik.create') }}" class="btn btn-primary">Add Tahun Akademik</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if ($tahunAkademik->count() == 0)
                            <div class="alert alert-info">
                                Data Tahun Akademik belum ada. Silahkan tambahkan data tahun akademik baru.
                            </div>
                        @else
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th class="col-1">No</th>
                                        <th>Periode</th>
                                        <th>Semester</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tahunAkademik as $a)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $a->periode }}</td>
                                            <td>{{ $a->semester }}</td>
                                            <td>
                                                @if ($a->is_active)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                                @endif
                                            </td>
                                            </td>
                                            <td>
                                                @if (!$a->is_active)
                                                    <form action="{{ route('admin.setTahunAkademik', $a->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-primary">
                                                            Set Aktif
                                                        </button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-sm btn-success" disabled>Aktif</button>
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
