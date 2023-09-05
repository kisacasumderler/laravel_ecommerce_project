<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
   protected $fillable = [
    'order_no',
    'status',
    'c_name',
    'c_email_address',
    'c_phone',
    'c_companyname',
    'c_country',
    'c_city',
    'c_address',
    'c_state_country',
    'c_postal_zip',
    'order_note',
    'status'
   ];

   public function orders() {
    return $this->hasMany(Order::class,'order_no','order_no');
   }
}
