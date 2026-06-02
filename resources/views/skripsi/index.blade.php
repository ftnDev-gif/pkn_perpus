<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Eprints Skripsi</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans p-6">

    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-end mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Data Repositori Skripsi</h1>
                <p class="text-sm text-gray-500 mt-1">Sistem Pemantauan Dokumen Eprints Perpustakaan</p>
            </div>
            
            <div class="flex gap-2">
                <form method="GET" action="{{ url('/skripsi') }}" class="flex flex-wrap gap-2 items-center">
    
                    <select name="prodi" class="px-3 py-2 border border-gray-300 rounded-lg text-sm outline-none bg-white">
                        <option value="">Semua Prodi/Fakultas</option>
                        <option value="D500" {{ request('prodi') == 'D500' ? 'selected' : '' }}>Teknik Kimia (D500)</option>
                        <option value="D100" {{ request('prodi') == 'D100' ? 'selected' : '' }}>Teknik Sipil (D100)</option>
                        <option value="D200" {{ request('prodi') == 'D200' ? 'selected' : '' }}>Teknik Mesin (D200)</option>
                        
                        <option value="L200" {{ request('prodi') == 'L200' ? 'selected' : '' }}>Teknik Informatika (L200)</option>
                        <option value="L100" {{ request('prodi') == 'L100' ? 'selected' : '' }}>Ilmu Komunikasi (L100)</option>

                        <option value="J500" {{ request('prodi') == 'J500' ? 'selected' : '' }}>Kedokteran (J500)</option>
                        <option value="K100" {{ request('prodi') == 'K100' ? 'selected' : '' }}>Farmasi (K100)</option>
                        <option value="B100" {{ request('prodi') == 'B100' ? 'selected' : '' }}>Manajemen (B100)</option>
                    </select>

                    <div class="flex items-center gap-1">
                        <input type="number" name="start_year" value="{{ request('start_year', '2015') }}" placeholder="Mulai" class="px-3 py-2 border border-gray-300 rounded-lg text-sm w-24 outline-none">
                        <span class="text-gray-500 font-medium">-</span>
                        <input type="number" name="end_year" value="{{ request('end_year', '2026') }}" placeholder="Akhir" class="px-3 py-2 border border-gray-300 rounded-lg text-sm w-24 outline-none">
                    </div>

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIM/Nama/Judul..." class="px-3 py-2 border border-gray-300 rounded-lg text-sm w-48 outline-none">
                    
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                        Filter Data
                    </button>
                    
                    @if(request('search') || request('prodi') || request('start_year') != '2015' || request('end_year') != '2026')
                        <a href="{{ url('/skripsi') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                            Reset
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">
                Statistik Skripsi per Fakultas ({{ request('start_year', '2015') }} - {{ request('end_year', '2026') }})
            </h2>
            <div class="relative h-72 w-full">
                <canvas id="skripsiChart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-xs uppercase tracking-wider border-b border-gray-200">
                            <th class="p-4 font-semibold">Mahasiswa</th>
                            <th class="p-4 font-semibold">Informasi Skripsi</th>
                            <th class="p-4 font-semibold">Akademik</th>
                            <th class="p-4 font-semibold text-center">Status</th>
                            <th class="p-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @foreach($dataSkripsi as $skripsi)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4">
                                <div class="font-medium text-gray-900">{{ $skripsi->Mahasiswa }}</div>
                                <div class="text-gray-500 text-xs mt-0.5">NIM: {{ $skripsi->NIM }}</div>
                            </td>
                            <td class="p-4 max-w-md">
                                <div class="font-medium text-gray-900 truncate" title="{{ $skripsi->Judul }}">
                                    {{ $skripsi->Judul }}
                                </div>
                                <div class="text-gray-500 text-xs mt-0.5">Pembimbing: {{ $skripsi->Dosen_Pembimbing }}</div>
                            </td>
                            <td class="p-4">
                                <div class="text-gray-900">{{ $skripsi->Fakultas }}</div>
                                <div class="text-gray-500 text-xs mt-0.5">Tahun: {{ $skripsi->lastmod_year }}</div>
                            </td>
                            <td class="p-4 text-center">
                                <span class="px-2.5 py-1 text-xs font-medium {{ $skripsi->status_keterangan == 'Publish' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }} rounded-full">
                                    {{ $skripsi->status_keterangan }}
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                <a href="{{ $skripsi->Link }}" target="_blank" class="inline-block text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                    Lihat Eprint
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 border-t border-gray-200 text-sm text-gray-500 flex justify-between items-center">
                {{ $dataSkripsi->links() }}
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('skripsiChart').getContext('2d');
        
        const labels = {!! json_encode($chartLabels) !!};
        const dataValues = {!! json_encode($chartValues) !!};

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Skripsi',
                    data: dataValues,
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderColor: 'rgba(37, 99, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</body>
</html>