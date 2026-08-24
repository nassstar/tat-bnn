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

            <!-- ========================================== -->
            <!-- BANNER NOTIFIKASI (SUCCESS, ERROR & VALIDASI) -->
            <!-- ========================================== -->

            <!-- 1. Notifikasi Sukses -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start shadow-sm">
                    <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    <div>
                        <h4 class="text-sm font-extrabold text-emerald-800">Berhasil!</h4>
                        <p class="text-[13px] font-semibold text-emerald-600 mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- 2. Notifikasi Error dari Controller (Ini yang akan memunculkan pesan gagal hapus) -->
            @if (session('error'))
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-xl flex items-start shadow-sm">
                    <svg class="w-5 h-5 text-rose-500 mt-0.5 flex-shrink-0 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div>
                        <h4 class="text-sm font-extrabold text-rose-800">Peringatan Sistem!</h4>
                        <p class="text-[13px] font-semibold text-rose-600 mt-1">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- 3. Notifikasi Validasi Form Input -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-xl flex items-start shadow-sm">
                    <svg class="w-5 h-5 text-rose-500 mt-0.5 flex-shrink-0 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div>
                        <h4 class="text-sm font-extrabold text-rose-800">Gagal Menyimpan Data!</h4>
                        <ul class="text-[13px] font-semibold text-rose-600 mt-1 list-disc list-inside ml-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form id="formEditKlien" action="{{ route('asesmen.update', $asesmen->id) }}" method="POST" class="space-y-8">
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

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">No / BLN</label>
                            <input type="text" name="no_bln" value="{{ old('no_bln', $asesmen->no_bln) }}" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Asal Pengajuan</label>
                            <input type="text" name="asal_pengajuan" value="{{ old('asal_pengajuan', $asesmen->asal_pengajuan) }}" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Tanggal Surat</label>
                            <input type="text" name="tgl_surat" value="{{ old('tgl_surat', $asesmen->tgl_surat ? \Carbon\Carbon::parse($asesmen->tgl_surat)->format('d-m-Y') : '') }}" class="datepicker-id mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Pilih Tanggal">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Tanggal Berkas Diterima</label>
                            <input type="text" name="tgl_berkas" value="{{ old('tgl_berkas', $asesmen->tgl_berkas ? \Carbon\Carbon::parse($asesmen->tgl_berkas)->format('d-m-Y') : '') }}" class="datepicker-id mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Pilih Tanggal">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Tanggal Pelaksanaan</label>
                            <input type="text" name="tgl_pelaksanaan" value="{{ old('tgl_pelaksanaan', $asesmen->tgl_pelaksanaan ? \Carbon\Carbon::parse($asesmen->tgl_pelaksanaan)->format('d-m-Y') : '') }}" class="datepicker-id mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Pilih Tanggal">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">No. Surat Pengajuan</label>
                            <input type="text" name="no_surat_pengajuan" value="{{ old('no_surat_pengajuan', $asesmen->no_surat_pengajuan) }}" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">No. LKN / LP / LI</label>
                            <input type="text" name="no_lkn" value="{{ old('no_lkn', $asesmen->no_lkn) }}" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Tanggal Penangkapan</label>
                            <input type="text" name="tgl_tangkap" value="{{ old('tgl_tangkap', $asesmen->tgl_tangkap ? \Carbon\Carbon::parse($asesmen->tgl_tangkap)->format('d-m-Y') : '') }}" class="datepicker-id mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Pilih Tanggal">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">No. Register</label>
                            <input type="text" name="no_register" value="{{ old('no_register', $asesmen->no_register) }}" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
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

                        <!-- BLOK INPUT NIK -->
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">NIK KTP <span class="text-rose-500">*</span></label>
                            <input type="text" name="nik" value="{{ old('nik', $asesmen->nik) }}" required maxlength="16"
                                @class([
                                    'block w-full rounded-xl shadow-sm sm:text-sm transition-all focus:bg-white',
                                    'border-rose-500 ring-2 ring-rose-200 bg-rose-50 text-rose-900' => $errors->has('nik'),
                                    'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 bg-slate-50' => !$errors->has('nik')
                                ])
                                placeholder="16 Digit NIK">
                            @error('nik')
                                <p class="text-[11px] text-rose-600 font-bold mt-1.5 flex items-start gap-1">
                                    <svg class="w-3.5 h-3.5 text-rose-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
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
                            <input type="text" name="tgl_lahir" id="tgl_lahir" value="{{ old('tgl_lahir', $asesmen->tgl_lahir ? \Carbon\Carbon::parse($asesmen->tgl_lahir)->format('d-m-Y') : '') }}" class="datepicker-id block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:text-sm transition-all bg-slate-50 focus:bg-white" placeholder="Pilih Tanggal">
                        </div>

                        <!-- FITUR KOTAK USIA OTOMATIS -->
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Usia <span class="text-blue-500 ml-1 lowercase font-normal">(Saat Didaftarkan)</span></label>
                            <input type="text" name="usia" id="usia" value="{{ old('usia') }}" class="block w-full rounded-xl border-slate-200 shadow-sm sm:text-sm transition-all bg-blue-50 text-blue-800 font-bold pointer-events-none focus:ring-0" placeholder="0 Tahun" readonly>
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

                        <!-- FITUR DROPDOWN PENDIDIKAN DENGAN MODAL KELOLA -->
                        <div class="md:col-span-2 lg:col-span-1">
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Pendidikan</label>
                            <div class="flex gap-2">
                                <select name="pendidikan_input" id="selectPendidikan" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                                    <option value="">-- Pilih Pendidikan --</option>
                                    @foreach($masterPendidikan ?? [] as $p)
                                        <option value="{{ $p->nama_pendidikan }}" {{ old('pendidikan_input', $asesmen->pendidikan_input ?? ($asesmen->pendidikan->nama_pendidikan ?? '')) == $p->nama_pendidikan ? 'selected' : '' }}>
                                            {{ $p->nama_pendidikan }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" onclick="openModalTambahPendidikan()" class="shrink-0 px-3 py-2 bg-blue-100 text-blue-700 font-extrabold text-[10px] sm:text-[11px] uppercase tracking-wider rounded-xl hover:bg-blue-200 transition-colors shadow-sm">+ Tambah</button>
                                <button type="button" onclick="openModalKelolaPendidikan()" class="shrink-0 px-3 py-2 bg-slate-100 text-slate-700 font-extrabold text-[10px] sm:text-[11px] uppercase tracking-wider rounded-xl hover:bg-slate-200 transition-colors shadow-sm">Kelola</button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Pekerjaan</label>
                            <input type="text" name="pekerjaan_input" value="{{ old('pekerjaan_input', $asesmen->pekerjaan_input ?? ($asesmen->pekerjaan->nama_pekerjaan ?? '')) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Penghasilan Rata-Rata</label>
                            <input type="text" name="penghasilan_rata_rata" id="penghasilan_rupiah" value="{{ old('penghasilan_rata_rata', $asesmen->penghasilan_rata_rata) }}" placeholder="Misal: Rp 3.000.000" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:text-sm transition-all bg-slate-50 focus:bg-white">
                        </div>
                    </div>

                    <!-- ===================================== -->
                    <!-- BLOK ALAMAT KTP & DOMISILI -->
                    <!-- ===================================== -->
                    <div class="col-span-1 sm:col-span-2 grid grid-cols-1 lg:grid-cols-2 gap-8 mt-6 pt-6 border-t border-slate-200">

                        <!-- 1. ALAMAT KTP -->
                        <div class="space-y-4 bg-slate-50 p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col h-full">
                            <h4 class="text-sm font-extrabold text-slate-800 border-b border-slate-200 pb-2 mb-2">Alamat Sesuai KTP</h4>

                            <div class="bg-indigo-50/70 border border-indigo-100 p-3 rounded-lg text-xs text-indigo-700 mb-2 leading-relaxed">
                                <span class="font-bold text-indigo-800">Sistem Edit Cerdas:</span> Alamat lama klien telah terisi di kolom <span class="font-bold">Manual</span>. Jika ingin merombak menggunakan dropdown, silakan ganti opsi ke Otomatis.
                            </div>

                            <!-- OPSI MODE PENGISIAN -->
                            <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 p-3 bg-white rounded-lg border border-slate-200 shadow-sm mb-2">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="mode_ktp" value="otomatis" class="text-indigo-600 focus:ring-indigo-500 w-4 h-4" onchange="toggleModeKtp()">
                                    <span class="ml-2 text-xs font-bold text-slate-700">Otomatis (Kab. Malang)</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="mode_ktp" value="manual" checked class="text-indigo-600 focus:ring-indigo-500 w-4 h-4" onchange="toggleModeKtp()">
                                    <span class="ml-2 text-xs font-bold text-slate-700">Manual (Alamat Lama)</span>
                                </label>
                            </div>

                            <!-- BLOK OTOMATIS KTP -->
                            <div id="blok_otomatis_ktp" class="hidden space-y-4">
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Detail Alamat (Jalan / RT RW)</label>
                                    <input type="text" id="jalan_ktp" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Cth: Jl. Diponegoro RT 14 RW 02" />
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block font-medium text-sm text-gray-700">Desa / Kelurahan</label>
                                        <div class="flex gap-2 mt-1">
                                            <select id="tipe_desa_ktp" class="w-[45%] border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm font-semibold text-slate-700">
                                                <option value="Desa">Desa</option>
                                                <option value="Kelurahan">Kelurahan</option>
                                            </select>
                                            <select id="desa_ktp" class="w-[55%] border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                                <option value="">-- Pilih --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block font-medium text-sm text-gray-700">Kecamatan</label>
                                        <select id="kecamatan_ktp" class="border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full text-sm">
                                            <option value="">-- Pilih --</option>
                                            <option value="Ampelgading">Ampelgading</option>
                                            <option value="Bantur">Bantur</option>
                                            <option value="Bululawang">Bululawang</option>
                                            <option value="Dampit">Dampit</option>
                                            <option value="Dau">Dau</option>
                                            <option value="Donomulyo">Donomulyo</option>
                                            <option value="Gedangan">Gedangan</option>
                                            <option value="Gondanglegi">Gondanglegi</option>
                                            <option value="Jabung">Jabung</option>
                                            <option value="Kalipare">Kalipare</option>
                                            <option value="Karangploso">Karangploso</option>
                                            <option value="Kasembon">Kasembon</option>
                                            <option value="Kepanjen">Kepanjen</option>
                                            <option value="Kromengan">Kromengan</option>
                                            <option value="Lawang">Lawang</option>
                                            <option value="Ngajum">Ngajum</option>
                                            <option value="Ngantang">Ngantang</option>
                                            <option value="Pagak">Pagak</option>
                                            <option value="Pagelaran">Pagelaran</option>
                                            <option value="Pakis">Pakis</option>
                                            <option value="Pakisaji">Pakisaji</option>
                                            <option value="Poncokusumo">Poncokusumo</option>
                                            <option value="Pujon">Pujon</option>
                                            <option value="Singosari">Singosari</option>
                                            <option value="Sumbermanjing Wetan">Sumbermanjing Wetan</option>
                                            <option value="Sumberpucung">Sumberpucung</option>
                                            <option value="Tajinan">Tajinan</option>
                                            <option value="Tirtoyudo">Tirtoyudo</option>
                                            <option value="Tumpang">Tumpang</option>
                                            <option value="Turen">Turen</option>
                                            <option value="Wagir">Wagir</option>
                                            <option value="Wajak">Wajak</option>
                                            <option value="Wonosari">Wonosari</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block font-medium text-sm text-gray-700">Kota/Kabupaten</label>
                                        <input type="text" id="kabupaten_ktp" class="border-slate-300 rounded-md shadow-sm mt-1 block w-full text-sm bg-slate-100 font-semibold text-slate-700 pointer-events-none" value="Kabupaten Malang" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- BLOK MANUAL KTP -->
                            <div id="blok_manual_ktp" class="space-y-4">
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Ketik Alamat Lengkap (Bisa Diedit Manual)</label>
                                    <textarea id="manual_ktp" rows="3" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Cth: Jl. Jendral Sudirman No. 10...">{{ old('alamat_ktp', $asesmen->alamat_ktp) }}</textarea>
                                </div>
                            </div>

                            <!-- KOTAK PREVIEW (Read-Only) YANG AKAN DIKIRIM -->
                            <div class="mt-auto pt-4 border-t border-slate-200">
                                <label class="block font-bold text-sm text-indigo-600">Hasil Akhir Alamat KTP</label>
                                <input type="hidden" name="alamat_ktp" id="hidden_alamat_ktp" value="{{ old('alamat_ktp', $asesmen->alamat_ktp) }}">
                                <textarea id="preview_alamat_ktp" rows="2" class="mt-1 block w-full text-[13px] bg-indigo-50 border-indigo-200 rounded-md shadow-sm font-bold text-indigo-800 resize-none cursor-not-allowed" disabled placeholder="Alamat akan terangkai otomatis beserta tanda koma di sini...">{{ old('alamat_ktp', $asesmen->alamat_ktp) }}</textarea>
                            </div>
                        </div>

                        <!-- 2. ALAMAT DOMISILI -->
                        <div class="space-y-4 bg-slate-50 p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col h-full relative">
                            <div class="flex justify-between items-center border-b border-slate-200 pb-2 mb-2">
                                <h4 class="text-sm font-extrabold text-slate-800">Alamat Domisili Saat Ini</h4>
                                <!-- Tombol centang salin alamat -->
                                <label class="inline-flex items-center cursor-pointer bg-white px-2 py-1 rounded border border-slate-200 hover:bg-slate-100 transition shadow-sm">
                                    <input type="checkbox" id="copy_alamat" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500 w-3.5 h-3.5" onchange="salinAlamat()">
                                    <span class="ml-2 text-[10px] font-bold text-slate-600 uppercase">Sama dgn KTP</span>
                                </label>
                            </div>

                            <!-- OPSI MODE PENGISIAN -->
                            <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 p-3 bg-white rounded-lg border border-slate-200 shadow-sm mb-2">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="mode_domisili" value="otomatis" class="text-indigo-600 focus:ring-indigo-500 w-4 h-4" onchange="toggleModeDomisili()">
                                    <span class="ml-2 text-xs font-bold text-slate-700">Otomatis (Kab. Malang)</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="mode_domisili" value="manual" checked class="text-indigo-600 focus:ring-indigo-500 w-4 h-4" onchange="toggleModeDomisili()">
                                    <span class="ml-2 text-xs font-bold text-slate-700">Manual (Alamat Lama)</span>
                                </label>
                            </div>

                            <!-- BLOK OTOMATIS DOMISILI -->
                            <div id="blok_otomatis_domisili" class="hidden space-y-4">
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Detail Alamat (Jalan / RT RW)</label>
                                    <input type="text" id="jalan_domisili" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Cth: Jl. Diponegoro RT 14 RW 02" />
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block font-medium text-sm text-gray-700">Desa / Kelurahan</label>
                                        <div class="flex gap-2 mt-1">
                                            <select id="tipe_desa_domisili" class="w-[45%] border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm font-semibold text-slate-700">
                                                <option value="Desa">Desa</option>
                                                <option value="Kelurahan">Kelurahan</option>
                                            </select>
                                            <select id="desa_domisili" class="w-[55%] border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                                <option value="">-- Pilih --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block font-medium text-sm text-gray-700">Kecamatan</label>
                                        <select id="kecamatan_domisili" class="border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full text-sm">
                                            <option value="">-- Pilih --</option>
                                            <option value="Ampelgading">Ampelgading</option>
                                            <option value="Bantur">Bantur</option>
                                            <option value="Bululawang">Bululawang</option>
                                            <option value="Dampit">Dampit</option>
                                            <option value="Dau">Dau</option>
                                            <option value="Donomulyo">Donomulyo</option>
                                            <option value="Gedangan">Gedangan</option>
                                            <option value="Gondanglegi">Gondanglegi</option>
                                            <option value="Jabung">Jabung</option>
                                            <option value="Kalipare">Kalipare</option>
                                            <option value="Karangploso">Karangploso</option>
                                            <option value="Kasembon">Kasembon</option>
                                            <option value="Kepanjen">Kepanjen</option>
                                            <option value="Kromengan">Kromengan</option>
                                            <option value="Lawang">Lawang</option>
                                            <option value="Ngajum">Ngajum</option>
                                            <option value="Ngantang">Ngantang</option>
                                            <option value="Pagak">Pagak</option>
                                            <option value="Pagelaran">Pagelaran</option>
                                            <option value="Pakis">Pakis</option>
                                            <option value="Pakisaji">Pakisaji</option>
                                            <option value="Poncokusumo">Poncokusumo</option>
                                            <option value="Pujon">Pujon</option>
                                            <option value="Singosari">Singosari</option>
                                            <option value="Sumbermanjing Wetan">Sumbermanjing Wetan</option>
                                            <option value="Sumberpucung">Sumberpucung</option>
                                            <option value="Tajinan">Tajinan</option>
                                            <option value="Tirtoyudo">Tirtoyudo</option>
                                            <option value="Tumpang">Tumpang</option>
                                            <option value="Turen">Turen</option>
                                            <option value="Wagir">Wagir</option>
                                            <option value="Wajak">Wajak</option>
                                            <option value="Wonosari">Wonosari</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block font-medium text-sm text-gray-700">Kota/Kabupaten</label>
                                        <input type="text" id="kabupaten_domisili" class="border-slate-300 rounded-md shadow-sm mt-1 block w-full text-sm bg-slate-100 font-semibold text-slate-700 pointer-events-none" value="Kabupaten Malang" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- BLOK MANUAL DOMISILI -->
                            <div id="blok_manual_domisili" class="space-y-4">
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Ketik Alamat Lengkap (Bisa Diedit Manual)</label>
                                    <textarea id="manual_domisili" rows="3" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Cth: Jl. Jendral Sudirman No. 10...">{{ old('alamat_domisili', $asesmen->alamat_domisili) }}</textarea>
                                </div>
                            </div>

                            <!-- KOTAK PREVIEW (Read-Only) YANG AKAN DIKIRIM -->
                            <div class="mt-auto pt-4 border-t border-slate-200">
                                <label class="block font-bold text-sm text-indigo-600">Hasil Rakitan Alamat Domisili</label>
                                <input type="hidden" name="alamat_domisili" id="hidden_alamat_domisili" value="{{ old('alamat_domisili', $asesmen->alamat_domisili) }}">
                                <textarea id="preview_alamat_domisili" rows="2" class="mt-1 block w-full text-[13px] bg-indigo-50 border-indigo-200 rounded-md shadow-sm font-bold text-indigo-800 resize-none cursor-not-allowed" disabled placeholder="Alamat akan terangkai otomatis beserta tanda koma di sini...">{{ old('alamat_domisili', $asesmen->alamat_domisili) }}</textarea>
                            </div>
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
                                @foreach($masterNarkotika ?? [] as $n)
                                    <option value="{{ $n->id }}" {{ old('narkotika_id', $asesmen->narkotika_id) == $n->id ? 'selected' : '' }}>{{ $n->jenis_narkotika }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Berat Barang Bukti (Gr)</label>
                            <input type="number" step="0.01" name="berat_bb" value="{{ old('berat_bb', $asesmen->berat_bb) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-100 sm:text-sm transition-all bg-slate-50 focus:bg-white" placeholder="Contoh: 2.50">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Status Hukum</label>
                            <input type="text" name="status_hukum" value="{{ old('status_hukum', $asesmen->status_hukum) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-100 sm:text-sm transition-all bg-slate-50 focus:bg-white" placeholder="Cth: Tersangka">
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
                            <input type="text" name="tes_urine" value="{{ old('tes_urine', $asesmen->tes_urine) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-100 sm:text-sm transition-all bg-slate-50 focus:bg-white" placeholder="Cth: Positif Sabu">
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
                        <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        4. Hasil Asesmen Awal (Rekap Mentah TAT)
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Hasil Asesmen Hukum</label>
                            <textarea name="hasil_asesmen_hukum" rows="4" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-slate-500 focus:ring-2 focus:ring-slate-100 sm:text-sm transition-all bg-slate-50 focus:bg-white" placeholder="Ketik kronologi mentah asesmen hukum...">{{ old('hasil_asesmen_hukum', $asesmen->hasil_asesmen_hukum) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Hasil Asesmen Medis</label>
                            <textarea name="hasil_asesmen_medis" rows="4" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-slate-500 focus:ring-2 focus:ring-slate-100 sm:text-sm transition-all bg-slate-50 focus:bg-white" placeholder="Ketik kronologi mentah asesmen medis...">{{ old('hasil_asesmen_medis', $asesmen->hasil_asesmen_medis) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-1">Rekomendasi TAT</label>
                            <input type="text" name="rekomendasi_input" value="{{ old('rekomendasi_input', $asesmen->rekomendasi_input) }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-slate-500 focus:ring-2 focus:ring-slate-100 sm:text-sm transition-all bg-slate-50 focus:bg-white" placeholder="Cth: Rawat Inap RSJ">
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
                <!-- SEKSI 5: ANALISIS CASE CONFERENCE (OPSIONAL) -->
                <!-- ========================================== -->
                <div class="bg-gradient-to-br from-indigo-50/50 to-purple-50/50 p-6 md:p-8 rounded-2xl border border-indigo-100 shadow-sm relative overflow-hidden">
                    <h3 class="text-sm font-extrabold text-indigo-900 uppercase tracking-wider mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        5. Analisis Sidang Case Conference
                    </h3>
                    <p class="text-[13px] font-medium text-indigo-700 mb-6 border-b border-indigo-200/60 pb-4">
                        <span class="bg-white px-2 py-0.5 rounded border border-indigo-100 text-xs shadow-sm mr-1">💡 Opsional</span>
                        Bisa dikosongkan saat pendaftaran awal. Anda dapat memperbarui bagian ini nanti setelah sidang selesai.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[12px] font-bold text-indigo-900 uppercase tracking-wide mb-1">Aspek Hukum</label>
                            <textarea name="aspek_hukum" rows="3" class="block w-full rounded-xl border-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm transition-all bg-white/80 focus:bg-white">{{ old('aspek_hukum', $asesmen->aspek_hukum) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-indigo-900 uppercase tracking-wide mb-1">Aspek Medis</label>
                            <textarea name="aspek_medis" rows="3" class="block w-full rounded-xl border-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm transition-all bg-white/80 focus:bg-white">{{ old('aspek_medis', $asesmen->aspek_medis) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-indigo-900 uppercase tracking-wide mb-1">Kesehatan</label>
                            <textarea name="kesehatan_fisik" rows="2" class="block w-full rounded-xl border-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm transition-all bg-white/80 focus:bg-white">{{ old('kesehatan_fisik', $asesmen->kesehatan_fisik) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-indigo-900 uppercase tracking-wide mb-1">Psikologi</label>
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

    <!-- MODAL TAMBAH PENDIDIKAN -->
    <div id="modalTambahPendidikan" class="fixed inset-0 z-[99] hidden bg-slate-900/50 backdrop-blur-sm overflow-y-auto items-center justify-center transition-all opacity-0">
        <div class="bg-white w-full max-w-md p-6 sm:p-8 rounded-3xl shadow-2xl transform scale-95 transition-all relative">
            <button type="button" onclick="closeModalTambahPendidikan()" class="absolute top-5 right-5 text-slate-400 hover:text-rose-500 transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <h3 class="text-xl font-extrabold text-slate-900 mb-6">Tambah Pendidikan</h3>

            <!-- PERBAIKAN: FORM JS MURNI (ANTI 404) -->
            <form onsubmit="tambahPendidikanJS(event)">
                <div class="mb-6">
                    <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-2">Nama Pendidikan Baru</label>
                    <input type="text" id="inputPendidikanBaru" required placeholder="Cth: S1 Teknik Informatika" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:text-sm transition-all bg-slate-50 focus:bg-white p-3">
                </div>
                <div class="flex flex-col-reverse sm:flex-row justify-end gap-3">
                    <button type="button" onclick="closeModalTambahPendidikan()" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 font-extrabold text-sm rounded-2xl hover:bg-slate-50 transition-colors shadow-sm">Batal</button>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-extrabold text-sm rounded-2xl hover:bg-blue-700 transition-colors shadow-sm">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL KELOLA PENDIDIKAN -->
    <div id="modalKelolaPendidikan" class="fixed inset-0 z-[99] hidden bg-slate-900/50 backdrop-blur-sm overflow-y-auto items-center justify-center transition-all opacity-0">
        <div class="bg-white w-full max-w-lg p-6 sm:p-8 rounded-3xl shadow-2xl transform scale-95 transition-all relative">
            <button type="button" onclick="closeModalKelolaPendidikan()" class="absolute top-5 right-5 text-slate-400 hover:text-rose-500 transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <h3 class="text-xl font-extrabold text-slate-900 mb-6">Kelola Pendidikan</h3>
            <div id="listKelolaPendidikan" class="max-h-[60vh] overflow-y-auto pr-2 space-y-3 mb-8 custom-scrollbar">
                @forelse($masterPendidikan ?? [] as $p)
                <div class="flex justify-between items-center p-4 border border-slate-200 rounded-2xl hover:bg-slate-50 transition-colors">
                    <span class="text-sm font-bold text-slate-700">{{ $p->nama_pendidikan }}</span>
                    <!-- PERINGATAN: Pastikan Anda menambahkan route('pendidikan.destroy') di web.php -->
                    <form action="{{ Route::has('pendidikan.destroy') ? route('pendidikan.destroy', $p->id) : url('pendidikan/'.$p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs font-bold text-rose-500 bg-white hover:bg-rose-50 border border-rose-100 px-4 py-2 rounded-xl transition-colors shadow-sm">Hapus</button>
                    </form>
                </div>
                @empty
                <div class="text-sm text-slate-500 text-center py-6 italic empty-msg">Belum ada data pendidikan.</div>
                @endforelse
            </div>
            <div class="flex justify-center">
                <button type="button" onclick="closeModalKelolaPendidikan()" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 font-extrabold text-sm rounded-2xl hover:bg-slate-50 transition-colors w-full sm:w-auto shadow-sm">Tutup Kelola</button>
            </div>
        </div>
    </div>

    <!-- Script JavaScript Terintegrasi -->
    <script>
        // Modal Handlers
        function openModalTambahPendidikan() {
            const modal = document.getElementById('modalTambahPendidikan');
            modal.classList.remove('hidden');
            modal.classList.add('flex'); // Add flex dynamically to avoid CSS conflict
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.children[0].classList.remove('scale-95');
            }, 10);
        }

        function closeModalTambahPendidikan() {
            const modal = document.getElementById('modalTambahPendidikan');
            modal.classList.add('opacity-0');
            modal.children[0].classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex'); // Remove flex dynamically
            }, 300);
        }

        function openModalKelolaPendidikan() {
            const modal = document.getElementById('modalKelolaPendidikan');
            modal.classList.remove('hidden');
            modal.classList.add('flex'); // Add flex dynamically to avoid CSS conflict
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.children[0].classList.remove('scale-95');
            }, 10);
        }

        function closeModalKelolaPendidikan() {
            const modal = document.getElementById('modalKelolaPendidikan');
            modal.classList.add('opacity-0');
            modal.children[0].classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex'); // Remove flex dynamically
            }, 300);
        }

        // FUNGSI JAVASCRIPT UNTUK TAMBAH PENDIDIKAN TANPA REFRESH
        function tambahPendidikanJS(event) {
            event.preventDefault(); // Mencegah reload/404 page
            const inputVal = document.getElementById('inputPendidikanBaru').value.trim();

            if(inputVal) {
                const selectElement = document.querySelector('select[name="pendidikan_input"]');

                // Cek apakah data sudah ada
                let exists = Array.from(selectElement.options).some(opt => opt.value === inputVal);

                if(!exists) {
                    const newOption = document.createElement('option');
                    newOption.value = inputVal;
                    newOption.textContent = inputVal;
                    selectElement.appendChild(newOption);

                    // ==============================================================
                    // FITUR BARU: Menambahkan DRAFT ke Daftar "Kelola Pendidikan"
                    // ==============================================================
                    const listKelola = document.getElementById('listKelolaPendidikan');

                    // Hapus pesan kosong jika ada
                    const emptyMsg = listKelola.querySelector('.empty-msg');
                    if(emptyMsg) emptyMsg.remove();

                    // Buat ID unik untuk draft (menghilangkan spasi)
                    const draftId = 'draft-' + inputVal.replace(/\s+/g, '-').toLowerCase();

                    // Render HTML baris draft
                    const draftHtml = `
                        <div class="flex justify-between items-center p-4 border border-slate-200 rounded-2xl hover:bg-slate-50 transition-colors" id="${draftId}">
                            <span class="text-sm font-bold text-slate-700">${inputVal}</span>
                            <button type="button" onclick="hapusDraftPendidikan('${inputVal}', '${draftId}')" class="text-xs font-bold text-rose-500 bg-white hover:bg-rose-50 border border-rose-100 px-4 py-2 rounded-xl transition-colors shadow-sm">Hapus</button>
                        </div>
                    `;

                    // Sisipkan baris di urutan paling atas daftar
                    listKelola.insertAdjacentHTML('afterbegin', draftHtml);
                }

                selectElement.value = inputVal;

                closeModalTambahPendidikan();
                document.getElementById('inputPendidikanBaru').value = '';

                alert('Pendidikan "' + inputVal + '" berhasil ditambahkan ke pilihan! Data akan tersimpan permanen ke database saat Anda menyimpan formulir utama.');
            }
        }

        // ==============================================================
        // FITUR BARU: Fungsi untuk membatalkan (menghapus) DRAFT dari browser
        // ==============================================================
        function hapusDraftPendidikan(val, elementId) {
            if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                return;
            }

            // 1. Hapus dari <select> dropdown utama
            const selectElement = document.querySelector('select[name="pendidikan_input"]');
            const optionToRemove = Array.from(selectElement.options).find(opt => opt.value === val);
            if (optionToRemove) {
                optionToRemove.remove();
            }

            // 2. Hapus dari jendela modal
            const draftElement = document.getElementById(elementId);
            if (draftElement) {
                draftElement.remove();
            }

            // Kembalikan ke pilihan default ("-- Pilih Pendidikan --")
            selectElement.value = "";
        }

        // Database Desa dan Kelurahan Kabupaten Malang
        const daftarKelurahan = [ "Ardirejo", "Candirenggo", "Cepokomulyo", "Dampit", "Kalirejo", "Kepanjen", "Lawang", "Losari", "Pagentan", "Penarukan", "Sedayu", "Turen" ];
        const daftarDesa = [ "Amadanom", "Ampeldento (Karangploso)", "Ampeldento (Pakis)", "Ampelgading", "Ardimulyo", "Argosari", "Argosuko", "Argotirto", "Argoyuwono", "Arjosari", "Arjowilangun", "Asrikaton", "Babadan", "Bakalan", "Balearjo", "Balesari", "Bambang", "Bandungrejo", "Bangelan", "Banjararum", "Banjarejo (Donomulyo)", "Banjarejo (Ngantang)", "Banjarejo (Pagelaran)", "Banjarejo (Pakis)", "Banjarsari", "Bantur", "Banturejo", "Baturetno (Dampit)", "Baturetno (Singosari)", "Bayem", "Bedali", "Belung", "Bendosari", "Benjor", "Blayu", "Bocek", "Bokor", "Bringin", "Brongkal", "Bululawang", "Bulupitu", "Bumirejo", "Bunutwetan", "Clumprit", "Codo", "Curungrejo", "Dadapan", "Dalisodo", "Dawuhan", "Dengkol", "Dilem", "Donomulyo", "Donowarih", "Druju", "Duwet", "Duwet Krajan", "Gading", "Gadingkembar", "Gadingkulon", "Gadungsari", "Gajahrejo", "Gampingan", "Ganjaran", "Gedangan", "Gedog Kulon", "Gedog Wetan", "Genengan", "Girimoyo", "Girimulyo", "Glanggang", "Gondanglegi Kulon", "Gondanglegi Wetan", "Gondowangi", "Gubukklakah", "Gunung Jati", "Gunungrejo", "Gunungronggo", "Gunungsari", "Harjokuncaran", "Jabung", "Jambangan", "Jambearjo", "Jambesari", "Jambuwer", "Jatiguwi", "Jatikerto", "Jatirejoyoso", "Jatisari (Pakisaji)", "Jatisari (Tajinan)", "Jedong", "Jenggolo", "Jeru (Tumpang)", "Jeru (Turen)", "Jogomulyan", "Jombok", "Kademangan", "Kaliasri", "Kalipare", "Kalirejo", "Kalisongo", "Kambingan", "Kanigoro", "Karanganyar", "Karangduren", "Karangkates", "Karangnongko", "Karangpandan", "Karangrejo", "Karangsari", "Karangsuko", "Karangwidoro", "Kasembon (Bululawang)", "Kasembon (Kasembon)", "Kasri", "Kaumrejo", "Kebobang", "Kebonagung", "Kedok", "Kedungbanteng", "Kedungpedaringan", "Kedungrejo", "Kedungsalam", "Kemantren", "Kemiri (Jabung)", "Kemiri (Kepanjen)", "Kemulan", "Kendalpayak", "Kenongo", "Kepatihan", "Kepuharjo", "Kesamben", "Ketawang", "Ketindan", "Kidal", "Kidangbang", "Klampok", "Klepu", "Kluwut", "Kranggan", "Krebet", "Krebet Senggrong", "Kromengan", "Kucur", "Kuwolu", "Landungsari", "Lang-Lang", "Lebakharjo", "Lumbangsari", "Madiredo", "Maguan", "Majangtengah", "Malangsuko", "Mangliawan", "Mangunrejo", "Mendalanwangi", "Mentaraman", "Mojosari", "Mulyoagung", "Mulyoarjo", "Mulyoasri", "Mulyorejo", "Ngabab", "Ngadas", "Ngadilangkung", "Ngadirejo (Jabung)", "Ngadirejo (Kromengan)", "Ngadireso", "Ngajum", "Ngantru", "Ngasem", "Ngawonggo", "Ngebruk (Poncokusumo)", "Ngebruk (Sumberpucung)", "Ngembal", "Ngenep", "Ngijo", "Ngingit", "Ngroto", "Pagedangan", "Pagersari", "Pait", "Pajaran", "Pakisaji", "Pakisjajar", "Pakiskembar", "Palaan", "Pamotan", "Pandanajeng", "Pandanlandung", "Pandanmulyo", "Pandanrejo (Pagak)", "Pandanrejo (Wagir)", "Pandansari (Ngantang)", "Pandansari (Poncokusumo)", "Pandansari Lor", "Pandesari", "Panggungrejo (Gondanglegi)", "Panggungrejo (Kepanjen)", "Parangargo", "Patokpicis", "Peniwen", "Permanu", "Petungsewu (Dau)", "Petungsewu (Wagir)", "Plandi", "Plaosan", "Pojok", "Poncokusumo", "Pondokagung", "Pringgodani", "Pringu", "Pucangsongo", "Pujiharjo", "Pujon Kidul", "Pujon Lor", "Pulungdowo", "Purwoasri", "Purwodadi (Donomulyo)", "Purwodadi (Tirtoyudo)", "Purwoharjo", "Purworejo (Donomulyo)", "Purworejo (Ngantang)", "Purwosekar", "Putat Kidul", "Putat Lor", "Putukrejo (Gondanglegi)", "Putukrejo (Kalipare)", "Randuagung", "Randugading", "Rejosari", "Rejoyoso", "Rembun", "Ringinkembar", "Ringinsari", "Sambigede", "Sanankerto", "Sananrejo", "Saptorenggo", "Sawahan", "Segaran", "Sekarbanyu", "Sekarpuro", "Selorejo", "Sempalwadak", "Sempol", "Senggreng", "Sengguruh", "Sepanjang", "Sidoasri", "Sidodadi (Gedangan)", "Sidodadi (Lawang)", "Sidodadi (Ngantang)", "Sidoluhur", "Sidomulyo", "Sidorahayu", "Sidorejo (Jabung)", "Sidorejo (Pagelaran)", "Sidorenggo", "Simojayan", "Sindurejo", "Sitiarjo", "Sitirejo", "Slamet", "Slamparejo", "Slorok", "Sonowangi", "Srigading", "Srigonco", "Srimulyo", "Sudimoro", "Sukoanyar (Pakis)", "Sukoanyar (Wajak)", "Sukodadi", "Sukodono", "Sukolilo (Jabung)", "Sukolilo (Wajak)", "Sukomulyo", "Sukonolo", "Sukopuro", "Sukoraharjo", "Sukorejo (Gondanglegi)", "Sukorejo (Tirtoyudo)", "Sukosari (Gondanglegi)", "Sukosari (Kasembon)", "Sukowilangun", "Sumberagung (Ngantang)", "Sumberagung (Sumbermanjing Wetan)", "Sumberbening", "Sumberdem", "Sumberejo (Gedangan)", "Sumberejo (Pagak)", "Sumberejo (Poncokusumo)", "Sumberjaya", "Sumberkerto", "Sumberkradenan", "Sumbermanjing Kulon", "Sumbermanjing Wetan", "Sumberngepoh", "Sumberoto", "Sumberpasir", "Sumberpetung", "Sumberporong", "Sumberpucung", "Sumberputih", "Sumbersekar", "Sumbersuko (Dampit)", "Sumbersuko (Tajinan)", "Sumbersuko (Wagir)", "Sumbertangkil", "Sumbertempur", "Sutojayan", "Suwaru", "Taji", "Tajinan", "Talangagung", "Talangsuko", "Talok", "Tamanasri", "Tamanharjo", "Tamankuncaran", "Tamansari", "Tamansatriyan", "Tambakasri (Sumbermanjing Wetan)", "Tambakasri (Tajinan)", "Tambakrejo", "Tanggung", "Tangkilsari", "Tawangagung", "Tawangargo", "Tawangrejeni", "Tawangsari", "Tegalgondo", "Tegalrejo", "Tegalsari", "Tegalweru", "Tempursari", "Ternyang", "Tirtomarto", "Tirtomoyo (Ampelgading)", "Tirtomoyo (Pakis)", "Tirtoyudo", "Tlogorejo", "Tlogosari (Donomulyo)", "Tlogosari (Tirtoyudo)", "Toyomarto", "Tulungrejo (Donomulyo)", "Tulungrejo (Ngantang)", "Tulusbesar", "Tumpakrejo (Gedangan)", "Tumpakrejo (Kalipare)", "Tumpang", "Tumpukrenteng", "Tunjungtirto", "Turirejo", "Undaan", "Urek-Urek", "Wadung", "Wajak", "Wandanpuro", "Watugede", "Waturejo", "Wirotaman", "Wiyurejo", "Wonoagung (Kasembon)", "Wonoagung (Tirtoyudo)", "Wonoayu", "Wonokerso", "Wonokerto", "Wonomulyo", "Wonorejo (Bantur)", "Wonorejo (Lawang)", "Wonorejo (Poncokusumo)", "Wonorejo (Singosari)", "Wonosari", "Wringinanom", "Wringinsongo" ];

        // Fungsi Memuat Opsi Desa/Kelurahan ke Dropdown
        function populateDesa(tipeId, targetId) {
            try {
                const tipe = document.getElementById(tipeId).value;
                const select = document.getElementById(targetId);

                const currentVal = select.value;

                select.innerHTML = '<option value="">-- Pilih --</option>';

                const dataToLoad = tipe === 'Kelurahan' ? daftarKelurahan : daftarDesa;

                dataToLoad.forEach(function(item) {
                    const opt = document.createElement('option');
                    opt.value = item;
                    opt.textContent = item;
                    select.appendChild(opt);
                });

                if (dataToLoad.includes(currentVal)) {
                    select.value = currentVal;
                }
            } catch (e) {
                console.error("Error populateDesa:", e);
            }
        }

        // Toggles Animasi Form KTP
        function toggleModeKtp() {
            try {
                const mode = document.querySelector('input[name="mode_ktp"]:checked').value;
                if (mode === 'otomatis') {
                    document.getElementById('blok_otomatis_ktp').classList.remove('hidden');
                    document.getElementById('blok_manual_ktp').classList.add('hidden');
                } else {
                    document.getElementById('blok_otomatis_ktp').classList.add('hidden');
                    document.getElementById('blok_manual_ktp').classList.remove('hidden');
                }
                updateAlamatKtp();
            } catch (e) { console.error(e); }
        }

        // Toggles Animasi Form Domisili
        function toggleModeDomisili() {
            try {
                const mode = document.querySelector('input[name="mode_domisili"]:checked').value;
                if (mode === 'otomatis') {
                    document.getElementById('blok_otomatis_domisili').classList.remove('hidden');
                    document.getElementById('blok_manual_domisili').classList.add('hidden');
                } else {
                    document.getElementById('blok_otomatis_domisili').classList.add('hidden');
                    document.getElementById('blok_manual_domisili').classList.remove('hidden');
                }
                updateAlamatDomisili();
            } catch(e) { console.error(e); }
        }

        // Fungsi Salin Alamat KTP -> Domisili
        function salinAlamat() {
            try {
                const isChecked = document.getElementById('copy_alamat').checked;
                if (isChecked) {
                    // Menyamakan mode radio button
                    const modeKtp = document.querySelector('input[name="mode_ktp"]:checked').value;
                    document.querySelector(`input[name="mode_domisili"][value="${modeKtp}"]`).checked = true;
                    toggleModeDomisili();

                    if (modeKtp === 'otomatis') {
                        document.getElementById('jalan_domisili').value = document.getElementById('jalan_ktp').value;
                        document.getElementById('tipe_desa_domisili').value = document.getElementById('tipe_desa_ktp').value;

                        populateDesa('tipe_desa_domisili', 'desa_domisili');

                        document.getElementById('desa_domisili').value = document.getElementById('desa_ktp').value;
                        document.getElementById('kecamatan_domisili').value = document.getElementById('kecamatan_ktp').value;
                    } else {
                        document.getElementById('manual_domisili').value = document.getElementById('manual_ktp').value;
                    }
                } else {
                    document.getElementById('jalan_domisili').value = '';
                    document.getElementById('desa_domisili').value = '';
                    document.getElementById('kecamatan_domisili').value = '';
                    document.getElementById('manual_domisili').value = '';
                }
                updateAlamatDomisili();
            } catch(e) { console.error(e); }
        }

        document.addEventListener('DOMContentLoaded', function() {

            // JALANKAN TOGGLE TAMPILAN DEFAULT
            toggleModeKtp();
            toggleModeDomisili();

            // Render awal daftar desa saat halaman pertama kali dimuat
            populateDesa('tipe_desa_ktp', 'desa_ktp');
            populateDesa('tipe_desa_domisili', 'desa_domisili');

            // Trigger perubahan tipe (Desa <-> Kelurahan)
            document.getElementById('tipe_desa_ktp').addEventListener('change', function() {
                populateDesa('tipe_desa_ktp', 'desa_ktp');
                updateAlamatKtp();
            });

            document.getElementById('tipe_desa_domisili').addEventListener('change', function() {
                populateDesa('tipe_desa_domisili', 'desa_domisili');
                updateAlamatDomisili();
            });

            // Format Rupiah
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

            // HITUNG USIA OTOMATIS CERDAS & ANTI GAGAL (Memakai created_at database)
            function hitungUsia() {
                try {
                    const tglLahirInput = document.getElementById('tgl_lahir').value.trim();
                    const usiaInput = document.getElementById('usia');

                    if (!tglLahirInput) {
                        usiaInput.value = '';
                        return;
                    }

                    // Ambil angka mentahnya, membuang jam jika ikut terbawa dari database
                    let rawDate = tglLahirInput.split(' ')[0];
                    let parts = rawDate.split('-');
                    let dob;

                    // Cek Cerdas Format YYYY-MM-DD vs DD-MM-YYYY
                    if (parts.length === 3) {
                        let p0 = parts[0];
                        let p2 = parts[2];
                        if (p0.length === 4) {
                            dob = new Date(parseInt(p0), parseInt(parts[1]) - 1, parseInt(p2));
                        } else if (p2.length === 4) {
                            dob = new Date(parseInt(p2), parseInt(parts[1]) - 1, parseInt(p0));
                        }
                    }

                    // Fallback jika aneh
                    if (!dob || isNaN(dob.getTime())) {
                        dob = new Date(rawDate);
                    }

                    if (isNaN(dob.getTime())) {
                        return;
                    }

                    // Ambil Tanggal saat pendaftaran dari PHP (Jika belum ada, pakai hari ini)
                    let refDateStr = "{{ $asesmen->created_at ? \Carbon\Carbon::parse($asesmen->created_at)->format('Y-m-d') : now()->format('Y-m-d') }}";
                    let refDate = new Date(refDateStr);

                    let age = refDate.getFullYear() - dob.getFullYear();
                    let m = refDate.getMonth() - dob.getMonth();

                    if (m < 0 || (m === 0 && refDate.getDate() < dob.getDate())) {
                        age--;
                    }

                    if(age >= 0) {
                        usiaInput.value = age + ' Tahun';
                    }
                } catch(e) {
                    console.error("Penghitungan Usia Gagal:", e);
                }
            }

            // Memasang pendeteksi standar untuk kolom tanggal
            const tglLahirEl = document.getElementById('tgl_lahir');
            if(tglLahirEl) {
                tglLahirEl.addEventListener('change', hitungUsia);
                tglLahirEl.addEventListener('input', hitungUsia);
                tglLahirEl.addEventListener('blur', hitungUsia);
                hitungUsia(); // Eksekusi saat halaman pertama dimuat
            }

            // Interval Kuat Khusus Datepicker Form
            let lastTgl = tglLahirEl ? tglLahirEl.value : '';
            setInterval(function() {
                let currentTgl = tglLahirEl ? tglLahirEl.value : '';
                if(currentTgl !== lastTgl) {
                    lastTgl = currentTgl;
                    hitungUsia();
                }
            }, 500);

            // Fungsi Real-time Update Alamat KTP
            function updateAlamatKtp() {
                try {
                    const mode = document.querySelector('input[name="mode_ktp"]:checked').value;
                    let finalAlamat = '';

                    if (mode === 'otomatis') {
                        const jalan = document.getElementById('jalan_ktp').value.trim();
                        const tipeDesa = document.getElementById('tipe_desa_ktp').value;
                        const desa = document.getElementById('desa_ktp').value;
                        const kec = document.getElementById('kecamatan_ktp').value;
                        const kab = document.getElementById('kabupaten_ktp').value;

                        let parts = [];
                        if (jalan) parts.push(jalan);
                        if (desa) parts.push(tipeDesa + ' ' + desa);
                        if (kec) parts.push('Kecamatan ' + kec);
                        if (kab) parts.push(kab);

                        finalAlamat = parts.join(', ');
                    } else {
                        finalAlamat = document.getElementById('manual_ktp').value.trim();
                    }

                    document.getElementById('preview_alamat_ktp').value = finalAlamat;
                    document.getElementById('hidden_alamat_ktp').value = finalAlamat;
                } catch(e) { console.error(e); }
            }

            // Fungsi Real-time Update Alamat Domisili
            function updateAlamatDomisili() {
                try {
                    const mode = document.querySelector('input[name="mode_domisili"]:checked').value;
                    let finalAlamat = '';

                    if (mode === 'otomatis') {
                        const jalan = document.getElementById('jalan_domisili').value.trim();
                        const tipeDesa = document.getElementById('tipe_desa_domisili').value;
                        const desa = document.getElementById('desa_domisili').value;
                        const kec = document.getElementById('kecamatan_domisili').value;
                        const kab = document.getElementById('kabupaten_domisili').value;

                        let parts = [];
                        if (jalan) parts.push(jalan);
                        if (desa) parts.push(tipeDesa + ' ' + desa);
                        if (kec) parts.push('Kecamatan ' + kec);
                        if (kab) parts.push(kab);

                        finalAlamat = parts.join(', ');
                    } else {
                        finalAlamat = document.getElementById('manual_domisili').value.trim();
                    }

                    document.getElementById('preview_alamat_domisili').value = finalAlamat;
                    document.getElementById('hidden_alamat_domisili').value = finalAlamat;
                } catch(e) { console.error(e); }
            }

            // Pasang pendeteksi perubahan untuk input otomatis
            const otomatisKtpFields = ['jalan_ktp', 'tipe_desa_ktp', 'desa_ktp', 'kecamatan_ktp', 'kabupaten_ktp'];
            otomatisKtpFields.forEach(function(id) {
                const el = document.getElementById(id);
                if (el) {
                    el.addEventListener('input', updateAlamatKtp);
                    el.addEventListener('change', updateAlamatKtp);
                }
            });

            const otomatisDomisiliFields = ['jalan_domisili', 'tipe_desa_domisili', 'desa_domisili', 'kecamatan_domisili', 'kabupaten_domisili'];
            otomatisDomisiliFields.forEach(function(id) {
                const el = document.getElementById(id);
                if (el) {
                    el.addEventListener('input', updateAlamatDomisili);
                    el.addEventListener('change', updateAlamatDomisili);
                }
            });

            // Pasang pendeteksi perubahan untuk input manual
            document.getElementById('manual_ktp').addEventListener('input', updateAlamatKtp);
            document.getElementById('manual_domisili').addEventListener('input', updateAlamatDomisili);

            // Validasi darurat saat form di-submit
            document.getElementById('formEditKlien').addEventListener('submit', function(e) {
                updateAlamatKtp();
                updateAlamatDomisili();
            });

        });
    </script>
</x-app-layout>
