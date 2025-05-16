@extends('dashboard')
@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <h3>Welcome {{ Auth::user()->name }}</h3>
            <p class="text-subtitle text-muted">
                {{ $guru->nama }} - {{ $guru->nip }}
            </p>
        </div>
        <div class="row g-4">
            <!-- Total Konseling -->
            <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-stretch">
                <div class="card shadow-sm w-100">
                    <div class="card-header text-center bg-primary">
                        <h5 class="card-title text-white">Total Konseling</h5>
                    </div>
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <h1 class="text-primary pt-4">{{ $konselingCount }}</h1>
                    </div>
                </div>
            </div>

            <!-- Konseling Belum di Jawab -->
            <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-stretch">
                <div class="card shadow-sm w-100">
                    <div class="card-header text-center bg-danger">
                        <h5 class="card-title text-white">Konseling Belum di Jawab</h5>
                    </div>
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <h1 class="text-warning pt-4">{{ $konselingPending }}</h1>
                    </div>
                </div>
            </div>

            <!-- Siswa Pernah Konseling -->
            <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-stretch">
                <div class="card shadow-sm w-100">
                    <div class="card-header text-center bg-info">
                        <h5 class="card-title text-white">Siswa Pernah Konseling</h5>
                    </div>
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <h1 class="text-info pt-4">{{ $siswaKonselingCount }}</h1>
                    </div>
                </div>
            </div>

            <!-- Topik Populer -->
            <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-stretch">
                <div class="card shadow-sm w-100 d-flex flex-column">
                    <div class="card-header text-center bg-secondary">
                        <h5 class="card-title text-white">Topik Populer</h5>
                    </div>
                    <ul class="list-group list-group-flush flex-grow-1">
                        @forelse($topikPopuler as $topik => $jumlah)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ ucfirst($topik) }}</span>
                                <span class="badge bg-secondary">{{ $jumlah }}x</span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Belum ada data</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Konselor Aktif -->
            <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-stretch">
                <div class="card shadow-sm w-100">
                    <div class="card-header text-center bg-success">
                        <h5 class="card-title text-white">Konselor Aktif</h5>
                    </div>
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <h1 class="text-success pt-4">{{ $guruCount }}</h1>
                    </div>
                </div>
            </div>

            <!-- Total Siswa -->
            <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-stretch">
                <div class="card shadow-sm w-100">
                    <div class="card-header text-center bg-warning">
                        <h5 class="card-title text-white">Total Siswa</h5>
                    </div>
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <h1 class="text-warning pt-4">{{ $siswaCount }}</h1>
                    </div>
                </div>
            </div>

            <!-- Total Artikel Publish -->
            <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-stretch">
                <div class="card shadow-sm w-100">
                    <div class="card-header text-center bg-info">
                        <h5 class="card-title text-white">Total Artikel Publish</h5>
                    </div>
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <h1 class="text-info pt-4">{{ $artikelPublishCount }}</h1>
                    </div>
                </div>
            </div>

            <!-- Total Kategori Konseling -->
            <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-stretch">
                <div class="card shadow-sm w-100">
                    <div class="card-header text-center bg-secondary">
                        <h5 class="card-title text-white">Total Kategori Konseling</h5>
                    </div>
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <h1 class="text-secondary pt-4">{{ $kategoriKonselingCount }}</h1>
                    </div>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-md-12 col-lg-7">
                <!-- Grafik Konseling Bulanan -->
                <div class="card mt-4 shadow-sm border-0 rounded-4">
                    <div class="card-body px-4 py-4">

                        <!-- Judul -->
                        <h5 class="text-center fw-bold mb-4">
                            <i class="bi bi-graph-up-arrow me-2 text-primary"></i>
                            Grafik Konseling Bulanan
                            @if (request('blok_bulan') && request('blok_tahun'))
                                <span class="text-muted small d-block mt-1">
                                    {{ DateTime::createFromFormat('!m', request('blok_bulan'))->format('F') }}
                                    {{ request('blok_tahun') }}
                                </span>
                            @endif
                        </h5>

                        <!-- Form Filter Grafik Batang -->
                        @php
                            $selectedBulan = request()->has('blok_bulan') ? request('blok_bulan') : now()->month;
                            $selectedTahun = request()->has('blok_tahun') ? request('blok_tahun') : now()->year;
                        @endphp
                        <form method="GET" action="{{ route('admin.dashboard') }}"
                            class="row g-3 justify-content-center mb-4">
                            <div class="d-flex justify-content-center align-items-end mb-3" style="gap: 1rem;">
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <select name="blok_bulan" class="form-select" id="bulanSelect">
                                            <option value="" {{ $selectedBulan === '' ? 'selected' : '' }}>
                                                Semua
                                                Bulan</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}"
                                                    {{ (int) $selectedBulan === $i ? 'selected' : '' }}>
                                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                                </option>
                                            @endfor
                                        </select>
                                        <label for="bulanSelect">Pilih Bulan</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <select name="blok_tahun" class="form-select" id="tahunSelect">
                                            <option value="">Semua Tahun</option>
                                            @for ($y = now()->year; $y >= 2020; $y--)
                                                <option value="{{ $y }}"
                                                    {{ $y == $selectedTahun ? 'selected' : '' }}>
                                                    {{ $y }}
                                                </option>
                                            @endfor
                                        </select>
                                        <label for="tahunSelect">Pilih Tahun</label>
                                    </div>
                                </div>
                                <div class="col-md-2 d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-3">
                                        <i class="bi bi-filter-circle me-1"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </form>


                        <!-- Chart -->
                        <div class="chart-container" style="position: relative; height: 40vh; width: 100%;">
                            <canvas id="grafikKonseling"></canvas>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-5">
                <!-- Grafik Donat Konseling -->
                <div class="card mt-4 shadow-sm border-0 rounded-4">
                    <div class="card-body px-4 py-4">

                        <!-- Judul -->
                        <h5 class="text-center fw-bold mb-4">
                            <i class="bi bi-pie-chart-fill me-2 text-success"></i>
                            Siswa Paling Sering Konseling
                            @if (request('donat_bulan') && request('donat_tahun'))
                                <span class="text-muted small d-block mt-1">
                                    {{ DateTime::createFromFormat('!m', request('donat_bulan'))->format('F') }}
                                    {{ request('donat_tahun') }}
                                </span>
                            @endif
                        </h5>

                        <!-- Form Filter Grafik Donat -->
                        @php
                            $selectedDonatBulan = request()->has('donat_bulan') ? request('donat_bulan') : now()->month;
                            $selectedDonatTahun = request()->has('donat_tahun') ? request('donat_tahun') : now()->year;
                        @endphp
                        <form method="GET" action="{{ route('admin.dashboard') }}"
                            class="row g-3 justify-content-center mb-4">
                            <div class="d-flex justify-content-center align-items-end mb-3" style="gap: 1rem;">
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <select name="donat_bulan" class="form-select" id="bulanDonutSelect">
                                            <option value="" {{ $selectedDonatBulan === '' ? 'selected' : '' }}>
                                                Semua
                                                Bulan</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $i == $selectedDonatBulan ? 'selected' : '' }}>
                                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                                </option>
                                            @endfor
                                        </select>
                                        <label for="bulanDonutSelect">Pilih Bulan</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <select name="donat_tahun" class="form-select" id="tahunDonutSelect">
                                            <option value="" {{ $selectedDonatTahun === '' ? 'selected' : '' }}>
                                                Semua
                                                Tahun</option>
                                            @for ($y = now()->year; $y >= 2020; $y--)
                                                <option value="{{ $y }}"
                                                    {{ $y == $selectedDonatTahun ? 'selected' : '' }}>
                                                    {{ $y }}</option>
                                            @endfor
                                        </select>
                                        <label for="tahunDonutSelect">Pilih Tahun</label>
                                    </div>
                                </div>
                                <div class="col-md-2 d-grid">
                                    <button type="submit" class="btn btn-success btn-lg rounded-3">
                                        <i class="bi bi-filter-circle me-1"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Donut Chart -->
                        <div class="chart-container" style="position: relative; height: 40vh; width: 100%;">
                            <canvas id="donutChart"></canvas>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Jadwal Hari Ini -->
        {{-- <div class="card mt-5 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Jadwal Konseling Hari Ini</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Jam</th>
                                <th>Siswa</th>
                                <th>Konselor</th>
                                <th>Topik</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>08:00</td>
                                <td>Dina Sari</td>
                                <td>Bu Rani</td>
                                <td>Kecemasan</td>
                                <td><span class="badge bg-warning text-dark">Menunggu</span></td>
                            </tr>
                            <tr>
                                <td>10:00</td>
                                <td>Rizki</td>
                                <td>Pak Budi</td>
                                <td>Perundungan</td>
                                <td><span class="badge bg-success">Selesai</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}

        <!-- Feedback atau Notifikasi -->
        {{-- <div class="card mt-5 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Notifikasi Terbaru</h5>
                <ul class="list-group">
                    <li class="list-group-item">🆕 Dina mengajukan sesi konseling baru</li>
                    <li class="list-group-item">📝 Rizki memberi rating 4/5 pada sesi terakhir</li>
                    <li class="list-group-item">⚠️ Kasus bullying perlu ditindaklanjuti</li>
                </ul>
            </div>
        </div> --}}
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Grafik Konseling Bulanan
        const ctx = document.getElementById('grafikKonseling')?.getContext('2d');
        if (ctx) {
            const chartLabels = {!! json_encode($chartLabels) !!};
            const chartData = {!! json_encode($chartData) !!};

            const data = {
                labels: chartLabels,
                datasets: [{
                    label: 'Jumlah Konseling',
                    data: chartData,
                    backgroundColor: '#4e73df',
                    borderRadius: 6,
                    barPercentage: 0.5,
                    categoryPercentage: 1.2
                }]
            };

            const options = {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            title: function(tooltipItems) {
                                // Tampilkan label kategori sesuai index
                                return `${chartLabels[tooltipItems[0].dataIndex]}`;
                            },
                            label: function(tooltipItem) {
                                return `Jumlah Konseling: ${tooltipItem.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        offset: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            padding: 8
                        }
                    },
                    y: {
                        beginAtZero: true,
                        suggestedMax: Math.max(...chartData, 3) + 1,
                        ticks: {
                            stepSize: 1,
                            precision: 0,
                            padding: 8
                        },
                        grid: {
                            color: '#e9ecef',
                            borderDash: [4, 4]
                        }
                    }
                }
            };

            new Chart(ctx, {
                type: 'bar',
                data: data,
                options: options
            });
        }

        // Grafik Donat
        const donutCtx = document.getElementById('donutChart')?.getContext('2d');
        if (donutCtx) {
            const donutLabels = {!! json_encode($topSiswa->pluck('nama')) !!};
            const donutData = {!! json_encode($topSiswa->pluck('total')) !!};

            new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: donutLabels,
                    datasets: [{
                        data: donutData,
                        backgroundColor: [
                            '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                            '#858796', '#fd7e14', '#20c997', '#6610f2', '#6f42c1'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right'
                        },
                        title: {
                            display: true,
                            text: '10 Siswa Paling Aktif Konseling'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `${donutLabels[tooltipItem.dataIndex]}: ${tooltipItem.raw}x konseling`;
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>
@endpush
