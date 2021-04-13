<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Mail;
use App\Mail\CommentMail;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Carbon\Carbon;
class CommentsController extends Controller
{
public function store(Request $request)
    {
     \DB::beginTransaction();
    //try {	
     $input = $request->all();
     $validator = Validator::make($input, [
     'nick_name' => 'required',
     'content' => 'required',
     'news_id' => 'nullable',
     'events_id' => 'nullable',
     ]);
 
     if($validator->fails()){
     return response()->json([
     "success" => false,
     "message" => "Validation Error.",
     "errors" => $validator->errors()
     ]);      
     }

     $comment = Comment::create($input);
     if(isset($input['news_id'])){
     	$subject = "Commented on News";
     	$type = "News";
     } else {
     	$subject = "Commented on Events";
     	$type = "Events";
     }
     $user = User::whereHas('roles',function($query){
     		$query->where('name','Author');
     	})->first();
     $mail_to = $user->email;
     $body ="Dear ".$user->name."\r\n"."Comment in the ".$type."\r\n"."Thank You\r\n";
     $data = [
     	'subject' => $subject,
     	'body' => $body,
     ];
     Mail::to($mail_to)->send(new CommentMail($data));
     \DB::commit();
     return response()->json([
     "success" => true,
     "message" => "Comment created successfully.",
     "data" => $comment
     ]);
     /*} catch (\Exception $e) {
      \DB::rollback();
       return response()->json([
     "success" => false,
     "message" => "Server Error.",
     ]);
    }*/
    }
     public function destroy($id)
    {
        \DB::beginTransaction();
    try {
     $comment = Comment::find($id);
     $comment->delete();
    \DB::commit();
     return response()->json([
     "success" => true,
     "message" => "Comment deleted successfully.",
     "data" => $comment
     ]);    
 } catch (\Exception $e) {
      \DB::rollback();
       return response()->json([
     "success" => false,
     "message" => "Server Error.",
     ]);
    }
}
}