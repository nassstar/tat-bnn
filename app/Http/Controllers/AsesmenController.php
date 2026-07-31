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

class AsesmenController extends Controller
{
    /**
     * Menampilkan halaman utama Data Asesmen TAT (Tabel Index)
     */
    public function index()
    {
        // Eager Loading: Menarik semua relasi agar lebih cepat (termasuk Narkotika)
        $asesmens = Asesmen::with(['narkotika', 'pendidikan', 'pekerjaan'])->paginate(10);
        return view('asesmen.index', compact('asesmens'));
    }

    /**
     * Menampilkan form tambah data manual (Create)
     */
    public function create()
    {
        // Ambil semua data dari tabel master untuk dropdown
        $pendidikans = Pendidikan::all();
        $pekerjaans = Pekerjaan::all();
        $narkotikas = Narkotika::all();
        $rekomendasis = Rekomendasi::all();

        return view('asesmen.create', compact('pendidikans', 'pekerjaans', 'narkotikas', 'rekomendasis'));
    }

    /**
     * Menyimpan data baru ke database (Store)
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // -- VALIDASI DATA LAMA (Contoh) --
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:16',
            'tempat_lahir' => 'nullable|string|max:255',
            'tgl_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'no_hp' => 'nullable|string|max:20',
            'pendidikan_id' => 'nullable|integer|exists:m_pendidikans,id', // Sesuaikan nama tabel master jika beda
            'pekerjaan_id' => 'nullable|integer|exists:m_pekerjaans,id',  // Sesuaikan nama tabel master jika beda
            'alamat_ktp' => 'nullable|string',
            'alamat_domisili' => 'nullable|string',

            'no_register' => 'nullable|string|max:100',
            'no_bln' => 'nullable|string|max:100',
            'no_surat_pengajuan' => 'nullable|string|max:100',
            'no_lkn' => 'nullable|string|max:100',
            'tgl_surat' => 'nullable|date',
            'tgl_berkas' => 'nullable|date',
            'tgl_pelaksanaan' => 'nullable|date',

            'tgl_tangkap' => 'nullable|date',
            'narkotika_id' => 'nullable|integer',
            'berat_bb' => 'nullable|string|max:100',
            'pasal_sangkaan' => 'nullable|string|max:255',

            'hasil_asesmen_hukum' => 'nullable|string',
            'hasil_asesmen_medis' => 'nullable|string',
            'rekomendasi_id' => 'nullable|integer',
            'pelaksanaan' => 'nullable|in:YA,TIDAK',

            // -- VALIDASI KOLOM BARU CASE CONFERENCE --
            'penghasilan_rata_rata' => 'nullable|string|max:255',
            'status_hukum' => 'nullable|string|max:255',
            'keterlibatan_jaringan' => 'nullable|string|max:255',
            'cara_mendapatkan' => 'nullable|string|max:255',
            'dapat_dari' => 'nullable|string|max:255',
            'kesehatan' => 'nullable|string',
            'psikologi' => 'nullable|string',
            'tes_urine' => 'nullable|in:Positif,Negatif',
            'alasan_penggunaan' => 'nullable|string',
            'kondisi_keluarga' => 'nullable|string',
            'tingkat_ketergantungan' => 'nullable|string|max:255',
            'pola_pemakaian' => 'nullable|string|max:255',
            'kondisi_lingkungan' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'saran' => 'nullable|string',
        ]);

        // Simpan ke database
        Asesmen::create($validatedData);

        return redirect()->route('asesmen.index')->with('success', 'Data Asesmen berhasil ditambahkan!');
    }

    /**
     * Menampilkan halaman Detail Data (Show)
     */
    public function show(string $id)
    {
        // Menggunakan findOrFail lebih aman agar jika ID tidak ada, langsung 404
        $asesmen = Asesmen::findOrFail($id);

        return view('asesmen.show', compact('asesmen'));
    }

    /**
     * Menampilkan form edit data (Edit)
     */
    public function edit( string $id)
    {
        $asesmen = Asesmen::findOrFail($id);

        // Ambil data masternya untuk dropdown
        $pendidikans = Pendidikan::all();
        $pekerjaans = Pekerjaan::all();
        $narkotikas = Narkotika::all();
        $rekomendasis = Rekomendasi::all();

        return view('asesmen.edit', compact('asesmen', 'pendidikans', 'pekerjaans', 'narkotikas', 'rekomendasis'));
    }

