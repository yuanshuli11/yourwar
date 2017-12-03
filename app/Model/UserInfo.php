<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use App\Model\Sys\SysObject;
use App\Model\UserTech;
use App\Model\City\CityResource;
class UserInfo extends Model
{   
    
    



    //添加用户信息
    public static function create($user_id,$main_city,$user_flag,$camp){
        $UserInfo = new UserInfo;
        $UserInfo->user_id = $user_id;
        $UserInfo->main_city = $main_city;
        $UserInfo->user_flag = $user_flag;
        $UserInfo->city_number = 1;
        $UserInfo->honor = 0;
        $UserInfo->camp = $camp==0?0:1;
        $UserInfo->save();
        $tech = SysObject::where("type","4")->get();
        $addTech = [];
        foreach ($tech as $key => $value) {
            $addTech[] = [
                'user_id'=>$user_id,
                'name'=>$value->name,
                'name_type'=>$value->name_type,
                'level'=>0,
                'name'=>$value->name,
            ];
        }
        UserTech::insert($addTech);
    }
   
    //重置用户redis中存的 csrf值
    public static function set_redis_csrf($user_id,$csrf){
        $user_csrf_key =  getRedisFlag('user_csrf',$user_id.'id',config('app.redis_dev'));
        Redis::set($user_csrf_key,$csrf);
    
    }   
    //获得用户redis中存的 csrf值
    public static function get_redis_csrf($user_id){

        $user_csrf_key =  getRedisFlag('user_csrf',$user_id.'id',config('app.redis_dev'));

        return Redis::get($user_csrf_key);
    } 
    //检验token是否正确
    public static function check_csrf_token($user_id,$token){
        
        if(self::get_redis_csrf($user_id)==$token){
            return true;
        }
        return false;
    }
    public function hasOneMainCity(){
        return $this->hasOne('App\Model\City\City','id','main_city');
    }
    public function hasOneCityResource(){
        return $this->hasOne('App\Model\City\CityResource','city_id','main_city');
    }
    public function hasManyOfficers(){
        return $this->hasMany('App\Model\City\CityOfficer','city_id','main_city');
    }
    public static function getUserInfo($user_id,$flash=false){

        $user_info_redis_key = getRedisFlag($user_id,'info',config('app.redis_dev'));
        if(!Redis::exists($user_info_redis_key)||$flash||1){
        $get_again = false;
        $user_info = UserInfo::with(['hasOneMainCity','hasOneCityResource',
                                    'hasManyOfficers'=>function($query) use($user_id){
                                        $query->select('id','user_id','city_id','name','level','stars','force','service','knowledge','location','status')->where('status','>','0')->where('user_id',$user_id);
                                }])
                                ->where('user_id',$user_id)->first()->toArray();
        $now = time();
        
        $user_tech = UserTech::getUserTech($user_id);
        //此处计算 已经考虑到 科技等级对资源产量的影响
        $user_info['has_one_city_resource'] = self::cal_city_resource($user_info['has_one_city_resource'],$user_tech);

        $resouce_update_gap =$now- strtotime($user_info['has_one_city_resource']['updated_at']);
        if( $resouce_update_gap >config('app.resource_gap')||$flash){            
            CityResource::gapUpdate($user_info['has_one_city_resource'],$resouce_update_gap);
            $get_again  = true;
        }      
        
        if($get_again){
            $user_info = UserInfo::with(['hasOneMainCity','hasOneCityResource',
                                    'hasManyOfficers'=>function($query) use($user_id){
                                        $query->select('id','user_id','city_id','name','level','stars','force','service','knowledge','location','status')->where('status','>','0')->where('user_id',$user_id);
                                }])
                                ->where('user_id',$user_id)->first()->toArray();
            
          
            $user_info['has_one_city_resource'] = self::cal_city_resource($user_info['has_one_city_resource'],$user_tech);

        }
        $user_info['getTime'] = $now;
        Redis::set($user_info_redis_key,json_encode($user_info));
        Redis::expire($user_info_redis_key,config('app.page_gap')); 
        $user_baseinfo_redis_key = getRedisFlag($user_id,'baseinfo',config('app.redis_dev'));
        Redis::set($user_baseinfo_redis_key,json_encode($user_info));
      
        }else{
            $user_info = json_decode(Redis::get($user_info_redis_key),true);
        }

        
        return $user_info;
    }
   
    private static function cal_city_resource($city_resouce,$user_tech){
        $chanliang = 0;
        $user_tech = collect($user_tech)->groupBy("name")->toArray();
        $resource_tech = UserTech::$resource_tech;
        foreach ($resource_tech as  $key=>$value) {
            $chanliang += $city_resouce[$key.'_change']*$city_resouce[$key.'_channeng'];
            //科技等级提升的资源产量 不占用人口
            if(isset($user_tech[$value][0])){
                $city_resouce[$key.'_change'] = $city_resouce[$key.'_change']*(1+$user_tech[$value][0]['level']*0.1);
            }
        }
        $busy_people =floor($chanliang/config("app.resource_people"));  
        $city_resouce['busy_people'] =$busy_people;
        $city_resouce['people_num'] -=$busy_people;
        $city_resouce['people_num'] = $city_resouce['people_num']<0?0:$city_resouce['people_num'];
        return $city_resouce;
    }
    public static function checkResource($user_id,$need_resource){
        $user_info = self::getUserInfo($user_id);
        $city_resouce = $user_info['has_one_city_resource'];
        foreach ($need_resource as $key => $value) {
            if($city_resouce[$key.'_num']<$value){
                return false;
            }
        }
        return true;
    }
}
