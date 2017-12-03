<?php

namespace App\Model\City;

use Illuminate\Database\Eloquent\Model;
use App\Model\Map;
use App\Model\City\CityResource;
class City extends Model
{
    public  static function create($name,$lng,$lat,$user_id,$user_flag){
        //需要判断当前位置能否创建城市
        if(1){
            $City = new City;
            $City->user_id = $user_id;
            $City->name = $name;
            $City->lng = $lng;
            $City->lat = $lat;
            $City->save();
            CityResource::create($City->id,$user_id);
            Map::where('lng',$lng)->where('lat',$lat)->update(['city'=>$user_flag,'user_id'=>$user_id]);
            return $City->id;
        }else{
            return "msg";
        }
       
    }
     public static function flashBuildQuene($city_id){
        self::where('id',$city_id)->update(["build_quene"=>2]);
    }
    
}