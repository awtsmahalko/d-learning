<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;

use App\Models\Post;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $post = Post::where('class_id', $request->class_id)->orderByDesc('created_at')->with('user')->get();
        return response()->json($post);
    }

    public function store(Request $request)
    {
        $post = Post::create($request->all());

        return response()->json([
            'message' => 'Post Created Successfully!!',
            'class' => $post
        ]);
    }

    public function uploadAtachment(Request $request)
    {
        // dd($request);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $request->getClientOriginalName();
            $folder = uniqid() . '-' . now()->timestamp;
            $file->storeAs('avatars/tmp/' . $folder, $filename);

            return $folder;
        }

        return '';
    }
}
