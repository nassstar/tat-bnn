<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asesmen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. KPI Cards (Statistik Cepat)
        $totalKlien = Asesmen::count();
        $menungguTAT = Asesmen::where('pelaksanaan', 'TIDAK')->orWhereNull('pelaksanaan')->count();
        $selesaiTAT = Asesmen::where('pelaksanaan', 'YA')->count();
        $totalBB = Asesmen::sum('berat_bb') ?? 0;

        // 2. Analisis Tren Narkotika (Aman dari error tabel hilang)
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

        // 4. Analisis Rekomendasi Rehab (Aman dari error kolom hilang)
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

        // 5. Tabel Kasus Terbaru (To-Do List)
        $kasusTerbaru = Asesmen::latest()->limit(5)->get();

        return view('dashboard', compact(
            'totalKlien',
            'menungguTAT',
            'selesaiTAT',
            'totalBB',
            'trenNarkotika',
            'demografiGender',
            'statusHukum',
            'rekomendasiRehab',
            'kasusTerbaru'
        ));
    }
}