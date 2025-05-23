@extends('dashboard')
@section('content')
    @push('styles')
        <style>
            #isi_konseling {
                white-space: pre-wrap;
            }
        </style>
    @endpush
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Balas Pesan Konseling</h3>

                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.konseling') }}">Konseling</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $title }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title" style="font-size: 15px">
                            Mohon berikan balasan yang sesuai dengan judul dan isi pesan konseling
                        </h4>
                        <a href="{{ route('admin.konseling') }}" class="btn btn-outline-warning" id="cancel">Batal</a>
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
                <div class="card-body">
                    {{-- Informasi Siswa --}}
                    <div class="mb-4 p-3 border-start border-4 border-primary rounded shadow-sm bg-white">
                        <h5 class="mb-3 text-primary fw-semibold">📌 Informasi Konseling</h5>
                        <div class="row">
                            <table class="align-middle mx-3">
                                <tr>
                                    <td class="fw-semibold" style="width: 13%">Nama Siswa</td>
                                    <td style="width: 1%">:</td>
                                    <td style="width: 33%">{{ $jawaban->konseling->siswa->nama }}</td>

                                    <td class="fw-semibold" style="width: 13%">NISN</td>
                                    <td style="width: 1%">:</td>
                                    <td>{{ $jawaban->konseling->siswa->nisn }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Kelas</td>
                                    <td>:</td>
                                    <td>{{ $jawaban->konseling->siswa->kelas->tingkat }}</td>

                                    <td class="fw-semibold">Tanggal Konseling</td>
                                    <td>:</td>
                                    <td>{{ \Carbon\Carbon::parse($jawaban->konseling->tanggal_konseling)->translatedFormat('d F Y, H:i') }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>


                    <form action="{{ route('admin.konseling.update', $jawaban->konseling->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="konseling_id" value="{{ $jawaban->konseling->id }}">
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul"
                                value="{{ $jawaban->konseling->judul }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="isi_konseling">Pesan Konseling</label>
                            <textarea class="form-control" id="isi_konseling" name="isi_konseling" readonly style="overflow:hidden; resize:none;">{{ $jawaban->konseling->isi_konseling }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="isi_jawaban">Balas Pesan</label>
                            <textarea class="form-control @error('isi_jawaban') is-invalid @enderror" id="isi_jawaban" name="isi_jawaban"
                                placeholder="Balas Pesan Konseling" style="resize: none;">{{ old('isi_jawaban', $jawaban->isi_jawaban) }}</textarea>
                            @error('isi_jawaban')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Update Jawaban</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const textarea = document.getElementById('isi_konseling');
            textarea.style.height = 'auto'; // Reset height
            textarea.style.height = textarea.scrollHeight + 'px'; // Set sesuai konten
        });
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#isi_jawaban'), {
                toolbar: {
                    items: [
                        'undo', 'redo', '|',
                        'heading', '|',
                        'bold', 'italic', 'underline', 'strikethrough', 'highlight', '|',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                        'alignment', '|',
                        'link', 'blockQuote', '|',
                        'numberedList', 'bulletedList', '|',
                        'outdent', 'indent', '|',
                        'codeBlock', 'removeFormat'
                    ]
                },
                language: 'id',
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
