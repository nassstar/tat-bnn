<x-app-layout>
    <div class="py-8 sm:py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- ========================================== -->
            <!-- 1. HEADER (SEAMLESS HERO) -->
            <!-- ========================================== -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <!-- Tombol Kembali ke Detail -->
                    <a href="{{ route('asesmen.show', $asesmen->id) }}" class="p-2.5 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-purple-600 transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <div>
                        <div class="inline-flex items-center gap-2 px-2 py-0.5 rounded text-[10px] font-bold bg-purple-100 text-purple-700 uppercase tracking-wider mb-1">
                            Generator Dokumen (Word)
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">Surat Rekomendasi: {{ $asesmen->nama_lengkap }}</h1>
                    </div>
                </div>
                <div class="text-sm text-slate-500 bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm hidden md:block">
                    Lengkapi form untuk mencetak <span class="font-bold text-slate-700">Surat Rekomendasi TAT</span>.
                </div>
            </div>

            <!-- ========================================== -->
            <!-- 2. KARTU PREVIEW DATA OTOMATIS -->
            <!-- ========================================== -->
            <div class="bg-indigo-50/50 p-6 md:p-8 rounded-2xl border border-indigo-100 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-indigo-500"></div>
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 border-b border-indigo-200/60 pb-3 mt-1 gap-2">
                    <h3 class="text-sm font-extrabold text-indigo-900 uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Preview Data Klien (Autofill ke Word)
                    </h3>
                    <p class="text-[11px] font-bold text-indigo-600 bg-white px-3 py-1 rounded-lg border border-indigo-100 shadow-sm uppercase tracking-wider">Hanya Baca</p>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                    <div class="bg-white p-3.5 rounded-xl border border-indigo-50 shadow-sm">
                        <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Nama Lengkap</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $asesmen->nama_lengkap }}</span>
                    </div>
                    <div class="bg-white p-3.5 rounded-xl border border-indigo-50 shadow-sm">
                        <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">NIK</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $asesmen->nik }}</span>
                    </div>
                    <div class="bg-white p-3.5 rounded-xl border border-indigo-50 shadow-sm">
                        <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">No. Surat Pengajuan</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $asesmen->no_surat_pengajuan ?? '-' }}</span>
                    </div>
                    <div class="bg-white p-3.5 rounded-xl border border-indigo-50 shadow-sm">
                        <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Jenis Narkotika</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $asesmen->narkotika->jenis_narkotika ?? '-' }}</span>
                    </div>
                    <div class="md:col-span-4 bg-gradient-to-r from-purple-500 to-indigo-600 p-4 rounded-xl shadow-md text-white flex items-center justify-between">
                        <div>
                            <span class="block text-[11px] font-medium text-purple-100 uppercase tracking-wider mb-0.5">Keputusan Tempat Rehabilitasi</span>
                            <span class="font-extrabold text-lg">{{ $asesmen->rekomendasi->tempat_rehabilitasi ?? 'Belum ada data tempat rehabilitasi' }}</span>
                        </div>
                        <svg class="w-8 h-8 text-white/50 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- 3. FORMULIR INSIDENTAL (INPUT MANUAL) -->
            <!-- ========================================== -->
            <form action="{{ route('asesmen.rekomendasi.unduh', $asesmen->id) }}" method="POST" class="space-y-8">
                @csrf

                <!-- SEKSI 1: ADMINISTRASI SURAT -->
                <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-purple-500"></div>
                    <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider mb-6 border-b border-slate-100 pb-3 flex items-center gap-2 mt-1">
                        <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        1. Administrasi Surat
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Nomor Surat Rekomendasi BNN <span class="text-rose-500">*</span></label>
                            <input type="text" name="no_surat_rekomendasi" value="{{ old('no_surat_rekomendasi', $asesmen->no_surat_rekomendasi) }}" placeholder="Misal: R/397/VII/Ka/PB.06.00/2026/BNNK" required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Tanggal Pembuatan Surat <span class="text-rose-500">*</span></label>
                            <input type="text" name="tgl_rekomendasi" value="{{ old('tgl_rekomendasi', $asesmen->tgl_rekomendasi ?? date('Y-m-d')) }}" required class="datepicker-id block w-full rounded-xl border-slate-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100 sm:text-sm transition-all bg-slate-50 focus:bg-white" placeholder="Pilih Tanggal">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Tujuan Surat (Kepada Yth) <span class="text-rose-500">*</span></label>
                            <input type="text" name="kepada_yth" list="list_kepada" value="{{ old('kepada_yth', $asesmen->kepada_yth) }}" placeholder="Misal: Kepala Kepolisian Resor Malang" required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100 sm:text-sm transition-all bg-slate-50 focus:bg-white" autocomplete="off">
                            <datalist id="list_kepada">
                                @foreach($riwayat_kepada as $item) <option value="{{ $item->kepada_yth }}"></option> @endforeach
                            </datalist>
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Kewarganegaraan Klien</label>
                            <input type="text" name="kewarganegaraan" value="{{ old('kewarganegaraan', $asesmen->kewarganegaraan ?? 'Indonesia (WNI)') }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                    </div>
                </div>

                <!-- SEKSI 2: DASAR HUKUM & PENGAJUAN -->
                <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-purple-500"></div>
                    <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider mb-6 border-b border-slate-100 pb-3 flex items-center gap-2 mt-1">
                        <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                        2. Dasar Hukum & Pengajuan
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">No. Keputusan Penunjukan Tim TAT <span class="text-rose-500">*</span></label>
                            <input type="text" name="no_keputusan" list="list_nokeputusan" value="{{ old('no_keputusan', $asesmen->no_keputusan) }}" placeholder="Misal: KEP/10/IV/KA/KP/2026..." required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100 sm:text-sm transition-all bg-slate-50 focus:bg-white" autocomplete="off">
                            <datalist id="list_nokeputusan">
                                @foreach($riwayat_no_keputusan as $item) <option value="{{ $item->no_keputusan }}"></option> @endforeach
                            </datalist>
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Tanggal Keputusan Penunjukan <span class="text-rose-500">*</span></label>
                            <input type="text" name="tgl_keputusan" value="{{ old('tgl_keputusan', $asesmen->tgl_keputusan) }}" required class="datepicker-id block w-full rounded-xl border-slate-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100 sm:text-sm transition-all bg-slate-50 focus:bg-white" placeholder="Pilih Tanggal">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Tentang Permohonan (Isi Surat) <span class="text-rose-500">*</span></label>
                            <input type="text" name="tentang_permohonan" list="list_tentang" value="{{ old('tentang_permohonan', $asesmen->tentang_permohonan) }}" placeholder="Misal: Permohonan Bantuan Asesmen dalam Proses Hukum" required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100 sm:text-sm transition-all bg-slate-50 focus:bg-white" autocomplete="off">
                            <datalist id="list_tentang">
                                @foreach($riwayat_tentang as $item) <option value="{{ $item->tentang_permohonan }}"></option> @endforeach
                            </datalist>
                        </div>
                    </div>
                </div>

                <!-- SEKSI 3: DIAGNOSIS & REKOMENDASI MEDIS -->
                <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-purple-500"></div>
                    <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider mb-6 border-b border-slate-100 pb-3 flex items-center gap-2 mt-1">
                        <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        3. Diagnosis & Rekomendasi Medis
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Nama Golongan Narkotika <span class="text-slate-400 font-medium normal-case">(Medis)</span> <span class="text-rose-500">*</span></label>
                            <input type="text" name="nama_narkotika_medis" list="list_narkotika_medis" value="{{ old('nama_narkotika_medis', $asesmen->nama_narkotika_medis) }}" placeholder="Misal: Metamphetamine" required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100 sm:text-sm transition-all bg-slate-50 focus:bg-white" autocomplete="off">
                            <datalist id="list_narkotika_medis">
                                @foreach($riwayat_narkotika as $item) <option value="{{ $item->nama_narkotika_medis }}"></option> @endforeach
                            </datalist>
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Lama Waktu Perawatan <span class="text-rose-500">*</span></label>
                            <input type="text" name="lama_perawatan" list="list_perawatan" value="{{ old('lama_perawatan', $asesmen->lama_perawatan) }}" placeholder="Misal: 1 (satu) sampai 3 (tiga) bulan" required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100 sm:text-sm transition-all bg-slate-50 focus:bg-white" autocomplete="off">
                            <datalist id="list_perawatan">
                                @foreach($riwayat_perawatan as $item) <option value="{{ $item->lama_perawatan }}"></option> @endforeach
                            </datalist>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Keterangan Diagnosis Panjang <span class="text-rose-500">*</span></label>
                            <input type="text" name="keterangan_diagnosis" list="list_diagnosis" value="{{ old('keterangan_diagnosis', $asesmen->keterangan_diagnosis) }}" placeholder="Misal: didiagnosis Gangguan Mental dan Perilaku..." required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100 sm:text-sm transition-all bg-slate-50 focus:bg-white" autocomplete="off">
                            <datalist id="list_diagnosis">
                                @foreach($riwayat_diagnosis as $item) <option value="{{ $item->keterangan_diagnosis }}"></option> @endforeach
                            </datalist>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- TOMBOL SUBMIT -->
                <!-- ========================================== -->
                <!-- ========================================== -->
                <!-- TOMBOL SUBMIT SURAT REKOMENDASI -->
                <!-- ========================================== -->
                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 pb-10">
                    <a href="{{ route('asesmen.show', $asesmen->id) }}" class="inline-flex justify-center items-center px-6 py-3 bg-white border border-slate-300 rounded-xl text-slate-700 font-bold hover:bg-slate-50 transition-all shadow-sm focus:ring-2 focus:ring-slate-200">
                        Batal
                    </a>

                    <!-- Tombol 1: Simpan Saja -->
                    <button type="submit" name="action" value="save_only" class="inline-flex justify-center items-center px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 hover:-translate-y-0.5 transition-all shadow-lg shadow-blue-200 focus:ring-4 focus:ring-blue-100">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                        Simpan Perubahan
                    </button>

                    <!-- Tombol 2: Simpan & Unduh -->
                    <button type="submit" name="action" value="generate" class="inline-flex justify-center items-center px-6 py-3 bg-purple-600 text-white font-bold rounded-xl hover:bg-purple-700 hover:-translate-y-0.5 transition-all shadow-lg shadow-purple-200 focus:ring-4 focus:ring-purple-100">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Simpan & Unduh Dokumen
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>