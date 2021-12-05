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
        'category',
        'status'
    ];

    protected $casts = [
        'duedate' => 'datetime',
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
        return $this->hasMany(ClassList::class,'class_id','class_id');
    }

    public function activity_details()
    {
        return $this->hasMany(ClassActivityDetail::class);
    }

    public function activity_material()
    {
        return $this->hasMany(ClassActivityMaterial::class);
    }

    public function activity_scoring()
    {
        return $this->hasMany(ClassActivityScoring::class);
    }
}
