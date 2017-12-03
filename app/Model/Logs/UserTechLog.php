<?php

namespace App\Model\Logs;

use Illuminate\Database\Eloquent\Model;

class UserTechLog extends Model
{
    public static function addLog($techArr,$type){
        $UserTechLog = new UserTechLog;
        $UserTechLog->user_id = $techArr['user_id'];
        $UserTechLog->city_id = $techArr['city_id'];
        $UserTechLog->tech_id = $techArr['id'];
        $UserTechLog->type = $type;
        $UserTechLog->end_time = $techArr['building_end']; 
        //升级完成后的等级    
        $UserTechLog->tech_level = $techArr['level'];
        $UserTechLog->save();
    }
}
