<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    'accepted'             => 'يجب قبول الحقل :attribute',
    'active_url'           => 'الحقل :attribute لا يُمثّل رابطًا صحيحًا',
    'after'                => 'يجب على الحقل :attribute أن يكون تاريخًا لاحقًا للتاريخ :date.',
    'alpha'                => 'يجب أن لا يحتوي الحقل :attribute سوى على حروف',
    'alpha_dash'           => 'يجب أن لا يحتوي الحقل :attribute على حروف، أرقام ومطّات.',
    'alpha_num'            => 'يجب أن يحتوي :attribute على حروفٍ وأرقامٍ فقط',
    'array'                => 'يجب أن يكون الحقل :attribute ًمصفوفة',
    'before'               => 'يجب على الحقل :attribute أن يكون تاريخًا سابقًا للتاريخ :date.',
    'between'              => [
        'numeric' => 'يجب أن تكون قيمة :attribute محصورة ما بين :min و :max.',
        'file'    => 'يجب أن يكون حجم الملف :attribute محصورًا ما بين :min و :max كيلوبايت.',
        'string'  => 'يجب أن يكون عدد حروف النّص :attribute محصورًا ما بين :min و :max',
        'array'   => 'يجب أن يحتوي :attribute على عدد من العناصر محصورًا ما بين :min و :max',
    ],
    'boolean'              => 'يجب أن تكون قيمة الحقل :attribute إما true أو false ',
    'confirmed'            => 'حقل التأكيد غير مُطابق للحقل :attribute',
    'date'                 => 'الحقل :attribute ليس تاريخًا صحيحًا',
    'date_format'          => 'لا يتوافق الحقل :attribute مع الشكل :format.',
    'different'            => 'يجب أن يكون الحقلان :attribute و :other مُختلفان',
    'digits'               => 'يجب أن يحتوي  :attribute على :digits رقمًا/أرقام',
    'digits_between'       => 'يجب أن يحتوي  :attribute ما بين :min و :max رقمًا/أرقام ',
    'email'                => 'يجب أن يكون :attribute  بصيغه صحيح',
    'exists'               => ' :attribute مطلوب',
    'filled'               => 'الحقل :attribute إجباري',
    'image'                => 'يجب أن يكون الحقل :attribute ',
    'in'                   => ' :attribute مطلوب',
    'integer'              => 'يجب أن يكون الحقل :attribute عددًا صحيحًا',
    'ip'                   => 'يجب أن يكون الحقل :attribute عنوان IP ذي بُنية صحيحة',
    'json'                 => 'يجب أن يكون الحقل :attribute نصآ من نوع JSON.',
    'max'                  => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute أصغر من :max.',
        'file'    => 'يجب أن يكون حجم الملف :attribute أصغر من :max كيلوبايت',
        'string'  => 'يجب أن لا يتجاوز طول النّص :attribute :max حروفٍ/حرفًا',
        'array'   => 'يجب أن لا يحتوي الحقل :attribute على أكثر من :max عناصر/عنصر.',
    ],
    'mimes'                => 'يجب أن يكون الحقل ملفًا من نوع : :values.',
    'min'                  => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute أكبر من :min.',
        'file'    => 'يجب أن يكون حجم الملف :attribute أكبر من :min كيلوبايت',
        'string'  => 'يجب أن يكون طول النص :attribute أكبر :min حروفٍ/حرفًا',
        'array'   => 'يجب أن يحتوي الحقل :attribute على الأقل على :min عُنصرًا/عناصر',
    ],
    'not_in'               => ' :attribute مطلوب',
    'numeric'              => 'يجب على الحقل :attribute أن يكون رقمًا',
    'regex'                => 'صيغة الحقل :attribute .غير صحيحة',
    'required'             => ' :attribute مطلوب.',
    'required_if'          => 'الحقل :attribute مطلوب في حال ما إذا كان :other يساوي :value.',
    'required_unless'      => 'الحقل :attribute مطلوب في حال ما لم يكن :other يساوي :values.',
    'required_with'        => 'الحقل :attribute إذا توفّر :values.',
    'required_with_all'    => 'الحقل :attribute إذا توفّر :values.',
    'required_without'     => 'الحقل :attribute إذا لم يتوفّر :values.',
    'required_without_all' => 'الحقل :attribute إذا لم يتوفّر :values.',
    'same'                 => 'يجب أن يتطابق الحقل :attribute مع :other',
    'size'                 => [
        'numeric' => 'يجب أن تكون قيمة :attribute أكبر من :size.',
        'file'    => 'يجب أن يكون حجم الملف :attribute أكبر من :size كيلو بايت.',
        'string'  => 'يجب أن يحتوي النص :attribute عن ما لا يقل عن  :size حرفٍ/أحرف.',
        'array'   => 'يجب أن يحتوي الحقل :attribute عن ما لا يقل عن:min عنصرٍ/عناصر',
    ],
    'string'               => 'يجب أن يكون الحقل :attribute نصآ.',
    'timezone'             => 'يجب أن يكون :attribute نطاقًا زمنيًا صحيحًا',
    'unique'               => 'قيمة الحقل :attribute مُستخدمة من قبل',
    'url'                  => 'صيغة الرابط :attribute غير صحيحة',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes'           => [
        'name'                  => 'الاسم',
        'username'              => 'اسم المُستخدم',
        'user_name'              => 'اسم المُستخدم',
        'email'                 => 'البريد الالكتروني',
        'first_name'            => 'الاسم',
        'last_name'             => 'اسم العائلة',
        'password'              => 'كلمة المرور',
        'password_confirmation' => 'تأكيد كلمة المرور',
        'city'                  => 'المدينة',
        'country'               => 'الدولة',
        'address'               => 'العنوان',
        'phone'                 => 'الهاتف',
        'mobile'                => 'الهاتف',
        'age'                   => 'العمر',
        'sex'                   => 'الجنس',
        'gender'                => 'النوع',
        'day'                   => 'اليوم',
        'month'                 => 'الشهر',
        'year'                  => 'السنة',
        'hour'                  => 'ساعة',
        'minute'                => 'دقيقة',
        'second'                => 'ثانية',
        'title'                 => 'اللقب',
        'content'               => 'المُحتوى',
        'description'           => 'الوصف',
        'excerpt'               => 'المُلخص',
        'date'                  => 'التاريخ',
        'time'                  => 'الوقت',
        'available'             => 'مُتاح',
        'size'                  => 'الحجم',
        'code'                  => 'رمز الدولة',
		'code_whats'           =>'رمز الدوله',
		'code_phone'           =>'رمز الدوله',
        'whatsapp'                  => 'الواتس اب',
		'whats_number'             =>'الواتس اب',
        'message'                  => 'الرسالة ',
        'social_data.DOB'                  => 'تاريخ الميلاد',
        'social_data.children_num'                  => 'عدد الأولاد',
        'social_data.gender'                  => 'النوع',
        'social_data.name'                  => 'الاسم',
        'social_data.gender.*'                  => 'النوع',
        'social_data.social_type'                  => 'النوع',
        'social_data.DOB.*'                  => 'تاريخ الميلاد',
        'brand.date_of_birth'                  => 'تاريخ الميلاد',
        'brand.req_img'                                =>"صورة",
        'brand.req img'                                =>"صورة",
        'brand.insta_uname'                                =>"أكونت الانستجرام",
        'brand.facebook_uname'                                =>"أكونت الفيسبوك",
        'brand.website_uname'                                =>"الموقع",
        'brand.whatsapp'                                =>"رقم واتساب",
        'brand.twitter_uname'                                =>"أكونت تويتر",
        'brand.snapchat_uname'                                =>"أكونت سناب شات",
        'brand.tiktok_uname'                                =>"أكونت التيك توك",
        "code_phone"                             =>"رمز الدولة",
        "code_whats"                             =>"رمز الواتس اب",
        "country_id"                             =>"الدولة",
        "type"                                   =>"النوع",

        'sub_brand.name' => "اسم البراند الفرعي",
        'sub_brand.link_facebook' => "فيسبوك البراند الفرعي",
        'sub_brand.link_insta' => "انستجرام البراند الفرعي",
        'sub_brand.link_snapchat' => "سناب شات البراند الفرعي",
        'sub_brand.link_tiktok' => "تيك توك البراند الفرعي",
        'sub_brand.link_twitter' => "تويتر البراند الفرعي",
        'sub_brand.link_website' => "موقع البراند الفرعي",
        'sub_brand.phone' => "جوال البراند الفرعي",
        'sub_brand.whats_number' => "واتساب البراند الفرعي",
		'sub_brand.preferred_gender'=>'النوع المفضل للبراند الفرعى',
        'copy_all_id' => "الانفلونسرز",
        'choose_group_list' => "الجروب",
		'terms'=>'الشروط والأحكام',
		'password'=>'كلمه المرور',
		 'brand.social.*.instagram_value'=>' الانستغرام ',
		 'brand.social.*.snapchat_value'=>' الاسناب ',
		 'brand.social.*.tiktok_value'=>' تيك توك ',
		 'brand.social.*.twitter_value'=>' تيويتر ',
			'brand.social.*.facebook_value'=>' فيس بوك ',
			'sub_brand.social.*.instagram_value'=>' الانستغرام ',
			'sub_brand.social.*.snapchat_value'=>' الاسناب ',
			'sub_brand.social.*.tiktok_value'=>' تيك توك ',
			'sub_brand.social.*.twitter_value'=>' تيويتر ',
			'sub_brand.social.*.facebook_value'=>' فيس بوك ',
		  'social.*.instagram_value'=>' الانستغرام ',
		 'social.*.snapchat_value'=>' الاسناب ',
		 'social.*.tiktok_value'=>' تيك توك ',
		 'social.*.twitter_value'=>' تيويتر ',
		  'social.*.facebook_value'=>' فيس بوك ',
		  'country.*'=>'الدولة',
		  'link_website'=>'الموقع',
		  'brand.code'=>'كود الدوله',
		  'brand.phone'=>'رقم الهاتف',



    ],

];

