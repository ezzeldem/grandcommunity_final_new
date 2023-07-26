<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\CommentResource;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return view('admin.dashboard.setting.articles.comments.index',  get_defined_vars());
    }

    /**datatable
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Exception
     */
    public function datatable($id){
        $article = Article::find($id);
        $comments = CommentResource::collection($article->comments);
        return datatables($comments)->make(true);
    }

    /**toggleStatus
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus($id){
        $comment = Comment::find($id);
        $comment->update(['status' => $comment->status == 0 ? 1 : 0]);
        return response()->json(['status'=>true,'active'=>false,'message'=>'change successfully']);
    }

    public function destroy($id)
    {
        Comment::find($id)->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }


    /**deleteAll
     * @param Request $request
     */
    public function bulckDelete(Request $request){
        Comment::whereIn('id',$request['id'])->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }

    public function bulckStatus(Request $request){
        $comment = Comment::whereIn('id',$request['id'])->get();
        foreach ($comments as $comment){
            $comment->update(['status' => !$comment->status]);
        }
        return response()->json(['status'=>true,'active'=>false,'message'=>'change successfully']);
    }
    
}
