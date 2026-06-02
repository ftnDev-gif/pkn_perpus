<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class SkripsiController extends Controller
{
    public function index(Request $request) 
    {
        // 1. Tangkap semua input dari form UI
        $search = $request->input('search');
        $prodi = $request->input('prodi');
        $start_year = $request->input('start_year', '2015'); // Tahun bawaan dari Pak Asharul
        $end_year = $request->input('end_year', '2026');

        // 2. Siapkan pondasi kondisi SQL untuk Rentang Tahun
        $whereClause = " WHERE e.date_year BETWEEN :start_year AND :end_year ";
        $bindings = [
            'start_year' => $start_year,
            'end_year' => $end_year,
        ];

        // 3. Jika user memilih Prodi spesifik, tambahkan ke SQL
        if ($prodi) {
            $whereClause .= " AND ed.divisions = :prodi ";
            $bindings['prodi'] = $prodi;
        }

        // 4. Jika user mengetik kata kunci pencarian, tambahkan ke SQL
        if ($search) {
            $whereClause .= " AND (
                e.title LIKE :search1 
                OR e.id_number LIKE :search2 
                OR CONCAT(IFNULL(mahasiswa.creators_name_given, ''), ' ', IFNULL(mahasiswa.creators_name_family, '')) LIKE :search3
            ) ";
            $searchTerm = '%' . $search . '%';
            $bindings['search1'] = $searchTerm;
            $bindings['search2'] = $searchTerm;
            $bindings['search3'] = $searchTerm;
        }

        // 5. Eksekusi Query
        $dataSkripsi = DB::select("
            SELECT 
                CONCAT('http://eprints.ums.ac.id/', e.eprintid) AS Link,
                ed.divisions AS Kode_Prodi,
                
                CASE 
                    WHEN ed.divisions IN ('G600', 'H100', 'I000', 'G100', 'G000', 'O200', 'O100', 'O300', 'H000','G108') THEN 'Fakultas Agama Islam'
                    WHEN ed.divisions IN ('B400', 'B10A', 'B200', 'B300', 'B100', 'W100', 'P100', 'B109') THEN 'Fakultas Ekonomi dan Bisnis'
                    WHEN ed.divisions IN ('KA00', 'K110', 'KI00', 'KR00', 'KI08', 'KI09', 'KP00', 'KP10', 'KR09', 'K100', 'V100', 'V109') THEN 'Fakultas Farmasi'
                    WHEN ed.divisions IN ('E100', 'E200') THEN 'Fakultas Geografi'
                    WHEN ed.divisions IN ('C100', 'R100', 'R200') THEN 'Fakultas Hukum'
                    WHEN ed.divisions IN ('J100', 'J300', 'J400', 'J110', 'J317', 'J130', 'J230', 'J120', 'J310', 'J210', 'J220', 'J410', 'J128', 'J218') THEN 'Fakultas Ilmu Kesehatan'
                    WHEN ed.divisions IN ('D10A', 'D20A', 'D800', 'D300', 'D400', 'D600', 'D500', 'D200', 'D700', 'D100', 'U200', 'U100', 'S100','D209') THEN 'Fakultas Teknik'
                    WHEN ed.divisions IN ('A210', 'A310', 'A320', 'A420', 'A610', 'A510', 'A540', 'A410', 'A810', 'A220', 'A520', 'A530', 'A710', 'Q100', 'S200', 'S400', 'Q200', 'A418', 'A319', 'Q300') THEN 'FKIP'
                    WHEN ed.divisions IN ('J510', 'J500', 'J508') THEN 'Fakultas Kedokteran'
                    WHEN ed.divisions IN ('J530', 'j520') THEN 'Fakultas Kedokteran Gigi'
                    WHEN ed.divisions IN ('L100', 'L300', 'L200', 'L280') THEN 'Fakultas Komunikasi dan Informatika'
                    WHEN ed.divisions IN ('T100', 'F200', 'F100', 'S300', 'F109') THEN 'Fakultas Psikologi'
                    ELSE 'Lainnya'
                END AS Fakultas,

                e.date_year AS lastmod_year, /* Disamakan aliasnya agar frontend tidak error */
                
                CASE 
                    WHEN e.eprint_status = 'archive' THEN 'Publish' 
                    ELSE 'Unpublish/OBE' 
                END AS status_keterangan,

                e.id_number AS NIM,
                e.title AS Judul,
                
                CONCAT(mahasiswa.creators_name_given, ' ', mahasiswa.creators_name_family) AS Mahasiswa,
                dosen.creators_name_given AS Dosen_Pembimbing

            FROM eprint_divisions AS ed
            LEFT JOIN eprint AS e ON e.eprintid = ed.eprintid
            LEFT JOIN (
                SELECT ec.eprintid, ec.creators_name_given, ec.creators_name_family
                FROM eprint_creators_name AS ec
                WHERE ec.pos = 0 
            ) AS mahasiswa ON mahasiswa.eprintid = ed.eprintid
            LEFT JOIN (
                SELECT ec.eprintid, ec.creators_name_given
                FROM eprint_creators_name AS ec
                WHERE ec.pos = 1 
            ) AS dosen ON dosen.eprintid = ed.eprintid

            /* Masukkan seluruh kondisi dinamis yang sudah kita rakit di atas ke sini */
            $whereClause

            GROUP BY 
                ed.divisions, 
                Fakultas,
                e.eprintid,
                e.date_year, 
                e.eprint_status, 
                e.id_number, 
                e.title,
                mahasiswa.creators_name_given, 
                mahasiswa.creators_name_family, 
                dosen.creators_name_given
            ORDER BY 
                ed.divisions ASC,
                e.eprint_status ASC;
        ", $bindings);

        $collection = collect($dataSkripsi);
        
        $grafikData = $collection->groupBy('Fakultas')->map->count();
        
        $chartLabels = $grafikData->keys()->toArray();
        $chartValues = $grafikData->values()->toArray();
        // ------------------------------

        $perPage = 10;
        $currentPage = request()->input('page', 1);

        $paginatedSkripsi = new LengthAwarePaginator(
            $collection->forPage($currentPage, $perPage),
            $collection->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('skripsi.index', [
            'dataSkripsi' => $paginatedSkripsi,
            'chartLabels' => $chartLabels,
            'chartValues' => $chartValues
        ]);
    }
}