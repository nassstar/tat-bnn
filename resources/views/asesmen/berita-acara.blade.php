<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('asesmen.show', $asesmen->id) }}" class="text-slate-500 hover:text-blue-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-slate-900 tracking-tight">Formulir Berita Acara TAT</h2>
                <p class="text-sm text-slate-500 mt-1">Klien: <span class="font-semibold text-blue-600">{{ $asesmen->nama_lengkap }}</span></p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('asesmen.berita-acara.generate', $asesmen->id) }}" method="POST" class="space-y-6" id="formBeritaAcara">
                @csrf
                <div id="hidden-inputs-container"></div>

                <!-- SEKSI 1: HEADER & TIM TAT -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">1. Header Surat & Pimpinan Rapat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Nomor Berita Acara</label>
                            <input type="text" name="no_ba" value="{{ old('no_ba', $asesmen->no_ba) }}" placeholder="Contoh: BA/277/VII/TAT/Pb.00/2026/BNNK" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Tanggal Rapat (BA)</label>
                            <input type="date" name="tgl_ba" value="{{ old('tgl_ba', $asesmen->tgl_ba) }}" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Nama Ketua TAT</label>
                            <input type="text" name="ketua_tat_nama" value="{{ old('ketua_tat_nama', $asesmen->ketua_tat_nama ?? 'LETKOL LAUT (PM) Hendratmo Budi Wibowo S Pd.') }}" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">NRP Ketua TAT</label>
                            <input type="text" name="ketua_tat_nrp" value="{{ old('ketua_tat_nrp', $asesmen->ketua_tat_nrp ?? '16301/P') }}" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Nomor SK Tim Asesmen</label>
                            <input type="text" name="no_kep_tim" value="{{ old('no_kep_tim', $asesmen->no_kep_tim ?? 'KEP/10/IV/KA/KP/2026/BNN Kab. Malang') }}" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Tanggal SK Tim</label>
                            <input type="date" name="tgl_kep_tim" value="{{ old('tgl_kep_tim', $asesmen->tgl_kep_tim) }}" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                    </div>
                </div>

                <!-- SEKSI 2: PEMILIHAN ANGGOTA TIM -->
                <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-200 shadow-sm">
                    <div class="flex justify-between items-center mb-4 border-b border-indigo-200 pb-2">
                        <h3 class="text-lg font-bold text-indigo-900">2. Susunan Anggota Tim TAT</h3>
                        <p class="text-xs text-indigo-700">Pilih dari daftar atau kelola database.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- KOLOM TIM MEDIS -->
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-indigo-100">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tim Medis (Maks. 2)</label>
                            <div class="flex gap-2 mb-4">
                                <select id="select-medis" class="block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">-- Pilih Dokter --</option>
                                </select>
                                <button type="button" onclick="bukaModal('medis')" class="px-3 py-2 bg-indigo-600 text-white text-xs font-bold rounded-md hover:bg-indigo-700 shadow-sm">+ Baru</button>
                                <button type="button" onclick="bukaKelola('medis')" class="px-3 py-2 bg-slate-200 text-slate-700 text-xs font-bold rounded-md hover:bg-slate-300 shadow-sm">⚙️ Kelola</button>
                            </div>
                            <div id="container-medis" class="space-y-2"></div>
                        </div>

                        <!-- KOLOM TIM HUKUM -->
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-indigo-100">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tim Hukum (Maks. 3)</label>
                            <div class="flex gap-2 mb-4">
                                <select id="select-hukum" class="block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">-- Pilih Penyidik/Jaksa --</option>
                                </select>
                                <button type="button" onclick="bukaModal('hukum')" class="px-3 py-2 bg-indigo-600 text-white text-xs font-bold rounded-md hover:bg-indigo-700 shadow-sm">+ Baru</button>
                                <button type="button" onclick="bukaKelola('hukum')" class="px-3 py-2 bg-slate-200 text-slate-700 text-xs font-bold rounded-md hover:bg-slate-300 shadow-sm">⚙️ Kelola</button>
                            </div>
                            <div id="container-hukum" class="space-y-2"></div>
                        </div>
                    </div>
                </div>

                <!-- SEKSI 3: HASIL PEMERIKSAAN (NARASI) -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">3. Narasi Hasil Pemeriksaan</h3>
                    <div class="space-y-6">
                        <!-- KOTAK NARASI MEDIS -->
                        <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg shadow-sm">
                            <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 mb-3">
                                <label class="block text-sm font-bold text-blue-900">Narasi Tim Medis</label>
                                <div class="flex items-center gap-3 bg-white p-2 rounded-md border border-blue-100 text-sm flex-wrap">
                                    <span class="text-slate-600 font-medium text-xs">Gunakan Alamat:</span>
                                    <label class="flex items-center gap-1 cursor-pointer text-blue-800 font-medium">
                                        <input type="radio" name="alamat_medis" value="ktp" checked> KTP
                                    </label>
                                    <label class="flex items-center gap-1 cursor-pointer text-blue-800 font-medium">
                                        <input type="radio" name="alamat_medis" value="domisili"> Domisili
                                    </label>
                                    <label class="flex items-center gap-1 cursor-pointer text-blue-800 font-medium">
                                        <input type="radio" name="alamat_medis" value="keduanya"> Keduanya
                                    </label>
                                    <button type="button" onclick="applyDraftMedis()" class="ml-2 px-3 py-1 bg-blue-600 text-white hover:bg-blue-700 rounded text-xs font-bold transition">Terapkan Draf Pembuka</button>
                                </div>
                            </div>
                            <textarea id="narasi_medis" name="narasi_medis" rows="7" class="block w-full rounded-md border-blue-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('narasi_medis', $asesmen->narasi_medis) }}</textarea>
                        </div>

                        <!-- KOTAK NARASI HUKUM -->
                        <div class="p-4 bg-slate-50 border border-slate-300 rounded-lg shadow-sm">
                            <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 mb-3">
                                <label class="block text-sm font-bold text-slate-800">Narasi Tim Hukum</label>
                                <div class="flex flex-wrap items-center gap-3 bg-white p-2 rounded-md border border-slate-200 text-sm">
                                    <div class="flex items-center gap-2 border-r border-slate-300 pr-3">
                                        <span class="text-slate-600 font-medium text-xs">Pekerjaan:</span>
                                        <input type="text" id="input_pekerjaan_hukum" value="{{ $asesmen->pekerjaan->nama_pekerjaan ?? '' }}" class="h-7 text-xs rounded border-slate-300 w-32 focus:ring-blue-500">
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-slate-600 font-medium text-xs">Gunakan Alamat:</span>
                                        <label class="flex items-center gap-1 cursor-pointer text-slate-800 font-medium">
                                            <input type="radio" name="alamat_hukum" value="ktp" checked> KTP
                                        </label>
                                        <label class="flex items-center gap-1 cursor-pointer text-slate-800 font-medium">
                                            <input type="radio" name="alamat_hukum" value="domisili"> Domisili
                                        </label>
                                        <label class="flex items-center gap-1 cursor-pointer text-slate-800 font-medium">
                                            <input type="radio" name="alamat_hukum" value="keduanya"> Keduanya
                                        </label>
                                    </div>
                                    <button type="button" onclick="applyDraftHukum()" class="ml-2 px-3 py-1 bg-slate-700 text-white hover:bg-slate-800 rounded text-xs font-bold transition">Terapkan Draf Pembuka</button>
                                </div>
                            </div>
                            <textarea id="narasi_hukum" name="narasi_hukum" rows="7" class="block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('narasi_hukum', $asesmen->narasi_hukum) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- SEKSI 4: ALAT BUKTI & KESIMPULAN -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">4. Alat Bukti & Kesimpulan</h3>
                    
                    <h4 class="font-semibold text-sm text-slate-600 mb-2 bg-slate-100 p-2 rounded">A. Data Alat Bukti (Surat Keterangan)</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">No. SK Narkoba</label>
                            <input type="text" name="alat_bukti_no_sk" value="{{ old('alat_bukti_no_sk', $asesmen->alat_bukti_no_sk ?? 'B/ND/336VII/KES.I./2026') }}" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Tanggal SK Narkoba</label>
                            <input type="date" name="alat_bukti_tgl_sk" value="{{ old('alat_bukti_tgl_sk', $asesmen->alat_bukti_tgl_sk) }}" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Nama Dokter Pemeriksa (Otomatis dari Tim Medis)</label>
                            <select id="select-dokter-pemeriksa" name="alat_bukti_dokter" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-slate-50 cursor-pointer">
                                <option value="{{ $asesmen->alat_bukti_dokter ?? '' }}">{{ $asesmen->alat_bukti_dokter ?? '-- Pilih dari Tim Medis --' }}</option>
                            </select>
                        </div>
                        <div class="row-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Hasil Zat Positif</label>
                            <div class="p-3 border border-slate-200 rounded-md bg-slate-50">
                                <div id="container-zat" class="space-y-1 mb-3">
                                    <!-- Render Checkbox Zat Positif JS -->
                                </div>
                                <div class="flex gap-2 pt-2 border-t border-slate-200">
                                    <button type="button" onclick="bukaModalOpsi('zat')" class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold rounded hover:bg-indigo-200 transition">+ Tambah Zat</button>
                                    <button type="button" onclick="bukaKelolaOpsi('zat')" class="px-2 py-1 bg-red-50 text-red-600 text-xs font-bold rounded hover:bg-red-100 transition">Kelola Zat</button>
                                </div>
                            </div>
                            <input type="hidden" name="alat_bukti_hasil" id="alat_bukti_hasil_input" value="{{ old('alat_bukti_hasil', $asesmen->alat_bukti_hasil) }}">
                        </div>
                    </div>

                    <h4 class="font-semibold text-sm text-slate-600 mb-2 mt-8 bg-slate-100 p-2 rounded">B. Kesimpulan TAT</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        
                        <!-- 1. Jenis Zat (Textarea melebar) -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700">Jenis Zat yang Dipakai</label>
                            <textarea id="kesimpulan_jenis_zat_input" name="kesimpulan_jenis_zat" rows="2" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 sm:text-sm bg-slate-100" readonly>{{ old('kesimpulan_jenis_zat', $asesmen->kesimpulan_jenis_zat) }}</textarea>
                            <p class="text-[10px] text-slate-500 mt-1">Otomatis terisi dari centang Zat Positif.</p>
                        </div>

                        <!-- 2. Status Klien -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Status Klien</label>
                            <select name="status_klien" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 sm:text-sm">
                                <option value="penyalahguna" {{ old('status_klien', $asesmen->status_klien) == 'penyalahguna' ? 'selected' : '' }}>Penyalahguna</option>
                                <option value="korban penyalahguna" {{ old('status_klien', $asesmen->status_klien) == 'korban penyalahguna' ? 'selected' : '' }}>Korban Penyalahguna</option>
                            </select>
                        </div>

                        <!-- 3. Pola Pemakaian (Ada 'Coba Pakai') -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Pola Pemakaian</label>
                            <select name="kesimpulan_pola_pakai" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 sm:text-sm">
                                <option value="">-- Pilih Pola --</option>
                                <option value="Coba pakai" {{ old('kesimpulan_pola_pakai', $asesmen->kesimpulan_pola_pakai) == 'Coba pakai' ? 'selected' : '' }}>Coba pakai</option>
                                <option value="Situasional" {{ old('kesimpulan_pola_pakai', $asesmen->kesimpulan_pola_pakai) == 'Situasional' ? 'selected' : '' }}>Situasional</option>
                                <option value="Rekreasional" {{ old('kesimpulan_pola_pakai', $asesmen->kesimpulan_pola_pakai) == 'Rekreasional' ? 'selected' : '' }}>Rekreasional</option>
                                <option value="Teratur pakai" {{ old('kesimpulan_pola_pakai', $asesmen->kesimpulan_pola_pakai) == 'Teratur pakai' ? 'selected' : '' }}>Teratur pakai</option>
                            </select>
                        </div>

                        <!-- 4. Kategori Ketergantungan (Tanpa 'Coba Pakai') -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Kategori Ketergantungan</label>
                            <select name="kesimpulan_kategori" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 sm:text-sm">
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Ringan" {{ old('kesimpulan_kategori', $asesmen->kesimpulan_kategori) == 'Ringan' ? 'selected' : '' }}>Ringan</option>
                                <option value="Sedang" {{ old('kesimpulan_kategori', $asesmen->kesimpulan_kategori) == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="Berat" {{ old('kesimpulan_kategori', $asesmen->kesimpulan_kategori) == 'Berat' ? 'selected' : '' }}>Berat</option>
                            </select>
                        </div>

                        <!-- 5. Diagnosis Medis Dinamis -->
                        <div class="md:col-span-2 mt-2">
                            <label class="block text-sm font-medium text-slate-700">Diagnosis Medis</label>
                            <div class="flex gap-2 mt-1">
                                <select id="select_diagnosis" name="diagnosis_medis" class="block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 sm:text-sm">
                                    <option value="{{ $asesmen->diagnosis_medis ?? '' }}">{{ $asesmen->diagnosis_medis ?? '-- Pilih Diagnosis --' }}</option>
                                </select>
                                <button type="button" onclick="bukaModalOpsi('diagnosis')" class="px-3 py-2 bg-indigo-100 text-indigo-700 text-xs font-bold rounded-md hover:bg-indigo-200 whitespace-nowrap transition">+ Tambah</button>
                                <button type="button" onclick="bukaKelolaOpsi('diagnosis')" class="px-3 py-2 bg-red-50 text-red-600 text-xs font-bold rounded-md hover:bg-red-100 whitespace-nowrap transition">Kelola</button>
                            </div>
                        </div>
                    </div>

                    <h4 class="font-semibold text-sm text-slate-600 mb-2 mt-8 bg-slate-100 p-2 rounded">C. Keputusan Rekomendasi</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700">Tempat Rehabilitasi (Sesuai SK)</label>
                            <div class="flex gap-2 mt-1">
                                <select id="select_tempat_rehab" name="rekomendasi_tempat_rehab" class="block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="{{ $asesmen->rekomendasi_tempat_rehab ?? '' }}">{{ $asesmen->rekomendasi_tempat_rehab ?? '-- Pilih Tempat Rehab --' }}</option>
                                    <!-- Options by JS -->
                                </select>
                                <button type="button" onclick="bukaModalOpsi('tempat_rehab')" class="px-3 py-2 bg-indigo-100 text-indigo-700 text-xs font-bold rounded-md hover:bg-indigo-200 whitespace-nowrap transition">+ Tambah</button>
                                <button type="button" onclick="bukaKelolaOpsi('tempat_rehab')" class="px-3 py-2 bg-red-50 text-red-600 text-xs font-bold rounded-md hover:bg-red-100 whitespace-nowrap transition">Kelola</button>
                            </div>
                        </div>
                        
                        <!-- DURASI REHABILITASI -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Lama (Durasi) Rehabilitasi</label>
                            <select id="select_durasi" onchange="handleDurasiChange(this)" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm mb-2">
                                <option value="1 bulan">1 bulan</option>
                                <option value="2 bulan">2 bulan</option>
                                <option value="3 bulan" selected>3 bulan</option>
                                <option value="1-3 bulan">1-3 bulan</option>
                                <option value="lainnya">Lainnya (Masukkan sendiri)</option>
                            </select>
                            <input type="text" id="input_durasi_custom" placeholder="Ketik durasi manual..." class="hidden w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" onkeyup="document.getElementById('rekomendasi_durasi_hidden').value = this.value">
                            <!-- Input asli yang terkirim -->
                            <input type="hidden" name="rekomendasi_durasi" id="rekomendasi_durasi_hidden" value="{{ old('rekomendasi_durasi', $asesmen->rekomendasi_durasi ?? '3 bulan') }}">
                        </div>

                        <!-- KETERANGAN HUKUM REKOMENDASI -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700">Keterangan Hukum Rekomendasi</label>
                            <select name="rekomendasi_keterangan" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm h-auto py-3">
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

                <!-- Tombol Submit -->
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('asesmen.show', $asesmen->id) }}" class="px-6 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-700 font-medium hover:bg-slate-50 transition">Batal</a>
                    <button type="submit" onclick="syncHiddenInputs()" style="background-color: #059669;" class="px-6 py-2.5 text-white font-medium rounded-lg hover:opacity-90 transition shadow-sm flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Simpan & Unduh Berita Acara
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL ANGGOTA TAT (MEDIS/HUKUM) -->
    <div id="modalTambahAnggota" class="fixed inset-0 z-[60] hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-lg font-bold text-slate-800" id="modalTitle">Tambah Anggota Baru</h3>
                <button type="button" onclick="tutupModal()" class="text-slate-400 hover:text-red-500 font-bold text-xl">&times;</button>
            </div>
            <form id="formTambahAnggota" class="space-y-4">
                <input type="hidden" id="modalKategori" name="kategori">
                <div><label class="block text-sm font-medium text-slate-700">Nama Lengkap & Gelar</label><input type="text" id="modalNama" required class="mt-1 block w-full rounded-md border-slate-300 sm:text-sm"></div>
                <div><label class="block text-sm font-medium text-slate-700">NIP / NRP / SIP</label><input type="text" id="modalNip" class="mt-1 block w-full rounded-md border-slate-300 sm:text-sm"></div>
                <div id="wrapPangkat"><label class="block text-sm font-medium text-slate-700">Pangkat (Opsional)</label><input type="text" id="modalPangkat" class="mt-1 block w-full rounded-md border-slate-300 sm:text-sm"></div>
                <div><label class="block text-sm font-medium text-slate-700">Jabatan</label><input type="text" id="modalJabatan" class="mt-1 block w-full rounded-md border-slate-300 sm:text-sm"></div>
                <div class="flex justify-end gap-2 pt-2"><button type="button" onclick="tutupModal()" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-md text-sm font-medium">Batal</button><button type="button" onclick="simpanAnggotaBaru()" id="btnSimpanAnggota" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium">Simpan Data</button></div>
            </form>
        </div>
    </div>
    <div id="modalKelolaAnggota" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6 flex flex-col max-h-[85vh]">
            <div class="flex justify-between items-center border-b pb-3 mb-4"><h3 class="text-lg font-bold text-slate-800" id="kelolaTitle">Kelola Anggota</h3><button type="button" onclick="tutupKelola()" class="text-slate-400 text-xl">&times;</button></div>
            <div class="overflow-y-auto flex-1 pr-2 space-y-2" id="kelolaList"></div>
            <div class="mt-4 pt-4 border-t text-right"><button type="button" onclick="tutupKelola()" class="px-4 py-2 bg-slate-100 rounded-md text-sm font-medium">Tutup</button></div>
        </div>
    </div>

    <!-- MODAL OPSI (ZAT & TEMPAT REHAB) -->
    <div id="modalTambahOpsi" class="fixed inset-0 z-[70] hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-sm p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-4" id="modalOpsiTitle">Tambah Data Baru</h3>
            <input type="hidden" id="modalOpsiKategori">
            <input type="text" id="modalOpsiNilai" placeholder="Ketik nama zat/tempat di sini..." class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 mb-4">
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modalTambahOpsi').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-md text-sm font-bold">Batal</button>
                <button type="button" onclick="simpanOpsiBaru()" id="btnSimpanOpsi" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-bold">Simpan</button>
            </div>
        </div>
    </div>
    <div id="modalKelolaOpsi" class="fixed inset-0 z-[65] hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6 flex flex-col max-h-[80vh]">
            <div class="flex justify-between items-center border-b pb-3 mb-4"><h3 class="text-lg font-bold text-slate-800" id="kelolaOpsiTitle">Kelola Opsi</h3><button type="button" onclick="document.getElementById('modalKelolaOpsi').classList.add('hidden')" class="text-slate-400 font-bold text-xl hover:text-red-500">&times;</button></div>
            <div class="overflow-y-auto flex-1 space-y-2" id="kelolaOpsiList"></div>
            <div class="mt-4 pt-4 border-t text-right"><button type="button" onclick="document.getElementById('modalKelolaOpsi').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-md text-sm font-bold">Tutup</button></div>
        </div>
    </div>


    <!-- JAVASCRIPT LOGIC -->
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
        // === FITUR ZAT, TEMPAT REHAB, & DIAGNOSIS DINAMIS ===
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
                    <label class="flex items-center gap-2 cursor-pointer mb-1 text-sm font-medium text-slate-700 hover:bg-slate-100 p-1 rounded">
                        <input type="checkbox" value="${z.nilai}" ${isChecked} onchange="updateZatTerpilih()" class="rounded text-blue-600 focus:ring-blue-500">
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
                    <div class="flex justify-between items-center p-2 border-b border-slate-100 hover:bg-slate-50">
                        <span class="text-sm font-medium text-slate-700">${item.nilai}</span>
                        <button type="button" onclick="hapusOpsiPermanen(${item.id}, '${kategori}')" class="text-red-500 hover:text-red-700 text-xs font-bold px-2">Hapus</button>
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
                        <div class="relative p-3 bg-blue-50 border border-blue-200 rounded-lg shadow-sm">
                            <button type="button" onclick="hapusMedis(${p.id})" class="absolute top-2 right-2 text-red-500 font-bold bg-red-100 rounded-full w-6 h-6 hover:bg-red-200">&times;</button>
                            <p class="font-bold text-sm text-blue-900">${p.nama}</p>
                            <p class="text-xs text-blue-700 mt-0.5">NIP/SIP: ${p.nip_nrp_sip || '-'}</p>
                            <p class="text-xs text-blue-700">Jabatan: ${p.jabatan || '-'}</p>
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
                        <div class="relative p-3 bg-slate-50 border border-slate-300 rounded-lg shadow-sm">
                            <button type="button" onclick="hapusHukum(${p.id})" class="absolute top-2 right-2 text-red-500 font-bold bg-red-100 rounded-full w-6 h-6 hover:bg-red-200">&times;</button>
                            <p class="font-bold text-sm text-slate-800">${p.nama}</p>
                            ${p.pangkat ? `<p class="text-xs text-slate-600 mt-0.5">Pangkat: ${p.pangkat}</p>` : ''}
                            <p class="text-xs text-slate-600 mt-0.5">NIP/NRP: ${p.nip_nrp_sip || '-'}</p>
                            <p class="text-xs text-slate-600">Jabatan: ${p.jabatan || '-'}</p>
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
            else if (selectedMedis.length >= 2) { alert('Maks. 2 orang.'); this.value = ''; }
        });

        document.getElementById('select-hukum').addEventListener('change', function() {
            if(this.value && selectedHukum.length < 3) { selectedHukum.push(parseInt(this.value)); renderHukum(); }
            else if (selectedHukum.length >= 3) { alert('Maks. 3 orang.'); this.value = ''; }
        });

        function hapusMedis(id) { selectedMedis = selectedMedis.filter(x => x !== id); renderMedis(); }
        function hapusHukum(id) { selectedHukum = selectedHukum.filter(x => x !== id); renderHukum(); }

        function bukaModal(k) {
            document.getElementById('modalKategori').value = k;
            document.getElementById('modalTitle').innerText = k === 'medis' ? 'Tambah Dokter' : 'Tambah Hukum';
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
                    <div class="flex justify-between items-center p-2 border-b hover:bg-slate-50">
                        <div><p class="font-bold text-sm text-slate-800">${p.nama}</p><p class="text-xs text-slate-500">${p.nip_nrp_sip || '-'} | ${p.jabatan || '-'}</p></div>
                        <button type="button" onclick="hapusPermanen(${p.id}, '${kategori}')" class="text-red-600 font-bold text-xs hover:text-red-800">Hapus</button>
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