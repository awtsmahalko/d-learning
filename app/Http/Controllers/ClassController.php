<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
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
        $class = Classes::where('user_id', $request->user_id)->with('classLists')->get();
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
}
