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

    public function images() {
        return $this->hasOne(ImageMedia::class, 'table_id','id')->where('model_name','specialOffer');
    }
}
