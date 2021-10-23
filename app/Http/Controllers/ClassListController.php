<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\ClassList;

use Illuminate\Http\Request;

class ClassListController extends Controller
{
    //
    public function studentsList(Request $request){
        $students_list = ClassList::where('class_id',$request->class_id)->with('user')->get();
        return response()->json($students_list);
    }

    public function students(Request $request){
        $students_list = User::where("category","S")->get();
        return response()->json($students_list);
    }

    public function addStudent(Request $request){

        $data = array(
            'class_id' => $request->student_list['class_id'],
            'user_id' => $request->student_list['student_id'],
            'status' => 'A'
        );

        $stud_list = ClassList::create($data);
        
        return response()->json([
            'message' => 'Class Created Successfully!',
            'classlist' => $stud_list
        ]);

    }

    public function deleteStudentsList($id)
    {
        $classList = ClassList::find($id);
        $classList->delete();

        return response()->json('List successfully removed');
    }
}
