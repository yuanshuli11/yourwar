<?php

// use Illuminate\Support\Facades\Redis;

// function updateAllTime($user_id,$redis_dev){
//     $redis_key = getRedisFlag($user_id,'uptime',$redis_dev);
//     $values = Redis::zrange($redis_key,-1,-1);
   
//     if($values){
//         //如果存在最近时间 
//     }else{
//         //如果不存在最近时间
        
//     }
// }

// //设置用户 redis信息
// function setRedisUserInfo($user_id,$user_info,$redis_dev){
//     $redis_key = getRedisFlag($user_id,'info',$redis_dev);
 
//     Redis::set($redis_key,json_encode($user_info));
// }
//获取redis 键值
function getRedisFlag($user_id,$type,$redis_dev){
    return 'user'.$user_id.$type.$redis_dev;
}
//单位换算
function changeUnit($number){
    if($number<10000){
        return floor($number);
    }else if($number<1000000){
        $number = floor($number/10)*10;       
        return round($number/1000,2)."k";
    }else{
        $number = floor($number/10000)*10000;        
        return round($number/1000000,2)."M";
    }
}
//将秒产量换为时产量
function calSpeed($number){
return ($number>0?'+':'').changeUnit(round($number))."/h";
}