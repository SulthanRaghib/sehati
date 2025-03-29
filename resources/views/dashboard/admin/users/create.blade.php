@extends('dashboard')
@section('content')
    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

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
                                <a href="{{ route('admin.users') }}">Users</a>
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
                        <h4 class="card-title">Tambah User</h4>
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-warning" id="kembali">Kembali</a>
                        <script>
                            document.getElementById('kembali').addEventListener('click', function(e) {
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
                        <form class="form form-vertical" method="POST" action="{{ route('admin.users.store') }}">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                                    placeholder="Name" name="name" value="{{ old('name') }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email address</label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                                    placeholder="Email" name="email" value="{{ old('email') }}">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="password" placeholder="Password" name="password">
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="role">Role</label>
                                                <select class="form-control @error('role') is-invalid @enderror"
                                                    id="role" name="role">
                                                    <option value="">-- Pilih Role --</option>
                                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                                        Admin</option>
                                                    <option value="gurubk" {{ old('role') == 'gurubk' ? 'selected' : '' }}>
                                                        Guru BK</option>
                                                    <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>
                                                        Siswa</option>
                                                </select>
                                                @error('role')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="userable_id" class="form-label">Pilih Data</label>
                                                <select
                                                    class="form-control select-search @error('userable_id') is-invalid @enderror"
                                                    id="userable_id" name="userable_id">
                                                    <option value="">-- Pilih Guru atau Siswa --</option>
                                                    @foreach ($guru as $g)
                                                        <option value="{{ $g->id }}" data-type="App\Models\Guru"
                                                            {{ old('userable_id') == $g->id ? 'selected' : '' }}>
                                                            {{ $g->nama }} - Guru</option>
                                                    @endforeach
                                                    @foreach ($siswa as $s)
                                                        <option value="{{ $s->id }}" data-type="App\Models\Siswa"
                                                            {{ old('userable_id') == $s->id ? 'selected' : '' }}>
                                                            {{ $s->nama }} - Siswa</option>
                                                    @endforeach
                                                </select>
                                                @error('userable_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                                <input type="hidden" name="userable_type" id="userable_type">
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                Submit
                                            </button>
                                            <button type="reset" class="btn btn-light-secondary mr-1 mb-1">
                                                Reset
                                            </button>
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
    <script>
        $(document).ready(function() {
            // Aktifkan Select2
            $('#userable_id').select2({
                placeholder: "-- Pilih Guru atau Siswa --",
                allowClear: true,
                width: '100%',
            });

            // Update userable_type saat user memilih
            $('#userable_id').on('change', function() {
                let selectedOption = $(this).find(':selected');
                let type = selectedOption.data('type') || '';
                $('#userable_type').val(type);
            });

            // Override padding setelah Select2 diinisialisasi
            $('.select2-selection').css({
                'display': 'block',
                'width': '100%',
                'min - height': 'calc(1.5 em + 0.934 rem + 2 px)',
                'padding': '0.467 rem 0.6 rem',
                'font - size': '0.855 rem',
                'font - weight': '400',
                'line - height': '1.5',
                'color': '#555252',
                'background-color': 'white',
                'background-clip': 'padding-box',
                'border': '1px solid #DFE3E7',
                'appearance': 'none',
                'border - radius': '0.25 rem',
                'transition': 'border - color 0.15 s ease - in - out, box - shadow 0.15 s ease - in - out'
            });

            // Set nilai awal saat halaman dimuat
            $('#userable_id').trigger('change');
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const userableSelect = document.getElementById("userable_id");
            const userableTypeInput = document.getElementById("userable_type");

            // Fungsi untuk mengisi userable_type berdasarkan pilihan
            function updateUserableType() {
                const selectedOption = userableSelect.options[userableSelect.selectedIndex];
                const type = selectedOption.getAttribute("data-type") || "";
                userableTypeInput.value = type;
            }

            // Panggil fungsi saat halaman dimuat
            updateUserableType();

            // Jalankan fungsi saat pilihan diubah
            userableSelect.addEventListener("change", updateUserableType);
        });
    </script>
@endsection
