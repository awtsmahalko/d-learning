<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassList extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'class_id',
        'status'
    ];
}
