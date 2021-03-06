<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ZoomApiController;
use App\Models\Attendee;
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
            $meetConfig = array(
                'topic' => $form_data['title'],
                'start_time' => $form_data['scheduled_at']
            );
            $apiZoom = ZoomApiController::createZoomMeeting($meetConfig);
            $form_data['number'] = $apiZoom->id;
            $form_data['password'] = $apiZoom->password;
            $form_data['join_url'] = $apiZoom->join_url;
            $meeting = Meeting::create($form_data);
        }
        return response()->json($meeting);
    }

    public function api()
    {
        $apiZoom = ZoomApiController::createZoomMeeting();
        return response()->json($apiZoom);
    }

    public function show($id)
    {
        $meeting = Meeting::find($id);
        return response()->json($meeting);
    }

    public function updateStatus($id)
    {
        $form_data = array(
            'status' => 'F',
        );

        $meeting = Meeting::find($id);
        $meeting = $meeting->update($form_data);

        return response()->json($meeting);
    }

    public function join(Request $request)
    {

        $data = array(
            'meeting_id' => $request->meeting_id,
            'user_id' => $request->user_id
        );

        $attendee = Attendee::updateOrCreate($data);

        return response()->json($attendee);
    }

    public function attendee($id)
    {
        $attendees = Attendee::join('users', 'attendees.user_id', '=', 'users.id')->where('meeting_id', $id)->orderBy('users.category', 'DESC')->select('attendees.*', 'users.fname', 'users.mname', 'users.lname', 'users.category')->get();
        return response()->json($attendees);
    }

    public function destroy($id)
    {
        $meeting = Meeting::find($id);
        $meeting = $meeting->delete();
        return response()->json($meeting);
    }

    public function apiCredentials()
    {
        $apiZoom = ZoomApiController::jwtToken();
        return response()->json($apiZoom);
    }
}
