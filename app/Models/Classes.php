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

    public function classLists(){
        return $this->hasMany(ClassList::class,'class_id');
    }
}
