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
            <!-- 3. FORMULIR INPUT DINAMIS -->
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
                        <!-- Nomor Surat (Input Biasa) -->
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Nomor Surat Rekomendasi BNN <span class="text-rose-500">*</span></label>
                            <input type="text" name="no_surat_rekomendasi" value="{{ old('no_surat_rekomendasi', $asesmen->no_surat_rekomendasi) }}" placeholder="Misal: R/397/VII/Ka/PB.06.00/2026/BNNK" required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>

                        <!-- Tanggal (Input Biasa) -->
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Tanggal Pembuatan Surat <span class="text-rose-500">*</span></label>
                            <input type="text" name="tgl_rekomendasi" value="{{ old('tgl_rekomendasi', $asesmen->tgl_rekomendasi ?? date('Y-m-d')) }}" required class="datepicker-id block w-full rounded-xl border-slate-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100 sm:text-sm transition-all bg-slate-50 focus:bg-white" placeholder="Pilih Tanggal">
                        </div>

                        <!-- Tujuan Surat (DINAMIS) -->
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Tujuan Surat (Kepada Yth) <span class="text-rose-500">*</span></label>
                            <div class="flex gap-2 items-center">
                                <select name="kepada_yth" id="kepada_yth" required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100 sm:text-sm transition-all bg-slate-50 focus:bg-white text-slate-700 font-medium">
                                    <option value="">-- Pilih Tujuan Surat --</option>
                                    @if(isset($asesmen->kepada_yth) && $asesmen->kepada_yth !== '')
                                        <option value="{{ $asesmen->kepada_yth }}" selected>{{ $asesmen->kepada_yth }}</option>
                                    @endif
                                    @foreach($riwayat_kepada as $item)
                                        @if($item->kepada_yth !== $asesmen->kepada_yth && $item->kepada_yth !== '')
                                            <option value="{{ $item->kepada_yth }}">{{ $item->kepada_yth }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <button type="button" onclick="openTambahModal('kepada_yth', 'Tujuan Surat')" class="px-3 py-2.5 bg-indigo-50 text-indigo-700 rounded-lg text-[11px] font-bold hover:bg-indigo-100 transition shadow-sm whitespace-nowrap">+ TAMBAH</button>
                                <button type="button" onclick="openKelolaModal('kepada_yth', 'Tujuan Surat')" class="px-3 py-2.5 bg-slate-100 text-slate-600 rounded-lg text-[11px] font-bold hover:bg-slate-200 transition shadow-sm whitespace-nowrap">KELOLA</button>
                            </div>
                        </div>

                        <!-- Kewarganegaraan (Input Biasa) -->
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
                        <!-- No Keputusan (DINAMIS) -->
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">No. Keputusan Penunjukan Tim TAT <span class="text-rose-500">*</span></label>
                            <div class="flex gap-2 items-center">
                                <select name="no_keputusan" id="no_keputusan" required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100 sm:text-sm transition-all bg-slate-50 focus:bg-white text-slate-700 font-medium">
                                    <option value="">-- Pilih No. Keputusan --</option>
                                    @if(isset($asesmen->no_keputusan) && $asesmen->no_keputusan !== '')
                                        <option value="{{ $asesmen->no_keputusan }}" selected>{{ $asesmen->no_keputusan }}</option>
                                    @endif
                                    @foreach($riwayat_no_keputusan as $item)
                                        @if($item->no_keputusan !== $asesmen->no_keputusan && $item->no_keputusan !== '')
                                            <option value="{{ $item->no_keputusan }}">{{ $item->no_keputusan }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <button type="button" onclick="openTambahModal('no_keputusan', 'No. Keputusan Tim TAT')" class="px-3 py-2.5 bg-indigo-50 text-indigo-700 rounded-lg text-[11px] font-bold hover:bg-indigo-100 transition shadow-sm whitespace-nowrap">+ TAMBAH</button>
                                <button type="button" onclick="openKelolaModal('no_keputusan', 'No. Keputusan Tim TAT')" class="px-3 py-2.5 bg-slate-100 text-slate-600 rounded-lg text-[11px] font-bold hover:bg-slate-200 transition shadow-sm whitespace-nowrap">KELOLA</button>
                            </div>
                        </div>

                        <!-- Tanggal (Input Biasa) -->
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Tanggal Keputusan Penunjukan <span class="text-rose-500">*</span></label>
                            <input type="text" name="tgl_keputusan" value="{{ old('tgl_keputusan', $asesmen->tgl_keputusan) }}" required class="datepicker-id block w-full rounded-xl border-slate-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100 sm:text-sm transition-all bg-slate-50 focus:bg-white" placeholder="Pilih Tanggal">
                        </div>

                        <!-- Tentang Permohonan (DINAMIS) -->
                        <div class="md:col-span-2">
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Tentang Permohonan (Isi Surat) <span class="text-rose-500">*</span></label>
                            <div class="flex gap-2 items-center">
                                <select name="tentang_permohonan" id="tentang_permohonan" required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100 sm:text-sm transition-all bg-slate-50 focus:bg-white text-slate-700 font-medium">
                                    <option value="">-- Pilih Tentang Permohonan --</option>
                                    @if(isset($asesmen->tentang_permohonan) && $asesmen->tentang_permohonan !== '')
                                        <option value="{{ $asesmen->tentang_permohonan }}" selected>{{ $asesmen->tentang_permohonan }}</option>
                                    @endif
                                    @foreach($riwayat_tentang as $item)
                                        @if($item->tentang_permohonan !== $asesmen->tentang_permohonan && $item->tentang_permohonan !== '')
                                            <option value="{{ $item->tentang_permohonan }}">{{ $item->tentang_permohonan }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <button type="button" onclick="openTambahModal('tentang_permohonan', 'Tentang Permohonan')" class="px-3 py-2.5 bg-indigo-50 text-indigo-700 rounded-lg text-[11px] font-bold hover:bg-indigo-100 transition shadow-sm whitespace-nowrap">+ TAMBAH</button>
                                <button type="button" onclick="openKelolaModal('tentang_permohonan', 'Tentang Permohonan')" class="px-3 py-2.5 bg-slate-100 text-slate-600 rounded-lg text-[11px] font-bold hover:bg-slate-200 transition shadow-sm whitespace-nowrap">KELOLA</button>
                            </div>
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
                        <!-- Nama Golongan Narkotika (DINAMIS) -->
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Nama Golongan Narkotika <span class="text-slate-400 font-medium normal-case">(Medis)</span> <span class="text-rose-500">*</span></label>
                            <div class="flex gap-2 items-center">
                                <select name="nama_narkotika_medis" id="nama_narkotika_medis" required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100 sm:text-sm transition-all bg-slate-50 focus:bg-white text-slate-700 font-medium">
                                    <option value="">-- Pilih Golongan Narkotika --</option>
                                    @if(isset($asesmen->nama_narkotika_medis) && $asesmen->nama_narkotika_medis !== '')
                                        <option value="{{ $asesmen->nama_narkotika_medis }}" selected>{{ $asesmen->nama_narkotika_medis }}</option>
                                    @endif
                                    @foreach($riwayat_narkotika as $item)
                                        @if($item->nama_narkotika_medis !== $asesmen->nama_narkotika_medis && $item->nama_narkotika_medis !== '')
                                            <option value="{{ $item->nama_narkotika_medis }}">{{ $item->nama_narkotika_medis }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <button type="button" onclick="openTambahModal('nama_narkotika_medis', 'Golongan Narkotika (Medis)')" class="px-3 py-2.5 bg-indigo-50 text-indigo-700 rounded-lg text-[11px] font-bold hover:bg-indigo-100 transition shadow-sm whitespace-nowrap">+ TAMBAH</button>
                                <button type="button" onclick="openKelolaModal('nama_narkotika_medis', 'Golongan Narkotika (Medis)')" class="px-3 py-2.5 bg-slate-100 text-slate-600 rounded-lg text-[11px] font-bold hover:bg-slate-200 transition shadow-sm whitespace-nowrap">KELOLA</button>
                            </div>
                        </div>

                        <!-- Lama Waktu Perawatan (DINAMIS) -->
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Lama Waktu Perawatan <span class="text-rose-500">*</span></label>
                            <div class="flex gap-2 items-center">
                                <select name="lama_perawatan" id="lama_perawatan" required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100 sm:text-sm transition-all bg-slate-50 focus:bg-white text-slate-700 font-medium">
                                    <option value="">-- Pilih Waktu Perawatan --</option>
                                    @if(isset($asesmen->lama_perawatan) && $asesmen->lama_perawatan !== '')
                                        <option value="{{ $asesmen->lama_perawatan }}" selected>{{ $asesmen->lama_perawatan }}</option>
                                    @endif
                                    @foreach($riwayat_perawatan as $item)
                                        @if($item->lama_perawatan !== $asesmen->lama_perawatan && $item->lama_perawatan !== '')
                                            <option value="{{ $item->lama_perawatan }}">{{ $item->lama_perawatan }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <button type="button" onclick="openTambahModal('lama_perawatan', 'Lama Waktu Perawatan')" class="px-3 py-2.5 bg-indigo-50 text-indigo-700 rounded-lg text-[11px] font-bold hover:bg-indigo-100 transition shadow-sm whitespace-nowrap">+ TAMBAH</button>
                                <button type="button" onclick="openKelolaModal('lama_perawatan', 'Lama Waktu Perawatan')" class="px-3 py-2.5 bg-slate-100 text-slate-600 rounded-lg text-[11px] font-bold hover:bg-slate-200 transition shadow-sm whitespace-nowrap">KELOLA</button>
                            </div>
                        </div>

                        <!-- Keterangan Diagnosis Panjang (DINAMIS) -->
                        <div class="md:col-span-2">
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Keterangan Diagnosis Panjang <span class="text-rose-500">*</span></label>
                            <div class="flex gap-2 items-center">
                                <select name="keterangan_diagnosis" id="keterangan_diagnosis" required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100 sm:text-sm transition-all bg-slate-50 focus:bg-white text-slate-700 font-medium">
                                    <option value="">-- Pilih Keterangan Diagnosis --</option>
                                    @if(isset($asesmen->keterangan_diagnosis) && $asesmen->keterangan_diagnosis !== '')
                                        <option value="{{ $asesmen->keterangan_diagnosis }}" selected>{{ $asesmen->keterangan_diagnosis }}</option>
                                    @endif
                                    @foreach($riwayat_diagnosis as $item)
                                        @if($item->keterangan_diagnosis !== $asesmen->keterangan_diagnosis && $item->keterangan_diagnosis !== '')
                                            <option value="{{ $item->keterangan_diagnosis }}">{{ $item->keterangan_diagnosis }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <button type="button" onclick="openTambahModal('keterangan_diagnosis', 'Keterangan Diagnosis Panjang')" class="px-3 py-2.5 bg-indigo-50 text-indigo-700 rounded-lg text-[11px] font-bold hover:bg-indigo-100 transition shadow-sm whitespace-nowrap">+ TAMBAH</button>
                                <button type="button" onclick="openKelolaModal('keterangan_diagnosis', 'Keterangan Diagnosis Panjang')" class="px-3 py-2.5 bg-slate-100 text-slate-600 rounded-lg text-[11px] font-bold hover:bg-slate-200 transition shadow-sm whitespace-nowrap">KELOLA</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- TOMBOL SUBMIT -->
                <!-- ========================================== -->
                <div class="flex justify-end gap-3 pt-4 bg-slate-50 p-4 border border-slate-200 rounded-lg">
                    <a href="{{ route('asesmen.show', $asesmen->id) }}" class="inline-flex items-center justify-center px-6 py-3 bg-white border border-slate-300 rounded-lg font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">Batal</a>
                    <button type="submit" name="action" value="save" class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-semibold text-white hover:bg-blue-700 focus:outline-none transition shadow-sm">Simpan Perubahan</button>
                    <button type="submit" name="action" value="download" style="background-color: #9333ea;" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg font-semibold text-white hover:opacity-90 focus:outline-none transition shadow-sm">Simpan & Unduh Dokumen</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- COMPONENT MODAL (TAMBAH & KELOLA OPSI) -->
    <!-- ========================================== -->

    <!-- Modal Tambah Opsi -->
    <div id="modalTambah" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Background backdrop, soft blur -->
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeTambahModal()"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <!-- Modal panel -->
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-slate-100">
                    <div class="bg-white px-5 pt-6 pb-5 sm:p-6 sm:pb-5">
                        <h3 class="text-lg leading-6 font-extrabold text-slate-900 mb-4" id="modal-title">Tambah <span id="tambah_label" class="text-indigo-600"></span> Baru</h3>
                        <input type="hidden" id="tambah_target_id">
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1">Nama/Nilai Baru</label>
                        <input type="text" id="tambah_input" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-sm py-2.5" placeholder="Ketik di sini...">
                    </div>
                    <div class="bg-slate-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100 gap-2">
                        <button type="button" onclick="simpanOpsiBaru()" class="w-full inline-flex justify-center rounded-lg border border-transparent bg-indigo-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-indigo-700 sm:w-auto transition-colors">Simpan</button>
                        <button type="button" onclick="closeTambahModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-bold text-slate-700 shadow-sm hover:bg-slate-50 sm:mt-0 sm:w-auto transition-colors">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Kelola Opsi (Hapus) -->
    <div id="modalKelola" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Background backdrop, soft blur -->
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeKelolaModal()"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <!-- Modal panel -->
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-100">
                    <div class="bg-white px-6 pt-6 pb-4">
                        <div class="flex justify-between items-center border-b border-slate-100 pb-3 mb-4">
                            <h3 class="text-lg leading-6 font-extrabold text-slate-900">Kelola Daftar <span id="kelola_label" class="text-indigo-600"></span></h3>
                            <button onclick="closeKelolaModal()" class="text-slate-400 hover:text-rose-500 transition-colors"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                        </div>
                        <input type="hidden" id="kelola_target_id">

                        <ul id="kelola_list" class="space-y-2 max-h-[40vh] overflow-y-auto pr-2">
                            <!-- List Item akan digenerate disini -->
                        </ul>
                    </div>
                    <div class="bg-slate-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100">
                        <button type="button" onclick="closeKelolaModal()" class="w-full inline-flex justify-center rounded-lg border border-transparent bg-slate-200 px-6 py-2.5 text-sm font-bold text-slate-700 shadow-sm hover:bg-slate-300 sm:w-auto transition-colors">Tutup Kelola</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT JAVASCRIPT UNTUK MODAL & OPSI DINAMIS -->
    <script>
        // Logika untuk Modal TAMBAH
        function openTambahModal(selectId, labelName) {
            document.getElementById('tambah_target_id').value = selectId;
            document.getElementById('tambah_label').innerText = labelName;
            document.getElementById('tambah_input').value = '';
            document.getElementById('modalTambah').classList.remove('hidden');
            setTimeout(() => document.getElementById('tambah_input').focus(), 100);
        }

        function closeTambahModal() {
            document.getElementById('modalTambah').classList.add('hidden');
        }

        function simpanOpsiBaru() {
            const selectId = document.getElementById('tambah_target_id').value;
            const newValue = document.getElementById('tambah_input').value.trim();

            if(newValue !== '') {
                const selectEl = document.getElementById(selectId);
                // Cek apakah opsi sudah ada agar tidak ganda
                let exists = false;
                for(let i = 0; i < selectEl.options.length; i++) {
                    if(selectEl.options[i].value === newValue) {
                        exists = true;
                        break;
                    }
                }

                // Jika belum ada, buat elemen <option> baru dan pilih
                if(!exists) {
                    const newOpt = new Option(newValue, newValue, true, true);
                    selectEl.add(newOpt);
                } else {
                    selectEl.value = newValue;
                }

                closeTambahModal();
            }
        }

        // Logika untuk Modal KELOLA (HAPUS)
        function openKelolaModal(selectId, labelName) {
            document.getElementById('kelola_target_id').value = selectId;
            document.getElementById('kelola_label').innerText = labelName;

            const selectEl = document.getElementById(selectId);
            const listContainer = document.getElementById('kelola_list');
            listContainer.innerHTML = ''; // Bersihkan list sebelumnya

            let hasItems = false;

            // Generate elemen <li> beserta tombol Hapus untuk setiap <option>
            for(let i = 0; i < selectEl.options.length; i++) {
                const opt = selectEl.options[i];
                if(opt.value !== '') { // Abaikan opsi "-- Pilih --"
                    hasItems = true;
                    const li = document.createElement('li');
                    li.className = "flex justify-between items-center p-3.5 bg-slate-50 border border-slate-100 rounded-xl hover:bg-white hover:shadow-sm transition-all";
                    li.innerHTML = `
                        <span class="text-sm font-medium text-slate-700 leading-snug w-3/4">${opt.text}</span>
                        <button type="button" onclick="hapusOpsiLokal('${selectId}', '${opt.value}', this)" class="text-xs font-bold text-rose-500 hover:text-white bg-rose-50 border border-rose-100 hover:bg-rose-500 px-4 py-1.5 rounded-lg transition shadow-sm">Hapus</button>
                    `;
                    listContainer.appendChild(li);
                }
            }

            if(!hasItems) {
                listContainer.innerHTML = '<li class="text-center text-slate-400 py-4 text-sm italic">Belum ada daftar riwayat tersimpan.</li>';
            }

            document.getElementById('modalKelola').classList.remove('hidden');
        }

        function closeKelolaModal() {
            document.getElementById('modalKelola').classList.add('hidden');
        }

        function hapusOpsiLokal(selectId, valueToRemove, btnEl) {
            const selectEl = document.getElementById(selectId);

            // Hapus dari dropdown <select> di form utama
            for(let i = 0; i < selectEl.options.length; i++) {
                if(selectEl.options[i].value === valueToRemove) {
                    selectEl.remove(i);
                    break;
                }
            }

            // Hapus secara visual dari list modal
            const li = btnEl.closest('li');
            li.style.opacity = '0';
            setTimeout(() => {
                li.remove();
                if(document.getElementById('kelola_list').children.length === 0) {
                    document.getElementById('kelola_list').innerHTML = '<li class="text-center text-slate-400 py-4 text-sm italic">Semua opsi telah dihapus dari daftar ini.</li>';
                }
            }, 200);
        }
    </script>
</x-app-layout>
