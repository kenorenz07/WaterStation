<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'delivery_man_id',
        'orders',
        'total',
        'status',
        'date_to_deliver',
        'time_to_deliver',
   ];

    // 'on-the-way','assinged-to-driver', 'pending','delivered','accepted','denied'

   protected $with = ['user','delivery_man'];

   public function user(){
       return $this->belongsTo(User::class);
   }
   
   public function delivery_man (){
       return $this->belongsTo(DeliveryMan::class);
   }
}
