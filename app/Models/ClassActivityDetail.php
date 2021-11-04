<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassActivityDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'activity_id',
        'user_id',
        'folder',
        'filename',
        'filesize',
        'filetype',
        'thumbnail',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activity()
    {
        return $this->belongsTo(ClassActivity::class);
    }
}
