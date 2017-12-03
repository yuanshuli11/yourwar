
<?php $__env->startSection('content'); ?>


<div class="show-add">

<form class="form-horizontal" method="POST" action="<?php echo e(asset('/sysadmin/add')); ?>">
  <?php echo e(csrf_field()); ?>

  <div class="form-group">
    <label  class="col-xs-4 control-label">名称</label>
        <div class="col-xs-8">
          <input  class="form-control" name="name" required="required" placeholder="名称">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-xs-4 control-label">数组标记</label>
        <div class="col-xs-8">
          <input  class="form-control" name="name_type"  required="required"  placeholder="不重复，且有理标记">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-xs-4 control-label">描述</label>
        <div class="col-xs-8">
          <textarea class="form-control"  rows="3"  required="required"  name="description" placeholder="描述"></textarea>  
        </div>
    </div>
    <div class="form-group">
        <label  class="col-xs-4 control-label">类型</label>
        <div class="col-xs-8">
          <select class="form-control"  required="required"  name="type">
            <option value="0">军事建筑</option>
            <option value="1">资源建筑</option>
            <option value="2">攻击军队</option>
            <option value="3">防御军队</option>
            <option value="4">科技项目</option>
          </select>
        </div>
    </div>
    <div class="form-group">
        <label  class="col-xs-4 control-label">最高等级</label>
        <div class="col-xs-8">
          <input  class="form-control" name="max_level" type="number" placeholder="可选">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-xs-4 control-label">阵营</label>
        <div class="col-xs-8">
           <select class="form-control" name="camp">
            <option value="2">通用</option>
            <option value="0">盟军</option>
            <option value="1">法西斯</option>
          </select>
        </div>
    </div>
  <div class="form-group">
    <div class="col-xs-offset-4 col-xs-8">
      <button type="submit" class="btn btn-default">添加</button>
    </div>
  </div>
</form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>