<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassActivityScoring extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_activity_id',
        'user_id',
        'points',
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
