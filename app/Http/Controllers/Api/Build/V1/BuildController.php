<?php

namespace App\Http\Controllers\Api\Build\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UserInfo;
use App\Model\UserTech;
use App\Model\Sys\SysObject;
use App\Model\Sys\SysObjectDetail;
use App\Model\City\City;
use App\Model\City\CityResource;
use App\Model\City\CityBuilding;
use App\Model\Logs\CityBuildingLog;
use App\Model\Logs\UserTechLog;
class BuildController extends Controller
{   
    public function getBuildUpInfo(Request $request){
        $user_id = $request->get('user_id');
        $area_id = $request->get('area_id','');
        $get_redis_csrf =UserInfo::get_redis_csrf($user_id); 

        if(UserInfo::check_csrf_token($user_id,$request->get('token'))&&is_numeric($area_id)){
            $user_info = UserInfo::getUserInfo($user_id);
            $main_city = $user_info['main_city'];
            $CityBuilding = CityBuilding::getFocusBuilding($user_id,$main_city,$area_id);

            if($CityBuilding){

                if($CityBuilding['level']<10){
                    $new_level = $CityBuilding['level']+1;
                    $SysObject = SysObject::getFocusObjectDetail($CityBuilding['type'],$CityBuilding['name_type'],$new_level);

                    return $this->apiResponse('0','success',$SysObject);
                   
                    
                }else{
                    return $this->apiResponse('1','已经不能再升级了哦~');
                }
            }else{
                return $this->apiAccident(__CLASS__.'~~'.__FUNCTION__ );
            }            
        }
    }
    public function building(Request $request){
        $user_id = $request->get('user_id');
        $get_redis_csrf =UserInfo::get_redis_csrf($user_id); 
        $type = $request->get('type','');
        $area_id = $request->get('area_id','area_id');
        $build_id = $request->get('build_id','');

        if(UserInfo::check_csrf_token($user_id,$request->get('token'))&&is_numeric($build_id)){
            $user_info = UserInfo::getUserInfo($user_id);
            $main_city = $user_info['main_city'];
            $SysObjectDetail = SysObjectDetail::with('hasOneObject')->where("id",$build_id)->first();
            $need_resource = json_decode($SysObjectDetail->need_resource,true);
            $need_building = json_decode($SysObjectDetail->need_building,true);
            $need_tech = json_decode($SysObjectDetail->need_tech,true);
            
            //校验建筑等级是否达到升级要求
            if(!CityBuilding::checkBuilding($user_id,$main_city,$need_building)){           
                return $this->apiResponse('1','建筑等级不够');
            }                
            //检查科技是否达到升级要求
            if(!UserTech::checkTech($user_id,$need_tech)){                
                return $this->apiResponse('1','科技等级不够');
            }
            //校验资源是否达到升级要求
            if(!UserInfo::checkResource($user_id,$need_resource)){
                return $this->apiResponse('1','资源不足');
            }
            //这里有问题~~~~~~~~~~~~~~~~~  队列数量判断
            //队列数量判断
            $building_count = CityBuilding::where('city_id',$user_info['has_one_main_city']['id'])->where('status',1)->count();
            $build_quene = $user_info['has_one_main_city']['build_quene'];
            if ($build_quene!=2) {
                 $end_time = strtotime($user_info['has_one_main_city']['more_quene_end']);  
                if($end_time<time()){
                    City::flashBuildQuene($user_info['has_one_main_city']['id']);
                    $build_quene = 2;
                }
            }
           
            //如果最大队列数 大于或等于 在建数 则不能键
            if($build_quene<=$building_count){
                return $this->apiResponse('1','建造队列繁忙');
            }

           //如果是建造 且目标建筑是限数的 ，则判断 已造数量是否大于限制数量  若大于等于则禁止再造
           
            if($SysObjectDetail->level==1&&$SysObjectDetail->hasOneObject->max_number!=0){
                $focus_building_count = CityBuilding::where('city_id',$main_city)->where('name_type',$SysObjectDetail->hasOneObject->name_type)->count();

                if($focus_building_count>=$SysObjectDetail->hasOneObject->max_number){
                    return $this->apiResponse('1','不能再建更多了~');
                }
            }
            
            //扣资源且二次确认
            if(!CityResource::reduceResource($main_city,$need_resource,"升级建筑".$build_id)){           
                return $this->apiResponse('1','资源不足');
            }
            //更新状态
            $building_end = date("Y-m-d H:i:s",time()+$SysObjectDetail->need_time);
            CityBuilding::where('id',$area_id)->where('city_id',$main_city)->update([
                    'name'=>$SysObjectDetail->hasOneObject->name,
                    'name_type'=>$SysObjectDetail->hasOneObject->name_type,
                    'level'=>$SysObjectDetail->level-1,
                    'status'=>1,
                    'building_end'=>$building_end,
                ]);
            $CityBuildingLog = new CityBuildingLog;
            $CityBuildingLog->city_id = $main_city;
            $CityBuildingLog->building_id = $area_id;
            $CityBuildingLog->building_name = $SysObjectDetail->hasOneObject->name;
            $CityBuildingLog->building_level = $SysObjectDetail->level-1;
            $CityBuildingLog->type = "开始升级";
            $CityBuildingLog->building_end = $building_end;
            $CityBuildingLog->save();
            //更新redis所有建筑信息
            CityBuilding::getCityBuilding($user_id,$main_city,'army',true);
            $returnData['building_end'] = $building_end;
            $returnData['building_name'] = $SysObjectDetail->hasOneObject->name;
            $returnData['building_level'] = '('.$SysObjectDetail->level.'级)';
            return $this->apiResponse('0','success',$returnData);
        }else{
             return $this->apiResponse('1','userinfo error');
        }
    }
    public function getTechUpInfo(Request $request){      
        $user_id = $request->get('user_id','');
        if(UserInfo::check_csrf_token($user_id,$request->get('token'))){     
            $tech_id = $request->get('tech_id','');
            $focus_tech = UserTech::find($tech_id)->toArray();
            if($focus_tech){
                $next_level = $focus_tech['level']+1;
                $type = 4;
                $SysObject = SysObject::with(['hasOneDetail'=>function($query) use($next_level){
                    return  $query->where('level',$next_level);
                }])->where("name_type",$focus_tech['name_type'])->where("type",$type)->first()->toArray();
                
                if(!$SysObject['has_one_detail']){
                    return $this->apiResponse('1','已经不能再升级了哦');
                }
                $SysObject['has_one_detail']['need_building'] = json_decode($SysObject['has_one_detail']['need_building'],true);
                $SysObject['has_one_detail']['need_resource'] = json_decode($SysObject['has_one_detail']['need_resource'],true);
                $SysObject['has_one_detail']['need_tech'] = json_decode($SysObject['has_one_detail']['need_tech'],true);

                return $this->apiResponse('0','success',$SysObject);
            }else{
                return $this->apiResponse('1','没有该科技信息');
            }
            

        }else{
             return $this->apiResponse('1','userinfo error');
        }



    }

