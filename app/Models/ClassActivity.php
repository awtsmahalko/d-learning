<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'class_id',
        'title',
        'instruction',
        'points',
        'duedate',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
