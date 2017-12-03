<?php $__env->startSection('content'); ?>
<div id="home-css" class="home-css">
   <?php echo $__env->make('layouts.cityinfo', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="home-type">  
        <button class="btn btn-success" v-on:click="block='resouse'">资源</button>
        <button class="btn btn-info" v-on:click="block='officer'" name="Officer">军官</button>
        <button class="btn btn-danger" v-on:click="block='army'" name="army">军队</button>
        <button class="btn btn-primary" v-on:click="block='defense'" name="defense">城防</button>
        <button class="btn btn-warning" v-on:click="block='commander'" name="commander">统帅</button>
    </div>
    <div  v-show="block=='resouse'" class="home-content resouse" >
        <div class="row">
            <div class="col-xs-2 homeleft">市长：</div>
            <div class="col-xs-9">
                <span>----</span>
            </div>
          
             <div class="row">
                <div class="col-xs-2 homeleft">黄金：</div>        
                <div class="col-xs-3">
                    <?php echo e(changeUnit($userInfo['has_one_city_resource']['gold_num'])); ?>           </div>
                <div class="col-xs-3">
                    (<?php echo e(calSpeed($userInfo['has_one_city_resource']['gold_change'])); ?> )
                </div>
            </div>
            <div class="row">
                <div class="col-xs-2 homeleft">粮食：</div>        
                <div class="col-xs-3">
                    <?php echo e(changeUnit($userInfo['has_one_city_resource']['food_num'])); ?>           </div>
                <div class="col-xs-3">
                    (<?php echo e(calSpeed($userInfo['has_one_city_resource']['food_change'])); ?> )
                </div>
            </div>
            <div class="row">
                <div class="col-xs-2 homeleft">钢铁：</div> 
                <div class="col-xs-3">
                    <?php echo e(changeUnit($userInfo['has_one_city_resource']['steel_num'])); ?>           </div>
                <div class="col-xs-3">
                    (<?php echo e(calSpeed($userInfo['has_one_city_resource']['steel_change'])); ?> )
                </div>     
            </div>
            <div class="row">
                <div class="col-xs-2 homeleft">石油：</div>
                <div class="col-xs-3">
                    <?php echo e(changeUnit($userInfo['has_one_city_resource']['oil_num'])); ?>           </div>
                <div class="col-xs-3">
                    (<?php echo e(calSpeed($userInfo['has_one_city_resource']['oil_change'])); ?> )
                </div>         
            </div>          
            <div class="row">
                <div class="col-xs-2 homeleft">稀矿：</div>
                <div class="col-xs-3">
                    <?php echo e(changeUnit($userInfo['has_one_city_resource']['rare_num'])); ?>           </div>
                <div class="col-xs-3">
                    (<?php echo e(calSpeed($userInfo['has_one_city_resource']['rare_change'])); ?> )
                </div>          
            </div>  
            <div class="row">           
            <div class="col-xs-2 homeleft">税率：</div>
            <div class="col-xs-3">
                <span><?php echo e($userInfo['has_one_main_city']['tax']); ?>%</span>                
            </div>
            <div class="col-xs-3">          
                <span class="build">修改</span>
            </div>
            </div>  
            <div class="row">
            <div class="col-xs-2 homeleft">民心：</div>
            <div class="col-xs-3">
                <span><?php echo e($userInfo['has_one_main_city']['people_love']); ?>/100</span>
            </div>
            </div>  
            <div class="row">   
            <div class="col-xs-2 homeleft">民怨：</div>
            <div class="col-xs-3">
                <span><?php echo e($userInfo['has_one_main_city']['people_hate']); ?></span>          
            </div>
            <div class="col-xs-3">              
                <span class="build">安抚</span>
            </div>
                <div class="col-xs-2">              
                <span class="build ">慈善</span>
            </div>
            </div>  
            <div class="row">   
            <div class="col-xs-2 homeleft">人口：</div>
            <div class="col-xs-3">
                <span><?php echo e(changeUnit($userInfo['has_one_city_resource']['people_num'])); ?>/<?php echo e(changeUnit($userInfo['has_one_city_resource']['busy_people'])); ?></span> 
                
            </div>
            <div class="col-xs-3">
                <span class="build">召集</span>
            </div>
            </div>
        </div>
    </div>
    <div  v-show="block=='officer'" class="home-content officer" style="display: none;">
        <div class="row">
            <div class="col-xs-12 officer-content">
                <div>
                    <div class="col-xs-10">
                        <span class="city-officer">市长：
                    ----                    
                        </span>
                    </div>
                    <div class="col-xs-2">
                        <span class="officer-status"><a>卸任</a></span>
                    </div>
                </div>
                <div>军官列表：</div>
                <div class="officer-list">
                    <?php $__currentLoopData = $userInfo['has_many_officers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div   v-show="officerPage=='<?php echo e(ceil(($key+1)/6)); ?>'" class="row show-officer-item">
                            <div class="col-xs-8"><span class="officers-name"><?php echo e($item['name']); ?></span><span  class="officers-power">(<?php echo e($item['force']); ?>,<?php echo e($item['service']); ?>,<?php echo e($item['knowledge']); ?>,<?php echo e($item['level']); ?>)</span></div>
                            <div class="col-xs-2">
                                <a>查看</a>                     
                            </div>
                            <div class="col-xs-2">
                                <a>派遣</a>                     
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if(count($userInfo['has_many_officers'])>7): ?>
                        <div class="row">
                            <div class="col-xs-2 col-xs-offset-8"><a  v-show="officerPage!='1'" v-on:click="officerPageChange('sub')">上页</a></div>
                            <div class="col-xs-2"><a  v-show="officerPage!=officerMax"  v-on:click="officerPageChange('add')">下页</a></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div  v-show="block=='army'" class="home-content army"  style="display: none;">
        <div class="row army-content">
            <div class="row">
                <div class="col-xs-4">
                    <span class="weaponName">军种</span>
                </div>
                <div class="col-xs-4">
                    <span class="weaponName">数量</span>
                </div>
                <div class="col-xs-4">
                    <span class="OfficerStatus">状态</span>
                </div>
            </div>      
            <div class="showArmy armyPage">
                <div class="row armys" data-value="0">
                    <div class="col-xs-4">
                        <span class="weaponName">步兵</span>
                    </div>
                    <div class="col-xs-4">
                        <span class="weaponName">0/0</span>
                    </div>
                    <div class="col-xs-4">
                        <span class="OfficerStatus"><a>查看</a></span>
                    </div>
                </div>                                  
            </div>          
        </div>
    </div>
    <div  v-show="block=='defense'" class="home-content defense" style="display: none;">
        <div class="row army-content">
            <div class="row">
                <div class="col-xs-4">
                    <span class="defenseName">军种</span>
                </div>
                <div class="col-xs-4">
                    <span class="defenseName">数量</span>
                </div>
                <div class="col-xs-4">
                    <span class="defenseStatus">状态</span>
                </div>
            </div>
            <div class="showArmy">
                <div class="row armys" data-value="0">
                    <div class="col-xs-4">
                        <span class="weaponName">围墙</span>
                    </div>
                    <div class="col-xs-4">
                        <span class="weaponName">0/0</span>
                    </div>
                    <div class="col-xs-4">
                        <span class="OfficerStatus">
                         <a>查看</a>                                
                        </span>
                    </div>
                </div>       
            </div>          
        </div>
    </div>
    <div  v-show="block=='commander'" class="home-content commander" style="display: none;">
        <div class="row">
            <div class="col-xs-2 homeleft">统帅：</div>
            <div class="col-xs-4">
                <span><?php echo e($userInfo['user_name']); ?></span>
            </div>
            <div class="col-xs-4">
                <a class="commanderbuild">修改</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2 homeleft">番号：</div>
            <div class="col-xs-4">
                <span><?php echo e($userInfo['user_flag']); ?></span>
            </div>
            <div class="col-xs-4">
                <a class="commanderbuild">修改</a>
            </div>
        </div>
            <div class="row">
            <div class="col-xs-2 homeleft">荣耀：</div>
            <div class="col-xs-4">
                <span><?php echo e($userInfo['honor']); ?></span>
            </div>
            <div class="col-xs-4">
                <a class="commanderbuild">详情</a>
            </div>
        </div>
            <div class="row">
            <div class="col-xs-2 homeleft">排名：</div>
            <div class="col-xs-4">
                <span>暂无排名</span>
            </div>
            <div class="col-xs-4">
                <a class="commanderbuild">详情</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2 homeleft">军衔：</div>
            <div class="col-xs-4">
                <span></span>
            </div>
            <div class="col-xs-4">
                <a class="commanderbuild">升级</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2 homeleft">职位：</div>
            <div class="col-xs-4">
                <span></span>
            </div>
            <div class="col-xs-4">
                <a class="commanderbuild">升级</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2 homeleft">军团：</div>
            <div class="col-xs-4">
                <span></span>
            </div>
            <div class="col-xs-4">
                <a class="commanderbuild">详情</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2 homeleft">城市：</div>
            <div class="col-xs-4">
                <span>1座</span>
            </div>
            <div class="col-xs-4">
                <a class="commanderbuild">列表</a>
            </div>
        </div>
    
        <div class="row">
            <div class="col-xs-2 homeleft">元宝：</div>
            <div class="col-xs-4">
                <span>0</span>
            </div>
            <div class="col-xs-4">
                <a class="commanderbuild">充值</a>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    var app = new Vue({
        el: '#home-css',
        data: {
            block: 'resouse',
            officerPage:1,
            officerMax:<?php echo e(ceil(count($userInfo['has_many_officers'])/6)); ?>

        },
        methods: {
            officerPageChange: function (type) {
                if(type=='sub'){
                    this.officerPage--;
                    if(this.officerPage<1){
                        this.officerPage = 1;
                    }
                }else if(type=='add'){
                    this.officerPage++;
                    if(this.officerPage>this.officerMax){
                        this.officerPage = this.officerMax;
                    }
                }
            }
        }

    })
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>