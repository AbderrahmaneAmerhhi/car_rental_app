<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'company_id',
        'Brande',
        'slug',
        'type',
        'prixJ',
        'dispo',
        'image'
];
public function getRouteKeyName()
{
    return 'slug';
}

  public function Company(){
    return $this->belongsTo(mf_Company::class,'company_id');
}
}
