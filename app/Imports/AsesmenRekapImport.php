<?php

namespace App\Imports;

use App\Models\Asesmen;
use App\Models\Narkotika;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Rekomendasi;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Exception;

class AsesmenRekapImport implements ToCollection, WithStartRow
{
    protected bool $updateExisting;

    public function __construct($updateExisting = false)
    {
        $this->updateExisting = $updateExisting;
    }

    public function startRow(): int
    {
        return 4;
    }

    private function parseDecimal(string $value)
    {
        if ($value === null || trim((string) $value) === '' || trim((string) $value) === '-')
            return null;
        $cleaned = str_replace(',', '.', trim((string) $value));
        $cleaned = preg_replace('/[^0-9.]/', '', $cleaned);
        return is_numeric($cleaned) ? (float) $cleaned : null;
    }

    private function parseDate(string $value)
    {
        if (empty($value) || trim((string) $value) === '-' || trim((string) $value) === '')
            return null;
        if (is_numeric($value)) {
            try {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }
        $bulanIndo = ['januari' => 'January', 'februari' => 'February', 'maret' => 'March', 'april' => 'April', 'mei' => 'May', 'juni' => 'June', 'juli' => 'July', 'agustus' => 'August', 'september' => 'September', 'oktober' => 'October', 'november' => 'November', 'desember' => 'December', 'jan' => 'Jan', 'feb' => 'Feb', 'mar' => 'Mar', 'apr' => 'Apr', 'jun' => 'Jun', 'jul' => 'Jul', 'agt' => 'Aug', 'aug' => 'Aug', 'sep' => 'Sep', 'okt' => 'Oct', 'oct' => 'Oct', 'nov' => 'Nov', 'des' => 'Dec'];
        $dateStr = str_ireplace(array_keys($bulanIndo), array_values($bulanIndo), strtolower(trim((string) $value)));
        try {
            return Carbon::parse($dateStr)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    private function parseJenisKelamin(string $value)
    {
        $val = strtoupper(trim((string) $value));
        if (in_array($val, ['L', 'LAKI-LAKI', 'LAKI LAKI', 'PRIA']))
            return 'L';
        if (in_array($val, ['P', 'PEREMPUAN', 'WANITA']))
            return 'P';
        return '-';
    }

    // FUNGSI SMART MERGE
    private function assignValue(\App\Models\Asesmen $model, string $field, string|null $value)
    {
        $val = trim((string) $value);
        if ($val !== '' && $val !== '-') {
            $model->$field = $val;
        } else {
            if (empty($model->$field) || $model->$field === '-') {
                $model->$field = '-';
            }
        }
    }


    public function collection(Collection $rows)
    {
        // ==========================================
        // 1. CEK DUPLIKASI NO. REGISTER (Mode Insert Baru)
        // ==========================================
        if (!$this->updateExisting) {
            foreach ($rows as $row) {
                $kolomA = strtoupper(trim((string) ($row[0] ?? '')));
                if (empty($row[9]) || strpos($kolomA, 'NO') !== false || strpos($kolomA, 'REKAP DATA TAT') !== false)
                    continue;

                // Ambil No Register dari index array yang benar (Indeks ke-10 berdasarkan pemetaan kode di bawah)
                $noRegisterExcel = trim((string) ($row[10] ?? ''));

                if ($noRegisterExcel !== '' && $noRegisterExcel !== '-') {
                    $existingKasus = Asesmen::where('no_register', $noRegisterExcel)->first();
                    if ($existingKasus) {
                        throw new Exception("Kasus dengan No Register \"{$noRegisterExcel}\" sudah terdaftar di sistem! Silakan centang kotak opsi 'Perbarui Data Lama' jika Anda ingin menimpanya.");
                    }
                }
            }
        }

        // ==========================================
        // 2. PROSES INSERT ATAU UPDATE
        // ==========================================
        foreach ($rows as $row) {
            $kolomA = strtoupper(trim((string) ($row[0] ?? '')));
            if (empty($row[9]) || strpos($kolomA, 'NO') !== false || strpos($kolomA, 'REKAP DATA TAT') !== false)
                continue;

            $namaExcel = mb_strtoupper(trim($row[9] ?? ''), 'UTF-8');
            $nikExcel = isset($row[20]) ? trim(str_replace("'", "", $row[20])) : '-';
            $noRegisterExcel = trim((string) ($row[10] ?? ''));

            $asesmen = null;

            // Jika "Update Data", maka cari datanya DARI NOMOR REGISTER
            if ($this->updateExisting && $noRegisterExcel !== '' && $noRegisterExcel !== '-') {
                $asesmen = Asesmen::where('no_register', $noRegisterExcel)->first();
            }

            // Jika tidak ada atau Insert Baru, buat instansi baru
            if (!$asesmen) {
                $asesmen = new Asesmen();
                // Selalu catat NIK apa adanya dari Excel, biarpun kembar dengan klien lain.
                $asesmen->nik = ($nikExcel === '' || $nikExcel === null) ? '-' : $nikExcel;
            } else {
                // Update NIK jika NIK lama kosong
                if (($asesmen->nik === '-' || empty($asesmen->nik)) && $nikExcel !== '-' && $nikExcel !== '') {
                    $asesmen->nik = $nikExcel;
                }
            }

            // === PEMETAAN DENGAN SMART MERGE ===
            $this->assignValue($asesmen, 'nama_lengkap', $namaExcel);
            $this->assignValue($asesmen, 'no_bln', $row[1] ?? '');
            $this->assignValue($asesmen, 'asal_pengajuan', $row[2] ?? '');

            $tglSurat = $this->parseDate($row[3] ?? null);
            if ($tglSurat)
                $asesmen->tgl_surat = $tglSurat;
            $tglBerkas = $this->parseDate($row[4] ?? null);
            if ($tglBerkas)
                $asesmen->tgl_berkas = $tglBerkas;
            $tglPelaksanaan = $this->parseDate($row[5] ?? null);
            if ($tglPelaksanaan)
                $asesmen->tgl_pelaksanaan = $tglPelaksanaan;

            $this->assignValue($asesmen, 'no_surat_pengajuan', $row[6] ?? '');
            $this->assignValue($asesmen, 'no_lkn', $row[7] ?? '');

            $tglTangkap = $this->parseDate($row[8] ?? null);
            if ($tglTangkap)
                $asesmen->tgl_tangkap = $tglTangkap;

            $this->assignValue($asesmen, 'no_register', $noRegisterExcel); // Set nilai no_register
            $this->assignValue($asesmen, 'alamat_ktp', $row[11] ?? '');
            $this->assignValue($asesmen, 'alamat_domisili', $row[12] ?? '');
            $this->assignValue($asesmen, 'tempat_lahir', $row[13] ?? '');

            $tglLahir = $this->parseDate($row[14] ?? null);
            if ($tglLahir)
                $asesmen->tgl_lahir = $tglLahir;

            $jk = $this->parseJenisKelamin($row[15] ?? '');
            if ($jk !== '-')
                $asesmen->jenis_kelamin = $jk;
            elseif (empty($asesmen->jenis_kelamin))
                $asesmen->jenis_kelamin = '-';

            $usiaBersih = preg_replace('/[^0-9]/', '', $row[16] ?? '');
            if ($usiaBersih !== '')
                $asesmen->usia = (int) $usiaBersih;

            $pendidikanVal = trim($row[17] ?? '');
            if ($pendidikanVal !== '' && $pendidikanVal !== '-') {
                $asesmen->pendidikan_id = Pendidikan::firstOrCreate(['nama_pendidikan' => $pendidikanVal])->id;
            } elseif (empty($asesmen->pendidikan_id)) {
                $asesmen->pendidikan_id = Pendidikan::firstOrCreate(['nama_pendidikan' => '-'])->id;
            }

            $pekerjaanVal = trim($row[18] ?? '');
            if ($pekerjaanVal !== '' && $pekerjaanVal !== '-') {
                $asesmen->pekerjaan_id = Pekerjaan::firstOrCreate(['nama_pekerjaan' => $pekerjaanVal])->id;
            } elseif (empty($asesmen->pekerjaan_id)) {
                $asesmen->pekerjaan_id = Pekerjaan::firstOrCreate(['nama_pekerjaan' => '-'])->id;
            }

            $this->assignValue($asesmen, 'no_hp', $row[19] ?? '');

            $narkotikaVal = trim($row[21] ?? '');
            if ($narkotikaVal !== '' && $narkotikaVal !== '-') {
                $asesmen->narkotika_id = Narkotika::firstOrCreate(['jenis_narkotika' => $narkotikaVal])->id;
            } elseif (empty($asesmen->narkotika_id)) {
                $asesmen->narkotika_id = Narkotika::firstOrCreate(['jenis_narkotika' => '-'])->id;
            }

            $beratBb = $this->parseDecimal($row[22] ?? null);
            if ($beratBb !== null)
                $asesmen->berat_bb = $beratBb;

            $this->assignValue($asesmen, 'pasal_sangkaan', $row[23] ?? '');
            $this->assignValue($asesmen, 'hasil_asesmen_hukum', $row[24] ?? '');
            $this->assignValue($asesmen, 'hasil_asesmen_medis', $row[25] ?? '');

            // Rekomendasi
            $rekRaw = '-';
            if (!empty(trim($row[26] ?? '')))
                $rekRaw = 'Rawat Jalan - ' . trim($row[26]);
            elseif (!empty(trim($row[27] ?? '')))
                $rekRaw = 'Rawat Inap - ' . trim($row[27]);
            elseif (!empty(trim($row[28] ?? '')))
                $rekRaw = 'Rehab di Lapas / Rutan - ' . trim($row[28]);
            elseif (!empty(trim($row[29] ?? '')))
                $rekRaw = 'Tidak Rehab (Proses Hukum) - ' . trim($row[29]);

            if ($rekRaw !== '-') {
                $asesmen->rekomendasi_id = Rekomendasi::firstOrCreate(['tempat_rehabilitasi' => $rekRaw])->id;
            } elseif (empty($asesmen->rekomendasi_id)) {
                $asesmen->rekomendasi_id = Rekomendasi::firstOrCreate(['tempat_rehabilitasi' => '-'])->id;
            }

            $pelaksanaan = !empty(trim($row[30] ?? '')) ? 'YA' : 'TIDAK';
            if ($pelaksanaan === 'YA') {
                $asesmen->pelaksanaan = 'YA';
            } elseif (empty($asesmen->pelaksanaan)) {
                $asesmen->pelaksanaan = 'TIDAK';
            }

            $this->assignValue($asesmen, 'keterangan_tambahan', $row[32] ?? '');

            // Simpan Perubahan
            $asesmen->save();
        }
    }
}
