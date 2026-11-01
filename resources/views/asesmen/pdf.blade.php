@php
    // LOGIKA KELENGKAPAN DATA (REVISI MUTLAK 100% FIELD)
    $kolomWajib = [
        'no_register', 'no_bln', 'asal_pengajuan', 'no_surat_pengajuan', 'no_lkn',
        'tgl_surat', 'tgl_berkas', 'tgl_pelaksanaan', 'tgl_tangkap',
        'nama_lengkap', 'nik', 'kewarganegaraan', 'tempat_lahir', 'tgl_lahir', 'jenis_kelamin', 'no_hp',
        'pendidikan_id', 'pekerjaan_id', 'alamat_ktp', 'alamat_domisili',
        'narkotika_id', 'deskripsi_bb', 'pasal_sangkaan',
        'status_hukum', 'keterlibatan_jaringan', 'cara_mendapatkan', 'dapat_dari_siapa',
        'tes_urine', 'hasil_asesmen_hukum', 'hasil_asesmen_medis',
        'aspek_hukum', 'aspek_medis', 'kesehatan_fisik', 'psikologi',
        'alasan_penggunaan', 'kondisi_keluarga', 'tingkat_ketergantungan', 'pola_pemakaian', 'kondisi_lingkungan', 'saran_case_conference'
    ];

    $isDataUtamaLengkap = true;
    foreach($kolomWajib as $kol) {
        if ($asesmen->$kol === null || trim((string)$asesmen->$kol) === '') {
            $isDataUtamaLengkap = false;
            break;
        }
    }

    // Berita Acara Terisi (Minimal Nomor BA & Ketua TAT)
    $isBaLengkap = !empty($asesmen->no_ba) && !empty($asesmen->ketua_tat_nama);

    // Rekomendasi Terisi (Minimal No Surat & Kepada Yth)
    $isRekomLengkap = !empty($asesmen->no_surat_rekomendasi) && !empty($asesmen->kepada_yth);

    // Final Lengkap Status
    $isLengkapTotal = ($isDataUtamaLengkap && $isBaLengkap && $isRekomLengkap);
    $teksStatus = $isLengkapTotal ? 'Data Lengkap' : 'Data Belum Lengkap';
    $warnaStatus = $isLengkapTotal ? '#10b981' : '#f59e0b';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ringkasan Asesmen - {{ $asesmen->nama_lengkap }}</title>
    <style>
        @page { margin: 1cm 1.5cm; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            line-height: 1.3;
            color: #1e293b;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }
        .header h1 { margin: 0; font-size: 14px; text-transform: uppercase; color: #1e3a8a; font-weight: bold; }
        .header h2 { margin: 3px 0 0 0; font-size: 11px; color: #64748b; font-weight: normal; }

        .section-title {
            background-color: #f1f5f9;
            color: #1e3a8a;
            padding: 4px 8px;
            font-size: 10px;
            font-weight: bold;
            border-left: 3px solid #3b82f6;
            margin-top: 10px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .table-split { width: 100%; }
        .table-split td { vertical-align: top; }
        .table-split .col-left { width: 49%; padding-right: 1%; }
        .table-split .col-right { width: 49%; padding-left: 1%; }

        .table-data { margin-bottom: 5px; width: 100%; }
        .table-data td { padding: 3px 4px; vertical-align: top; border-bottom: 1px solid #f1f5f9; }
        .table-data td.label { font-weight: bold; width: 35%; color: #475569; font-size: 9px; text-transform: uppercase; }
        .table-data td.colon { width: 2%; text-align: center; font-weight: bold; }
        .table-data td.value { width: 63%; color: #0f172a; }

        .box-text {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            border-radius: 3px;
            background-color: #f8fafc;
            margin-bottom: 5px;
            text-align: justify;
        }
        .box-title {
            font-size: 9px;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 3px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 3px;
        }
        .badge { background-color: #e0e7ff; color: #4338ca; padding: 2px 4px; border-radius: 3px; font-size: 8px; font-weight: bold; text-transform: uppercase; }
        .highlight-box { background-color: #ecfdf5; border: 1.5px solid #10b981; padding: 8px; border-radius: 4px; margin-top: 10px; }
        .footer { margin-top: 15px; text-align: right; font-size: 8px; color: #94a3b8; font-style: italic; }
        .page-break { page-break-after: always; }

        ul { margin: 0; padding-left: 15px; }
        li { margin-bottom: 2px; }
    </style>
</head>
<body>

    <!-- KOP SURAT / HEADER -->
    <div class="header">
        <h1>RINGKASAN DATA ASESMEN TERPADU (TAT)</h1>
        <h2>Badan Narkotika Nasional</h2>
        <div style="margin-top: 3px; font-size: 9px;">Dicetak pada: {{ date('d F Y - H:i') }} | Status Kelengkapan: <span style="font-weight: bold; color: {{ $warnaStatus }}">{{ $teksStatus }}</span></div>
    </div>

    <!-- 1 & 2 DIBUAT SEJAJAR KIRI-KANAN (MENGIKUTI TAMPILAN WEB) -->
    <table class="table-split">
        <tr>
            <!-- KOLOM KIRI (1. Profil Klien) -->
            <td class="col-left">
                <div class="section-title">1. Profil Klien</div>
                <table class="table-data">
                    <tr><td class="label">Nama Lengkap</td><td class="colon">:</td><td class="value" style="font-size: 11px; font-weight: bold;">{{ $asesmen->nama_lengkap }}</td></tr>
                    <tr><td class="label">NIK KTP</td><td class="colon">:</td><td class="value">{{ $asesmen->nik ?? '-' }}</td></tr>
                    <tr><td class="label">TTL</td><td class="colon">:</td><td class="value">{{ $asesmen->tempat_lahir ?? '-' }}, {{ $asesmen->tgl_lahir ? \Carbon\Carbon::parse($asesmen->tgl_lahir)->format('d/m/Y') : '-' }}</td></tr>
                    <tr><td class="label">Kelamin / Agama</td><td class="colon">:</td><td class="value">{{ $asesmen->jenis_kelamin == 'L' ? 'L' : ($asesmen->jenis_kelamin == 'P' ? 'P' : '-') }} | {{ $asesmen->agama ?? '-' }}</td></tr>
                    <tr><td class="label">Pend. / Pkrjn</td><td class="colon">:</td><td class="value">{{ $asesmen->pendidikan_input ?? $asesmen->pendidikan->nama_pendidikan ?? '-' }} | {{ $asesmen->pekerjaan_input ?? $asesmen->pekerjaan->nama_pekerjaan ?? '-' }}</td></tr>
                    <tr><td class="label">Alamat Domisili</td><td class="colon">:</td><td class="value">{{ $asesmen->alamat_domisili ?? '-' }}</td></tr>
                </table>
            </td>

            <!-- KOLOM KANAN (2. Data Administrasi) -->
            <td class="col-right">
                <div class="section-title">2. Data Administrasi</div>
                <table class="table-data">
                    <tr><td class="label">No / Bulan</td><td class="colon">:</td><td class="value">{{ $asesmen->no_bln ?? '-' }}</td></tr>
                    <tr><td class="label">Nomor Register</td><td class="colon">:</td><td class="value"><strong>{{ $asesmen->no_register ?? '-' }}</strong></td></tr>
                    <tr><td class="label">Asal / No LKN</td><td class="colon">:</td><td class="value">{{ $asesmen->asal_pengajuan ?? '-' }} / {{ $asesmen->no_lkn ?? '-' }}</td></tr>
                    <tr><td class="label">No. Surat</td><td class="colon">:</td><td class="value">{{ $asesmen->no_surat_pengajuan ?? '-' }}</td></tr>
                    <tr><td class="label">Tgl. Surat / Berkas</td><td class="colon">:</td><td class="value">{{ $asesmen->tgl_surat ? \Carbon\Carbon::parse($asesmen->tgl_surat)->format('d/m/Y') : '-' }} / {{ $asesmen->tgl_berkas ? \Carbon\Carbon::parse($asesmen->tgl_berkas)->format('d/m/Y') : '-' }}</td></tr>
                    <tr><td class="label">Tgl. Pelaksanaan</td><td class="colon">:</td><td class="value"><strong>{{ $asesmen->tgl_pelaksanaan ? \Carbon\Carbon::parse($asesmen->tgl_pelaksanaan)->format('d/m/Y') : '-' }}</strong> (Tngkp: {{ $asesmen->tgl_tangkap ? \Carbon\Carbon::parse($asesmen->tgl_tangkap)->format('d/m/Y') : '-' }})</td></tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- 3. PERKARA HUKUM, MEDIS & REKOMENDASI TAT -->
    <div class="section-title">3. Perkara Hukum, Medis & Rekomendasi TAT</div>
    <table class="table-data">
        <tr>
            <td class="label" style="width: 17%;">Status Hukum</td><td class="colon">:</td>
            <td class="value" style="width: 31%;"><span class="badge">{{ $asesmen->status_hukum ?? '-' }}</span></td>
            <td class="label" style="width: 17%;">Jaringan</td><td class="colon">:</td>
            <td class="value" style="width: 31%;">{{ $asesmen->keterlibatan_jaringan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Zat & Berat BB</td><td class="colon">:</td>
            <td class="value"><strong>{{ $asesmen->narkotika->jenis_narkotika ?? '-' }}</strong> ({{ $asesmen->berat_bb ? $asesmen->berat_bb . ' gr' : '-' }})</td>
            <td class="label">Cara Mendapat</td><td class="colon">:</td>
            <td class="value">{{ $asesmen->cara_mendapatkan ?? '-' }} ({{ $asesmen->dapat_dari_siapa ?? '-' }})</td>
        </tr>
    </table>

    <div class="box-text">
        <div class="box-title">Detail / Deskripsi Barang Bukti & Hasil Tes Urine</div>
        <strong>Tes Urine:</strong> <span style="color: {{ strpos(strtoupper($asesmen->tes_urine), 'POSITIF') !== false ? '#dc2626' : (strpos(strtoupper($asesmen->tes_urine), 'NEGATIF') !== false ? '#059669' : '#0f172a') }}; font-weight:bold;">{{ $asesmen->tes_urine ?? '-' }}</span><br>
        <strong>Deskripsi BB:</strong> {{ $asesmen->deskripsi_bb ?? '-' }}
    </div>

    <!-- Analisis Case Conference (Tetap dalam lingkup Poin 3) -->
    <table class="table-split" style="margin-bottom: 0;">
        <tr>
            <td class="col-left">
                <div class="box-text" style="height: 90%;">
                    <div class="box-title">Kondisi Psikologi & Fisik</div>
                    <strong>Fisik:</strong> {{ $asesmen->kesehatan_fisik ?? '-' }}<br>
                    <strong>Psikologi:</strong> {{ $asesmen->psikologi ?? '-' }}
                </div>
            </td>
            <td class="col-right">
                <div class="box-text" style="height: 90%;">
                    <div class="box-title">Riwayat Pemakaian & Lingkungan</div>
                    <strong>Alasan:</strong> {{ $asesmen->alasan_penggunaan ?? '-' }} | <strong>Pola:</strong> {{ $asesmen->pola_pemakaian ?? '-' }}<br>
                    <strong>Ketergantungan:</strong> {{ $asesmen->tingkat_ketergantungan ?? '-' }}<br>
                    <strong>Keluarga & Lingkungan:</strong> {{ $asesmen->kondisi_keluarga ?? '-' }} / {{ $asesmen->kondisi_lingkungan ?? '-' }}
                </div>
            </td>
        </tr>
    </table>

    <div class="box-text" style="background-color: #fffbeb; border-color: #fcd34d; margin-top:2px;">
        <div class="box-title" style="color: #b45309; border-bottom-color: #fde68a;">Saran Sidang Case Conference</div>
        <ul style="font-weight: bold; color: #b45309;">
            @php $saranList = array_filter(array_map('trim', explode(',', $asesmen->saran_case_conference ?? ''))); @endphp
            @if(count($saranList) > 0)
                @foreach($saranList as $saran) <li>{{ $saran }}</li> @endforeach
            @else <li>-</li> @endif
        </ul>
    </div>

    <!-- KESIMPULAN HIGHLIGHT (Juga masuk Poin 3 sesuai web) -->
    <div class="highlight-box">
        <div style="text-align:center; font-size: 11px; font-weight: bold; color: #047857; text-transform: uppercase; margin-bottom: 5px;">Keputusan Akhir & Rekomendasi TAT</div>
        <table style="width:100%; text-align: left; font-size: 10px; margin-bottom: 5px;">
            <tr>
                <td style="font-weight:bold; color:#064e3b; width:15%;">Status Klien</td><td style="width:2%;">:</td>
                <td style="width:33%;">{{ ucwords($asesmen->status_klien ?? '-') }}</td>
                <td style="font-weight:bold; color:#064e3b; width:15%;">Zat / Golongan</td><td style="width:2%;">:</td>
                <td style="width:33%; font-weight:bold;">{{ $asesmen->kesimpulan_jenis_zat ?? $asesmen->nama_narkotika_medis ?? '-' }}</td>
            </tr>
            <tr>
                <td style="font-weight:bold; color:#064e3b;">Diagnosis Medis</td><td>:</td>
                <td colspan="4" style="font-weight:bold;">{{ $asesmen->diagnosis_medis ?? '-' }}</td>
            </tr>
        </table>
        <div style="background-color: #d1fae5; padding: 6px; border-radius: 4px; border: 1px solid #6ee7b7; text-align:center;">
            <span style="font-size: 9px; color: #064e3b; text-transform:uppercase;">Tempat Rehabilitasi</span><br>
            <strong style="font-size: 13px; color: #064e3b;">{{ $asesmen->rekomendasi_input ?? $asesmen->rekomendasi->tempat_rehabilitasi ?? 'BELUM DITENTUKAN' }}</strong><br>
            <span style="font-size: 10px; color: #047857;"><strong>Durasi Rawat:</strong> {{ $asesmen->lama_perawatan ?? $asesmen->rekomendasi_durasi ?? '-' }}</span>
        </div>
        <div style="margin-top: 5px; font-size: 9px; color: #064e3b; font-style: italic;">
            <strong>Ket. Hukum:</strong> "{{ $asesmen->rekomendasi_keterangan ?? $asesmen->keterangan_tambahan ?? '-' }}"
        </div>
    </div>

    <!-- 4. HASIL ASESMEN FINAL & PELAKSANAAN -->
    <div class="section-title">4. Hasil Asesmen Final & Pelaksanaan</div>
    <table class="table-data">
        <tr>
            <td class="label" style="width:20%;">Pasal Disangkakan</td><td class="colon">:</td>
            <td class="value"><strong>{{ $asesmen->pasal_sangkaan ?? '-' }}</strong></td>
        </tr>
        <tr>
            <td class="label">Asesmen Hukum Final</td><td class="colon">:</td>
            <td class="value">{!! nl2br(e($asesmen->hasil_asesmen_hukum ?? '-')) !!}</td>
        </tr>
        <tr>
            <td class="label">Rujukan Medis Final</td><td class="colon">:</td>
            <td class="value">{!! nl2br(e($asesmen->hasil_asesmen_medis ?? '-')) !!}</td>
        </tr>
        <tr>
            <td class="label">Pelaksanaan</td><td class="colon">:</td>
            <td class="value">
                @if($asesmen->pelaksanaan === 'YA') <strong style="color: #059669;">SUDAH DILAKSANAKAN (YA)</strong>
                @elseif($asesmen->pelaksanaan === 'TIDAK') <strong style="color: #dc2626;">BELUM / BATAL (TIDAK)</strong>
                @else - @endif
            </td>
        </tr>
    </table>

    <!-- HALAMAN KE 2 (Jika Data Surat Lengkap) -->
    @if($asesmen->no_ba || $asesmen->ketua_tat_nama || $asesmen->no_surat_rekomendasi || $asesmen->kepada_yth)
        <div class="page-break"></div>
        <div class="header">
            <h1>DATA DOKUMEN REKOMENDASI & BERITA ACARA</h1>
            <h2>{{ $asesmen->nama_lengkap }} (Reg: {{ $asesmen->no_register ?? '-' }})</h2>
        </div>

        <!-- 5. DATA SURAT REKOMENDASI -->
        <div class="section-title">5. Data Surat Rekomendasi</div>
        <table class="table-data">
            <tr>
                <td class="label" style="width:25%;">Nomor Surat / Tujuan</td><td class="colon">:</td>
                <td class="value"><strong>{{ $asesmen->no_surat_rekomendasi ?? '-' }}</strong> | Yth. {{ $asesmen->kepada_yth ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Keputusan TAT / Tgl</td><td class="colon">:</td>
                <td class="value">{{ $asesmen->no_keputusan ?? '-' }} | {{ $asesmen->tgl_keputusan ? \Carbon\Carbon::parse($asesmen->tgl_keputusan)->format('d/m/Y') : '-' }} (Srt Rekom: {{ $asesmen->tgl_rekomendasi ? \Carbon\Carbon::parse($asesmen->tgl_rekomendasi)->format('d/m/Y') : '-' }})</td>
            </tr>
            <tr>
                <td class="label">Tentang Permohonan</td><td class="colon">:</td>
                <td class="value">{!! nl2br(e($asesmen->tentang_permohonan ?? '-')) !!}</td>
            </tr>
        </table>

        <!-- 6. DATA SURAT BERITA ACARA (B.A) -->
        <div class="section-title">6. Data Surat Berita Acara (B.A)</div>
        <table class="table-data">
            <tr>
                <td class="label" style="width:25%;">Ketua TAT / NRP</td><td class="colon">:</td>
                <td class="value">{{ $asesmen->ketua_tat_nama ?? '-' }} | {{ $asesmen->ketua_tat_nrp ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">SK Tim TAT / Tgl</td><td class="colon">:</td>
                <td class="value">{{ $asesmen->no_kep_tim ?? '-' }} | {{ $asesmen->tgl_kep_tim ? \Carbon\Carbon::parse($asesmen->tgl_kep_tim)->format('d/m/Y') : '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tgl. Rapat B.A</td><td class="colon">:</td>
                <td class="value">{{ $asesmen->tgl_ba ? \Carbon\Carbon::parse($asesmen->tgl_ba)->format('d/m/Y') : '-' }}</td>
            </tr>
            <tr>
                <td class="label">SK Narkotika / Dokter</td><td class="colon">:</td>
                <td class="value">{{ $asesmen->alat_bukti_no_sk ?? '-' }} ({{ $asesmen->alat_bukti_tgl_sk ? \Carbon\Carbon::parse($asesmen->alat_bukti_tgl_sk)->format('d/m/Y') : '-' }}) | dr. {{ $asesmen->alat_bukti_dokter ?? '-' }}</td>
            </tr>
        </table>

        <table class="table-split">
            <tr>
                <td class="col-left">
                    <div class="box-text">
                        <div class="box-title">Narasi Tim Hukum</div>
                        {!! nl2br(e($asesmen->narasi_hukum ?? '-')) !!}
                    </div>
                </td>
                <td class="col-right">
                    <div class="box-text">
                        <div class="box-title">Narasi Tim Medis</div>
                        {!! nl2br(e($asesmen->narasi_medis ?? '-')) !!}
                    </div>
                </td>
            </tr>
        </table>
    @endif

    <div class="footer">
        <p>Dokumen cetak ini di-generate secara otomatis oleh Sistem TAT BNN dan telah disesuaikan dengan kelengkapan data web.</p>
    </div>

</body>
</html>
