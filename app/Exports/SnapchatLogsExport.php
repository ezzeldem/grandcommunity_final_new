<?php

namespace App\Exports;

use App\Models\LogSnapchat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SnapchatLogsExport implements FromCollection, WithHeadings, WithEvents, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function columnFormats(): array
    {
        return [
            'N' => "###-###-####",
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [

            1 => ['font' => ['bold' => true]],
        ];
    }

    public function collection()
    {
        $influencer_id = request()->influencer_id;
        $snapchat_logs = LogSnapchat::where('snapchat_id', $influencer_id)->get();

        $data = $snapchat_logs->transform(function ($q) {
            return [
                'date' => $q->created_at,
                'followers' => $q->followers,
                'uploads' => $q->uploads,
            ];
        });
        return $data;
    }

    public function headings(): array
    {
        return ['Date', 'Followers', 'Following', 'Uploads'];
    }

    public function registerEvents(): array
    {
        $styleArray = ['font' => ['bold' => true]];

        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->getSheet()->getDelegate()->getStyle('A1:AK1')->getFont()->setName('Calibri')->setSize(15);
                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(17);
                $event->sheet->getDelegate()->getStyle('A1:AK1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                foreach ($this->coloumns() as $charachter) {
                    $event->sheet->getDelegate()->getColumnDimension($charachter)->setWidth(50);
                }
            },
        ];
    }

    public function coloumns()
    {
        return ['A', 'B', 'C', 'D'];
    }
}
