<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'scheduled_at',
        'number',
        'password',
        'join_url',
        'class_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function classLists()
    {
        return $this->belongsTo(ClassList::class, 'class_id', 'class_id');
    }
}
