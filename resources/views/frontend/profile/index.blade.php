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
            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Perhatian!</strong> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                </ul>
            </div>


            <!-- Tab Content -->
            <div class="tab-content p-4 border" id="profileTabContent">

                @if (Route::is('siswa.profile.show'))
                    @include('frontend.profile.view')
                @elseif (Route::is('siswa.profile.edit'))
                    @include('frontend.profile.edit')
                @endif

            </div>
        </div>
        <!-- End Tab Content -->
    </section>
    <!-- End Services Section -->
@endsection
