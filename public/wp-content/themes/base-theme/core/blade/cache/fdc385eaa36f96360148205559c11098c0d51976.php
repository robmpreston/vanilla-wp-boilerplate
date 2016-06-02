<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="content">
            <div class="title">WordPress Rapid Development Theme</div>
            <p><?php echo e($data['home']); ?></p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>