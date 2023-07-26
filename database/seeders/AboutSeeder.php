<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('about_us')->truncate();
                        AboutUs::create([
                 'welcome_message'=>json_encode([
                 'ar' =>
                'تأسست الشركة عام 2018 من قبل عادل حماد، الذي كان يعمل في مجال التسويق عبر وسائل التواصل الاجتماعي لأكثر من 15 عام ويعرف مدى قوة التسويق الشفهي. أثناء عمله كمتخصص التسويق عبر وسائل التواصل الاجتماعي لشركة طلبات، المنصة الأكبر لتوصيل الطعام في الشرق الأوسط، استخدم التسويق من خلال المؤثرين في استراتيجيته ولاحظ كم كان تأثيره ملموسا في النتائج.
                ولكن في ذلك الوقت، لم يكن من السهل تحقيق أقصى استفادة من التسويق من خلال المؤثرين لعدم وجود طريقة سهلة للبحث عن المؤثرين والتواصل معهم، خاصة في حالة الأعداد الكبيرة، ولكون حملات التسويق من خلال المؤثرين تتطلب ميزانيات لا تناسب جميع المشاريع.
                من هنا بدأت الشركة في تطوير طريقة لجمع الآلاف من أبرز صناع المحتوى على منصة واحدة، وطورت أدوات بحث متقدمة لمساعدة العلامات التجارية وأصحاب المشاريع في العثور على المؤثرين وتصنيفهم بناءا على عشرات من الإحصائيات المهمة.
                كانت الخطوة التالية هي تقديم خدمة إدارة الحملات ومراقبتها لضمان سيرها بسلاسة وتخفيف عبء المتابعة المستمرة عن العلامات التجارية، وكل ذلك بأسعار في متناول الجميع.',
                'en' => 
                'The company was founded in 2018 by Adel Hammad, who has been in the Social Media Marketing field for over 15 years and knew how powerful
                    word-of-mouth marketing was. While working as the Social Media Marketing Specialist for Talabat, the leading food delivery service in The Middle
                    East, he incorporated influencer marketing to his strategy and saw how impactful it was.
                    But at the time, you couldn’t make the most out of influencer marketing as there wasn’t an easy way to search for influencers and connect to them,
                    especially in the case of large numbers, and influencer marketing campaigns weren’t budget-friendly for every business.
                    Thus, Grand Community established a way to gather thousands of the most outstanding content creators on one platform, and developed advanced
                    search tools to help brands and business owners find and filter out the influencers based on tens of important statistics. The next step was offering a
                    campaign management service to ensure campaigns run smoothly and to take the burden of monitoring off of the brand, all for an affordable price.']),
            'vision'=>
                json_encode([
                    'ar' =>
                     'نسعى لنكون المقر والمرجع الأول لجميع المؤثرين والعلامات التجارية حول العالم.',
                    'en' =>
                     'We strive to be the number one hub and reference for every influencer and brand around the world.']),
            'mission'=>json_encode([
                'ar'=>
                'رسالتنا هي جعل التسويق من خلال المؤثرين سهلا ومتاحا لجميع الأطراف: المؤثرين، العلامات التجارية، أصحاب المشاريع، و متخصصي التسويق.',
                'en'=>
                'To make influencer marketing easy and accessible for every party: influencers, brands, business owners, and marketers.']),
            'services'=>json_encode([
                'ar'=>
                'تواصل مباشر ويومي مع المؤثرين المتواجدين على منصتنا لضمان بناء العلاقات بين العلامات التجارية والمؤثرين وتوافق المؤثرين مع متطلبات العلامات في الحملات المختلفة.
                إمكانية إطلاق حملات إعلانية مع أكثر من 5000 مؤثر بإشعار سابق ساعتين فقط.
                لدينا فريق داخلي من المبرمجين يعمل بشكل مستمر على تطوير منصاتنا وتحديثها للحصول على أفضل تجربة مستخدم ممكنة لكل من العلامات التجارية والمؤثرين.',
                'en'=>
                'One-on-one communication with influencers on our platform to ensure strong relationships between brands and influencers.
                 The ability to help brands launch campaigns with up to 5000 influencers with only 2 hours notice.
                 An in-house tech team that’s continuously working on updating
                 and improving our platforms for the best possible user experience.'
                ]),

            'clients'=>json_encode([
                'ar'=>
                'نعمل مع أكثر من 1000 علامة تجارية دولية ومحلية، وساعدنا بفخر عددا لا حصر له من المشاريع المختلفة في النمو وتحقيق أهدافهم، من خلال الآلاف من الحملات الإعلانية الناجحة.
                لقد أطلقنا حملات لمختلف المناسبات، المطاعم، متاجر الأزياء، التطبيقات، وحملات للإعلان عن إطلاق المنتجات الجديدة، وأكثر.',
                'en'=>
                'We’ve been working with over 1000 global and local brands, and we’ve proudly helped countless different businesses achieve their goals through thousands of successful campaigns
                 We’ve been working with over 1000 global and local brands, and we’ve proudly helped countless different businesses achieve their goals through thousands of successful campaigns']),
             'features'=>json_encode([
                'ar'=>
                'تأسست شركة جراند كومينتي برؤية لجعل التسويق من خلال المؤثرين أسهل وأكثر كفاءة من أي وقت مضى.',
                'en'=>
                'Grand community was founded with a mission to make bulk influencer marketing easier and more efficient than ever.']),
                 'about_owner'=>json_encode([
                 'ar'=>
                    'عادل حماد، المؤسس والرئيس التنفيذي لجراند كومينتي، هو من أكثر الأسماء اللامعة والمؤثرة في مجال التسويق عبر منصات التواصل الاجتماعي في الشرق الأوسط منذ أكثر من عقد.
                    على مر 15 عاما من العمل في هذا المجال، ساعد عشرات العلامات التجارية والمشاريع المختلفة في تطوير تواجدهم عبر الإنترنت واستخدام قوة وسائل التواصل الاجتماعي لبناء الوعي بالعلامة التجارية وزيادة النمو ومضاعفة المبيعات.
                    على مر السنوات، تولى أدوارا مختلفة بدءا من كونه متخصص ومستشار التسويق عبر وسائل التواصل، إلى كونه متحدثا في مختلف المناسبات التي تخص هذا المجال لرفع الوعي عنه، فقد تحدث في العديد من الندوات والبرامج التلفزيونية والبودكاست، وحتى كونه مدربا لوسائل التواصل الاجتماعي لطلاب إدارة الأعمال في جامعة الكويت.
                    المشاريع التي عمل عليها تتراوح من المشاريع المحلية إلى العلامات التجارية العالمية، وتشمل: طلبات، ديليفري هيرو، مجموعة كوت الغذائية التي تضم (برجر كنج، بيتزا هت، تاكو بل، أبل بيز، سكوب أ كون، برج الحمام، أيامي، فل وياسمين) مجوهرات ألفيرا، مجموعة TM  للأزياء، تطبيق محفظة Bookeey، وأكثر.
                    بعد مساعدة الكثير من المشاريع، أراد استخدام خبراته وفهمه لآليات عمل وسائل التواصل الاجتماعي في تطوير منصة كان يؤمن بأن السوق في حاجة إليها وأن من شأنها مساعدة أصحاب المشاريع بشكل أكبر وعلى نطاق أوسع. ومن هنا بدأ رحلته الخاصة في إنشاء شركة جراند كومينتي.',
                    'en'=>
                    'Adel Hammad, Founder and CEO of Grand Community, has been a bright, impactful name in the Social
                    Media Marketing field in The Middle East for over a decade.
                    During his 15 years of working in this field, he helped tens of brands and businesses develop their online
                    presence and use the power of social media to build brand awareness, drive growth, and increase sales.
                    Over the years, he took on different roles from being a Social Media Consultant, Strategist, Director
                    of Social Media, to being a Speaker at different events, webinars, TV programmes, and podcasts to
                    help raise awareness regarding this field, to being a Social Media Trainer for Business Administration
                    students at Kuwait University.
                    Business he worked with ranged from local business to global brands. These business include: Talabat,
                    Delivery Hero, Kout Food Group which includes (Burger King, Pizza Hut, Taco Bell, Applebee’s, Scoop
                    A Cone, Burj Al Hamam, Ayyame, Fol O’Yasmine) Alvira Luxury Accessories, TM Fashion Group, Bookeey
                    Wallet, and more.
                    He wanted to use his experiences and understanding of social media mechanisms to develop a platform that
                    he believed the market needed and believed it would help businesses on a bigger scale. Thus, he began
                    his own journey with Grand Community.'
            ])

        ]);
    }
}
