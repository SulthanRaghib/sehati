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
                <div class="card-header  pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Tambah User</h4>
                        <a href="{{ route('admin.users') }}" class="btn btn-primary">Kembali</a>
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
                                            @csrf
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" placeholder="Name"
                                                    name="name">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email address</label>
                                                <input type="email" class="form-control" id="email"
                                                    placeholder="Email" name="email">
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" id="password"
                                                    placeholder="Password" name="password">
                                            </div>
                                            <div class="form-group">
                                                <label for="role">Role</label>
                                                <select class="form-control" id="role" name="role">
                                                    <option value="">-- Pilih Role --</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="guru">Guru BK</option>
                                                    <option value="siswa">Siswa</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="userable_id" class="form-label">Pilih Data</label>
                                                <select class="form-control select-search" id="userable_id"
                                                    name="userable_id" required>
                                                    <option value="">-- Pilih Guru atau Siswa --</option>
                                                    @foreach ($guru as $g)
                                                        <option value="{{ $g->id }}" data-type="App\Models\Guru">
                                                            {{ $g->nama }}
                                                            - Guru</option>
                                                    @endforeach
                                                    @foreach ($siswa as $s)
                                                        <option value="{{ $s->id }}" data-type="App\Models\Siswa">
                                                            {{ $s->nama }}
                                                            - Siswa</option>
                                                    @endforeach
                                                </select>

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
@endsection
