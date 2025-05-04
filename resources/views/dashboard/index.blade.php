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
            <!-- Statistik Konseling -->
            <div class="col-md-3 d-flex align-items-stretch">
                <div class="card shadow-sm w-100">
                    <div class="card-header text-center bg-primary">
                        <h5 class="card-title text-white">Total Konseling</h5>
                    </div>
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <h1 class="text-primary">{{ $konselingCount }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex align-items-stretch">
                <div class="card shadow-sm w-100">
                    <div class="card-header text-center bg-success">
                        <h5 class="card-title text-white">Konselor Aktif</h5>
                    </div>
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <h1 class="text-success">{{ $guruCount }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex align-items-stretch">
                <div class="card shadow-sm w-100">
                    <div class="card-header text-center bg-info">
                        <h5 class="card-title text-white">Siswa Pernah Konseling</h5>
                    </div>
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <h1 class="text-info">{{ $siswaCount }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex align-items-stretch">
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
        </div>

        <div class="row">
            <div class="col-6">
                <!-- Grafik Konseling Bulanan -->
                <div class="card mt-4 shadow-sm border-0 rounded-4">
                    <div class="card-body px-4 py-4">

                        <!-- Judul -->
                        <h5 class="text-center fw-bold mb-4">
                            <i class="bi bi-graph-up-arrow me-2 text-primary"></i>
                            Grafik Konseling Bulanan
                            @if (request('bulan') && request('tahun'))
                                <span class="text-muted small d-block mt-1">
                                    {{ DateTime::createFromFormat('!m', request('bulan'))->format('F') }}
                                    {{ request('tahun') }}
                                </span>
                            @endif
                        </h5>

                        <!-- Form Filter -->
                        <form method="GET" action="{{ route('admin.dashboard') }}"
                            class="row g-3 justify-content-center mb-4">
                            <div class="d-flex justify-content-center align-items-end mb-3" style="gap: 1rem;">
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <label for="bulanSelect">Pilih Bulan</label>
                                        <select name="bulan" class="form-select" id="bulanSelect">
                                            <option value="">-- Semua Bulan --</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}" {{ $i == $bulan ? 'selected' : '' }}>
                                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <label for="tahunSelect">Pilih Tahun</label>
                                        <select name="tahun" class="form-select" id="tahunSelect">
                                            <option value="">-- Semua Tahun --</option>
                                            @for ($y = now()->year; $y >= 2020; $y--)
                                                <option value="{{ $y }}" {{ $y == $tahun ? 'selected' : '' }}>
                                                    {{ $y }}</option>
                                            @endfor
                                        </select>
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
        </div>

        <!-- Jadwal Hari Ini -->
        <div class="card mt-5 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Jadwal Konseling Hari Ini</h5>
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

        <!-- Feedback atau Notifikasi -->
        <div class="card mt-5 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Notifikasi Terbaru</h5>
                <ul class="list-group">
                    <li class="list-group-item">🆕 Dina mengajukan sesi konseling baru</li>
                    <li class="list-group-item">📝 Rizki memberi rating 4/5 pada sesi terakhir</li>
                    <li class="list-group-item">⚠️ Kasus bullying perlu ditindaklanjuti</li>
                </ul>
            </div>
        </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('grafikKonseling').getContext('2d');

        const data = {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Jumlah Konseling',
                data: {!! json_encode($chartData) !!},
                backgroundColor: '#4e73df',
                borderRadius: 6,
                barPercentage: 0.5, // lebar batang
                categoryPercentage: 1.2 // jarak antar batang
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
                    suggestedMax: Math.max(...{!! json_encode($chartData) !!}) + 1,
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
    </script>
@endpush
