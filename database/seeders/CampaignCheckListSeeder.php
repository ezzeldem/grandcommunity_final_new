<?php

namespace Database\Seeders;

use App\Models\CampaignCheckList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
class CampaignCheckListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $chick_list = new Collection (['Starting & ending dates','Target Number Of Influencer','Influencer List "Double the Target" ','Dashboard Username"Influencer 365"','Instagram Due Date','Target Gender "M,F or Mix"',"Number of Influencers per day if there`s daily target",'Bilingual Brief','Campaign Type "Delivery,Visit or Mix (online)"',
         'Branches Locations details and addresses  and links if possible','Images For the shopes if possible',
         'Delivery Gift details','Visit Gift details','Visit Timing From xx am to xx pm','Delivery Timing From xx am to xx pm','For Visit How Many people Allowed With the Influencer','WhatsApp Group For The Campaing','Make Sure Client at the Group','Dropbox links for Confirmations','could Coverage link','share the Dropbox & p-could link with IT to create the campaign at the system',
         'create the campaign at the system','send the video system at the group with the test codes','Make Sure the Client test the codes at the system and remove it before start the campaign','Generate QR code List','Bilingual invetations','Invetations Starting date and timing','invetations deadline to Achieve the target','share the links over the Whatsapp','Create the Final report',
         'Match the system report with the Excel sheet','Campaign business','Influencer discount'
        ]);
        \DB::table('campaign_check_lists')->truncate();
 
        $chick_list->each(function ($item, $index) {
           CampaignCheckList::create(['name'=>$item]);
        });
    }
}
