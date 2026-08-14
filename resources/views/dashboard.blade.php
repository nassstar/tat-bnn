<x-app-layout>
    <!-- Tambahkan library Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-8 sm:py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- ========================================== -->
            <!-- 1. HEADER HERO DASHBOARD -->
            <!-- ========================================== -->
            <div class="bg-gradient-to-r from-indigo-800 to-blue-700 rounded-3xl p-8 sm:p-10 shadow-lg text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
                <!-- Ornamen Latar Belakang -->
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-48 h-48 bg-white opacity-10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-32 -mb-10 w-32 h-32 bg-blue-400 opacity-20 rounded-full blur-2xl"></div>
                
                <div class="relative z-10">
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-900/50 border border-indigo-500/30 text-indigo-100 text-xs font-semibold mb-4 tracking-wide uppercase">
                        Command Center TAT
                    </div>
                    <h2 class="font-extrabold text-3xl sm:text-4xl tracking-tight mb-2">Dashboard Analisis BNN</h2>
                    <p class="text-indigo-100 text-sm sm:text-base max-w-2xl leading-relaxed">
                        Selamat datang, <strong>{{ explode(' ', Auth::user()->name)[0] }}</strong>. Berikut adalah ringkasan performa Tim Asesmen Terpadu dan tren peredaran narkotika untuk membantu pengambilan keputusan strategis.
                    </p>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- 2. KPI CARDS (KEY PERFORMANCE INDICATORS) -->
            <!-- ========================================== -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Klien -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden group hover:border-indigo-300 transition-colors">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-indigo-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Klien Terdaftar</p>
                            <h3 class="text-3xl font-extrabold text-slate-800">{{ number_format($totalKlien) }}</h3>
                        </div>
                        <div class="p-3 bg-indigo-100 text-indigo-600 rounded-xl">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Kasus Menunggu TAT -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden group hover:border-amber-300 transition-colors">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-amber-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Menunggu Sidang TAT</p>
                            <h3 class="text-3xl font-extrabold text-slate-800">{{ number_format($menungguTAT) }}</h3>
                            <p class="text-[10px] text-amber-600 font-bold mt-1 bg-amber-100 inline-block px-2 py-0.5 rounded">Butuh Tindakan</p>
                        </div>
                        <div class="p-3 bg-amber-100 text-amber-600 rounded-xl">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Kasus Selesai -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden group hover:border-emerald-300 transition-colors">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Selesai Diasesmen</p>
                            <h3 class="text-3xl font-extrabold text-slate-800">{{ number_format($selesaiTAT) }}</h3>
                        </div>
                        <div class="p-3 bg-emerald-100 text-emerald-600 rounded-xl">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Total Barang Bukti -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden group hover:border-rose-300 transition-colors">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-rose-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Bukti Disita</p>
                            <h3 class="text-3xl font-extrabold text-slate-800">{{ number_format($totalBB, 1, ',', '.') }} <span class="text-base font-bold text-slate-500">Gram</span></h3>
                        </div>
                        <div class="p-3 bg-rose-100 text-rose-600 rounded-xl">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- 3. GRAFIK ANALISIS UTAMA -->
            <!-- ========================================== -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Grafik: Tren Narkotika (Doughnut Chart) -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="font-extrabold text-slate-800 text-lg">Peta Kerawanan Narkotika</h3>
                            <p class="text-[12px] text-slate-500">Distribusi 5 jenis zat yang paling banyak disalahgunakan.</p>
                        </div>
                    </div>
                    <div class="relative h-64 w-full">
                        <canvas id="chartNarkotika"></canvas>
                    </div>
                </div>

                <!-- Grafik: Rekomendasi Rehabilitasi (Bar Chart) -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="font-extrabold text-slate-800 text-lg">Tren Rekomendasi TAT</h3>
                            <p class="text-[12px] text-slate-500">Keputusan akhir tempat penempatan rehabilitasi klien.</p>
                        </div>
                    </div>
                    <div class="relative h-64 w-full">
                        <canvas id="chartRehab"></canvas>
                    </div>
                </div>

            </div>

            <!-- ========================================== -->
            <!-- 4. ANALISIS DEMOGRAFI & DAFTAR KERJA -->
            <!-- ========================================== -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                
                <!-- Kolom Kiri: Demografi Cepat -->
                <div class="xl:col-span-1 space-y-6">
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                        <h3 class="font-extrabold text-slate-800 mb-4 border-b border-slate-100 pb-2">Demografi Gender Klien</h3>
                        <div class="space-y-4">
                            @foreach($demografiGender as $gender)
                                <div>
                                    <div class="flex justify-between text-sm mb-1 font-bold text-slate-700">
                                        <span>{{ $gender->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</span>
                                        <span>{{ $gender->total }} Orang</span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2.5">
                                        <div class="bg-{{ $gender->jenis_kelamin == 'L' ? 'blue' : 'rose' }}-500 h-2.5 rounded-full" style="width: {{ ($totalKlien > 0) ? ($gender->total / $totalKlien) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                        <h3 class="font-extrabold text-slate-800 mb-4 border-b border-slate-100 pb-2">Status Hukum (Tersangka/Saksi)</h3>
                        <div class="space-y-3">
                            @foreach($statusHukum as $sh)
                                <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl border border-slate-100">
                                    <span class="text-sm font-bold text-slate-700 uppercase">{{ $sh->status_hukum }}</span>
                                    <span class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-xs font-bold text-indigo-600 shadow-sm">{{ $sh->total }} Kasus</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Kasus To-Do List / Terbaru -->
                <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                        <div>
                            <h3 class="font-extrabold text-slate-800 text-lg">Aktivitas Asesmen Terbaru</h3>
                            <p class="text-[12px] text-slate-500 mt-0.5">5 klien terakhir yang terdaftar dalam sistem.</p>
                        </div>
                        <a href="{{ route('asesmen.index') }}" class="text-xs font-bold text-indigo-600 bg-white border border-indigo-200 px-4 py-2 rounded-lg hover:bg-indigo-50 shadow-sm transition-colors">Lihat Semua Data &rarr;</a>
                    </div>
                    
                    <div class="flex-1 overflow-x-auto p-2">
                        <table class="w-full text-left">
                            <tbody>
                                @forelse($kasusTerbaru as $kasus)
                                    <tr class="hover:bg-slate-50 transition-colors group border-b border-slate-100 last:border-0">
                                        <td class="p-4 align-top">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-100 to-blue-200 text-indigo-700 font-bold flex items-center justify-center border border-indigo-200 shrink-0">
                                                    {{ strtoupper(substr($kasus->nama_lengkap, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <p class="font-bold text-slate-900 text-sm group-hover:text-indigo-600 transition-colors">{{ $kasus->nama_lengkap }}</p>
                                                    <p class="text-xs text-slate-500 mt-0.5">No. Reg: <span class="font-semibold">{{ $kasus->no_register ?? '-' }}</span></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-4 align-middle">
                                            @if($kasus->pelaksanaan == 'YA')
                                                <span class="inline-flex px-2.5 py-1 rounded-md text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase tracking-wider">Selesai TAT</span>
                                            @else
                                                <span class="inline-flex px-2.5 py-1 rounded-md text-[10px] font-extrabold bg-amber-50 text-amber-700 border border-amber-200 uppercase tracking-wider">Menunggu TAT</span>
                                            @endif
                                        </td>
                                        <td class="p-4 align-middle text-right">
                                            <a href="{{ route('asesmen.show', $kasus->id) }}" class="inline-flex items-center px-3 py-1.5 bg-white border border-slate-300 text-slate-600 rounded-lg text-xs font-bold hover:bg-slate-100 hover:text-slate-900 transition-all shadow-sm">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="p-8 text-center text-slate-500 font-medium text-sm">Belum ada data klien yang diinput ke dalam sistem.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- ========================================== -->
    <!-- SCRIPT RENDER GRAFIK (CHART.JS) -->
    <!-- ========================================== -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Data untuk Tren Narkotika (Doughnut)
            const narkotikaData = @json($trenNarkotika);
            const narkotikaLabels = narkotikaData.map(item => item.nama || 'Tidak Diketahui');
            const narkotikaValues = narkotikaData.map(item => item.total);
            
            // Konfigurasi Chart Peta Kerawanan Narkotika
            new Chart(document.getElementById('chartNarkotika'), {
                type: 'doughnut',
                data: {
                    labels: narkotikaLabels,
                    datasets: [{
                        data: narkotikaValues,
                        backgroundColor: [
                            '#4f46e5', // Emerald
                            '#06b6d4', // Teal
                            '#f59e0b', // Amber
                            '#ec4899', // Pink
                            '#8b5cf6', // Purple
                        ],
                        borderWidth: 2,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right', labels: { usePointStyle: true, boxWidth: 8, font: { size: 11, family: "'Inter', sans-serif" } } }
                    },
                    cutout: '65%'
                }
            });

            // Data untuk Rekomendasi (Bar)
            const rehabData = @json($rekomendasiRehab);
            const rehabLabels = rehabData.map(item => item.rekomendasi_input || 'Lainnya');
            const rehabValues = rehabData.map(item => item.total);

            // Konfigurasi Chart Tren Rekomendasi
            new Chart(document.getElementById('chartRehab'), {
                type: 'bar',
                data: {
                    labels: rehabLabels,
                    datasets: [{
                        label: 'Jumlah Klien',
                        data: rehabValues,
                        backgroundColor: '#6366f1', // Indigo 500
                        borderRadius: 6,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0, font: { size: 11 } },
                            grid: { color: '#f1f5f9' }
                        },
                        x: {
                            ticks: { font: { size: 10 } },
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>