<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Events;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Carbon\Carbon;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 
 public function get(Request $request)
    {
        //try {  
        $input = $request->all();
        $user_id = Auth::guard('api')->user()->id;
        if(Auth::guard('api')->user()->hasRole('Author')){
            if(isset($input['date_of_event'])){
            $events = Events::with('comments')->whereDate('valid_from','<=', $input['date_of_event'])->whereDate('valid_to','>', $input['date_of_event'])->get();
        } else {
        
         $events = Events::with('comments')->whereDate('created_at', Carbon::today())->get();
        }
        } else {
        if(isset($input['date_of_event'])){
            $events = Events::with('comments')->whereDate('valid_from','<=', $input['date_of_event'])->whereDate('valid_to','>', $input['date_of_event'])->where('user_id',$user_id)->get();
        } else {
        
         $events = Events::with('comments')->whereDate('created_at', Carbon::today())->where('user_id',$user_id)->get();
        }
        }   
         return response()->json([
         "success" => true,
         "message" => "Events List",
         "data" => $events
         ]);
        /*} catch (\Exception $e) {
       return response()->json([
     "success" => false,
     "message" => "Server Error.",
     ]);
    }*/
 
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
     'valid_from' => 'required',
     'valid_to' => 'required',     
     'title' => 'required',
     'content' => 'required',
     'gps_lat' => 'nullable',
     'gps_lng' => 'nullable'
     ]);
 
     if($validator->fails()){
     return response()->json([
     "success" => false,
     "message" => "Validation Error.",
     "errors" => $validator->errors()
     ]);      
     }

    $input['user_id'] = Auth::guard('api')->user()->id;
     $event = Events::create($input);
     \DB::commit();
     return response()->json([
     "success" => true,
     "message" => "Event created successfully.",
     "data" => $event
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
     * @param  \App\Models\Events  $event
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    try {
         $event = Events::find($id);
         if (is_null($event)) {
              return response()->json([
     "success" => false,
     "message" => "Event Not found",
     "errors" => "Event Not Found"
     ]);
         }
         return response()->json([
         "success" => true,
         "message" => "Event retrieved successfully.",
         "data" => $event
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
     * @param  \App\Models\Events  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
    \DB::beginTransaction();
    try {
        $event = Events::find($id);
     $input = $request->all();
     $validator = Validator::make($input, [
     'valid_from' => 'required',
     'valid_to' => 'required',    
     'title' => 'required',
     'content' => 'required',
     'gps_lat' => 'nullable',
     'gps_lng' => 'nullable'
     ]);
 
     if($validator->fails()){
          return response()->json([
     "success" => false,
     "message" => "Validation Error.",
     "errors" => $validator->errors()
     ]);       
     }
     $event->valid_from = $input['valid_from'];
     $event->valid_to = $input['valid_to']; 
     $event->title = $input['title'];
     $event->content = $input['content'];
     $event->gps_lat = $input['gps_lat'];
     $event->gps_lng = $input['gps_lng'];     
     $event->save();
     \DB::commit();
     return response()->json([
     "success" => true,
     "message" => "Event updated successfully.",
     "data" => $event
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
     * @param  \App\Models\Events  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \DB::beginTransaction();
    try {
     $event = Events::find($id);
     $event->delete();
    \DB::commit();
     return response()->json([
     "success" => true,
     "message" => "Event deleted successfully.",
     "data" => $event
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
?>