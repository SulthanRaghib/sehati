@extends('home')
@section('main-content')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
            });
        </script>
    @elseif (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
            });
        </script>
    @elseif (session('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: '{{ session('warning') }}',
            });
        </script>
    @endif

    <!-- Services Section -->
    <section id="services" class="services section">
        <!-- Section Title -->
        <div class="pt-3">
            <div class="container section-title pt-5 pb-3" data-aos="fade-up">
                <h2>Profile</h2>
            </div>
        </div>
        <!-- End Section Title -->

        <div class="container">
            @php
                $onlyFotoIncomplete = count($missingFields) === 1 && in_array('Foto', $missingFields);
            @endphp

            @if (!$siswa->is_completed)
                <div class="alert alert-warning">
                    <strong>Data Anda belum lengkap.</strong>

                    @if ($onlyFotoIncomplete)
                        Silakan unggah foto Anda dengan menekan ikon <i class="bi bi-pencil-fill text-primary"></i> <a
                            href="{{ route('siswa.profile.show') }}">di sini</a>, di atas
                        foto profil Anda.
                    @else
                        Silakan lengkapi <a href="{{ route('siswa.profile.edit') }}">di sini</a>.
                    @endif

                    @if (!$onlyFotoIncomplete)
                        <br>
                        <small><strong>Field yang belum diisi:</strong></small>
                        <ul class="mb-0">
                            @foreach ($missingFields as $field)
                                <li>{{ $field }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif


            <!-- Tabs -->
            <div class="d-flex flex-column align-items-center">
                <ul class="nav nav-pills" id="profileTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('siswa.profile.show') ? 'active' : '' }}"
                            href="{{ route('siswa.profile.show') }}">Preview Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('siswa.profile.edit') ? 'active' : '' }}"
                            href="{{ route('siswa.profile.edit') }}">Edit Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('siswa.profile.newPassword') ? 'active' : '' }}"
                            href="{{ route('siswa.profile.newPassword') }}">New Password</a>
                    </li>
                </ul>
            </div>


            <!-- Tab Content -->
            <div class="tab-content p-4 border" id="profileTabContent">

                @if (Route::is('siswa.profile.show'))
                    @include('frontend.profile.view')
                @elseif (Route::is('siswa.profile.edit'))
                    @include('frontend.profile.edit')
                @elseif (Route::is('siswa.profile.newPassword'))
                    @include('frontend.profile.edit_password')
                @endif

            </div>
        </div>
        <!-- End Tab Content -->
    </section>
    <!-- End Services Section -->
@endsection
