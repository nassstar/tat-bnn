<x-app-layout>
    <div class="py-8 sm:py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- ========================================== -->
            <!-- 1. HEADER & TOMBOL AKSI -->
            <!-- ========================================== -->
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('asesmen.index') }}" class="p-2.5 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-indigo-600 transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $asesmen->status_kelengkapan === 'Data Lengkap' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $asesmen->status_kelengkapan ?? 'Status Tidak Diketahui' }}
                            </span>
                            @if($asesmen->pelaksanaan == 'YA')
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-700 uppercase tracking-wider">Telah Rapat TAT</span>
                            @endif
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">Detail Klien: {{ $asesmen->nama_lengkap }}</h1>
                    </div>
                </div>

                <!-- Kumpulan Tombol Cetak Dokumen -->
                <div class="flex flex-wrap gap-2 w-full lg:w-auto mt-2 lg:mt-0">
                    <a href="{{ route('asesmen.edit', $asesmen->id) }}" class="flex-1 lg:flex-none inline-flex justify-center items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 border border-transparent rounded-lg text-xs font-bold text-white shadow-sm transition-all focus:ring-2 focus:ring-amber-300">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                        Edit Data
                    </a>
                    <a href="{{ route('asesmen.berita-acara', $asesmen->id) }}" class="flex-1 lg:flex-none inline-flex justify-center items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg text-xs font-bold text-white hover:bg-emerald-700 shadow-sm transition-all focus:ring-2 focus:ring-emerald-300">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        BA (Word)
                    </a>
                    <a href="{{ route('asesmen.rekomendasi', $asesmen->id) }}" class="flex-1 lg:flex-none inline-flex justify-center items-center px-4 py-2 bg-purple-600 border border-transparent rounded-lg text-xs font-bold text-white hover:bg-purple-700 shadow-sm transition-all focus:ring-2 focus:ring-purple-300">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                        Rekom (Word)
                    </a>
                    <a href="{{ route('asesmen.cetakPdf', $asesmen->id) }}" target="_blank" class="flex-1 lg:flex-none inline-flex justify-center items-center px-4 py-2 bg-rose-600 border border-transparent rounded-lg text-xs font-bold text-white hover:bg-rose-700 shadow-sm transition-all focus:ring-2 focus:ring-rose-300">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                        Cetak PDF
                    </a>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- 2. GRID KONTEN (1/3 Kiri, 2/3 Kanan) -->
            <!-- ========================================== -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">

                <!-- ========================================== -->
                <!-- KOLOM KIRI (Administrasi & Identitas) - 4 Kolom dari 12 -->
                <!-- ========================================== -->
                <div class="lg:col-span-4 space-y-6">
                    
                    <!-- Card 1: Data Administrasi -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-indigo-500"></div>
                        <h3 class="text-[13px] font-extrabold text-slate-800 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2 ml-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            1. Data Administrasi
                        </h3>
                        <div class="space-y-3 text-[13px] ml-2">
                            <div class="flex justify-between border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium">No. Register</span> <span class="font-bold text-slate-800">{{ $asesmen->no_register ?? '-' }}</span></div>
                            <div class="flex justify-between border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium">No / Bulan</span> <span class="font-bold text-slate-800">{{ $asesmen->no_bln ?? '-' }}</span></div>
                            <div class="flex flex-col border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium mb-1">Asal Pengajuan</span> <span class="font-bold text-slate-800 leading-snug">{{ $asesmen->asal_pengajuan ?? '-' }}</span></div>
                            <div class="flex flex-col border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium mb-1">No. Surat Pengajuan</span> <span class="font-bold text-slate-800 leading-snug">{{ $asesmen->no_surat_pengajuan ?? '-' }}</span></div>
                            <div class="flex flex-col border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium mb-1">No. LKN</span> <span class="font-bold text-slate-800 leading-snug">{{ $asesmen->no_lkn ?? '-' }}</span></div>
                            
                            <div class="grid grid-cols-2 gap-2 mt-3 pt-3 bg-slate-50 rounded-xl p-3 border border-slate-100">
                                <div><span class="block text-[11px] text-slate-400 font-medium mb-0.5">Tgl Surat</span><span class="font-bold text-slate-800">{{ $asesmen->tgl_surat ? \Carbon\Carbon::parse($asesmen->tgl_surat)->format('d/m/Y') : '-' }}</span></div>
                                <div><span class="block text-[11px] text-slate-400 font-medium mb-0.5">Tgl Masuk</span><span class="font-bold text-slate-800">{{ $asesmen->tgl_berkas ? \Carbon\Carbon::parse($asesmen->tgl_berkas)->format('d/m/Y') : '-' }}</span></div>
                                <div><span class="block text-[11px] text-slate-400 font-medium mb-0.5">Tgl Tangkap</span><span class="font-bold text-slate-800">{{ $asesmen->tgl_tangkap ? \Carbon\Carbon::parse($asesmen->tgl_tangkap)->format('d/m/Y') : '-' }}</span></div>
                                <div><span class="block text-[11px] text-indigo-500 font-bold mb-0.5">Tgl Rapat TAT</span><span class="font-bold text-indigo-700">{{ $asesmen->tgl_pelaksanaan ? \Carbon\Carbon::parse($asesmen->tgl_pelaksanaan)->format('d/m/Y') : '-' }}</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Identitas Pribadi -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-blue-500"></div>
                        <h3 class="text-[13px] font-extrabold text-slate-800 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2 ml-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            2. Profil Klien
                        </h3>
                        
                        <div class="flex items-center gap-3 mb-5 bg-slate-50 p-3 rounded-xl border border-slate-100 ml-2">
                            <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-700 font-extrabold flex items-center justify-center text-xl shrink-0">
                                {{ strtoupper(substr($asesmen->nama_lengkap ?? 'A', 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 leading-tight text-sm">{{ $asesmen->nama_lengkap }}</h4>
                                <p class="text-xs text-slate-500 mt-0.5">NIK: <span class="font-semibold">{{ $asesmen->nik ?? '-' }}</span></p>
                            </div>
                        </div>

                        <div class="space-y-3 text-[13px] ml-2">
                            <div class="flex justify-between border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium">No. HP</span> <span class="font-bold text-slate-800">{{ $asesmen->no_hp ?? '-' }}</span></div>
                            <div class="flex flex-col border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium mb-1">TTL</span> <span class="font-bold text-slate-800">{{ $asesmen->tempat_lahir ?? '-' }}, {{ $asesmen->tgl_lahir ? \Carbon\Carbon::parse($asesmen->tgl_lahir)->format('d F Y') : '-' }}</span></div>
                            <div class="flex justify-between border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium">Jenis Kelamin</span> <span class="font-bold text-slate-800">{{ $asesmen->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</span></div>
                            <div class="flex justify-between border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium">Kewarganegaraan</span> <span class="font-bold text-slate-800">{{ $asesmen->kewarganegaraan ?? '-' }}</span></div>
                            <div class="flex justify-between border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium">Agama</span> <span class="font-bold text-slate-800">{{ $asesmen->agama ?? '-' }}</span></div>
                            <div class="flex justify-between border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium">Pendidikan</span> <span class="font-bold text-slate-800">{{ $asesmen->pendidikan->nama_pendidikan ?? '-' }}</span></div>
                            <div class="flex flex-col border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium mb-1">Pekerjaan</span> <span class="font-bold text-slate-800 line-clamp-2">{{ $asesmen->pekerjaan->nama_pekerjaan ?? '-' }}</span></div>
                            <div class="flex flex-col border-b border-slate-50 pb-1.5"><span class="text-slate-500 font-medium mb-1">Penghasilan /Bulan</span> <span class="font-bold text-slate-800">{{ $asesmen->penghasilan_rata_rata ?? '-' }}</span></div>
                            
                            <div class="pt-2">
                                <span class="text-slate-500 font-medium block mb-1">Alamat KTP</span>
                                <p class="font-bold text-slate-800 bg-slate-50 p-2.5 rounded-xl border border-slate-100 leading-relaxed">{{ $asesmen->alamat_ktp ?? '-' }}</p>
                            </div>
                            <div class="pt-2">
                                <span class="text-slate-500 font-medium block mb-1">Alamat Domisili saat ini</span>
                                <p class="font-bold text-slate-800 bg-slate-50 p-2.5 rounded-xl border border-slate-100 leading-relaxed">{{ $asesmen->alamat_domisili ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ========================================== -->
                <!-- KOLOM KANAN (Kronologi Hukum, Medis & TAT) - 8 Kolom dari 12 -->
                <!-- ========================================== -->
                <div class="lg:col-span-8 space-y-6">

                    <!-- Card 3: Perkara Hukum & Barang Bukti -->
                    <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1.5 bg-amber-400"></div>
                        <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider mb-6 border-b border-slate-100 pb-3 flex items-center gap-2 mt-1">
                            <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                            3. Status Perkara & Barang Bukti
                        </h3>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 border-b border-slate-100 pb-6 mb-6">
                            <div>
                                <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Zat/Narkotika</span>
                                <span class="font-extrabold text-slate-900 text-base">{{ $asesmen->narkotika->jenis_narkotika ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Berat Bukti (BB)</span>
                                <span class="font-extrabold text-slate-900 text-base">{{ $asesmen->berat_bb ? $asesmen->berat_bb . ' gram' : '-' }}</span>
                            </div>
                            <div>
                                <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Status Hukum</span>
                                <span class="inline-flex px-3 py-1 rounded-md text-[11px] font-extrabold bg-amber-100 text-amber-800 border border-amber-200 shadow-sm">
                                    {{ $asesmen->status_hukum ?? 'Belum Diinput' }}
                                </span>
                            </div>
                            <div>
                                <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Hasil Tes Urine</span>
                                @php
                                    $urineText = $asesmen->tes_urine ?? '';
                                    $urineFirstWord = strtoupper(strtok($urineText, " :,-"));
                                @endphp
                                @if($urineFirstWord === 'POSITIF')
                                    <span class="inline-flex px-3 py-1 rounded-md text-[11px] font-extrabold bg-rose-100 text-rose-800 shadow-sm">{{ $asesmen->tes_urine }}</span>
                                @elseif($urineFirstWord === 'NEGATIF')
                                    <span class="inline-flex px-3 py-1 rounded-md text-[11px] font-extrabold bg-emerald-100 text-emerald-800 shadow-sm">{{ $asesmen->tes_urine }}</span>
                                @else
                                    <span class="inline-flex px-3 py-1 rounded-md text-[11px] font-extrabold bg-slate-100 text-slate-700 shadow-sm">{{ $asesmen->tes_urine ?? '-' }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Pasal Sangkaan</span>
                                <p class="font-bold text-slate-800 text-[15px] bg-slate-50 p-3 rounded-xl border border-slate-100">{{ $asesmen->pasal_sangkaan ?? '-' }}</p>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                    <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Detail Barang Bukti</span>
                                    <p class="text-sm font-semibold text-slate-700 leading-relaxed">{{ $asesmen->deskripsi_bb ?? 'Tidak ada deskripsi.' }}</p>
                                </div>
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                    <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Riwayat Barang Bukti</span>
                                    <ul class="text-sm font-medium text-slate-700 space-y-2">
                                        <li><span class="text-slate-500 block text-[11px] uppercase tracking-wider">Dapat dari:</span> {{ $asesmen->dapat_dari_siapa ?? '-' }}</li>
                                        <li><span class="text-slate-500 block text-[11px] uppercase tracking-wider">Cara dapat:</span> {{ $asesmen->cara_mendapatkan ?? '-' }}</li>
                                        <li><span class="text-slate-500 block text-[11px] uppercase tracking-wider">Keterlibatan Jaringan:</span> <span class="font-bold {{ strtolower($asesmen->keterlibatan_jaringan) == 'tidak' ? 'text-emerald-600' : 'text-rose-600' }}">{{ $asesmen->keterlibatan_jaringan ?? '-' }}</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Card 4 & 5: Hasil Narasi Asesmen & TAT (RUANG DIPERBESAR) -->
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
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
                    </div>


                    <!-- ========================================== -->
                    <!-- KELOMPOK 3: KESIMPULAN & REKOMENDASI FINAL -->
                    <!-- ========================================== -->
                    <div class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 rounded-2xl border border-indigo-200 shadow-lg overflow-hidden relative">
                        <!-- Ornamen -->
                        <div class="absolute top-0 right-0 p-8 opacity-10">
                            <svg class="w-48 h-48 text-indigo-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        </div>

                        <div class="px-6 md:px-8 py-5 border-b border-indigo-100/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 relative z-10">
                            <h3 class="text-base font-extrabold text-indigo-900 uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                5. Kesimpulan Diagnostik & Keputusan Rekomendasi TAT
                            </h3>
                            <a href="{{ route('asesmen.rekomendasi', $asesmen->id) }}" class="text-[11px] font-bold text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-lg transition shadow-sm">Form Rekomendasi &rarr;</a>
                        </div>
                        
                        <div class="p-6 md:p-8 relative z-10 space-y-8">
                            
                            <!-- Blok Atas: Kesimpulan Diagnostik TAT -->
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

                            <!-- Blok Bawah: Hasil Final Rekomendasi -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                
                                <!-- Hasil Penempatan (Kotak Hijau Besar) -->
                                <div>
                                    <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Keputusan Tempat Rehab (Final)</span>
                                    <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-6 text-white shadow-lg">
                                        <div class="flex items-start gap-4 mb-4">
                                            <div class="p-3 bg-white/20 rounded-xl shrink-0"><svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg></div>
                                            <div>
                                                <div class="text-[12px] font-medium text-emerald-100 uppercase tracking-wider mb-1">Ditempatkan di:</div>
                                                <div class="text-xl md:text-2xl font-extrabold leading-tight">{{ $asesmen->rekomendasi_tempat_rehab ?? $asesmen->rekomendasi_input ?? 'Belum ditentukan' }}</div>
                                            </div>
                                        </div>
                                        <div class="border-t border-emerald-400/50 pt-3 mt-3">
                                            <div class="text-[13px] font-medium text-emerald-100">Durasi Perawatan Terpadu: <span class="font-extrabold text-white text-base ml-2 px-3 py-1 bg-black/10 rounded-lg">{{ $asesmen->rekomendasi_durasi ?? '-' }}</span></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Saran & Keterangan -->
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
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>