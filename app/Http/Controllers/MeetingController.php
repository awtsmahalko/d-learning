<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use ZoomApiController;
class MeetingController extends Controller
{
    public function create(Request $request){
        $data = ZoomApiController::createZoomMeeting();
        return response()->json($data);
    }
}
