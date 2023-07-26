<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reply;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\ReplyResource;


class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return view('admin.dashboard.setting.articles.comments.replies.index',  get_defined_vars());
    }

    /**datatable
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Exception
     */
    public function datatable($id){
        $comment = Comment::find($id);
        $replies = ReplyResource::collection($comment->replies);
        return datatables($replies)->make(true);
    }

    /**toggleStatus
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus($id){
        $reply = Reply::find($id);
        $reply->update(['status' => !$reply->status]);
        return response()->json(['status'=>true,'active'=>false,'message'=>'change successfully']);
    }

    public function destroy($id)
    {
        Reply::find($id)->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }


    /**deleteAll
     * @param Request $request
     */
    public function bulckDelete(Request $request){
        Reply::whereIn('id',$request['id'])->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }

    public function bulckStatus(Request $request){
        $replies = Reply::whereIn('id',$request['id'])->get();
        foreach ($replies as $reply){
            $reply->update(['status' => !$reply->status]);
        }
        return response()->json(['status'=>true,'active'=>false,'message'=>'change successfully']);
    }
}
