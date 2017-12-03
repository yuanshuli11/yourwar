<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Laravel')); ?></title>   
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('/bootstrap/css/bootstrap.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('/css/syshome.css')); ?>">
    <script type="text/javascript" src="<?php echo e(asset('/js/jquery.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('/bootstrap/js/bootstrap.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('/js/vue.js')); ?>"></script>
    <!-- Styles -->   
</head>
<body>
    <div class="header">
        <div class="title">二战风云-后台管理系统</div>
    </div>
    <div class="main-body">
       <div class="side-bar">
            <div class="show-tab"> <a href="<?php echo e(asset('/sysadmin')); ?>">首页</a></div>
            <div class="show-tab"> <a href="<?php echo e(asset('/sysadmin/object/list')); ?>">对象列表</a></div>
            <div class="show-tab"> <a href="<?php echo e(asset('/sysadmin/object/add')); ?>">添加对象</a></div>
       </div>
        <div class="body-content">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
  
</body>
</html>