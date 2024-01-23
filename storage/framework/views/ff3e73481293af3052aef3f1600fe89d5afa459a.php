<?php $currentUrl = url()->current();
?>
<?php $__env->startSection('title', __('labels.backend.menu-manager.title').' | '.app_name()); ?>

<?php $__env->startPush('after-styles'); ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <style>
        .nav-tabs .nav-link, .nav-tabs .navbar .dropdown-toggle, .navbar .nav-tabs .dropdown-toggle {
            color: #536c79;
            background-color: #f1f1f1;
            border-bottom: 1px solid #a7b7bf;
        }

        .mb-0 > .card-header {
            display: block;
            position: relative;
            outline: none;
            text-align: left;
            border: none;
        }

        .mb-0 > .card-header span:after {
            content: "\f078"; /* fa-chevron-down */
            font-family: 'Font Awesome\ 5 Free';
            font-weight: 900;
            right: 15px;
            left: 10px
        }

        .mb-0 > button.card-header:after {
            position: absolute;
            content: "\f078"; /* fa-chevron-down */
            font-family: 'Font Awesome\ 5 Free';
            font-weight: 900;
            right: 15px;
        }

        .sub-menu {
            margin-left: 30px;
        }

        .sub-sub-menu {
            margin-left: 60px;
        }

        .mb-0 > button.card-header[aria-expanded="true"]:after, .card-header span[aria-expanded="true"]:after {
            content: "\f077"; /* fa-chevron-up */
            font-weight: 900;
        }

        div.disabled {
            pointer-events: none;
            cursor: not-allowed;
            /* for "disabled" effect */
            opacity: 0.5;
            background: #CCC;
        }

        .menu-list {
            list-style-type: none;
            padding-left: 0px;
        }

        .menu-list .card-header {
            cursor: move;
        }

        .menu-list .card-header span {
            cursor: pointer;
        }

        .action-text {
            cursor: pointer;
            color: blue;
        }

        .action-text span {
            margin-right: 20px;
            white-space: nowrap;
        }

        .error {
            border-color: red;
        }

        .card-header h6 {
            color: grey;
            font-size: 0.800rem;
            margin-left: 10px;
            display: inline-block;
        }

    </style>
    <link href="<?php echo e(asset('vendor/harimayco-menu/style.css')); ?>" rel="stylesheet">

<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="page-title mb-0">
                <?php echo e(__('labels.backend.menu-manager.title')); ?>


            </h3>
        </div>
        <div class="card-body">
            <?php if(isset($menu)): ?>
                <?php echo Menu::render()->with(['menu' => $menu,'menu_list' => $menu_list,'pages' =>$pages]); ?>

            <?php else: ?>
                <?php echo Menu::render()->with(['menu_list' => $menu_list]); ?>

            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('after-scripts'); ?>
    <?php echo Menu::scripts(); ?>

    <script src="<?php echo e(url('/plugins/bootstrap-iconpicker/js/bootstrap-iconpicker.bundle.min.js')); ?>"></script>
    <script type="text/javascript">
        $('#menu_icon').iconpicker({});

        $(document).ready(function () {
            $(document).on('click', '.btn-add', function (e) {
                e.preventDefault();

                var tableFields = $('.table-fields'),
                    currentEntry = $(this).parents('.entry:first'),
                    newEntry = $(currentEntry.clone()).appendTo(tableFields);

                newEntry.find('input').val('');
                tableFields.find('.entry:not(:last) .btn-add')
                    .removeClass('btn-add').addClass('btn-remove')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="fa fa-minus"></span>');
            }).on('click', '.btn-remove', function (e) {
                $(this).parents('.entry:first').remove();

                e.preventDefault();
                return false;
            });

        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/menu-manager/index.blade.php ENDPATH**/ ?>