<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryPostAttachments extends Model
{
    use HasFactory;

    protected $fillable = ['folder', 'filename', 'filename', 'filesize', 'filetype', 'thumbnail'];
}
