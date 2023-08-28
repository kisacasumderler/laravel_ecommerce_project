<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'content',
        'link',
        'image',
        'MobileImage',
        'status',
    ];

    public function images() {
        return $this->hasOne(ImageMedia::class, 'table_id','id')->where('model_name','Slider');
    }
}
