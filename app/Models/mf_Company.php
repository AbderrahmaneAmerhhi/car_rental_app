<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class mf_Company extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable =[
        'title',
        'slug',
        'logo',
    ];
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function Cars(){
        return $this->hasMany(Car::class,'id');
    }
}