    public function techBuild (Request $request){
        $user_id = $request->get('user_id','');
        if(UserInfo::check_csrf_token($user_id,$request->get('token'))){     
            $tech_id = $request->get('tech_id','');
            $focus_tech = UserTech::find($tech_id)->toArray();

            $type = 4;
            //校验是否能够建造
            if($focus_tech['status']!=0){           
                return $this->apiResponse('1','该状态下不能建造');
            }
            $next_level = $focus_tech['level']+1;
            //校验是否能够建造
            if($next_level>10){           
                return $this->apiResponse('1','已经满级啦');
            }
            $user_info = UserInfo::getUserInfo($user_id);
            $user_tech = UserTech::getUserTech($user_id);
            $main_city = $user_info['main_city'];
            $SysObject = SysObject::with(['hasOneDetail'=>function($query) use($next_level){
                return  $query->where('level',$next_level);
            }])->where("name_type",$focus_tech['name_type'])->where("type",$type)->first()->toArray();
            if(!$SysObject['has_one_detail']){
                return $this->apiResponse('1','一定是哪里出了错！');
            }
            $need_resource = json_decode($SysObject['has_one_detail']['need_resource'],true);
            $need_building = json_decode($SysObject['has_one_detail']['need_building'],true);
            $need_tech = json_decode($SysObject['has_one_detail']['need_tech'],true);
            
            //校验建筑等级是否达到升级要求
            if(!CityBuilding::checkBuilding($user_id,$main_city,$need_building)){           
                return $this->apiResponse('1','建筑等级不够');
            }                
            //检查科技是否达到升级要求
            if(!UserTech::checkTech($user_id,$need_tech)){                
                return $this->apiResponse('1','科技等级不够');
            }
            //校验资源是否达到升级要求
            if(!UserInfo::checkResource($user_id,$need_resource)){
                return $this->apiResponse('1','资源不足');
            }
            //判断改城市能否开始研究科技
            foreach ($user_tech as $value) {
                if($value['status']==1&&$value['city_id']==$main_city){
                    return $this->apiResponse('1','科研中心很忙~');
                }
            }

            // //扣资源且二次确认
            // if(!CityResource::reduceResource($main_city,$need_resource,"研究科技".$tech_id)){           
            //     return $this->apiResponse('1','资源不足');
            // }
            //更新状态
            $building_end = date("Y-m-d H:i:s",time()+$SysObject['has_one_detail']['need_time']);
            UserTech::where('id',$tech_id)->update([
                    'status'=>1,
                    'city_id'=>$main_city,
                    'building_end'=>$building_end,
                ]);
            UserTech::getUserTech($user_id,true);
            $logArr['user_id'] = $user_id;
            $logArr['id'] = $SysObject['has_one_detail']['id'];
            $logArr['city_id'] = $main_city;
            $logArr['tech_id'] = $tech_id;
            $logArr['building_end'] = $building_end;
            $logArr['level'] = $SysObject['has_one_detail']['level'];
            UserTechLog::addLog($logArr,"开始升级");

            return $this->apiResponse('0','建造成功');
        }
      


    }

}
