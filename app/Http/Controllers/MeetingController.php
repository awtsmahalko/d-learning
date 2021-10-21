<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ZoomApiController;

class MeetingController extends Controller
{
    public function create(Request $request)
    {
        $data = ZoomApiController::createZoomMeeting();
        return response()->json($data);
    }
}
