<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ["review","user_id"];
    protected $with = ["user"];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
