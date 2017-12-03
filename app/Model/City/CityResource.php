<?php

namespace App\Model\City;

use Illuminate\Database\Eloquent\Model;
use App\Model\Logs\CityResourceLog;
use App\Model\UserInfo;
class CityResource extends Model
{   
    public static function create($city_id,$user_id,$Resource_arr = null){
        $default_Resource_arr = [
            'food_num' => 5000,
            'steel_num'=>5000,
            'oil_num'=>5000,
            'rare_num'=>5000,
            'gold_num'=>5000,
            'people_num'=>100
        ];
        if($Resource_arr){
            foreach ($Resource_arr as $key => $value) {
                if(isset($default_Resource_arr[$key])){
                    $default_Resource_arr[$key]-=$value;
                }
            }
        }
        $CityResource = new CityResource;
        $CityResource->user_id = $user_id;
        $CityResource->city_id = $city_id;
        $CityResource->food_num =$default_Resource_arr['food_num'];
        $CityResource->steel_num =$default_Resource_arr['steel_num'];
        $CityResource->oil_num =$default_Resource_arr['oil_num'];
        $CityResource->rare_num =$default_Resource_arr['rare_num'];
        $CityResource->gold_num =$default_Resource_arr['gold_num'];    
        $CityResource->people_num =$default_Resource_arr['people_num'];    
        $CityResource->save();
    }
    public static function reduceResource($main_city,$need_resource,$logtext){

        $resource = self::where("city_id",$main_city)->first();
        $CityResourceLog = new CityResourceLog;
        $CityResourceLog->user_id = $resource->user_id;
        $CityResourceLog->city_id = $resource->city_id;
        $CityResourceLog->text = $logtext;
        foreach ($need_resource as $key => $value) {
           if($value>0){
            $key = $key.'_num';
            $log_key = 'add_'.$key;
            $new_resource = $resource->$key - $value;
            if($new_resource>0){
                $resource->$key = $resource->$key - $value;
                $CityResourceLog->$log_key = -$value;
            }else{
                return false;
            }
            
           }
        }
        $resource->save();
        $CityResourceLog->save();
        //刷新用户数据
        UserInfo::getUserInfo($resource->user_id,true);
        return true;
    }
    public static function gapUpdate($resource_info,$gap){
        if($gap>0){
            $per = 3600;
            $gap = $gap>259200?259200:$gap;
            $city_resource = CityResource::where('id',$resource_info['id']);
            $text = "资源更新间隔：".$gap."秒";
            $resource_add = $gap;
            $update_arr = [];
            if($resource_info['acce_time'] > 0){
                if($resource_info['acce_time']>$gap){                 
                    $update_arr['acce_time'] = $resource_info['acce_time']-$gap;
                    $acce_time = $gap;
                    $resource_add = $gap*$resource_info['acce_persent'];
                }else{
                    $update_arr['acce_time'] = 0;
                    $acce_time = $resource_info['acce_time'];
                    $resource_add = $gap -$acce_time +$resource_info['acce_persent']*$acce_time ;

                }
                $text .= ",其中加速时间：".$acce_time."秒";
            }
            $add_food_num=  $resource_info['food_channeng']*$resource_info['food_change']*$resource_add/$per;
            $add_steel_num =  $resource_info['steel_channeng']*$resource_info['steel_change']*$resource_add/$per;
            $add_oil_num =  $resource_info['oil_channeng']*$resource_info['oil_change']*$resource_add/$per;
            $add_rare_num =  $resource_info['rare_channeng']*$resource_info['rare_change']*$resource_add/$per;
            $add_gold_num =  $resource_info['gold_change']*$gap/$per;
            $add_people_num =  $resource_info['people_change']*$gap/$per;
            $update_arr['food_num']  = $resource_info['food_num']+$add_food_num;
            $update_arr['steel_num']  = $resource_info['steel_num']+$add_steel_num;
            $update_arr['oil_num']  = $resource_info['oil_num']+$add_oil_num;
            $update_arr['rare_num'] = $resource_info['rare_num']+$add_rare_num;
            $update_arr['gold_num']  = $resource_info['gold_num']+$add_gold_num;
            $people_num = $resource_info['people_num']+$add_people_num;
            $people_num =  $people_num>$resource_info['people_max']?$resource_info['people_max']:$people_num;
            $add_people_num = $people_num -$resource_info['people_num'];
            $update_arr['people_num']  = $people_num;
            $city_resource->update($update_arr);
            $city_resource_log =new CityResourceLog;
            $city_resource_log->city_id = $resource_info['city_id'];
            $city_resource_log->user_id = $resource_info['user_id'];
            $city_resource_log->text = $text;
            $city_resource_log->add_food_num = $add_food_num;
            $city_resource_log->add_steel_num = $add_steel_num;
            $city_resource_log->add_oil_num = $add_oil_num;
            $city_resource_log->add_rare_num = $add_rare_num;
            $city_resource_log->add_gold_num = $add_gold_num;
            $city_resource_log->add_people_num = $add_people_num;
            $city_resource_log->save();
        }
        
        
    }
    
}
