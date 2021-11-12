<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'delivery_man_id',
        'orders',
        'total',
        'date_delivered',
        'time_delivered',
    ];

    protected $with = ['user','delivery_man'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function delivery_man (){
        return $this->belongsTo(DeliveryMan::class);
    }
}
