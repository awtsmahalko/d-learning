<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ZoomApiController;

use App\Models\Meeting;

class MeetingController extends Controller
{
    public function index(Request $request){
        if($request->category == 'T'){
            $meetings = Meeting::where('class_id', $request->class_id)->get();
        }else{
            $meetings = Meeting::whereRelation('classLists','user_id', $request->user_id)->get();
        }
        return response()->json($meetings);
    }
    public function create(Request $request)
    {
        // $data = ZoomApiController::createZoomMeeting();
        // return response()->json($data);

        $form_data = array(
            'title' => $request->title,
            'description' => $request->description,
            'number' => '',
            'class_id' => $request->class_id
        );
        $meeting = Meeting::create($form_data);
        return response()->json($meeting);
    }
}
