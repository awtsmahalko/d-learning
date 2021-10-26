<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ZoomApiController extends Controller
{
    public static function createZoomMeeting($meetingConfig = [])
    {
        $jwtToken = 'eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6InhFNFJNWTFpUkRDYnpYTDBoZmdRX0EiLCJleHAiOjE2MzU0NzU4ODgsImlhdCI6MTYzNDg3MTA4OX0.m4bsyRxsQ5G67uDdTtn-dD3qfBdBzpk6ZTqN0CMz3N0';

        $requestBody = [
            'topic'         => $meetingConfig['topic']  ?? 'PHP General Talk',
            'type'          => $meetingConfig['type']   ?? 2,
            'start_time'    => $meetingConfig['start_time'] ?? date('Y-m-dTh:i:00') . 'Z',
            'duration'      => $meetingConfig['duration']   ?? 30,
            'password'      => $meetingConfig['password']   ?? mt_rand(),
            'timezone'      => 'UTC',
            'agenda'        => 'PHP Session',
            'settings'  => [
                'host_video'        => false,
                'participant_video' => true,
                'cn_meeting'        => false,
                'in_meeting'        => false,
                'join_before_host'  => true,
                'mute_upon_entry'   => true,
                'watermark'         => false,
                'use_pmi'           => false,
                'approval_type'     => 1,
                'registration_type' => 1,
                'audio'             => 'voip',
                'auto_recording'    => 'none',
                'waiting_room'      => false
            ]
        ];

        $zoomUserId = '1N6c5fUHR2CJkluLrbV0og';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // Skip SSL Verification
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.zoom.us/v2/users/" . $zoomUserId . "/meetings",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($requestBody),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $jwtToken,
                "Content-Type: application/json",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
        // $err = curl_error($curl);


        // if ($err) {
        //     return [
        //         'success'     => false,
        //         'msg'         => 'cURL Error #:' . $err,
        //         'response'     => ''
        //     ];
        // } else {
        //     return [
        //         'success'     => true,
        //         'msg'         => 'success',
        //         'response'     => json_decode($response)
        //     ];
        // }
    }
}
