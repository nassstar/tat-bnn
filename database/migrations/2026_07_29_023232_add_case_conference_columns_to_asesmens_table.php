<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('asesmens', function (Blueprint $table) {
            // Tambahan Aspek Ekonomi
            $table->string('penghasilan_rata_rata')->nullable()->after('pekerjaan_id');

            // Tambahan Aspek Hukum
            $table->string('status_hukum')->nullable()->after('pasal_sangkaan');
            $table->string('keterlibatan_jaringan')->nullable()->after('status_hukum');
            $table->string('cara_mendapatkan')->nullable()->after('keterlibatan_jaringan');
            $table->string('dapat_dari')->nullable()->after('cara_mendapatkan');

            // Tambahan Aspek Medis
            $table->text('kesehatan')->nullable()->after('hasil_asesmen_medis');
            $table->text('psikologi')->nullable()->after('kesehatan');
            $table->string('tes_urine')->nullable()->after('psikologi');

            // Tambahan Aspek Kondisi Klien & Lingkungan
            $table->text('alasan_penggunaan')->nullable()->after('tes_urine');
            $table->text('kondisi_keluarga')->nullable()->after('alasan_penggunaan');
            $table->string('tingkat_ketergantungan')->nullable()->after('kondisi_keluarga');
            $table->string('pola_pemakaian')->nullable()->after('tingkat_ketergantungan');
            $table->text('kondisi_lingkungan')->nullable()->after('pola_pemakaian');

            // Tambahan Keterangan & Saran
            $table->text('keterangan')->nullable()->after('pelaksanaan');
            $table->text('saran')->nullable()->after('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asesmens', function (Blueprint $table) {
            $table->dropColumn([
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
            ]);
        });
    }
};