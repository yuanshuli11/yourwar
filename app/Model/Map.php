<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
class Map extends Model
{   
    public static function getMap($lng,$lat){
        $lng_offset = $lng%2==0?$lng:$lng-1;
        $lat_offset = floor($lat/10);
        $map_redis_key =  getRedisFlag('mapof','lng'.$lng_offset.'lat'.$lat_offset.'end',config('app.redis_dev'));
 
        if(!Redis::exists($map_redis_key)){
            Map::RedisMapUpdate($lng_offset,$lat_offset);
        }
        $map = json_decode(Redis::get($map_redis_key),true);
        $returnMap = [
            'begin_lng'=>$lng_offset,
            'begin_lat'=>$lat_offset*10,
            'data'=>$map,
        ];
     
        return $returnMap;
    }
    public static function RedisMapUpdate($lng_offset,$lat_offset){
        $min_lng = $lng_offset;
        $max_lng = $lng_offset+1; 
        $min_lat = $lat_offset*10;
        $max_lat = $min_lat+9;

        $Map = Map::select('id','city','lng','lat','user_id','level')->where('lng','>=',$min_lng)->where('lng','<=',$max_lng)
            ->where('lat','>=',$min_lat)->where('lat','<=',$max_lat)->orderBy('lat','asc')->orderBy('lng','asc')->get()->toArray();
        $map_redis_key =  getRedisFlag('mapof','lng'.$lng_offset.'lat'.$lat_offset.'end',config('app.redis_dev'));
        Redis::set($map_redis_key,json_encode($Map));

    }
    public static function getRandomLocationByDalu($dalu){

        $lng_min = 0;
        $lng_max = 99;
        $lat_min = 0;
        $lat_max = 99;

        $Map = Map::where('lat','>=',$lat_min)
                  ->where('lat','<=',$lat_max)
                  ->where('lng','>=',$lng_min)
                  ->where('lng','<=',$lng_max)->where('map_type','5')->inRandomOrder()->first();
        
        if($Map){

             return [
                'lat'=>$Map->lat,
                'lng'=>$Map->lng
            ];
        }else{
            return ;
        }
        // return [
        //     'lat'=>Map->lat,
        //     'lng'=>Map->lng
        //     ];
            
    }
}
