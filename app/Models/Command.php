<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Command extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable =[
        'user_id',
        'car_id',
        'dateL',
        'dateR',
        'PrixTTC',
        'notes',


    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function car(){
        return $this->hasOne(Car::class,'id','car_id');
    }
}
