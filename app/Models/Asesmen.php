<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Asesmen extends Model
{
    use HasFactory;

    // Cukup gunakan ini agar semua kolom di tabel asesmens bisa diisi
    protected $guarded = [];

    protected $table = 'asesmens';

    // Konfigurasi Primary Key UUID
    protected $keyType = 'string';
    public $incrementing = false;

    // Event Booting: Otomatis generate UUID
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // --- Relasi BelongsTo ke Tabel Master ---
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

    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class, 'pendidikan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected $fillable = [
        'nama_lengkap',
        'nik',
        'tempat_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'no_hp',
        'pendidikan_id',
        'pekerjaan_id',
        'alamat_ktp',
        'alamat_domisili',
        'no_register',
        'no_bln',
        'no_surat_pengajuan',
        'no_lkn',
        'tgl_surat',
        'tgl_berkas',
        'tgl_pelaksanaan',
        'tgl_tangkap',
        'narkotika_id',
        'berat_bb',
        'pasal_sangkaan',
        'hasil_asesmen_hukum',
        'hasil_asesmen_medis',
        'rekomendasi_id',
        'pelaksanaan',

        // -- KOLOM BARU CASE CONFERENCE --
        'penghasilan_rata_rata',
        'status_hukum',
        'keterlibatan_jaringan',
        'cara_mendapatkan',
        'dapat_dari',
        'kesehatan',
        'psikologi',
        'tes_urine',
        'alasan_penggunaan',
        'kondisi_keluarga',
        'tingkat_ketergantungan',
        'pola_pemakaian',
        'kondisi_lingkungan',
        'keterangan',
        'saran'
    ];
}