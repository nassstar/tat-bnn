<?php

namespace App\Http\Controllers;

use App\Models\Asesmen;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. KPI Cards (Statistik Cepat)
        $totalKlien = Asesmen::count();
        $menungguTAT = Asesmen::where('pelaksanaan', 'TIDAK')->orWhereNull('pelaksanaan')->count();
        $selesaiTAT = Asesmen::where('pelaksanaan', 'YA')->count();
        $totalBB = Asesmen::sum('berat_bb') ?? 0;

        // 2. Analisis Tren Narkotika
        try {
            $trenNarkotika = Asesmen::select('master_narkotikas.jenis_narkotika as nama', DB::raw('count(*) as total'))
                ->join('master_narkotikas', 'asesmens.narkotika_id', '=', 'master_narkotikas.id')
                ->groupBy('master_narkotikas.jenis_narkotika')
                ->orderByDesc('total')
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            $trenNarkotika = collect();
        }

        // 3. Analisis Demografi Gender & Status Hukum
        $demografiGender = Asesmen::select('jenis_kelamin', DB::raw('count(*) as total'))
            ->groupBy('jenis_kelamin')
            ->get();

        $statusHukum = Asesmen::select('status_hukum', DB::raw('count(*) as total'))
            ->whereNotNull('status_hukum')
            ->groupBy('status_hukum')
            ->get();

        // 4. Analisis Rekomendasi Rehab
        try {
            $rekomendasiRehab = Asesmen::select('rekomendasi_input', DB::raw('count(*) as total'))
                ->whereNotNull('rekomendasi_input')
                ->groupBy('rekomendasi_input')
                ->orderByDesc('total')
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            $rekomendasiRehab = collect();
        }

        // 5. Tabel Aktivitas Terbaru
        $asesmenTerakhir = Asesmen::latest('created_at')->first();
        if ($asesmenTerakhir) {
            $tanggalTerakhir = $asesmenTerakhir->created_at->format('Y-m-d');
            $aktivitasTerbaru = Asesmen::whereDate('created_at', $tanggalTerakhir)->latest('created_at')->get();
        } else {
            $tanggalTerakhir = null;
            $aktivitasTerbaru = collect();
        }

        // 6. Demografi Usia Klien
        $semuaAsesmen = Asesmen::select('tgl_lahir', 'created_at')->get();
        $umurKlien = [];
        foreach ($semuaAsesmen as $a) {
            if (!empty($a->tgl_lahir)) {
                try {
                    $patokanWaktu = $a->created_at ? date_create($a->created_at) : date_create('now');
                    $rawLahir = trim(explode(' ', $a->tgl_lahir)[0]);

                    $parts = explode('-', $rawLahir);
                    if (count($parts) === 3 && strlen($parts[2]) === 4) {
                        $rawLahir = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                    }

                    $tglLahir = date_create($rawLahir);
                    if ($tglLahir) {
                        $diff = date_diff($tglLahir, $patokanWaktu);
                        $umurKlien[] = (int) $diff->y;
                    }
                } catch (\Exception $e) {}
            }
        }

        // 7. Demografi Wilayah (KTP & Domisili)
        $alamatKtp = Asesmen::pluck('alamat_ktp')->filter();
        $alamatDomisili = Asesmen::pluck('alamat_domisili')->filter();

        $dataKtp = $this->prosesDemografiWilayah($alamatKtp);
        $dataDomisili = $this->prosesDemografiWilayah($alamatDomisili);

        // ==============================================================
        // 8. DEMOGRAFI PENDIDIKAN (PERBAIKAN RELASI DATABASE)
        // ==============================================================
        try {
            // Kita melakukan JOIN ke tabel m_pendidikan karena asesmens menyimpan pendidikan_id
            $demografiPendidikan = Asesmen::select('m_pendidikan.nama_pendidikan as nama', DB::raw('count(*) as total'))
                ->join('m_pendidikan', 'asesmens.pendidikan_id', '=', 'm_pendidikan.id')
                ->groupBy('m_pendidikan.nama_pendidikan')
                ->orderByDesc('total')
                ->get();

            $totalPendidikan = $demografiPendidikan->sum('total');
        } catch (\Exception $e) {
            // Sistem pengaman jika ada error / tabel kosong
            $demografiPendidikan = collect();
            $totalPendidikan = 0;
        }

        return view('dashboard', compact(
            'totalKlien', 'menungguTAT', 'selesaiTAT', 'totalBB',
            'trenNarkotika', 'demografiGender', 'statusHukum',
            'rekomendasiRehab', 'aktivitasTerbaru', 'tanggalTerakhir',
            'umurKlien', 'dataKtp', 'dataDomisili',
            'demografiPendidikan', 'totalPendidikan'
        ));
    }

    /**
     * Helper Ekstrak Wilayah
     */
    private function prosesDemografiWilayah(\Illuminate\Support\Collection $alamats)
    {
        $totalAlamat = max(1, $alamats->count());
        $desaData = [];
        $kelurahanData = [];
        $kecamatanData = [];

        foreach ($alamats as $alamat) {
            if (preg_match('/Desa\s+([^,]+)/i', $alamat, $matches)) {
                $nama = trim($matches[1]);
                $desaData[$nama] = ($desaData[$nama] ?? 0) + 1;
            }
            if (preg_match('/Kelurahan\s+([^,]+)/i', $alamat, $matches)) {
                $nama = trim($matches[1]);
                $kelurahanData[$nama] = ($kelurahanData[$nama] ?? 0) + 1;
            }
            if (preg_match('/Kecamatan\s+([^,]+)/i', $alamat, $matches)) {
                $nama = trim($matches[1]);
                $kecamatanData[$nama] = ($kecamatanData[$nama] ?? 0) + 1;
            }
        }

        arsort($desaData);
        arsort($kelurahanData);
        arsort($kecamatanData);

        $full = ['desa' => [], 'kelurahan' => [], 'kecamatan' => []];

        foreach($desaData as $name => $count) {
            $full['desa'][] = ['nama' => $name, 'count' => $count, 'persen' => round(($count / $totalAlamat) * 100, 1)];
        }
        foreach($kelurahanData as $name => $count) {
            $full['kelurahan'][] = ['nama' => $name, 'count' => $count, 'persen' => round(($count / $totalAlamat) * 100, 1)];
        }
        foreach($kecamatanData as $name => $count) {
            $full['kecamatan'][] = ['nama' => $name, 'count' => $count, 'persen' => round(($count / $totalAlamat) * 100, 1)];
        }

        return [
            'topDesa'      => array_slice($desaData, 0, 5, true),
            'topKelurahan' => array_slice($kelurahanData, 0, 5, true),
            'topKecamatan' => array_slice($kecamatanData, 0, 5, true),
            'full'         => $full,
            'total'        => $totalAlamat
        ];
    }
}
