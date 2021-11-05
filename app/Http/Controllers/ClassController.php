<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\ClassActivity;
use App\Models\ClassActivityDetail;
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
        $activities = ClassActivity::where('class_id', $request->class_id)->orderByDesc('created_at')->with('user')->get();

        return response()->json($activities);
    }

    public function createActivity(Request $request)
    {
        $form_data = array(
            'user_id' => $request->user_id,
            'class_id' => $request->class_id,
            'title' => $request->title,
            'instruction' => $request->instructions,
            'points' => $request->points,
            'duedate' => $request->duedate,
            'status' => 1
        );
        $classactivity = ClassActivity::create($form_data);

        return response()->json([
            'message' => 'Class Activity Created Successfully!!',
            'class' => $classactivity
        ]);
    }

    public function activityDetail(Request $request)
    {
        $activity = ClassActivity::find($request->activityId);

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
}
