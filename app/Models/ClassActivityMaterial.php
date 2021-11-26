<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassActivityMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_activity_id',
        'folder',
        'filename',
        'filesize',
        'filetype',
        'thumbnail',
        'status'
    ];

    public function activity()
    {
        return $this->belongsTo(ClassActivity::class);
    }
}
