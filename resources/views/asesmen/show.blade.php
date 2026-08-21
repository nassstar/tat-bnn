<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('asesmen.index') }}" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
                </a>
                <div>
                    <span class="inline-block px-2 py-1 bg-amber-100 text-amber-800 text-[10px] font-bold rounded mb-1 uppercase tracking-wider">Data Asesmen</span>
                    <h2 class="font-bold text-2xl text-slate-900 tracking-tight">Detail Klien: {{ $asesmen->nama_lengkap }}</h2>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('asesmen.edit', $asesmen->id) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold text-xs rounded-lg transition shadow-sm flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit Data
                </a>
                <a href="{{ route('asesmen.berita-acara', $asesmen->id) }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-lg transition shadow-sm flex items-center">
                    BA (Word)
                </a>
                <a href="{{ route('asesmen.rekomendasi', $asesmen->id) }}" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold text-xs rounded-lg transition shadow-sm flex items-center">
                    Rekom (Word)
                </a>
                <a href="{{ route('asesmen.cetakPdf', $asesmen->id) }}" target="_blank" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs rounded-lg transition shadow-sm flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak PDF
                </a>
            </div>
        </div>
    </x-slot>

    <!-- PEMBUNGKUS UTAMA HALAMAN -->
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- ========================================================================= -->
            <!-- BAGIAN ATAS: Card 1, 2, dan 3 (DIRUBAH KE FLEXBOX AGAR LEBIH STABIL) -->
            <!-- ========================================================================= -->
            <div class="flex flex-col lg:flex-row gap-6 items-start">

                <!-- KOLOM KIRI (Card 1 & 2): Mengambil 1/3 layar -->
                <div class="w-full lg:w-1/3 flex flex-col gap-6">

                    <!-- Card 1: Data Administrasi -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden w-full">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-indigo-500"></div>
                        <h3 class="text-[13px] font-extrabold text-slate-800 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2 ml-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            1. Data Administrasi
                        </h3>
                        <div class="space-y-3 text-[13px] ml-2">
                            <div class="flex justify-between items-start border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium">No / BLN</span> <span class="font-bold text-slate-800 text-right">{{ $asesmen->no_bln ?? '-' }}</span></div>
                            <div class="flex flex-col border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium mb-1">Asal Pengajuan</span> <span class="font-bold text-slate-800 leading-snug">{{ $asesmen->asal_pengajuan ?? '-' }}</span></div>
                            <div class="flex justify-between items-start border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium">Tgl Surat</span> <span class="font-bold text-slate-800 text-right">{{ $asesmen->tgl_surat ? \Carbon\Carbon::parse($asesmen->tgl_surat)->format('d-m-Y') : '-' }}</span></div>
                            <div class="flex justify-between items-start border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium">Tgl Berkas Diterima</span> <span class="font-bold text-slate-800 text-right">{{ $asesmen->tgl_berkas ? \Carbon\Carbon::parse($asesmen->tgl_berkas)->format('d-m-Y') : '-' }}</span></div>
                            <div class="flex justify-between items-start border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium">Tgl Pelaksanaan</span> <span class="font-bold text-indigo-600 text-right">{{ $asesmen->tgl_pelaksanaan ? \Carbon\Carbon::parse($asesmen->tgl_pelaksanaan)->format('d-m-Y') : '-' }}</span></div>
                            <div class="flex flex-col border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium mb-1">No. Surat Pengajuan</span> <span class="font-bold text-slate-800 leading-snug break-words">{{ $asesmen->no_surat_pengajuan ?? '-' }}</span></div>
                            <div class="flex flex-col border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium mb-1">No. LKN / LP / LI</span> <span class="font-bold text-slate-800 leading-snug break-words">{{ $asesmen->no_lkn ?? '-' }}</span></div>
                            <div class="flex justify-between items-start border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium">Tgl Penangkapan</span> <span class="font-bold text-slate-800 text-right">{{ $asesmen->tgl_tangkap ? \Carbon\Carbon::parse($asesmen->tgl_tangkap)->format('d-m-Y') : '-' }}</span></div>
                            <div class="flex flex-col pt-1"><span class="text-slate-500 font-medium mb-1">No. Register</span> <span class="font-bold text-slate-800 leading-snug break-words">{{ $asesmen->no_register ?? '-' }}</span></div>
                        </div>
                    </div>

                    <!-- Card 2: Profil Klien -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden w-full">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-blue-500"></div>
                        <h3 class="text-[13px] font-extrabold text-slate-800 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2 ml-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            2. Profil Klien
                        </h3>
                        <div class="space-y-3 text-[13px] ml-2">
                            <div class="flex flex-col border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium mb-1">Nama Lengkap</span> <span class="font-bold text-slate-800">{{ $asesmen->nama_lengkap }}</span></div>
                            <div class="flex flex-col border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium mb-1">NIK</span> <span class="font-bold text-slate-800">{{ $asesmen->nik }}</span></div>
                            <div class="flex flex-col border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium mb-1">No. HP</span> <span class="font-bold text-slate-800">{{ $asesmen->no_hp ?? '-' }}</span></div>
                            <div class="flex flex-col border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium mb-1">Tempat, Tgl Lahir</span> <span class="font-bold text-slate-800">{{ $asesmen->tempat_lahir ?? '-' }}, {{ $asesmen->tgl_lahir ? \Carbon\Carbon::parse($asesmen->tgl_lahir)->format('d-m-Y') : '-' }}</span></div>
                            <div class="flex flex-col border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium mb-1">Jenis Kelamin</span> <span class="font-bold text-slate-800">{{ $asesmen->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</span></div>
                            <div class="flex flex-col border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium mb-1">Agama & WN</span> <span class="font-bold text-slate-800">{{ $asesmen->agama ?? '-' }} | {{ $asesmen->kewarganegaraan ?? '-' }}</span></div>
                            <div class="flex flex-col border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium mb-1">Pendidikan</span> <span class="font-bold text-slate-800">{{ $asesmen->pendidikan->nama_pendidikan ?? '-' }}</span></div>
                            <div class="flex flex-col border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium mb-1">Pekerjaan</span> <span class="font-bold text-slate-800">{{ $asesmen->pekerjaan->nama_pekerjaan ?? '-' }}</span></div>

                            <!-- TAMBAHAN: Penghasilan Rata-rata -->
                            <div class="flex flex-col border-b border-slate-50 pb-1.5">
                                <span class="text-slate-500 font-medium mb-1">Penghasilan Rata-rata</span>
                                <span class="font-bold text-slate-800">{{ $asesmen->penghasilan_rata_rata ?? '-' }}</span>
                            </div>

                            <div class="flex flex-col border-b border-slate-50 pb-1.5">
                                <span class="text-slate-500 font-medium mb-1">Alamat KTP</span>
                                <span class="font-bold text-slate-800 leading-snug">{{ $asesmen->alamat_ktp ?? '-' }}</span>
                            </div>
                            <div class="flex flex-col pt-1">
                                <span class="text-slate-500 font-medium mb-1">Alamat Domisili</span>
                                <span class="font-bold text-slate-800 leading-snug">{{ $asesmen->alamat_domisili ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- KOLOM KANAN (Card 3): Mengambil 2/3 layar -->
                <div class="w-full lg:w-2/3 flex flex-col">

                    <!-- Card 3: Perkara Hukum -->
                    <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden w-full h-full">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-amber-400"></div>
                        <h3 class="text-[14px] font-extrabold text-slate-800 uppercase tracking-wider mb-6 border-b border-slate-100 pb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                            3. STATUS PERKARA & BARANG BUKTI
                        </h3>

                        <!-- Inner Grid Card 3 -->
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 text-sm mb-6">
                            <div class="flex flex-col"><span class="text-slate-400 text-[11px] font-bold uppercase mb-1">Zat/Narkotika</span> <span class="font-bold text-slate-800 text-base">{{ $asesmen->narkotika->jenis_narkotika ?? '-' }}</span></div>
                            <div class="flex flex-col"><span class="text-slate-400 text-[11px] font-bold uppercase mb-1">Berat Bukti (BB)</span> <span class="font-bold text-slate-800 text-base">{{ $asesmen->berat_bb ? $asesmen->berat_bb . ' gram' : '-' }}</span></div>
                            <div class="flex flex-col"><span class="text-slate-400 text-[11px] font-bold uppercase mb-1">Status Hukum</span> <div><span class="inline-flex px-2.5 py-1 rounded bg-amber-100 text-amber-800 font-bold text-xs">{{ $asesmen->status_hukum ?? '-' }}</span></div></div>
                            <div class="flex flex-col">
                                <span class="text-slate-400 text-[11px] font-bold uppercase mb-1">Hasil Tes Urine</span>
                                <div>
                                @php
                                    $urineText = $asesmen->tes_urine ?? '';
                                    $urineFirstWord = strtoupper(strtok($urineText, " :,-"));
                                @endphp
                                @if($urineFirstWord === 'POSITIF')
                                    <span class="inline-block px-2 py-1.5 rounded text-[11px] font-bold bg-rose-100 text-rose-700 leading-snug">{{ $asesmen->tes_urine }}</span>
                                @elseif($urineFirstWord === 'NEGATIF')
                                    <span class="inline-block px-2 py-1.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-700 leading-snug">{{ $asesmen->tes_urine }}</span>
                                @else
                                    <span class="inline-block px-2 py-1.5 rounded text-[11px] font-bold bg-slate-100 text-slate-700 leading-snug">{{ $asesmen->tes_urine ?? '-' }}</span>
                                @endif
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <span class="text-slate-400 block text-[11px] font-bold uppercase mb-2">Pasal Sangkaan</span>
                            <div class="p-4 bg-slate-50 rounded-lg text-slate-800 font-semibold border border-slate-100">{{ $asesmen->pasal_sangkaan ?? '-' }}</div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="p-5 bg-slate-50 rounded-xl border border-slate-100 h-full">
                                <span class="text-slate-400 block text-[11px] font-bold uppercase mb-2">Detail Barang Bukti</span>
                                <div class="text-slate-800 font-medium leading-relaxed">{{ $asesmen->deskripsi_bb ?? '-' }}</div>
                            </div>
                            <div class="p-5 bg-slate-50 rounded-xl border border-slate-100 space-y-4 h-full">
                                <div>
                                    <span class="text-slate-400 block text-[11px] font-bold uppercase mb-1">Dapat Dari:</span>
                                    <div class="text-slate-800 font-bold">{{ $asesmen->dapat_dari_siapa ?? '-' }}</div>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[11px] font-bold uppercase mb-1">Cara Dapat:</span>
                                    <div class="text-slate-800 font-medium">{{ $asesmen->cara_mendapatkan ?? '-' }}</div>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[11px] font-bold uppercase mb-1">Keterlibatan Jaringan:</span>
                                    <div class="text-rose-600 font-bold uppercase">{{ $asesmen->keterlibatan_jaringan ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div> <!-- END BAGIAN ATAS -->


            <!-- Card 4: Hasil Narasi Asesmen -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mt-6">
                <div class="bg-slate-50 px-6 md:px-8 py-5 border-b border-slate-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        4. Narasi Hasil Asesmen & Sidang Case Conference
                    </h3>
                    <a href="{{ route('asesmen.berita-acara', $asesmen->id) }}" class="text-xs font-bold text-emerald-700 hover:text-white bg-emerald-100 hover:bg-emerald-600 px-4 py-2 rounded-lg transition-all shadow-sm">Edit Narasi &rarr;</a>
                </div>

                <div class="p-6 md:p-8 space-y-10">
                    <!-- A. ASESMEN MENTAH -->
                    <div>
                        <h4 class="text-base font-extrabold text-slate-900 border-b-2 border-slate-100 pb-2 mb-4">A. Hasil Asesmen Awal (Mentah)</h4>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Kronologi Asesmen Hukum</span>
                                <div class="p-4 md:p-5 bg-slate-50 rounded-xl border border-slate-200 text-[14px] text-slate-800 whitespace-pre-line leading-loose max-h-[300px] overflow-y-auto font-medium">{{ $asesmen->hasil_asesmen_hukum ?? 'Belum ada data' }}</div>
                            </div>
                            <div>
                                <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Kronologi Asesmen Medis</span>
                                <div class="p-4 md:p-5 bg-slate-50 rounded-xl border border-slate-200 text-[14px] text-slate-800 whitespace-pre-line leading-loose max-h-[300px] overflow-y-auto font-medium">{{ $asesmen->hasil_asesmen_medis ?? 'Belum ada data' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- B. NARASI BERITA ACARA -->
                    <div>
                        <h4 class="text-base font-extrabold text-slate-900 border-b-2 border-slate-100 pb-2 mb-4">B. Narasi Berita Acara TAT (Word)</h4>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Narasi B.A Tim Hukum</span>
                                <div class="p-4 md:p-5 bg-slate-50 rounded-xl border border-slate-200 text-[14px] text-slate-800 whitespace-pre-wrap leading-loose shadow-inner max-h-[400px] overflow-y-auto font-medium">{{ $asesmen->narasi_hukum ?? 'Narasi hukum belum diisi melalui form Berita Acara.' }}</div>
                                <div class="mt-3 flex items-center flex-wrap gap-2">
                                    <span class="text-[11px] font-bold text-slate-400">Tim Hukum Terlibat:</span>
                                    @forelse($asesmen->anggotaTim->where('kategori', 'hukum') as $hukum)
                                        <span class="text-[10px] font-bold text-slate-700 bg-slate-200 px-2.5 py-1 rounded border border-slate-300">{{ $hukum->nama }}</span>
                                    @empty
                                        <span class="text-[11px] text-rose-500 font-bold">Belum ada tim ditugaskan</span>
                                    @endforelse
                                </div>
                            </div>

                            <div>
                                <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Narasi B.A Tim Medis</span>
                                <div class="p-4 md:p-5 bg-blue-50/50 rounded-xl border border-blue-100 text-[14px] text-slate-800 whitespace-pre-wrap leading-loose shadow-inner max-h-[400px] overflow-y-auto font-medium">{{ $asesmen->narasi_medis ?? 'Narasi medis belum diisi melalui form Berita Acara.' }}</div>
                                <div class="mt-3 flex items-center flex-wrap gap-2">
                                    <span class="text-[11px] font-bold text-slate-400">Tim Medis Terlibat:</span>
                                    @forelse($asesmen->anggotaTim->where('kategori', 'medis') as $medis)
                                        <span class="text-[10px] font-bold text-blue-700 bg-blue-100 px-2.5 py-1 rounded border border-blue-200">{{ $medis->nama }}</span>
                                    @empty
                                        <span class="text-[11px] text-rose-500 font-bold">Belum ada dokter ditugaskan</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- C. ANALISIS SIDANG TAT -->
                    <div>
                        <h4 class="text-base font-extrabold text-slate-900 border-b-2 border-slate-100 pb-2 mb-4">C. Analisis Lengkap Sidang Case Conference</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50 p-6 rounded-2xl border border-slate-200">
                            <div class="space-y-5">
                                <div>
                                    <span class="block text-[11px] font-bold text-indigo-600 uppercase tracking-wider mb-1.5">Analisis Aspek Hukum</span>
                                    <p class="text-[14px] text-slate-800 whitespace-pre-line font-medium leading-relaxed bg-white p-4 rounded-xl border border-slate-100">{{ $asesmen->aspek_hukum ?? 'Belum ada data' }}</p>
                                </div>
                                <div>
                                    <span class="block text-[11px] font-bold text-indigo-600 uppercase tracking-wider mb-1.5">Analisis Aspek Medis & Psikologi</span>
                                    <div class="bg-white p-4 rounded-xl border border-slate-100 space-y-3">
                                        <p class="text-[14px] text-slate-800 whitespace-pre-line font-medium leading-relaxed"><span class="text-[11px] uppercase tracking-wider text-slate-400 block mb-0.5">Fisik & Medis:</span> {{ $asesmen->aspek_medis ?? 'Belum ada data' }}</p>
                                        <div class="h-px w-full bg-slate-100"></div>
                                        <p class="text-[14px] text-slate-800 whitespace-pre-line font-medium leading-relaxed"><span class="text-[11px] uppercase tracking-wider text-slate-400 block mb-0.5">Psikologi:</span> {{ $asesmen->psikologi ?? 'Belum ada data' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-5">
                                <div>
                                    <span class="block text-[11px] font-bold text-indigo-600 uppercase tracking-wider mb-1.5">Lingkungan & Riwayat Pemakaian</span>
                                    <div class="bg-white p-4 rounded-xl border border-slate-100 space-y-3">
                                        <p class="text-[14px] text-slate-800 font-medium"><span class="text-[11px] uppercase tracking-wider text-slate-400 block mb-0.5">Keluarga:</span> {{ $asesmen->kondisi_keluarga ?? '-' }}</p>
                                        <p class="text-[14px] text-slate-800 font-medium"><span class="text-[11px] uppercase tracking-wider text-slate-400 block mb-0.5">Lingkungan:</span> {{ $asesmen->kondisi_lingkungan ?? '-' }}</p>
                                        <div class="h-px w-full bg-slate-100 my-2"></div>
                                        <ul class="text-[13px] font-bold text-slate-700 space-y-2">
                                            <li><span class="text-slate-500 font-normal w-24 inline-block">Alasan Pakai:</span> {{ $asesmen->alasan_penggunaan ?? '-' }}</li>
                                            <li><span class="text-slate-500 font-normal w-24 inline-block">Pola Pakai:</span> {{ $asesmen->pola_pemakaian ?? '-' }}</li>
                                            <li><span class="text-slate-500 font-normal w-24 inline-block">Ketergantungan:</span> <span class="text-rose-600">{{ $asesmen->tingkat_ketergantungan ?? '-' }}</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- END CARD 4 -->


            <!-- Card 5: KESIMPULAN & REKOMENDASI FINAL -->
            <div class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 rounded-2xl border border-indigo-200 shadow-lg overflow-hidden relative">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <svg class="w-48 h-48 text-indigo-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                </div>
                <div class="px-6 md:px-8 py-5 border-b border-indigo-100/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 relative z-10">
                    <h3 class="text-base font-extrabold text-indigo-900 uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        5. Kesimpulan Diagnostik & Keputusan Rekomendasi TAT
                    </h3>
                    <div class="flex gap-2 w-full sm:w-auto">
    <!-- Tombol Edit Form -->
    <a href="{{ route('asesmen.berita-acara', $asesmen->id) }}" class="flex-1 sm:flex-none text-center px-4 py-2 border border-slate-300 bg-white rounded-lg font-bold text-xs text-slate-700 uppercase tracking-widest hover:bg-slate-50 transition shadow-sm">
        Edit Form BA
    </a>

    <!-- Tombol Unduh Murni (Tanpa Update Database) -->
    <form action="{{ route('asesmen.berita-acara.unduh', $asesmen->id) }}" method="POST" class="flex-1 sm:flex-none">
        @csrf
        <button type="submit" style="background-color: #9333ea;" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:opacity-90 transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Unduh BA
        </button>
    </form>
</div>
                </div>
                <div class="p-6 md:p-8 relative z-10 space-y-8">
                    <div class="bg-white/90 backdrop-blur-md p-5 md:p-6 rounded-2xl border border-white shadow-sm">
                        <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-4">Kesimpulan Diagnostik (Dari Berita Acara)</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <div><span class="block text-[11px] text-slate-500 mb-1">Status Klien</span><span class="font-bold text-slate-900 text-[15px] capitalize">{{ $asesmen->status_klien ?? '-' }}</span></div>
                            <div><span class="block text-[11px] text-slate-500 mb-1">Zat Utama</span><span class="font-bold text-slate-900 text-[15px]">{{ $asesmen->kesimpulan_jenis_zat ?? '-' }}</span></div>
                            <div><span class="block text-[11px] text-slate-500 mb-1">Pola Pemakaian</span><span class="font-bold text-slate-900 text-[15px]">{{ $asesmen->kesimpulan_pola_pakai ?? '-' }}</span></div>
                            <div><span class="block text-[11px] text-slate-500 mb-1">Kategori</span><span class="font-bold text-rose-600 text-[15px]">{{ $asesmen->kesimpulan_kategori ?? '-' }}</span></div>
                            <div class="col-span-2 md:col-span-4 mt-2 pt-4 border-t border-slate-100">
                                <span class="block text-[11px] text-slate-500 mb-1.5 uppercase tracking-wider">Diagnosis Medis Final</span>
                                <div class="font-extrabold text-indigo-700 text-lg leading-relaxed">{{ $asesmen->diagnosis_medis ?? 'Belum ada diagnosis ditarik dari form BA' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div>
                            <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Keputusan Tempat Rehab (Final)</span>
                            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-6 text-white shadow-lg">
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="p-3 bg-white/20 rounded-xl shrink-0"><svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg></div>
                                    <div>
                                        <div class="text-[12px] font-medium text-emerald-100 uppercase tracking-wider mb-1">Ditempatkan di:</div>
                                        <div class="text-xl md:text-2xl font-extrabold leading-tight">
                                            {{ $asesmen->rekomendasi->tempat_rehabilitasi ?? 'Belum ditentukan' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="border-t border-emerald-400/50 pt-3 mt-3">
                                    <div class="text-[13px] font-medium text-emerald-100">
                                        Durasi Perawatan Terpadu:
                                        <span class="font-extrabold text-white text-base ml-2 px-3 py-1 bg-black/10 rounded-lg">
                                            {{ $asesmen->lama_perawatan ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="bg-white/80 backdrop-blur-sm p-5 rounded-2xl border border-white shadow-sm">
                                <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Saran Case Conference</span>
                                <p class="text-[14px] font-bold text-slate-800 leading-relaxed">{{ $asesmen->saran_case_conference ?? 'Belum ada saran terisi' }}</p>
                            </div>
                            <div class="bg-white/80 backdrop-blur-sm p-5 rounded-2xl border border-white shadow-sm">
                                <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Keterangan Hukum Rekomendasi</span>
                                <p class="text-[14px] font-semibold text-slate-700 italic leading-relaxed">"{{ $asesmen->rekomendasi_keterangan ?? 'Belum ada keterangan hukum dari form Rekomendasi...' }}"</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- END CARD 5 -->


            <!-- ========================================== -->
            <!-- CARD 6: DATA SURAT REKOMENDASI TAT       -->
            <!-- ========================================== -->
            @if($asesmen->no_surat_rekomendasi)
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm mt-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 border-b border-slate-100 pb-4 gap-4">
                    <h3 class="text-base font-extrabold text-purple-700 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        6. Data Surat Rekomendasi TAT
                    </h3>
                    <div class="flex gap-2 w-full sm:w-auto">
                        <a href="{{ route('asesmen.rekomendasi', $asesmen->id) }}" class="flex-1 sm:flex-none text-center px-4 py-2 border border-slate-300 rounded-lg font-bold text-xs text-slate-700 uppercase tracking-widest hover:bg-slate-50 transition shadow-sm">
                            Edit Form
                        </a>
                        <form action="{{ route('asesmen.rekomendasi.unduh', $asesmen->id) }}" method="POST" class="flex-1 sm:flex-none">
                            @csrf
                            <input type="hidden" name="action" value="download">
                            <!-- Mengirim ulang data hidden agar tetap bisa generate Word -->
                            <input type="hidden" name="no_surat_rekomendasi" value="{{ $asesmen->no_surat_rekomendasi }}">
                            <input type="hidden" name="tgl_rekomendasi" value="{{ $asesmen->tgl_rekomendasi }}">
                            <input type="hidden" name="kepada_yth" value="{{ $asesmen->kepada_yth }}">
                            <input type="hidden" name="no_keputusan" value="{{ $asesmen->no_keputusan }}">
                            <input type="hidden" name="tgl_keputusan" value="{{ $asesmen->tgl_keputusan }}">
                            <input type="hidden" name="tentang_permohonan" value="{{ $asesmen->tentang_permohonan }}">
                            <input type="hidden" name="kewarganegaraan" value="{{ $asesmen->kewarganegaraan }}">
                            <input type="hidden" name="nama_narkotika_medis" value="{{ $asesmen->nama_narkotika_medis }}">
                            <input type="hidden" name="lama_perawatan" value="{{ $asesmen->lama_perawatan }}">
                            <input type="hidden" name="keterangan_diagnosis" value="{{ $asesmen->keterangan_diagnosis }}">

                            <button type="submit" style="background-color: #9333ea;" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:opacity-90 transition shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Unduh
                            </button>
                        </form>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-10 text-sm">
                    <!-- Administrasi -->
                    <div>
                        <span class="text-purple-600 block text-[11px] font-extrabold mb-3 uppercase tracking-widest border-b border-purple-100 pb-1">Administrasi Surat</span>
                        <div class="space-y-3">
                            <div class="flex flex-col"><span class="text-slate-400 text-[11px] font-bold uppercase mb-0.5">No. Surat Rekomendasi BNN</span> <span class="font-bold text-slate-800 bg-slate-50 p-2.5 rounded-lg border border-slate-100">{{ $asesmen->no_surat_rekomendasi }}</span></div>
                            <div class="flex flex-col"><span class="text-slate-400 text-[11px] font-bold uppercase mb-0.5">Tgl Pembuatan Surat</span> <span class="font-bold text-slate-800 bg-slate-50 p-2.5 rounded-lg border border-slate-100">{{ $asesmen->tgl_rekomendasi ? \Carbon\Carbon::parse($asesmen->tgl_rekomendasi)->translatedFormat('d F Y') : '-' }}</span></div>
                            <div class="flex flex-col"><span class="text-slate-400 text-[11px] font-bold uppercase mb-0.5">Tujuan Surat (Kepada Yth)</span> <span class="font-bold text-slate-800 bg-slate-50 p-2.5 rounded-lg border border-slate-100">{{ $asesmen->kepada_yth }}</span></div>
                            <div class="flex flex-col"><span class="text-slate-400 text-[11px] font-bold uppercase mb-0.5">Kewarganegaraan Klien</span> <span class="font-bold text-slate-800 bg-slate-50 p-2.5 rounded-lg border border-slate-100">{{ $asesmen->kewarganegaraan }}</span></div>
                        </div>
                    </div>

                    <!-- Dasar Hukum -->
                    <div>
                        <span class="text-purple-600 block text-[11px] font-extrabold mb-3 uppercase tracking-widest border-b border-purple-100 pb-1">Dasar Hukum & Pengajuan</span>
                        <div class="space-y-3">
                            <div class="flex flex-col"><span class="text-slate-400 text-[11px] font-bold uppercase mb-0.5">No. Keputusan Tim TAT</span> <span class="font-bold text-slate-800 bg-slate-50 p-2.5 rounded-lg border border-slate-100">{{ $asesmen->no_keputusan }}</span></div>
                            <div class="flex flex-col"><span class="text-slate-400 text-[11px] font-bold uppercase mb-0.5">Tgl Keputusan Tim TAT</span> <span class="font-bold text-slate-800 bg-slate-50 p-2.5 rounded-lg border border-slate-100">{{ $asesmen->tgl_keputusan ? \Carbon\Carbon::parse($asesmen->tgl_keputusan)->translatedFormat('d F Y') : '-' }}</span></div>
                            <div class="flex flex-col"><span class="text-slate-400 text-[11px] font-bold uppercase mb-0.5">Tentang Permohonan</span> <span class="font-bold text-slate-800 bg-slate-50 p-2.5 rounded-lg border border-slate-100">{{ $asesmen->tentang_permohonan }}</span></div>
                        </div>
                    </div>

                    <!-- Diagnosis -->
                    <div class="md:col-span-2">
                        <span class="text-purple-600 block text-[11px] font-extrabold mb-3 uppercase tracking-widest border-b border-purple-100 pb-1">Diagnosis & Rekomendasi Medis</span>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col"><span class="text-slate-400 text-[11px] font-bold uppercase mb-0.5">Golongan Narkotika (Medis)</span> <span class="font-bold text-slate-800 bg-slate-50 p-2.5 rounded-lg border border-slate-100">{{ $asesmen->nama_narkotika_medis }}</span></div>
                            <div class="flex flex-col"><span class="text-slate-400 text-[11px] font-bold uppercase mb-0.5">Lama Waktu Perawatan</span> <span class="font-bold text-slate-800 bg-slate-50 p-2.5 rounded-lg border border-slate-100">{{ $asesmen->lama_perawatan }}</span></div>
                            <div class="flex flex-col md:col-span-2"><span class="text-slate-400 text-[11px] font-bold uppercase mb-0.5">Keterangan Diagnosis</span> <span class="font-bold text-slate-800 bg-slate-50 p-2.5 rounded-lg border border-slate-100">{{ $asesmen->keterangan_diagnosis }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <!-- EMPTY STATE JIKA DATA REKOMENDASI BELUM DIBUAT -->
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm mt-6 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Belum Ada Surat Rekomendasi</h3>
                <p class="text-slate-500 text-sm mb-6 max-w-md mx-auto">Klien ini belum dibuatkan dokumen administrasi Surat Rekomendasi TAT. Silakan lengkapi formulir terlebih dahulu.</p>
                <a href="{{ route('asesmen.rekomendasi', $asesmen->id) }}" class="inline-flex items-center px-6 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-bold text-sm rounded-xl transition shadow-sm">
                    Buat Surat Rekomendasi Sekarang
                </a>
            </div>
            @endif
            <!-- END CARD 6 -->

        </div> <!-- END MAX-W-7XL -->
    </div> <!-- END PY-8 -->
</x-app-layout>
