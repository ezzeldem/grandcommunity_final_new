<?php

namespace App\Exports;

use App\Models\City;
use App\Models\Country;
use App\Models\Influencer;
use App\Models\InfluencerClassification;
use App\Models\InfluencerPhone;
use App\Models\Nationality;
use App\Models\State;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;
use App\Http\Resources\Admin\InfluencerResource;


class InfluencerExport implements FromCollection,WithHeadings,WithEvents,WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $visibleColumns;
    protected $selected_ids;
    protected $request;

    public function columnFormats(): array
    {
        return [
            'N' => "###-###-####"
        ];
    }
    public function styles(Worksheet $sheet)
{
    return [

        1    => ['font' => ['bold' => true]],
    ];
}

    public function __construct($visibleColumns, $selected_ids,$request)
    {
        $this->visibleColumns = $visibleColumns;
        $this->selected_ids = $selected_ids;
        $this->request=$request;
    }


    public function collection()
    {
		$influencers = clone (Influencer::select('influencers.*')->with(['country']));
		if(!empty($this->selected_ids))
		       $influencers = $influencers->whereIn('influencers.id',$this->selected_ids);

		$influencers = $influencers->orderBy('id', 'DESC')->dtFilter(session('filter_datatables_values', []))->distinct()->groupBy('influencers.id')->take(30000)->cursor();
          $data = InfluencerResource::collection($influencers);
        return $data;
    }

    public function headings(): array
    {
		$arrs = ['status', 'user_name', 'name', 'email', 'primary_phone', 'primary_whatsapp', 'call_phones', 'whatsapp_phones', 'office_phones', 'nationality', 'gender', 'date_of_birth', 'marital_status', "language", "country", "state", "city", "address_ar", "address_en", 'children_number', 'children_info', 'instagram_username','snapchat_username','tiktok_username','facebook_username','twitter_username', 'account_type', 'categories', 'classifications', 'coverage_platform', 'interests', 'image_path'];
       return $arrs;
    }

    public function registerEvents(): array
    {
        $styleArray = ['font' => ['bold' => true]];

        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->getSheet()->getDelegate()->getStyle('A1:AK1')->getFont()->setName('Calibri')->setSize(15);
                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(17);
                $event->sheet->getDelegate()->getStyle('A1:AK1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
               // $event->sheet->getDelegate()->getStyle('A1:AK1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                // ->getStartColor()->set('FFFFF');
                foreach ($this->coloumns() as $charachter) {
                    $event->sheet->getDelegate()->getColumnDimension($charachter)->setWidth(50);
                }
            },
            ];
    }


    public function coloumns()
    {
        return ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z', 'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK'];
    }

    public function coloumnvisabilty()
    {
        $arrvisability = [];
        $columns = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        foreach($this->visibleColumns as $key => $elem){
           array_push($arrvisability,$columns[$key]);
        }
        return $arrvisability;
    }
}
