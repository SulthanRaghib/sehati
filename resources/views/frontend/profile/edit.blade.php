<!-- Edit Tab -->
<div class="tab-pane fade show active" id="edit" role="tabpanel">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white fw-bold">
            Edit Profil Siswa
        </div>
        <div class="card-body">
            <form action="{{ route('siswa.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Data Siswa -->
                <fieldset class="border p-3 rounded mb-4">
                    <legend class="float-none w-auto px-3 mb-0 text-primary fw-bold">Data Siswa</legend>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="hidden" name="id" value="{{ $siswa->id }}">
                            <label>NISN</label>
                            <input type="text" name="nisn"
                                class="form-control @error('nisn') is-invalid @elseif(old('nisn')) is-valid @enderror"
                                value="{{ old('nisn', $siswa->nisn) }}">
                            @error('nisn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                @if (old('nisn'))
                                    <div class="valid-feedback">Looks good!</div>
                                @endif
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Nama</label>
                            <input type="text" name="nama"
                                class="form-control @error('nama') is-invalid @elseif(old('nama')) is-valid @enderror"
                                value="{{ old('nama', $siswa->nama) }}">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                @if (old('nama'))
                                    <div class="valid-feedback">Looks good!</div>
                                @endif
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempat_lahir"
                                class="form-control @error('tempat_lahir') is-invalid @elseif(old('tempat_lahir')) is-valid @enderror"
                                value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}">
                            @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                @if (old('tempat_lahir'))
                                    <div class="valid-feedback">Looks good!</div>
                                @endif
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir"
                                class="form-control @error('tanggal_lahir') is-invalid @elseif(old('tanggal_lahir')) is-valid @enderror"
                                value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                @if (old('tanggal_lahir'))
                                    <div class="valid-feedback">Looks good!</div>
                                @endif
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin"
                                class="form-control @error('jenis_kelamin') is-invalid @elseif(old('jenis_kelamin')) is-valid @enderror">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L"
                                    {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="P"
                                    {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                @if (old('jenis_kelamin'))
                                    <div class="valid-feedback">Looks good!</div>
                                @endif
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>No HP</label>
                            <input type="text" name="no_hp"
                                class="form-control @error('no_hp') is-invalid @elseif(old('no_hp')) is-valid @enderror"
                                value="{{ old('no_hp', $siswa->no_hp) }}">
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                @if (old('no_hp'))
                                    <div class="valid-feedback">Looks good!</div>
                                @endif
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat"
                                class="form-control @error('alamat') is-invalid @elseif(old('alamat')) is-valid @enderror">{{ old('alamat', $siswa->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                @if (old('alamat'))
                                    <div class="valid-feedback">Looks good!</div>
                                @endif
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Agama</label>
                            <select name="agama_id"
                                class="form-control @error('agama_id') is-invalid @elseif(old('agama_id')) is-valid @enderror">
                                <option value="">-- Pilih Agama --</option>
                                @foreach ($agama as $a)
                                    <option value="{{ $a->id }}"
                                        {{ old('agama_id', $siswa->agama_id) == $a->id ? 'selected' : '' }}>
                                        {{ $a->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('agama_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                @if (old('agama_id'))
                                    <div class="valid-feedback">Looks good!</div>
                                @endif
                            @enderror
                        </div>
                    </div>
                </fieldset>

                <fieldset class="border p-3 rounded mb-4">
                    <legend class="float-none w-auto px-3 mb-0 text-primary fw-bold">Data Ayah</legend>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>NIK Ayah</label>
                            <input type="text" name="nik_ayah"
                                class="form-control @error('nik_ayah') is-invalid @elseif(old('nik_ayah')) is-valid @enderror"
                                value="{{ old('nik_ayah', $siswa->nik_ayah) }}">
                            @error('nik_ayah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                @if (old('nik_ayah'))
                                    <div class="valid-feedback">Looks good!</div>
                                @endif
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Nama Ayah</label>
                            <input type="text" name="nama_ayah"
                                class="form-control @error('nama_ayah') is-invalid @elseif(old('nama_ayah')) is-valid @enderror"
                                value="{{ old('nama_ayah', $siswa->nama_ayah) }}">
                            @error('nama_ayah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                @if (old('nama_ayah'))
                                    <div class="valid-feedback">Looks good!</div>
                                @endif
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Tempat Lahir Ayah</label>
                            <input type="text" name="tempat_lahir_ayah"
                                class="form-control @error('tempat_lahir_ayah') is-invalid @elseif(old('tempat_lahir_ayah')) is-valid @enderror"
                                value="{{ old('tempat_lahir_ayah', $siswa->tempat_lahir_ayah) }}">
                            @error('tempat_lahir_ayah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                @if (old('tempat_lahir_ayah'))
                                    <div class="valid-feedback">Looks good!</div>
                                @endif
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Tanggal Lahir Ayah</label>
                            <input type="date" name="tanggal_lahir_ayah"
                                class="form-control @error('tanggal_lahir_ayah') is-invalid @elseif(old('tanggal_lahir_ayah')) is-valid @enderror"
                                value="{{ old('tanggal_lahir_ayah', $siswa->tanggal_lahir_ayah) }}">
                            @error('tanggal_lahir_ayah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                @if (old('tanggal_lahir_ayah'))
                                    <div class="valid-feedback">Looks good!</div>
                                @endif
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Pekerjaan Ayah</label>
                            <select name="pekerjaan_ayah_id"
                                class="form-control @error('pekerjaan_ayah_id') is-invalid @elseif(old('pekerjaan_ayah_id')) is-valid @enderror">
                                <option value="">-- Pilih Pekerjaan --</option>
                                @foreach ($pekerjaans as $pekerjaan)
                                    <option value="{{ $pekerjaan->id }}"
                                        {{ old('pekerjaan_ayah_id', $siswa->pekerjaan_ayah_id) == $pekerjaan->id ? 'selected' : '' }}>
                                        {{ $pekerjaan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pekerjaan_ayah_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                @if (old('pekerjaan_ayah_id'))
                                    <div class="valid-feedback">Looks good!</div>
                                @endif
                            @enderror
                        </div>
                    </div>
                </fieldset>

                <fieldset class="border p-3 rounded mb-4">
                    <legend class="float-none w-auto px-3 mb-0 text-primary fw-bold">Data Ibu</legend>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>NIK Ibu</label>
                            <input type="text" name="nik_ibu"
                                class="form-control @error('nik_ibu') is-invalid @elseif(old('nik_ibu')) is-valid @enderror"
                                value="{{ old('nik_ibu', $siswa->nik_ibu) }}">
                            @error('nik_ibu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                @if (old('nik_ibu'))
                                    <div class="valid-feedback">Looks good!</div>
                                @endif
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Nama Ibu</label>
                            <input type="text" name="nama_ibu"
                                class="form-control @error('nama_ibu') is-invalid @elseif(old('nama_ibu')) is-valid @enderror"
                                value="{{ old('nama_ibu', $siswa->nama_ibu) }}">
                            @error('nama_ibu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                @if (old('nama_ibu'))
                                    <div class="valid-feedback">Looks good!</div>
                                @endif
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Tempat Lahir Ibu</label>
                            <input type="text" name="tempat_lahir_ibu"
                                class="form-control @error('tempat_lahir_ibu') is-invalid @elseif(old('tempat_lahir_ibu')) is-valid @enderror"
                                value="{{ old('tempat_lahir_ibu', $siswa->tempat_lahir_ibu) }}">
                            @error('tempat_lahir_ibu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                @if (old('tempat_lahir_ibu'))
                                    <div class="valid-feedback">Looks good!</div>
                                @endif
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Tanggal Lahir Ibu</label>
                            <input type="date" name="tanggal_lahir_ibu"
                                class="form-control @error('tanggal_lahir_ibu') is-invalid @elseif(old('tanggal_lahir_ibu')) is-valid @enderror"
                                value="{{ old('tanggal_lahir_ibu', $siswa->tanggal_lahir_ibu) }}">
                            @error('tanggal_lahir_ibu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                @if (old('tanggal_lahir_ibu'))
                                    <div class="valid-feedback">Looks good!</div>
                                @endif
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Pekerjaan Ibu</label>
                            <select name="pekerjaan_ibu_id"
                                class="form-control @error('pekerjaan_ibu_id') is-invalid @elseif(old('pekerjaan_ibu_id')) is-valid @enderror">
                                <option value="">-- Pilih Pekerjaan --</option>
                                @foreach ($pekerjaans as $pekerjaan)
                                    <option value="{{ $pekerjaan->id }}"
                                        {{ old('pekerjaan_ibu_id', $siswa->pekerjaan_ibu_id) == $pekerjaan->id ? 'selected' : '' }}>
                                        {{ $pekerjaan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pekerjaan_ibu_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                @if (old('pekerjaan_ibu_id'))
                                    <div class="valid-feedback">Looks good!</div>
                                @endif
                            @enderror
                        </div>
                    </div>
                </fieldset>

                <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
<!-- End Edit Tab -->
