<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ContactRequest;
use App\Http\Requests\API\ReplyRequest;
use App\Http\Resources\API\PagesResource;
use App\Http\Resources\API\ArticlesResource;
use App\Http\Resources\API\CaseStudiesResource;
use App\Http\Resources\API\SettingResource;
use App\Http\Resources\API\FAQSResource;
use App\Http\Requests\API\CommentRequest;
use App\Http\Requests\Api\InfluencerImport;
use App\Http\Requests\Api\InfluencerImportRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\AboutUs;
use App\Models\Campaign;
use App\Models\CaseStudies;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Article;
use App\Models\CampaignInfluencer;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Faq;
use App\Models\Influencer;
use App\Models\Interest;
use App\Models\Nationality;
use App\Models\OurSponsors;
use App\Models\Page;
use App\Models\Reply;
use App\Models\Setting;
use App\Models\Statistic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;
use App\Http\Traits\SocialScrape\InstagramScrapeFacebookTrait;
use App\Http\Traits\SocialScrape\InstagramScrapeTrait;

class HomepageController extends Controller
{
    use ResponseTrait,HasTranslations,InstagramScrapeFacebookTrait,InstagramScrapeTrait;

    public function countries(){
            if(\request()->countrycode){
                $countries = Country::has('states.cities')->orderByRaw('code = ? desc',[Str::lower(\request()->countrycode)])->get();
            }else{
                $countries = Country::has('states.cities')->get();
            }
        $countries->map(function ($country){
            $country->code = Str::lower($country->code);
            $country->url = 'https://hatscripts.github.io/circle-flags/flags/'.Str::lower($country->code).'.svg';
        });

        return $this->returnData('countries', $countries, 'countries returned successfully');
    }

    public function getDataHomePage(){
        $data = [];
        $sponsors = OurSponsors::select('image','id','title')->where(['status'=>1,'priority'=>1])->inRandomOrder()->limit(20)->get();
        $statistics = Statistic::where('active',1)->get()->map(function ($statis){
			return ['id'         => $statis->id,'title'      => $statis->title,'body'      =>$statis->body,
				   'image'      => $statis->image,'count'     =>$statis->count ];
			});
		
        $caseStudies = CaseStudies::latest()->inRandomOrder()->limit(9)->get();
		$caseStudies = CaseStudiesResource::collection($caseStudies);

		$setting = Setting::first();
		$setting = new SettingResource($setting);
	
		$data=[
			'setting'=>$setting,
			'sponsors'=>$sponsors,
			'statistics'=>$statistics,
			'case_study'=>$caseStudies,
		];


        return $this->returnData('data', $data, 'data returned successfully');

    }
    public function getCaseStudyPage(Request $request){

        $caseStudies = CaseStudies::paginate(9);
        tap($caseStudies)->map(function($item){
            $arr = explode(",", $item->image);
            $image = ltrim($arr[0], '[');
           $image =  trim($image,'\'"'); 
            $item->image = request()->getSchemeAndHttpHost().'/photos/case_studies/'.$image;
            if($item->campaign_name)
               @$item->campaign_name = Campaign::whereId($item->campaign_name)->first()->name;
        });
        // $request->header('x-total-count', CaseStudies::count());
        return response()->json(['data'=>$caseStudies,'x_total_count'=>CaseStudies::count()]);
        // return $this->returnData('data', $caseStudies, 'data returned successfully');
    }

    public function get_about_us_data()
    {
        $about_us = AboutUs::all();
        $about_us->map(function($item){
            $item->welcome_message = json_decode($item->welcome_message,true)[app()->getLocale()];
            $item->vision = json_decode($item->vision,true)[app()->getLocale()];
            $item->mission = json_decode($item->mission,true)[app()->getLocale()];
            $item->services = json_decode($item->services,true)[app()->getLocale()];
            $item->features = json_decode($item->features,true)[app()->getLocale()];
            $item->about_owner = json_decode($item->about_owner,true)[app()->getLocale()];
            $item->clients = json_decode($item->clients,true)[app()->getLocale()];
            $item->image =  request()->getSchemeAndHttpHost().'/front/images/about-us/image.png';
        });
        return $this->returnData('data', $about_us, 'data returned successfully');
    }

    public function getCaseStudiesRelated($id){
      
        $caseStudies = CaseStudies::where('category_id',$id)->get();
        $caseStudies->map(function($item){
            $item->image = json_decode($item->image,true);
            if($item->campaign_name)
                $item->campaign_name = Campaign::whereId($item->campaign_name)->first()->name;
        });
        return response()->json(['data'=>$caseStudies,'x_total_count'=>CaseStudies::count()]);
    }
    public function getCaseStudyById($id){
        $caseStudies = CaseStudies::find($id);
        $caseStudies->image = json_decode($caseStudies->image,true);
        $caseStudies->channels = json_decode($caseStudies->channels,true);
        if($caseStudies->campaign_name)
            $caseStudies->campaign_name = Campaign::whereId($caseStudies->campaign_name)->first()->name;

        return $this->returnData('data', $caseStudies, 'data returned successfully');
    }

    public function InfluencerImport(InfluencerImportRequest $request){
       $data =   CampaignInfluencer::create($request->validated);
        return $this->returnData('data', $data, 'data returned successfully');
    }

