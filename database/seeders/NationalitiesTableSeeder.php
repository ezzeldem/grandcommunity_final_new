<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NationalitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nationalities')->delete();

        $nationalities = [
            array('AF', 'Afghanistan','أفغانستان','Afghan','أفغانستاني'),
            array('AL', 'Albania','ألبانيا','Albanian','ألباني'),
            array('AX', 'Aland Islands','جزر آلاند','Aland Islander','آلاندي'),
            array('DZ', 'Algeria','الجزائر','Algerian','جزائري'),
            array('AS', 'American Samoa','ساموا-الأمريكي','American Samoan','أمريكي سامواني'),
            array('AD', 'Andorra','أندورا','Andorran','أندوري'),
            array('AO', 'Angola','أنغولا','Angolan','أنقولي'),
            array('AI', 'Anguilla','أنغويلا','Anguillan','أنغويلي'),
            array('AQ', 'Antarctica','أنتاركتيكا','Antarctican','أنتاركتيكي'),
            array('AG', 'Antigua and Barbuda','أنتيغوا وبربودا','Antiguan','بربودي'),
            array('AR', 'Argentina','الأرجنتين','Argentinian','أرجنتيني'),
            array('AM', 'Armenia','أرمينيا','Armenian','أرميني'),
            array('AW', 'Aruba','أروبه','Aruban','أوروبهيني'),
            array('AU', 'Australia','أستراليا','Australian','أسترالي'),
            array('AT', 'Austria','النمسا','Austrian','نمساوي'),
            array('AZ', 'Azerbaijan','أذربيجان','Azerbaijani','أذربيجاني'),
            array('BS', 'Bahamas','الباهاماس','Bahamian','باهاميسي'),
            array('BH', 'Bahrain','البحرين','Bahraini','بحريني'),
            array('BD', 'Bangladesh','بنغلاديش','Bangladeshi','بنغلاديشي'),
            array('BB', 'Barbados','بربادوس','Barbadian','بربادوسي'),
            array('BY', 'Belarus','روسيا البيضاء','Belarusian','روسي'),
            array('BE', 'Belgium','بلجيكا','Belgian','بلجيكي'),
            array('BZ', 'Belize','بيليز','Belizean','بيليزي'),
            array('BJ', 'Benin','بنين','Beninese','بنيني'),
            array('BL', 'Saint Barthelemy','سان بارتيلمي','Saint Barthelmian','سان بارتيلمي'),
            array('BM', 'Bermuda','جزر برمودا','Bermudan','برمودي'),
            array('BT', 'Bhutan','بوتان','Bhutanese','بوتاني'),
            array('BO', 'Bolivia','بوليفيا','Bolivian','بوليفي'),
            array('BA', 'Bosnia and Herzegovina','البوسنة و الهرسك','Bosnian / Herzegovinian','بوسني/هرسكي'),
            array('BW', 'Botswana','بوتسوانا','Botswanan','بوتسواني'),
            array('BV', 'Bouvet Island','جزيرة بوفيه','Bouvetian','بوفيهي'),
            array('BR', 'Brazil','البرازيل','Brazilian','برازيلي'),
            array('IO', 'British Indian Ocean Territory','إقليم المحيط الهندي البريطاني','British Indian Ocean Territory','إقليم المحيط الهندي البريطاني'),
            array('BN', 'Brunei Darussalam','بروني','Bruneian','بروني'),
            array('BG', 'Bulgaria','بلغاريا','Bulgarian','بلغاري'),
            array('BF', 'Burkina Faso','بوركينا فاسو','Burkinabe','بوركيني'),
            array('BI', 'Burundi','بوروندي','Burundian','بورونيدي'),
            array('KH', 'Cambodia','كمبوديا','Cambodian','كمبودي'),
            array('CM', 'Cameroon','كاميرون','Cameroonian','كاميروني'),
            array('CA', 'Canada','كندا','Canadian','كندي'),
            array('CV', 'Cape Verde','الرأس الأخضر','Cape Verdean','الرأس الأخضر'),
            array('KY', 'Cayman Islands','جزر كايمان','Caymanian','كايماني'),
            array('CF', 'Central African Republic','جمهورية أفريقيا الوسطى','Central African','أفريقي'),
            array('TD', 'Chad','تشاد','Chadian','تشادي'),
            array('CL', 'Chile','شيلي','Chilean','شيلي'),
            array('CN', 'China','الصين','Chinese','صيني'),
            array('CX', 'Christmas Island','جزيرة عيد الميلاد','Christmas Islander','جزيرة عيد الميلاد'),
            array('CC', 'Cocos (Keeling) Islands','جزر كوكوس','Cocos Islander','جزر كوكوس'),
            array('CO', 'Colombia','كولومبيا','Colombian','كولومبي'),
            array('KM', 'Comoros','جزر القمر','Comorian','جزر القمر'),
            array('CG', 'Congo','الكونغو','Congolese','كونغي'),
            array('CK', 'Cook Islands','جزر كوك','Cook Islander','جزر كوك'),
            array('CR', 'Costa Rica','كوستاريكا','Costa Rican','كوستاريكي'),
            array('HR', 'Croatia','كرواتيا','Croatian','كوراتي'),
            array('CU', 'Cuba','كوبا','Cuban','كوبي'),
            array('CY', 'Cyprus','قبرص','Cypriot','قبرصي'),
            array('CW', 'Curaçao','كوراساو','Curacian','كوراساوي'),
            array('CZ', 'Czech Republic','الجمهورية التشيكية','Czech','تشيكي'),
            array('DK', 'Denmark','الدانمارك','Danish','دنماركي'),
            array('DJ', 'Djibouti','جيبوتي','Djiboutian','جيبوتي'),
            array('DM', 'Dominica','دومينيكا','Dominican','دومينيكي'),
            array('DO', 'Dominican Republic','الجمهورية الدومينيكية','Dominican','دومينيكي'),
            array('EC', 'Ecuador','إكوادور','Ecuadorian','إكوادوري'),
            array('EG', 'Egypt','مصر','Egyptian','مصري'),
            array('SV', 'El Salvador','إلسلفادور','Salvadoran','سلفادوري'),
            array('GQ', 'Equatorial Guinea','غينيا الاستوائي','Equatorial Guinean','غيني'),
            array('ER', 'Eritrea','إريتريا','Eritrean','إريتيري'),
            array('EE', 'Estonia','استونيا','Estonian','استوني'),
            array('ET', 'Ethiopia','أثيوبيا','Ethiopian','أثيوبي'),
            array('FK', 'Falkland Islands (Malvinas)','جزر فوكلاند','Falkland Islander','فوكلاندي'),
            array('FO', 'Faroe Islands','جزر فارو','Faroese','جزر فارو'),
            array('FJ', 'Fiji','فيجي','Fijian','فيجي'),
            array('FI', 'Finland','فنلندا','Finnish','فنلندي'),
            array('FR', 'France','فرنسا','French','فرنسي'),
            array('GF', 'French Guiana','غويانا الفرنسية','French Guianese','غويانا الفرنسية'),
            array('PF', 'French Polynesia','بولينيزيا الفرنسية','French Polynesian','بولينيزيي'),
            array('TF', 'French Southern and Antarctic Lands','أراض فرنسية جنوبية وأنتارتيكية','French','أراض فرنسية جنوبية وأنتارتيكية'),
            array('GA', 'Gabon','الغابون','Gabonese','غابوني'),
            array('GM', 'Gambia','غامبيا','Gambian','غامبي'),
            array('GE', 'Georgia','جيورجيا','Georgian','جيورجي'),
            array('DE', 'Germany','ألمانيا','German','ألماني'),
            array('GH', 'Ghana','غانا','Ghanaian','غاني'),
            array('GI', 'Gibraltar','جبل طارق','Gibraltar','جبل طارق'),
            array('GG', 'Guernsey','غيرنزي','Guernsian','غيرنزي'),
            array('GR', 'Greece','اليونان','Greek','يوناني'),
            array('GL', 'Greenland','جرينلاند','Greenlandic','جرينلاندي'),
            array('GD', 'Grenada','غرينادا','Grenadian','غرينادي'),
            array('GP', 'Guadeloupe','جزر جوادلوب','Guadeloupe','جزر جوادلوب'),
            array('GU', 'Guam','جوام','Guamanian','جوامي'),
            array('GT', 'Guatemala','غواتيمال','Guatemalan','غواتيمالي'),
            array('GN', 'Guinea','غينيا','Guinean','غيني'),
            array('GW', 'Guinea-Bissau','غينيا-بيساو','Guinea-Bissauan','غيني'),
            array('GY', 'Guyana','غيانا','Guyanese','غياني'),
            array('HT', 'Haiti','هايتي','Haitian','هايتي'),
            array('HM', 'Heard and Mc Donald Islands','جزيرة هيرد وجزر ماكدونالد','Heard and Mc Donald Islanders','جزيرة هيرد وجزر ماكدونالد'),
            array('HN', 'Honduras','هندوراس','Honduran','هندوراسي'),
            array('HK', 'Hong Kong','هونغ كونغ','Hongkongese','هونغ كونغي'),
            array('HU', 'Hungary','المجر','Hungarian','مجري'),
            array('IS', 'Iceland','آيسلندا','Icelandic','آيسلندي'),
            array('IN', 'India','الهند','Indian','هندي'),
            array('IM', 'Isle of Man','جزيرة مان','Manx','ماني'),
            array('ID', 'Indonesia','أندونيسيا','Indonesian','أندونيسيي'),
            array('IR', 'Iran','إيران','Iranian','إيراني'),
            array('IQ', 'Iraq','العراق','Iraqi','عراقي'),
            array('IE', 'Ireland','إيرلندا','Irish','إيرلندي'),
            array('IL', 'Israel','إسرائيل','Israeli','إسرائيلي'),
            array('IT', 'Italy','إيطاليا','Italian','إيطالي'),
            array('CI', 'Ivory Coast','ساحل العاج','Ivory Coastian','ساحل العاج'),
            array('JE', 'Jersey','جيرزي','Jersian','جيرزي'),
            array('JM', 'Jamaica','جمايكا','Jamaican','جمايكي'),
            array('JP', 'Japan','اليابان','Japanese','ياباني'),
            array('JO', 'Jordan','الأردن','Jordanian','أردني'),
            array('KZ', 'Kazakhstan','كازاخستان','Kazakh','كازاخستاني'),
            array('KE', 'Kenya','كينيا','Kenyan','كيني'),
            array('KI', 'Kiribati','كيريباتي','I-Kiribati','كيريباتي'),
            array('KP', 'Korea(North Korea)','كوريا الشمالية','North Korean','كوري'),
            array('KR', 'Korea(South Korea)','كوريا الجنوبية','South Korean','كوري'),
            array('XK', 'Kosovo','كوسوفو','Kosovar','كوسيفي'),
            array('KW', 'Kuwait','الكويت','Kuwaiti','كويتي'),
            array('KG', 'Kyrgyzstan','قيرغيزستان','Kyrgyzstani','قيرغيزستاني'),
            array('LA', 'Lao PDR','لاوس','Laotian','لاوسي'),
            array('LV', 'Latvia','لاتفيا','Latvian','لاتيفي'),
            array('LB', 'Lebanon','لبنان','Lebanese','لبناني'),
            array('LS', 'Lesotho','ليسوتو','Basotho','ليوسيتي'),
            array('LR', 'Liberia','ليبيريا','Liberian','ليبيري'),
            array('LY', 'Libya','ليبيا','Libyan','ليبي'),
            array('LI', 'Liechtenstein','ليختنشتين','Liechtenstein','ليختنشتيني'),
            array('LT', 'Lithuania','لتوانيا','Lithuanian','لتوانيي'),
            array('LU', 'Luxembourg','لوكسمبورغ','Luxembourger','لوكسمبورغي'),
            array('LK', 'Sri Lanka','سريلانكا','Sri Lankian','سريلانكي'),
            array('MO', 'Macau','ماكاو','Macanese','ماكاوي'),
            array('MK', 'Macedonia','مقدونيا','Macedonian','مقدوني'),
            array('MG', 'Madagascar','مدغشقر','Malagasy','مدغشقري'),
            array('MW', 'Malawi','مالاوي','Malawian','مالاوي'),
            array('MY', 'Malaysia','ماليزيا','Malaysian','ماليزي'),
            array('MV', 'Maldives','المالديف','Maldivian','مالديفي'),
            array('ML', 'Mali','مالي','Malian','مالي'),
            array('MT', 'Malta','مالطا','Maltese','مالطي'),
            array('MH', 'Marshall Islands','جزر مارشال','Marshallese','مارشالي'),
            array('MQ', 'Martinique','مارتينيك','Martiniquais','مارتينيكي'),
            array('MR', 'Mauritania','موريتانيا','Mauritanian','موريتانيي'),
            array('MU', 'Mauritius','موريشيوس','Mauritian','موريشيوسي'),
            array('YT', 'Mayotte','مايوت','Mahoran','مايوتي'),
            array('MX', 'Mexico','المكسيك','Mexican','مكسيكي'),
            array('FM', 'Micronesia','مايكرونيزيا','Micronesian','مايكرونيزيي'),
            array('MD', 'Moldova','مولدافيا','Moldovan','مولديفي'),
            array('MC', 'Monaco','موناكو','Monacan','مونيكي'),
            array('MN', 'Mongolia','منغوليا','Mongolian','منغولي'),
            array('ME', 'Montenegro','الجبل الأسود','Montenegrin','الجبل الأسود'),
            array('MS', 'Montserrat','مونتسيرات','Montserratian','مونتسيراتي'),
            array('MA', 'Morocco','المغرب','Moroccan','مغربي'),
            array('MZ', 'Mozambique','موزمبيق','Mozambican','موزمبيقي'),
            array('MM', 'Myanmar','ميانمار','Myanmarian','ميانماري'),
            array('NA', 'Namibia','ناميبيا','Namibian','ناميبي'),
            array('NR', 'Nauru','نورو','Nauruan','نوري'),
            array('NP', 'Nepal','نيبال','Nepalese','نيبالي'),
            array('NL', 'Netherlands','هولندا','Dutch','هولندي'),
            array('AN', 'Netherlands Antilles','جزر الأنتيل الهولندي','Dutch Antilier','هولندي'),
            array('NC', 'New Caledonia','كاليدونيا الجديدة','New Caledonian','كاليدوني'),
            array('NZ', 'New Zealand','نيوزيلندا','New Zealander','نيوزيلندي'),
            array('NI', 'Nicaragua','نيكاراجوا','Nicaraguan','نيكاراجوي'),
            array('NE', 'Niger','النيجر','Nigerien','نيجيري'),
            array('NG', 'Nigeria','نيجيريا','Nigerian','نيجيري'),
            array('NU', 'Niue','ني','Niuean','ني'),
            array('NF', 'Norfolk Island','جزيرة نورفولك','Norfolk Islander','نورفوليكي'),
            array('MP', 'Northern Mariana Islands','جزر ماريانا الشمالية','Northern Marianan','ماريني'),
            array('NO', 'Norway','النرويج','Norwegian','نرويجي'),
            array('OM', 'Oman','عمان','Omani','عماني'),
            array('PK', 'Pakistan','باكستان','Pakistani','باكستاني'),
            array('PW', 'Palau','بالاو','Palauan','بالاوي'),
            array('PS', 'Palestine','فلسطين','Palestinian','فلسطيني'),
            array('PA', 'Panama','بنما','Panamanian','بنمي'),
            array('PG', 'Papua New Guinea','بابوا غينيا الجديدة','Papua New Guinean','بابوي'),
            array('PY', 'Paraguay','باراغواي','Paraguayan','بارغاوي'),
            array('PE', 'Peru','بيرو','Peruvian','بيري'),
            array('PH', 'Philippines','الفليبين','Filipino','فلبيني'),
            array('PN', 'Pitcairn','بيتكيرن','Pitcairn Islander','بيتكيرني'),
            array('PL', 'Poland','بولونيا','Polish','بوليني'),
            array('PT', 'Portugal','البرتغال','Portuguese','برتغالي'),
            array('PR', 'Puerto Rico','بورتو ريكو','Puerto Rican','بورتي'),
            array('QA', 'Qatar','قطر','Qatari','قطري'),
            array('RE', 'Reunion Island','ريونيون','Reunionese','ريونيوني'),
            array('RO', 'Romania','رومانيا','Romanian','روماني'),
            array('RU', 'Russian','روسيا','Russian','روسي'),
            array('RW', 'Rwanda','رواندا','Rwandan','رواندا'),
            array('KN', 'Saint Kitts and Nevis','سانت كيتس ونيفس,','Kittitian/Nevisian','سانت كيتس ونيفس'),
            array('MF', 'Saint Martin (French part)','ساينت مارتن فرنسي','St. Martian(French)','ساينت مارتني فرنسي'),
            array('SX', 'Sint Maarten (Dutch part)','ساينت مارتن هولندي','St. Martian(Dutch)','ساينت مارتني هولندي'),
            array('LC', 'Saint Pierre and Miquelon','سان بيير وميكلون','St. Pierre and Miquelon','سان بيير وميكلوني'),
            array('VC', 'Saint Vincent and the Grenadines','سانت فنسنت وجزر غرينادين','Saint Vincent and the Grenadines','سانت فنسنت وجزر غرينادين'),
            array('WS', 'Samoa','ساموا','Samoan','ساموي'),
            array('SM', 'San Marino','سان مارينو','Sammarinese','ماريني'),
            array('ST', 'Sao Tome and Principe','ساو تومي وبرينسيبي','Sao Tomean','ساو تومي وبرينسيبي'),
            array('SA', 'Saudi Arabia','المملكة العربية السعودية','Saudi Arabian','سعودي'),
            array('SN', 'Senegal','السنغال','Senegalese','سنغالي'),
            array('RS', 'Serbia','صربيا','Serbian','صربي'),
            array('SC', 'Seychelles','سيشيل','Seychellois','سيشيلي'),
            array('SL', 'Sierra Leone','سيراليون','Sierra Leonean','سيراليوني'),
            array('SG', 'Singapore','سنغافورة','Singaporean','سنغافوري'),
            array('SK', 'Slovakia','سلوفاكيا','Slovak','سولفاكي'),
            array('SI', 'Slovenia','سلوفينيا','Slovenian','سولفيني'),
            array('SB', 'Solomon Islands','جزر سليمان','Solomon Island','جزر سليمان'),
            array('SO', 'Somalia','الصومال','Somali','صومالي'),
            array('ZA', 'South Africa','جنوب أفريقيا','South African','أفريقي'),
            array('GS', 'South Georgia and the South Sandwich','المنطقة القطبية الجنوبية','South Georgia and the South Sandwich','لمنطقة القطبية الجنوبية'),
            array('SS', 'South Sudan','السودان الجنوبي','South Sudanese','سوادني جنوبي'),
            array('ES', 'Spain','إسبانيا','Spanish','إسباني'),
            array('SH', 'Saint Helena','سانت هيلانة','St. Helenian','هيلاني'),
            array('SD', 'Sudan','السودان','Sudanese','سوداني'),
            array('SR', 'Suriname','سورينام','Surinamese','سورينامي'),
            array('SJ', 'Svalbard and Jan Mayen','سفالبارد ويان ماين','Svalbardian/Jan Mayenian','سفالبارد ويان ماين'),
            array('SZ', 'Swaziland','سوازيلند','Swazi','سوازيلندي'),
            array('SE', 'Sweden','السويد','Swedish','سويدي'),
            array('CH', 'Switzerland','سويسرا','Swiss','سويسري'),
            array('SY', 'Syria','سوريا','Syrian','سوري'),
            array('TW', 'Taiwan','تايوان','Taiwanese','تايواني'),
            array('TJ', 'Tajikistan','طاجيكستان','Tajikistani','طاجيكستاني'),
            array('TZ', 'Tanzania','تنزانيا','Tanzanian','تنزانيي'),
            array('TH', 'Thailand','تايلندا','Thai','تايلندي'),
            array('TL', 'Timor-Leste','تيمور الشرقية','Timor-Lestian','تيموري'),
            array('TG', 'Togo','توغو','Togolese','توغي'),
            array('TK', 'Tokelau','توكيلاو','Tokelaian','توكيلاوي'),
            array('TO', 'Tonga','تونغا','Tongan','تونغي'),
            array('TT', 'Trinidad and Tobago','ترينيداد وتوباغو','Trinidadian/Tobagonian','ترينيداد وتوباغو'),
            array('TN', 'Tunisia','تونس','Tunisian','تونسي'),
            array('TR', 'Turkey','تركيا','Turkish','تركي'),
            array('TM', 'Turkmenistan','تركمانستان','Turkmen','تركمانستاني'),
            array('TC', 'Turks and Caicos Islands','جزر توركس وكايكوس','Turks and Caicos Islands','جزر توركس وكايكوس'),
            array('TV', 'Tuvalu','توفالو','Tuvaluan','توفالي'),
            array('UG', 'Uganda','أوغندا','Ugandan','أوغندي'),
            array('UA', 'Ukraine','أوكرانيا','Ukrainian','أوكراني'),
            array('AE', 'United Arab Emirates','الإمارات العربية المتحدة','Emirati','إماراتي'),
            array('GB', 'United Kingdom','المملكة المتحدة','British','بريطاني'),
            array('US', 'United States','الولايات المتحدة','American','أمريكي'),
            array('UM', 'US Minor Outlying Islands','قائمة الولايات والمناطق الأمريكية','US Minor Outlying Islander','أمريكي'),
            array('UY', 'Uruguay','أورغواي','Uruguayan','أورغواي'),
            array('UZ', 'Uzbekistan','أوزباكستان','Uzbek','أوزباكستاني'),
            array('VU', 'Vanuatu','فانواتو','Vanuatuan','فانواتي'),
            array('VE', 'Venezuela','فنزويلا','Venezuelan','فنزويلي'),
            array('VN', 'Vietnam','فيتنام','Vietnamese','فيتنامي'),
            array('VI', 'Virgin Islands (U.S.)','الجزر العذراء الأمريكي','American Virgin Islander','أمريكي'),
            array('VA', 'Vatican City','فنزويلا','Vatican','فاتيكاني'),
            array('WF', 'Wallis and Futuna Islands','والس وفوتونا','Wallisian/Futunan','فوتوني'),
            array('EH', 'Western Sahara','الصحراء الغربية','Sahrawian','صحراوي'),
            array('YE', 'Yemen','اليمن','Yemeni','يمني'),
            array('ZM', 'Zambia','زامبيا','Zambian','زامبياني'),
            array('ZW', 'Zimbabwe','زمبابوي','Zimbabwean','زمبابوي'),
        ];
       
        $filter_nationalities = [];
       foreach ($nationalities as $nationality){
           array_push($filter_nationalities,array('code' => $nationality[0],'active'=>1,"name"=>'{"ar":"'.$nationality[4].'","en":"'.$nationality[3].'"}'));
       }
        DB::table('nationalities')->insert($filter_nationalities);
    }
}