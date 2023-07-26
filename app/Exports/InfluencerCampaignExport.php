<?php

namespace App\Exports;

use App\Models\Campaign;
use App\Models\CampaignInfluencer;
use App\Models\Influencer;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;
use App\Http\Resources\Admin\InfluencerResource;


class InfluencerCampaignExport implements FromCollection,WithHeadings,WithEvents,WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
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

    public function __construct($request)
    {
        $this->request=$request;
    }


    public function collection()
    {
        $campId = $this->request;
        $filter = request()->only(['country_val', 'campaign_type_val', 'camp_sub_type', 'qrcode_search_form_input', 'visitCheck', 'qrCheck', 'rateCheck', 'brief', 'coverage_status', 'custom']);
        $campaignInfluencers = Influencer::with('user')->whereHas('campaignInfluencer', function ($q) use ($filter, $campId) {
            $q->where('campaign_id', (int) $campId)->filter($filter);
        })->get();

        $data = $campaignInfluencers->map(function ($q){
            return[
                'name'=>$q->name,
                'user_name'=>$q->user->user_name,
                'qrcode'=>$q->qrcode,
                'code'=>$q->influ_code,
            ];
        });
        return $data;


    }

    public function headings(): array
    {
		$arrs = [ 'name', 'user_name', 'qrcode', 'code'];
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
