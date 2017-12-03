<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
class SysObject extends Model
{   

    public function hasOneBegin(){
        return $this->hasOne('App\Model\Sys\SysObjectDetail','object_id','id');
    }
    public function hasManyDetails(){
        return $this->hasMany('App\Model\Sys\SysObjectDetail','object_id','id');
    }
    public function hasOneDetail(){
        return $this->hasOne('App\Model\Sys\SysObjectDetail','object_id','id');
    }
    public  static function getObjectName($type){
        //type 0军事建筑 1资源建筑 2攻击军队 3防御军队 4科技
        $objectName_redis_key =  getRedisFlag('all',$type.'objectName',config('app.redis_dev'));
        if(!Redis::exists($objectName_redis_key)){
            $SysObject = SysObject::with(['hasManyDetails'])->select("name","name_type")->where("type",$type)->get();
            $returnArr = [] ;
            foreach ($SysObject as $key => $value) {
                 $returnArr[$value->name_type] = $value->name;
            }
            Redis::set($objectName_redis_key,json_encode($returnArr));
        }else{
            $returnArr = json_decode(Redis::get($objectName_redis_key),true);
        }
        return $returnArr;
    }
    public static function getBuildingName(){
        $resource_building_name = SysObject::getObjectName(1);
        $building_name = SysObject::getObjectName(0);
        foreach ($resource_building_name as $key => $value) {
            $building_name[$key] = $value;
        }
        return $building_name;
    }
    public static function getFocusObjectDetail($type,$name_type,$level){
        $SysObject =  self::getAll($type);
       
        foreach ($SysObject as  $value) {
            if($value['name_type']==$name_type){
                foreach ($value['has_many_details'] as  $item) {
                    if($item['level']==$level){
                        $returnArr= $value;
                        $returnArr['level'] = $item['level'];
                        $returnArr['building_id'] = $item['id'];
                        $returnArr['building'] = json_decode($item['need_building'],true);
                        $returnArr['resource'] = json_decode($item['need_resource'],true);
                        $returnArr['tech'] = json_decode($item['need_tech'],true);
                        
                     
                        return $returnArr;
                    }
                }
            }
        }
        return false;
    }


    public static function  getAll($type,$flash=false){
    //type 0军事建筑 1资源建筑 2攻击军队 3防御军队 4科技
    $buildingInfo_redis_key =  getRedisFlag('all',$type.'buildinginfo',config('app.redis_dev'));

    if(!Redis::exists($buildingInfo_redis_key)||$flash){

        $SysObject =  SysObject::with(['hasOneBegin'=>function($query){
            return $query->where('level','1');
        },'hasManyDetails'])->where('type',$type)->orderBy('name_type','asc')->get()->toArray();

        $objectArr = [];
        foreach ($SysObject as $key => $value) {
            if(isset($value['has_one_begin']['need_resource'])){
                if($value['has_one_begin']['need_resource']!="[]"){
                     $value['resource'] = json_decode($value['has_one_begin']['need_resource'],true);
                 
                }else{
                     $value['resource'] = $value['has_one_begin']['need_resource'];
                }
                if($value['has_one_begin']['need_tech']!="[]"){
                     $value['tech'] = json_decode($value['has_one_begin']['need_tech'],true);
                 
                }else{
                     $value['tech'] = $value['has_one_begin']['need_tech'];
                }
                if($value['has_one_begin']['need_building']!="[]"){
                     $value['building'] = json_decode($value['has_one_begin']['need_building'],true);
                 
                }else{
                     $value['building'] = $value['has_one_begin']['need_building'];
                }
                $objectArr[]=$value;
            }
        }
        Redis::set($buildingInfo_redis_key,json_encode($objectArr));
     }else{
        $objectArr = json_decode(Redis::get($buildingInfo_redis_key),true);
     }
     return $objectArr;

    return $objectArr;

   }
    
   
}
