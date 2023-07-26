<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\API\BrandDashboard\CampaignsController;
use App\Http\Controllers\API\InfluencerDashboard\CampaignController;
use App\Http\Controllers\API\InfluencerDashboard\InfluencerController;

/*
|--------------------------------------------------------------------------
| API Routes [brands - influencers ]
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware'=>['setLangApi']],function () {
    Route::get('/event', [UserController::class, 'index']);
    Route::post('/register', 'AuthenticationController@register');
    Route::post('/login', 'AuthenticationController@login');


    Route::post('social/{provider}', 'AuthenticationController@social');

    //Start Scanner Routes
    Route::post('scanner-login', 'ScannerController@scanner_login');
    Route::group(['middleware'=>['scanner.authenticate'],'prefix' => 'scanner'],function () {
            Route::get('/get-influe-camp', 'ScannerController@getConfirmedInfluencers');
            Route::post('/visit_report', 'ScannerController@getVisitReport');
            Route::post('scancode', 'ScannerController@scanCode');
            Route::post('update_influ_visit', 'ScannerController@updateInfluVisit');
            Route::post('rate_influencer', 'ScannerController@rateInfluencer');
            Route::get('/get_confirmed_influe', 'ScannerController@getConfirmedInfluenecrs');
    });
    //End Scanner Routes

    Route::post('/signout', 'AuthenticationController@signout')->middleware(['auth:sanctum']);
    Route::post('/forget-step1', 'ForgetPasswordController@forgetStep1')->name('forget.step1');
    Route::post('/forget-step2', 'ForgetPasswordController@forgetStep2')->name('forget.step2');
    Route::post('/forget-step3', 'ForgetPasswordController@forgetStep3')->name('forget.step3');
    Route::post('/resend-forget', 'ForgetPasswordController@resendForget')->name('forget.resend');
    Route::post('/recaptcha-verify', 'ForgetPasswordController@verifyRecaptcha')->name('recaptcha.verify');

    Route::get('/countries', 'HomepageController@countries');
    Route::get('/nationalities', 'HomepageController@nationalities');
    Route::get('/nationalities/search', 'HomepageController@nationalities_search');
    Route::post('/confirm/{code}', 'UserController@confirm');
    Route::post('/reset-confirm-code/', 'UserController@resetConfirmCode');
    Route::get('/get-data-homepage', 'HomepageController@getDataHomePage');
    Route::get('/case-studies', 'HomepageController@getCaseStudyPage');
    Route::get('/case-studies/{id}', 'HomepageController@getCaseStudyById');
    Route::get('/get-case-studies-related/{id}', 'HomepageController@getCaseStudiesRelated');
    Route::get('/get-about-us-data', 'HomepageController@get_about_us_data');
    Route::get('common','HomepageController@common');
	Route::get('scrap_facebook/{influencer}','HomepageController@scrapinstabyfacebook');
	Route::get('scrap_insta_test/{influencer}','HomepageController@scrapinsttest');
	Route::get('testInterface/{id}',[NotificationController::class,'getNotifications']);



    Route::post('/influe-import', 'HomepageController@InfluencerImport');

    Route::get('/get-logo', 'HomepageController@getLogo');
    Route::get('/set-local', 'HomepageController@setLocal');
    Route::post('/contacts', 'HomepageController@saveContact');
    Route::get('/pages', 'HomepageController@pages');
    Route::get('/articles', 'HomepageController@articles');
    Route::get('/articles/{id}', 'HomepageController@article');
    Route::get('/faqs', 'HomepageController@faqs');
    Route::post('/save_comments', 'HomepageController@save_comments');
    Route::post('/save_reply', 'HomepageController@save_replies');
    Route::get('/get-all-categories', 'HomepageController@get_all_categories');
    Route::get('/get-all-sponsors', 'HomepageController@get_all_sponsors');
    Route::get('/interests', 'HomepageController@interests');



    Route::post('login_to_booking_campaign', [CampaignsController::class, 'login_to_booking_campaign']);
    Route::post('confirm_booking_campaign', [CampaignsController::class, 'confirm_booking_campaign']);
    Route::post('reject_booking_campaign', [CampaignsController::class, 'reject_booking_campaign']);

    Route::group(['middleware' => ['auth:sanctum'/*,'user.check'*/]], function () {
        Route::get('/user', 'UserController@getUser');
        Route::get('/userAccessories', 'SpinnersController@getAccessories');
        Route::get('/completed', 'UserController@getCompletedData');
        Route::post('/complete-profile/{user}', 'UserController@completeProfile');
        Route::post('/complete-profile-v2/{user}', 'UserController@completeProfileV2');
        Route::post('/edit-complete-profile/{user}', 'UserController@editCompleteProfile');
        Route::post('/resend-verification', 'AuthenticationController@resendVerification');
        Route::post('/check-user-status/{user}', 'UserController@chechUserStatus');
        Route::put('switch-user', 'UserController@switchUser')->middleware('auth:sanctum');
		Route::post('/upload_files', 'UserController@uploadFiles');

        Route::group(['namespace' => 'BrandDashboard', 'prefix' => 'brand_dashboard' ,'middleware' => ['user.check']], function () {

            Route::get('getCampaigns', [CampaignController::class, 'getCampaigns']);
            Route::get('getCurrentCampaign', [CampaignController::class, 'getCurrentCampaign']);
            Route::get('getCurentCampaigns', [CampaignController::class, 'getCurrentCampaigns']);
            Route::get('getUpcomingCampaigns', [CampaignController::class, 'getUpcomingCampaigns']);
            Route::get('noneActionCampaigns', [CampaignController::class, 'noneActionCampaigns']);
            Route::post('confirmCampaign', [CampaignController::class, 'confirmCampaign']);
            Route::post('rejectCampaign', [CampaignController::class, 'rejectCampaign']);
            Route::post('influencerCoverge', [CampaignsController::class, 'influencerCoverge']);
            Route::get('channels_types', [CampaignsController::class, 'channels_types']);
            Route::post('chart', [CampaignsController::class, 'chart']);
            Route::post('requestToCancelCampaign', [CampaignsController::class, 'request_to_cancel']);
            Route::get('getCompleteProfilePercentage',[InfluencerController::class,'getCompleteProfilePercentage']);


            Route::get('/statistics', 'HomeController@getStatistics')->name('statistics');
            Route::post('/getcharts', 'HomeController@getBrandCharts')->name('getcharts');
            Route::apiResource('campaigns', 'CampaignsController');
            Route::post('campaigns_filter', 'CampaignsController@index');
            Route::get('get_type_status', 'CampaignsController@get_campaign_type_status');

            Route::get('get_campaign_data', 'CampaignsController@campaign_data');
            Route::get('Subbrand_get_list', 'CampaignsController@Subbrand_get_list');
            Route::get('get_currency', 'CampaignsController@getCurrencyCode');

            Route::post('camp_influes/import/{id}', 'CampaignsController@CampaignInfluencerImport')->name('influe.export');
            Route::post('stop_campaign_visits/{id}', 'CampaignsController@campaignStopVisits')->name('camps.stopVisits');
            Route::post('hold_campaign/{id}', 'CampaignsController@holdCampaign')->name('camps.hold');
            Route::post('cancel_campaign_influencers', 'CampaignsController@cancelInfluencerCampaign')->name('camps.cancelInfluencer');
            Route::post('request_new_date', 'CampaignsController@requestNewDate')->name('camps.requestNewDate');
            Route::post('delete-campaigns', 'CampaignsController@destroyAll');
            Route::post('remove-influencers', 'CampaignsController@removeInfluencers');
            Route::get('active-campaigns', 'CampaignsController@index')->name('active.campaigns');
            Route::get('history_campaign', 'CampaignsController@index')->name('history.campaigns');
            Route::get('upcoming-campaigns', 'CampaignsController@index')->name('upcoming.campaigns');
            Route::get('pending-campaigns', 'CampaignsController@index')->name('pending.campaigns');
            Route::get('refused-campaigns', 'CampaignsController@index')->name('refused.campaigns');
            Route::post('rate-campaign-show', 'CampaignsController@rate_campaign_show');
            Route::post('get-campaign-data-show', 'CampaignsController@getCampaignData');
			Route::get('influencer_visited_campaign/{influencer}', 'CampaignsController@VisitedCampaignByInfluencerId');

            Route::apiResource('sub-brands', 'SubBrandController');
            Route::apiResource('branches', 'BranchController');
            Route::apiResource('group-lists', 'GroupListController');
            Route::post('branches/delete-all', 'BranchController@delete_all');
            Route::get('branch-campaigns/{branch}', 'BranchController@branchCampaigns');
            Route::post('subbrands/delete-all', 'SubBrandController@delete_all');
            Route::post('/contact-us', 'HomeController@contact_us');
            Route::post('/group-lists/delete-all', 'GroupListController@delete_all');
            Route::post('/group-lists/copyInflue', 'GroupListController@copyInflue');
            Route::post('/group-lists/moveInflue', 'GroupListController@moveInflue');
            Route::post('/group-lists/removeInflue', 'GroupListController@removeInflue');
            Route::post('/edit-profile', 'BrandController@edit_profile');
            Route::get('/get-brand-countries/{brand}', 'BrandController@get_brand_countries');
            Route::get('/influencers-list', 'InfluencersController@brandInfluencers');
            Route::post('/get_influencer_list', 'InfluencersController@getAllInfluencers');
            Route::get('/get_brand_influencer', 'InfluencersController@getBrandInfluencers');
            Route::get('/influencer/get-filter-influencer-data', 'InfluencersController@getFilterInfluencerData');

            Route::get('/export/instagram-logs', 'InfluencersController@instagramLogsExport');
            Route::get('/export/tiktok-logs', 'InfluencersController@tiktokLogsExport');
            Route::get('/export/snapchat-logs', 'InfluencersController@snapchatLogsExport');
            Route::get('/export/twitter-logs', 'InfluencersController@twitterLogsExport');

            /*=====================scraper===============*/
			Route::get('/influencer_profile/{influencer}', 'InfluencersController@getInfluencerProfile');
            Route::get('/scrap_instagram/{influencer}', 'InfluencersController@scrap_insta');
			Route::get('/scrap_tiktok/{influencer}', 'InfluencersController@scrap_tiktok');
            Route::get('/scrap_snap/{influencer}', 'InfluencersController@scrap_snap');
			Route::get('/scrap_twitter/{influencer}', 'InfluencersController@scrap_Twitter');


			Route::post('/rate-influencer','InfluencersController@rate_influencer');//

            Route::post('/compare_users', 'InfluencersController@compare_users');
            Route::patch('/influencer/fav-toggle/{influencer}', 'InfluencersController@favToggle');
            Route::patch('/influencer/dislike-toggle/{influencer}', 'InfluencersController@dislikeToggle');
            Route::post('/influencer/dislike-toggle-all', 'InfluencersController@dislikeToggleAll');
            Route::post('/influencer/bulk-unfav', 'InfluencersController@bulkFavToggle');
            Route::get('/influencer/groups', 'InfluencersGroupController@allGroups');
            Route::get('celebrity_campaigns', [CampaignController::class, 'celebrityCampaigns']);
            Route::post('change_camp_influ_status', [CampaignController::class, 'changeCampaingInfluencerStatus']);
            Route::post('/influencer/add-group', 'InfluencersGroupController@addGroup');
            Route::post('/influencer/add-to-groups', 'InfluencersGroupController@addToGroups');
            Route::get('p_cloud', [CampaignController::class, 'PCloudHandle']);


        });
    });

    Route::group(['prefix' => 'spinner'], function () {
        Route::get('countries', 'SpinnersController@countries');
        Route::get('influ-social-type', 'SpinnersController@influ_social_type');
        Route::get('cities', 'SpinnersController@cities');
        Route::get('sub-brands', 'SpinnersController@getSubBands');
        Route::get('branches', 'SpinnersController@getBranches');
        Route::get('brand_branches', 'SpinnersController@getBrandBranches');
        Route::get('group-list', 'SpinnersController@getGroupList');
        Route::get('states/{country}', 'SpinnersController@getStates');
        Route::get('states-cities/{state}', 'SpinnersController@getStateCities');
        Route::get('states-country/{country}', 'SpinnersController@getCountryCities');
        Route::get('get-complete-profile', 'SpinnersController@getCompleteProfileData');
        Route::get('languages', 'SpinnersController@languages');
        Route::get('jobs', 'SpinnersController@jobs');

    });

    Route::get('/{slug}', 'HomepageController@getPage');

});


/** */
Route::post('change_influencer_status','WebServiceController@campaignConfirmation');




