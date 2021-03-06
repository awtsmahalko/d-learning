<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'description',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classLists()
    {
        return $this->hasMany(ClassList::class, 'class_id');
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class, 'class_id');
    }
}
