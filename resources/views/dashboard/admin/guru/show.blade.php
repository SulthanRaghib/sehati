@extends('dashboard')
@section('content')
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
                                <a href="{{ route('admin.guru') }}">Guru</a>
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title">{{ $guru->nama }}</h4>
                                <div>
                                    <a href="{{ route('admin.guru') }}" class="btn btn-outline-primary">Kembali</a>
                                    <a href="{{ route('admin.guru.edit', $guru->id) }}" class="btn btn-warning">Edit</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Sidebar Foto -->
                                <div class="col-md-4">
                                    <div class="card shadow-sm mb-4">
                                        <div class="card-body text-center">
                                            @if ($guru->foto)
                                                <img src="{{ asset('storage/img/guru/' . $guru->foto) }}"
                                                    class="rounded-circle img-thumbnail mb-3" alt="Foto Guru" width="150"
                                                    height="150">
                                            @else
                                                <img src="{{ asset('mine/img/user_default.png') }}"
                                                    class="rounded-circle img-thumbnail mb-3" alt="Foto Default"
                                                    width="150" height="150">
                                            @endif

                                            <h5 class="mb-0">{{ $guru->nama }}</h5>
                                            <p class="text-muted mb-1">{{ $guru->nip }}</p>
                                            <span class="badge bg-primary">
                                                <p class="text-white mb-0" style="font-size: 0.8rem">{!! $guru->user->email ?? '<span class="text-danger">Email belum diisi</span>' !!}
                                                </p>
                                            </span>
                                            <p class="text-muted">
                                                <small>{{ $guru->alamat ?? 'Alamat belum diisi' }}</small>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detail Informasi -->
                                <div class="col-md-8">
                                    <div class="card shadow-sm">
                                        <div class="card-header">
                                            <h3 class="mb-0" style="font-weight: bold;">Informasi Lengkap Guru</h3>
                                        </div>

                                        <hr class="mt-0">

                                        <div class="card-body">
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr>
                                                    <th style="width: 25%;">Nama Lengkap</th>
                                                    <td>: {{ $guru->nama }}</td>
                                                </tr>
                                                <tr>
                                                    <th>NIP</th>
                                                    <td>: {{ $guru->nip }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Tempat, Tanggal Lahir</th>
                                                    <td>: {{ $guru->tempat_lahir }},
                                                        {{ \Carbon\Carbon::parse($guru->tanggal_lahir)->format('d M Y') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Jenis Kelamin</th>
                                                    <td>: {{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Agama</th>
                                                    <td>: {!! $guru->agama->nama ?? '<span class="text-danger">Belum Diisi</span>' !!}</td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat</th>
                                                    <td>: {{ $guru->alamat }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Pendidikan Terakhir</th>
                                                    <td>: {!! $guru->pendidikanTerakhir->nama ?? '<span class="text-danger">Belum Diisi</span>' !!}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection
