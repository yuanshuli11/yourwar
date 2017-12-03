<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\User;
use App\Model\City\City;
use App\Model\UserInfo;
use App\Model\UserTech;
use App\Model\Map;
use App\Model\City\CityBuilding;
use App\Model\Sys\SysObject;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        

    }
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
  
        if(!$request->user()->name){
            return $this->begin($request);
        }
        $user = $request->user();  
        $user_id = $user->id;
        $user_info = UserInfo::getUserInfo($user_id);        
        $user_info['user_name'] = $request->user()->name;
        
        // Redis::zadd('names1', '213123123','Taylor');
        // Redis::zadd('names1', '123123','111');
        // Redis::zadd('names1', '12412','222');
        // Redis::zadd('names1', '124124','2221');
        // $value =  Redis::zrange('names1',-1,-1);
        // print_r($value);
        return view('home')
                ->withUserInfo($user_info);

    }

    public function begin(Request $request)
    {
          
       return view('/once/begin');

    }
    public function beginSetting(Request $request)
    { 
        if(isset($request->user()->id)&&$request->user()->id>0&&!$request->user()->name){
            $User = User::with('hasUserInfo')->where('id',$request->user()->id)->first();
            if(!$User->hasUserInfo){
                $city_name = $request->get('cityName');
                $user_name = $request->get('user_name');
                $user_flag = $request->get('user_flag');
                $camp = $request->get('camp');
         
                $city_location = Map::getRandomLocationByDalu(1);
                $user_id = $request->user()->id;
                $create_city = City::create($city_name,$city_location['lng'],$city_location['lat'],$user_id,$user_flag);
                if($create_city){
                    User::where('id',$user_id)->update(['name'=>$user_name]);
                    UserInfo::create($user_id,$create_city,$user_flag,$camp);
                    header("Location: /");   
                    die();
                }else{
                    die("beginerror1");
                    return $this->begin($request);
                }
            }else{
               
                die("beginerror2");
            }
            
             
        }

       // return $this->index($request);

    }

    //军事区
    public function army(Request $request){
        $user_id = $request->user()->id;
        $user_info = UserInfo::getUserInfo($user_id);
        $city_id = $user_info['has_one_main_city']['id'];
        $city_building = CityBuilding::getCityBuilding($user_id,$city_id,'army');
        UserInfo::set_redis_csrf($user_id,csrf_token());
        $SysObject = SysObject::getAll(0);
        //键名为 建筑的name_type  键值为建筑的name
        $building_name = SysObject::getObjectName(0);
        //键名为 科技的name_type  键值为科技的name
        $tech_name = SysObject::getObjectName(4);
        // foreach ($city_building as $key => $value) {
        //    if(isset($SysObject[$value['name_type']])){
        //         $SysObject[$value['name_type']] = "";
        //    }
        // }

        $user_now_status['resouce'] = $user_info['has_one_city_resource'];
        

        //目前可建造的建筑
        $can_build = $SysObject;
            

      
        return view('part/army')
            ->withPartName('军事区')
            ->withBuilding($city_building)
            ->withBuildingName($building_name)
            ->withTechName($tech_name)
            ->withUserNowStatus($user_now_status)
            ->withCanBuild($can_build)
            ->withUserInfo($user_info);
    }
     //资源区
    public function resource(Request $request){
        $user_id = $request->user()->id;
        $user_info = UserInfo::getUserInfo($user_id);
        $city_id = $user_info['has_one_main_city']['id'];
        $city_building = CityBuilding::getCityBuilding($user_id,$city_id,'resource');
        UserInfo::set_redis_csrf($user_id,csrf_token());
        $SysObject = SysObject::getAll(1);
        //键名为 建筑的name_type  键值为建筑的name
        $building_name = SysObject::getObjectName(1);
        //键名为 科技的name_type  键值为科技的name
        $tech_name = SysObject::getObjectName(4);
        // foreach ($city_building as $key => $value) {
        //    if(isset($SysObject[$value['name_type']])){
        //         $SysObject[$value['name_type']] = "";
        //    }
        // }
       
        $user_now_status['resouce'] = $user_info['has_one_city_resource'];
        

        //目前可建造的建筑
        $can_build = $SysObject;
            
        
      
        return view('part/resource')
            ->withPartName('资源区')
            ->withBuilding($city_building)
            ->withBuildingName($building_name)
            ->withTechName($tech_name)
            ->withUserNowStatus($user_now_status)
            ->withCanBuild($can_build)
            ->withUserInfo($user_info);
    }
    //交易所
    public function trade(Request $request){
        $user_id = $request->user()->id;
        $user_info = UserInfo::getUserInfo($user_id);
        return view('part/trade')
            ->withPartName('交易所')
            ->withUserInfo($user_info);
    }
    //科研中心
    public function tech(Request $request){
        $user_id = $request->user()->id;
        $user_info = UserInfo::getUserInfo($user_id);
        $user_tech = UserTech::getUserTech($user_id);
        UserInfo::set_redis_csrf($user_id,csrf_token());
        //键名为 建筑的name_type  键值为建筑的name
        $building_name = SysObject::getBuildingName();
        //键名为 科技的name_type  键值为科技的name
        $tech_name = SysObject::getObjectName(4);
        $user_now_status['resouce'] = $user_info['has_one_city_resource'];
        return view('part/tech')
            ->withPartName('科研中心')
            ->withTech($user_tech)
            ->withBuildingName($building_name)
            ->withTechName($tech_name)
            ->withUserNowStatus($user_now_status)
            ->withUserInfo($user_info);
    }
     //地图区
    public function map(Request $request){
        $user_id = $request->user()->id;
        $user_info = UserInfo::getUserInfo($user_id);
        $city_info = $user_info['has_one_main_city'];
        $lng = $request->get('lng','');
        $lat = $request->get('lat','');
       
        if($lng=='' || $lat==''){
            $lng = $city_info['lng'];
            $lat = $city_info['lat'];
        }
      
        $Map = Map::getMap($lng,$lat);
        $map_max = config('setting.mapMax');
        $page_btn = [
            'up'=>[
                'lng'=>$Map['begin_lng'],
                'lat'=>$Map['begin_lat']==0?$map_max:$Map['begin_lat']-10,
            ],
            'down'=>[
                'lng'=>$Map['begin_lng'],
                'lat'=>$Map['begin_lat']+10>=$map_max?0:$Map['begin_lat']+10,
            ],
            'left'=>[
                'lng'=>$Map['begin_lng']==0?$map_max:$Map['begin_lng']-2,
                'lat'=>$Map['begin_lat'],
            ],
            'right'=>[
                'lng'=>$Map['begin_lng']+2>=$map_max?0:$Map['begin_lng']+2,
                'lat'=>$Map['begin_lat'],
            ],
        ];
        return view('part/map')
            ->withPartName('地图区')
            ->withMap($Map)
            ->withPageBtn($page_btn)
            ->withUserInfo($user_info);
    }

}
