<?php

namespace Database\Seeders;

use App\Models\Statistic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statistics')->delete();
        $statistics = [
            [
                'en_title'=>'Brands',
                'ar_title'=>'علامة تجارية',
                'en_body'=>'Start your success story now, and join over 1000 successful brands, locally and globally, with Grand Community.',
                'ar_body'=>'ابدأ قصة نجاحك الآن، وانضم لأكثر من 1000 علامة تجارية ناجحة محليا وعالميا، مع جراند كومينيتي.',
                'count'=>'1500',
                'image'=>'advertising.png',
                "active"=>1
            ],
            [
                'en_title'=>'Influenecrs',
                'ar_title'=>'مؤثر',
                'en_body'=>'Over 15,000 of the most influential creators and ambassadors in every field.
                            In minutes, find and collaborate with the creators that understand your brand and will help broadcast it to your target customers.',
                'ar_body'=>'أكثر من 15000 من السفراء والمؤثرين في مختلف المجالات.
                            في دقائق، اكتشف وتعاون مع المؤثرين الذين يفهمون علامتك التجارية و سيساعدون في نشرها للفئة المستهدفة من العملاء.',
                'count'=>'12000',
                'image'=>'review.png',
                "active"=>1
            ],
            [
                'en_title'=>'Countries',
                'ar_title'=>'دولة',
                'en_body'=>'Wherever you are, we’re nearby.
                        We manage thousands of campaigns in 15 different countries around the globe, and we’re soon to be expanding.',
                'ar_body'=>'أينما كنت، نحن بالقرب منك
                            نتواجد ونعمل على إدارة الآف الحملات في 15 دولة مختلفة حول العالم، وقريبا في دول أخرى.',
                'count'=>'14',
                'image'=>'worldwide.png',
                "active"=>1
            ],
            [
                'en_title'=>'Live Campaign Management',
                'ar_title'=>'ادارة مباشرة للحملات',
                'en_body'=>'World-class support and 24/7 live campaign management services, to provide coordination and direct follow-up, and offer the best service you need anytime throughout the day.',
                'ar_body'=>'خدمة إدارة الحملات وتقديم دعم فني عالمي المستوى، لتوفير تنسيق ومتابعة مباشرة طوال اليوم، وتقديم أفضل خدمة تحتاجها في أي وقت خلال اليوم.',
                'count'=>'12',
                'image'=>'customer-service.png',
                "active"=>1

            ],
            [
                'en_title'=>'employees',
                'ar_title'=>'موظف',
                'en_body'=>'Over 300 specialized employees in different departments, to ensure a successful campaign management service.',
                'ar_body'=>'أكثر من 300 موظف متخصص في أقسام مختلفة، لضمان خدمة حملات إعلانية ناجحة.',
                'count'=>'300',
                'image'=>'group.png',
                "active"=>1
            ],
        ];


        Statistic::insert($statistics);

    }
}

