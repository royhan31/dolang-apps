<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $guarded = [];

    public function panoramas(){
      return $this->hasMany(Panorama::class,'tour_id','id');
    }
}