    public function getLogo(){

        $array=[];

        $data = Setting::select('facebook','twitter','image','company_name','instagram','snapchat','linkedin','google_play','app_store','youtube','pinterset','desc_en','desc_ar')->first();

        $array=[["icon"=>'mdi-facebook','iconOld'=>'fab fa-facebook-f', "url"=>$data->facebook],['icon'=>'mdi-twitter','iconOld'=>'fab fa-twitter', "url"=>$data->twitter],
            ['icon'=>'mdi-instagram','iconOld'=>'fab fa-instagram', "url"=>$data->instagram],['icon'=>'mdi-snapchat','iconOld'=>'fab fa-snapchat-ghost',"url"=>$data->snapchat],
            ['icon'=>'mdi-linkedin','iconOld'=>'fab fa-linkedin-in', "url"=>$data->linkedin],
            ['icon'=>'mdi-youtube','iconOld'=>'fab fa-youtube', "url"=>$data->youtube],['icon'=>'mdi-pinterest','iconOld'=>'fab fa-pinterest-p',"url"=>$data->pinterset]];
        $array['logoPage'] = getLogoImage();
        $array['companyName'] = getCompanyName();
        $array['desc_en'] = $data->desc_en??'--';
        $array['desc_ar'] = $data->desc_ar??'--';
        return $this->returnData('data', $array, 'data returned successfully');

    }

    public function saveContact(ContactRequest $request){
        $input=$request->except('whatsapp','checkWhats');

        if(!$request->input('checkWhats')){
            $input['whatsapp']=$request->phone;
             Contact::create($input);
        }else{
             Contact::create($input);
        }

        return $this->returnData('data', '', 'data returned successfully');
    }

    public function nationalities(){
        return $this->returnData('nationalities', nationalities(), 'nationalities returned successfully');
    }
    
    public function nationalities_search(){
        $nationality = Nationality::where('name', 'LIKE', '%'.request('text').'%')->paginate(5);
        return $this->returnData('nationalities', $nationality, 'nationalities returned successfully');
    }

    public function pages(){

        $pages =  Page::whereStatus(1)->get();
        return $this->returnData('data', PagesResource::collection($pages), 'pages returned successfully');
    }

    public function faqs(){
        $faqs =  Faq::all();
        return $this->returnData('data', FAQSResource::collection($faqs), 'articles returned successfully');
    }

    public function articles(Request $request){
        
        $limit=$request->limit;
        $articles =  Article::orderBy('created_at', 'desc')->whereStatus(1)->paginate($limit);
        return $this->returnData('data', ArticlesResource::collection($articles)->response()->getData(true), 'articles returned successfully');
    }

    public function article($id){
        $article =  Article::with(['approved_comments.active_replies'])->where('id',$id)->whereStatus(1)->first();
        return $this->returnData('data', new ArticlesResource($article), 'articles returned successfully');
    }

    public function save_comments(CommentRequest $request){
        $comment = Comment::create($request->validated());
        return $this->returnData('comment', $comment, 'comment saved successfully');
    }

    public function save_replies(ReplyRequest $request){
        $reply = Reply::create($request->validated());
        return $this->returnData('comment', $reply, 'reply saved successfully');
    }

    public function getPage($slug){
        $page =  Page::where('slug',$slug)->first();
        if(!$page)
           return $this->returnError('404','data not found');
        return $this->returnData('data', new PagesResource($page), 'page returned successfully');
    }

    public function get_all_categories(){
        $categories = Category::all();
        return $this->returnData('data', $categories, 'data returned successfully');
    }
    public function get_all_sponsors(Request $request){
        $data = $request['data'];
//        dd($data);
        $page = $request['page'];
        $limit = $request['limit'];
        if($data != 0){
            $sponsors = OurSponsors::where('category_id',$data)->where('status',1)->orderBy('priority','DESC')->get();
        }else{
            $sponsors = OurSponsors::limit($limit)->where('status',1)->orderBy('priority','DESC')->paginate($limit);
        }
        $sponsors->map(function ($single) {
            $new_image = storage_path('photos/sponsors/' . $single['image']);
            return $new_image;
        });

        return $this->returnData('data', $sponsors, 'data returned successfully');

    }

    /**interests
     * @return \Illuminate\Http\JsonResponse
     */
    public function interests(){
        $interests = Interest::whereStatus(1)->select('id','interest','status')->get();
        return $this->returnData('interests', $interests, 'interests returned successfully');
    }
    public function common(){

        $data=[
            'caseStudies'=>CaseStudies::exists(),
            'blogs'=>Article::exists()
        ];
        return $this->returnData('data', $data, 'Data returned successfully');

    }

	public function scrapinstabyfacebook(Influencer $influencer)
    {
      //  dd($influencer);
      //  try {
		
            $data = $this->scrapiacebook($influencer);
			return $this->returnData('data',$data,'influencers data');
       // } catch (\Exception $e) {
            return response()->json(['status' => false], 500);
       //}
    }
    
	public function scrapinsttest(Influencer $influencer)
    {
       // dd($influencer);
      //  try {
		$all_data = Influencer::where('id','<=',3878)->where('id','>=',3850)->get();
         foreach($all_data as $item){
             if(!$item)
              continue;
              
            $data = $this->scrapInstagram($item);
         }
			return $this->returnData('data',$data,'influencers data');
       // } catch (\Exception $e) {
            return response()->json(['status' => false], 500);
       //}
    }
	
}
