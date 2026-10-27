<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Asesmen extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'asesmens';

    // PERBAIKAN: Gunakan $guarded, hapus $fillable. 
    // Ini mengizinkan semua kolom (termasuk foto_klien & no_hp) tersimpan ke database.
    protected $guarded = ['id'];

    // =========================================================================
    // RELASI DATABASE
    // =========================================================================

    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class, 'pendidikan_id');
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id');
    }

    public function narkotika()
    {
        return $this->belongsTo(Narkotika::class, 'narkotika_id');
    }

    public function rekomendasi()
    {
        return $this->belongsTo(Rekomendasi::class, 'rekomendasi_id');
    }

    public function anggotaTim()
    {
        return $this->belongsToMany(MasterAnggota::class, 'asesmen_anggota', 'asesmen_id', 'master_anggota_id');
    }

    public function anggota()
    {
        return $this->belongsToMany(MasterAnggota::class, 'asesmen_anggota', 'asesmen_id', 'master_anggota_id');
    }

    // =========================================================================
    // FITUR CEK KELENGKAPAN DATA (ACCESSOR)
    // =========================================================================
    // =========================================================================
    // FITUR CEK KELENGKAPAN DATA (ACCESSOR)
    // =========================================================================
    public function getStatusKelengkapanAttribute()
    {
        // 1. Daftar kolom yang WAJIB TERISI (Tidak termasuk Foto, Agama, dan Penghasilan)
        $kolomWajib = [
            'nama_lengkap',
            'nik',
            'no_register',
            'no_bln',
            'asal_pengajuan',
            'no_surat_pengajuan',
            'no_lkn',
            'tgl_surat',
            'tgl_berkas',
            'tgl_pelaksanaan',
            'tgl_tangkap',
            'tempat_lahir',
            'tgl_lahir',
            'jenis_kelamin',
            'kewarganegaraan',
            'alamat_ktp',
            'alamat_domisili',
            'berat_bb',
            'pasal_sangkaan',
            'deskripsi_bb',
            'status_hukum',
            'keterlibatan_jaringan',
            'cara_mendapatkan',
            'dapat_dari_siapa',
            'kesehatan_fisik',
            'psikologi',
            'tes_urine',
            'alasan_penggunaan',
            'kondisi_keluarga',
            'tingkat_ketergantungan',
            'pola_pemakaian',
            'kondisi_lingkungan',
            'saran_case_conference',
            'hasil_asesmen_hukum',
            'hasil_asesmen_medis'
        ];

        // Cek apakah ada kolom wajib di form utama yang kosong
        foreach ($kolomWajib as $kol) {
            if (is_null($this->$kol) || trim((string) $this->$kol) === '' || trim((string) $this->$kol) === '-') {
                return 'BELUM LENGKAP';
            }
        }

        // Cek Kelengkapan Dropdown Narkotika
        if (empty($this->narkotika_id) && empty($this->narkotika_input))
            return 'BELUM LENGKAP';

        // 2. Cek Kelengkapan Berita Acara (Minimal No BA & Ketua TAT harus ada)
        if (empty($this->no_ba) || empty($this->ketua_tat_nama) || trim((string) $this->no_ba) === '-') {
            return 'BELUM LENGKAP';
        }

        // 3. Cek Kelengkapan Rekomendasi (Minimal No Surat & Kepada Yth harus ada)
        if (empty($this->no_surat_rekomendasi) || empty($this->kepada_yth) || trim((string) $this->no_surat_rekomendasi) === '-') {
            return 'BELUM LENGKAP';
        }

        // Jika semua lolos pengecekan di atas, berarti Data Lengkap!
        return 'DATA LENGKAP';
    }

    public function getIsLengkapAttribute()
    {
        return $this->status_kelengkapan === 'DATA LENGKAP';
    }
}