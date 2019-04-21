<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use App\Model\Country;

class City extends Model
{
  protected $table='cities';

  protected $fillable=[
      'city_name_ar',
      'city_name_en',
      'country_id',
  ];





}
