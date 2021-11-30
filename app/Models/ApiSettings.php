<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiSettings extends Model
{
    use HasFactory;
    protected $fillable = [
        'api_key',
        'api_secret',
        'jwt_token',
        'zoom_user_id',
        'status'
    ];
}
