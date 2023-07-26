<?php

namespace App\Exports;

use App\Models\Brand;
use App\Models\BrandDislike;
use App\Models\GroupList;
use App\Models\Influencer;
use App\Models\InfluencerGroup;
use App\Repository\InfluencerRepository;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;
use App\Http\Resources\Admin\InfluencerResource;


class WishlistExport implements FromCollection,WithHeadings,WithEvents,WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $request;
    protected $influencerQuery;
    protected $brandData;

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

    public function __construct($influencerQuery, $brandData, $request)
    {
       $this->influencerQuery = $influencerQuery;
        $this->request=$request;
        $this->brandData = $brandData;
    }


    public function collection()
    {
        $influencersGroups = $this->influencerQuery->get();
        $brandData = $this->brandData;
        $data = $influencersGroups->map(function ($q) use ($brandData) {

            return[
                'name'=>$q->name,
                'user_name'=>$q->user->user_name,
                'insta_uname'=>$q->insta_uname,
                'snapchat_uname'=>$q->snapchat_uname,
                'tiktok_uname'=>$q->tiktok_uname,
				'twitter_uname'=>$q->twitter_uname,
				// 'groups'=>'',//($wishlist) ? $wishlist['groups'] : [],
                'groups'=>implode(',', $q->getJoinGroupsByBrandId($brandData->id)['groups']->pluck('name')->toArray()),
			    'created_at'=>$q->created_at,
				//'visited_campaign'=>1,
                'qrcode'=>$q->qrcode,
                'influ_code'=>$q->influ_code,
            ];
        });
        return $data;


    }

    public function headings(): array
    {
		$arrs = [ 'name', 'user_name', 'instagram_user', 'snapchat_users', 'tiktok_uname','twitter_uname','groups', 'created_at', 'qrcode', 'influ_code'];
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
