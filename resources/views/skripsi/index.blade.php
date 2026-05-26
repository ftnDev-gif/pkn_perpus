<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Eprints Skripsi</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-800 font-sans p-6">

    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-end mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Data Repositori Skripsi</h1>
                <p class="text-sm text-gray-500 mt-1">Sistem Pemantauan Dokumen Eprints Perpustakaan</p>
            </div>
            
            <div class="flex gap-2">
                <input type="text" placeholder="Cari NIM / Nama..." class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 outline-none">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                    Cari
                </button>
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
                        
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4">
                                <div class="font-medium text-gray-900">Hadya Cintya Pralapita</div>
                                <div class="text-gray-500 text-xs mt-0.5">NIM: D500220044</div>
                            </td>
                            <td class="p-4 max-w-md">
                                <div class="font-medium text-gray-900 truncate" title="Analisis Uji Nyala Biogas Dari Variasi...">
                                    Analisis Uji Nyala Biogas Dari Variasi ...
                                </div>
                                <div class="text-gray-500 text-xs mt-0.5">Pembimbing: Muhammad Mujibburohim</div>
                            </td>
                            <td class="p-4">
                                <div class="text-gray-900">Teknik Kimia</div>
                                <div class="text-gray-500 text-xs mt-0.5">Tahun: 2026</div>
                            </td>
                            <td class="p-4 text-center">
                                <span class="px-2.5 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">
                                    Publish
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                <a href="http://eprints.ums.ac.id/ID_EPRINT" target="_blank" class="inline-block text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                    Lihat Eprint
                                </a>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4">
                                <div class="font-medium text-gray-900">Faris 'Adilah</div>
                                <div class="text-gray-500 text-xs mt-0.5">NIM: D100160104</div>
                            </td>
                            <td class="p-4 max-w-md">
                                <div class="font-medium text-gray-900 truncate" title="Pengaruh Campuran Silica Fume Sebagai...">
                                    Pengaruh Campuran Silica Fume Seba...
                                </div>
                                <div class="text-gray-500 text-xs mt-0.5">Pembimbing: Ir. Aliem Sudjatmiko, M.T.</div>
                            </td>
                            <td class="p-4">
                                <div class="text-gray-900">Fakultas Teknik</div>
                                <div class="text-gray-500 text-xs mt-0.5">Tahun: 2020</div>
                            </td>
                            <td class="p-4 text-center">
                                <span class="px-2.5 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">
                                    Publish
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                <a href="http://eprints.ums.ac.id/ID_EPRINT" target="_blank" class="inline-block text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                    Lihat Eprint
                                </a>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            
            <div class="p-4 border-t border-gray-200 text-sm text-gray-500 flex justify-between items-center">
                <span>Menampilkan 1 hingga 2 dari ribuan data</span>
                <div class="flex gap-1">
                    <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100 disabled:opacity-50" disabled>Sebelumnya</button>
                    <button class="px-3 py-1 border border-gray-300 rounded bg-blue-50 text-blue-600 font-medium">1</button>
                    <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">2</button>
                    <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">Selanjutnya</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>