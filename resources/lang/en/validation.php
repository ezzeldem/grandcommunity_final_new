<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute must only contain letters.',
    'alpha_dash' => 'The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute must only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'current_password' => 'The password is incorrect.',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'The :attribute must be a valid email address.',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'The :attribute must not be greater than :max.',
        'file' => 'The :attribute must not be greater than :max kilobytes.',
        'string' => 'The :attribute must not be greater than :max characters.',
        'array' => 'The :attribute must not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'The :attribute field must be English char.',
    'required' => 'The :attribute field is required',
    'required_if' => 'The :attribute field is required when :other is :value',
    'required_unless' => 'The :attribute field is required unless :other is in :values',
    'required_with' => 'The :attribute field is required when :values is present',
    'required_with_all' => 'The :attribute field is required when :values are present',
    'required_without' => 'The :attribute field is required when :values is not present',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid timezone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute must be a valid URL.',
    'uuid' => 'The :attribute must be a valid UUID.',

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

    'custom' => [
        'active' => [
            'in' => 'The status fields must be in ( Pending, Active, Inactive, Reject )',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes'           => [
        "country_id"=>'Country',
        "state_id"=>'Governorate',
        'city_id'=>'City',
        'insta uname'=>'Instagram username',

        'social_data.DOB'                      => 'date of birth',
        'social_data.children_num'             => 'number of children',
        'social_data.gender'                   => 'gender',
        'social_data.gender.*'                 => 'gender',
        'social_data.name'                     => 'name',
        'social_data.name.*'                   => 'name',
        'social_data.social_type'              => 'type',
        'social_data.DOB.*'                    => 'date of birth',
        'brand.date_of_birth'                  => 'date of birth',
        'brand.req_img'                                =>"field",
        'brand.req img'                                =>"field",
        'brand.insta_uname'                                =>"instagram username",
        'brand.facebook_uname'                                =>"facebook username",
        'brand.tiktok_uname'                                =>"tik tok username",
        'brand.snapchat_uname'                                =>"snapchat username",
        'brand.twitter_uname'                                =>"twitter username",
        'brand.whatsapp'                                =>"whatsapp",
        'brand.website_uname'                                =>"website",

        'sub_brand.name' => "Sub-brand name",
        'sub_brand.link_facebook' => "Sub-brand facebook",
        'sub_brand.link_insta' => "Sub-brand instagram",
        'sub_brand.link_snapchat' => "Sub-brand snapchat",
        'sub_brand.link_tiktok' => "Sub-brand tik tok",
        'sub_brand.link_twitter' => "Sub-brand twitter",
        'sub_brand.link_website' => "Sub-brand website",
        'sub_brand.phone' => "Sub-brand phone",
        'sub_brand.whats_number' => "Sub-brand whatsapp",
		'sub_brand.preferred_gender'=>'Sub-brand Preferred gender',
        'copy_all_id' => "influencers",
        'choose_group_list' => "groups",
        'Editprofile_form'=>'password',
        "main_phone_code"=>"Calling Code",
        "whatsapp_code"=>"Calling Code",
        "interest"=>"Interests",
        "lang"=>"Language",
        "user_name"=>"User name",
        "whats_number"=>"Whatsapp Number",
		'whatsapp'=>'Whatsapp Number',
        "address"=>"Address",
        "password"=>"Password",
		'email'=>'E-mail address',
        "password_confirmation"=>"Password confirmation",
        "active"=>"Status",
		'terms'=>'terms and conditions',
		'password'=>'password',
		 'brand.social.*.instagram_value'=>'Instagram ',
		 'brand.social.*.snapchat_value'=>'Snapchat ',
		 'brand.social.*.tiktok_value'=>'Tiktok ',
		 'brand.social.*.twitter_value'=>'Twitter',
		 'brand.social.*.facebook_value'=>'Facebook ',
		 'sub_brand.social.*.instagram_value'=>'Instagram ',
		 'sub_brand.social.*.snapchat_value'=>'Snapchat ',
		 'sub_brand.social.*.tiktok_value'=>'Tiktok ',
		 'sub_brand.social.*.twitter_value'=>'Twitter',
		 'sub_brand.social.*.facebook_value'=>'Facebook ',
		 'social.*.instagram_value'=>'Instagram ',
		 'social.*.snapchat_value'=>'Snapchat ',
		 'social.*.tiktok_value'=>'Tiktok ',
		 'social.*.twitter_value'=>'Twitter',
		 'social.*.facebook_value'=>'Facebook ',
		 'country.*'=>'Country',
		 'code_whats'=>'country code',
		 'code_phone'=>'country code',
		 'link_website'=>'website ',
		 'brand.code'=>'Country Code',
		 'brand.phone'=>'Phone Number',



    ],


];
