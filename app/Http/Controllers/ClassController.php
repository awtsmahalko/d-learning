<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Classes $classes)
    {
        return view('classes.index', ['classes' => $classes->where('user_id','=',Auth::id())
            ->paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('classes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required',
        ]);

        $request['user_id'] = Auth::id();
        Classes::create($request->all());
     
        return redirect()->route('class.index')
                        ->with('success','Class created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Classes $class)
    {
        return view('classes.edit',compact('class'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classes $class)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
        ]);
    
        $class->update($request->all());
    
        return redirect()->route('class.index')
                        ->with('success','Classes updated successfully');
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
    
        return redirect()->route('class.index')
                        ->with('success','Class deleted successfully');
    }
}
