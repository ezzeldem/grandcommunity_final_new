<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->truncate();
        $status=[['en'=>'OutOfCountry','ar'=>'خارج الدولة'],['en'=>'Vip','ar'=>'Vip'],['en'=>'Delivery_Only','ar'=>'توصيل فقط']];//add status here
        $value=[1,2,3];//array of Value
        $path = ['out_of_country.png','vip.png','only_delivered.png'];
        for ($i=0;$i< count($value);$i++){
            Status::create([
                'name' => $status[$i],
                'value' => $value[$i],
                'type' => 'influencer',
                'path'=>$path[$i]
            ]);
        }
        $camp_status=[['en'=>'Pending','ar'=>'المعلقة'],['en'=>'Active','ar'=>'نشط'],['en'=>'Finished','ar'=>'المكتملة'],['en'=>'Canceled','ar'=>'الملغاة'],['en'=>'Upcoming','ar'=>'القادمة'],['en'=>'Drafted','ar'=>'المؤرشفة']];//add status here
        $camp_value=[0,1,2,3,4,5];
        $campa_value  = [];
        for ($i=0;$i< count($camp_value);$i++){
            Status::create([
                'name' => $camp_status[$i],
                'value' => $camp_value[$i],
                'type' => 'campaign'
            ]);
        }
//'Traveling','No Chat', 'Cancel From community','paid ads','Block', 'No Response',
        $camp_influ_status=[['en'=>'Pending','ar'=>'المعلقة'], ['en'=>'Confirmed','ar'=>'المؤكدة'],['en'=>'Visit','ar'=>'زيارة'] ,['en'=>'Missed Visit','ar'=>'الفائتة'],['en'=>'Canceled','ar'=>'ملغاة'],['en'=>'Waiting','ar'=>'قيد الانتظار'],['en'=>'InCorrect','ar'=>'غير صحيح'],['en'=>'Posted','ar'=>'تم النشر']];
        $camp_influ_value=[0,1,2,3,4,5,6,7];
        for ($i=0;$i< count($camp_influ_value);$i++){
            Status::create([
                'name' => $camp_influ_status[$i],
                'value' => $camp_influ_value[$i],
                'type' => 'campaign_influencers'
            ]);
        }

        $operation_status=[['en'=>'Operation','ar'=>'العمليات'], ['en'=>'Coordination','ar'=>'التنسيق'],['en'=>'Community' ,'ar'=>'Community'],['en'=>'Coverage','ar'=>'التغطية'],['en'=>'Quality','ar'=>'الجودة'],['en'=>'Whatsapp','ar'=>'واتساب']];
        $operation_value=[0,1,2,3,4,5];
        for ($i=0;$i< count($operation_value);$i++){
            Status::create([
                'name' => $operation_status[$i],
                'value' => $operation_value[$i],
                'type' => 'operation'
            ]);
        }
    }
}
