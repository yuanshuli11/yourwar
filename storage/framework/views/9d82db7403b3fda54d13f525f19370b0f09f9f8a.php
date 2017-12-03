    <?php $__env->startSection('headercontent'); ?>

    <div class="page-header">
        <h1 style="text-align: center;">
            二战风云<small>阿登战役</small>
        </h1>
    </div>
    <div class="row">
        <div class="col-xs-12 ">
                    <form class="form-horizontal" method="POST" action="<?php echo e(route('register')); ?>">
                        <?php echo e(csrf_field()); ?>


                     
                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                            <div class="input-group input-group-lg loginInput">
                                    <span class="input-group-addon">邮箱</span> <input id="email" type="email" class="form-control" placeholder="请输入注册账号" name="email" value="<?php echo e(old('email')); ?>" required>
                            </div>
                            <div>
                                <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                            <div class="input-group input-group-lg loginInput">
                                    <span class="input-group-addon">密码</span> <input id="password" type="password" class="form-control"  placeholder="请输入密码"  name="password" required>
                            </div>
                            <div>
                                <?php if($errors->has('name')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group input-group-lg loginInput">
                                    <span class="input-group-addon">验证</span>  <input id="password-confirm" type="password" class="form-control"  placeholder="再次输入密码"   name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-3  col-xs-offset-2">
                                <span class="btn btn-info btn-lg leftBtn"><a href="<?php echo e(asset('login')); ?>" style="color:#fff">返回</a></span>                      
                            </div>
                            <div class="col-xs-3 col-xs-offset-1">                       
                                <button type="submit" class="btn btn-lg btn-primary">
                                    注册
                                </button>
                            </div>
                        </div>
                    </form>
           
        </div>
    </div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>