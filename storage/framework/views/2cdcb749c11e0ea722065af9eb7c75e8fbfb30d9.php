

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.cityinfo', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div class="home-content">
    <div class="part-body">
        <div v-for="(build,index) in building"  v-show="buildingPage==Math.ceil((index+1)/8)"  class="row show-building-item" style="display: none;">
            <div class="col-xs-5">{{build.name}} {{build.level?'('+build.level+'级)':''}}</div>
            <div class="col-xs-2 item-a">  <a v-if="build.name_type!=30">进入</a>   <a v-if="build.name_type==30"   v-on:click="buildUp(build.id)">建造</a></div>
            <div class="col-xs-3 item-a"> <a v-if="build.level&&build.level<10&&build.status==0"  v-on:click="upLevel(build.id)">升级</a><span class="showtime build" v-bind:data-end="build.building_end" v-if="build.status==1"></span></div>
            <div class="col-xs-2 item-a"> <a v-if="build.name_type!=30">拆除</a></div>
        </div>
        <div v-if="building.length>8" class="row">
            <div class="col-xs-2 col-xs-offset-8"><a  v-show="buildingPage!='1'" v-on:click="buildingPageChange('sub')">上页</a></div>
            <div class="col-xs-2"><a  v-show="buildingPage!=buildingMax"  v-on:click="buildingPageChange('add')">下页</a></div>
        </div>
    </div>
    <div id="showbuild" class="modal fade bs-example-modal-sm showbuild" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div  v:if="nowBuildingInfo" class="modal-content">
                <div class="modal-header modal-sm">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel"> {{ nowBuildingInfo.name }} {{nowBuildingInfo.level?'('+nowBuildingInfo.level+'级)':''}}</h4>
                </div>
                <div class="modal-body">
                        <div class="show-description">{{nowBuildingInfo.description}}</div>
                        <div v:if="nowBuildingInfo.resource">
                            <div class="row">
                                需要资源：
                            </div>
                            <div v-for="(resource, name) in nowBuildingInfo.resource">
                                <div  v-if="parseInt(resource)<=parseInt(userNowStatus['resouce'][name+'_num'])&&resource!='0'" class="row smile" > 
                                    <div class="col-xs-1 ">
                                        <i class="fa fa-smile-o "></i>
                                    </div>
                                    <div class="col-xs-3 ">
                                       {{resourceName[name]}}
                                    </div>
                                    <div class="col-xs-5">{{resource}}</div>
                                </div>
                                <div  v-if="parseInt(resource)>parseInt(userNowStatus['resouce'][name+'_num'])&&resource!='0'" class="row frown" > 
                                    <div class="col-xs-1 ">
                                        <i class="fa fa-frown-o "></i>
                                    
                                    </div>
                                    <div class="col-xs-3 ">
                                       {{resourceName[name]}}
                                    </div>
                                    <div class="col-xs-5">{{resource}}</div>
                                </div>
                            </div>                            
                        </div>
                        <div v-if="nowBuildingInfo.building!='[]'">
                            <div class="row">
                                需要建筑：
                            </div>
                            <div v-for="building in nowBuildingInfo.building">
                                <div v-if="1" class="row smile">
                                    <div class="col-xs-1">
                                        <i class="fa fa-smile-o"></i>
                                    </div>
                                    <div class="col-xs-4">
                                      {{buildingName[building.name_type]}}
                                    </div>
                                    <div class="col-xs-3">{{building.level?building.level+'级':''}}</div>
                                </div>
                                <div v-if="0" class="row frown">
                                    <div class="col-xs-1">
                                        <i class="fa fa-frown-o"></i>
                                    </div>
                                    <div class="col-xs-4">
                                      {{buildingName[building.name_type]}}
                                    </div>
                                    <div class="col-xs-3">{{building.level?building.level+'级':''}}</div>
                                </div>
                            </div>
                        </div>
                        <div v-if="nowBuildingInfo.tech!='[]'">
                            <div class="row">
                                需要科技：
                            </div>
                            <div v-for="tech in nowBuildingInfo.tech">
                                <div v-if="1"  class="row smile">
                                    <div class="col-xs-1 ">
                                        <i class="fa fa-smile-o "></i>
                                    </div>
                                    <div class="col-xs-4 ">
                                       {{techName[tech.name_type]}}
                                    </div>
                                    <div class="col-xs-3">{{tech.level?tech.level+'级':''}}</div>
                                </div>
                                <div v-if="0"  class="row frown">
                                    <div class="col-xs-1 ">
                                        <i class="fa fa-frown-o "></i>
                                    </div>
                                    <div class="col-xs-4 ">
                                       {{techName[tech.name_type]}}
                                    </div>
                                    <div class="col-xs-3">{{tech.level?tech.level+'级':''}}</div>
                                </div>
                            </div>
                        </div>
                </div>
                <span class="show_cannot"  v-if="canBuild>0" >还有条件未达成哦~</span>
                <div class="modal-footer">
                    <span v-if="nowBuildPage>0&&buildType=='build'" v-on:click="buildPageChange('sub')"  class="btn btn-sm btn-info"  >上页</span>
                    <span v-if="nowBuildPage<maxBuildPage&&buildType=='build'" v-on:click="buildPageChange('add')"  class="btn btn-sm btn-info" >下页</span>
                    <button type="button" class="btn btn-sm btn-success" v-on:click="realBuild">建造</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    CAN_SUBMIT = true;
    TOKEN = $("meta[name=csrf-token]").attr("content");
    USER_ID = <?php echo e($userInfo['user_id']); ?>;
    TIMEGAP =new Date('<?php echo e(date("Y-m-d H:i:s")); ?>').getTime() - new Date().getTime();
    var app = new Vue({
        el: '.home-content',
        data: {       
            buildingPage:1,
            building:<?php echo json_encode($building); ?>,
            buildingMax:<?php echo e(ceil(count($building)/8)); ?>,
            canBuildigInfo:<?php echo json_encode($canBuild); ?>,
            userNowStatus:<?php echo json_encode($userNowStatus); ?>,
            nowBuildPage:0,
            maxBuildPage:<?php echo e(count($canBuild)-1); ?>,
            buildingName:<?php echo json_encode($buildingName); ?>,
            techName:<?php echo json_encode($techName); ?>,
            resourceName:<?php echo json_encode(config('setting.resourceName')); ?>,
            nowBuildingInfo:'',
            canBuild:0,
            areaId:'',
            next_level:'',
            buildType:'up'
        },
        methods: {
          
            upLevel:function(area_id){
                var _this = this;
                var type='army';
                var token = TOKEN;
                this.buildType = 'up';
                var  user_id = USER_ID;
                this.areaId = area_id;
                var  data = {                            
                            user_id : user_id,
                            area_id : area_id,                      
                            token : token
                    };
                $.ajax({
                    url:"<?php echo e(asset('/api/build/v1/getBuildUpInfo')); ?>",
                    method:"POST",
                    data:data,
                    success:function(result){
                        _this.nowBuildingInfo = result.values;
                        _this.next_level = result.values.level+'级';
                         
                        $("#showbuild").modal("show");
                        //$("#showbuild").modal("hide");
                    }
                });
               
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
                if(this.canBuild==0&&this.areaId>0){
                    var  type='army';
                    var  name_type = this.nowBuildingInfo.name_type;
                    var  token =$("meta[name=csrf-token]").attr("content");
                    var  user_id = <?php echo e($userInfo['user_id']); ?>;
                    var  area_id = this.areaId;
                    var  name = this.nowBuildingInfo.name;
                    var  build_id = this.nowBuildingInfo.building_id?this.nowBuildingInfo.building_id:this.nowBuildingInfo.has_one_begin.id;
                    var  data = {
                                type : type,
                                name_type : name_type,
                                user_id : user_id,
                                build_id : build_id,
                                area_id :area_id,
                                token : token
                        };
                    if(CAN_SUBMIT){
                        CAN_SUBMIT = false;
                        $.ajax({
                            url:"<?php echo e(asset('/api/build/v1/building')); ?>",
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
                                $("#showbuild").modal("hide");
                            
                            }
                        });
                    }
                    
                }
            },
            buildUp:function(id){
                this.buildType = 'build';
                this.areaId = id;
                this.canBuild = 0;
                $('#showbuild').modal('show');
                this.nowBuildingInfo = this.canBuildigInfo[this.nowBuildPage];
                this.next_level = this.nowBuildingInfo.level+'级';
                console.log(this.nowBuildingInfo);
            },
            buildPageChange:function(type){
                this.canBuild = 0;
                if(type=='sub'){
                    this.nowBuildPage--;
                    if(this.nowBuildPage<0){
                       this.nowBuildPage =0; 
                    }
                }else if(type=='add'){
                    this.nowBuildPage++;
                    if(this.nowBuildPage>this.maxBuildPage){
                       this.nowBuildPage = this.maxBuildPage; 
                    }
                }
                this.nowBuildingInfo = this.canBuildigInfo[this.nowBuildPage];
            },
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
            }
        }

    });



app.all_time_change();
setInterval('app.all_time_change()', 1000);
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>