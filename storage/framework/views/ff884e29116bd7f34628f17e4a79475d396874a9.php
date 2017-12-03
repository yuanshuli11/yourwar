
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
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('/bootstrap/css/font-awesome.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('/sweetalert/sweetalert.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('/css/home.css')); ?>">
    <script type="text/javascript" src="<?php echo e(asset('/js/jquery.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('/bootstrap/js/bootstrap.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('/sweetalert/sweetalert.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('/js/vue.js')); ?>"></script>
    <!-- Styles -->   
</head>
<body>
   <div class="main-body">
        <?php echo $__env->yieldContent('headercontent'); ?>
    </div>
</body>
<script type="text/javascript">
   
</script>
</html>
