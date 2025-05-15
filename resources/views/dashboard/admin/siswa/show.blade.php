@extends('dashboard')
@section('content')
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
                                <a href="{{ route('admin.siswa') }}">Siswa</a>
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
                                <h4 class="card-title">Detail Siswa</h4>
                                <div>
                                    <a href="{{ route('admin.siswa') }}" class="btn btn-outline-primary">Kembali</a>
                                    <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="btn btn-warning">Edit</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-pane fade show active" id="preview" role="tabpanel">
                                <div class="row">
                                    <!-- Sidebar Identitas Siswa -->
                                    <div class="col-md-4">
                                        <div class="card shadow-sm mb-4">
                                            <div class="card-body text-center position-relative">
                                                <div class="position-relative d-inline-block">
                                                    @if ($siswa->avatar)
                                                        <img src="{{ asset('storage/' . $siswa->avatar) }}"
                                                            class="rounded-circle img-thumbnail mb-3" width="150"
                                                            height="150" alt="Avatar Siswa" style="object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('mine/img/user_default.png') }}"
                                                            class="rounded-circle img-thumbnail mb-3" width="150"
                                                            height="150" alt="Avatar Default">
                                                    @endif
                                                </div>

                                                <h5 class="mb-1">{!! $siswa->nama ?? '<span class="text-danger">Nama belum diisi</span>' !!}</h5>
                                                <p class="text-muted mb-1">NISN: {!! $siswa->nisn ?? '<span class="text-danger">NISN belum diisi</span>' !!}</p>
                                                <span class="badge bg-primary d-inline-block mb-2">
                                                    {!! $siswa->user->email ?? '<span class="text-danger">Email belum diisi</span>' !!}
                                                </span>
                                                <p class="text-muted mb-0">
                                                    Tahun Akademik:
                                                    {!! $siswa->tahunAkademik->periode ?? '<span class="text-danger">Tahun Akademik tidak tersedia</span>' !!}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Detail Biodata Siswa -->
                                    <div class="col-md-8">
                                        <div class="card shadow-sm">
                                            <div class="card-header border-bottom d-flex justify-content-between mb-3">
                                                <ul class="nav nav-tabs card-header-tabs" id="profileTabs" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="details-tab" data-bs-toggle="tab"
                                                            href="#details" role="tab" aria-controls="details"
                                                            aria-selected="true">
                                                            Biodata Siswa
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="ayah-tab" data-bs-toggle="tab"
                                                            href="#ayah" role="tab" aria-controls="ayah"
                                                            aria-selected="false">
                                                            Data Ayah
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="ibu-tab" data-bs-toggle="tab"
                                                            href="#ibu" role="tab" aria-controls="ibu"
                                                            aria-selected="false">
                                                            Data Ibu
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="card-body tab-content">
                                                <!-- Biodata Siswa -->
                                                <div class="tab-pane fade show active" id="details" role="tabpanel"
                                                    aria-labelledby="details-tab">
                                                    <table class="table table-sm table-borderless">
                                                        <tr>
                                                            <th width="30%">Nama</th>
                                                            <td>: {!! $siswa->nama ?? '<span class="text-danger m-0">Nama belum diisi</span>' !!}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>NISN</th>
                                                            <td>: {!! $siswa->nisn ?? '<span class="text-danger m-0">NISN belum diisi</span>' !!}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Kelas</th>
                                                            <td>: {!! $siswa->kelas->tingkat ?? '<span class="text-danger m-0">Kelas belum diisi</span>' !!}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Tempat, Tanggal Lahir</th>
                                                            <td>: {!! $siswa->tempat_lahir ?? '<span class="text-danger m-0">Tempat lahir belum diisi</span>' !!}, {!! $siswa->tanggal_lahir ?? '<span class="text-danger m-0">Tanggal lahir belum diisi</span>' !!}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Jenis Kelamin</th>
                                                            <td>: {!! $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' !!}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Agama</th>
                                                            <td>: {!! $siswa->agama->nama ?? '<span class="text-danger m-0">Agama belum diisi</span>' !!}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Alamat</th>
                                                            <td>: {!! $siswa->alamat ?? '<span class="text-danger m-0">Alamat belum diisi</span>' !!}</td>
                                                        </tr>
                                                    </table>
                                                </div>

                                                <!-- Data Ayah -->
                                                <div class="tab-pane fade" id="ayah" role="tabpanel"
                                                    aria-labelledby="ayah-tab">
                                                    <table class="table table-borderless table-sm">
                                                        <tr>
                                                            <th width="30%">NIK Ayah</th>
                                                            <td>: {!! $siswa->nik_ayah ?? '<span class="text-danger m-0">NIK Ayah belum diisi</span>' !!}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Nama Ayah</th>
                                                            <td>: {!! $siswa->nama_ayah ?? '<span class="text-danger m-0">Nama Ayah belum diisi</span>' !!}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Tempat, Tanggal Lahir Ayah</th>
                                                            <td>: {!! $siswa->tempat_lahir_ayah ?? '<span class="text-danger m-0">Tempat lahir Ayah belum diisi</span>' !!}, {!! $siswa->tanggal_lahir_ayah ?? '<span class="text-danger m-0">Tanggal lahir Ayah belum diisi</span>' !!}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Pekerjaan Ayah</th>
                                                            <td>: {!! $siswa->pekerjaanAyah->nama ?? '<span class="text-danger m-0">Pekerjaan Ayah belum diisi</span>' !!}</td>
                                                        </tr>
                                                    </table>
                                                </div>

                                                <!-- Data Ibu -->
                                                <div class="tab-pane fade" id="ibu" role="tabpanel"
                                                    aria-labelledby="ibu-tab">
                                                    <table class="table table-borderless table-sm">
                                                        <tr>
                                                            <th width="30%">NIK Ibu</th>
                                                            <td>: {!! $siswa->nik_ibu ?? '<span class="text-danger m-0">NIK Ibu belum diisi</span>' !!}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Nama Ibu</th>
                                                            <td>: {!! $siswa->nama_ibu ?? '<span class="text-danger m-0">Nama Ibu belum diisi</span>' !!}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Tempat, Tanggal Lahir Ibu</th>
                                                            <td>: {!! $siswa->tempat_lahir_ibu ?? '<span class="text-danger m-0">Tempat lahir Ibu belum diisi</span>' !!}, {!! $siswa->tanggal_lahir_ibu ?? '<span class="text-danger m-0">Tanggal lahir Ibu belum diisi</span>' !!}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Pekerjaan Ibu</th>
                                                            <td>: {!! $siswa->pekerjaanIbu->nama ?? '<span class="text-danger m-0">Pekerjaan Ibu belum diisi</span>' !!}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
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
