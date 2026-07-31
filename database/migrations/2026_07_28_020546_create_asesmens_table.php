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
        Schema::create('asesmens', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Pakai UUID agar lebih aman untuk URL
            $table->date('tgl_surat')->nullable();
            $table->date('tgl_pelaksanaan')->nullable();
            $table->string('no_surat_pengajuan')->nullable();

            $table->string('nama_lengkap');
            $table->string('nik', 16)->unique();
            $table->string('no_register')->nullable();

            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);

            // Relasi ke Master Data
            $table->foreignId('pendidikan_id')->nullable()->constrained('m_pendidikan');
            $table->foreignId('pekerjaan_id')->nullable()->constrained('m_pekerjaan');

            $table->text('alamat_ktp')->nullable();
            $table->text('alamat_domisili')->nullable();

            $table->foreignId('narkotika_id')->nullable()->constrained('m_narkotika');
            $table->string('pasal_sangkaan')->nullable();

            // Data Hasil TAT
            $table->text('hasil_asesmen_hukum')->nullable();
            $table->text('hasil_asesmen_medis')->nullable();
            $table->foreignId('rekomendasi_id')->nullable()->constrained('m_rekomendasi');
            $table->enum('pelaksanaan', ['YA', 'TIDAK'])->default('TIDAK');

            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asesmens');
    }
};