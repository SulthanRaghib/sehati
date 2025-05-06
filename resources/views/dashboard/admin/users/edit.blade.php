@extends('dashboard')
@section('content')
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
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Edit User</h4>
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-warning" id="cancel">Batal</a>
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
                            action="{{ route('admin.users.update', $user->id) }}">
                            @method('PUT')
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Nama</label>
                                                        <input type="text"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            id="name" placeholder="Nama" name="name"
                                                            value="{{ $user->name }}">
                                                        @error('name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            id="email" placeholder="Email" name="email"
                                                            value="{{ $user->email }}">
                                                        @error('email')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="role">Role</label>
                                                        <select class="form-control @error('role') is-invalid @enderror"
                                                            id="role" name="role">
                                                            <option value="">-- Pilih Role --</option>
                                                            <option value="admin"
                                                                {{ $user->role == 'admin' ? 'selected' : '' }}>
                                                                Admin</option>
                                                            <option value="gurubk"
                                                                {{ $user->role == 'gurubk' ? 'selected' : '' }}>
                                                                Guru BK</option>
                                                            <option value="siswa"
                                                                {{ $user->role == 'siswa' ? 'selected' : '' }}>
                                                                Siswa</option>
                                                        </select>
                                                        @error('role')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="userable_type">Tipe Pemilik User</label>
                                                        <select class="form-control" id="userable_type"
                                                            name="userable_type">
                                                            <option value="">-- Pilih Tipe Pemilik --</option>
                                                            <option value="App\Models\Guru"
                                                                {{ $user->userable_type == 'App\Models\Guru' ? 'selected' : '' }}>
                                                                Guru</option>
                                                            <option value="App\Models\Siswa"
                                                                {{ $user->userable_type == 'App\Models\Siswa' ? 'selected' : '' }}>
                                                                Siswa</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="userable_id">Pemilik User</label>
                                                        <select
                                                            class="form-control @error('userable_id') is-invalid @enderror"
                                                            id="userable_id" name="userable_id">
                                                            <option value="">-- Pilih Pemilik User --</option>

                                                            {{-- Data Guru --}}
                                                            @foreach ($guru as $g)
                                                                <option value="{{ $g->id }}" class="guru-option"
                                                                    {{ $user->userable_type == 'App\Models\Guru' && $user->userable_id == $g->id ? 'selected' : '' }}>
                                                                    {{ $g->nama }}
                                                                </option>
                                                            @endforeach

                                                            {{-- Data Siswa --}}
                                                            @foreach ($siswa as $s)
                                                                <option value="{{ $s->id }}" class="siswa-option"
                                                                    {{ $user->userable_type == 'App\Models\Siswa' && $user->userable_id == $s->id ? 'selected' : '' }}>
                                                                    {{ $s->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('userable_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <script>
                                                    document.addEventListener("DOMContentLoaded", function() {
                                                        let userableTypeSelect = document.getElementById("userable_type");
                                                        let userableIdSelect = document.getElementById("userable_id");

                                                        function updateUserableOptions() {
                                                            let selectedType = userableTypeSelect.value;

                                                            // Sembunyikan semua opsi terlebih dahulu
                                                            document.querySelectorAll("#userable_id option").forEach(option => {
                                                                option.style.display = "none";
                                                            });

                                                            // Tampilkan opsi sesuai tipe yang dipilih
                                                            if (selectedType === "App\\Models\\Guru") {
                                                                document.querySelectorAll(".guru-option").forEach(option => {
                                                                    option.style.display = "block";
                                                                });
                                                            } else if (selectedType === "App\\Models\\Siswa") {
                                                                document.querySelectorAll(".siswa-option").forEach(option => {
                                                                    option.style.display = "block";
                                                                });
                                                            }

                                                            // Reset nilai userable_id jika tidak sesuai
                                                            if (userableIdSelect.querySelector("option[selected]")) {
                                                                let selectedOption = userableIdSelect.querySelector("option[selected]");
                                                                if (selectedOption.style.display === "none") {
                                                                    userableIdSelect.value = "";
                                                                }
                                                            }
                                                        }

                                                        userableTypeSelect.addEventListener("change", updateUserableOptions);
                                                        updateUserableOptions(); // Panggil saat halaman dimuat
                                                    });
                                                </script>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">
                                        Update User
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
