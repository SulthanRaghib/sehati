@extends('dashboard')
@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Pekerjaan</h3>

                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.pekerjaan') }}">Pekerjaan</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $title }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header  pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Edit Pekerjaan</h4>
                        <a href="{{ route('admin.pekerjaan') }}" class="btn btn-outline-warning" id="cancel">Batal</a>
                        <script>
                            document.getElementById('cancel').addEventListener('click', function(e) {
                                e.preventDefault();
                                Swal.fire({
                                    title: 'Apakah Anda Yakin ? ',
                                    text: "Anda akan kehilangan data yang sudah diinput!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#FDAC41',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ya, Lanjutkan!',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location = this.href;
                                    }
                                })
                            });
                        </script>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" method="POST"
                            action="{{ route('admin.pekerjaan.update', $pekerjaan->id) }}">
                            @method('put')
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="nama">Nama Pekerjaan</label>
                                                <input type="text" id="nama"
                                                    class="form-control @error('nama') is-invalid @enderror" name="nama"
                                                    placeholder="Nama Pekerjaan" value="{{ $pekerjaan->nama }}">
                                                @error('nama')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Submit
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
