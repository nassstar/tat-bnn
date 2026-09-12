<?php

namespace App\Http\Controllers;

use App\Models\Asesmen;
use Illuminate\Http\Request; // PASTIKAN BARIS INI ADA
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. KPI Cards (Statistik Cepat)
        $totalKlien = Asesmen::count();
        $menungguTAT = Asesmen::where('pelaksanaan', 'TIDAK')->orWhereNull('pelaksanaan')->count();
        $selesaiTAT = Asesmen::where('pelaksanaan', 'YA')->count();
        $totalBB = Asesmen::sum('berat_bb') ?? 0;

        // 2. Analisis Demografi Gender & Status Hukum
        $demografiGender = Asesmen::select('jenis_kelamin', DB::raw('count(*) as total'))
            ->groupBy('jenis_kelamin')
            ->get();

        $listKlienGender = Asesmen::select('id', 'nama_lengkap', 'no_register', 'jenis_kelamin')
            ->orderBy('nama_lengkap', 'asc')
            ->get()
            ->groupBy('jenis_kelamin');

        $statusHukum = Asesmen::select('status_hukum', DB::raw('count(*) as total'))
            ->whereNotNull('status_hukum')
            ->groupBy('status_hukum')
            ->get();

        // 3. Tabel Aktivitas Terbaru
        $asesmenTerakhir = Asesmen::latest('created_at')->first();
        if ($asesmenTerakhir) {
            $tanggalTerakhir = $asesmenTerakhir->created_at->format('Y-m-d');
            $aktivitasTerbaru = Asesmen::whereDate('created_at', $tanggalTerakhir)->latest('created_at')->get();
        } else {
            $tanggalTerakhir = null;
            $aktivitasTerbaru = collect();
        }

        // 4. Demografi Usia Klien
        $semuaAsesmen = Asesmen::select('id', 'nama_lengkap', 'no_register', 'tgl_lahir', 'created_at')->get();
        $dataKlienUsia = [];

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
                        $dataKlienUsia[] = [
                            'id' => $a->id,
                            'nama_lengkap' => $a->nama_lengkap,
                            'no_register' => $a->no_register,
                            'usia' => (int) $diff->y
                        ];
                    }
                } catch (\Exception $e) {
                }
            }
        }

        // ==============================================================
        // 5. DEMOGRAFI WILAYAH (DENGAN FILTER BULAN/TAHUN)
        // ==============================================================
        $queryWilayah = Asesmen::select('id', 'nama_lengkap', 'no_register', 'alamat_ktp', 'alamat_domisili');

        // Jika ada filter bulan yang dipilih
        if ($request->filled('bulan_wilayah')) {
            $queryWilayah->whereMonth('created_at', $request->bulan_wilayah);
        }

        // Jika ada filter tahun yang dipilih
        if ($request->filled('tahun_wilayah')) {
            $queryWilayah->whereYear('created_at', $request->tahun_wilayah);
        }

        $allAsesmens = $queryWilayah->get();
        $dataKtp = $this->prosesDemografiWilayah($allAsesmens, 'alamat_ktp');
        $dataDomisili = $this->prosesDemografiWilayah($allAsesmens, 'alamat_domisili');

        // Ambil Daftar Tahun Unik yang tersedia di database
        $tahunTersedia = Asesmen::selectRaw('YEAR(created_at) as tahun')
            ->whereNotNull('created_at')
            ->groupBy('tahun')
            ->orderByDesc('tahun')
            ->pluck('tahun');

        // Jika database kosong, beri default tahun ini
        if ($tahunTersedia->isEmpty()) {
            $tahunTersedia = collect([date('Y')]);
        }

        // ==============================================================
        // 6. DEMOGRAFI PENDIDIKAN & TARIKAN DATA UNTUK MODAL DETAIL
        // ==============================================================
        try {
            $demografiPendidikan = Asesmen::select('m_pendidikan.nama_pendidikan as nama', DB::raw('count(*) as total'))
                ->join('m_pendidikan', 'asesmens.pendidikan_id', '=', 'm_pendidikan.id')
                ->groupBy('m_pendidikan.nama_pendidikan')
                ->orderByDesc('total')
                ->get();

            $totalPendidikan = $demografiPendidikan->sum('total');

            $listKlienPendidikan = Asesmen::select('asesmens.id', 'asesmens.nama_lengkap', 'asesmens.no_register', 'm_pendidikan.nama_pendidikan')
                ->join('m_pendidikan', 'asesmens.pendidikan_id', '=', 'm_pendidikan.id')
                ->orderBy('asesmens.nama_lengkap', 'asc')
                ->get()
                ->groupBy('nama_pendidikan');

        } catch (\Exception $e) {
            $demografiPendidikan = collect();
            $totalPendidikan = 0;
            $listKlienPendidikan = collect();
        }

        // ==============================================================
        // 7. DEMOGRAFI TOP 5 PEKERJAAN
        // ==============================================================
        try {
            $topPekerjaan = Asesmen::select('m_pekerjaan.nama_pekerjaan as pekerjaan_input', DB::raw('count(*) as total'))
                ->join('m_pekerjaan', 'asesmens.pekerjaan_id', '=', 'm_pekerjaan.id')
                ->whereNotNull('m_pekerjaan.nama_pekerjaan')
                ->where('m_pekerjaan.nama_pekerjaan', '!=', '')
                ->groupBy('m_pekerjaan.nama_pekerjaan')
                ->orderByDesc('total')
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            $topPekerjaan = collect();
        }

        return view('dashboard', compact(
            'totalKlien',
            'menungguTAT',
            'selesaiTAT',
            'totalBB',
            'demografiGender',
            'listKlienGender',
            'statusHukum',
            'aktivitasTerbaru',
            'tanggalTerakhir',
            'dataKlienUsia',
            'dataKtp',
            'dataDomisili',
            'demografiPendidikan',
            'totalPendidikan',
            'listKlienPendidikan',
            'topPekerjaan',
            'tahunTersedia' // <-- Variabel tahun dikirim ke view
        ));
    }

    /**
     * Helper Ekstrak Wilayah Beserta Daftar Klien
     */
    private function prosesDemografiWilayah(\Illuminate\Database\Eloquent\Collection $asesmens, string $field)
    {
        $validCount = 0;
        $desaKliens = [];
        $kelurahanKliens = [];
        $kecamatanKliens = [];

        foreach ($asesmens as $a) {
            $alamat = $a->$field;
            if (!$alamat)
                continue;
            $validCount++;

            if (preg_match('/Desa\s+([^,]+)/i', $alamat, $matches)) {
                $nama = trim($matches[1]);
                $desaKliens[$nama][] = [
                    'id' => $a->id,
                    'nama_lengkap' => $a->nama_lengkap,
                    'no_register' => $a->no_register,
                ];
            }
            if (preg_match('/Kelurahan\s+([^,]+)/i', $alamat, $matches)) {
                $nama = trim($matches[1]);
                $kelurahanKliens[$nama][] = [
                    'id' => $a->id,
                    'nama_lengkap' => $a->nama_lengkap,
                    'no_register' => $a->no_register,
                ];
            }
            if (preg_match('/Kecamatan\s+([^,]+)/i', $alamat, $matches)) {
                $nama = trim($matches[1]);
                $kecamatanKliens[$nama][] = [
                    'id' => $a->id,
                    'nama_lengkap' => $a->nama_lengkap,
                    'no_register' => $a->no_register,
                ];
            }
        }

        uasort($desaKliens, fn($x, $y) => count($y) <=> count($x));
        uasort($kelurahanKliens, fn($x, $y) => count($y) <=> count($x));
        uasort($kecamatanKliens, fn($x, $y) => count($y) <=> count($x));

        $totalAlamat = max(1, $validCount);

        $topDesa = [];
        foreach (array_slice($desaKliens, 0, 5, true) as $k => $v) {
            $topDesa[$k] = count($v);
        }

        $topKelurahan = [];
        foreach (array_slice($kelurahanKliens, 0, 5, true) as $k => $v) {
            $topKelurahan[$k] = count($v);
        }

        $topKecamatan = [];
        foreach (array_slice($kecamatanKliens, 0, 5, true) as $k => $v) {
            $topKecamatan[$k] = count($v);
        }

        $full = ['desa' => [], 'kelurahan' => [], 'kecamatan' => []];
        foreach ($desaKliens as $name => $kliens) {
            $full['desa'][] = [
                'nama' => $name,
                'count' => count($kliens),
                'persen' => round((count($kliens) / $totalAlamat) * 100, 1),
            ];
        }
        foreach ($kelurahanKliens as $name => $kliens) {
            $full['kelurahan'][] = [
                'nama' => $name,
                'count' => count($kliens),
                'persen' => round((count($kliens) / $totalAlamat) * 100, 1),
            ];
        }
        foreach ($kecamatanKliens as $name => $kliens) {
            $full['kecamatan'][] = [
                'nama' => $name,
                'count' => count($kliens),
                'persen' => round((count($kliens) / $totalAlamat) * 100, 1),
            ];
        }

        return [
            'topDesa' => $topDesa,
            'topKelurahan' => $topKelurahan,
            'topKecamatan' => $topKecamatan,
            'topDesaKliens' => array_slice($desaKliens, 0, 5, true),
            'topKelurahanKliens' => array_slice($kelurahanKliens, 0, 5, true),
            'topKecamatanKliens' => array_slice($kecamatanKliens, 0, 5, true),
            'full' => $full,
            'total' => $totalAlamat
        ];
    }
}