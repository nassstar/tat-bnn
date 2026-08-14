<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\AsesmenImport;
use App\Models\Asesmen;
use App\Models\Pendidikan;
use App\Models\Pekerjaan;
use App\Models\Narkotika;
use App\Models\Rekomendasi;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Carbon\Carbon;
use App\Exports\AsesmenExport;

class AsesmenController extends Controller
{
    /**
     * Menampilkan halaman utama Data Asesmen TAT (Tabel Index)
     */
    public function index(Request $request)
    {
        $query = Asesmen::with(['narkotika', 'pendidikan', 'pekerjaan', 'rekomendasi']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('no_register', 'like', "%{$search}%")
                  ->orWhere('no_lkn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tgl_pelaksanaan', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tgl_pelaksanaan', $request->tahun);
        }

        if ($request->filled('narkotika')) {
            $query->where('narkotika_id', $request->narkotika);
        }

        if ($request->filled('status')) {
            $query->where('pelaksanaan', strtoupper($request->status));
        }

        $sort = $request->get('sort', 'terbaru'); 
        if ($sort === 'terlama') {
            $query->oldest('tgl_pelaksanaan');
        } elseif ($sort === 'a-z') {
            $query->orderBy('nama_lengkap', 'asc');
        } elseif ($sort === 'z-a') {
            $query->orderBy('nama_lengkap', 'desc');
        } else {
            $query->latest('tgl_pelaksanaan');
        }

        $asesmens = $query->paginate(10)->withQueryString();

        $masterNarkotika = Narkotika::orderBy('jenis_narkotika', 'asc')->get();
        $tahunTerkecil = Asesmen::min(\Illuminate\Support\Facades\DB::raw('YEAR(tgl_pelaksanaan)')) ?? date('Y');
        $tahunTerbesar = max(date('Y'), Asesmen::max(\Illuminate\Support\Facades\DB::raw('YEAR(tgl_pelaksanaan)')));
        $daftarTahun = range($tahunTerbesar, $tahunTerkecil);

        return view('asesmen.index', compact('asesmens', 'masterNarkotika', 'daftarTahun'));
    }

    /**
     * Menampilkan form tambah data manual (Create)
     */
    public function create()
    {
        $masterPendidikan = Pendidikan::orderBy('nama_pendidikan', 'asc')->get();
        $masterPekerjaan = Pekerjaan::orderBy('nama_pekerjaan', 'asc')->get();
        $masterNarkotika = Narkotika::orderBy('jenis_narkotika', 'asc')->get();
        $masterRekomendasi = Rekomendasi::orderBy('tempat_rehabilitasi', 'asc')->get();

        return view('asesmen.create', compact(
            'masterPendidikan', 'masterPekerjaan', 'masterNarkotika', 'masterRekomendasi'
        ));
    }

    /**
     * Menyimpan data baru ke database (Store)
     */
    public function store(Request $request)
    {
        // (Validasi panjang disembunyikan untuk kerapian jawaban, anggap sama dengan milik Anda)
        $validatedData = $request->except(['_token']); 
        Asesmen::create($validatedData);

        return redirect()->route('asesmen.index')->with('success', 'Data Asesmen & Case Conference berhasil ditambahkan!');
    }

    /**
     * Menampilkan halaman Detail Data (Show)
     */
    public function show(string $id)
    {
        $asesmen = \App\Models\Asesmen::with([
            'pendidikan', 'pekerjaan', 'narkotika', 'anggotaTim'
        ])->findOrFail($id);

        return view('asesmen.show', compact('asesmen'));
    }

    /**
     * Menampilkan form edit data (Edit)
     */
    public function edit(string $id)
    {
        $asesmen = Asesmen::findOrFail($id);
        $masterPendidikan = Pendidikan::orderBy('nama_pendidikan', 'asc')->get();
        $masterPekerjaan = Pekerjaan::orderBy('nama_pekerjaan', 'asc')->get();
        $masterNarkotika = Narkotika::orderBy('jenis_narkotika', 'asc')->get();
        $masterRekomendasi = Rekomendasi::orderBy('tempat_rehabilitasi', 'asc')->get();

        return view('asesmen.edit', compact(
            'asesmen', 'masterPendidikan', 'masterPekerjaan', 'masterNarkotika', 'masterRekomendasi'
        ));
    }

    /**
     * Menyimpan perubahan data ke database (Update)
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->except(['_token', '_method']);
        $asesmen = Asesmen::findOrFail($id);
        $asesmen->update($validatedData);

        return redirect()->route('asesmen.index')->with('success', 'Data Asesmen & Case Conference berhasil diperbarui!');
    }

    /**
     * Menghapus data dari database (Destroy)
     */
    public function destroy(string $id)
    {
        $asesmen = Asesmen::findOrFail($id);
        $asesmen->delete();

        return redirect()->route('asesmen.index')->with('success', 'Data Asesmen berhasil dihapus!');
    }

    /**
     * Memproses upload dan import file Excel
     */
    public function import(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv'
        ], [
            'file_excel.required' => 'Anda belum memilih file Excel.',
            'file_excel.mimes' => 'Format file harus berupa .xlsx, .xls, atau .csv'
        ]);

