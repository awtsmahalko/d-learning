<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ZoomApiController;
use App\Models\ClassList;
use App\Models\Meeting;

class MeetingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->category == 'T') {
            $meetings = Meeting::where('class_id', $request->class_id)->get();
        } else {
            $meetings = Meeting::whereRelation('classLists', 'user_id', $request->user_id)->where('class_id', $request->class_id)->get();
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
            'scheduled_at' => $request->scheduled_at,
            'class_id' => $request->class_id
        );

        $meeting = Meeting::find($request->id);

        if ($meeting) {
            $meeting = $meeting->update($form_data);
        } else {
            $meeting = Meeting::create($form_data);
        }
        return response()->json($meeting);
    }

    public function show($id)
    {
        $meeting = Meeting::find($id);
        return response()->json($meeting);
    }

    public function destroy($id)
    {
        $meeting = Meeting::find($id);
        $meeting = $meeting->delete();
        return response()->json($meeting);
    }
}
