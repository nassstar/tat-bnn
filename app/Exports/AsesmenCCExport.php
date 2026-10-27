<?php

namespace App\Exports;

use App\Models\Asesmen;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AsesmenCCExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithCustomStartCell, WithTitle, WithEvents
{
    protected $request;
    protected $rowNumber = 1;

    public function __construct($request)
    {
        $this->request = $request instanceof Request ? $request : new Request($request);
    }

    public function query()
    {
        if ($this->request->get('search') === 'XXXXXXXXX_EMPTY_TEMPLATE_XXXXXXXXX') {
            return Asesmen::whereNull('id');
        }

        $query = Asesmen::query()->with(['narkotika', 'pendidikan', 'pekerjaan', 'rekomendasi']);

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('no_register', 'like', "%{$search}%")
                  ->orWhere('no_lkn', 'like', "%{$search}%");
            });
        }
        if ($this->request->filled('bulan')) {
            $query->whereMonth('tgl_pelaksanaan', $this->request->bulan);
        }
        if ($this->request->filled('tahun')) {
            $query->whereYear('tgl_pelaksanaan', $this->request->tahun);
        }
        if ($this->request->filled('narkotika')) {
            $query->where('narkotika_id', $this->request->narkotika);
        }
        if ($this->request->filled('status')) {
            $query->where('pelaksanaan', strtoupper($this->request->status));
        }

        $sort = $this->request->get('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->oldest('created_at');
        } elseif ($sort === 'a-z') {
            $query->orderBy('nama_lengkap', 'asc');
        } elseif ($sort === 'z-a') {
            $query->orderBy('nama_lengkap', 'desc');
        } else {
            $query->latest('created_at');
        }

        return $query;
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function title(): string
    {
        return 'Data Case Conference';
    }

    public function headings(): array
    {
        return [
            ['DATA CASE CONFERENCE TAHUN ' . date('Y')], // Baris 1
            [
                'NO', 'NAMA KLIEN', 'NIK', 'USIA', 'P/L', 'PEKERJAAN', 'PENDIDIKAN TERAKHIR', 'DOMISILI', 
                'HUKUM', '', '', '', '', 
                'MEDIS', '', '', 
                'ALASAN PENGGUNAAN', 'KONDISI KELUARGA', 'TINGKAT KETERGANTUNGAN', 'POLA PEMAKAIAN', 
                'KONDISI LINGKUNGAN', 'REKOMENDASI', 'KETERANGAN', 'SARAN', '', '', '' // Y-AA dikosongi untuk merge SARAN
            ],
            [
                '', '', '', '', '', '', '', '', 
                'STATUS HUKUM', 'KETERLIBATAN JARINGAN', 'BARANG BUKTI', 'CARA MENDAPATKAN', 'DAPAT DARI SIAPA',
                'KESEHATAN', 'PSIKOLOGI', 'TES URINE',
                '', '', '', '', '', '', '', 
                '1', '2', '3', '4' // Empat kolom anak untuk SARAN (X, Y, Z, AA)
            ]
        ];
    }

    public function map($asesmen): array
    {
        $usia = '-';
        if ($asesmen->tgl_lahir) {
            try {
                $usia = \Carbon\Carbon::parse($asesmen->tgl_lahir)->diff(\Carbon\Carbon::parse($asesmen->created_at ?? now()))->y;
            } catch (\Exception $e) {}
        }

        $nik = $asesmen->nik ? "'" . $asesmen->nik : '-';

        // Pecah saran yang disimpan dengan koma di database
        $saranString = $asesmen->saran_case_conference ?? '';
        $saranArray = array_map('trim', explode(',', $saranString));
        
        $saran1 = isset($saranArray[0]) && $saranArray[0] !== '' ? $saranArray[0] : '-';
        $saran2 = isset($saranArray[1]) && $saranArray[1] !== '' ? $saranArray[1] : '-';
        $saran3 = isset($saranArray[2]) && $saranArray[2] !== '' ? $saranArray[2] : '-';
        $saran4 = isset($saranArray[3]) && $saranArray[3] !== '' ? $saranArray[3] : '-';

        return [
            $this->rowNumber++,
            $asesmen->nama_lengkap ?? '-',
            $nik,
            $usia,
            $asesmen->jenis_kelamin ?? '-',
            $asesmen->pekerjaan_input ?? $asesmen->pekerjaan->nama_pekerjaan ?? '-',
            $asesmen->pendidikan_input ?? $asesmen->pendidikan->nama_pendidikan ?? '-',
            $asesmen->alamat_domisili ?? '-',
            
            $asesmen->status_hukum ?? '-',
            $asesmen->keterlibatan_jaringan ?? '-',
            $asesmen->deskripsi_bb ?? $asesmen->barang_bukti ?? '-',
            $asesmen->cara_mendapatkan ?? '-',
            $asesmen->dapat_dari_siapa ?? $asesmen->dapat_dari ?? '-',
            
            $asesmen->kesehatan_fisik ?? $asesmen->kesehatan ?? '-',
            $asesmen->psikologi ?? '-',
            $asesmen->tes_urine ?? '-',
            
            $asesmen->alasan_penggunaan ?? '-',
            $asesmen->kondisi_keluarga ?? '-',
            $asesmen->tingkat_ketergantungan ?? '-',
            $asesmen->pola_pemakaian ?? '-',
            $asesmen->kondisi_lingkungan ?? '-',
            $asesmen->rekomendasi_input ?? optional($asesmen->rekomendasi)->tempat_rehabilitasi ?? '-',
            $asesmen->rekomendasi_keterangan ?? '-',
            
            // Empat kolom saran
            $saran1,
            $saran2,
            $saran3,
            $saran4,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                // MERGE TITLE (A1 s/d AA1)
                $sheet->mergeCells('A1:AA1');

                // MERGE HEADER VERTIKAL (Baris 2 dan 3)
                $colToMergeVertical = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'Q', 'R', 'S', 'T', 'U', 'V', 'W'];
                foreach ($colToMergeVertical as $col) {
                    $sheet->mergeCells($col.'2:'.$col.'3');
                }

                $sheet->mergeCells('I2:M2'); // HUKUM
                $sheet->mergeCells('N2:P2'); // MEDIS
                $sheet->mergeCells('X2:AA2'); // SARAN (Gabung 4 Kolom: X, Y, Z, AA)

                // STYLING TITLE
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFD9D9D9']
                    ],
                ]);

                // STYLING HEADER
                $headerStyle = [
                    'font' => ['bold' => true, 'size' => 11],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFE2EFDA'] // Hijau Pudar
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000']
                        ]
                    ]
                ];
                $sheet->getStyle('A2:AA3')->applyFromArray($headerStyle);

                // KHUSUS MEWARNAI BIRU UNTUK KOLOM SARAN (Persis Gambar Anda)
                $sheet->getStyle('X2:AA3')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFA9C8F5'); // Biru pastel seperti di gambar

                // STYLING AREA DATA
                if ($highestRow > 3) {
                    $sheet->getStyle('A4:AA' . $highestRow)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['argb' => 'FF000000']
                            ]
                        ],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_CENTER,
                            'wrapText' => true
                        ]
                    ]);

                    $sheet->getStyle('A4:A' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('C4:E' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                // COLUMN WIDTHS
                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(25);
                $sheet->getColumnDimension('C')->setWidth(20);
                $sheet->getColumnDimension('D')->setWidth(8);
                $sheet->getColumnDimension('E')->setWidth(6);
                $sheet->getColumnDimension('F')->setWidth(20);
                $sheet->getColumnDimension('G')->setWidth(20);
                $sheet->getColumnDimension('H')->setWidth(30);
                
                $sheet->getColumnDimension('I')->setWidth(20);
                $sheet->getColumnDimension('J')->setWidth(25);
                $sheet->getColumnDimension('K')->setWidth(35);
                $sheet->getColumnDimension('L')->setWidth(25);
                $sheet->getColumnDimension('M')->setWidth(20);
                
                $sheet->getColumnDimension('N')->setWidth(25);
                $sheet->getColumnDimension('O')->setWidth(25);
                $sheet->getColumnDimension('P')->setWidth(25);
                
                $sheet->getColumnDimension('Q')->setWidth(25);
                $sheet->getColumnDimension('R')->setWidth(25);
                $sheet->getColumnDimension('S')->setWidth(25);
                $sheet->getColumnDimension('T')->setWidth(25);
                $sheet->getColumnDimension('U')->setWidth(30);
                $sheet->getColumnDimension('V')->setWidth(25);
                $sheet->getColumnDimension('W')->setWidth(35);
                $sheet->getColumnDimension('X')->setWidth(30); // Saran 1
                $sheet->getColumnDimension('Y')->setWidth(30); // Saran 2
                $sheet->getColumnDimension('Z')->setWidth(30); // Saran 3
                $sheet->getColumnDimension('AA')->setWidth(30); // Saran 4
            }
        ];
    }
}