<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\ClassActivity;
use App\Models\ClassActivityDetail;
use App\Models\ClassList;
use App\Models\User;
use App\Models\Attendance;
use App\Models\ClassActivityMaterial;
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

    public function indexActivity(Request $request)
    {
        $activities = ClassActivity::where('class_id', $request->class_id)->orderByDesc('created_at')->with('user')->withCount(["activity_details" => function ($q) use ($request) {
            $q->where('user_id', '=', $request->user_id);
        }])->get();

        return response()->json($activities);
    }

    public function createActivity(Request $request)
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
        $classactivity = ClassActivity::create($form_data);

        $this->moveClassworkMaterials($request, $classactivity->id);

        return response()->json([
            'message' => 'Class Activity Created Successfully!!',
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

                    $thumbnail = $_REQUEST['baseUrl'] . '/public/storage/classactivity/materials/' . $class->code . '/' . $activity_id . '/' . $tempSwFile->filename;

                    ClassActivityMaterial::where('id', $tempSwFile->id)->update(['class_activity_id' => $activity_id, 'thumbnail' => $thumbnail, 'status' => 'S']);

                    Storage::deleteDirectory('public/classactivity/materials/' . $class->code . '/tmp/' . $tempSwFile->folder);
                }
            }
        }
    }

    public function activityDetail(Request $request)
    {
        $activity = ClassActivity::where('id', $request->activityId)->with('activity_material')->first();

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
                $thumbnail = "../../storage/file_extension_icon/" . strtoupper($fileType) . '.png';
            } else {
                if (in_array(strtoupper($fileType), $imgThumbs)) {
                    $thumbnail = '../../storage/classactivity/' . $classCode->code . '/' . $request->activityId . '/' . $filename;
                } else {
                    $thumbnail = "../../storage/file_extension_icon/FILE.png";
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

    public function submitStudentWork(Request $request)
    {
        $class = Classes::find($request->classId);
        $statusUnSubmitted = ClassActivityDetail::where('class_activity_id', $request->activityId)->first();

        if ($statusUnSubmitted->status == 'C') {
            $updateResponse = ClassActivityDetail::where('class_activity_id', $request->activityId)->where('user_id', $request->user_id)->update(['status' => 'S']);
        } else {
            foreach ($request->submitStudentData as $studentWorkFile) {
                if ($studentWorkFile != null) {
                    $tempSwFile = ClassActivityDetail::where('folder', $studentWorkFile)->first();

                    if (Storage::exists('public/classactivity/' . $class->code . '/' . $request->activityId . '/tmp/' . $tempSwFile->folder . '/' . $tempSwFile->filename)) {
                        Storage::move('public/classactivity/' . $class->code . '/' . $request->activityId . '/tmp/' . $tempSwFile->folder . '/' . $tempSwFile->filename, 'public/classactivity/' . $class->code . "/" . $request->activityId . '/' . $tempSwFile->filename);

                        $updateResponse = ClassActivityDetail::where('class_activity_id', $request->activityId)->update(['status' => 'S']);

                        Storage::deleteDirectory('public/classactivity/' . $class->code . '/' . $request->activityId . '/tmp/' . $tempSwFile->folder);
                    }
                }
            }
        }

        return response()->json([
            'message' => 'Post Created Successfully!!'
        ]);
    }

    public function studentworkdata(Request $request)
    {
        $studentWork = ClassActivityDetail::where('class_activity_id', $request->activity_id)->where('user_id', $request->user_id)->get();

        return response()->json($studentWork);
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

        return response()->json($studentSubmitted);
    }

    public function attendance(Request $request)
    {
        $students_list = User::join('class_lists', 'class_lists.user_id', '=', 'users.id')->where('class_id', $request->class_id)->orderBy('users.lname', 'asc')->select('users.lname', 'users.mname', 'users.fname')->with('attendance')->get();
        return response()->json($students_list);
    }

    public function attendanceModalStudents(Request $request)
    {
        $students_list = User::join('class_lists', 'class_lists.user_id', '=', 'users.id')->where('class_id', $request->class_id)->orderBy('users.lname', 'asc')->select('users.id', 'users.lname', 'users.mname', 'users.fname')->with('attendance')->get();
        return response()->json($students_list);
    }

    public function attendanceAddRecord(Request $request)
    {
        // foreach ($request->student as $user_id => $status) {
        //     // $form_data = array(
        //     //     'date' => date("Y-m-d", strtotime($request->date)),
        //     //     'user_id' => $user_id,
        //     //     'status' => $status,
        //     //     'class_id' => 1
        //     // );
        //     $students_list[] = $user_id; //Attendance::create($form_data);
        // }
        return response()->json($request);
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
                $thumbnail = $_REQUEST['baseUrl'] . "/public/storage/file_extension_icon/" . strtoupper($fileType) . '.png';
            } else {
                if (in_array(strtoupper($fileType), $imgThumbs)) {
                    $thumbnail = $_REQUEST['baseUrl'] . '/public/storage/classactivity/' . $classCode->code . '/' . $filename;
                } else {
                    $thumbnail = $_REQUEST['baseUrl'] . "/public/storage/file_extension_icon/FILE.png";
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
        $filename = $request->activity_material[0]['filename'];
        $activityId = $request->activity_material[0]['class_activity_id'];
        $classCode = Classes::find($request->activity['class_id']);

        Storage::deleteDirectory('public/classactivity/materials/' . $classCode->code . '/' . $activityId . '/' . $filename);

        ClassActivityMaterial::where('id', $request->material_id)->delete();
    }
}