    /**
     * Menyimpan perubahan data ke database (Update)
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            // -- VALIDASI DATA LAMA --
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:16',
            'tempat_lahir' => 'nullable|string|max:255',
            'tgl_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'no_hp' => 'nullable|string|max:20',
            'pendidikan_id' => 'nullable|integer',
            'pekerjaan_id' => 'nullable|integer',
            'alamat_ktp' => 'nullable|string',
            'alamat_domisili' => 'nullable|string',

            'no_register' => 'nullable|string|max:100',
            'no_bln' => 'nullable|string|max:100',
            'no_surat_pengajuan' => 'nullable|string|max:100',
            'no_lkn' => 'nullable|string|max:100',
            'tgl_surat' => 'nullable|date',
            'tgl_berkas' => 'nullable|date',
            'tgl_pelaksanaan' => 'nullable|date',

            'tgl_tangkap' => 'nullable|date',
            'narkotika_id' => 'nullable|integer',
            'berat_bb' => 'nullable|string|max:100',
            'pasal_sangkaan' => 'nullable|string|max:255',

            'hasil_asesmen_hukum' => 'nullable|string',
            'hasil_asesmen_medis' => 'nullable|string',
            'rekomendasi_id' => 'nullable|integer',
            'pelaksanaan' => 'nullable|in:YA,TIDAK',

            // -- VALIDASI KOLOM BARU CASE CONFERENCE --
            'penghasilan_rata_rata' => 'nullable|string|max:255',
            'status_hukum' => 'nullable|string|max:255',
            'keterlibatan_jaringan' => 'nullable|string|max:255',
            'cara_mendapatkan' => 'nullable|string|max:255',
            'dapat_dari' => 'nullable|string|max:255',
            'kesehatan' => 'nullable|string',
            'psikologi' => 'nullable|string',
            'tes_urine' => 'nullable|in:Positif,Negatif',
            'alasan_penggunaan' => 'nullable|string',
            'kondisi_keluarga' => 'nullable|string',
            'tingkat_ketergantungan' => 'nullable|string|max:255',
            'pola_pemakaian' => 'nullable|string|max:255',
            'kondisi_lingkungan' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'saran' => 'nullable|string',
        ]);

        // Cari data berdasarkan ID dan Update
        $asesmen = Asesmen::findOrFail($id);
        $asesmen->update($validatedData);

        return redirect()->route('asesmen.index')->with('success', 'Data Asesmen berhasil diperbarui!');
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
    /**
     * Mengunduh Template Excel Kosong beserta petunjuk pengisian
     */
    public function downloadTemplate()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 1. Tulis Header di Baris ke-2
        $headers = [
            'A' => 'KOSONG',
            'B' => 'NO.',
            'C' => 'NO/BLN',
            'D' => 'TGL SURAT',
            'E' => 'TGL BERKAS',
            'F' => 'TGL PELAKSANAAN',
            'G' => 'NO SURAT',
            'H' => 'NO LKN',
            'I' => 'TGL TANGKAP',
            'J' => 'NAMA',
            'K' => 'NO REG',
            'L' => 'ALAMAT KTP',
            'M' => 'ALAMAT DOMISILI',
            'N' => 'TMP LAHIR',
            'O' => 'TGL LAHIR',
            'P' => 'JENIS KELAMIN (L/P)',
            'Q' => 'USIA',
            'R' => 'PENDIDIKAN',
            'S' => 'PEKERJAAN',
            'T' => 'NO HP',
            'U' => 'NIK',
            'V' => 'PENGHASILAN RATA-RATA', // Tambahan Baru

            // Aspek Perkara & Hukum
            'W' => 'JENIS NARKOTIKA',
            'X' => 'BERAT (gr)',
            'Y' => 'PASAL YANG DISANGKAKAN',
            'Z' => 'STATUS HUKUM', // Tambahan Baru
            'AA' => 'KETERLIBATAN JARINGAN', // Tambahan Baru
            'AB' => 'CARA MENDAPATKAN', // Tambahan Baru
            'AC' => 'DAPAT DARI SIAPA', // Tambahan Baru

            // Aspek Medis & Psikososial
            'AD' => 'KESEHATAN FISIK', // Tambahan Baru
            'AE' => 'PSIKOLOGI', // Tambahan Baru
            'AF' => 'HASIL TES URINE', // Tambahan Baru
            'AG' => 'ALASAN PENGGUNAAN', // Tambahan Baru
            'AH' => 'KONDISI KELUARGA', // Tambahan Baru
            'AI' => 'TINGKAT KETERGANTUNGAN', // Tambahan Baru
            'AJ' => 'POLA PEMAKAIAN', // Tambahan Baru
            'AK' => 'KONDISI LINGKUNGAN', // Tambahan Baru

            // Kesimpulan TAT
            'AL' => 'HASIL ASESMEN HUKUM',
            'AM' => 'HASIL ASESMEN MEDIS',
            'AN' => 'REKOMENDASI TAT',
            'AO' => 'PELAKSANAAN REKOMENDASI',
            'AP' => 'KETERANGAN TAMBAHAN', // Tambahan Baru
            'AQ' => 'SARAN CASE CONFERENCE' // Tambahan Baru
        ];

        foreach ($headers as $col => $val) {
            $sheet->setCellValue($col . '2', $val);
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $sheet->getStyle($col . '2')->getFont()->setBold(true);
        }

        // 2. Berikan Petunjuk Pengisian di Baris ke-3
        $sheet->setCellValue('J3', 'Mohon isi data mulai baris ke-4 ke bawah.');
        $sheet->getStyle('J3')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);

        // 3. Ekspor dan Otomatis Download
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
        // 1. Cari data asesmen berdasarkan ID (mendukung UUID)
        // Jika data tidak ditemukan, akan otomatis memunculkan halaman 404 Not Found
        $asesmen = Asesmen::findOrFail($id);

        // 2. Arahkan ke file blade 'berita-acara.blade.php' di folder 'resources/views/asesmen/'
        // dan kirimkan variabel $asesmen ke view tersebut
        return view('asesmen.berita-acara', compact('asesmen'));
    }
    public function rekomendasi(string $id)
    {
        // Cari data asesmen berdasarkan ID
        $asesmen = Asesmen::findOrFail($id);

        // Arahkan ke file blade 'rekomendasi.blade.php' di folder 'resources/views/asesmen/'
        return view('asesmen.rekomendasi', compact('asesmen'));
    }

}
