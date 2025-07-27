@extends('layout.tampil')

@section('konten')
    <style>
        /* Tetap seperti sebelumnya */
        .glass-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        }

        .icon-wrapper {
            font-size: 2.5rem;
            color: var(--card-color);
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
        }

        .glass-card:hover .icon-wrapper {
            transform: scale(1.1);
        }

        .content {
            text-align: center;
        }

        .content h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
            color: var(--card-color);
        }

        .content p {
            font-size: 1rem;
            font-weight: 500;
            margin: 0.5rem 0 0;
            color: #333;
        }

        .progress-bar-container {
            width: 100%;
            height: 8px;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            overflow: hidden;
            margin-top: 1rem;
        }

        .progress-bar {
            height: 100%;
            transition: width 0.5s ease;
        }
    </style>

    <div class="container py-5">
        {{-- Judul --}}
        <nav class="navbar-welcome mb-5" style="font-family: 'Poppins', sans-serif;">
            <h1 class="text-center fw-bold text-primary display-5 m-0">
                SELAMAT DATANG DI PERPUSTAKAAN SMPN 3 BESUKI
            </h1>
        </nav>

        {{-- Kartu Dashboard --}}
        <div class="row g-4 justify-content-center">
            @php
                $data = [
                    [
                        'count' => $jumlahAnggota ?? 0,
                        'text' => 'Data Anggota',
                        'icon' => 'id-badge',
                        'color' => '#28a745',
                        'route' => route('dataanggota.tampil1'),
                    ],
                    [
                        'count' => $jumlahBuku ?? 0,
                        'text' => 'Data Buku',
                        'icon' => 'book',
                        'color' => '#ffc107',
                        'route' => route('buku.tampil5'),
                    ],
                    [
                        'count' => $jumlahPengembalian ?? 0,
                        'text' => 'Total Pengembalian',
                        'icon' => 'undo-alt',
                        'color' => '#17a2b8',
                        'route' => route('pengembalian.tampil8'),
                    ],
                ];
            @endphp

            @foreach ($data as $item)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="{{ $item['route'] }}" class="glass-card" style="--card-color: {{ $item['color'] }};" tabindex="0"
                        aria-label="{{ $item['text'] }}: {{ $item['count'] }}">
                        <div class="icon-wrapper" aria-hidden="true">
                            <i class="fas fa-{{ $item['icon'] }}"></i>
                        </div>
                        <div class="content">
                            <h2>{{ $item['count'] }}</h2>
                            <p>{{ $item['text'] }}</p>
                        </div>
                        <div class="progress-bar-container" aria-hidden="true">
                            <div class="progress-bar"
                                style="background-color: {{ $item['color'] }}; width: {{ max(min($item['count'] * 5, 100), 10) }}%;">
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Grafik Tamu --}}
        <div class="row mt-5 justify-content-center">
            <div class="col-12 col-md-10">
                <div class="card shadow-sm p-4">
                    <h5 class="text-center fw-bold text-primary mb-4">Grafik Daftar Tamu (30 Hari Terakhir)</h5>
                    <div style="height: 300px;">
                        <canvas id="tamuChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Logout --}}
    

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('tamuChart').getContext('2d');
        const tamuChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Jumlah Tamu',
                    data: {!! json_encode($values) !!},
                    backgroundColor: '#007bff',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        ticks: {
                            maxRotation: 90,
                            minRotation: 45,
                            autoSkip: true,
                            maxTicksLimit: 15
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@endsection
