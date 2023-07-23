<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class specialOffer extends Model
{
    protected $fillable = [
        'name',
        'image',
        'title',
        'message',
        'link',
        'status',
    ];
}
