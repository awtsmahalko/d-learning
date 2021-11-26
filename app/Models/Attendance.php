<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'class_id',
        'user_id',
        'status',
        'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
