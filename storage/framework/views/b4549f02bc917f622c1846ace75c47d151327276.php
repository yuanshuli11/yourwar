
<?php $__env->startSection('content'); ?>

<div class="show-pagename"><h2><?php echo e($page); ?></h2></div>
<div class="show-add">
    <table class="table table-hover"  style="text-align: center;" >
        <thead>
            <tr>
                <td>名称</td>
                <td>等级</td>
                <td width="200px">所需资源</td>
                <td>所需建筑</td>
                <td>所需科技</td>
                <td>能力提升</td>
                <td>耗时(s)</td> 
            </tr>
        </thead>
        <tbody>
                
            <tr v-for="detai in objectDetail" v-on:click="change(detai)">
                <td>{{object.name}}</td>
                <td>{{detai.level}}</td>
                <td>
                   
                    <span v-for="(resource,name) in detai.need_resource" class="show-resource">{{resourceName[name]}}:{{resource}}</span>
                   
                </td>
                <td>
                    
                    <div v-for="(building,name) in detai.need_building" class="show-building">{{ nameArr[0][building.name_type]}}:{{building.level}}</div>
                    
                </td>
                <td>
                     <div v-for="(tech,name) in detai.need_tech" class="show-tech">{{ nameArr[4][tech.name_type]}}:{{tech.level}}</div>
                  
                </td>
                 <td>
                     <div v-for="(enhance,name) in detai.enhance" class="show-tech">{{ ability[name]}}:{{enhance}}</div>
                  
                </td>
                <td>{{detai.need_time}}</td>
       
            </tr>            
        
        </tbody>
    </table>
    <form class="form-horizontal" method="POST" action="<?php echo e(asset('/sysadmin/object/addDetail/'.$object['id'])); ?>">
        <?php echo e(csrf_field()); ?>

        <div class="form-group">
            <label  class="col-xs-1 control-label">名称</label>
            <div class="col-xs-2">
              <input  class="form-control" value="<?php echo e($object['name']); ?>" readonly="readonly" placeholder="名称">
            </div>
            <label  class="col-xs-1 control-label">等级</label>
            <div class="col-xs-2">
              <select class="form-control"  name="level">
                <option value="0">无等级</option>
                <option value="1">1级</option>
                <option value="2">2级</option>
                <option value="3">3级</option>
                <option value="4">4级</option>
                <option value="5">5级</option>
                <option value="6">6级</option>
                <option value="7">7级</option>
                <option value="8">8级</option>
                <option value="9">9级</option>
                <option value="10">10级</option>
              </select>
            </div>
        </div>
        <div class="form-group">
            <span class="label label-primary">所需资源</span>
        </div>
        <div class="form-group">
            <label  class="col-xs-1 control-label">黄金</label>
            <div class="col-xs-2">
              <input  type="number" id="goldnum" name="resource[gold]" min="0" class="form-control"  value="0" placeholder="黄金">
            </div>
            <label  class="col-xs-1 control-label">粮食</label>
            <div class="col-xs-2">
              <input  type="number" id="foodnum"  name="resource[food]"  min="0" class="form-control"  value="0" placeholder="粮食">
            </div>
            <label  class="col-xs-1 control-label">钢铁</label>
            <div class="col-xs-2">
              <input  type="number" id="steelnum"  name="resource[steel]" min="0" class="form-control"  value="0" placeholder="钢铁">
            </div>
        </div>
        <div class="form-group"> 
            <label  class="col-xs-1 control-label">石油</label>
            <div class="col-xs-2">
              <input  type="number" id="oilnum"  name="resource[oil]" min="0" class="form-control"  value="0" placeholder="石油">
            </div>
            <label  class="col-xs-1 control-label">稀矿</label>
            <div class="col-xs-2">
              <input  type="number"  id="rarenum" name="resource[rare]" min="0" class="form-control"  value="0" placeholder="稀矿">
            </div>
            <label  class="col-xs-1 control-label">人口</label>
            <div class="col-xs-2">
              <input  type="number"  id="peoplenum"  name="resource[people]" min="0" class="form-control"  value="0" placeholder="人口">
            </div>
        </div>
        <div class="form-group">
            <span class="label label-primary">建筑等级</span>
        </div>
        <div class="form-group">
            <label  class="col-xs-1 control-label">需求1</label>
            <div class="col-xs-2">
                <select class="form-control"  name="need_building1">
                    <option value="0">无</option>
                    <?php $__currentLoopData = $buildList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item['name_type']); ?>"><?php echo e($item['name']); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-xs-2">
                <select class="form-control"  name="need_building1_level">
                    <option value="0">无等级</option>
                    <option value="1">1级</option>
                    <option value="2">2级</option>
                    <option value="3">3级</option>
                    <option value="4">4级</option>
                    <option value="5">5级</option>
                    <option value="6">6级</option>
                    <option value="7">7级</option>
                    <option value="8">8级</option>
                    <option value="9">9级</option>
                    <option value="10">10级</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label  class="col-xs-1 control-label">需求2</label>
            <div class="col-xs-2">
                <select class="form-control"  name="need_building2">
                    <option value="0">无</option>
                    <?php $__currentLoopData = $buildList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item['name_type']); ?>"><?php echo e($item['name']); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-xs-2">
                <select class="form-control"  name="need_building2_level">
                    <option value="0">无等级</option>
                    <option value="1">1级</option>
                    <option value="2">2级</option>
                    <option value="3">3级</option>
                    <option value="4">4级</option>
                    <option value="5">5级</option>
                    <option value="6">6级</option>
                    <option value="7">7级</option>
                    <option value="8">8级</option>
                    <option value="9">9级</option>
                    <option value="10">10级</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <span class="label label-primary">科技等级</span>
        </div>
        <div class="form-group">
            <label  class="col-xs-1 control-label">需求1</label>
            <div class="col-xs-2">
                <select class="form-control"  name="need_tech1">
                    <option value="0">无</option>
                    <?php $__currentLoopData = $techList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item['name_type']); ?>"><?php echo e($item['name']); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-xs-2">
                <select class="form-control"  name="need_tech1_level">
                    <option value="1">1级</option>
                    <option value="2">2级</option>
                    <option value="3">3级</option>
                    <option value="4">4级</option>
                    <option value="5">5级</option>
                    <option value="6">6级</option>
                    <option value="7">7级</option>
                    <option value="8">8级</option>
                    <option value="9">9级</option>
                    <option value="10">10级</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label  class="col-xs-1 control-label">需求2</label>
            <div class="col-xs-2">
                <select class="form-control"  name="need_tech2">
                    <option value="0">无</option>
                    <?php $__currentLoopData = $techList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item['name_type']); ?>"><?php echo e($item['name']); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-xs-2">
                <select class="form-control"  name="need_tech2_level">
                    <option value="1">1级</option>
                    <option value="2">2级</option>
                    <option value="3">3级</option>
                    <option value="4">4级</option>
                    <option value="5">5级</option>
                    <option value="6">6级</option>
                    <option value="7">7级</option>
                    <option value="8">8级</option>
                    <option value="9">9级</option>
                    <option value="10">10级</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <span class="label label-primary">能力提升</span>
        </div>
        <div class="form-group">
            <label  class="col-xs-1 control-label">资源</label>
            <div class="col-xs-2">
                <select class="form-control"  name="resource_ability">
                    <option value="0">无</option>
                    <?php $__currentLoopData = config('ability.resource'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>"><?php echo e($item); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-xs-2">
                <input  type="number"  name="resource_ability_value" min="0" class="form-control inputNum"   placeholder="每小时">
            </div>
        </div>
     
        <div class="form-group">
            <span class="label label-primary">其他</span>
        </div>
        <div class="form-group"> 
            <label  class="col-xs-1 control-label">耗时</label>
            <div class="col-xs-1">
              <input  type="number"  name="need_time" min="0" class="form-control inputNum"   placeholder="秒数">
            </div>
            <label  class="col-xs-1 control-label">秒</label>
        </div>
        <input  type="number" style="display: none" v-bind:value="object.type" name="type">
        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-4">
              <button type="submit" class="btn btn-default">添加</button>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
        var app = new Vue({
            el: '.show-add',
            data: {   
                objectDetail:<?php echo json_encode($objectDetail); ?>,
                resourceName:<?php echo json_encode(config('setting.resourceName')); ?>,
                object:<?php echo json_encode($object); ?>,
                ability:<?php echo json_encode(config('ability.resource')); ?>,
                nameArr:<?php echo json_encode($nameArr); ?>

            },
            methods: {
                change:function(detail){
                    this.resetValue();
                    $("select[name=level]").val(detail.level);
                    $("#goldnum").val(detail.need_resource.gold);
                    $("#foodnum").val(detail.need_resource.food);
                    $("#steelnum").val(detail.need_resource.steel);
                    $("#oilnum").val(detail.need_resource.oil);
                    $("#rarenum").val(detail.need_resource.rare);
                    $("#peoplenum").val(detail.need_resource.people);
                    for(var i = 0;i<detail.need_building.length;i++){
                        $("select[name=need_building"+(i+1)+"]").val(detail.need_building[i].name_type);
                        $("select[name=need_building"+(i+1)+"_level]").val(detail.need_building[i].level);
                    }
                    for(var i = 0;i<detail.need_tech.length;i++){
                        $("select[name=need_tech"+(i+1)+"]").val(detail.need_tech[i].name_type);
                        $("select[name=need_tech"+(i+1)+"_level]").val(detail.need_tech[i].level);
                    }
                    Object.keys(detail.enhance).forEach(function(item,index){
                        $("select[name=resource_ability]").val(item);
                        $("input[name=resource_ability_value]").val(detail.enhance[item]);
                        
                    })
                    
                    $("input[name=need_time]").val(detail.need_time);
                },
                resetValue(){
                     $("select[name=level]").val(0);
                    $("#goldnum").val(0);
                    $("#foodnum").val(0);
                    $("#steelnum").val(0);
                    $("#oilnum").val(0);
                    $("#rarenum").val(0);
                    $("#peoplenum").val(0);                    
                    for(var i = 0;i<2;i++){
                        $("select[name=need_building"+(i+1)+"]").val(0);
                        $("select[name=need_building"+(i+1)+"_level]").val(1);
                    }
                    for(var i = 0;i<2;i++){
                        $("select[name=need_tech"+(i+1)+"]").val(0);
                        $("select[name=need_tech"+(i+1)+"_level]").val(1);
                    }
                    $("select[name=resource_ability]").val(0);
                    $("input[name=resource_ability_value]").val("");
                    $("input[name=need_time]").val(0);
                }

            }
        });



</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>