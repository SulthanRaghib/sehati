@extends('home')
@section('main-content')
    <!-- Services Section -->
    <section id="services" class="services section">
        <!-- Section Title -->
        <div class="pt-3">
            <div class="container section-title pt-5 pb-3" data-aos="fade-up">
                <h2>Dashboard</h2>
            </div>
        </div>
        <!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row g-4">
                <!-- Stats Section untuk Siswa Login -->
                <div class="card shadow-sm">
                    <section id="stats" class="stats" style="background: none;">
                        <div class="container" data-aos="fade-up" data-aos-delay="100">
                            <div class="row gy-4">

                                <!-- Total Konseling oleh Siswa Ini -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="stats-item text-center w-100 h-100">
                                        <span data-purecounter-start="0" data-purecounter-end="{{ $myKonselingCount }}"
                                            data-purecounter-duration="1" class="purecounter"></span>
                                        <p>Konseling Saya</p>
                                    </div>
                                </div>

                                <!-- Konseling yang Masih Diproses -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="stats-item text-center w-100 h-100">
                                        <span data-purecounter-start="0" data-purecounter-end="{{ $myKonselingProses }}"
                                            data-purecounter-duration="1" class="purecounter"></span>
                                        <p>Sedang Diproses</p>
                                    </div>
                                </div>

                                <!-- Konseling Selesai -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="stats-item text-center w-100 h-100">
                                        <span data-purecounter-start="0" data-purecounter-end="{{ $myKonselingSelesai }}"
                                            data-purecounter-duration="1" class="purecounter"></span>
                                        <p>Sudah Selesai</p>
                                    </div>
                                </div>

                                <!-- Rating yang Sudah Diberikan -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="stats-item text-center w-100 h-100">
                                        <span data-purecounter-start="0" data-purecounter-end="{{ $myRatingCount }}"
                                            data-purecounter-duration="1" class="purecounter"></span>
                                        <p>Penilaian Saya</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <div class="row">
                <!-- Grafik -->
                <div class="card shadow-sm mt-5">
                    <div class="card-body">
                        <h5 class="card-title text-center">Aktivitas Konseling per Bulan</h5>
                        <canvas id="grafikKonselingSiswa" style="height: 40vh; width: 100%;"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('grafikKonselingSiswa');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($bulanLabels) !!}, // Contoh: ['Jan', 'Feb', ...]
                datasets: [{
                    label: 'Jumlah Konseling Saya',
                    data: {!! json_encode($jumlahPerBulan) !!},
                    backgroundColor: '#36b9cc',
                    borderRadius: 10,
                }]
            },
            options: {
                responsive: true,
                animation: {
                    duration: 800,
                    easing: 'easeOutQuart'
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: 2, // Tambahan di sini
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        }
                    }
                },
            }
        });
    </script>
@endpush
