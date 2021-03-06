<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\ClassActivity;
use App\Models\ClassActivityDetail;
use App\Models\ClassActivityScoring;
use App\Models\ClassList;
use App\Models\User;
use App\Models\Attendance;
use App\Models\ClassActivityMaterial;
use App\Models\Meeting;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Whoops\Run;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->category == 'T') {
            if ($request->type == 'V') {
                $class = Classes::where('user_id', $request->user_id)->with('meetings')->get();
            } else {
                $class = Classes::where('user_id', $request->user_id)->with('classLists')->get();
            }
        } else {
            $class = Classes::whereRelation('classLists', 'user_id', $request->user_id)->with('meetings')->get();
        }
        return response()->json($class);
    }

    public function store(Request $request)
    {
        $form_data = array(
            'code' => Str::random(6),
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => $request->user_id
        );
        $class = Classes::create($form_data);

        return response()->json([
            'message' => 'Class Created Successfully!!',
            'class' => $class
        ]);
    }


    public function show(Classes $class)
    {
        return response()->json($class);
    }

    public function update(Request $request, Classes $class)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
        ]);

        $class->update($request->all());


        return response()->json([
            'message' => 'Class Updated Successfully!!',
            'class' => $class
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classes $class)
    {
        $class->delete();

        return response()->json('Class deleted!');
    }

    public function addRecord(Request $request)
    {
        $response = 0;
        $form_data = array(
            'code' => Str::random(6),
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => $request->user_id
        );
        $class = Classes::create($form_data);

        if ($class) {
            $response = 1;
        }
        return response()->json($response);
    }

    public function viewRecord(Request $request)
    {
        if ($request->category == 'T') {
            $class = Classes::where('user_id', $request->user_id)->with('meetings', 'classLists')->get();
        } else if ($request->category == 'A') {
            $class = Classes::with('user', 'meetings', 'classLists')->get();
        } else {
            $class = Classes::whereRelation('classLists', 'user_id', $request->user_id)->with('meetings')->get();
        }
        return response()->json($class);
    }


    public function updateRecord(Request $request)
    {
        $response = 0;

        $form_data = array(
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => $request->user_id
        );

        $class = Classes::find($request->id);
        if ($class->user_id == $request->user_id) {
            $class->update($form_data);
            $response = 1;
        } else {
            if ($this->checkIfClassUsed($request->id, 0) > 0) {
                $response = 'user';
            } else {
                $class->update($form_data);
                $response = 1;
            }
        }
        return response()->json($response);
    }

    public function deleteRecord(Request $request)
    {
        $class = Classes::find($request->id);
        if ($this->checkIfClassUsed($request->id) > 0) {
            $response = 2;
        } else {
            $class->delete();
            $response = 1;
        }

        return response()->json($response);
    }

    public function checkIfClassUsed($class_id, $all = 1)
    {
        $count_activity = ClassActivity::where('class_id', $class_id)->count();
        $count_post = Post::where('class_id', $class_id)->count();
        $count_meeting = Meeting::where('class_id', $class_id)->count();

        $count_init = $count_activity + $count_post + $count_meeting;
        $count_list = ClassList::where('class_id', $class_id)->count();

        return $all == 1 ? $count_init + $count_list : $count_init;
    }

    public function fetchUserByCategory(Request $request)
    {

        $users = User::where('category', $request->category)
            ->orderBy('fname')
            ->get();

        return response()->json($users);
    }


    public function indexActivity(Request $request)
    {
        $activities = ClassActivity::where('class_id', $request->class_id)->orderByDesc('created_at')->with('user')->withCount(["activity_details" => function ($q) use ($request) {
            $q->where('user_id', '=', $request->user_id);
        }])->get();

        return response()->json($activities);
    }

    public function dashboardActivityOrig(Request $request)
    {
        if ($request->view_by == 'T') {
            $activities = ClassActivity::where('user_id', $request->user_id)->orderBy('duedate')->with('user', 'class')->withCount(["activity_details" => function ($q) use ($request) {
                $q->where('user_id', '=', $request->user_id);
            }])->get();
        } else {
            $activities = ClassActivity::whereRelation('classLists', 'user_id', $request->user_id)->orderBy('duedate')->orderBy('class_id')->with('user', 'class')->withCount(["activity_details" => function ($q) use ($request) {
                $q->where('user_id', '=', $request->user_id);
            }])->get();
        }

        return response()->json($activities);
    }

    public function dashboardActivity(Request $request)
    {
        if ($request->view_by == 'T') {
            $activities = ClassActivity::where('user_id', $request->user_id)->orderBy('duedate')->with('user', 'class')->withCount(["activity_details" => function ($q) use ($request) {
                $q->where('user_id', '=', $request->user_id);
            }])->get();
        } else if ($request->view_by == 'A') {
            $activities = ClassActivity::orderBy('duedate')->with('user', 'class')->get();
        } else {
            $activities = ClassActivity::whereRelation('classLists', 'user_id', $request->user_id)->orderBy('duedate')->orderBy('class_id')->with('user', 'class')->withCount(["activity_details" => function ($q) use ($request) {
                $q->where('user_id', '=', $request->user_id);
            }])->get();
        }

        $activities = $activities->groupBy(function ($data) {
            return $data->duedate->format('F d, Y');
        });

        foreach ($activities as $key => $activity) {
            $new_activity = $activity->groupBy(function ($data) {
                return $data->class_id;
            });
            $activities[$key] = $new_activity;
        }

        return response()->json($activities);
    }

    public function createActivity(Request $request)
    {
        $title =  ($request->text_title == "") ? $request->title : $request->text_title;

        $counter = ClassActivity::where('class_id', '=', $request->class_id)
            ->where('title', '=', $title)
            ->count();

        if ($counter > 0) {
            $response['counter'] = 2;
        } else {
            $form_data = array(
                'user_id' => $request->user_id,
                'class_id' => $request->class_id,
                'title' => $title,
                'instruction' => $request->instructions,
                'points' => $request->points,
                'duedate' => $request->duedate,
                'category' => $request->cw_category,
                'status' => 1
            );
            $classactivity = ClassActivity::create($form_data);
            $this->moveClassworkMaterials($request, $classactivity->id);
            $response = [
                'counter' => 1,
                'message' => 'Class Activity Created Successfully!!',
                'class' => $classactivity
            ];
        }
        return response()->json($response);
    }

    public function updateActivity(Request $request)
    {
        $title =  ($request->text_title == "") ? $request->title : $request->text_title;

        $form_data = array(
            'user_id' => $request->user_id,
            'class_id' => $request->class_id,
            'title' => $title,
            'instruction' => $request->instructions,
            'points' => $request->points,
            'duedate' => $request->duedate,
            'category' => $request->cw_category,
            'status' => 1
        );

        $classactivity = ClassActivity::where('id', '=', $request->id)->update($form_data);

        $this->moveClassworkMaterials($request, $request->id);

        return response()->json([
            'message' => 'Class Activity updated Successfully!!',
            'class' => $classactivity
        ]);
    }

    public function moveClassworkMaterials($request, $activity_id)
    {
        $class = Classes::find($request->class_id);

        foreach ($request->classworkFiles as $classWorkFile) {
            if ($classWorkFile != null) {
                $tempSwFile = ClassActivityMaterial::where('folder', $classWorkFile)->first();

                if (Storage::exists('public/classactivity/materials/' . $class->code . '/tmp/' . $tempSwFile->folder . '/' . $tempSwFile->filename)) {
                    Storage::move('public/classactivity/materials/' . $class->code . '/tmp/' . $tempSwFile->folder . '/' . $tempSwFile->filename, 'public/classactivity/materials/' . $class->code . "/" . $activity_id . '/' . $tempSwFile->filename);

                    $thumbnail = '/classactivity/materials/' . $class->code . '/' . $activity_id . '/' . $tempSwFile->filename;

                    ClassActivityMaterial::where('id', $tempSwFile->id)->update(['class_activity_id' => $activity_id, 'thumbnail' => $thumbnail, 'status' => 'S']);

                    Storage::deleteDirectory('public/classactivity/materials/' . $class->code . '/tmp/' . $tempSwFile->folder);
                }
            }
        }
    }

    public function activityDetail(Request $request)
    {
        $activity = ClassActivity::where('id', $request->activityId)->with('user', 'activity_material', 'activity_scoring')->first();

        return response()->json($activity);
    }

    public function uploadStudentWork(Request $request)
    {
        $classCode = Classes::find($request->classId);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = date('his') . '-' . $file->getClientOriginalName();
            $filesize = $file->getSize();
            $fileType = $file->getClientOriginalExtension();
            $folder = uniqid() . '-' . now()->timestamp;

            $fileThumbs = ["XLS", "DOCX", "CSV", "TXT", "ZIP", "EXE", "XLSX", "PPT", "PPTX"];
            $imgThumbs = ["JPEG", "JPG", "EXIF", "TIFF", "GIF", "BMP", "PNG", "SVG", "ICO", "PPM", "PGM", "PNM"];

            if (in_array(strtoupper($fileType), $fileThumbs)) {
                $thumbnail = "/file_extension_icon/" . strtoupper($fileType) . '.png';
            } else {
                if (in_array(strtoupper($fileType), $imgThumbs)) {
                    $thumbnail = '/classactivity/' . $classCode->code . '/' . $request->activityId . '/' . $filename;
                } else {
                    $thumbnail = "/file_extension_icon/FILE.png";
                }
            }

            // insert to temporary table in database
            $tmpPostAttachment = ClassActivityDetail::create([
                'class_activity_id' => $request->activityId,
                'user_id' => $request->userId,
                'folder' => $folder,
                'filename' => $filename,
                'filesize' => $filesize,
                'filetype' => $fileType,
                'thumbnail' => $thumbnail,
                'status' => 'T'
            ]);

            if ($tmpPostAttachment) {
                $file->storeAs('public/classactivity/' . $classCode->code . '/' . $request->activityId . '/tmp/' . $folder, $filename);
            }

            return $folder;
        }

        return '';
    }

    public function mobileUploadStudenWork($request)
    {
        $classCode = Classes::find($request->classId);
        if ($request->hasFile('file')) {
            $data = [];
            if ($request->file('file') != null) {
                foreach ($request->file('file') as $file) {
                    // $file = $request->file('file');
                    $filename = date('his') . '-' . $file->getClientOriginalName();
                    $filesize = $file->getSize();
                    $fileType = $file->getClientOriginalExtension();
                    $folder = uniqid() . '-' . now()->timestamp;

                    $fileThumbs = ["XLS", "DOCX", "CSV", "TXT", "ZIP", "EXE", "XLSX", "PPT", "PPTX"];
                    $imgThumbs = ["JPEG", "JPG", "EXIF", "TIFF", "GIF", "BMP", "PNG", "SVG", "ICO", "PPM", "PGM", "PNM"];

                    if (in_array(strtoupper($fileType), $fileThumbs)) {
                        $thumbnail = "/file_extension_icon/" . strtoupper($fileType) . '.png';
                    } else {
                        if (in_array(strtoupper($fileType), $imgThumbs)) {
                            $thumbnail = '/classactivity/' . $classCode->code . '/' . $request->activityId . '/' . $filename;
                        } else {
                            $thumbnail = "/file_extension_icon/FILE.png";
                        }
                    }

                    // insert to temporary table in database
                    $tmpPostAttachment = ClassActivityDetail::create([
                        'class_activity_id' => $request->activityId,
                        'user_id' => $request->user_id,
                        'folder' => $folder,
                        'filename' => $filename,
                        'filesize' => $filesize,
                        'filetype' => $fileType,
                        'thumbnail' => $thumbnail,
                        'status' => 'T'
                    ]);

                    if ($tmpPostAttachment) {
                        $file->storeAs('public/classactivity/' . $classCode->code . '/' . $request->activityId . '/tmp/' . $folder, $filename);
                    }

                    $data[] = $folder;
                }
            }
            return $data;
        }
    }

    public function submitStudentWork(Request $request)
    {
        if ($request->isMobile == "true") {
            $fileFolders = $this->mobileUploadStudenWork($request);
            $studentWorkFiles = ($fileFolders != null) ? $fileFolders : ["0" => []];
        } else {
            $studentWorkFiles = $request->submitStudentData;
        }

        $class = Classes::find($request->classId);
        $statusUnSubmitted = ClassActivityDetail::where('class_activity_id', $request->activityId)->first();

        // if ($statusUnSubmitted->status == 'C') {
        $updateResponse = ClassActivityDetail::where('class_activity_id', $request->activityId)->where('user_id', $request->user_id)->update(['status' => 'S']);
        // } else {
        foreach ($studentWorkFiles as $studentWorkFile) {
            if ($studentWorkFile != null) {
                $tempSwFile = ClassActivityDetail::where('folder', $studentWorkFile)->first();

                if (Storage::exists('public/classactivity/' . $class->code . '/' . $request->activityId . '/tmp/' . $tempSwFile->folder . '/' . $tempSwFile->filename)) {
                    Storage::move('public/classactivity/' . $class->code . '/' . $request->activityId . '/tmp/' . $tempSwFile->folder . '/' . $tempSwFile->filename, 'public/classactivity/' . $class->code . "/" . $request->activityId . '/' . $tempSwFile->filename);

                    $updateResponse = ClassActivityDetail::where('class_activity_id', $request->activityId)->update(['status' => 'S']);

                    Storage::deleteDirectory('public/classactivity/' . $class->code . '/' . $request->activityId . '/tmp/' . $tempSwFile->folder);
                }
            }
        }
        // }

        return response()->json([
            'message' => 'Post Created Successfully!!'
        ]);
    }

    public function studentworkdata(Request $request)
    {
        $test = [];

        $test['activity_detail'] = ClassActivityDetail::where('class_activity_id', $request->activity_id)->where('user_id', $request->user_id)->get();

        $test['scoring'] = ClassActivityScoring::where('user_id', $request->user_id)->where('class_activity_id', $request->activity_id)->first();

        return response()->json((object) $test);
    }

    public function unsubmitStudentWork(Request $request)
    {
        $updateResponse = ClassActivityDetail::where('class_activity_id', $request->activityId)->where('user_id', $request->userId)->update(['status' => 'C']);

        return response()->json($updateResponse);
    }

    public function indexStudentWork(Request $request)
    {
        $studentSubmitted = ClassActivityDetail::select('user_id', DB::raw('COUNT(*) as total'))
            ->where('class_activity_id', $request->activityId)
            ->groupBy('user_id')
            ->having('total', '>', 0)
            ->with('user')
            ->get();


        $data = [];
        foreach ($studentSubmitted as $student) {
            $files = ClassActivityDetail::where('user_id', $student->user_id)
                ->where('class_activity_id', $request->activityId)
                ->get();

            $score = ClassActivityScoring::where('user_id', $student->user_id)->where('class_activity_id', $request->activityId)->first();

            $points = ($score != null) ? (($score->points != 0) ? $score->points : 0) : 0;

            $data[] = [
                'user_id' => $student->user_id,
                'total' => $student->total,
                'user' => $student->user,
                'details' => $files,
                'score' => number_format($points, 2),
            ];
        }

        return response()->json((object)$data);
    }

    public function attendance(Request $request)
    {
        $students_list = User::join('class_lists', 'class_lists.user_id', '=', 'users.id')->where('class_id', $request->class_id)->orderBy('users.lname', 'asc')->select('users.id', 'users.lname', 'users.mname', 'users.fname')->with('attendance:user_id,status')->get();
        return response()->json($students_list);
    }

    public function attendanceModalStudents(Request $request)
    {
        $students_list = User::join('class_lists', 'class_lists.user_id', '=', 'users.id')->where('class_id', $request->class_id)->orderBy('users.lname', 'asc')->select('users.id', 'users.lname', 'users.mname', 'users.fname')->with('attendance')->get();
        return response()->json($students_list);
    }

    public function attendanceAddRecord(Request $request)
    {
        $date = date("Y-m-d", strtotime($request->date));
        $counter = Attendance::where('class_id', '=', $request->class_id)
            ->where('date', '=', $date)
            ->count();

        if ($counter > 0) {
            $res = 2;
        } else {
            foreach ($request->student as $user_id => $status) {
                if (isset($status)) {
                    $students_list[] = $status;
                    $form_data = array(
                        'date' => $date,
                        'user_id' => $user_id,
                        'status' => $status,
                        'class_id' => $request->class_id
                    );
                    Attendance::create($form_data);
                }
            }
            $res = 1;
        }

        return response()->json($res);
    }

    public function uploadClassworkAttachment(Request $request)
    {
        $classCode = Classes::find($request->classId);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = date('his') . '-' . $file->getClientOriginalName();
            $filesize = $file->getSize();
            $fileType = $file->getClientOriginalExtension();
            $folder = uniqid() . '-' . now()->timestamp;

            $fileThumbs = ["XLS", "DOCX", "CSV", "TXT", "ZIP", "EXE", "XLSX", "PPT", "PPTX"];
            $imgThumbs = ["JPEG", "JPG", "EXIF", "TIFF", "GIF", "BMP", "PNG", "SVG", "ICO", "PPM", "PGM", "PNM"];

            if (in_array(strtoupper($fileType), $fileThumbs)) {
                $thumbnail = "/file_extension_icon/" . strtoupper($fileType) . '.png';
            } else {
                if (in_array(strtoupper($fileType), $imgThumbs)) {
                    $thumbnail = '/classactivity/' . $classCode->code . '/' . $filename;
                } else {
                    $thumbnail = "/file_extension_icon/FILE.png";
                }
            }

            // insert to temporary table in database
            $tmpPostAttachment = ClassActivityMaterial::create([
                'folder' => $folder,
                'filename' => $filename,
                'filesize' => $filesize,
                'filetype' => $fileType,
                'thumbnail' => $thumbnail,
                'status' => 'T'
            ]);

            if ($tmpPostAttachment) {
                $file->storeAs('public/classactivity/materials/' . $classCode->code . '/tmp/' . $folder, $filename);
            }

            return $folder;
        }

        return '';
    }

    public function revertClassWorkMaterial(Request $request)
    {
        $folder = $request->file;
        $classCode = Classes::find($request->classId);

        Storage::deleteDirectory('public/classactivity/materials/' . $classCode->code . '/tmp/' . $folder);

        ClassActivityMaterial::where('folder', $folder)->delete();
    }

    public function deleteClassWorkMaterial(Request $request)
    {
        $filename = $request->activity['activity_material'][0]['filename'];
        $activityId = $request->activity['activity_material'][0]['class_activity_id'];
        $classCode = Classes::find($request->activity['class_id']);

        Storage::delete('public/classactivity/materials/' . $classCode->code . '/' . $activityId . '/' . $filename);

        ClassActivityMaterial::where('id', $request->material_id)->delete();
    }

    public function deleteStudentWork(Request $request)
    {
        $studentWork = ClassActivityDetail::find($request->activity_detail_id);
        $classCode = Classes::find($request->classId);

        if (Storage::exists('public/classactivity/' . $classCode->code . '/' . $request->activityId . '/' . $studentWork->filename)) {
            Storage::delete('public/classactivity/' . $classCode->code . '/' . $request->activityId . '/' . $studentWork->filename);
        }

        ClassActivityDetail::where('id', $request->activity_detail_id)->delete();
    }

    public function addScore(Request $request)
    {
        $form_data = array(
            'class_activity_id' => $request->id,
            'user_id' => $request->student_id,
            'class_id' => $request->class_id,
            'points' => $request->student_score,
            'status' => 'S',
        );
        $filter = array(
            'user_id' => $request->student_id,
            'class_activity_id' => $request->id
        );
        $classactivity = ClassActivityScoring::updateOrCreate($filter, $form_data);

        return response()->json([
            'message' => 'Score added Successfully!!',
            'class' => $classactivity
        ]);
    }

    public function getScore(Request $request)
    {
        $score = ClassActivityScoring::where('user_id', $request->student_id)->where('class_activity_id', $request->activityId)->first();

        $points = ($score != null) ? (($score->points != 0) ? $score->points : 0) : 0;

        return response()->json($points);
    }

    public function studentWork(Request $request)
    {
        $classActivity = ClassActivity::selectRaw('SUM(points) as total_points')
            ->where('class_id', '=', $request->class_id)
            ->where('category', '=', $request->category)
            ->get();

        $total_points = (float) $classActivity[0]['total_points'];
        $student_list = ClassActivityScoring::join("class_activities", 'class_activities.id', '=', 'class_activity_scorings.class_activity_id')
            ->selectRaw("SUM(class_activity_scorings.points) AS earned_points,class_activity_scorings.user_id,$total_points AS total_points")
            ->where("class_activities.category", "=", $request->category)
            ->where("class_activities.class_id", "=", $request->class_id)
            ->groupBy("class_activity_scorings.user_id")
            ->orderByRaw('SUM(class_activity_scorings.points) desc')
            ->with('user:id,student_id,fname,mname,lname')
            ->get();
        return response()->json($student_list);
    }

    public function teacherWork(Request $request)
    {
        $works = ClassActivity::select('id', 'title', 'points')
            ->where('class_id', '=', $request->class_id)
            ->where('category', '=', $request->category)
            ->get();


        $classActivity = ClassActivity::selectRaw('SUM(points) as total_points')
            ->where('class_id', '=', $request->class_id)
            ->where('category', '=', $request->category)
            ->get();

        $total_points = (float) $classActivity[0]['total_points'];
        $student_list = array();
        $student_list_ = ClassActivityScoring::join("class_activities", 'class_activities.id', '=', 'class_activity_scorings.class_activity_id')
            ->selectRaw("SUM(class_activity_scorings.points) AS earned_points,class_activity_scorings.user_id")
            ->where("class_activities.category", "=", $request->category)
            ->where("class_activities.class_id", "=", $request->class_id)
            ->groupBy("class_activity_scorings.user_id")
            ->orderByRaw('SUM(class_activity_scorings.points) desc')
            ->with('user:id,fname,mname,lname')
            ->get();

        foreach ($student_list_ as $list_data) {
            $list = array(
                'earned_points' => (float) $list_data['earned_points'],
                'user_id'       => $list_data['user_id'],
                'student_name'  => strtoupper($list_data['user']['lname'] . ', ' . $list_data['user']['fname']),
                'total_points'  => $total_points
            );

            $list_work = array();
            foreach ($works as $work_data) {
                $score = ClassActivityScoring::select('points')
                    ->where('class_activity_id', '=', $work_data['id'])
                    ->where('user_id', '=', $list_data['user_id'])
                    ->get();

                $list_work[] = isset($score[0]['points']) ? (float) $score[0]['points'] : 0;
            }

            $list['work'] = $list_work;

            array_push($student_list, $list);
        }

        $response = array(
            'works' => $works,
            'student_list' => $student_list
        );
        return response()->json($response);
    }

    public function downloadClassWorkMaterial($class_id, $material_id)
    {
        $material = ClassActivityMaterial::where('id', $material_id)->first();
        $class = Classes::find($class_id);

        $file = public_path() . '/storage/classactivity/materials/' .  $class->code . '/' . $material->class_activity_id . '/' . $material->filename;

        $headers = [
            'Content-Type' => 'application/' . $material->filetype,
        ];

        return response()->download($file, $material->filename, $headers);
    }

    public function deleteActivity(Request $request)
    {
        $classWork = ClassActivityMaterial::where("class_activity_id", "=", $request->id)->get();
        $classWorkDetails = ClassActivityDetail::where("class_activity_id", "=", $request->id)->get();
        $classCode = Classes::find($request->class_id);

        if (count($classWorkDetails) > 0) {
            foreach ($classWorkDetails as $workDetails) {
                if (Storage::exists('public/classactivity/' . $classCode->code . '/' . $request->id . '/' . $workDetails->filename)) {
                    Storage::delete('public/classactivity/' . $classCode->code . '/' . $request->id . '/' . $workDetails->filename);
                }
            }
        }

        if (count($classWork) > 0) {
            foreach ($classWork as $work) {
                if (Storage::exists('public/classactivity/materials/' . $classCode->code . '/' . $request->id . '/' . $work->filename)) {
                    Storage::delete('public/classactivity/materials/' . $classCode->code . '/' . $request->id . '/' . $work->filename);
                }
            }
        }

        ClassActivityMaterial::where('class_activity_id', $request->id)->delete();
        ClassActivityScoring::where('class_activity_id', $request->id)->delete();
        ClassActivityDetail::where('class_activity_id', $request->id)->delete();
        ClassActivity::where('id', $request->id)->delete();
    }
}
