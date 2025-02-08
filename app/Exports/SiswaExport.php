<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\Users\Siswa;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class SiswaExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithEvents
{
    use Exportable;

    protected $kelasBimbelId;

    public function __construct($kelasBimbelId)
    {
        $this->kelasBimbelId = $kelasBimbelId;
    }

    public function query()
    {
        return Siswa::query()
            ->with(['cabang', 'kelasBimbel'])
            ->when($this->kelasBimbelId, function ($query) {
                $query->where('kelas_bimbel_id', $this->kelasBimbelId);
            });
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'Email',
            'Asal Sekolah',
            'No. Telepon',
            'Cabang',
            'Kelas Bimbel',
            'Tanggal Bergabung',
            'Status'
        ];
    }

    public function map($siswa): array
    {
        return [
            $siswa->nama_lengkap,
            $siswa->email,
            $siswa->asal_sekolah,
            $siswa->no_telepon,
            $siswa->cabang->nama ?? '-',
            $siswa->kelasBimbel->nama_kelas ?? '-',
            $siswa->created_at->format('d/m/Y'),
            $siswa->status
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 90,
                    'startColor' => [
                        'argb' => 'FF4F46E5', // Indigo color
                    ],
                    'endColor' => [
                        'argb' => 'FF7C3AED', // Violet color
                    ],
                ],
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FFFFFFFF'],
                ],
            ],
            'A2:F' . ($sheet->getHighestRow()) => [
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30, // Nama Lengkap
            'B' => 35, // Email
            'C' => 20, // No. Telepon
            'D' => 25, // Cabang
            'E' => 25, // Kelas Bimbel
            'F' => 20, // Tanggal Bergabung
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Auto-fit semua kolom
                foreach ($sheet->getColumnIterator() as $column) {
                    $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
                }

                // Tambahkan border untuk semua cell yang berisi data
                $lastRow = $sheet->getHighestRow();
                $lastColumn = $sheet->getHighestColumn();

                $sheet->getStyle('A1:' . $lastColumn . $lastRow)->getBorders()->getAllBorders()->setBorderStyle('thin');

                // Set row height
                $sheet->getDefaultRowDimension()->setRowHeight(20);
                $sheet->getRowDimension(1)->setRowHeight(30);

                // Freeze pane pada header
                $sheet->freezePane('A2');

                // Aktifkan filter
                $sheet->setAutoFilter('A1:' . $lastColumn . $lastRow);

                // Wrap text untuk menghindari text yang terlalu panjang
                $sheet->getStyle('A1:' . $lastColumn . $lastRow)->getAlignment()->setWrapText(true);
            },
        ];
    }
}
