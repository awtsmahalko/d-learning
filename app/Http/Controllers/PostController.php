<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;

use App\Models\Post;
class PostController extends Controller
{
    public function index(Request $request)
    {
        $post = Post::where('class_id',1)->orderByDesc('created_at')->with('user')->get();
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
}
