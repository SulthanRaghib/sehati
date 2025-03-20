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
                                <h4 class="card-title">{{ $siswa->nama }}</h4>
                                <div>
                                    <a href="{{ route('admin.siswa') }}" class="btn btn-outline-primary">Kembali</a>
                                    <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="btn btn-warning">Edit</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td>NISN</td>
                                            <td>:</td>
                                            <td>{{ $siswa->nisn }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama</td>
                                            <td>:</td>
                                            <td>{{ $siswa->nama }}</td>
                                        </tr>
                                        @php
                                            $tingkat = $siswa->kelas->tingkat;
                                            if ($tingkat == 'X') {
                                                $kelas = 'Sepuluh';
                                            } elseif ($tingkat == 'XI') {
                                                $kelas = 'Sebelas';
                                            } else {
                                                $kelas = 'Dua Belas';
                                            }
                                        @endphp
                                        <tr>
                                            <td>Kelas</td>
                                            <td>:</td>
                                            <td>{{ $siswa->kelas->tingkat }} ({{ $kelas }}) </td>
                                        </tr>
                                        <tr>
                                            <td>Tempat, Tanggal Lahir</td>
                                            <td>:</td>
                                            <td>{{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jenis Kelamin</td>
                                            <td>:</td>
                                            <td>{{ $siswa->jenis_kelamin }}</td>
                                        </tr>
                                        <tr>
                                            <td>Agama</td>
                                            <td>:</td>
                                            <td>{{ $siswa->agama->nama }}</td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td>:</td>
                                            <td>{{ $siswa->alamat }}</td>
                                        </tr>
                                    </table>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Data Ayah</h5>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>NIK</td>
                                                <td>:</td>
                                                <td>{{ $siswa->nik_ayah }}</td>
                                            </tr>
                                            <tr>
                                                <td>Nama</td>
                                                <td>:</td>
                                                <td>{{ $siswa->nama_ayah }}</td>
                                            </tr>
                                            <tr>
                                                <td>Tempat, Tanggal Lahir</td>
                                                <td>:</td>
                                                <td>{{ $siswa->tempat_lahir_ayah }},
                                                    {{ $siswa->tanggal_lahir_ayah }}</td>
                                            </tr>
                                            <tr>
                                                <td>Pekerjaan Ayah</td>
                                                <td>:</td>
                                                <td>{{ $siswa->pekerjaanAyah->nama }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Data Ibu</h5>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>NIK</td>
                                                <td>:</td>
                                                <td>{{ $siswa->nik_ibu }}</td>
                                            </tr>
                                            <tr>
                                                <td>Nama</td>
                                                <td>:</td>
                                                <td>{{ $siswa->nama_ibu }}</td>
                                            </tr>
                                            <tr>
                                                <td>Tempat, Tanggal Lahir</td>
                                                <td>:</td>
                                                <td>{{ $siswa->tempat_lahir_ibu }},
                                                    {{ $siswa->tanggal_lahir_ibu }}</td>
                                            </tr>
                                            <tr>
                                                <td>Pekerjaan Ibu</td>
                                                <td>:</td>
                                                <td>{{ $siswa->pekerjaanIbu->nama }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection
