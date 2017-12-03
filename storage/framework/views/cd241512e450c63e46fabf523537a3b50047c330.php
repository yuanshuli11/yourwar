
<?php $__env->startSection('content'); ?>

<div class="show-pagename"><h2><?php echo e($page); ?></h2></div>
<div>
    <a class="btn btn-primary" href="<?php echo e(asset('/sysadmin/object/list')); ?>?type=0">军事建筑</a>
    <a class="btn btn-primary" href="<?php echo e(asset('/sysadmin/object/list')); ?>?type=1">资源建筑</a>
    <a class="btn btn-primary" href="<?php echo e(asset('/sysadmin/object/list')); ?>?type=4">科技研究</a>
    <a class="btn btn-primary" href="<?php echo e(asset('/sysadmin/object/list')); ?>?type=3">其他</a>
</div>
<table class="table table-hover">
    <thead>
        <th>
            <td>名称</td>
            <td>标识</td>
            <td>描述</td>
            <td>类型</td>
            <td>最高等级</td>
            <td>数量限制</td>
            <td>阵营</td>
            <td>更新时间</td>
            <td>操作</td>
        </th>
    </thead>
    <tbody>
        <?php $__currentLoopData = $object; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($item['id']); ?></td>
            <td><?php echo e($item['name']); ?></td>
            <td><?php echo e($item['name_type']); ?></td>
            <td><?php echo e($item['description']); ?></td>
            <td><?php echo e($item['type']); ?></td>
            
            <td><?php echo e($item['max_level']); ?></td>
            <td><?php echo e($item['max_number']==0?"不限制":$item['max_number']); ?></td>
            <td><?php echo e($item['camp']); ?></td>
            <td><?php echo e($item['updated_at']); ?></td>
            <td><a href="<?php echo e(asset('/sysadmin/object/edit/'.$item['id'])); ?>">编辑</a></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>

</table>
  <?php echo e($object->appends(['type' =>isset($_GET['type'])?$_GET['type']:'all'])->links()); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>