<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Sluggable;
    protected $fillable = [
        'name',
        'slug',
        'content',
        'cat_ust',
        'status',
    ];

    public function images() {
        return $this->hasOne(ImageMedia::class, 'table_id','id')->where('model_name','Category');
    }

    public function items () {
        return $this->hasMany(Product::class,'category_id','id');
    }
    public function subCategory() {
        return $this->hasMany(Category::class,'cat_ust','id');
    }
    public function category() {
        return $this->hasOne(Category::class,'id','cat_ust');
    }

    public function getTotalProductCount() {
        $total = $this->items()->count();
        foreach ($this->subcategory as $childCategory) {
            $total += $childCategory->items()->count();
        }

        return $total;
    }

    public function parentCategory() {
        return $this->belongsTo(Category::class, 'cat_ust','id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
