
<?php $__env->startSection('content'); ?>

<div class="show-pagename"><h2><?php echo e($page); ?></h2></div>
<div class="show-add">
    <form class="form-horizontal" method="POST" action="<?php echo e(asset('/sysadmin/add')); ?>">
        <?php echo e(csrf_field()); ?>

        <div class="form-group">
            <label  class="col-xs-4 control-label">名称</label>
            <div class="col-xs-8">
              <input  class="form-control" value="<?php echo e($object['name']); ?>" readonly="readonly" placeholder="名称">
            </div>
        </div>
        <div class="form-group">
            <label  class="col-xs-4 control-label">等级</label>
            <div class="col-xs-8">
              <select class="form-control"  name="type">
                <option value="0">无等级</option>
                <option value="1">1级</option>
                <option value="1">2级</option>
                <option value="1">3级</option>
                <option value="1">4级</option>
                <option value="1">5级</option>
                <option value="1">6级</option>
                <option value="1">7级</option>
                <option value="1">8级</option>
                <option value="1">9级</option>
                <option value="1">10级</option>
              </select>
            </div>
        </div>
        <div class="form-group">
            <label  class="col-xs-4 control-label">黄金</label>
            <div class="col-xs-8">
              <input  type="number" min="0" class="form-control"  value="<?php echo e($object['name']); ?>" placeholder="黄金">
            </div>
        </div>
        <div class="form-group">
            <label  class="col-xs-4 control-label">粮食</label>
            <div class="col-xs-8">
              <input  type="number" min="0" class="form-control"  value="<?php echo e($object['name']); ?>" placeholder="粮食">
            </div>
        </div>
        <div class="form-group">
            <label  class="col-xs-4 control-label">钢铁</label>
            <div class="col-xs-8">
              <input  type="number" min="0" class="form-control"  value="<?php echo e($object['name']); ?>" placeholder="钢铁">
            </div>
        </div>
        <div class="form-group">
            <label  class="col-xs-4 control-label">石油</label>
            <div class="col-xs-8">
              <input  type="number" min="0" class="form-control"  value="<?php echo e($object['name']); ?>" placeholder="石油">
            </div>
        </div>
        <div class="form-group">
            <label  class="col-xs-4 control-label">稀矿</label>
            <div class="col-xs-8">
              <input  type="number" min="0" class="form-control"  value="<?php echo e($object['name']); ?>" placeholder="稀矿">
            </div>
        </div>
        <div class="form-group">
            <label  class="col-xs-4 control-label">人口</label>
            <div class="col-xs-8">
              <input  type="number" min="0" class="form-control"  value="<?php echo e($object['name']); ?>" placeholder="人口">
            </div>
        </div>
    </form>
    
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>