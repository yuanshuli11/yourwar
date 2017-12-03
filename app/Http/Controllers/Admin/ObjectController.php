<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Sys\SysObject;
use App\Model\Sys\SysObjectDetail;
class ObjectController extends Controller
{
    
    public function list(Request $request){
        $SysObject = SysObject::where('id','>','0');
        if($request->get('type','')!=''&&$request->get('type','')!='all'){
           $SysObject->where('type',$request->get('type','')); 
        }
        $SysObject=$SysObject->orderBy("type","asc")->orderBy("name_type","asc")->paginate(10);

        return view('admin/object/list')->withObject($SysObject)->withPage("对象列表");
    }
    public function add(Request $request){
        return view('admin/object/add')->withPage("添加对象");
    }
    public function addDetail(Request $request,$id){
        $need_building = [];
        $type = $request->get('type',0);
        if($request->get('need_building1',0)){
            $need_building[]= [
                'name_type'=>$request->get('need_building1',0),
                'level'=>$request->get('need_building1_level',0),
            ];
        }
        if($request->get('need_building2',0)&&$request->get('need_building2',0)!=$request->get('need_building1',0)){
            $need_building[]= [
                'name_type'=>$request->get('need_building2',0),
                'level'=>$request->get('need_building2_level',0),
            ];
        }
        $need_tech = [];
        if($request->get('need_tech1',0)){
            $need_tech[]= [
                'name_type'=>$request->get('need_tech1',0),
                'level'=>$request->get('need_tech1_level',0),
            ];
        }
        if($request->get('need_tech2',0)&&$request->get('need_tech2',0)!=$request->get('need_tech1',0)){
            $need_tech[]= [
                'name_type'=>$request->get('need_tech2',0),
                'level'=>$request->get('need_tech2_level',0),
            ];
        }
        $ability=[];
        if($request->get('resource_ability',0)&&$request->get('resource_ability_value',0)){
            $ability[$request->get('resource_ability',0)]=$request->get('resource_ability_value',0);
        }
        $SysObjectDetail = SysObjectDetail::where('object_id',$id)->where('level',$request->get('level',0))->first();
        if( !$SysObjectDetail){
          $SysObjectDetail = new SysObjectDetail;
        }
        $SysObjectDetail->object_id = $id;
        if($request->get('level',0)){
            $SysObjectDetail->level = $request->get('level',0);
        }
        $SysObjectDetail->need_resource = json_encode($request->get('resource',[]));
        $SysObjectDetail->need_building = json_encode($need_building);
        $SysObjectDetail->need_tech = json_encode($need_tech);
        $SysObjectDetail->enhance = json_encode($ability);
        $SysObjectDetail->need_time = $request->get('need_time',0);
        $SysObjectDetail->save();

        SysObject::getAll($type,true);

        //还有系统能力  城市能力  建造时长  拆除时长
        return view('admin/success')
                    ->withTitle("添加成功,点击返回上一页。")
                    ->withUrl(asset('/sysadmin/object/edit/'.$id));

    }
   
    public function edit(Request $request,$id){
       // $SysObject= SysObject::find($id)->toArray();
        $SysObject = SysObject::where('id',$id)->orWhere('type',0)->orWhere('type',4)->orWhere('type',1)->get()->toArray();
        $main_object = "";
        $build_list =[];
        $tech_list =[];
        $name_arr = [];
        foreach ($SysObject as $key => $value) {
            $name_arr[$value['type']][$value['name_type']] = $value['name'];
            if( $value['id'] == $id){
                $main_object = $value;
            }else if(($value['type']==0||$value['type']==1)&&$value['name_type']!=30){
                $build_list [] = $value;
            }else if($value['type']==4){
                $tech_list [] = $value;
            }
        }
        if($main_object){
            $SysObjectDetail = SysObjectDetail::where("object_id",$id)->orderBy('level','asc')->get(); 
                foreach ($SysObjectDetail as $key => &$value) {
                    $value['need_resource'] = json_decode($value['need_resource'],true);
                    $value['need_tech'] = json_decode($value['need_tech'],true);
                    $value['need_building'] = json_decode($value['need_building'],true);
                    $value['enhance'] = json_decode($value['enhance'],true);
                }

            return view('admin/object/editobject')
                        ->withObject($main_object)
                        ->withObjectDetail($SysObjectDetail)
                        ->withTechList($tech_list)
                        ->withNameArr($name_arr)
                        ->withPage("编辑".$main_object['name'])
                        ->withBuildList($build_list);
        }else{
            return "error";
        }
        
    }
    public function post_add(Request $request){
        $name=$request->get('name');
        $name_type=$request->get('name_type');
        $description=$request->get('description');
        $type=$request->get('type');
        $max_level=$request->get('max_level');
        $max_number = $request->get('max_number');
        $camp=$request->get('camp');
        $SysObject = SysObject::where('name_type',$name_type)->where('type',$type)->first();
        if(!$SysObject){
            $SysObject = new SysObject;
            $SysObject->name = $name;
            $SysObject->name_type = $name_type;
            $SysObject->description = $description;
            $SysObject->type = $type;
            $SysObject->max_number = $max_number;
            $SysObject->max_level = $max_level;
            $SysObject->camp = $camp;
            $SysObject->save();
            return view('admin/success')
                    ->withTitle("添加成功,点击返回上一页。")
                    ->withUrl(asset('/sysadmin/object/add'));
        }
     
    }
}
