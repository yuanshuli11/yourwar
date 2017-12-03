@extends('layouts.app')

@section('content')
@include('layouts.cityinfo')

<div class="home-content">
    <div class="part-body">
        <div v-for="(item,index) in  tech" >
            <div  v-show="buildingPage==Math.ceil((index+1)/8)" class="row" >
                <div class="col-xs-6">@{{item.name}}  @{{item.level!=0?('（'+item.level+'级'+'）'):''}}</div>
                <div  v-if="item.status==0" class="col-xs-2 col-xs-2 col-xs-offset-2"><a v-if="item.level&&item.level<10" v-on:click="buildUp(item)">建造</a></div>
                <div  v-if="item.status==1" class="col-xs-4" style="text-align: center;"><span class="showtime build" v-bind:data-end="item.building_end" v-if="item.status==1"></span></div>
                <div class="col-xs-2 item-a"> <a >拆除</a></div>
            </div>
            
        </div>     
      
        <div v-if="tech.length>8" class="row">
            <div class="col-xs-2 col-xs-offset-8"><a  v-show="buildingPage!='1'" v-on:click="buildingPageChange('sub')">上页</a></div>
            <div class="col-xs-2"><a  v-show="buildingPage!=buildingMax"  v-on:click="buildingPageChange('add')">下页</a></div>
        </div>
    </div>
    <div id="showbuild" class="modal fade bs-example-modal-sm showbuild" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div  v-if="focusTechInfo" class="modal-content">
                <div class="modal-header modal-sm">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel"> @{{ focusTechInfo.name }}（@{{ focusTechInfo.has_one_detail.level }}级）</h4>
                </div>
                <div class="modal-body">
                        <div class="show-description">@{{focusTechInfo.description}}</div>
                        <div v-if="focusTechInfo.has_one_detail.need_resource">
                            <div class="row">
                                需要资源：
                            </div>
                            <div v-for="(resource, name) in focusTechInfo.has_one_detail.need_resource">
                                <div  v-if="parseInt(resource)<=parseInt(userNowStatus['resouce'][name+'_num'])&&resource!='0'" class="row smile" > 
                                    <div class="col-xs-1 ">
                                        <i class="fa fa-smile-o "></i>
                                    </div>
                                    <div class="col-xs-3 ">
                                       @{{resourceName[name]}}
                                    </div>
                                    <div class="col-xs-5">@{{resource}}</div>
                                </div>
                                <div  v-if="parseInt(resource)>parseInt(userNowStatus['resouce'][name+'_num'])&&resource!='0'" class="row frown" > 
                                    <div class="col-xs-1 ">
                                        <i class="fa fa-frown-o "></i>
                                    
                                    </div>
                                    <div class="col-xs-3 ">
                                       @{{resourceName[name]}}
                                    </div>
                                    <div class="col-xs-5">@{{resource}}</div>
                                </div>
                            </div>                            
                        </div>
                        <div v-if="focusTechInfo.has_one_detail.need_building!='[]'&&focusTechInfo.has_one_detail.need_building.length">
                            <div class="row">
                                需要建筑：
                            </div>
                            <div v-for="building in focusTechInfo.has_one_detail.need_building">
                                <div v-if="1" class="row smile">
                                    <div class="col-xs-1">
                                        <i class="fa fa-smile-o"></i>
                                    </div>
                                    <div class="col-xs-4">
                                      @{{buildingName[building.name_type]}}
                                    </div>
                                    <div class="col-xs-3">@{{building.level?building.level+'级':''}}</div>
                                </div>
                                <div v-if="0" class="row frown">
                                    <div class="col-xs-1">
                                        <i class="fa fa-frown-o"></i>
                                    </div>
                                    <div class="col-xs-4">
                                      @{{buildingName[building.name_type]}}
                                    </div>
                                    <div class="col-xs-3">@{{building.level?building.level+'级':''}}</div>
                                </div>
                            </div>
                        </div>
                        <div v-if="focusTechInfo.has_one_detail.need_tech!='[]'&&focusTechInfo.has_one_detail.need_tech.length>0">
                            <div class="row">
                                需要科技：
                            </div>
                            <div v-for="tech in focusTechInfo.has_one_detail.need_tech">
                                <div v-if="1"  class="row smile">
                                    <div class="col-xs-1 ">
                                        <i class="fa fa-smile-o "></i>
                                    </div>
                                    <div class="col-xs-4 ">
                                       @{{techName[tech.name_type]}}
                                    </div>
                                    <div class="col-xs-3">@{{tech.level?tech.level+'级':''}}</div>
                                </div>
                                <div v-if="0"  class="row frown">
                                    <div class="col-xs-1 ">
                                        <i class="fa fa-frown-o "></i>
                                    </div>
                                    <div class="col-xs-4 ">
                                       @{{techName[tech.name_type]}}
                                    </div>
                                    <div class="col-xs-3">@{{tech.level?tech.level+'级':''}}</div>
                                </div>
                            </div>
                        </div>
                </div>
                <span class="show_cannot"  v-if="canBuild>0" >还有条件未达成哦~</span>
                <div class="modal-footer">                    
                    <button type="button" class="btn btn-sm btn-success" v-on:click="realBuild">建造</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    CAN_SUBMIT = true;
    TOKEN = $("meta[name=csrf-token]").attr("content");
    USER_ID = {{$userInfo['user_id']}};
    TIMEGAP =new Date('{{date("Y-m-d H:i:s")}}').getTime() - new Date().getTime();
    var app = new Vue({
        el: '.home-content',
        data: {  
            tech:{!! json_encode($tech) !!},
            buildingPage:1,
            canBuild:0,
            userNowStatus:{!!json_encode($userNowStatus)!!},
            buildingMax:{{ceil(count($tech)/8)}},
            resourceName:{!!json_encode(config('setting.resourceName'))!!},
            buildingName:{!!json_encode($buildingName)!!},
            techName:{!!json_encode($techName)!!},
            focusTechInfo:'',
            nowtech:''
        },
        methods: {
            buildingPageChange: function (type) {
                if(type=='sub'){
                    this.buildingPage--;
                    if(this.buildingPage<1){
                        this.buildingPage = 1;
                    }
                }else if(type=='add'){
                    this.buildingPage++;
                    if(this.buildingPage>this.buildingMax){
                        this.buildingPage = this.buildingMax;
                    }
                }
            },
            all_time_change:function(){
                var timeint = 0;
                var _this =this;
                $(".showtime").each(function(index){

                var timeint =new Date($(this).attr("data-end")).getTime() - (new Date().getTime()+TIMEGAP);
                timeint =parseInt(timeint/1000);
                if(timeint<0){
                    $(this).html("<a  href='javascript:reflsehPart()'>完成</a>");
                }else{
                    timeint = _this.timeTostr(timeint);
                    $(this).html(timeint);
                }
                });
            },
            timeTostr:function(timeint){
                var h = parseInt(timeint/3600);
                var m = parseInt(timeint%3600/60);
                var s = parseInt(timeint%3600%60);
                if(h.length<10){
                    h = '0'+h;
                }
            
                if(m<10){
                    m = '0'+m;
                }
                if(s<10){
                    s = '0'+s;
                }
                return h+':'+m+':'+s;
            },
            realBuild:function(){
                this.canBuild = $(".row.frown").length;
                if(this.canBuild==0&&CAN_SUBMIT){
                   
                    var  type='tech';
                    var  token =$("meta[name=csrf-token]").attr("content");
                    var  user_id = {{$userInfo['user_id']}};
                    var  name = this.focusTechInfo.name;
                    var  name_type = this.focusTechInfo.name_type
                    var  tech_id = this.nowtech.id;
                    var  data = {                               
                                user_id : user_id,
                                tech_id : tech_id,                    
                                token : token
                        };
                    $.ajax({
                        url:"{{ asset('/api/build/v1/techBuild') }}",
                        method:"POST",
                        data:data,
                        success:function(result){
                            CAN_SUBMIT = true;
                            if(result.status==0){
                               swal({
                                  title: result.values.building_name+result.values.building_level+"建造成功",
                                  text: "完成时间："+result.values.building_end, 
                                  type: "success",
                                  confirmButtonText: "确定", 
                                  closeOnConfirm: false
                                },
                                function(){
                                    location.reload();
                                });
                                
                             
                            }else{
                                swal(result.message,"","error")
                            }
                        }
                    });
                }
                    
            },
            buildUp:function(tech){
                var _this = this;
                var tech_id = tech.id;
                var  token =$("meta[name=csrf-token]").attr("content");
                var  user_id = {{$userInfo['user_id']}};
                this.nowtech = tech;
                var  data = {
                        user_id : user_id,                                                  
                        tech_id:tech_id,
                        token : token
                    };                
                if(CAN_SUBMIT){
                    CAN_SUBMIT = false;
                    $.ajax({
                        url:"{{ asset('/api/build/v1/getTechUpInfo') }}",
                        method:"POST",
                        data:data,
                        success:function(result){
                            CAN_SUBMIT = true;
                            if(result.status==0){
                                _this.focusTechInfo = result.values;                                
                               $("#showbuild").modal("show");
                            }else{
                                swal(result.message,"","error")
                            }
                        }
                    });
                }
            }
        }


    });
    app.all_time_change();
    setInterval('app.all_time_change()', 1000);
</script>
@endsection