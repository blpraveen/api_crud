<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Carbon\Carbon;
class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {   
        $user_id = Auth::guard('api')->user()->id;
        if(Auth::guard('api')->user()->hasRole('Author')){
            $news = News::with('comments')->whereDate('created_at', Carbon::today())->get();
        } else {
         $news = News::with('comments')->whereDate('created_at', Carbon::today())->where('user_id',$user_id)->get();
         }
         return response()->json([
         "success" => true,
         "message" => "News List",
         "data" => $news
         ]);
        } catch (\Exception $e) {
       return response()->json([
     "success" => false,
     "message" => "Server Error.",
     ]);
    }
 
    }
 
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     \DB::beginTransaction();
    try {	
     $input = $request->all();
     $validator = Validator::make($input, [
     'title' => 'required',
     'content' => 'required'
     ]);
 
     if($validator->fails()){
     return response()->json([
     "success" => false,
     "message" => "Validation Error.",
     "errors" => $validator->errors()
     ]);      
     }

    $input['user_id'] = Auth::guard('api')->user()->id;
     $news = News::create($input);
     \DB::commit();
     return response()->json([
     "success" => true,
     "message" => "News created successfully.",
     "data" => $news
     ]);
     } catch (\Exception $e) {
      \DB::rollback();
       return response()->json([
     "success" => false,
     "message" => "Server Error.",
     ]);
    }
    }
 
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    try {
         $news = News::find($id);
         if (is_null($news)) {
              return response()->json([
     "success" => false,
     "message" => "News Not found",
     "errors" => "News Not Found"
     ]);
         }
         return response()->json([
         "success" => true,
         "message" => "News retrieved successfully.",
         "data" => $news
         ]);
    } catch (\Exception $e) {
       return response()->json([
     "success" => false,
     "message" => "Server Error.",
     ]);
    }
    }
 
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
    \DB::beginTransaction();
    try {
        $news = News::find($id);
     $input = $request->all();
     $validator = Validator::make($input, [
     'title' => 'required',
     'content' => 'required'
     ]);
 
     if($validator->fails()){
          return response()->json([
     "success" => false,
     "message" => "Validation Error.",
     "errors" => $validator->errors()
     ]);       
     }
 
     $news->title = $input['title'];
     $news->content = $input['content'];
     $news->save();
     \DB::commit();
     return response()->json([
     "success" => true,
     "message" => "news updated successfully.",
     "data" => $news
     ]);
    } catch (\Exception $e) {
      \DB::rollback();
       return response()->json([
     "success" => false,
     "message" => "Server Error.",
     ]);
    }
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \DB::beginTransaction();
    try {
     $news = News::with('comments')->find($id);
     if(!$news->comments()->count()){
         $news->delete();
        \DB::commit();
         return response()->json([
         "success" => true,
         "message" => "News deleted successfully.",
         "data" => $news
         ]);    
    } else {
        return response()->json([
         "success" => true,
         "message" => "Cannot Delete Comment Exists.",
         "data" => $news
         ]);  
    }
 } catch (\Exception $e) {
      \DB::rollback();
       return response()->json([
     "success" => false,
     "message" => "Server Error.",
     ]);
    }
}
}
?>