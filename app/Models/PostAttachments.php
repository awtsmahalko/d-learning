<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostAttachments extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'folder', 'filename', 'filesize', 'filetype'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
