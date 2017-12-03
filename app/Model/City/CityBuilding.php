<?php

namespace App\Model\City;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use App\Model\Logs\CityBuildingLog;
use App\Model\City\CityResource;
use App\Model\Sys\SysObject;
class CityBuilding extends Model
{
    public static function newCity($city_id){
            $armyBuilding = config('setting.armyBuilding');
            $resourceBuilding = config('setting.resourceBuilding');
          // name 会在对应的数据中定义 1表示市政厅 不变  30 表示空地不变
            // type 0 表示军事建筑  type 1表示资源建筑
            $insertData[] = [
                'city_id'=>$city_id,
                'name'=>$armyBuilding[1],
                'name_type'=>1,
                'level'=>1,
                'type'=>'0',
                'status'=>'0',
            ];
            for ($i=0; $i <12 ; $i++) { 
                //资源建筑
                $insertData[] = [
                    'city_id'=>$city_id,
                    'name'=>$armyBuilding[30],
                    'name_type'=>40,
                    'type'=>'1',
                    'status'=>'0',
                    'level'=>null,
                ];
                //因为已有市政厅 所以军事建筑少一个
                if($i>0){
                    $insertData[] = [
                        'city_id'=>$city_id,
                        'name'=>$armyBuilding[30],
                        'type'=>'0',
                        'name_type'=>30,
                        'status'=>'0',
                        'level'=>null,
                    ];
                }
            }
            $CityBuilding = new CityBuilding;
            $CityBuilding->insert($insertData);
    }
    public static function readData($city_id){
        return CityBuilding::where('city_id',$city_id)->orderBy('name_type','asc')->get()->toArray();
    }
   




    public static function getCityBuilding($user_id,$city_id,$type='army',$flash=false){
        $user_building_redis_key = getRedisFlag($user_id,'building'.$city_id,config('app.redis_dev'));
        if(Redis::exists($user_building_redis_key)&&!$flash){
            $CityBuilding =  json_decode(Redis::get($user_building_redis_key),true) ;
            // //如果有建筑 状态改变 则重新获取 最新的数据
            // //两次 redis set 的位置不一样  因为一次是从数据库取值  另一次是从redis取值
            // if(CityBuilding::checkTime($CityBuilding)){
            //     $CityBuilding = CityBuilding::readData($city_id);
            //     Redis::set($user_building_redis_key,json_encode($CityBuilding));
            //     Redis::expire($user_building_redis_key,config('app.part_gap'));
            // }
        }else{
            $CityBuilding =CityBuilding::readData($city_id);
            // //如果有建筑 状态改变 则重新获取 最新的数据
            // if(CityBuilding::checkTime($CityBuilding)){
            //     $CityBuilding = CityBuilding::readData($city_id);
            // }
            Redis::set($user_building_redis_key,json_encode($CityBuilding));
            Redis::expire($user_building_redis_key,config('app.part_gap'));
        }
        $returnArr = [];
        //根据type返回 数据
        $CityBuilding = self::checkFinish($user_id,$CityBuilding,$type);
        if($type=='army'){
            foreach ($CityBuilding as $key => $value) {
                if($value['type']==0){
                    $returnArr []=$value;
                }
            }
        }else if($type=='resource'){
            foreach ($CityBuilding as $key => $value) {
                if($value['type']==1){
                    $returnArr []=$value;
                }
            }
        }else{
            $returnArr = $CityBuilding;
        }
        return $returnArr;
    }
    public static function checkFinish($user_id,$CityBuilding,$type){

        $now_time = date("Y-m-d H:i:s");
        foreach ($CityBuilding as $key => $value) {            
            if($value['status']==1&&$value['building_end']<$now_time){
                if($value['level']<10){
                    $new_level = $value['level']+1;
                  
                    $SysObject = SysObject::getFocusObjectDetail($value['type'],$value['name_type'],$value['level']+1);
                    if($SysObject&&$SysObject['has_one_begin']['enhance']){
                        $enhance = json_decode($SysObject['has_one_begin']['enhance'],true);                        
                        foreach ($enhance as $key => $adden) {
                            CityResource::where('city_id',$value['city_id'])->increment($key, $adden);
                        }
                    }
                    CityBuildingLog::addLog($value,"升级完成");
                    CityBuilding::where('id',$value['id'])->update(['level'=>$new_level,'status'=>0,'building_end'=>null]);
                    
                    return self::getCityBuilding($user_id,$value['city_id'],$type,true);
                }
            }
        }
        return $CityBuilding;
      
    }
    //根据建筑id获取目标建筑信息
    public static function getFocusBuilding($user_id,$city_id,$area_id){
        $city_building = self::getCityBuilding($user_id,$city_id,'all',false);
        foreach ($city_building as $key => $value) {
            if($value['id']==$area_id){
                return $value;
            }
          
        }
        return false;

    }

    public static function checkTime($city_building){
        $has_num = 0;
        foreach ($city_building as $key => $value) {
            if($value['status'] == 1){
                echo "CityBuilding";
                $has_num++;
            }
        }
        $has_num = 1;
        return $has_num;
       
    }
    //校验  用户建筑是否达到规定要求
    public static function checkBuilding($user_id,$city_id,$need_building){
    
        $cityBuilding = self::buildMax(self::getCityBuilding($user_id,$city_id,"all",true));
        
        foreach ($need_building as $key => $value) {
            if(isset($cityBuilding[$value['name_type']])){
                if($cityBuilding[$value['name_type']]<$value['level']){
                    return false;
                }
            }else{
                return false;
            }
        }
        return true;
    }
    public static function buildMax($cityBuilding ){
        $returnArr = [];
        foreach ($cityBuilding as $key => $value) {
            if(isset($returnArr[$value['name_type']])){
                if($returnArr[$value['name_type']]<$value['level']){
                    $returnArr[$value['name_type']]  = $value['level'];
                }
            }else if($value['name_type']!=30){
                 $returnArr[$value['name_type']]  = $value['level'];
            }
           
        }
        return $returnArr;
    }

    public function getInBuindingNumber($city_id){
        return CityBuilding::where('city_id',$city_id)->where('status','1')->count();
    }
}
