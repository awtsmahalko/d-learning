<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCommentAttachment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'folder', 'filename', 'filesize', 'filetype', 'thumbnail'];

    public function comment()
    {
        return $this->belongsTo(PostComments::class);
    }
}
