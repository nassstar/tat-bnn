<x-app-layout>
    <div class="py-8 sm:py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- ========================================== -->
            <!-- 1. HEADER (SEAMLESS HERO) -->
            <!-- ========================================== -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('asesmen.show', $asesmen->id) }}" class="p-2.5 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-emerald-600 transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <div>
                        <div class="inline-flex items-center gap-2 px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase tracking-wider mb-1">
                            Generator Dokumen (Word)
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">Berita Acara: {{ $asesmen->nama_lengkap }}</h1>
                    </div>
                </div>
                <div class="text-sm text-slate-500 bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm hidden md:block">
                    Isi dan lengkapi data untuk mencetak <span class="font-bold text-slate-700">Berita Acara TAT</span>.
                </div>
            </div>

            <form action="{{ route('asesmen.berita-acara.generate', $asesmen->id) }}" method="POST" class="space-y-8" id="formBeritaAcara">
                @csrf
                <div id="hidden-inputs-container"></div>

                <!-- ========================================== -->
                <!-- SEKSI 1: HEADER SURAT & PIMPINAN RAPAT -->
                <!-- ========================================== -->
                <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-slate-500"></div>
                    <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider mb-6 border-b border-slate-100 pb-3 flex items-center gap-2 mt-1">
                        <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        1. Header Surat & Pimpinan Rapat
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Nomor Berita Acara</label>
                            <input type="text" name="no_ba" value="{{ old('no_ba', $asesmen->no_ba) }}" placeholder="Cth: BA/277/VII/TAT/..." class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Tanggal Rapat (BA)</label>
                            <input type="date" name="tgl_ba" value="{{ old('tgl_ba', $asesmen->tgl_ba) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Nama Ketua TAT</label>
                            <input type="text" name="ketua_tat_nama" value="{{ old('ketua_tat_nama', $asesmen->ketua_tat_nama ?? 'LETKOL LAUT (PM) Hendratmo Budi Wibowo S Pd.') }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">NRP Ketua TAT</label>
                            <input type="text" name="ketua_tat_nrp" value="{{ old('ketua_tat_nrp', $asesmen->ketua_tat_nrp ?? '16301/P') }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div class="md:col-span-2">
                            <div class="flex flex-col sm:flex-row gap-5">
                                <div class="flex-1">
                                    <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Nomor SK Tim Asesmen</label>
                                    <input type="text" name="no_kep_tim" value="{{ old('no_kep_tim', $asesmen->no_kep_tim ?? 'KEP/10/IV/KA/KP/2026/BNN Kab. Malang') }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                                </div>
                                <div class="sm:w-1/3">
                                    <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Tanggal SK Tim</label>
                                    <input type="date" name="tgl_kep_tim" value="{{ old('tgl_kep_tim', $asesmen->tgl_kep_tim) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- SEKSI 2: PEMILIHAN ANGGOTA TIM TAT -->
                <!-- ========================================== -->
                <div class="bg-indigo-50/50 p-6 md:p-8 rounded-2xl border border-indigo-100 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-indigo-500"></div>
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 border-b border-indigo-200/60 pb-3 mt-1 gap-2">
                        <h3 class="text-sm font-extrabold text-indigo-900 uppercase tracking-wider flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            2. Susunan Anggota Tim TAT
                        </h3>
                        <p class="text-xs font-semibold text-indigo-600 bg-white px-3 py-1 rounded-lg border border-indigo-100 shadow-sm">Pilih & Kelola dari Master Data</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- KOLOM TIM MEDIS -->
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-indigo-100">
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-2">Tim Medis <span class="text-slate-400 font-medium normal-case">(Maks. 2)</span></label>
                            <div class="flex gap-2 mb-4">
                                <select id="select-medis" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 sm:text-sm bg-slate-50 focus:bg-white transition-all">
                                    <option value="">-- Pilih Dokter --</option>
                                </select>
                                <button type="button" onclick="bukaModal('medis')" class="px-3 py-2 bg-indigo-100 text-indigo-700 text-xs font-bold rounded-xl hover:bg-indigo-200 transition whitespace-nowrap shadow-sm">+ Baru</button>
                                <button type="button" onclick="bukaKelola('medis')" class="px-3 py-2 bg-slate-100 text-slate-600 text-xs font-bold rounded-xl hover:bg-slate-200 transition whitespace-nowrap shadow-sm">⚙️ Kelola</button>
                            </div>
                            <div id="container-medis" class="space-y-2"></div>
                        </div>

                        <!-- KOLOM TIM HUKUM -->
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-indigo-100">
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-2">Tim Hukum <span class="text-slate-400 font-medium normal-case">(Maks. 3)</span></label>
                            <div class="flex gap-2 mb-4">
                                <select id="select-hukum" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 sm:text-sm bg-slate-50 focus:bg-white transition-all">
                                    <option value="">-- Pilih Penyidik/Jaksa --</option>
                                </select>
                                <button type="button" onclick="bukaModal('hukum')" class="px-3 py-2 bg-indigo-100 text-indigo-700 text-xs font-bold rounded-xl hover:bg-indigo-200 transition whitespace-nowrap shadow-sm">+ Baru</button>
                                <button type="button" onclick="bukaKelola('hukum')" class="px-3 py-2 bg-slate-100 text-slate-600 text-xs font-bold rounded-xl hover:bg-slate-200 transition whitespace-nowrap shadow-sm">⚙️ Kelola</button>
                            </div>
                            <div id="container-hukum" class="space-y-2"></div>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- SEKSI 3: HASIL PEMERIKSAAN (NARASI) -->
                <!-- ========================================== -->
                <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-blue-500"></div>
                    <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider mb-6 border-b border-slate-100 pb-3 flex items-center gap-2 mt-1">
                        <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        3. Narasi Hasil Pemeriksaan
                    </h3>

                    <div class="space-y-8">
                        <!-- KOTAK NARASI MEDIS -->
                        <div class="p-5 md:p-6 bg-blue-50/50 border border-blue-100 rounded-2xl shadow-sm">
                            <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 mb-4">
                                <label class="block text-[13px] font-extrabold text-blue-900 uppercase tracking-wider">Narasi Tim Medis</label>
                                <div class="flex items-center gap-3 bg-white p-2.5 rounded-xl border border-blue-100 shadow-sm flex-wrap">
                                    <span class="text-slate-500 font-bold text-[11px] uppercase tracking-wider">Gunakan Alamat:</span>
                                    <label class="flex items-center gap-1.5 cursor-pointer text-blue-800 font-bold text-xs">
                                        <input type="radio" name="alamat_medis" value="ktp" checked class="text-blue-600 focus:ring-blue-500"> KTP
                                    </label>
                                    <label class="flex items-center gap-1.5 cursor-pointer text-blue-800 font-bold text-xs">
                                        <input type="radio" name="alamat_medis" value="domisili" class="text-blue-600 focus:ring-blue-500"> Domisili
                                    </label>
                                    <label class="flex items-center gap-1.5 cursor-pointer text-blue-800 font-bold text-xs">
                                        <input type="radio" name="alamat_medis" value="keduanya" class="text-blue-600 focus:ring-blue-500"> Keduanya
                                    </label>
                                    <div class="w-px h-6 bg-blue-100 hidden sm:block mx-1"></div>
                                    <button type="button" onclick="applyDraftMedis()" class="px-4 py-1.5 bg-blue-600 text-white hover:bg-blue-700 rounded-lg text-[11px] font-bold uppercase tracking-wider transition shadow-sm">Terapkan Draf Pembuka</button>
                                </div>
                            </div>
                            <textarea id="narasi_medis" name="narasi_medis" rows="8" class="block w-full rounded-xl border-blue-200 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:text-sm transition-all leading-relaxed">{{ old('narasi_medis', $asesmen->narasi_medis) }}</textarea>
                        </div>

                        <!-- KOTAK NARASI HUKUM -->
                        <div class="p-5 md:p-6 bg-slate-50 border border-slate-200 rounded-2xl shadow-sm">
                            <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 mb-4">
                                <label class="block text-[13px] font-extrabold text-slate-800 uppercase tracking-wider">Narasi Tim Hukum</label>
                                <div class="flex flex-wrap items-center gap-3 bg-white p-2.5 rounded-xl border border-slate-200 shadow-sm">
                                    <div class="flex items-center gap-2 border-r border-slate-200 pr-3">
                                        <span class="text-slate-500 font-bold text-[11px] uppercase tracking-wider">Pekerjaan:</span>
                                        <input type="text" id="input_pekerjaan_hukum" value="{{ $asesmen->pekerjaan->nama_pekerjaan ?? '' }}" class="h-8 text-xs font-bold rounded-lg border-slate-300 w-32 focus:ring-2 focus:ring-slate-200">
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="text-slate-500 font-bold text-[11px] uppercase tracking-wider">Alamat:</span>
                                        <label class="flex items-center gap-1.5 cursor-pointer text-slate-800 font-bold text-xs">
                                            <input type="radio" name="alamat_hukum" value="ktp" checked class="text-slate-600 focus:ring-slate-500"> KTP
                                        </label>
                                        <label class="flex items-center gap-1.5 cursor-pointer text-slate-800 font-bold text-xs">
                                            <input type="radio" name="alamat_hukum" value="domisili" class="text-slate-600 focus:ring-slate-500"> Domisili
                                        </label>
                                        <label class="flex items-center gap-1.5 cursor-pointer text-slate-800 font-bold text-xs">
                                            <input type="radio" name="alamat_hukum" value="keduanya" class="text-slate-600 focus:ring-slate-500"> Keduanya
                                        </label>
                                    </div>
                                    <div class="w-px h-6 bg-slate-200 hidden sm:block mx-1"></div>
                                    <button type="button" onclick="applyDraftHukum()" class="px-4 py-1.5 bg-slate-700 text-white hover:bg-slate-800 rounded-lg text-[11px] font-bold uppercase tracking-wider transition shadow-sm">Terapkan Draf Pembuka</button>
                                </div>
                            </div>
                            <textarea id="narasi_hukum" name="narasi_hukum" rows="8" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-slate-500 focus:ring-2 focus:ring-slate-200 sm:text-sm transition-all leading-relaxed">{{ old('narasi_hukum', $asesmen->narasi_hukum) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- SEKSI 4: ALAT BUKTI & KESIMPULAN -->
                <!-- ========================================== -->
                <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-emerald-500"></div>
                    <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider mb-6 border-b border-slate-100 pb-3 flex items-center gap-2 mt-1">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        4. Alat Bukti & Kesimpulan
                    </h3>

                    <!-- Sub A: Alat Bukti -->
                    <div class="bg-slate-50 p-5 rounded-xl border border-slate-100 mb-8">
                        <h4 class="font-extrabold text-[12px] text-emerald-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <span class="bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded">A</span> Data Alat Bukti (Surat Keterangan Narkoba)
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">No. SK Narkoba</label>
                                <input type="text" name="alat_bukti_no_sk" value="{{ old('alat_bukti_no_sk', $asesmen->alat_bukti_no_sk ?? 'B/ND/336VII/KES.I./2026') }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 sm:text-sm transition-all">
                            </div>
                            <div>
                                <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Tanggal SK Narkoba</label>
                                <input type="date" name="alat_bukti_tgl_sk" value="{{ old('alat_bukti_tgl_sk', $asesmen->alat_bukti_tgl_sk) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 sm:text-sm transition-all">
                            </div>
                            <div>
                                <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Nama Dokter Pemeriksa</label>
                                <select id="select-dokter-pemeriksa" name="alat_bukti_dokter" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 sm:text-sm bg-white cursor-pointer transition-all">
                                    <option value="{{ $asesmen->alat_bukti_dokter ?? '' }}">{{ $asesmen->alat_bukti_dokter ?? '-- Pilih dari Tim Medis --' }}</option>
                                </select>
                                <p class="text-[10px] text-slate-500 mt-1">Otomatis ditarik dari Susunan Tim Medis di atas.</p>
                            </div>
                            <div class="row-span-2">
                                <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Hasil Zat Positif</label>
                                <div class="p-4 border border-slate-200 rounded-xl bg-white shadow-sm">
                                    <div id="container-zat" class="space-y-1.5 mb-4 max-h-40 overflow-y-auto pr-2">
                                        <!-- Render Checkbox Zat Positif JS -->
                                    </div>
                                    <div class="flex gap-2 pt-3 border-t border-slate-100">
                                        <button type="button" onclick="bukaModalOpsi('zat')" class="px-3 py-1.5 bg-emerald-50 text-emerald-700 text-[11px] font-bold uppercase tracking-wider rounded-lg hover:bg-emerald-100 transition shadow-sm">+ Tambah Zat</button>
                                        <button type="button" onclick="bukaKelolaOpsi('zat')" class="px-3 py-1.5 bg-slate-100 text-slate-600 text-[11px] font-bold uppercase tracking-wider rounded-lg hover:bg-slate-200 transition shadow-sm">Kelola</button>
                                    </div>
                                </div>
                                <input type="hidden" name="alat_bukti_hasil" id="alat_bukti_hasil_input" value="{{ old('alat_bukti_hasil', $asesmen->alat_bukti_hasil) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Sub B: Kesimpulan TAT -->
                    <div class="bg-indigo-50/40 p-5 rounded-xl border border-indigo-100/50 mb-8">
                        <h4 class="font-extrabold text-[12px] text-indigo-800 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <span class="bg-indigo-200 text-indigo-800 px-2 py-0.5 rounded">B</span> Kesimpulan Diagnostik TAT
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="md:col-span-2">
                                <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Jenis Zat yang Dipakai</label>
                                <textarea id="kesimpulan_jenis_zat_input" name="kesimpulan_jenis_zat" rows="2" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 sm:text-sm bg-slate-100 cursor-not-allowed text-slate-600 font-bold" readonly>{{ old('kesimpulan_jenis_zat', $asesmen->kesimpulan_jenis_zat) }}</textarea>
                                <p class="text-[10px] text-slate-500 mt-1">Otomatis terisi dari centangan Hasil Zat Positif di atas.</p>
                            </div>
                            <div>
                                <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Status Klien</label>
                                <select name="status_klien" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 sm:text-sm bg-white transition-all">
                                    <option value="penyalahguna" {{ old('status_klien', $asesmen->status_klien) == 'penyalahguna' ? 'selected' : '' }}>Penyalahguna</option>
                                    <option value="korban penyalahguna" {{ old('status_klien', $asesmen->status_klien) == 'korban penyalahguna' ? 'selected' : '' }}>Korban Penyalahguna</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Pola Pemakaian</label>
                                <select name="kesimpulan_pola_pakai" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 sm:text-sm bg-white transition-all">
                                    <option value="">-- Pilih Pola --</option>
                                    <option value="Coba pakai" {{ old('kesimpulan_pola_pakai', $asesmen->kesimpulan_pola_pakai) == 'Coba pakai' ? 'selected' : '' }}>Coba pakai</option>
                                    <option value="Situasional" {{ old('kesimpulan_pola_pakai', $asesmen->kesimpulan_pola_pakai) == 'Situasional' ? 'selected' : '' }}>Situasional</option>
                                    <option value="Rekreasional" {{ old('kesimpulan_pola_pakai', $asesmen->kesimpulan_pola_pakai) == 'Rekreasional' ? 'selected' : '' }}>Rekreasional</option>
                                    <option value="Teratur pakai" {{ old('kesimpulan_pola_pakai', $asesmen->kesimpulan_pola_pakai) == 'Teratur pakai' ? 'selected' : '' }}>Teratur pakai</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Kategori Ketergantungan</label>
                                <select name="kesimpulan_kategori" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 sm:text-sm bg-white transition-all">
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Ringan" {{ old('kesimpulan_kategori', $asesmen->kesimpulan_kategori) == 'Ringan' ? 'selected' : '' }}>Ringan</option>
                                    <option value="Sedang" {{ old('kesimpulan_kategori', $asesmen->kesimpulan_kategori) == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="Berat" {{ old('kesimpulan_kategori', $asesmen->kesimpulan_kategori) == 'Berat' ? 'selected' : '' }}>Berat</option>
                                </select>
                            </div>
                            <div class="md:col-span-2 pt-2">
                                <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Diagnosis Medis Final</label>
                                <div class="flex gap-2">
                                    <select id="select_diagnosis" name="diagnosis_medis" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 sm:text-sm bg-white font-bold text-indigo-700 transition-all">
                                        <option value="{{ $asesmen->diagnosis_medis ?? '' }}">{{ $asesmen->diagnosis_medis ?? '-- Pilih Diagnosis --' }}</option>
                                    </select>
                                    <button type="button" onclick="bukaModalOpsi('diagnosis')" class="px-4 py-2 bg-indigo-100 text-indigo-700 text-[11px] font-bold uppercase tracking-wider rounded-xl hover:bg-indigo-200 whitespace-nowrap transition shadow-sm">+ Tambah</button>
                                    <button type="button" onclick="bukaKelolaOpsi('diagnosis')" class="px-4 py-2 bg-slate-100 text-slate-600 text-[11px] font-bold uppercase tracking-wider rounded-xl hover:bg-slate-200 whitespace-nowrap transition shadow-sm">Kelola</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sub C: Rekomendasi -->
                    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 p-5 rounded-xl border border-emerald-100">
                        <h4 class="font-extrabold text-[12px] text-emerald-800 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <span class="bg-emerald-200 text-emerald-800 px-2 py-0.5 rounded">C</span> Keputusan Rekomendasi & Penempatan
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="md:col-span-2">
                                <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Tempat Rehabilitasi (Sesuai SK)</label>
                                <div class="flex gap-2">
                                    <select id="select_tempat_rehab" name="rekomendasi_tempat_rehab" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 sm:text-sm bg-white font-bold text-emerald-700 transition-all">
                                        <option value="{{ $asesmen->rekomendasi_tempat_rehab ?? '' }}">{{ $asesmen->rekomendasi_tempat_rehab ?? '-- Pilih Tempat Rehab --' }}</option>
                                        <!-- Options by JS -->
                                    </select>
                                    <button type="button" onclick="bukaModalOpsi('tempat_rehab')" class="px-4 py-2 bg-emerald-100 text-emerald-700 text-[11px] font-bold uppercase tracking-wider rounded-xl hover:bg-emerald-200 whitespace-nowrap transition shadow-sm">+ Tambah</button>
                                    <button type="button" onclick="bukaKelolaOpsi('tempat_rehab')" class="px-4 py-2 bg-slate-100 text-slate-600 text-[11px] font-bold uppercase tracking-wider rounded-xl hover:bg-slate-200 whitespace-nowrap transition shadow-sm">Kelola</button>
                                </div>
                            </div>

                            <!-- DURASI REHABILITASI -->
                            <div>
                                <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Lama (Durasi) Rawat</label>
                                <select id="select_durasi" onchange="handleDurasiChange(this)" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 sm:text-sm bg-white mb-2 transition-all">
                                    <option value="1 bulan">1 bulan</option>
                                    <option value="2 bulan">2 bulan</option>
                                    <option value="3 bulan" selected>3 bulan</option>
                                    <option value="1-3 bulan">1-3 bulan</option>
                                    <option value="lainnya">Lainnya (Masukkan manual)</option>
                                </select>
                                <input type="text" id="input_durasi_custom" placeholder="Ketik durasi manual..." class="hidden w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 sm:text-sm transition-all" onkeyup="document.getElementById('rekomendasi_durasi_hidden').value = this.value">
                                <input type="hidden" name="rekomendasi_durasi" id="rekomendasi_durasi_hidden" value="{{ old('rekomendasi_durasi', $asesmen->rekomendasi_durasi ?? '3 bulan') }}">
                            </div>

                            <!-- KETERANGAN HUKUM REKOMENDASI -->
                            <div class="md:col-span-2">
                                <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Keterangan Hukum Rekomendasi</label>
                                <select name="rekomendasi_keterangan" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 sm:text-sm bg-white h-auto py-3 leading-snug transition-all">
                                    @php
                                        $ketList = [
                                            "Hasil pemeriksaan urine positif narkotika, tanpa barang bukti narkotika dan tidak terdapat keterlibatan dalam jaringan peredaran gelap narkotika.",
                                            "Hasil pemeriksaan urine negatif narkotika, tanpa barang bukti narkotika dan tidak terdapat keterlibatan dalam jaringan peredaran gelap narkotika.",
                                            "Hasil pemeriksaan urine positif narkotika, dengan barang bukti narkotika dan tidak terdapat keterlibatan dalam jaringan peredaran gelap narkotika.",
                                            "Hasil pemeriksaan urine negatif narkotika, dengan barang bukti narkotika dan tidak terdapat keterlibatan dalam jaringan peredaran gelap narkotika.",
                                            "Hasil pemeriksaan urine positif narkotika, tanpa barang bukti narkotika, namun terdapat keterlibatan dalam jaringan peredaran gelap narkotika.",
                                            "Hasil pemeriksaan urine negatif narkotika, tanpa barang bukti narkotika, namun terdapat keterlibatan dalam jaringan peredaran gelap narkotika.",
                                            "Hasil pemeriksaan urine positif narkotika, dengan barang bukti narkotika dan terdapat keterlibatan dalam jaringan peredaran gelap narkotika.",
                                            "Hasil pemeriksaan urine negatif narkotika, dengan barang bukti narkotika dan terdapat keterlibatan dalam jaringan peredaran gelap narkotika."
                                        ];
                                        $savedKet = old('rekomendasi_keterangan', $asesmen->rekomendasi_keterangan);
                                    @endphp
                                    <option value="">-- Pilih Keterangan Hukum --</option>
                                    @foreach($ketList as $ket)
                                        <option value="{{ $ket }}" {{ $savedKet == $ket ? 'selected' : '' }}>{{ $ket }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- TOMBOL SUBMIT -->
                <!-- ========================================== -->
                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 pb-10">
                    <a href="{{ route('asesmen.show', $asesmen->id) }}" class="inline-flex justify-center items-center px-6 py-3 bg-white border border-slate-300 rounded-xl text-slate-700 font-bold hover:bg-slate-50 transition-all shadow-sm focus:ring-2 focus:ring-slate-200">
                        Batal
                    </a>

                    <!-- Tombol 1: Simpan Saja -->
                    <button type="submit" name="action" value="save_only" onclick="syncHiddenInputs()" class="inline-flex justify-center items-center px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 hover:-translate-y-0.5 transition-all shadow-lg shadow-blue-200 focus:ring-4 focus:ring-blue-100">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                        Simpan Perubahan
                    </button>

                    <!-- Tombol 2: Simpan & Unduh -->
                    <button type="submit" name="action" value="generate" onclick="syncHiddenInputs()" class="inline-flex justify-center items-center px-6 py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 hover:-translate-y-0.5 transition-all shadow-lg shadow-emerald-200 focus:ring-4 focus:ring-emerald-100">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Simpan & Unduh Berita Acara
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MODALS (ANGGOTA TAT & OPSI) -->
    <!-- ========================================== -->

    <!-- MODAL ANGGOTA TAT (MEDIS/HUKUM) -->
    <div id="modalTambahAnggota" class="fixed inset-0 z-[60] hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 sm:p-8">
            <div class="flex justify-between items-center border-b border-slate-100 pb-4 mb-5">
                <h3 class="text-lg font-extrabold text-slate-900" id="modalTitle">Tambah Anggota Baru</h3>
                <button type="button" onclick="tutupModal()" class="text-slate-400 hover:text-rose-500 transition-colors p-1">&times;</button>
            </div>
            <form id="formTambahAnggota" class="space-y-4">
                <input type="hidden" id="modalKategori" name="kategori">
                <div><label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap & Gelar</label><input type="text" id="modalNama" required class="block w-full rounded-xl border-slate-300 focus:ring-2 focus:ring-indigo-100 sm:text-sm"></div>
                <div><label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">NIP / NRP / SIP</label><input type="text" id="modalNip" class="block w-full rounded-xl border-slate-300 focus:ring-2 focus:ring-indigo-100 sm:text-sm"></div>
                <div id="wrapPangkat"><label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Pangkat (Opsional)</label><input type="text" id="modalPangkat" class="block w-full rounded-xl border-slate-300 focus:ring-2 focus:ring-indigo-100 sm:text-sm"></div>
                <div><label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Jabatan</label><input type="text" id="modalJabatan" class="block w-full rounded-xl border-slate-300 focus:ring-2 focus:ring-indigo-100 sm:text-sm"></div>
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 mt-2">
                    <button type="button" onclick="tutupModal()" class="px-5 py-2 bg-slate-100 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-200 transition">Batal</button>
                    <button type="button" onclick="simpanAnggotaBaru()" id="btnSimpanAnggota" class="px-5 py-2 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 shadow-md transition">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalKelolaAnggota" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 sm:p-8 flex flex-col max-h-[85vh]">
            <div class="flex justify-between items-center border-b border-slate-100 pb-4 mb-4">
                <h3 class="text-lg font-extrabold text-slate-900" id="kelolaTitle">Kelola Anggota</h3>
                <button type="button" onclick="tutupKelola()" class="text-slate-400 hover:text-rose-500 p-1 transition-colors">&times;</button>
            </div>
            <div class="overflow-y-auto flex-1 pr-2 space-y-2" id="kelolaList"></div>
            <div class="mt-5 pt-4 border-t border-slate-100 text-right">
                <button type="button" onclick="tutupKelola()" class="px-6 py-2 bg-slate-100 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-200 transition">Tutup Kelola</button>
            </div>
        </div>
    </div>

    <!-- MODAL OPSI (ZAT & TEMPAT REHAB) -->
    <div id="modalTambahOpsi" class="fixed inset-0 z-[70] hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 sm:p-8">
            <h3 class="text-lg font-extrabold text-slate-900 mb-5 border-b border-slate-100 pb-3" id="modalOpsiTitle">Tambah Data Baru</h3>
            <input type="hidden" id="modalOpsiKategori">
            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Nama/Nilai Baru</label>
            <input type="text" id="modalOpsiNilai" placeholder="Ketik di sini..." class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 mb-6">
            <div class="flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('modalTambahOpsi').classList.add('hidden')" class="px-5 py-2 bg-slate-100 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-200 transition">Batal</button>
                <button type="button" onclick="simpanOpsiBaru()" id="btnSimpanOpsi" class="px-5 py-2 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 shadow-md transition">Simpan</button>
            </div>
        </div>
    </div>

    <div id="modalKelolaOpsi" class="fixed inset-0 z-[65] hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 sm:p-8 flex flex-col max-h-[80vh]">
            <div class="flex justify-between items-center border-b border-slate-100 pb-4 mb-4">
                <h3 class="text-lg font-extrabold text-slate-900" id="kelolaOpsiTitle">Kelola Opsi</h3>
                <button type="button" onclick="document.getElementById('modalKelolaOpsi').classList.add('hidden')" class="text-slate-400 hover:text-rose-500 p-1 transition-colors">&times;</button>
            </div>
            <div class="overflow-y-auto flex-1 space-y-2" id="kelolaOpsiList"></div>
            <div class="mt-5 pt-4 border-t border-slate-100 text-right">
                <button type="button" onclick="document.getElementById('modalKelolaOpsi').classList.add('hidden')" class="px-6 py-2 bg-slate-100 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-200 transition">Tutup Kelola</button>
            </div>
        </div>
    </div>


    <!-- ========================================== -->
    <!-- JAVASCRIPT LOGIC (Fungsionalitas 100% Utuh) -->
    <!-- ========================================== -->
    <script>
        // === 1. FITUR DRAF OTOMATIS NARASI ===
        let klien = @json($klienData);
        let hasSavedMedis = "{{ $asesmen->narasi_medis ? 'yes' : 'no' }}";
        let hasSavedHukum = "{{ $asesmen->narasi_hukum ? 'yes' : 'no' }}";

        function getDraftMedis() {
            let alamatType = document.querySelector('input[name="alamat_medis"]:checked').value;
            let alamatTeks = "";

            if (alamatType === 'ktp') {
                alamatTeks = klien.alamat_ktp;
            } else if (alamatType === 'domisili') {
                alamatTeks = klien.alamat_domisili;
            } else {
                alamatTeks = `Sesuai KTP di ${klien.alamat_ktp} dan Domisili saat ini di ${klien.alamat_domisili}`;
            }

            return `Bahwa klien bernama ${klien.nama} Usia ${klien.usia} (Lahir di ${klien.tempat_lahir}, ${klien.tgl_lahir}). Pendidikan Terakhir ${klien.pendidikan}. Alamat Tempat Tinggal ${alamatTeks}.\n\n(Lanjutkan mengetik kronologi medis klien di sini...)`;
        }
        function getDraftHukum() {
            let alamatType = document.querySelector('input[name="alamat_hukum"]:checked').value;
            let alamatTeks = "";

            if (alamatType === 'ktp') {
                alamatTeks = klien.alamat_ktp;
            } else if (alamatType === 'domisili') {
                alamatTeks = klien.alamat_domisili;
            } else {
                alamatTeks = `Sesuai KTP di ${klien.alamat_ktp} dan Domisili saat ini di ${klien.alamat_domisili}`;
            }

            let pekerjaan = document.getElementById('input_pekerjaan_hukum').value || '-';

            return `Bahwa Tersangka bernama lengkap ${klien.nama}, NIK ${klien.nik}, Tempat/Tanggal Lahir ${klien.tempat_lahir}, ${klien.tgl_lahir}, Jenis Kelamin ${klien.jk}, Agama ${klien.agama}, Pekerjaan ${pekerjaan}, Pendidikan Terakhir ${klien.pendidikan}, Alamat Tempat Tinggal ${alamatTeks}.\n\nTersangka diamankan oleh petugas pada... (Lanjutkan mengetik kronologi penangkapan di sini...)`;
        }
        function applyDraftMedis() {
            let box = document.getElementById('narasi_medis');
            if(box.value.trim() !== '' && !box.value.includes('Lanjutkan mengetik')) if(!confirm("Draf akan menimpa teks Anda. Lanjutkan?")) return;
            box.value = getDraftMedis();
        }
        function applyDraftHukum() {
            let box = document.getElementById('narasi_hukum');
            if(box.value.trim() !== '' && !box.value.includes('Lanjutkan mengetik')) if(!confirm("Draf akan menimpa teks Anda. Lanjutkan?")) return;
            box.value = getDraftHukum();
        }
        document.addEventListener("DOMContentLoaded", function() {
            if(hasSavedMedis === 'no' && document.getElementById('narasi_medis').value.trim() === '') document.getElementById('narasi_medis').value = getDraftMedis();
            if(hasSavedHukum === 'no' && document.getElementById('narasi_hukum').value.trim() === '') document.getElementById('narasi_hukum').value = getDraftHukum();
            initDurasi();
        });

        // === 2. FITUR DURASI KUSTOM ===
        function initDurasi() {
            let val = document.getElementById('rekomendasi_durasi_hidden').value;
            let sel = document.getElementById('select_durasi');
            let inp = document.getElementById('input_durasi_custom');

            let options = Array.from(sel.options).map(o => o.value);
            if(options.includes(val)) {
                sel.value = val;
                inp.classList.add('hidden');
            } else {
                sel.value = 'lainnya';
                inp.value = val;
                inp.classList.remove('hidden');
            }
        }
        function handleDurasiChange(sel) {
            let inp = document.getElementById('input_durasi_custom');
            let hidden = document.getElementById('rekomendasi_durasi_hidden');
            if(sel.value === 'lainnya') {
                inp.classList.remove('hidden');
                hidden.value = inp.value;
            } else {
                inp.classList.add('hidden');
                hidden.value = sel.value;
            }
        }

        // === 3. FITUR ZAT & TEMPAT REHAB DINAMIS ===
        let masterZat = @json($masterZat);
        let masterTempatRehab = @json($masterTempatRehab);
        let masterDiagnosis = @json($masterDiagnosis);
        let prevZatString = "{{ old('alat_bukti_hasil', $asesmen->alat_bukti_hasil) }}";

        function renderOpsiData() {
            // Render Zat Checkbox
            let contZat = document.getElementById('container-zat');
            contZat.innerHTML = '';
            let currentStr = document.getElementById('alat_bukti_hasil_input').value;
            masterZat.forEach(z => {
                let isChecked = currentStr.includes(z.nilai) ? 'checked' : '';
                contZat.innerHTML += `
                    <label class="flex items-center gap-2 cursor-pointer mb-1.5 text-[13px] font-bold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 p-1.5 rounded-lg transition-colors border border-transparent hover:border-emerald-100">
                        <input type="checkbox" value="${z.nilai}" ${isChecked} onchange="updateZatTerpilih()" class="rounded text-emerald-600 focus:ring-emerald-500 w-4 h-4 shadow-sm border-slate-300">
                        ${z.nilai}
                    </label>
                `;
            });

            // Render Tempat Rehab
            let selTempat = document.getElementById('select_tempat_rehab');
            let currentTempat = selTempat.value;
            selTempat.innerHTML = `<option value="${currentTempat}">${currentTempat || '-- Pilih Tempat Rehab --'}</option>`;
            masterTempatRehab.forEach(t => {
                if(t.nilai !== currentTempat) selTempat.innerHTML += `<option value="${t.nilai}">${t.nilai}</option>`;
            });

            // Render Diagnosis
            let selDiag = document.getElementById('select_diagnosis');
            let currentDiag = selDiag.value;
            selDiag.innerHTML = `<option value="${currentDiag}">${currentDiag || '-- Pilih Diagnosis --'}</option>`;
            masterDiagnosis.forEach(d => {
                if(d.nilai !== currentDiag) selDiag.innerHTML += `<option value="${d.nilai}">${d.nilai}</option>`;
            });
        }

        function updateZatTerpilih() {
            let checkboxes = document.querySelectorAll('#container-zat input[type="checkbox"]:checked');
            let vals = Array.from(checkboxes).map(cb => cb.value);
            let teksHasil = vals.length > 0 ? "POSITIF " + vals.join(' DAN ') : "";
            document.getElementById('alat_bukti_hasil_input').value = teksHasil;
            document.getElementById('kesimpulan_jenis_zat_input').value = vals.join(', ');
        }

        function bukaModalOpsi(kategori) {
            document.getElementById('modalOpsiKategori').value = kategori;

            let title = 'Tambah Data Baru';
            if(kategori === 'zat') title = 'Tambah Zat Baru';
            else if(kategori === 'tempat_rehab') title = 'Tambah Tempat Rehabilitasi';
            else if(kategori === 'diagnosis') title = 'Tambah Diagnosis Baru';

            document.getElementById('modalOpsiTitle').innerText = title;
            document.getElementById('modalOpsiNilai').value = '';
            document.getElementById('modalTambahOpsi').classList.remove('hidden');
        }

        function simpanOpsiBaru() {
            let btn = document.getElementById('btnSimpanOpsi');
            let data = {
                kategori: document.getElementById('modalOpsiKategori').value,
                nilai: document.getElementById('modalOpsiNilai').value,
                _token: '{{ csrf_token() }}'
            };
            if(!data.nilai) return alert('Data tidak boleh kosong!');

            btn.innerText = 'Tunggu...';
            fetch('{{ route("master-opsi.storeAjax") }}', {
                method: 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' }, body: JSON.stringify(data)
            }).then(r => r.json()).then(res => {
                if(res.success) {
                    if(data.kategori === 'zat') masterZat.push(res.data);
                    else if(data.kategori === 'tempat_rehab') masterTempatRehab.push(res.data);
                    else masterDiagnosis.push(res.data);

                    renderOpsiData();
                    document.getElementById('modalTambahOpsi').classList.add('hidden');
                }
            }).finally(() => btn.innerText = 'Simpan');
        }

        function bukaKelolaOpsi(kategori) {
            let title = 'Kelola Opsi';
            if(kategori === 'zat') title = 'Kelola Daftar Zat';
            else if(kategori === 'tempat_rehab') title = 'Kelola Tempat Rehabilitasi';
            else if(kategori === 'diagnosis') title = 'Kelola Daftar Diagnosis';

            document.getElementById('kelolaOpsiTitle').innerText = title;
            renderKelolaOpsiList(kategori);
            document.getElementById('modalKelolaOpsi').classList.remove('hidden');
        }

        function renderKelolaOpsiList(kategori) {
            let container = document.getElementById('kelolaOpsiList');
            container.innerHTML = '';
            let data = kategori === 'zat' ? masterZat : (kategori === 'tempat_rehab' ? masterTempatRehab : masterDiagnosis);

            data.forEach(item => {
                container.innerHTML += `
                    <div class="flex justify-between items-center p-3 border border-slate-100 rounded-xl mb-2 hover:bg-slate-50 transition-colors shadow-sm">
                        <span class="text-sm font-bold text-slate-700">${item.nilai}</span>
                        <button type="button" onclick="hapusOpsiPermanen(${item.id}, '${kategori}')" class="text-rose-500 hover:text-rose-700 hover:bg-rose-50 text-[11px] font-bold px-3 py-1 rounded-lg transition-colors border border-rose-100">Hapus</button>
                    </div>
                `;
            });
        }

        function hapusOpsiPermanen(id, kategori) {
            if(!confirm('Hapus permanen dari database?')) return;
            fetch(`/master-opsi/ajax/${id}`, {
                method: 'DELETE', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            }).then(r => r.json()).then(res => {
                if(res.success) {
                    if(kategori === 'zat') masterZat = masterZat.filter(x => x.id !== id);
                    else if(kategori === 'tempat_rehab') masterTempatRehab = masterTempatRehab.filter(x => x.id !== id);
                    else masterDiagnosis = masterDiagnosis.filter(x => x.id !== id);

                    renderOpsiData();
                    renderKelolaOpsiList(kategori);
                }
            });
        }
        renderOpsiData();


        // === 4. FITUR TIM MEDIS & HUKUM ===
        let masterMedis = @json($masterMedis);
        let masterHukum = @json($masterHukum);
        let selectedMedis = @json($asesmen->anggotaTim->where('kategori', 'medis')->pluck('id')->toArray());
        let selectedHukum = @json($asesmen->anggotaTim->where('kategori', 'hukum')->pluck('id')->toArray());

        function renderMedis() {
            const container = document.getElementById('container-medis');
            const select = document.getElementById('select-medis');
            const selectDokter = document.getElementById('select-dokter-pemeriksa');

            container.innerHTML = ''; select.innerHTML = '<option value="">-- Pilih Dokter TAT --</option>';
            let currentDokterVal = selectDokter.value || "{{ old('alat_bukti_dokter', $asesmen->alat_bukti_dokter) }}";
            selectDokter.innerHTML = `<option value="${currentDokterVal}">${currentDokterVal || '-- Otomatis dari Tim Medis --'}</option>`;

            selectedMedis.forEach(id => {
                let p = masterMedis.find(x => x.id == id);
                if(p) {
                    container.innerHTML += `
                        <div class="relative p-3 bg-white border border-indigo-100 rounded-xl shadow-sm mb-2 group">
                            <button type="button" onclick="hapusMedis(${p.id})" class="absolute top-3 right-3 text-rose-500 font-bold bg-rose-50 border border-rose-100 rounded-lg px-2 py-1 text-[10px] hover:bg-rose-500 hover:text-white transition-colors opacity-0 group-hover:opacity-100">HAPUS</button>
                            <p class="font-extrabold text-sm text-indigo-900 pr-12">${p.nama}</p>
                            <p class="text-[11px] font-bold text-indigo-500 mt-1 uppercase tracking-wider">NIP/SIP: <span class="text-slate-600 normal-case">${p.nip_nrp_sip || '-'}</span></p>
                            <p class="text-[11px] font-bold text-indigo-500 uppercase tracking-wider">Jabatan: <span class="text-slate-600 normal-case">${p.jabatan || '-'}</span></p>
                        </div>
                    `;
                    // Sinkronisasi ke dropdown Dokter Pemeriksa
                    if(p.nama !== currentDokterVal) {
                        selectDokter.innerHTML += `<option value="${p.nama}">${p.nama}</option>`;
                    }
                }
            });

            masterMedis.forEach(p => {
                if(!selectedMedis.includes(p.id)) select.innerHTML += `<option value="${p.id}">${p.nama}</option>`;
            });
            syncHiddenInputs();
        }

        function renderHukum() {
            const container = document.getElementById('container-hukum');
            const select = document.getElementById('select-hukum');
            container.innerHTML = ''; select.innerHTML = '<option value="">-- Pilih Penyidik/Jaksa --</option>';

            selectedHukum.forEach(id => {
                let p = masterHukum.find(x => x.id == id);
                if(p) {
                    container.innerHTML += `
                        <div class="relative p-3 bg-white border border-indigo-100 rounded-xl shadow-sm mb-2 group">
                            <button type="button" onclick="hapusHukum(${p.id})" class="absolute top-3 right-3 text-rose-500 font-bold bg-rose-50 border border-rose-100 rounded-lg px-2 py-1 text-[10px] hover:bg-rose-500 hover:text-white transition-colors opacity-0 group-hover:opacity-100">HAPUS</button>
                            <p class="font-extrabold text-sm text-slate-800 pr-12">${p.nama}</p>
                            ${p.pangkat ? `<p class="text-[11px] font-bold text-indigo-500 mt-1 uppercase tracking-wider">Pangkat: <span class="text-slate-600 normal-case">${p.pangkat}</span></p>` : ''}
                            <p class="text-[11px] font-bold text-indigo-500 ${p.pangkat ? '' : 'mt-1'} uppercase tracking-wider">NIP/NRP: <span class="text-slate-600 normal-case">${p.nip_nrp_sip || '-'}</span></p>
                            <p class="text-[11px] font-bold text-indigo-500 uppercase tracking-wider">Jabatan: <span class="text-slate-600 normal-case">${p.jabatan || '-'}</span></p>
                        </div>
                    `;
                }
            });
            masterHukum.forEach(p => {
                if(!selectedHukum.includes(p.id)) select.innerHTML += `<option value="${p.id}">${p.nama}</option>`;
            });
            syncHiddenInputs();
        }

        function syncHiddenInputs() {
            const container = document.getElementById('hidden-inputs-container');
            container.innerHTML = '';
            selectedMedis.forEach(id => container.innerHTML += `<input type="hidden" name="tim_medis[]" value="${id}">`);
            selectedHukum.forEach(id => container.innerHTML += `<input type="hidden" name="tim_hukum[]" value="${id}">`);
        }

        document.getElementById('select-medis').addEventListener('change', function() {
            if(this.value && selectedMedis.length < 2) { selectedMedis.push(parseInt(this.value)); renderMedis(); }
            else if (selectedMedis.length >= 2) { alert('Maks. 2 Dokter untuk Tim Medis.'); this.value = ''; }
        });

        document.getElementById('select-hukum').addEventListener('change', function() {
            if(this.value && selectedHukum.length < 3) { selectedHukum.push(parseInt(this.value)); renderHukum(); }
            else if (selectedHukum.length >= 3) { alert('Maks. 3 Penyidik/Jaksa untuk Tim Hukum.'); this.value = ''; }
        });

        function hapusMedis(id) { selectedMedis = selectedMedis.filter(x => x !== id); renderMedis(); }
        function hapusHukum(id) { selectedHukum = selectedHukum.filter(x => x !== id); renderHukum(); }

        function bukaModal(k) {
            document.getElementById('modalKategori').value = k;
            document.getElementById('modalTitle').innerText = k === 'medis' ? 'Tambah Dokter' : 'Tambah Tim Hukum';
            document.getElementById('wrapPangkat').style.display = k === 'medis' ? 'none' : 'block';
            document.getElementById('modalTambahAnggota').classList.remove('hidden');
        }
        function tutupModal() {
            document.getElementById('formTambahAnggota').reset();
            document.getElementById('modalTambahAnggota').classList.add('hidden');
        }
        function simpanAnggotaBaru() {
            let data = {
                nama: document.getElementById('modalNama').value, nip_nrp_sip: document.getElementById('modalNip').value,
                pangkat: document.getElementById('modalPangkat').value, jabatan: document.getElementById('modalJabatan').value,
                kategori: document.getElementById('modalKategori').value, _token: '{{ csrf_token() }}'
            };
            fetch('{{ route("master-anggota.storeAjax") }}', {
                method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data)
            }).then(r => r.json()).then(res => {
                if(data.kategori === 'medis') { masterMedis.push(res.data); if(selectedMedis.length < 2) selectedMedis.push(res.data.id); renderMedis(); }
                else { masterHukum.push(res.data); if(selectedHukum.length < 3) selectedHukum.push(res.data.id); renderHukum(); }
                tutupModal();
            });
        }

        function bukaKelola(kategori) {
            document.getElementById('kelolaTitle').innerText = kategori === 'medis' ? 'Kelola Tim Medis' : 'Kelola Tim Hukum';
            renderKelolaList(kategori);
            document.getElementById('modalKelolaAnggota').classList.remove('hidden');
        }
        function tutupKelola() { document.getElementById('modalKelolaAnggota').classList.add('hidden'); }

        function renderKelolaList(kategori) {
            let container = document.getElementById('kelolaList'); container.innerHTML = '';
            let data = kategori === 'medis' ? masterMedis : masterHukum;
            data.forEach(p => {
                container.innerHTML += `
                    <div class="flex justify-between items-center p-3 border border-slate-100 rounded-xl mb-2 hover:bg-slate-50 shadow-sm transition-colors">
                        <div>
                            <p class="font-extrabold text-sm text-slate-800">${p.nama}</p>
                            <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mt-0.5">${p.nip_nrp_sip || '-'} <span class="text-slate-300 mx-1">|</span> ${p.jabatan || '-'}</p>
                        </div>
                        <button type="button" onclick="hapusPermanen(${p.id}, '${kategori}')" class="text-rose-500 bg-rose-50 hover:bg-rose-100 border border-rose-100 px-3 py-1.5 rounded-lg font-bold text-[11px] transition-colors">Hapus</button>
                    </div>`;
            });
        }
        function hapusPermanen(id, kategori) {
            if(!confirm('Yakin ingin menghapus anggota ini secara permanen dari sistem?')) return;
            fetch(`/master-anggota/ajax/${id}`, { method: 'DELETE', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }})
            .then(r => r.json()).then(res => {
                if(kategori === 'medis') { masterMedis = masterMedis.filter(x => x.id !== id); selectedMedis = selectedMedis.filter(x => x !== id); renderMedis(); }
                else { masterHukum = masterHukum.filter(x => x.id !== id); selectedHukum = selectedHukum.filter(x => x !== id); renderHukum(); }
                renderKelolaList(kategori);
            });
        }

        renderMedis(); renderHukum();
    </script>
</x-app-layout>
