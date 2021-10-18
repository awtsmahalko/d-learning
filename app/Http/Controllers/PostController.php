<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\File;
use App\Models\Classes;
use App\Models\Post;
use App\Models\TemporaryPostAttachments;
use App\Models\PostAttachments;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $post = Post::where('class_id', $request->class_id)->orderByDesc('created_at')->with('user', 'postAttachments')->get();
        return response()->json($post);
    }

    public function store(Request $request)
    {
        $class = Classes::find($request->postData['class_id']);
        $post = Post::create([
            'description' => $request->postData['description'],
            'class_id' => $request->postData['class_id'],
            'user_id' => $request->postData['user_id']
        ]);

        foreach ($request->postAttachData as $postFile) {
            // $test[] = $postFile['serverId'];
            if ($postFile != null) {
                $tempPostFile = TemporaryPostAttachments::where('folder', $postFile)->first();

                // Storage::disk('public')->put('example.txt', 'Contents');
                if (Storage::exists('public/postattachment/tmp/' . $class->code . '/' . $tempPostFile['folder'] . '/' . $tempPostFile['filename'])) {

                    Storage::move('public/postattachment/tmp/' . $class->code . '/' . $tempPostFile['folder'] . '/' . $tempPostFile['filename'], 'public/postattachment/' . $class->code . "/" . $tempPostFile['filename']);

                    $saveResponse = $this->saveToPostAttachmentTable($tempPostFile, $post->id);

                    Storage::deleteDirectory('public/postattachment/tmp/' . $class->code . '/' . $tempPostFile['folder']);

                    if ($saveResponse) {
                        TemporaryPostAttachments::where('id', $tempPostFile->id)->delete();
                    }
                }
            }
        }

        return response()->json([
            'message' => 'Post Created Successfully!!',
            'class' => $post
        ]);
    }

    public function saveToPostAttachmentTable($attachment, $post_id)
    {
        return PostAttachments::create([
            'post_id' => $post_id,
            'folder' => $attachment['folder'],
            'filename' => $attachment['filename'],
            'filesize' => $attachment['filesize'],
            'filetype' => $attachment['filetype']
        ]);
    }

    public function uploadAtachment(Request $request)
    {
        $classCode = Classes::find($request->classId);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $filesize = $file->getSize();
            $fileType = $file->getClientOriginalExtension();
            $folder = uniqid() . '-' . now()->timestamp;

            // insert to temporary table in database
            $tmpPostAttachment = TemporaryPostAttachments::create([
                'folder' => $folder,
                'filename' => $filename,
                'filesize' => $filesize,
                'filetype' => $fileType
            ]);

            if ($tmpPostAttachment) {
                $file->storeAs('public/postattachment/tmp/' . $classCode->code . '/' . $folder, $filename);
            }

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
