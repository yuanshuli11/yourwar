

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.cityinfo', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div class="home-content">
    <div class="part-body">
        <div class="map_input"> 
        移动至 x:<input id="city_lng" placeholder="x" value="<?php echo e($userInfo['has_one_main_city']['lng']); ?>">y:<input id="city_lat" value="<?php echo e($userInfo['has_one_main_city']['lat']); ?>" placeholder="y">
        <button class="btn btn-info btn-sm" onclick="skipto()">移动</button>
        </div>
        <div class="row">
            <?php $__currentLoopData = $map['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div  class="col-xs-6" >
                    <div ><a><?php echo e($item['city']); ?>(<?php echo e($item['lng'].','.$item['lat']); ?>)<?php if(!$item['user_id']): ?> <?php echo e($item['level']); ?>级 <?php endif; ?></a></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="show-page-btn">           
            <a class="btn btn-info btn-sm" href="<?php echo e(asset('/part/map?lng='.$pageBtn['left']['lng'].'&lat='.$pageBtn['left']['lat'])); ?>">左移</a>
            <a class="btn btn-info btn-sm" href="<?php echo e(asset('/part/map?lng='.$pageBtn['right']['lng'].'&lat='.$pageBtn['right']['lat'])); ?>">右移</a>
            <a class="btn btn-info btn-sm" href="<?php echo e(asset('/part/map?lng='.$pageBtn['up']['lng'].'&lat='.$pageBtn['up']['lat'])); ?>">上移</a>
            <a class="btn btn-info btn-sm" href="<?php echo e(asset('/part/map?lng='.$pageBtn['down']['lng'].'&lat='.$pageBtn['down']['lat'])); ?>">下移</a>
       </div>
    </div>

</div>
<script type="text/javascript">
   function skipto(){
    var lng = $("#city_lng").val();
    var lat = $("#city_lat").val();
    url = '<?php echo e(asset('/part/map')); ?>'+'?lat='+lat+'&lng='+lng;
    window.location.href=url;       
   }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>