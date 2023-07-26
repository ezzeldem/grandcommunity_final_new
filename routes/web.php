<?php

use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Admin\BrandsController;
use App\Http\Controllers\Admin\ChangeDetailInfluencerController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\InfluencerController;
use App\Http\Controllers\Admin\OperationsController;
use App\Http\Controllers\Admin\OurSponsorsController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\NotificationController;
//use App\Http\Livewire\MemberAdd;
use Facade\FlareClient\View;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/test-email', function () {
    return view('front.emails.forget_password');
});
Route::get('/event', [NotificationController::class, 'index']);

Route::view('/not_authrize', 'admin.dashboard.not_authrize')->name('not_authrize');

Route::group(['middleware' => 'guest', 'as' => 'dashboard.', 'namespace' => 'Auth'], function () {
    Route::get('/login', 'LoginController@create')->name('login');
    Route::post('/login', 'LoginController@store')->name('login.store');
});
Route::post('/logout', 'Auth\LoginController@destroy')->name('logout');

// Route::get('/',function (){
//    return redirect()->route('dashboard.login');
// });

Route::view('showImage', 'showImage')->name('showImage');
Route::get('/', 'HomeController@index')->middleware('auth:web');
Route::get('/digial_card/{username}/{influencercode}', 'InfluencerDigitalCardController@index');
Route::get('/404', 'InfluencerDigitalCardController@NOTFound');

