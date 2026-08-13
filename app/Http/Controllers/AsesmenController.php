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
        // 1. Inisiasi Query Builder beserta relasinya
        $query = Asesmen::with(['narkotika', 'pendidikan', 'pekerjaan', 'rekomendasi']);

        // 2. Logika Pencarian Kata Kunci (Teks)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('no_register', 'like', "%{$search}%")
                    ->orWhere('no_lkn', 'like', "%{$search}%");
            });
        }

        // 3. Logika Filter Bulan (Berdasarkan tgl_pelaksanaan)
        if ($request->filled('bulan')) {
            $query->whereMonth('tgl_pelaksanaan', $request->bulan);
        }

        // 4. Logika Filter Tahun (Berdasarkan tgl_pelaksanaan)
        if ($request->filled('tahun')) {
            $query->whereYear('tgl_pelaksanaan', $request->tahun);
        }

        // 5. Logika Filter Jenis Narkotika
        if ($request->filled('narkotika')) {
            $query->where('narkotika_id', $request->narkotika);
        }

        // 6. Logika Filter Status Pelaksanaan (Sudah/Belum di-Rehab)
        if ($request->filled('status')) {
            $query->where('pelaksanaan', strtoupper($request->status));
        }

        // 7. Logika Sorting (Pengurutan)
        $sort = $request->get('sort', 'terbaru'); // Default 'terbaru'
        if ($sort === 'terlama') {
            $query->oldest('tgl_pelaksanaan');
        } elseif ($sort === 'a-z') {
            $query->orderBy('nama_lengkap', 'asc');
        } elseif ($sort === 'z-a') {
            $query->orderBy('nama_lengkap', 'desc');
        } else {
            $query->latest('tgl_pelaksanaan');
        }

        // 8. Eksekusi query dengan pagination
        $asesmens = $query->paginate(10)->withQueryString();

        // 9. Ambil data master untuk Dropdown Filter di View
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
            'masterPendidikan',
            'masterPekerjaan',
            'masterNarkotika',
            'masterRekomendasi'
        ));
    }

    /**
     * Menyimpan data baru ke database (Store)
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Administrasi Surat & Registrasi
            'no_register' => 'nullable|string|max:100',
            'no_bln' => 'nullable|string|max:100',
            'asal_pengajuan' => 'nullable|string|max:255',
            'no_surat_pengajuan' => 'nullable|string|max:100',
            'no_lkn' => 'nullable|string|max:100',
            'tgl_surat' => 'nullable|date',
            'tgl_berkas' => 'nullable|date',
            'tgl_pelaksanaan' => 'nullable|date',
            'tgl_tangkap' => 'nullable|date',

            // Identitas Klien
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:16',
            'kewarganegaraan' => 'nullable|string|max:100',
            'agama' => 'nullable|string|max:100',
            'tempat_lahir' => 'nullable|string|max:255',
            'tgl_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'nullable|string|max:20',
            'pendidikan_id' => 'nullable',
            'pekerjaan_id' => 'nullable',
            'penghasilan_rata_rata' => 'nullable|string|max:255',
            'alamat_ktp' => 'nullable|string',
            'alamat_domisili' => 'nullable|string',

            // Perkara Hukum & Barang Bukti
            'narkotika_id' => 'nullable',
            'berat_bb' => 'nullable|numeric',
            'deskripsi_bb' => 'nullable|string',
            'pasal_sangkaan' => 'nullable|string',
            'status_hukum' => 'nullable|string|max:255',
            'keterlibatan_jaringan' => 'nullable|string|max:255',
            'cara_mendapatkan' => 'nullable|string|max:255',
            'dapat_dari_siapa' => 'nullable|string|max:255',
            'tes_urine' => 'nullable|string|max:50',

            // Hasil Asesmen Awal (Rekap TAT)
            'hasil_asesmen_hukum' => 'nullable|string',
            'hasil_asesmen_medis' => 'nullable|string',
            'rekomendasi_id' => 'nullable',
            'pelaksanaan' => 'nullable|in:YA,TIDAK',
            'keterangan_tambahan' => 'nullable|string',

            // Analisis Case Conference
            'aspek_hukum' => 'nullable|string',
            'aspek_medis' => 'nullable|string',
            'kesehatan_fisik' => 'nullable|string',
            'psikologi' => 'nullable|string',
            'alasan_penggunaan' => 'nullable|string',
            'kondisi_keluarga' => 'nullable|string',
            'tingkat_ketergantungan' => 'nullable|string|max:255',
            'pola_pemakaian' => 'nullable|string|max:255',
            'kondisi_lingkungan' => 'nullable|string',
            'saran_case_conference' => 'nullable|string',
        ]);

        Asesmen::create($validatedData);

        return redirect()->route('asesmen.index')->with('success', 'Data Asesmen & Case Conference berhasil ditambahkan!');
    }

    /**
     * Menampilkan halaman Detail Data (Show)
     */
    public function show(string $id)
    {
        $asesmen = Asesmen::with(['narkotika', 'pendidikan', 'pekerjaan', 'rekomendasi'])->findOrFail($id);
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
            'asesmen',
            'masterPendidikan',
            'masterPekerjaan',
            'masterNarkotika',
            'masterRekomendasi'
        ));
    }

    /**
     * Menyimpan perubahan data ke database (Update)
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            // Administrasi Surat & Registrasi
            'no_register' => 'nullable|string|max:100',
            'no_bln' => 'nullable|string|max:100',
            'asal_pengajuan' => 'nullable|string|max:255',
            'no_surat_pengajuan' => 'nullable|string|max:100',
            'no_lkn' => 'nullable|string|max:100',
            'tgl_surat' => 'nullable|date',
            'tgl_berkas' => 'nullable|date',
            'tgl_pelaksanaan' => 'nullable|date',
            'tgl_tangkap' => 'nullable|date',

            // Identitas Klien
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:16',
            'kewarganegaraan' => 'nullable|string|max:100',
            'agama' => 'nullable|string|max:100',
            'tempat_lahir' => 'nullable|string|max:255',
            'tgl_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'nullable|string|max:20',
            'pendidikan_id' => 'nullable',
            'pekerjaan_id' => 'nullable',
            'penghasilan_rata_rata' => 'nullable|string|max:255',
            'alamat_ktp' => 'nullable|string',
            'alamat_domisili' => 'nullable|string',

            // Perkara Hukum & Barang Bukti
            'narkotika_id' => 'nullable',
            'berat_bb' => 'nullable|numeric',
            'deskripsi_bb' => 'nullable|string',
            'pasal_sangkaan' => 'nullable|string',
            'status_hukum' => 'nullable|string|max:255',
            'keterlibatan_jaringan' => 'nullable|string|max:255',
            'cara_mendapatkan' => 'nullable|string|max:255',
            'dapat_dari_siapa' => 'nullable|string|max:255',
            'tes_urine' => 'nullable|string|max:50',

            // Hasil Asesmen Awal (Rekap TAT)
            'hasil_asesmen_hukum' => 'nullable|string',
            'hasil_asesmen_medis' => 'nullable|string',
            'rekomendasi_id' => 'nullable',
            'pelaksanaan' => 'nullable|in:YA,TIDAK',
            'keterangan_tambahan' => 'nullable|string',

            // Analisis Case Conference
            'aspek_hukum' => 'nullable|string',
            'aspek_medis' => 'nullable|string',
            'kesehatan_fisik' => 'nullable|string',
            'psikologi' => 'nullable|string',
            'alasan_penggunaan' => 'nullable|string',
            'kondisi_keluarga' => 'nullable|string',
            'tingkat_ketergantungan' => 'nullable|string|max:255',
            'pola_pemakaian' => 'nullable|string|max:255',
            'kondisi_lingkungan' => 'nullable|string',
            'saran_case_conference' => 'nullable|string',
        ]);

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
    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv'
        ], [
            'file_excel.required' => 'Anda belum memilih file Excel.',
            'file_excel.mimes' => 'Format file harus berupa .xlsx, .xls, atau .csv'
        ]);

        try {
            Excel::import(new AsesmenImport, $request->file('file_excel'));
            return redirect()->route('asesmen.index')->with('success', 'Data Excel Asesmen berhasil diimpor ke database!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimpor data. Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Mengunduh Template Excel Kosong beserta petunjuk pengisian
     */
    public function downloadTemplate()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'A' => 'NO.',
            'B' => 'NAMA LENGKAP',
            'C' => 'NIK',
            'D' => 'KEWARGANEGARAAN',
            'E' => 'TEMPAT LAHIR',
            'F' => 'TANGGAL LAHIR',
            'G' => 'JENIS KELAMIN (L/P)',
            'H' => 'NO HP',
            'I' => 'PENDIDIKAN',
            'J' => 'PEKERJAAN',
            'K' => 'PENGHASILAN RATA-RATA',
            'L' => 'ALAMAT KTP',
            'M' => 'ALAMAT DOMISILI',
            'N' => 'NO REGISTRASI',
            'O' => 'NO/BLN',
            'P' => 'ASAL PENGAJUAN',
            'Q' => 'NO SURAT PENGAJUAN',
            'R' => 'NO LKN',
            'S' => 'TGL SURAT',
            'T' => 'TGL BERKAS',
            'U' => 'TGL PELAKSANAAN',
            'V' => 'TGL TANGKAP',
            'W' => 'JENIS NARKOTIKA',
            'X' => 'BERAT BUKTI (gr)',
            'Y' => 'BARANG BUKTI (DESKRIPSI)',
            'Z' => 'PASAL YANG DISANGKAKAN',
            'AA' => 'STATUS HUKUM',
            'AB' => 'KETERLIBATAN JARINGAN',
            'AC' => 'CARA MENDAPATKAN',
            'AD' => 'DAPAT DARI SIAPA',
            'AE' => 'KESEHATAN FISIK',
            'AF' => 'PSIKOLOGI',
            'AG' => 'HASIL TES URINE',
            'AH' => 'TINGKAT KETERGANTUNGAN',
            'AI' => 'POLA PEMAKAIAN',
            'AJ' => 'ALASAN PENGGUNAAN',
            'AK' => 'KONDISI KELUARGA',
            'AL' => 'KONDISI LINGKUNGAN',
            'AM' => 'HASIL ASESMEN HUKUM',
            'AN' => 'HASIL ASESMEN MEDIS',
            'AO' => 'REKOMENDASI TAT',
            'AP' => 'PELAKSANAAN REKOMENDASI (YA/TIDAK)',
            'AQ' => 'KETERANGAN TAMBAHAN',
            'AR' => 'SARAN CASE CONFERENCE'
        ];

        foreach ($headers as $col => $val) {
            $sheet->setCellValue($col . '2', $val);
            $sheet->getColumnDimension($col)->setAutoSize(true);

            $sheet->getStyle($col . '2')->getFont()->setBold(true);
            $sheet->getStyle($col . '2')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFD3D3D3');
        }

        $sheet->mergeCells('A1:AR1');
        $sheet->setCellValue('A1', 'PETUNJUK PENGISIAN: Isi data mulai dari baris ke-4. Kolom tanggal mohon diisi dengan format YYYY-MM-DD (contoh: 2026-08-17). Kosongi sel jika data tidak ada.');
        $sheet->getStyle('A1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
        $sheet->getStyle('A1')->getFont()->setBold(true);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'Template_Import_Asesmen_Case_Conference.xlsx';

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

        return $pdf->stream('Berita_Acara_TAT_' . str_replace(' ', '_', $asesmen->nama_lengkap) . '.pdf');
    }

    public function beritaAcara(string $id)
    {
        $asesmen = \App\Models\Asesmen::with(['pendidikan', 'pekerjaan', 'anggotaTim'])->findOrFail($id);

        $masterMedis = \App\Models\MasterAnggota::where('kategori', 'medis')->get();
        $masterHukum = \App\Models\MasterAnggota::where('kategori', 'hukum')->get();

        // Panggil data Master Opsi
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

        // Variabel masterDiagnosis dikirimkan ke blade melalui compact()
        return view('asesmen.berita-acara', compact('asesmen', 'masterMedis', 'masterHukum', 'masterZat', 'masterTempatRehab', 'masterDiagnosis', 'klienData'));
    }

    public function generateBeritaAcara(\Illuminate\Http\Request $request, string $id)
    {
        $asesmen = \App\Models\Asesmen::findOrFail($id);

        // 1. Simpan/Update data ke database terlebih dahulu
        // (Pastikan kolom status_klien dan diagnosis_medis sudah Anda tambahkan di tabel asesmens jika ingin disave)
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

            // Variabel Kesimpulan
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

        // 2. Load Template Word (Pastikan path ini sesuai dengan letak file template Anda)
        $templatePath = storage_path('app/templates/template_berita_acara.docx');
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

        // --- MAPPING VARIABEL IDENTITAS & HEADER ---
        $templateProcessor->setValue('nama_lengkap', $asesmen->nama_lengkap ?? '-');
        $templateProcessor->setValue('no_register', $asesmen->no_register ?? '-');
        $templateProcessor->setValue('no_ba', $request->no_ba ?? '-');
        $templateProcessor->setValue('ketua_tat_nama', $request->ketua_tat_nama ?? '-');
        $templateProcessor->setValue('ketua_tat_nrp', $request->ketua_tat_nrp ?? '-');
        $templateProcessor->setValue('no_kep_tim', $request->no_kep_tim ?? '-');

        // --- MAPPING TANGGAL INDONESIA (Manual Tahun Huruf) ---
        if ($request->tgl_ba) {
            $tglBa = \Carbon\Carbon::parse($request->tgl_ba);
            $templateProcessor->setValue('tgl_ba', $tglBa->translatedFormat('d'));
            $templateProcessor->setValue('hari_ba', $tglBa->translatedFormat('l'));
            $templateProcessor->setValue('bln_ba', $tglBa->translatedFormat('F'));
            $templateProcessor->setValue('thn_ba', $tglBa->year);

            $tahunAngka = $tglBa->year;
            $tahunHuruf = '';
            if ($tahunAngka >= 2000 && $tahunAngka < 2100) {
                $puluhan = $tahunAngka % 100;
                $hurufAngka = [0 => '', 1 => 'satu', 2 => 'dua', 3 => 'tiga', 4 => 'empat', 5 => 'lima', 6 => 'enam', 7 => 'tujuh', 8 => 'delapan', 9 => 'sembilan', 10 => 'sepuluh', 11 => 'sebelas', 12 => 'dua belas', 13 => 'tiga belas', 14 => 'empat belas', 15 => 'lima belas', 16 => 'enam belas', 17 => 'tujuh belas', 18 => 'delapan belas', 19 => 'sembilan belas'];
                if ($puluhan < 20) {
                    $teksPuluhan = $hurufAngka[$puluhan];
                } else {
                    $puluhanBulat = floor($puluhan / 10);
                    $satuan = $puluhan % 10;
                    $teksPuluhan = $hurufAngka[$puluhanBulat] . ' puluh ' . $hurufAngka[$satuan];
                }
                $tahunHuruf = 'dua ribu ' . trim($teksPuluhan);
            } else {
                $tahunHuruf = (string) $tahunAngka;
            }
            $templateProcessor->setValue('thn_ba_huruf', $tahunHuruf);
        } else {
            $templateProcessor->setValue('tgl_ba', '-');
            $templateProcessor->setValue('hari_ba', '-');
            $templateProcessor->setValue('bln_ba', '-');
            $templateProcessor->setValue('thn_ba', '-');
            $templateProcessor->setValue('thn_ba_huruf', '-');
        }

        $templateProcessor->setValue('tgl_kep_tim', $request->tgl_kep_tim ? \Carbon\Carbon::parse($request->tgl_kep_tim)->translatedFormat('d F Y') : '-');
        $templateProcessor->setValue('alat_bukti_tgl_sk', $request->alat_bukti_tgl_sk ? \Carbon\Carbon::parse($request->alat_bukti_tgl_sk)->translatedFormat('d F Y') : '-');

        // --- MAPPING TIM MEDIS (Dinamis dengan cloneBlock) ---
        $medis = \App\Models\MasterAnggota::whereIn('id', (array) $request->tim_medis)->get();
        $templateProcessor->cloneBlock('block_medis', count($medis), true, true);
        foreach ($medis as $index => $m) {
            $i = $index + 1;
            $templateProcessor->setValue("no_medis#{$i}", $i);
            $templateProcessor->setValue("med_nama#{$i}", $m->nama);
            $templateProcessor->setValue("med_nip#{$i}", $m->nip_nrp_sip ?? '-');
            $templateProcessor->setValue("med_jabatan#{$i}", $m->jabatan ?? '-');
        }

        // --- MAPPING TIM HUKUM (Dinamis dengan cloneBlock) ---
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

        // --- MAPPING NARASI & ALAT BUKTI ---
        $templateProcessor->setValue('narasi_medis', $request->narasi_medis ?? '-');
        $templateProcessor->setValue('narasi_hukum', $request->narasi_hukum ?? '-');

        $templateProcessor->setValue('alat_bukti_no_sk', $request->alat_bukti_no_sk ?? '-');
        $templateProcessor->setValue('alat_bukti_dokter', $request->alat_bukti_dokter ?? '-');
        $templateProcessor->setValue('alat_bukti_hasil', $request->alat_bukti_hasil ?? '-');

        // --- MAPPING KESIMPULAN (Terbaru) ---
        $templateProcessor->setValue('status_klien', $request->status_klien ?? 'penyalahguna');
        $templateProcessor->setValue('kesimpulan_jenis_zat', $request->kesimpulan_jenis_zat ?? '-');
        $templateProcessor->setValue('kesimpulan_pola_pakai', $request->kesimpulan_pola_pakai ?? '-');
        $templateProcessor->setValue('kesimpulan_kategori', $request->kesimpulan_kategori ?? '-');
        $templateProcessor->setValue('diagnosis_medis', $request->diagnosis_medis ?? '-');

        // --- MAPPING REKOMENDASI ---
        $templateProcessor->setValue('rekomendasi_tempat_rehab', $request->rekomendasi_tempat_rehab ?? '-');
        $templateProcessor->setValue('rekomendasi_durasi', $request->rekomendasi_durasi ?? '-');
        $templateProcessor->setValue('rekomendasi_keterangan', $request->rekomendasi_keterangan ?? '-');

        // Membersihkan variabel lama/sisa (Jika masih ada di dokumen Word)
        $templateProcessor->setValue('pasal_sangkaan', '');
        $templateProcessor->setValue('hasil_lab_for', '');
        $templateProcessor->setValue('jenis_rehabilitasi', '');

        // --- OUTPUT & DOWNLOAD ---
        $fileName = 'Berita_Acara_TAT_' . str_replace(' ', '_', $asesmen->nama_lengkap) . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), 'word');
        $templateProcessor->saveAs($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }

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
            'asesmen',
            'riwayat_kepada',
            'riwayat_no_keputusan',
            'riwayat_tentang',
            'riwayat_narkotika',
            'riwayat_perawatan',
            'riwayat_diagnosis'
        ));
    }

    public function unduhRekomendasi(Request $request, string $id)
    {
        $asesmen = Asesmen::with(['rekomendasi', 'narkotika'])->findOrFail($id);

        $templatePath = storage_path('app/templates/template_rekomendasi.docx');
        if (!file_exists($templatePath)) {
            return redirect()->back()->with('error', 'Template Word tidak ditemukan.');
        }

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

        $templateProcessor->setValue('no_surat_rekomendasi', $request->no_surat_rekomendasi ?? '-');

        try {
            $tgl_rek = Carbon::parse($request->tgl_rekomendasi)->translatedFormat('d F Y');
        } catch (Exception $e) {
            $tgl_rek = $request->tgl_rekomendasi ?? '-';
        }
        $templateProcessor->setValue('tgl_rekomendasi', $tgl_rek);

        $templateProcessor->setValue('kepada_yth', $request->kepada_yth ?? '-');
        $templateProcessor->setValue('no_keputusan', $request->no_keputusan ?? '-');

        try {
            $tgl_kep = Carbon::parse($request->tgl_keputusan)->translatedFormat('d F Y');
        } catch (Exception $e) {
            $tgl_kep = $request->tgl_keputusan ?? '-';
        }
        $templateProcessor->setValue('tgl_keputusan', $tgl_kep);

        $templateProcessor->setValue('tentang_permohonan', $request->tentang_permohonan ?? '-');
        $templateProcessor->setValue('kewarganegaraan', $request->kewarganegaraan ?? 'Indonesia (WNI)');
        $templateProcessor->setValue('nama_narkotika', $request->nama_narkotika_medis ?? '-');
        $templateProcessor->setValue('keterangan_diagnosis', $request->keterangan_diagnosis ?? '-');
        $templateProcessor->setValue('lama_perawatan', $request->lama_perawatan ?? '-');

        $templateProcessor->setValue('nama_lengkap', $asesmen->nama_lengkap);
        $templateProcessor->setValue('nama_langkap', $asesmen->nama_lengkap);
        $templateProcessor->setValue('nam_lengkap', $asesmen->nama_lengkap);
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

    /**
     * Mengunduh Surat Rekomendasi Word langsung dari data Database yang tersimpan
     */
    public function downloadWordTerpakai(string $id)
    {
        $asesmen = Asesmen::with(['rekomendasi', 'narkotika'])->findOrFail($id);
        $templatePath = storage_path('app/templates/template_rekomendasi.docx');

        if (!file_exists($templatePath)) {
            return redirect()->back()->with('error', 'Template Word tidak ditemukan.');
        }

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

        // Mapping Data Administrasi Surat (Dari Database)
        $templateProcessor->setValue('no_surat_rekomendasi', $asesmen->no_surat_rekomendasi ?? '-');
        $templateProcessor->setValue('tgl_rekomendasi', $asesmen->tgl_rekomendasi ? \Carbon\Carbon::parse($asesmen->tgl_rekomendasi)->translatedFormat('d F Y') : '-');
        $templateProcessor->setValue('kepada_yth', $asesmen->kepada_yth ?? '-');
        $templateProcessor->setValue('no_keputusan', $asesmen->no_keputusan ?? '-');
        $templateProcessor->setValue('tgl_keputusan', $asesmen->tgl_keputusan ? \Carbon\Carbon::parse($asesmen->tgl_keputusan)->translatedFormat('d F Y') : '-');
        $templateProcessor->setValue('tentang_permohonan', $asesmen->tentang_permohonan ?? '-');
        $templateProcessor->setValue('kewarganegaraan', $asesmen->kewarganegaraan ?? 'Indonesia (WNI)');
        $templateProcessor->setValue('nama_narkotika', $asesmen->nama_narkotika_medis ?? '-');
        $templateProcessor->setValue('keterangan_diagnosis', $asesmen->keterangan_diagnosis ?? '-');
        $templateProcessor->setValue('lama_perawatan', $asesmen->lama_perawatan ?? '-');

        // Mapping Data Klien
        $templateProcessor->setValue('nama_lengkap', $asesmen->nama_lengkap);
        $templateProcessor->setValue('nama_langkap', $asesmen->nama_lengkap);
        $templateProcessor->setValue('nam_lengkap', $asesmen->nama_lengkap);
        $templateProcessor->setValue('nik', $asesmen->nik);
        $templateProcessor->setValue('tempat_lahir', $asesmen->tempat_lahir ?? '-');
        $templateProcessor->setValue('tgl_lahir', $asesmen->tgl_lahir ? \Carbon\Carbon::parse($asesmen->tgl_lahir)->translatedFormat('d F Y') : '-');

        $jk = $asesmen->jenis_kelamin == 'L' ? 'Laki-laki' : ($asesmen->jenis_kelamin == 'P' ? 'Perempuan' : '-');
        $templateProcessor->setValue('jenis_kelamin', $jk);
        $templateProcessor->setValue('alamat_ktp', $asesmen->alamat_ktp ?? '-');
        $templateProcessor->setValue('alamat_domisili', $asesmen->alamat_domisili ?? '-');
        $templateProcessor->setValue('no_surat_pengajuan', $asesmen->no_surat_pengajuan ?? '-');

        $tgl_pelaksanaan = $asesmen->tgl_pelaksanaan ? \Carbon\Carbon::parse($asesmen->tgl_pelaksanaan)->translatedFormat('d F Y') : '-';
        $hari_pelaksanaan = $asesmen->tgl_pelaksanaan ? \Carbon\Carbon::parse($asesmen->tgl_pelaksanaan)->translatedFormat('l') : '-';

        $templateProcessor->setValue('tgl_pelaksanaan', $tgl_pelaksanaan);
        $templateProcessor->setValue('tanggal_tat', $tgl_pelaksanaan);
        $templateProcessor->setValue('hari', $hari_pelaksanaan);
        $templateProcessor->setValue('jenis_narkotika', $asesmen->narkotika->jenis_narkotika ?? '-');
        $templateProcessor->setValue('tingkat_ketergantungan', $asesmen->tingkat_ketergantungan ?? '-');
        $templateProcessor->setValue('rekomendasi_tat', $asesmen->rekomendasi->tempat_rehabilitasi ?? '-');

        // Proses Unduh
        $fileName = 'Surat_Rekomendasi_TAT_' . str_replace(' ', '_', $asesmen->nama_lengkap) . '.docx';
        $tempPath = storage_path('app/temp_' . $fileName);

        $templateProcessor->saveAs($tempPath);
        return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);
    }
}