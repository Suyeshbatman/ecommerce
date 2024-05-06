<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Available_Services extends Model

{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'services_id',
        'image',
        'difficulty',
        'rate',
        'zip',
        'city',
    ];
}
