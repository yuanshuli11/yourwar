<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class SysObjectDetail extends Model
{
   public function hasOneObject(){
    return $this->belongsTo('\App\Model\Sys\SysObject','object_id');
   }
   
}