Route::group(['middleware' => ['auth:web'], 'prefix' => 'dashboard', 'as' => 'dashboard.'], function () {

    Route::resource('/create-campaign', 'NewCampaignController');
    //Route::get('/add-member' ,[MemberAdd::class,'__invoke'])->name('add-member');
    Route::get('/', 'HomeController@index')->name('index');
    Route::get('/getactivecamps', 'HomeController@getactivecamps')->name('getactivecamps');
    Route::get('/get-country-code/{id}', 'HomeController@countryFlag')->name('getCountryCode');
    Route::get('/recent-users', 'HomeController@getRecentUsers')->name('index.recent.users');
    Route::get('/brand-countries/{id}', 'HomeController@getBrandCountry')->name('index.brand.countries');
    Route::get('/complains', 'HomeController@getComplains')->name('complains');
    Route::post('/replying', 'HomeController@addReply')->name('reply');
    Route::get('/complain/update_status', 'HomeController@update_complain_status');
    Route::get('/users-view/{user}', 'HomeController@viewUser')->name('index.view.user');
    Route::post('/users-accept/{user}/{expire_date}', 'HomeController@acceptUser')->name('index.accept.user');
    Route::put('/users-reject/{user}', 'HomeController@rejectUser')->name('index.reject.user');
    Route::put('/users-forcereject/{user}', 'HomeController@forcerejecttUser')->name('index.forcereject.user');
    Route::put('/users-inactive/{user}', 'HomeController@inactiveUser')->name('index.inactive.user');
    Route::put('/active-campaign/{campaign}', 'HomeController@activeCampaign')->name('index.active.campaign');
    Route::put('/delete-campaign/{campaign}', 'HomeController@deleteCampaign')->name('index.delete.campaign');
    Route::get('/edit-profile', 'HomeController@editprofile')->name('editprofile');
    Route::post('/update-profile', 'HomeController@updateprofile')->name('updateprofile');
    Route::get('/filterSectionsStats', 'HomeController@filterSectionsStats')->name('filterSectionsStats');
    Route::post('import/{status}', 'CampaignInfluencersController@pendingimport')->name('import.visit.camp');
    Route::get('/getselectcountry', 'CampaignController@getcountriesselected')->name('getselectcountry');

    //////////// start Admins routes //////////////////////
    Route::resource('/admins', 'AdminsController');
    Route::get('/get-admins', 'AdminsController@getAdmins')->name('admins.get_data');
    Route::delete('/del-all/admins', 'AdminsController@bulkDelete')->name('admins.delete_all');
    Route::post('/admins/edit_all', 'AdminsController@edit_all')->name('admins.edit_all');
    Route::post('adminimport', [AdminsController::class, 'import'])->name('importadmin.import');
    Route::post('/admins-toggle-status/{admin}', 'AdminsController@statusToggle')->name('admins.status-toggle');
    Route::get('admin/export', 'AdminsController@export')->name('admins.export');
    //////////// end Admins routes //////////////////////
    ///   //////////// start OurSponsors routes //////////////////////
    Route::resource('/our-sponsors', 'OurSponsorsController');
    Route::get('/get-our-sponsors', 'OurSponsorsController@getOurSponsors')->name('our-sponsors.get_data');
    Route::post('our-sponsors/delete-all', 'OurSponsorsController@delete_all')->name('our_sponsors.delete_all');
    Route::post('/our-sponsors/edit_all', 'OurSponsorsController@edit_all')->name('our_sponsors.edit_all');
    Route::post('/our-sponsors-toggle-status/{id}', 'OurSponsorsController@statusToggle')->name('our-sponsors.status-toggle');
    Route::post('sponsors/delete-all', [OurSponsorsController::class, 'delete_all'])->name('sponsors.delete_all');
    Route::post('sponsors/edit-all', [OurSponsorsController::class, 'edit_all'])->name('sponsors.edit_all');
    //////////// end OurSponsors routes //////////////////////
    //////////// start Operations routes //////////////////////
    Route::resource('/operations', 'OperationsController');
    Route::get('/get-operations', 'OperationsController@getOperations')->name('operations.get_data');
    Route::delete('/del-all/operations', 'OperationsController@bulkDelete')->name('operations.delete_all');
    Route::post('/operations/edit_all', 'OperationsController@edit_all')->name('operations.edit_all');
    Route::post('importoperation', [OperationsController::class, 'import'])->name('importoperation.import');
    Route::post('/import/operations', 'OperationsController@import')->name('operations.import');
    Route::post('/operations-toggle-status/{operation}', 'OperationsController@statusToggle')->name('operations.status-toggle');
    Route::get('operation/export', 'OperationsController@export')->name('operations.export');
    Route::post('operation/store/task', 'TaskController@store')->name('operation.store.task');
    Route::get('operation/get_assigned_status', 'TaskController@getAssignedStatus')->name('operations.getAssignedStatus');
    //////////// start Communities routes //////////////////////
    Route::resource('/community', 'CommunityController');
    Route::get('/get-communities', 'CommunityController@getCommunities');
    Route::delete('/del-all/community', 'CommunityController@bulkDelete')->name('community.delete_all');
    Route::post('/communities/edit_all', 'CommunityController@edit_all')->name('community.edit_all');
    Route::post('/import/community', 'CommunityController@import')->name('community.import');
    Route::post('/community-toggle-status/{community}', 'CommunityController@statusToggle')->name('community.status-toggle');
    Route::get('community/export', 'CommunityController@export')->name('community.export');
    Route::post('community/store/task', 'TaskController@store')->name('store.task');
    Route::get('community/get_assigned_status', 'TaskController@getAssignedStatus')->name('community.getAssignedStatus');
    //////////// start Operations routes //////////////////////
    Route::resource('/tasks', 'TaskController');
    // task.edit_all
    Route::get('/get-tasks', 'TaskController@getTasks')->name('tasks.get_data');
    Route::get('/task/status/toggle/{id}', 'TaskController@toggleStatus');
    Route::delete('/del-all/task', 'TaskController@bulkDelete')->name('tasks.delete_all');
    // Route::post('/task/edit_all' ,'TaskController@edit_all')->name('tasks.edit_all');
    // Route::post('/import/task' ,'TaskController@import')->name('tasks.import');
    Route::post('/task-toggle-status/{operation}', 'TaskController@statusToggle')->name('tasks.status-toggle');
    // Route::get('task/export', 'TaskController@export')->name('tasks.export');
    Route::get('task/get_assigned_status', 'TaskController@getAssignedStatus')->name('tasks.getAssignedStatus');
    //////////// end Admins routes //////////////////////
    //////////// start Sales routes //////////////////////
    Route::resource('/sales', 'SalesController');
    Route::get('/get-sales', 'SalesController@getSales')->name('sales.get_data');
    Route::delete('/del-all/sales', 'SalesController@bulkDelete')->name('sales.delete_all');
    Route::post('/sales/edit_all', 'SalesController@edit_all')->name('sales.edit_all');
    Route::post('/getimportsales/sales', [SalesController::class, 'import'])->name('getimportsales.import');
    Route::post('/sales-toggle-status/{sales}', 'SalesController@statusToggle')->name('sales.status-toggle');
    Route::get('/export/sales', 'SalesController@export')->name('sales.export');
    //////////// end Sales routes //////////////////////
    //////////// start roles routes //////////////////////
    Route::resource('/roles', 'RolesController');
    Route::get('/get-roles', 'RolesController@getRoles')->name('roles.get_data');
    Route::get('checkRoles/{role}', 'RolesController@CheckRole');

    //////////// start Offices routes //////////////////////
    Route::apiResource('/offices', 'OfficeController')->only('index', 'store', 'update', 'destroy');
    Route::get('/get-offices', 'OfficeController@getOffices')->name('offices.get_data');
    Route::get('/getOffice/{office}', 'OfficeController@getOffice')->name('offices.getOffice');
    Route::post('/offices-toggle-status/{office}', 'OfficeController@statusToggle')->name('office.status-toggle');
    Route::get('/offices/export', 'OfficeController@export')->name('offices.export');
    Route::post('/offices/edit_all', 'OfficeController@editAll')->name('offices.edit_all');
    //////////// end roles routes //////////////////////
    //////////// start Influncer routes //////////////////////
    Route::resource('/influences', 'InfluencerController');
    // ---------------- SELECT2 ----------------
    Route::get('/get_nationalities', 'InfluencerController@getNationalities');
    Route::get('/get_governorate', 'InfluencerController@getGovernorate');
    Route::get('/get_brand', 'InfluencerController@getBrand');
    Route::get('/get_countries', 'InfluencerController@getCountries');
    Route::get('/get_status', 'InfluencerController@getStatus');
    Route::get('/get_influencer_status', 'InfluencerController@getInfluencerdata');
    Route::post('/update_influencer_status', 'InfluencerController@UpdateInfluencerdata');
    // ---------------- SELECT2 ----------------
    Route::post('/influencer-change_status', 'InfluencerController@changeInfluencerStatus')->name('influencer-change_status');

    Route::get('/get-sub-brand-by-brand-id', 'InfluencerController@getSubBrandsListByBrandId')->name('getSubBrandsListByBrandId');
    Route::get('/get-groups-list-by-sub-brand-id', 'InfluencerController@getGroupsListBySubBrandId')->name('getGroupsListBySubBrandId');
    Route::get('/get-groups-list-by-brand-id', 'InfluencerController@getGroupsListByBrandId')->name('getGroupsListByBrandId');
    Route::get('/get-states-list-by-country-id', 'InfluencerController@getStatesListByCountryId')->name('getStatesListByCountryId');
    Route::get('/get-cities-list-by-state-id', 'InfluencerController@getCitiesListByStateId')->name('getCitiesListByStateId');

    Route::get('/get-influences', 'InfluencerController@getInfluencer')->name('influencer.get_data');
    Route::get('/state/one_influ_or_more', 'InfluencerController@getAllInfluencer')->name('influencer.getAllInfluencer');
    Route::post('/state/update_status', 'InfluencerController@updateStatus')->name('influencer.update_status');
    Route::get('/state/{id}', 'InfluencerController@getCountryState')->name('influencer.getStateCountry');
    Route::get('/city/{id}', 'InfluencerController@getCityState')->name('influencer.getCityState');
    Route::get('social-scrape/{id}', 'InfluencerController@getScrape')->name('influencer.scrape');
    Route::post('influencer/instagram', 'InfluencerController@instagramData')->name('influencer.instagram');
    Route::post('influencer/snapchat', 'InfluencerController@snapchatData')->name('influencer.snapchat');
    Route::post('influencer/tiktok', 'InfluencerController@tiktokData')->name('influencer.tiktok');
    Route::get('/influencer/generate-codes/{id}', 'InfluencerController@regenerateCodes')->name('influencer.generate-codes');
    Route::post('influe/delete-all', [InfluencerController::class, 'delete_all'])->name('influe_delete_all');
    Route::get('influe/get-statistics', [InfluencerController::class, 'statictics'])->name('influe_statictics');

    Route::post('influe/edit-all', [InfluencerController::class, 'edit_all'])->name('influe_edit_all');
    Route::post('influe/import', [InfluencerController::class, 'import'])->name('influencer.import');
    Route::post('influe/get_confirmation', [InfluencerController::class, 'get_influencer_confirmation'])->name('influencer.get_confirmation');
    Route::post('influe/get_visits', [InfluencerController::class, 'get_influencer_visits'])->name('influencer.get_visits');
    Route::post('influe/influ_details', [InfluencerController::class, 'get_influencer_details'])->name('influencer.influ_details');
    Route::post('influe/submit_influ_change_details', [ChangeDetailInfluencerController::class, 'submit_influ_change_details']);
    Route::post('influe/delete_campaign_influencers_visits', [InfluencerController::class, 'influe_visits_delete_all'])->name('campaign.influencers.visits.delete_all');
    Route::post('influe/confirmation/update', [InfluencerController::class, 'update_confirmation'])->name('influencer.update_confirmation');
    Route::post('influe/complain', [InfluencerController::class, 'get_influencer_CampaignControllercomplain'])->name('influencer.complain');
    Route::post('influe/complain/store', [InfluencerController::class, 'complain_store'])->name('influencer.store.complain');
    Route::post('influe/complain/update_status', [InfluencerController::class, 'update_complain_status'])->name('influencer.complain.update');
    Route::post('influe/groups_create', [InfluencerController::class, 'create_group'])->name('brand.groups.create.influe');
    Route::post('influe/AddInflue_to_group', [InfluencerController::class, 'AddInflue_to_group'])->name('brand.groups.AddInflue_to_group');
    Route::get('influe/export', [InfluencerController::class, 'export'])->name('influe.export');
    Route::post('influencer_restore-all', 'InfluencerController@restore_all')->name('influencer.restore_all');
    Route::post('influencer-restore-disliked-all', 'InfluencerController@restore_influ_dislikes')->name('influencer.restore_disliked_all');
    Route::post('influencer_delete_fav_all', 'InfluencerController@delete_fav_all')->name('influencer.delete_fav_all');
    //////////// end influencer routes //////////////////////
    ///
    //////////// start brand routes //////////////////////
    Route::resource('/brands', 'BrandsController');
    Route::post('/brand/groups/{id}', 'BrandsController@getBrandGroups')->name('brand.get_groups');
    Route::get('/allbrands/{id}', 'BrandsController@getAllBrands')->name('brand.get_all');
    Route::get('/brand_groups/{id}', 'BrandsController@getGroupListOfBrand')->name('groups');
    Route::get('/brand/brand-campaigns-datatable/{id}', 'BrandsController@getCampaigns')->name('brand.campaigns.datatable');
    Route::get('/brand/brand-branches-datatable/{id}', 'BrandsController@getBranches')->name('brand.branches.datatable');
    Route::get('/get-brands', 'BrandsController@getBrand')->name('brand.get_data');
    Route::get('/get_brand_countries', 'BrandsController@getBrandCountries');
    Route::post('/update_brand_countries', 'BrandsController@updateBrandCountries');
    Route::post('/campaign-change_status', 'CampaignController@updateCampaign_Status');
    Route::post('/brand-change_status', 'BrandsController@updateBrand_Status');

    Route::post('/get-brands-by-country/{country_id}', 'BrandsController@getBrandsByCountry');
    Route::post('/get-subbrand-by-brand/{country_id}/{brand_id}', 'BrandsController@getsubbrandsByBrands');
    Route::get('/get-brand-branches/{id}', 'BrandsController@getBrandBranches')->name('brand.get_data_branches');
    Route::get('/get-brand-campaigns/{id}', 'BrandsController@getBrandCampaigns')->name('brand.get_data_campaigns');
    Route::post('/add-new-branch', 'BrandsController@addNewBranch')->name('brand.addNewBranch');
    Route::post('import', 'BrandsController@import')->name('import');
    Route::post('dislikes/import', 'BrandsController@dislikesImport')->name('dislikesImport');
    Route::post('brand-favourites/add', 'BrandsController@addToFavourites')->name('addToFavourites');
    // Route::post('brand/export', 'BrandsController@export')->name('brand.export');
    Route::post('delete-all', 'BrandsController@delete_all')->name('delete_all');
    Route::post('edit-all', 'BrandsController@edit_all')->name('edit_all');
    Route::post('/brands-toggle-status/{brand}', 'BrandsController@statusToggle')->name('brand.status-toggle');
    Route::get('brand/export', 'BrandsController@export')->name('brands.export');
    Route::post('brands/deleteBrandBranch/{id}', 'BrandsController@deleteBrandBranch_new');
    Route::post('brands/toggle-brand-branch/{branch}', 'BrandsController@statusToggleBrandBranch');
    Route::get('brands/get-brand-branch-data/{branch}', 'BrandsController@getbrandbranchdata');
    Route::post('branches-all-delete-all', 'BrandsController@branches_all_delete_all')->name('branches.all.delete.all');
    Route::post('brand-subbrand-add', 'BrandsController@brand_subbrand_add')->name('brand-subbrand-add');
    Route::get('brand/branches_export/{id}', 'BrandsController@branches_export')->name('brands.branches.export');
    Route::post('brand/add_to_camp/', 'BrandsController@add_to_camp');
    Route::post('/brand-accept/{brand}', 'BrandsController@acceptBrand')->name('index.accept.brand');
    Route::post('/influencer-accept/{influencer}', 'InfluencerController@acceptInfluencer')->name('index.accept.influencer');
    Route::get('/brand-not-assignd-branches-to-subbrand/{id}/{country}', 'BrandsController@BrandNotAssignedBranchesToSubBrand');
    Route::get('brand/getresultsearch', [BrandsController::class, 'getstatictics'])->name('brand_getresultsearch');
    Route::post('brand/brand_all_details', [BrandsController::class, 'get_details']);
    Route::post('brand/brand_details', [BrandsController::class, 'get_brand_details'])->name('brand.brand_details');
    Route::get('get-subbrand-countries/{id}', [BrandsController::class, 'getSubbrandCountries'])->name('get_subbrand_countries');
    //////////// end brand routes //////////////////////

    //////////// start sub-brands routes //////////////////////
    Route::resource('/tasks', 'TaskController');
    Route::post('/tasks/import/', 'TaskController@import')->name('task.import');
    Route::post('del-all/tasks', 'TaskController@bulkDelete')->name('task.remove');
    Route::post('/task/edit_all', 'TaskController@editAll')->name('task.edit_all');

    //////////// start sub-brands routes //////////////////////
    Route::resource('/sub-brands', 'SubBrandsController');
    Route::get('/get-sub-brand-campaigns/{id}', 'SubBrandsController@getSubBrandCampaigns')->name('subbrand.get_data_campaigns');
    Route::get('/get-sub-brand-branches/{id}', 'SubBrandsController@getSubBrandBranches')->name('subbrand.get_data_branches');
    Route::get('/sub-brand', 'SubBrandsController@getSubBrands')->name('sub-brands.get_data');
    Route::delete('/subbrands/dels', 'SubBrandsController@bulkDelete')->name('sub-brands.delete_all');
    Route::post('/sub-brands/import', 'SubBrandsController@import')->name('sub-brands.import');

    Route::post('sub-brand/edit-all', 'SubBrandsController@edit_all')->name('sub-brand.edit_all');
    Route::post('/sub-brands-toggle-status/{subBrand}', 'SubBrandsController@statusToggle')->name('sub-brands.status-toggle');
    Route::get('/sub-brand/export', 'SubBrandsController@export')->name('sub-brands.export');

    //////////// end sub-brands routes //////////////////////
    Route::get('/dislike/{id}', 'BrandsController@dislikeList')->name('drand_dislike.get_data');
    Route::delete('/addtofavourite/{campaign_influ}', 'BrandsController@delete')->name('add-favourite.destroy');
    Route::delete('/addtofavourite/bulk/delete', 'BrandsController@bulkDelete')->name('add-favourite.bulk-delete');

    //////////// start branches routes //////////////////////
    Route::resource('branches', 'BranchesController');
    Route::get('/get-branches', 'BranchesController@getBranches')->name('branches.get_data');
    Route::delete('/del-all/branches', 'BranchesController@bulkDelete')->name('branches.delete_all');
    Route::post('branches/edit-all', 'BranchesController@edit_all')->name('branches.edit_all');
    Route::post('/branches/import', 'BranchesController@import')->name('branches.import');
    Route::post('/branches-toggle-status/{branch}', 'BranchesController@statusToggle')->name('branches.status-toggle');
    Route::get('branches.export', 'BranchesController@export')->name('branches.export');

    //////////// end branches routes //////////////////////

    //////////// start campaigns routes //////////////////////
    Route::resource('/campaigns', 'CampaignController');
    Route::get('/campaigns-datatable', 'CampaignController@datatable')->name('campaigns.datatable');
    Route::post('campaigns/{campaign_id}/update-campaign-quality', 'CampaignController@updateCampaignQuality')->name('campaigns.updateCampaignQuality');
    Route::post('campaigns/{campaign_id}/update-campaign-secret-keys', 'CampaignController@updateCampaignSecretKeys')->name('campaigns.updateCampaignSecretKeys');
    Route::get('/campaign-favouriteList-datatable', 'CampaignController@campaignFavouriteListDatatables')->name('campaigns.campaignFavouriteListDatatables');
    Route::delete('campaigns/bulk/delete', 'CampaignController@bulkDelete')->name('campaigns.delete_all');
    Route::get('/get-country-states', 'CampaignController@getStates');
    Route::get('/get-state-city/{id}', 'CampaignController@getStateCities');
    Route::get('/get-sub-brands/{id}', 'CampaignController@getSubBrands');
    Route::get('/get-sub-brands-branches/{id}', 'CampaignController@getSubBrandBranches');
    Route::get('/get-permission-by-type', 'CampaignController@permissionByType');
    Route::get('/getCampBranches', 'CampaignController@getCampBranches')->name('campaigns.countryBranches');
    Route::get('/campaign-favourite-list/{type}', 'CampaignController@campaignFavouriteListDatatables');
    Route::post('/campaign-toggle-status/{id}', 'CampaignController@toggleStatus');
    Route::POST('/campaigns-take_camp', 'CampaignController@takeCamp')->name('campaigns.take_camp');
    Route::POST('/camp-influ-deliverDetails', 'CampaignController@campDeliverDetails')->name('campaigns.deliverDetails');
    Route::POST('/camp-influ-noOfUses', 'CampaignController@noOfUses')->name('campaigns.noOfUses');
    Route::POST('/camp-coverage-update', 'CampaignController@camp_coverage_update');
    Route::put('/campaign/approveCancel/{id}', 'CampaignController@approveCancelCampaign')->name('approve.campaign.cancel');
    Route::put('/campaign/rejectCancel/{id}', 'CampaignController@rejectCancelCampaign')->name('reject.campaign.cancel');

    Route::post('campaign_complaint', 'CampaignInfluencersController@CampaignComplaign')->name('campaign_complaint');
    Route::get('/campaigns/influencers/counter', 'CampaignInfluencersController@campaignInfluencersCounter')->name('campaigns.influencers.status.counter');
    Route::delete('/campaign-influ/{campaign_influ}', 'CampaignInfluencersController@destroy')->name('campaign-influ.destroy');
    Route::delete('/campaign-influ/bulk/delete', 'CampaignInfluencersController@bulkDelete')->name('campaign-influ.bulk-delete');
    Route::post('/campaign-influ/influe_status', 'CampaignInfluencersController@influeStatus')->name('campaign-influ.influeStatus');
    Route::post('/campaign-influ/confirm_status', 'CampaignInfluencersController@confirm_status')->name('campaign-influ.confirm_status');
    Route::post('/campaign-influ/missed_visit', 'CampaignInfluencersController@missed_visit')->name('campaign-influ.missed_visit');
    Route::post('/campaign-influ/reject', 'CampaignInfluencersController@reject')->name('campaign-influ.reject');
    Route::post('/campaign/edit-coulmn', 'CampaignInfluencersController@edit_coulmn')->name('campaign.edit.column');
    Route::post('campaign/addInfluencerImport', 'CampaignInfluencersController@addInfluencerImport')->name('camp.addInfluencer.import');

    Route::post('/campaign-influ/updateInflueStatusPending', 'CampaignInfluencersController@updateInflueStatusPending')->name('campaign-influ.updateInflueStatusPending');
    Route::put('/campaignupdate-influ/bulk/update', 'CampaignInfluencersController@bulkDupdate')->name('campaignupdate-influ.bulk-update');

    Route::put('/campaignupdate-influ/{campaign_influ}', 'CampaignInfluencersController@updateinf');
    Route::post('/campaignupdate-influncer/{campaign_influ}', 'CampaignInfluencersController@bulkupdateinfluncer')->name('campaignupdate-influ.update');
    Route::post('/campaign-influ/generate-codes/', 'CampaignInfluencersController@generateCodes')->name('campaign-influ.generate-codes');
    Route::get('/generate-unique-secret', 'CampaignController@generateBrandUniquePassword');
    Route::post('/update_secret_status', 'CampaignController@updateSecretStatus');
    Route::post('/update_campaign_status', 'CampaignController@updateCampaignStatus');
    Route::delete('/delete-brand-secret/{id}', 'CampaignController@deleteBrandSecrete');
    Route::get('/export/campaign', 'CampaignController@export')->name('campaigns.export');
    Route::get('/log/campaign/{id}', 'CampaignController@campaignLog')->name('campaigns.log');
    Route::get('/logajax/campaign/{id}', 'CampaignController@campaignLogAjax')->name('campaigns.logajax');
    Route::get('/complainsajax/campaign/{id}', 'CampaignController@complainsAjax')->name('campaigns.complainajax');
    Route::get('/add-reply', 'CampaignController@addReply')->name('add-reply');
    Route::get('/get-influencers-by-country', 'CampaignController@getInfluencersByCountry')->name('campaigns.get-influencers-by-country');
    Route::post('/add-influencers-to-campaign', 'CampaignController@addInfluencersToCampaign')->name('campaigns.add-influencers-to-campaign');
    Route::get('/ajax/campaigns/calender-data', 'CampaignController@calenderData')->name('campaigns.calender_data');
    Route::post('/upload-campaign-report', 'CampaignController@uploadReport')->name('campaigns.upload-campaign-report');
    Route::post('/add_new_influenecrs_to_campaign', 'CampaignController@addNewInfluenecrsToCampaign')->name('campaigns.add_new_influenecrs_to_campaign');

    // Route::get('/get-sub-brands-branches/{id}' ,'InfluencerStatus@getSubBrandBranches');

    //////////// end campaigns routes //////////////////////
    ///////////////////////////// GroupListTraits /////////////////////////////////
    Route::get('groups/{id}', 'GroupListController@show')->name('brand.groups');
    Route::post('groups_create', 'GroupListController@create_groups')->name('brand.groups.create');
    Route::post('groups_delete-all', 'GroupListController@delete_all')->name('groups.delete_all');
    Route::post('groups_restore-all', 'GroupListController@restore_all')->name('groups.restore_all');
    Route::get('get-fav-groupList', 'GroupListController@groupListBrand')->name('groupList.brand');
    Route::post('copy_move_influe_group', 'GroupListController@copyInflueGroup')->name('groupList.copy.influe');
    Route::post('delete_influencer_fromGroup', 'GroupListController@deleteInflueGroup');
    Route::post('delete_dislike_influencer_fromGroup', 'GroupListController@deleteDislikeInflueGroup')->name('groupList.delete.influe');
    Route::post('groupList/import', 'GroupListController@import')->name('groupList.import');
    Route::get('groupList_merge/{brand}', 'GroupListController@getGroupsBrand');
    Route::post('groupList-merge-save', 'GroupListController@groupList_merge_save');

    //////////// start setting routes //////////////////////

    Route::resource('/setting', 'SettingController');
    Route::post('/update_setting', 'SettingController@saveupdated')->name('update_setting');
    Route::resource('/contacts', 'ContactController');
    Route::get('/get-contacts', 'ContactController@getContacts')->name('contacts.get_data');
    Route::post('contacts/delete-all', [ContactController::class, 'delete_all'])->name('contacts.delete_all');

    // pages
    Route::resource('pages', 'PagesController');
    Route::get('/pages-datatable', 'PagesController@datatable')->name('pages.datatable');
    Route::get('/get-pages', 'PagesController@getPages')->name('pages.get_data');
    Route::post('/pages-toggle-status/{id}', 'PagesController@toggleStatus');
    Route::post('/pages-status', 'PagesController@bulckStatus');
    Route::delete('pages-delete', 'PagesController@bulckDelete')->name('pages.delete');
    Route::delete('pages-section-delete/{id}', 'PagesController@DeleteSection')->name('pages.sections.delete');

    // statistics
    Route::resource('statistics', 'StatisticsController');
    Route::get('/get-statistics', 'StatisticsController@getStatistics')->name('statistics.datatable');
    Route::get('/controlhome', 'SettingController@controlHome')->name('controlhome.datatable');

    Route::post('/statistics-toggle-status/{statistic}', 'StatisticsController@statusToggle')->name('statistics.status-toggle');

    // faqs
    Route::resource('faqs', 'FaqController');
    Route::get('/get-faqs', 'FaqController@getFaqs')->name('faqs.datatable');
    Route::post('/faqs-toggle-status/{id}', 'FaqController@toggleStatus');
    Route::post('/faqs-status', 'FaqController@bulckStatus');

    // jobs
    Route::resource('jobs', 'JobsController');
    Route::get('/get-jobs', 'JobsController@getJobs')->name('jobs.datatable');
    Route::post('/jobs-toggle-status/{id}', 'JobsController@toggleStatus');
    Route::post('/jobs-status', 'JobsController@bulckStatus');

    // matchCampaign
    Route::resource('match-campaign', 'MatchCampaignController');
    Route::get('/get-match-campaign', 'MatchCampaignController@getMatchCampaigns')->name('match-campaign.datatable');
    Route::post('/match-campaign-toggle-status/{id}', 'MatchCampaignController@toggleStatus');
    Route::post('/match-campaign-status', 'MatchCampaignController@bulckStatus');

    // articles
    Route::resource('articles', 'ArticleController');
    Route::get('/articles-datatable', 'ArticleController@datatable')->name('articles.datatable');
    Route::post('/articles-toggle-status/{id}', 'ArticleController@toggleStatus');
    Route::post('/articles-status', 'ArticleController@bulckStatus');
    Route::delete('articles-delete', 'ArticleController@bulckDelete')->name('articles.delete');
    Route::delete('articles-section-delete/{id}', 'ArticleController@DeleteSection')->name('articles.sections.delete');

    // comments
    Route::get('comments/{id}', 'CommentController@index');
    Route::delete('comments/{id}', 'CommentController@destroy');
    Route::delete('comments-delete', 'CommentController@bulckDelete')->name('comments.delete');
    Route::get('/comments-datatable/{id}', 'CommentController@datatable')->name('comments.datatable');
    Route::post('/comments-toggle-status/{id}', 'CommentController@toggleStatus');
    Route::post('/comments-status', 'CommentController@bulckStatus');

    // replies
    Route::get('replies/{id}', 'ReplyController@index');
    Route::delete('replies/{id}', 'ReplyController@destroy');
    Route::delete('replies-delete', 'ReplyController@bulckDelete')->name('replies.delete');
    Route::get('/replies-datatable/{id}', 'ReplyController@datatable')->name('replies.datatable');
    Route::post('/replies-toggle-status/{id}', 'ReplyController@toggleStatus');
    Route::post('/replies-status', 'ReplyController@bulckStatus');

    Route::resource('caseStudies', 'CaseStudiesController');
    Route::get('/get-casestudies', 'CaseStudiesController@getCaseStudies')->name('casestudies.datatable');
    Route::get('/delete/case/{id}', 'CaseStudiesController@delete')->name('delete/case');
    Route::get('/get-campaigns', 'CaseStudiesController@get_campaigns')->name('get-campaigns');
    Route::get('/get-campaign-brand', 'CaseStudiesController@get_campaign_brand')->name('get-campaign-brand');

    Route::Post('/get-charts-data', 'HomeController@getChartsData')->name('get-charts-data');
    Route::Post('/get-charts-data', 'HomeController@getChartsData')->name('get-charts-data');
    Route::get('wishlist/export', [BrandsController::class, 'wishlistExport'])->name('wishlist.export');
    Route::get('campaign_influencer/export/{id}', 'CampaignController@CampaignInfluencerExport')->name('campaign_influencer_export');

    /////////////// end setting routes //////////////////////

    Route::get('session', function () {
        if (\request ('reset')) {
            session()->put('country', []);
            return redirect()->back();
        }
        if (\request ('country', [])) {
            $country = explode(",", \request ()->get('country'));
            array_map('strval', $country);
        } else {
            $country = [];
        }
        session()->put('country', $country);
    })->name("set_countries_session");
});

Route::get('/auth/redirect', function () {
    return Socialite::driver('facebook')->redirect();
});

Route::get('auth/facebook/callback', function () {
    $user = Socialite::driver('facebook')->stateless()->user();
});

route::get('checktable', function () {
    $dbTables = adminDbTablesPermissions();
    foreach ($dbTables as $tbl) {
        if ($tbl == 'brands_buttons') {
            dump('yes you have table brands_button');
        }
    }
});