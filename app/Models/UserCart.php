<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'normaluser_id',
        'availability_id',
        'requesteddate',
        'requestedtime',
        'requested',
        'accepted',
        'jobstarttime',
        'jobendtime',
    ];
}
