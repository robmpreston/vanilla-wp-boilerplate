<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="content">
            <div class="title">Something went wrong.</div>
            <p><a href="/">&lt; Go back</a></p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>