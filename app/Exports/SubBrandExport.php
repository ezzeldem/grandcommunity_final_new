<?php

namespace App\Exports;

use App\Models\Country;
use App\Models\Subbrand;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SubBrandExport implements FromCollection, WithHeadings, WithEvents, WithColumnFormatting
{
    protected $visibleColumns;
    protected $selected_ids;
    protected $brand_id;

    public function columnFormats(): array
    {
        return [
            'N' => '###-###-####',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function __construct($visibleColumns, $selected_ids, $brand_id)
    {
        $this->visibleColumns = $visibleColumns;
        $this->selected_ids = $selected_ids;
        $this->brand_id = $brand_id;
    }

    public function collection()
    {
        if ($this->brand_id) {
            $subBrand = Subbrand::when($this->selected_ids && !empty($this->selected_ids), function ($q) {
                return $q->whereIn('id', $this->selected_ids);
            })
                ->where('brand_id', $this->brand_id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $subBrand = Subbrand::when($this->selected_ids && !empty($this->selected_ids), function ($q) {
                return $q->whereIn('id', $this->selected_ids);
            })
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $data = $subBrand->transform(function ($q) {
            return [
                'name' => $q->name,
                'preferred_gender' => $q->preferred_gender,
                'brand_name' => @$q->brand->name ?? 'not found',
                'status' => $q->status == 0 ? 'InActive' : 'Active',
                'branches' => $q->branches ? implode(', ', $q->branches->pluck('name')->toArray()) : '',
                'code_phone' => @$q->code_phone,
                'phone' => @$q->phone,
                'code_whats' => @$q->code_whats,
                'whats_app' => $q->whats_number,
                'expiration_date' => $q->expirations_date,
                'countries' => $q->country_id
                    ? implode(
                        ', ',
                        Country::whereIn('id', $q->country_id)
                            ->get()
                            ->pluck('name')
                            ->toArray(),
                    )
                    : '',
                'insta_uname' => $q->link_insta,
                'facebook_uname' => $q->link_facebook,
                'tiktok_uname' => $q->link_tiktok,
                'snapchat_uname' => $q->link_snapchat,
                'twitter_uname' => $q->link_twitter,
                'website_uname' => $q->link_website,
                'created_at' => $q->created_at,
                'image' => $q->image,
            ];
        });
        return $data;
    }

    public function headings(): array
    {
        $arrs = ['name', 'preferred_gender', 'brand_name', 'status', 'branches', 'code_phone', 'phone', 'code_whats', 'whats_app', 'expiration_date', 'countries', 'insta_uname', 'facebook_uname', 'tiktok_uname', 'snapchat_uname', 'twitter_uname', 'website_uname', 'created_at', 'image'];
        return $arrs;
    }

    public function registerEvents(): array
    {
        $styleArray = ['font' => ['bold' => true]];

        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event
                    ->getSheet()
                    ->getDelegate()
                    ->getStyle('A1:AK1')
                    ->getFont()
                    ->setName('Calibri')
                    ->setSize(15);
                $event->sheet
                    ->getDelegate()
                    ->getRowDimension('1')
                    ->setRowHeight(17);
                $event->sheet
                    ->getDelegate()
                    ->getStyle('A1:AK1')
                    ->getFont()
                    ->getColor()
                    ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                foreach ($this->coloumns() as $charachter) {
                    $event->sheet
                        ->getDelegate()
                        ->getColumnDimension($charachter)
                        ->setWidth(50);
                }
            },
        ];
    }

    public function coloumns()
    {
        return ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK'];
    }

    public function coloumnvisabilty()
    {
        $arrvisability = [];
        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        foreach ($this->visibleColumns as $key => $elem) {
            array_push($arrvisability, $columns[$key]);
        }
        return $arrvisability;
    }
}