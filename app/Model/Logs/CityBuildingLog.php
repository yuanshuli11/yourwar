<?php

namespace App\Model\Logs;

use Illuminate\Database\Eloquent\Model;

class CityBuildingLog extends Model
{
    public static function addLog($buildingArr,$type){
        $CityBuildingLog = new CityBuildingLog;   
        $CityBuildingLog->city_id = $buildingArr['city_id'];
        $CityBuildingLog->building_id = $buildingArr['id'];
        $CityBuildingLog->building_name = $buildingArr['name'];
        $CityBuildingLog->type = $type;
        $CityBuildingLog->building_end = $buildingArr['building_end'];     
        $CityBuildingLog->building_level = $buildingArr['level'];  
        $CityBuildingLog->save();
    }
}
