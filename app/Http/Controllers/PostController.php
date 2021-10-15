<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\File;
use App\Models\Classes;
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
        $class = Classes::find($request->class_id);

        $post = Post::create($request->all());

        // $post->addMedia(storage_path('app/public/postattachment/tmp/6169134b4eb1a-1634276171/LIBONA_PREMIUM_SWINE_STARTER.pdf'))->toMediaCollection('public/postattachment/' . $request->class_id);

        // Storage::disk('public')->put('example.txt', 'Contents');
        if (Storage::exists('public/postattachment/tmp/61691be6a2895-1634278374/LIBONA PREMIUM SWINE STARTER.xlsx')) {
            Storage::move('public/postattachment/tmp/61691be6a2895-1634278374/LIBONA PREMIUM SWINE STARTER.xlsx', 'public/postattachment/' . $class->code . "/LIBONA PREMIUM SWINE STARTER.xlsx");
        }

        return response()->json([
            'message' => 'Post Created Successfully!!',
            'class' => $post
        ]);
    }

    public function uploadAtachment(Request $request)
    {
        $classCode = Classes::find($request->classId);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $folder = uniqid() . '-' . now()->timestamp;
            $file->storeAs('public/postattachment/tmp/' . $classCode->code . '/' . $folder, $filename);

            // insert to temporary table in database

            return $folder;
        }

        return '';
    }

    public function deletePostAttachment(Request $request)
    {
        $folder = $request->getContent();

        rmdir(storage_path('app/public/postattachment/tmp/' . $folder));
    }
}
