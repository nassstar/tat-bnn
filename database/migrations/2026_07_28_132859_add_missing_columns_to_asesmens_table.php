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
            // Menambahkan kolom baru setelah kolom tertentu agar rapi di database (opsional)
            $table->string('no_hp', 20)->nullable()->after('nik');
            $table->string('no_lkn')->nullable()->after('no_surat_pengajuan');
            $table->string('no_bln')->nullable()->after('no_lkn'); // Sekalian saya tambahkan no_bln yang tadi juga hilang
            $table->date('tgl_berkas')->nullable()->after('tgl_surat');
            $table->date('tgl_tangkap')->nullable()->after('tgl_pelaksanaan');

            // Untuk berat_bb disarankan pakai decimal/float agar bisa simpan angka desimal seperti 1.5
            $table->decimal('berat_bb', 8, 2)->nullable()->after('jenis_kelamin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asesmens', function (Blueprint $table) {
            // Menghapus kolom jika sewaktu-waktu dilakukan rollback
            $table->dropColumn([
                'no_hp',
                'no_lkn',
                'no_bln',
                'tgl_berkas',
                'tgl_tangkap',
                'berat_bb'
            ]);
        });
    }
};