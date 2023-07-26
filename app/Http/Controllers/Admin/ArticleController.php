<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleRequest;
use App\Http\Resources\Admin\ArticlesResource;
use App\Models\Article;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statistics['totalArticles'] = ['title'=>'Total Articles','count'=>Article::count(),'icon'=>'fab fa-bandcamp'];
        $statistics['totalActiveArticles'] = ['title'=>'Active Articles','count'=>Article::whereStatus(1)->count(),'icon'=>'fas fa-toggle-off'];
        $statistics['totalInActiveArticles'] = ['title'=>'InActive Articles','count'=>Article::whereStatus(0)->count(),'icon'=>'fas fa-toggle-on'];
        return view('admin.dashboard.setting.articles.index',  get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $routes =  [ ['route'=>route('dashboard.articles.index'),'name'=>'articles'] ];
        return view('admin.dashboard.setting.articles.create',  get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        // try {
            // DB::beginTransaction();
            $article = Article::create($request->validated());
            foreach($request->sub_title as $i => $title){
                $article->sections()->save(new Section([
                    'title' => handleInputLanguage($title),
                    'description' => handleInputLanguage($request['sub_description'][$i])
                ]));
            }       
            // DB::commit();
            return redirect(route('dashboard.articles.index'))->with(['successful_message' => 'Article Stored successfully']);

        // }catch (\Exception $ex){
        //     DB::rollBack();
        // }

        return redirect(route('dashboard.articles.index'))->with(['successful_message' => 'Article Stored successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
      
        // dd(explode(',', $article->getTranslation('tags','en')));
        $tags_en = collect(explode(',', $article->getTranslation('tags','en')));
        $tags_en = $tags_en->mapWithKeys(function($tag){
            return [ $tag => $tag ];  
        });
        $tags_ar = collect(explode(',', $article->getTranslation('tags','ar')));
        $tags_ar = $tags_ar->mapWithKeys(function($tag){
            return [ $tag => $tag ];  
        });
        $article->tags_en = $tags_en; 
        $article->tags_ar = $tags_ar;
        $routes =  [ ['route'=>route('dashboard.articles.index'),'name'=>'articles'] ];
        return view('admin.dashboard.setting.articles.edit',  get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {

        $data = $request->validated();
        try {
        DB::beginTransaction();        
        $article->update($data);
        foreach($request->sub_title as $i => $title){
            if(isset(request()->section_id[$i])){
                $check = $article->sections()->find(request()->section_id[$i]);
                if($check->exists()){
                    $check->update([
                        'title' => handleInputLanguage($title),
                        'description' => handleInputLanguage($request['sub_description'][$i])
                    ]);
                }else{
                    $article->sections()->create([
                        'title' => handleInputLanguage($title),
                        'description' => handleInputLanguage($request['sub_description'][$i])
                    ]);
                }
            }else{
                $article->sections()->create([
                    'title' => handleInputLanguage($title),
                    'description' => handleInputLanguage($request['sub_description'][$i])
                ]);
            }
        }
        DB::commit();
        return redirect(route('dashboard.articles.index'))->with(['successful_message' => 'Article Updated Successfully']);

        }catch (\Exception $ex){
            DB::rollBack();
        }
        
        return redirect(route('dashboard.articles.index'))->with(['successful_message' => 'Article Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }

    /**datatable
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Exception
     */
    public function datatable(){
        $articles = ArticlesResource::collection(Article::all());
        return datatables($articles)->make(true);
    }

    /**toggleStatus
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus($id){
        $article = Article::find($id);
        $article->update(['status' => !$article->status]);
        return response()->json(['status'=>true,'active'=>false,'message'=>'change successfully']);
    }

    /**deleteAll
     * @param Request $request
     */
    public function bulckDelete(Request $request){
        Article::whereIn('id',$request['id'])->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }

    public function bulckStatus(Request $request){
        $articles = Article::whereIn('id',$request['id'])->get();
        foreach ($articles as $article){
            $article->update(['status' => !$article->status]);
        }
        return response()->json(['status'=>true,'active'=>false,'message'=>'change successfully']);
    }

    public function DeleteSection($id){
        $section = Section::find($id);
        $section->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }
}
