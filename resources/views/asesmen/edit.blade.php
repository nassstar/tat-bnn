<x-app-layout>
    <div class="py-8 sm:py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- ========================================== -->
            <!-- 1. HEADER (SEAMLESS HERO) -->
            <!-- ========================================== -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('asesmen.index') }}" class="p-2.5 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-blue-600 transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <div>
                        <div class="inline-flex items-center gap-2 px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-700 uppercase tracking-wider mb-1">
                            Mode Edit Data
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">Edit Klien: {{ $asesmen->nama_lengkap }}</h1>
                    </div>
                </div>
                <div class="text-sm text-slate-500 bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm hidden md:block">
                    Perbarui data dengan teliti. Tanda <span class="text-rose-500 font-bold">*</span> wajib diisi.
                </div>
            </div>

            <form action="{{ route('asesmen.update', $asesmen->id) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- ========================================== -->
                <!-- SEKSI 1: ADMINISTRASI SURAT & REGISTRASI -->
                <!-- ========================================== -->
                <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-indigo-500"></div>
                    <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider mb-6 border-b border-slate-100 pb-3 flex items-center gap-2 mt-1">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        1. Administrasi Surat & Registrasi
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">No. Register</label>
                            <input type="text" name="no_register" value="{{ old('no_register', $asesmen->no_register) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">No / BLN</label>
                            <input type="text" name="no_bln" value="{{ old('no_bln', $asesmen->no_bln) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Asal Pengajuan</label>
                            <input type="text" name="asal_pengajuan" value="{{ old('asal_pengajuan', $asesmen->asal_pengajuan) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">No. Surat Pengajuan</label>
                            <input type="text" name="no_surat_pengajuan" value="{{ old('no_surat_pengajuan', $asesmen->no_surat_pengajuan) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">No. LKN / LP / LI</label>
                            <input type="text" name="no_lkn" value="{{ old('no_lkn', $asesmen->no_lkn) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Tanggal Surat</label>
                            <input type="text" name="tgl_surat" value="{{ old('tgl_surat', $asesmen->tgl_surat) }}" class="datepicker-id block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 sm:text-sm transition-all bg-slate-50 focus:bg-white" placeholder="Pilih Tanggal">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Tanggal Berkas Diterima</label>
                            <input type="text" name="tgl_berkas" value="{{ old('tgl_berkas', $asesmen->tgl_berkas) }}" class="datepicker-id block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 sm:text-sm transition-all bg-slate-50 focus:bg-white" placeholder="Pilih Tanggal">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Tanggal Pelaksanaan</label>
                            <input type="text" name="tgl_pelaksanaan" value="{{ old('tgl_pelaksanaan', $asesmen->tgl_pelaksanaan) }}" class="datepicker-id block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 sm:text-sm transition-all bg-slate-50 focus:bg-white" placeholder="Pilih Tanggal">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Tanggal Penangkapan</label>
                            <input type="text" name="tgl_tangkap" value="{{ old('tgl_tangkap', $asesmen->tgl_tangkap) }}" class="datepicker-id block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 sm:text-sm transition-all bg-slate-50 focus:bg-white" placeholder="Pilih Tanggal">
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- SEKSI 2: IDENTITAS KLIEN -->
                <!-- ========================================== -->
                <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-blue-500"></div>
                    <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider mb-6 border-b border-slate-100 pb-3 flex items-center gap-2 mt-1">
                        <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        2. Identitas Profil Klien
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $asesmen->nama_lengkap) }}" required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">NIK KTP <span class="text-rose-500">*</span></label>
                            <input type="text" name="nik" value="{{ old('nik', $asesmen->nik) }}" required maxlength="16" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">No. Handphone</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $asesmen->no_hp) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $asesmen->tempat_lahir) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Tanggal Lahir</label>
                            <input type="text" name="tgl_lahir" value="{{ old('tgl_lahir', $asesmen->tgl_lahir) }}" class="datepicker-id block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:text-sm transition-all bg-slate-50 focus:bg-white" placeholder="Pilih Tanggal">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                            <select name="jenis_kelamin" required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                                <option value="L" {{ old('jenis_kelamin', $asesmen->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-Laki (L)</option>
                                <option value="P" {{ old('jenis_kelamin', $asesmen->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Kewarganegaraan</label>
                            <input type="text" name="kewarganegaraan" value="{{ old('kewarganegaraan', $asesmen->kewarganegaraan) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Agama</label>
                            <select name="agama" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                                <option value="">-- Pilih Agama --</option>
                                <option value="Islam" {{ old('agama', $asesmen->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen Protestan" {{ old('agama', $asesmen->agama) == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                                <option value="Katolik" {{ old('agama', $asesmen->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama', $asesmen->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama', $asesmen->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('agama', $asesmen->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Pendidikan</label>
                            <input type="text" name="pendidikan_input" value="{{ old('pendidikan_input', $asesmen->pendidikan->nama_pendidikan ?? '') }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Pekerjaan</label>
                            <input type="text" name="pekerjaan_input" value="{{ old('pekerjaan_input', $asesmen->pekerjaan->nama_pekerjaan ?? '') }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Penghasilan Rata-Rata</label>
                            <input type="text" name="penghasilan_rata_rata" id="penghasilan_rupiah" value="{{ old('penghasilan_rata_rata', $asesmen->penghasilan_rata_rata) }}" placeholder="Misal: Rp 3.000.000" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5 border-t border-slate-100 pt-5">
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Alamat KTP</label>
                            <textarea name="alamat_ktp" rows="3" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">{{ old('alamat_ktp', $asesmen->alamat_ktp) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Alamat Domisili Saat Ini</label>
                            <textarea name="alamat_domisili" rows="3" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">{{ old('alamat_domisili', $asesmen->alamat_domisili) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- SEKSI 3: PERKARA HUKUM & BARANG BUKTI -->
                <!-- ========================================== -->
                <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-amber-400"></div>
                    <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider mb-6 border-b border-slate-100 pb-3 flex items-center gap-2 mt-1">
                        <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                        3. Perkara Hukum & Barang Bukti
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Jenis Narkotika</label>
                            <select name="narkotika_id" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                                <option value="">-- Pilih Zat/Narkotika --</option>
                                @foreach($masterNarkotika as $n)
                                    <option value="{{ $n->id }}" {{ old('narkotika_id', $asesmen->narkotika_id) == $n->id ? 'selected' : '' }}>{{ $n->jenis_narkotika }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Berat Barang Bukti (Gr)</label>
                            <input type="number" step="0.01" name="berat_bb" value="{{ old('berat_bb', $asesmen->berat_bb) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Status Hukum</label>
                            <input type="text" name="status_hukum" value="{{ old('status_hukum', $asesmen->status_hukum) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div class="md:col-span-2 lg:col-span-3">
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Deskripsi Barang Bukti</label>
                            <textarea name="deskripsi_bb" rows="2" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">{{ old('deskripsi_bb', $asesmen->deskripsi_bb) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Pasal Sangkaan</label>
                            <input type="text" name="pasal_sangkaan" value="{{ old('pasal_sangkaan', $asesmen->pasal_sangkaan) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Keterlibatan Jaringan</label>
                            <input type="text" name="keterlibatan_jaringan" value="{{ old('keterlibatan_jaringan', $asesmen->keterlibatan_jaringan) }}" placeholder="Ya / Tidak" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Hasil Tes Urine</label>
                            <input type="text" name="tes_urine" value="{{ old('tes_urine', $asesmen->tes_urine) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Cara Mendapatkan</label>
                            <input type="text" name="cara_mendapatkan" value="{{ old('cara_mendapatkan', $asesmen->cara_mendapatkan) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div class="md:col-span-2 text-sm">
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Dapat Dari Siapa</label>
                            <input type="text" name="dapat_dari_siapa" value="{{ old('dapat_dari_siapa', $asesmen->dapat_dari_siapa) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- SEKSI 4: HASIL TAT AWAL -->
                <!-- ========================================== -->
                <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-slate-400"></div>
                    <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider mb-6 border-b border-slate-100 pb-3 flex items-center gap-2 mt-1">
                        <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        4. Hasil Asesmen Awal (Rekap Mentah TAT)
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Hasil Asesmen Hukum</label>
                            <textarea name="hasil_asesmen_hukum" rows="4" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-slate-500 focus:ring-2 focus:ring-slate-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">{{ old('hasil_asesmen_hukum', $asesmen->hasil_asesmen_hukum) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Hasil Asesmen Medis</label>
                            <textarea name="hasil_asesmen_medis" rows="4" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-slate-500 focus:ring-2 focus:ring-slate-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">{{ old('hasil_asesmen_medis', $asesmen->hasil_asesmen_medis) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Rekomendasi TAT</label>
                            <input type="text" name="rekomendasi_input" value="{{ old('rekomendasi_input', $asesmen->rekomendasi->tempat_rehabilitasi ?? '') }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-slate-500 focus:ring-2 focus:ring-slate-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Status Pelaksanaan Rekomendasi</label>
                            <select name="pelaksanaan" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-slate-500 focus:ring-2 focus:ring-slate-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                                <option value="TIDAK" {{ old('pelaksanaan', $asesmen->pelaksanaan) == 'TIDAK' ? 'selected' : '' }}>Belum Dilaksanakan (TIDAK)</option>
                                <option value="YA" {{ old('pelaksanaan', $asesmen->pelaksanaan) == 'YA' ? 'selected' : '' }}>Sudah Dilaksanakan (YA)</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Keterangan Tambahan TAT</label>
                            <input type="text" name="keterangan_tambahan" value="{{ old('keterangan_tambahan', $asesmen->keterangan_tambahan) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-slate-500 focus:ring-2 focus:ring-slate-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- SEKSI 5: ANALISIS CASE CONFERENCE -->
                <!-- ========================================== -->
                <div class="bg-gradient-to-br from-indigo-50/50 to-purple-50/50 p-6 md:p-8 rounded-2xl border border-indigo-100 shadow-sm relative overflow-hidden">
                    <h3 class="text-sm font-extrabold text-indigo-900 uppercase tracking-wider mb-4 flex items-center gap-2 border-b border-indigo-200/60 pb-3">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        5. Hasil Sidang Case Conference
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[12px] font-bold text-indigo-900 uppercase tracking-wide mb-1">Analisis Aspek Hukum</label>
                            <textarea name="aspek_hukum" rows="3" class="block w-full rounded-xl border-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm transition-all bg-white/80 focus:bg-white">{{ old('aspek_hukum', $asesmen->aspek_hukum) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-indigo-900 uppercase tracking-wide mb-1">Analisis Aspek Medis</label>
                            <textarea name="aspek_medis" rows="3" class="block w-full rounded-xl border-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm transition-all bg-white/80 focus:bg-white">{{ old('aspek_medis', $asesmen->aspek_medis) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-indigo-900 uppercase tracking-wide mb-1">Kesehatan Fisik</label>
                            <textarea name="kesehatan_fisik" rows="2" class="block w-full rounded-xl border-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm transition-all bg-white/80 focus:bg-white">{{ old('kesehatan_fisik', $asesmen->kesehatan_fisik) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-indigo-900 uppercase tracking-wide mb-1">Kondisi Psikologi</label>
                            <textarea name="psikologi" rows="2" class="block w-full rounded-xl border-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm transition-all bg-white/80 focus:bg-white">{{ old('psikologi', $asesmen->psikologi) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:col-span-2 mt-2 pt-4 border-t border-indigo-100/50">
                             <div>
                                <label class="block text-[12px] font-bold text-indigo-900 uppercase tracking-wide mb-1">Alasan Penggunaan</label>
                                <textarea name="alasan_penggunaan" rows="2" class="block w-full rounded-xl border-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm transition-all bg-white/80 focus:bg-white">{{ old('alasan_penggunaan', $asesmen->alasan_penggunaan) }}</textarea>
                            </div>
                            <div>
                                <label class="block text-[12px] font-bold text-indigo-900 uppercase tracking-wide mb-1">Kondisi Keluarga</label>
                                <textarea name="kondisi_keluarga" rows="2" class="block w-full rounded-xl border-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm transition-all bg-white/80 focus:bg-white">{{ old('kondisi_keluarga', $asesmen->kondisi_keluarga) }}</textarea>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[12px] font-bold text-indigo-900 uppercase tracking-wide mb-1">Tingkat Ketergantungan</label>
                            <input type="text" name="tingkat_ketergantungan" value="{{ old('tingkat_ketergantungan', $asesmen->tingkat_ketergantungan) }}" class="block w-full rounded-xl border-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm transition-all bg-white/80 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-indigo-900 uppercase tracking-wide mb-1">Pola Pemakaian</label>
                            <input type="text" name="pola_pemakaian" value="{{ old('pola_pemakaian', $asesmen->pola_pemakaian) }}" class="block w-full rounded-xl border-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm transition-all bg-white/80 focus:bg-white">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-[12px] font-bold text-indigo-900 uppercase tracking-wide mb-1">Kondisi Lingkungan</label>
                            <textarea name="kondisi_lingkungan" rows="2" class="block w-full rounded-xl border-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm transition-all bg-white/80 focus:bg-white">{{ old('kondisi_lingkungan', $asesmen->kondisi_lingkungan) }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[12px] font-bold text-indigo-900 uppercase tracking-wide mb-1">Saran Sidang Case Conference</label>
                            <textarea name="saran_case_conference" rows="4" class="block w-full rounded-xl border-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm transition-all bg-white/80 focus:bg-white">{{ old('saran_case_conference', $asesmen->saran_case_conference) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- TOMBOL SUBMIT -->
                <!-- ========================================== -->
                <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 pb-10">
                    <a href="{{ route('asesmen.index') }}" class="inline-flex justify-center items-center px-8 py-3.5 bg-white border border-slate-300 rounded-xl text-slate-700 font-bold hover:bg-slate-50 transition-all shadow-sm focus:ring-2 focus:ring-slate-200">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex justify-center items-center px-8 py-3.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 hover:-translate-y-0.5 transition-all shadow-lg shadow-indigo-200 focus:ring-4 focus:ring-indigo-100">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                        Simpan Perubahan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script JavaScript untuk Format Rupiah -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var penghasilanInput = document.getElementById('penghasilan_rupiah');

            if (penghasilanInput) {
                penghasilanInput.addEventListener('keyup', function(e) {
                    this.value = formatRupiah(this.value, 'Rp. ');
                });

                if(penghasilanInput.value) {
                    penghasilanInput.value = formatRupiah(penghasilanInput.value, 'Rp. ');
                }
            }

            function formatRupiah(angka, prefix) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    var separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            }
        });
    </script>
</x-app-layout>