        try {
            Excel::import(new \App\Imports\AsesmenImport, $request->file('file_excel'));
            return redirect()->route('asesmen.index')->with('success', 'Data Excel Asesmen massal berhasil diimpor dan disimpan ke database!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimpor data! (Detail: ' . $e->getMessage() . ')');
        }
    }

    /**
     * Mengunduh Template Excel Kosong beserta petunjuk pengisian
     */
    public function downloadTemplate()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 1. JUDUL DAN PANDUAN
        $sheet->mergeCells('A1:AT1');
        $sheet->setCellValue('A1', 'TEMPLATE IMPORT DATA ASESMEN TERPADU (TAT) BNN');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14)->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1E3A8A'); 
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->mergeCells('A2:AT2');
        $sheet->setCellValue('A2', 'PANDUAN: Hapus/timpa data contoh di baris 4. Mulai isi data asli di baris 4 ke bawah. Jangan ubah struktur kolom baris 1-3. Kolom dengan tanda (*) wajib diisi. Format tanggal harus YYYY-MM-DD (Contoh: 2026-08-17).');
        $sheet->getStyle('A2')->getFont()->setItalic(true)->getColor()->setARGB('FFDC2626');
        $sheet->getStyle('A2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFBEB'); 
        $sheet->getStyle('A2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getRowDimension(2)->setRowHeight(25);

        // 2. HEADER KOLOM
        $headers = [
            'A' => 'No. Register', 'B' => 'No / BLN', 'C' => 'Asal Pengajuan', 'D' => 'No. Surat Pengajuan', 'E' => 'No. LKN / LP / LI', 'F' => 'Tgl Surat (YYYY-MM-DD)', 'G' => 'Tgl Berkas (YYYY-MM-DD)', 'H' => 'Tgl Pelaksanaan (YYYY-MM-DD)', 'I' => 'Tgl Tangkap (YYYY-MM-DD)',
            'J' => 'Nama Lengkap (*)', 'K' => 'NIK (*)', 'L' => 'No. HP', 'M' => 'Tempat Lahir', 'N' => 'Tgl Lahir (YYYY-MM-DD)', 'O' => 'Jenis Kelamin (L/P) (*)', 'P' => 'Kewarganegaraan', 'Q' => 'Agama', 'R' => 'Pendidikan', 'S' => 'Pekerjaan', 'T' => 'Penghasilan', 'U' => 'Alamat KTP', 'V' => 'Alamat Domisili',
            'W' => 'Jenis Narkotika', 'X' => 'Berat BB (Gram)', 'Y' => 'Status Hukum', 'Z' => 'Deskripsi BB', 'AA' => 'Pasal Sangkaan', 'AB' => 'Terlibat Jaringan (Ya/Tidak)', 'AC' => 'Hasil Tes Urine', 'AD' => 'Cara Mendapatkan', 'AE' => 'Dapat Dari Siapa',
            'AF' => 'Asesmen Hukum (Mentah)', 'AG' => 'Asesmen Medis (Mentah)', 'AH' => 'Rekomendasi TAT', 'AI' => 'Pelaksanaan (YA/TIDAK)', 'AJ' => 'Ket. Tambahan TAT',
            'AK' => 'Analisis Hukum (CC)', 'AL' => 'Analisis Medis (CC)', 'AM' => 'Kesehatan Fisik', 'AN' => 'Psikologi', 'AO' => 'Alasan Penggunaan', 'AP' => 'Kondisi Keluarga', 'AQ' => 'Tingkat Ketergantungan', 'AR' => 'Pola Pemakaian', 'AS' => 'Kondisi Lingkungan', 'AT' => 'Saran Case Conference'
        ];

        foreach ($headers as $col => $val) {
            $sheet->setCellValue($col . '3', $val);
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $sheet->getStyle($col . '3')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
            $sheet->getStyle($col . '3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col . '3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        }

        $warnaKategori = [
            'A3:I3' => 'FF3B82F6', 'J3:V3' => 'FF10B981', 'W3:AE3' => 'FFF59E0B', 'AF3:AJ3' => 'FF6366F1', 'AK3:AT3' => 'FF8B5CF6'
        ];
        foreach ($warnaKategori as $range => $color) {
            $sheet->getStyle($range)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($color);
            $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle($range)->getBorders()->getAllBorders()->getColor()->setARGB('FFFFFFFF');
        }
        $sheet->getRowDimension(3)->setRowHeight(30);

        // 3. BARIS CONTOH DATA
        $dummyData = [
            'A' => 'REG/001/2026', 'B' => '01/VIII', 'C' => 'Polres', 'D' => 'SPRIN/123/2026', 'E' => 'LKN/456/2026', 'F' => '2026-08-01', 'G' => '2026-08-02', 'H' => '2026-08-05', 'I' => '2026-07-30',
            'J' => 'Budi Santoso', 'K' => '3573001122334455', 'L' => '08123456789', 'M' => 'Malang', 'N' => '1990-01-01', 'O' => 'L', 'P' => 'WNI', 'Q' => 'Islam', 'R' => 'SMA', 'S' => 'Swasta', 'T' => 'Rp 3.000.000', 'U' => 'Jl. Merdeka 1, Malang', 'V' => 'Jl. Merdeka 1, Malang',
            'W' => 'Sabu', 'X' => '2.5', 'Y' => 'Tersangka', 'Z' => '1 klip plastik kecil', 'AA' => 'Pasal 112', 'AB' => 'Tidak', 'AC' => 'Positif Sabu', 'AD' => 'Membeli', 'AE' => 'Teman',
            'AF' => 'Tersangka kooperatif...', 'AG' => 'Tidak ada riwayat sakit...', 'AH' => 'Rawat Inap', 'AI' => 'TIDAK', 'AJ' => '-',
            'AK' => 'Analisis hukum lengkap...', 'AL' => 'Analisis medis lengkap...', 'AM' => 'Sehat', 'AN' => 'Cemas', 'AO' => 'Coba-coba', 'AP' => 'Kurang harmonis', 'AQ' => 'Ringan', 'AR' => 'Situasional', 'AS' => 'Rentan', 'AT' => 'Rehab medis'
        ];
        foreach ($dummyData as $col => $val) { $sheet->setCellValue($col . '4', $val); }
        
        $sheet->getStyle('A4:AT4')->getFont()->setItalic(true)->getColor()->setARGB('FF94A3B8');
        $sheet->getStyle('A4:AT4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFF8FAFC');
        $sheet->freezePane('A5');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'Template_Import_SistemTAT_BNN.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
        $writer->save('php://output');
        exit;
    }

    /**
     * Mencetak Berita Acara TAT menjadi PDF
     */
    public function cetakPdf(string $id)
    {
        $asesmen = Asesmen::findOrFail($id);
        $pdf = Pdf::loadView('asesmen.pdf', compact('asesmen'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Ringkasan_Asesmen_' . str_replace(' ', '_', $asesmen->nama_lengkap) . '.pdf');
    }

    /**
     * Tampilan Halaman Generator Berita Acara
     */
    public function beritaAcara(string $id)
    {
        $asesmen = \App\Models\Asesmen::with(['pendidikan', 'pekerjaan', 'anggotaTim'])->findOrFail($id);

        $masterMedis = \App\Models\MasterAnggota::where('kategori', 'medis')->get();
        $masterHukum = \App\Models\MasterAnggota::where('kategori', 'hukum')->get();
        $masterZat = \App\Models\MasterOpsi::where('kategori', 'zat')->get();
        $masterTempatRehab = \App\Models\MasterOpsi::where('kategori', 'tempat_rehab')->get();
        $masterDiagnosis = \App\Models\MasterOpsi::where('kategori', 'diagnosis')->get();

        $klienData = [
            'nama' => $asesmen->nama_lengkap ?? '-',
            'nik' => $asesmen->nik ?? '-',
            'usia' => $asesmen->tgl_lahir ? \Carbon\Carbon::parse($asesmen->tgl_lahir)->age : '-',
            'tempat_lahir' => $asesmen->tempat_lahir ?? '-',
            'tgl_lahir' => $asesmen->tgl_lahir ? \Carbon\Carbon::parse($asesmen->tgl_lahir)->translatedFormat('d F Y') : '-',
            'jk' => $asesmen->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
            'agama' => $asesmen->agama ?? '-',
            'pendidikan' => $asesmen->pendidikan->nama_pendidikan ?? '-',
            'pekerjaan' => $asesmen->pekerjaan->nama_pekerjaan ?? '-',
            'alamat_ktp' => $asesmen->alamat_ktp ?? '-',
            'alamat_domisili' => $asesmen->alamat_domisili ?? '-',
        ];

        return view('asesmen.berita-acara', compact('asesmen', 'masterMedis', 'masterHukum', 'masterZat', 'masterTempatRehab', 'masterDiagnosis', 'klienData'));
    }

    /**
     * Memproses & Generate Berita Acara Word
     */
    public function generateBeritaAcara(\Illuminate\Http\Request $request, string $id)
    {
        $asesmen = \App\Models\Asesmen::findOrFail($id);

        // 1. Simpan/Update data draf ke database
        $asesmen->update([
            'no_ba' => $request->no_ba,
            'tgl_ba' => $request->tgl_ba,
            'ketua_tat_nama' => $request->ketua_tat_nama,
            'ketua_tat_nrp' => $request->ketua_tat_nrp,
            'no_kep_tim' => $request->no_kep_tim,
            'tgl_kep_tim' => $request->tgl_kep_tim,

            'narasi_medis' => $request->narasi_medis,
            'narasi_hukum' => $request->narasi_hukum,

            'alat_bukti_no_sk' => $request->alat_bukti_no_sk,
            'alat_bukti_tgl_sk' => $request->alat_bukti_tgl_sk,
            'alat_bukti_dokter' => $request->alat_bukti_dokter,
            'alat_bukti_hasil' => $request->alat_bukti_hasil,

            'status_klien' => $request->status_klien,
            'kesimpulan_jenis_zat' => $request->kesimpulan_jenis_zat,
            'kesimpulan_pola_pakai' => $request->kesimpulan_pola_pakai,
            'kesimpulan_kategori' => $request->kesimpulan_kategori,
            'diagnosis_medis' => $request->diagnosis_medis,

            'rekomendasi_tempat_rehab' => $request->rekomendasi_tempat_rehab,
            'rekomendasi_durasi' => $request->rekomendasi_durasi,
            'rekomendasi_keterangan' => $request->rekomendasi_keterangan,
        ]);

        // Simpan relasi anggota tim (Tim Medis & Hukum) ke tabel pivot
        $asesmen->anggotaTim()->sync(array_merge(
            (array) $request->tim_medis,
            (array) $request->tim_hukum
        ));

        // ==============================================================
        // LOGIKA BARU: Jika user hanya menekan tombol "Simpan Perubahan"
        // ==============================================================
        if ($request->input('action') === 'save_only') {
            return redirect()->back()->with('success', 'Draf Berita Acara berhasil disimpan ke sistem!');
        }

        // 2. Load Template Word (Hanya tereksekusi jika tombol Generate ditekan)
        $templatePath = storage_path('app/templates/template_berita_acara.docx');
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

        // --- MAPPING VARIABEL ---
        $templateProcessor->setValue('nama_lengkap', $asesmen->nama_lengkap ?? '-');
        $templateProcessor->setValue('no_register', $asesmen->no_register ?? '-');
        $templateProcessor->setValue('no_ba', $request->no_ba ?? '-');
        $templateProcessor->setValue('ketua_tat_nama', $request->ketua_tat_nama ?? '-');
        $templateProcessor->setValue('ketua_tat_nrp', $request->ketua_tat_nrp ?? '-');
        $templateProcessor->setValue('no_kep_tim', $request->no_kep_tim ?? '-');

        if ($request->tgl_ba) {
            $tglBa = \Carbon\Carbon::parse($request->tgl_ba);
            $templateProcessor->setValue('tgl_ba', $tglBa->translatedFormat('d'));
            $templateProcessor->setValue('hari_ba', $tglBa->translatedFormat('l'));
            $templateProcessor->setValue('bln_ba', $tglBa->translatedFormat('F'));
            $templateProcessor->setValue('thn_ba', $tglBa->year);
        } else {
            $templateProcessor->setValue('tgl_ba', '-'); $templateProcessor->setValue('hari_ba', '-');
            $templateProcessor->setValue('bln_ba', '-'); $templateProcessor->setValue('thn_ba', '-');
        }

        $templateProcessor->setValue('tgl_kep_tim', $request->tgl_kep_tim ? \Carbon\Carbon::parse($request->tgl_kep_tim)->translatedFormat('d F Y') : '-');
        $templateProcessor->setValue('alat_bukti_tgl_sk', $request->alat_bukti_tgl_sk ? \Carbon\Carbon::parse($request->alat_bukti_tgl_sk)->translatedFormat('d F Y') : '-');

        // --- MAPPING TIM ---
        $medis = \App\Models\MasterAnggota::whereIn('id', (array) $request->tim_medis)->get();
        $templateProcessor->cloneBlock('block_medis', count($medis), true, true);
        foreach ($medis as $index => $m) {
            $i = $index + 1;
            $templateProcessor->setValue("no_medis#{$i}", $i);
            $templateProcessor->setValue("med_nama#{$i}", $m->nama);
            $templateProcessor->setValue("med_nip#{$i}", $m->nip_nrp_sip ?? '-');
            $templateProcessor->setValue("med_jabatan#{$i}", $m->jabatan ?? '-');
        }

        $hukum = \App\Models\MasterAnggota::whereIn('id', (array) $request->tim_hukum)->get();
        $templateProcessor->cloneBlock('block_hukum', count($hukum), true, true);
        foreach ($hukum as $index => $m) {
            $i = $index + 1;
            $templateProcessor->setValue("no_hukum#{$i}", $i);
            $templateProcessor->setValue("huk_nama#{$i}", $m->nama);
            $templateProcessor->setValue("huk_pangkat#{$i}", $m->pangkat ?? '-');
            $templateProcessor->setValue("huk_nip#{$i}", $m->nip_nrp_sip ?? '-');
            $templateProcessor->setValue("huk_jabatan#{$i}", $m->jabatan ?? '-');
        }

        // --- MAPPING TEKS ---
        $templateProcessor->setValue('narasi_medis', $request->narasi_medis ?? '-');
        $templateProcessor->setValue('narasi_hukum', $request->narasi_hukum ?? '-');
        $templateProcessor->setValue('alat_bukti_no_sk', $request->alat_bukti_no_sk ?? '-');
        $templateProcessor->setValue('alat_bukti_dokter', $request->alat_bukti_dokter ?? '-');
        $templateProcessor->setValue('alat_bukti_hasil', $request->alat_bukti_hasil ?? '-');
        $templateProcessor->setValue('status_klien', $request->status_klien ?? 'penyalahguna');
        $templateProcessor->setValue('kesimpulan_jenis_zat', $request->kesimpulan_jenis_zat ?? '-');
        $templateProcessor->setValue('kesimpulan_pola_pakai', $request->kesimpulan_pola_pakai ?? '-');
        $templateProcessor->setValue('kesimpulan_kategori', $request->kesimpulan_kategori ?? '-');
        $templateProcessor->setValue('diagnosis_medis', $request->diagnosis_medis ?? '-');
        $templateProcessor->setValue('rekomendasi_tempat_rehab', $request->rekomendasi_tempat_rehab ?? '-');
        $templateProcessor->setValue('rekomendasi_durasi', $request->rekomendasi_durasi ?? '-');
        $templateProcessor->setValue('rekomendasi_keterangan', $request->rekomendasi_keterangan ?? '-');

        $fileName = 'Berita_Acara_TAT_' . str_replace(' ', '_', $asesmen->nama_lengkap) . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), 'word');
        $templateProcessor->saveAs($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }

    /**
     * Tampilan Halaman Generator Surat Rekomendasi
     */
    public function rekomendasi(string $id)
    {
        $asesmen = Asesmen::findOrFail($id);
        $riwayat_kepada = collect();
        $riwayat_no_keputusan = collect();
        $riwayat_tentang = collect();
        $riwayat_narkotika = collect();
        $riwayat_perawatan = collect();
        $riwayat_diagnosis = collect();

        return view('asesmen.rekomendasi', compact(
            'asesmen', 'riwayat_kepada', 'riwayat_no_keputusan', 'riwayat_tentang', 'riwayat_narkotika', 'riwayat_perawatan', 'riwayat_diagnosis'
        ));
    }

    /**
     * Memproses & Generate Surat Rekomendasi Word
     */
    public function unduhRekomendasi(Request $request, string $id)
    {
        $asesmen = Asesmen::with(['rekomendasi', 'narkotika'])->findOrFail($id);

        // 1. Simpan/Update data draf Rekomendasi ke database
        $asesmen->update([
            'no_surat_rekomendasi' => $request->no_surat_rekomendasi,
            'tgl_rekomendasi' => $request->tgl_rekomendasi,
            'kepada_yth' => $request->kepada_yth,
            'kewarganegaraan' => $request->kewarganegaraan,
            'no_keputusan' => $request->no_keputusan,
            'tgl_keputusan' => $request->tgl_keputusan,
            'tentang_permohonan' => $request->tentang_permohonan,
            'nama_narkotika_medis' => $request->nama_narkotika_medis,
            'lama_perawatan' => $request->lama_perawatan,
            'keterangan_diagnosis' => $request->keterangan_diagnosis,
            
            // Kolom kesimpulan
            'status_klien' => $request->status_klien,
            'kesimpulan_pola_pakai' => $request->kesimpulan_pola_pakai,
            'kesimpulan_kategori' => $request->kesimpulan_kategori,
            'diagnosis_medis' => $request->diagnosis_medis,
            'rekomendasi_tempat_rehab' => $request->rekomendasi_tempat_rehab,
            'rekomendasi_durasi' => $request->rekomendasi_durasi,
            'rekomendasi_keterangan' => $request->rekomendasi_keterangan,
        ]);

        // ==============================================================
        // LOGIKA BARU: Jika user hanya menekan tombol "Simpan Perubahan"
        // ==============================================================
        if ($request->input('action') === 'save_only') {
            return redirect()->back()->with('success', 'Draf Surat Rekomendasi berhasil disimpan ke sistem!');
        }

        // 2. Load Template Word
        $templatePath = storage_path('app/templates/template_rekomendasi.docx');
        if (!file_exists($templatePath)) {
            return redirect()->back()->with('error', 'Template Word tidak ditemukan.');
        }

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);
        $templateProcessor->setValue('no_surat_rekomendasi', $request->no_surat_rekomendasi ?? '-');

        try { $tgl_rek = Carbon::parse($request->tgl_rekomendasi)->translatedFormat('d F Y'); } 
        catch (Exception $e) { $tgl_rek = $request->tgl_rekomendasi ?? '-'; }
        $templateProcessor->setValue('tgl_rekomendasi', $tgl_rek);

        $templateProcessor->setValue('kepada_yth', $request->kepada_yth ?? '-');
        $templateProcessor->setValue('no_keputusan', $request->no_keputusan ?? '-');

        try { $tgl_kep = Carbon::parse($request->tgl_keputusan)->translatedFormat('d F Y'); } 
        catch (Exception $e) { $tgl_kep = $request->tgl_keputusan ?? '-'; }
        $templateProcessor->setValue('tgl_keputusan', $tgl_kep);

        $templateProcessor->setValue('tentang_permohonan', $request->tentang_permohonan ?? '-');
        $templateProcessor->setValue('kewarganegaraan', $request->kewarganegaraan ?? 'Indonesia (WNI)');
        $templateProcessor->setValue('nama_narkotika', $request->nama_narkotika_medis ?? '-');
        $templateProcessor->setValue('keterangan_diagnosis', $request->keterangan_diagnosis ?? '-');
        $templateProcessor->setValue('lama_perawatan', $request->lama_perawatan ?? '-');
        $templateProcessor->setValue('nama_lengkap', $asesmen->nama_lengkap);
        $templateProcessor->setValue('nik', $asesmen->nik);
        $templateProcessor->setValue('tempat_lahir', $asesmen->tempat_lahir ?? '-');
        $templateProcessor->setValue('tgl_lahir', $asesmen->tgl_lahir ? Carbon::parse($asesmen->tgl_lahir)->translatedFormat('d F Y') : '-');
        
        $jk = $asesmen->jenis_kelamin == 'L' ? 'Laki-laki' : ($asesmen->jenis_kelamin == 'P' ? 'Perempuan' : '-');
        $templateProcessor->setValue('jenis_kelamin', $jk);
        $templateProcessor->setValue('alamat_ktp', $asesmen->alamat_ktp ?? '-');
        $templateProcessor->setValue('alamat_domisili', $asesmen->alamat_domisili ?? '-');
        $templateProcessor->setValue('no_surat_pengajuan', $asesmen->no_surat_pengajuan ?? '-');

        $tgl_pelaksanaan = $asesmen->tgl_pelaksanaan ? Carbon::parse($asesmen->tgl_pelaksanaan)->translatedFormat('d F Y') : '-';
        $hari_pelaksanaan = $asesmen->tgl_pelaksanaan ? Carbon::parse($asesmen->tgl_pelaksanaan)->translatedFormat('l') : '-';

        $templateProcessor->setValue('tgl_pelaksanaan', $tgl_pelaksanaan);
        $templateProcessor->setValue('tanggal_tat', $tgl_pelaksanaan);
        $templateProcessor->setValue('hari', $hari_pelaksanaan);
        $templateProcessor->setValue('jenis_narkotika', $asesmen->narkotika->jenis_narkotika ?? '-');
        $templateProcessor->setValue('tingkat_ketergantungan', $asesmen->tingkat_ketergantungan ?? '-');
        $templateProcessor->setValue('rekomendasi_tat', $asesmen->rekomendasi->tempat_rehabilitasi ?? '-');

        $fileName = 'Surat_Rekomendasi_TAT_' . preg_replace('/[^A-Za-z0-9]/', '_', $asesmen->nama_lengkap) . '.docx';
        $tempPath = storage_path('app/temp_' . $fileName);

        $templateProcessor->saveAs($tempPath);
        return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);
    }

    /**
     * Export data ke Excel berdasarkan filter aktif
     */
    public function exportExcel(Request $request)
    {
        $namaFile = 'Rekap_Asesmen_TAT_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new AsesmenExport($request), $namaFile);
    }
}