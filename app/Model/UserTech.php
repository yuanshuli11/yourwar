<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use App\Model\Logs\UserTechLog;
class UserTech extends Model
{   public static $resource_tech = [
                'food'=>'粮食生产',
                'steel'=>'钢铁生产',
                'oil'=>'石油生产',
                'rare'=>'稀矿生产'
            ];
    public static function checkTech($user_id,$need_tech){
        $UserTech = self::getUserTech($user_id);       
        if(count($need_tech)){
            foreach ($need_tech as $key => $value) {
                foreach ($UserTech as $iKey => $item) {
                    if($item['name_type']==$value['name_type']){
                        if($item['level']<$value['level']){
                            return false;
                        }
                        break;
                    }
                }

            }
        }
        return true;
    }
    public static function getUserTech($user_id,$flash=false){
        $user_tech_redis_key = getRedisFlag($user_id,'tech',config('app.redis_dev'));
        if(!Redis::exists($user_tech_redis_key)||$flash){
            $UserTech = self::where('user_id',$user_id)->orderBy('name_type','asc')->get()->toArray();
            Redis::set($user_tech_redis_key,json_encode($UserTech));
        }else{
            $UserTech = json_decode(Redis::get($user_tech_redis_key),true);
        }
        return self::checkFinish($UserTech);
    }
    //判断科技是否升级完成 若完成 提升相应的能力
    public static function checkFinish($UserTech){
        $now_time = date("Y-m-d H:i:s");
        foreach ($UserTech as $key => $value) {
            if($value['status'] == 1&&$value['building_end']<$now_time){
                if($value['level']<10){
                    $new_level = $value['level']+1;
                    UserTechLog::addLog($value,"升级完成"); 
                    UserTech::where('id',$value['id'])->update(['level'=>$new_level,'status'=>0,'city_id'=>null]);
                    //记下来是提升用户能力

                    return self::getUserTech($value['user_id'],true);
                }
            }
        }
        return $UserTech;

    }
}
