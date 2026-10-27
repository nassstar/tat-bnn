<?php

namespace App\Imports;

use App\Models\Asesmen;
use App\Models\Pendidikan;
use App\Models\Pekerjaan;
use App\Models\Rekomendasi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Exception;

class AsesmenCaseConfImport implements ToCollection, WithStartRow
{
    protected $updateExisting;

    public function __construct($updateExisting = false)
    {
        $this->updateExisting = $updateExisting;
    }

    public function startRow(): int
    {
        return 4;
    }

    // FUNGSI SMART MERGE: Hanya timpa jika data Excel terisi (bukan kosong/strip)
    private function assignValue($model, $field, $value)
    {
        $val = trim((string) $value);
        if ($val !== '' && $val !== '-') {
            $model->$field = $val;
        } else {
            // Jika Excel kosong, dan database juga kosong, baru isi strip
            if (empty($model->$field) || $model->$field === '-') {
                $model->$field = '-';
            }
        }
    }

    public function collection(Collection $rows)
    {
        // ==========================================================
        // TAHAP 1: PRE-SCAN (ANTI DUPLIKAT GANDA)
        // ==========================================================
        if (!$this->updateExisting) {
            foreach ($rows as $row) {
                if (empty($row[1]) && empty($row[2]))
                    continue;

                $namaExcel = mb_strtoupper(trim($row[1] ?? ''), 'UTF-8');
                $nikExcel = trim(str_replace("'", "", $row[2] ?? ''));

                $existingKlien = null;

                // Cari pakai NIK dulu
                if ($nikExcel !== '-' && $nikExcel !== '') {
                    $existingKlien = Asesmen::where('nik', $nikExcel)->first();
                }
                // Jika NIK tidak ketemu, cari pakai Nama
                if (!$existingKlien && $namaExcel !== '' && $namaExcel !== '-') {
                    $existingKlien = Asesmen::where('nama_lengkap', $namaExcel)->first();
                }

                if ($existingKlien) {
                    $namaLama = $existingKlien->nama_lengkap;
                    $nikLama = $existingKlien->nik;
                    throw new Exception("Data atas nama \"{$namaLama}\" (NIK: {$nikLama}) sudah terdaftar! Silakan centang kotak opsi 'Perbarui Data Lama'.");
                }
            }
        }

        // ==========================================================
        // TAHAP 2: PROSES PENYIMPANAN & PENGGABUNGAN CERDAS (MERGE)
        // ==========================================================
        foreach ($rows as $row) {
            if (empty($row[1]) && empty($row[2]))
                continue;

            $namaExcel = mb_strtoupper(trim($row[1] ?? ''), 'UTF-8');
            $nikExcel = trim(str_replace("'", "", $row[2] ?? ''));

            $asesmen = null;

            // Cari pakai NIK
            if ($nikExcel !== '-' && $nikExcel !== '') {
                $asesmen = Asesmen::where('nik', $nikExcel)->first();
            }
            // Cari pakai Nama (Fallback jika NIK beda/kosong)
            if (!$asesmen && $namaExcel !== '' && $namaExcel !== '-') {
                $asesmen = Asesmen::where('nama_lengkap', $namaExcel)->first();
            }

            // Jika Klien benar-benar baru
            if (!$asesmen) {
                $asesmen = new Asesmen();
                $asesmen->nik = ($nikExcel === '' || $nikExcel === '-') ? '-' : $nikExcel;
            } else {
                // Jika Klien ada tapi NIK sebelumnya kosong, update NIK-nya
                if (($asesmen->nik === '-' || empty($asesmen->nik)) && $nikExcel !== '-' && $nikExcel !== '') {
                    $asesmen->nik = $nikExcel;
                }
            }

            // --- PEMETAAN DENGAN SMART MERGE ---
            $this->assignValue($asesmen, 'nama_lengkap', $namaExcel);

            $usiaBersih = preg_replace('/[^0-9]/', '', $row[3] ?? '');
            if ($usiaBersih !== '')
                $asesmen->usia = (int) $usiaBersih;

            $jk = strtoupper(trim($row[4] ?? ''));
            if ($jk == 'P' || $jk == 'PEREMPUAN') {
                $asesmen->jenis_kelamin = 'P';
            } elseif ($jk == 'L' || $jk == 'LAKI-LAKI' || $jk == 'LAKI LAKI' || $jk == 'PRIA') {
                $asesmen->jenis_kelamin = 'L';
            } elseif (empty($asesmen->jenis_kelamin)) {
                $asesmen->jenis_kelamin = '-';
            }

            $pekerjaanVal = trim($row[5] ?? '');
            if ($pekerjaanVal !== '' && $pekerjaanVal !== '-') {
                $asesmen->pekerjaan_id = Pekerjaan::firstOrCreate(['nama_pekerjaan' => $pekerjaanVal])->id;
            } elseif (empty($asesmen->pekerjaan_id)) {
                $asesmen->pekerjaan_id = Pekerjaan::firstOrCreate(['nama_pekerjaan' => '-'])->id;
            }

            $pendidikanVal = trim($row[6] ?? '');
            if ($pendidikanVal !== '' && $pendidikanVal !== '-') {
                $asesmen->pendidikan_id = Pendidikan::firstOrCreate(['nama_pendidikan' => $pendidikanVal])->id;
            } elseif (empty($asesmen->pendidikan_id)) {
                $asesmen->pendidikan_id = Pendidikan::firstOrCreate(['nama_pendidikan' => '-'])->id;
            }

            $this->assignValue($asesmen, 'alamat_domisili', $row[7] ?? '');
            $this->assignValue($asesmen, 'status_hukum', $row[8] ?? '');
            $this->assignValue($asesmen, 'keterlibatan_jaringan', $row[9] ?? '');
            $this->assignValue($asesmen, 'deskripsi_bb', $row[10] ?? '');
            $this->assignValue($asesmen, 'cara_mendapatkan', $row[11] ?? '');
            $this->assignValue($asesmen, 'dapat_dari_siapa', $row[12] ?? '');
            $this->assignValue($asesmen, 'kesehatan_fisik', $row[13] ?? '');
            $this->assignValue($asesmen, 'psikologi', $row[14] ?? '');
            $this->assignValue($asesmen, 'tes_urine', $row[15] ?? '');
            $this->assignValue($asesmen, 'alasan_penggunaan', $row[16] ?? '');
            $this->assignValue($asesmen, 'kondisi_keluarga', $row[17] ?? '');
            $this->assignValue($asesmen, 'tingkat_ketergantungan', $row[18] ?? '');
            $this->assignValue($asesmen, 'pola_pemakaian', $row[19] ?? '');
            $this->assignValue($asesmen, 'kondisi_lingkungan', $row[20] ?? '');

            $rekomendasiVal = trim($row[21] ?? '');
            if ($rekomendasiVal !== '' && $rekomendasiVal !== '-') {
                $asesmen->rekomendasi_id = Rekomendasi::firstOrCreate(['tempat_rehabilitasi' => $rekomendasiVal])->id;
            } elseif (empty($asesmen->rekomendasi_id)) {
                $asesmen->rekomendasi_id = Rekomendasi::firstOrCreate(['tempat_rehabilitasi' => '-'])->id;
            }

            $this->assignValue($asesmen, 'rekomendasi_keterangan', $row[22] ?? '');

            $this->assignValue($asesmen, 'saran_1', $row[23] ?? '');
            $this->assignValue($asesmen, 'saran_2', $row[24] ?? '');
            $this->assignValue($asesmen, 'saran_3', $row[25] ?? '');
            $this->assignValue($asesmen, 'saran_4', $row[26] ?? '');

            // Gabungkan untuk backup
            $saranArray = array_filter([
                trim($asesmen->saran_1) === '-' ? null : $asesmen->saran_1,
                trim($asesmen->saran_2) === '-' ? null : $asesmen->saran_2,
                trim($asesmen->saran_3) === '-' ? null : $asesmen->saran_3,
                trim($asesmen->saran_4) === '-' ? null : $asesmen->saran_4
            ]);
            $asesmen->saran_case_conference = !empty($saranArray) ? implode(', ', $saranArray) : '-';

            $asesmen->save();
        }
    }
}