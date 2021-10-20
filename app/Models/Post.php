<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'description',
        'class_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function postAttachments()
    {
        return $this->hasMany(PostAttachments::class);
    }

    public function postComments()
    {
        return $this->hasMany(PostComments::class);
    }
}
