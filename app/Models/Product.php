<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Sluggable,HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'price',
        'size',
        'color',
        'short_text',
        'content',
        'qty',
        'kdv',
        'tax_free_price',
        'status',
    ];
    public function images() {
        return $this->hasOne(ImageMedia::class, 'table_id','id')->where('model_name','Product');
    }
    public function category () {
       return $this->hasOne(Category::class,'id','category_id');
    }
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function couponsWithProducts() {
        return $this->hasOne(Coupon::class, 'category_id','category_id')->where('status','1')->where('qty','>','0')->where('discount_rate','>','0');
    }
}
