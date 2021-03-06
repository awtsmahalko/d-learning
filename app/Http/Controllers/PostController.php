<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\File;
use App\Models\Classes;
use App\Models\ClassActivity;
use App\Models\Post;
use App\Models\TemporaryPostAttachments;
use App\Models\PostAttachments;
use App\Models\PostCommentAttachment;
use App\Models\PostComments;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $classwork = ClassActivity::select('class_id', DB::raw("'0' AS id"), 'id AS cw_id', DB::raw("title AS title"), "instruction AS description", 'created_at', 'user_id', DB::raw("'CW' AS module"), DB::raw("category AS category"))->where('class_id', $request->class_id)->withCount(["activity_details" => function ($q) use ($request) {
            $q->where('user_id', '=', $request->user_id);
        }]);

        $post = Post::select('class_id', 'id AS id', DB::raw("'0' AS cw_id"), DB::raw("'' AS title"), "description AS description", 'created_at', 'user_id', DB::raw("'POST' AS module"), DB::raw("'D' AS category"), DB::raw("'0' as activity_details_count"))->where('class_id', $request->class_id)->with('user', 'postAttachments');

        return response()->json($post->union($classwork)->orderByDesc('created_at')->get());
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
            'filetype' => $attachment['filetype'],
            'thumbnail' => $attachment['thumbnail']
        ]);
    }

    public function uploadAtachment(Request $request)
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
                    $thumbnail = "/postattachment/" . $classCode->code . '/' . $filename;
                } else {
                    $thumbnail = "/file_extension_icon/FILE.png";
                }
            }

            // insert to temporary table in database
            $tmpPostAttachment = TemporaryPostAttachments::create([
                'folder' => $folder,
                'filename' => $filename,
                'filesize' => $filesize,
                'filetype' => $fileType,
                'thumbnail' => $thumbnail
            ]);

            if ($tmpPostAttachment) {
                $file->storeAs('public/postattachment/tmp/' . $classCode->code . '/' . $folder, $filename);
            }

            return $folder;
        }

        return '';
    }

    public function deletePost(Request $request)
    {
        $attachments = PostAttachments::where('post_id', $request->post_id)->with('post')->get();
        foreach ($attachments as $attachment) {
            $filename = $attachment->filename;
            $classCode = Classes::find($attachment->post->class_id);

            if (Storage::exists('public/postattachment/' . $classCode->code . '/' . $filename)) {
                Storage::delete('public/postattachment/' . $classCode->code . '/' . $filename);
            }
        }

        PostAttachments::where('post_id', $request->post_id)->delete();
        PostComments::where('post_id', $request->post_id)->delete();
        Post::where('id', $request->post_id)->delete();
    }

    public function deletePostAttachment(Request $request)
    {
        $folder = $request->file;
        $classCode = Classes::find($request->classId);

        Storage::deleteDirectory('public/postattachment/tmp/' . $classCode->code . '/' . $folder);

        TemporaryPostAttachments::where('folder', $folder)->delete();
    }

    public function deleteAttachment(Request $request)
    {
        $attachment = PostAttachments::where('id', $request->attachment_id)->with('post')->first();
        $filename = $attachment->filename;
        $classCode = Classes::find($attachment->post->class_id);

        if (Storage::exists('public/postattachment/' . $classCode->code . '/' . $filename)) {
            Storage::delete('public/postattachment/' . $classCode->code . '/' . $filename);
        }

        PostAttachments::where('id', $request->attachment_id)->delete();
    }

    public function commentData(Request $request)
    {
        $comment = PostComments::where('post_id', $request->post_id)->orderBy('created_at')->with('user', 'comment_attachment')->get();
        return response()->json($comment);
    }

    public function commentStore(Request $request)
    {
        $comment = PostComments::create([
            'post_id' => $request->post_id,
            'user_id' => $request->user_id,
            'message' => $request->message
        ]);

        $this->moveCommentAttachments($request, $comment->id);

        return response()->json([
            'message' => 'Comment Posted Successfully!!',
            'class' => $comment
        ]);
    }

    public function uploadCommentAttachment(Request $request)
    {
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
                    $thumbnail = '/postcommentattachment/' . $request->classCode . '/' . $filename;
                } else {
                    $thumbnail = "/file_extension_icon/FILE.png";
                }
            }

            // insert to temporary table in database
            $tmpPostAttachment = PostCommentAttachment::create([
                'folder' => $folder,
                'filename' => $filename,
                'filesize' => $filesize,
                'filetype' => $fileType,
                'thumbnail' => $thumbnail,
                'status' => 'T'
            ]);

            if ($tmpPostAttachment) {
                $file->storeAs('public/postcommentattachment/' . $request->classCode . '/tmp/' . $folder, $filename);
            }

            return $folder;
        }

        return '';
    }

    public function revertCommentAttachment(Request $request)
    {
        $folder = $request->file;

        Storage::deleteDirectory('public/postcommentattachment/' . $request->classCode . '/tmp/' . $folder);

        PostCommentAttachment::where('folder', $folder)->delete();
    }

    public function moveCommentAttachments($request, $comment_id)
    {
        foreach ($request->commentedFiles as $commentedFile) {
            if ($commentedFile != null) {
                $tempPcFile = PostCommentAttachment::where('folder', $commentedFile)->first();

                if (Storage::exists('public/postcommentattachment/' . $request->classCode . '/tmp/' . $tempPcFile->folder . '/' . $tempPcFile->filename)) {
                    Storage::move('public/postcommentattachment/' . $request->classCode . '/tmp/' . $tempPcFile->folder . '/' . $tempPcFile->filename, 'public/postcommentattachment/' . $request->classCode . "/" . $comment_id . '/' . $tempPcFile->filename);

                    $thumbnail = '/postcommentattachment/' . $request->classCode . '/' . $comment_id . '/' . $tempPcFile->filename;

                    PostCommentAttachment::where('id', $tempPcFile->id)->update(['post_comment_id' => $comment_id, 'thumbnail' => $thumbnail, 'status' => 'S']);

                    Storage::deleteDirectory('public/postcommentattachment/' . $request->classCode . '/tmp/' . $tempPcFile->folder);
                }
            }
        }
    }

    public function deleteCommentAttachment(Request $request)
    {
        $commentFile = PostCommentAttachment::find($request->commentFile_id);

        Storage::delete('public/postcommentattachment/' . $request->classCode . '/' . $commentFile->post_comment_id . '/' . $commentFile->filename);

        PostCommentAttachment::where('id', $request->commentFile_id)->delete();
    }
}
