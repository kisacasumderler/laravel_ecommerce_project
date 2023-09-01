<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'name',
        'price',
        'discount_rate',
        'status',
        'category_id',
        'isDiscount',
        'qty'
    ];
}
