<?php $__env->startSection('title', trans('labels.frontend.cart.payment_status').' | '.app_name()); ?>

<?php $__env->startPush('after-styles'); ?>
    <style>
        input[type="radio"] {
            display: inline-block !important;
        }

        .course-rate li {
            color: #ffc926 !important;
        }

        #applyCoupon {
            box-shadow: none !important;
            color: #fff !important;
            font-weight: bold;
        }

        #coupon.warning {
            border: 1px solid red;
        }

        .purchase-list .in-total {
            font-size: 18px;
        }

        #coupon-error {
            color: red;
        }
        .in-total:not(:first-child):not(:last-child){
            font-size: 15px;
        }

    </style>

    <script src='https://js.stripe.com/v2/' type='text/javascript'></script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

    <!-- Start of breadcrumb section
        ============================================= -->
    <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
            <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold"><span><?php echo app('translator')->get('labels.frontend.cart.checkout'); ?></span></h2>
                </div>
            </div>
        </div>
    </section>
    <!-- End of breadcrumb section
        ============================================= -->


    <!-- Start of Checkout content
        ============================================= -->
    <section id="checkout" class="checkout-section">
        <div class="container">
            <div class="section-title mb45 headline text-center">
                <span class="subtitle text-uppercase"><?php echo app('translator')->get('labels.frontend.cart.your_shopping_cart'); ?></span>
                <h2><?php echo app('translator')->get('labels.frontend.cart.complete_your_purchases'); ?></h2>
            </div>
            <div class="checkout-content">
                <?php if(session()->has('danger')): ?>
                    <div class="alert alert-dismissable alert-danger fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo session('danger'); ?>

                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-9">
                        <div class="order-item mb30 course-page-section">
                            <div class="section-title-2  headline text-left">
                                <h2><?php echo app('translator')->get('labels.frontend.cart.order_item'); ?></h2>
                            </div>

                            <div class="course-list-view table-responsive">
                                <table class="table">

                                    <thead>
                                    <tr class="list-head text-uppercase">
                                        <th><?php echo app('translator')->get('labels.frontend.cart.product_name'); ?></th>
                                        <th><?php echo app('translator')->get('labels.frontend.cart.product_type'); ?></th>
                                        <th><?php echo app('translator')->get('labels.frontend.cart.starts'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(count($courses) > 0): ?>
                                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="position-relative">

                                                <td>
                                                    <a style="right: 3%;" class="text-danger position-absolute"
                                                       href="<?php echo e(route('cart.remove',['course'=>$course])); ?>"><i
                                                                class="fa fa-times"></i></a>
                                                    <div class="course-list-img-text">
                                                        <div class="course-list-img"
                                                             <?php if($course->course_image != ""): ?> style="background-image: url(<?php echo e(asset('storage/uploads/'.$course->course_image)); ?>)" <?php endif; ?> >

                                                        </div>
                                                        <div class="course-list-text">
                                                            <h3>
                                                                <a href="<?php echo e(route('courses.show', [$course->slug])); ?>"><?php echo e($course->title); ?></a>
                                                            </h3>
                                                            <div class="course-meta">
                                                                <span class="course-category bold-font"><a
                                                                            href="#"><?php if($course->free == 1): ?>
                                                                            <span><?php echo e(trans('labels.backend.bundles.fields.free')); ?></span>
                                                                        <?php else: ?>
                                                                            <span> <?php echo e($appCurrency['symbol'].' '.$course->price); ?></span>
                                                                        <?php endif; ?></a></span>
                                                                <span class="bold-font"><?php echo e($course->category->name); ?></span>
                                                                <div class="course-rate ul-li">
                                                                    <ul>
                                                                        <?php for($i=1; $i<=(int)$course->rating; $i++): ?>
                                                                            <li><i class="fas fa-star"></i></li>
                                                                        <?php endfor; ?>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="course-type-list">
                                                        <span><?php echo e(class_basename($course)); ?></span>
                                                    </div>
                                                </td>
                                                <td><?php echo e(($course->start_date != "") ? $course->start_date : 'N/A'); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4"><?php echo app('translator')->get('labels.frontend.cart.empty_cart'); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php if(count($courses) > 0): ?>
                            <?php if((config('services.stripe.active') == 0) && (config('paypal.active') == 0) && (config('payment_offline_active') == 0) && (config('services.instamojo.active') == 0) && (config('services.razorpay.active') == 0) && (config('services.cashfree.active') == 0) && (config('services.payu.active') == 0) && (config('flutter.active') == 0)): ?>
                                <div class="order-payment">
                                    <div class="section-title-2 headline text-left">
                                        <h2><?php echo app('translator')->get('labels.frontend.cart.no_payment_method'); ?></h2>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="order-payment">
                                    <div class="section-title-2  headline text-left">
                                        <h2><?php echo app('translator')->get('labels.frontend.cart.order_payment'); ?></h2>
                                    </div>
                                    <div id="accordion">
                                        <?php if(config('services.stripe.active') == 1): ?>
                                            <div class="payment-method w-100 mb-0">
                                                <div class="payment-method-header">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="method-header-text">
                                                                <div class="radio">
                                                                    <label>
                                                                        <input data-toggle="collapse"
                                                                               href="#collapsePaymentOne"
                                                                               type="radio" name="paymentMethod"
                                                                               value="1"
                                                                               checked>
                                                                        <?php echo app('translator')->get('labels.frontend.cart.payment_cards'); ?>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="payment-img float-right">
                                                                <img src="<?php echo e(asset('assets/img/banner/p-1.jpg')); ?>"
                                                                     alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="check-out-form collapse show" id="collapsePaymentOne"
                                                     data-parent="#accordion">


                                                    <form accept-charset="UTF-8"
                                                          action="<?php echo e(route('cart.stripe.payment')); ?>"
                                                          class="require-validation" data-cc-on-file="false"
                                                          data-stripe-publishable-key="<?php echo e(config('services.stripe.key')); ?>"
                                                          id="payment-form"
                                                          method="POST">

                                                        <div style="margin:0;padding:0;display:inline">
                                                            <input name="utf8" type="hidden"
                                                                   value="✓"/>
                                                            <?php echo csrf_field(); ?>
                                                        </div>


                                                        <div class="payment-info">
                                                            <label class=" control-label"><?php echo app('translator')->get('labels.frontend.cart.name_on_card'); ?>
                                                                :</label>
                                                            <input type="text" autocomplete='off'
                                                                   class="form-control required card-name"
                                                                   placeholder="<?php echo app('translator')->get('labels.frontend.cart.name_on_card_placeholder'); ?>"
                                                                   value="">
                                                        </div>
                                                        <div class="payment-info">
                                                            <label class=" control-label"><?php echo app('translator')->get('labels.frontend.cart.card_number'); ?>
                                                                :</label>
                                                            <input autocomplete='off' type="text"
                                                                   class="form-control required card-number"
                                                                   placeholder="<?php echo app('translator')->get('labels.frontend.cart.card_number_placeholder'); ?>"
                                                                   value="">
                                                        </div>
                                                        <div class="payment-info input-2">
                                                            <label class=" control-label"><?php echo app('translator')->get('labels.frontend.cart.cvv'); ?>
                                                                :</label>
                                                            <input type="text" class="form-control card-cvc required"
                                                                   placeholder="<?php echo app('translator')->get('labels.frontend.cart.cvv'); ?>"
                                                                   value="">
                                                        </div>
                                                        <div class="payment-info input-2">
                                                            <label class=" control-label"><?php echo app('translator')->get('labels.frontend.cart.expiration_date'); ?>
                                                                :</label>
                                                            <input autocomplete='off' type="text"
                                                                   class="form-control required card-expiry-month"
                                                                   placeholder="<?php echo app('translator')->get('labels.frontend.cart.mm'); ?>"
                                                                   value="">
                                                            <input autocomplete='off' type="text"
                                                                   class="form-control required card-expiry-year"
                                                                   placeholder="<?php echo app('translator')->get('labels.frontend.cart.yy'); ?>"
                                                                   value="">
                                                        </div>
                                                        <button type="submit"
                                                                class="text-white genius-btn mt25 gradient-bg text-center text-uppercase  bold-font">
                                                            <?php echo app('translator')->get('labels.frontend.cart.pay_now'); ?> <i
                                                                    class="fas fa-caret-right"></i>
                                                        </button>
                                                        <div class="row mt-3">
                                                            <div class="col-12 error form-group d-none">
                                                                <div class="alert-danger alert">
                                                                    <?php echo app('translator')->get('labels.frontend.cart.stripe_error_message'); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if(config('paypal.active') == 1): ?>
                                            <div class="payment-method w-100 mb-0">
                                                <div class="payment-method-header">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="method-header-text">
                                                                <div class="radio">
                                                                    <label>
                                                                        <input data-toggle="collapse"
                                                                               href="#collapsePaymentTwo"
                                                                               type="radio" name="paymentMethod"
                                                                               value="2">
                                                                        <?php echo app('translator')->get('labels.frontend.cart.paypal'); ?>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="payment-img float-right">
                                                                <img src="<?php echo e(asset('assets/img/banner/p-2.jpg')); ?>"
                                                                     alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="check-out-form collapse disabled" id="collapsePaymentTwo"
                                                     data-parent="#accordion">
                                                    <form class="w3-container w3-display-middle w3-card-4 "
                                                          method="POST"
                                                          id="payment-form" action="<?php echo e(route('cart.paypal.payment')); ?>">
                                                        <?php echo e(csrf_field()); ?>

                                                        <p> <?php echo app('translator')->get('labels.frontend.cart.pay_securely_paypal'); ?></p>

                                                        <button type="submit"
                                                                class="text-white genius-btn mt25 gradient-bg text-center text-uppercase  bold-font">
                                                            <?php echo app('translator')->get('labels.frontend.cart.pay_now'); ?> <i
                                                                    class="fas fa-caret-right"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if(config('flutter.active') == 1): ?>
                                        <div class="payment-method w-100 mb-0">
                                            <div class="payment-method-header">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="method-header-text">
                                                            <div class="radio">
                                                                <label>
                                                                    <input data-toggle="collapse"
                                                                           href="#collapsePaymentTwo"
                                                                           type="radio" name="paymentMethod"
                                                                           value="8">
                                                                    <?php echo app('translator')->get('labels.frontend.cart.flutter'); ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="payment-img float-right">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="check-out-form collapse disabled" id="collapsePaymentTwo"
                                                 data-parent="#accordion">
                                                <form class="w3-container w3-display-middle w3-card-4 "
                                                      method="POST"
                                                      id="paymentForm" action="<?php echo e(route('cart.flutter.payment')); ?>">
                                                    <?php echo e(csrf_field()); ?>

                                                    <p> <?php echo app('translator')->get('labels.frontend.cart.pay_securely_flutter'); ?></p>

                                                    <input type="text" autocomplete='off'
                                                           class="form-control"
                                                           name="user_phone"
                                                           placeholder="<?php echo app('translator')->get('labels.frontend.cart.user_phone'); ?>"
                                                           value="" required>

                                                    <button type="submit"
                                                            class="text-white genius-btn mt25 gradient-bg text-center text-uppercase  bold-font">
                                                        <?php echo app('translator')->get('labels.frontend.cart.pay_now'); ?> <i
                                                                class="fas fa-caret-right"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <?php if(config('services.instamojo.active') == 1): ?>
                                            <div class="payment-method w-100 mb-0">
                                                <div class="payment-method-header">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="method-header-text">
                                                                <div class="radio">
                                                                    <label>
                                                                        <input data-toggle="collapse"
                                                                               href="#collapsePaymentFour"
                                                                               type="radio" name="paymentMethod"
                                                                               value="4">
                                                                        <?php echo app('translator')->get('labels.frontend.cart.instamojo'); ?>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="payment-img float-right">
                                                                <img src="<?php echo e(asset('assets/img/banner/p-3.png')); ?>"
                                                                     alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="check-out-form collapse disabled" id="collapsePaymentFour"
                                                     data-parent="#accordion">
                                                    <form class="w3-container w3-display-middle w3-card-4 "
                                                          method="POST"
                                                          action="<?php echo e(route('cart.instamojo.payment')); ?>">
                                                        <?php echo e(csrf_field()); ?>

                                                        <p> <?php echo app('translator')->get('labels.frontend.cart.pay_securely_instamojo'); ?></p>
                                                        <div class="payment-info">
                                                            <label class=" control-label"><?php echo app('translator')->get('labels.frontend.cart.user_name'); ?>
                                                                :</label>
                                                            <input type="text" autocomplete='off'
                                                                   class="form-control"
                                                                   name="user_name"
                                                                   placeholder="<?php echo app('translator')->get('labels.frontend.cart.user_name'); ?>"
                                                                   value="<?php echo e(auth()->user()->name); ?>" required>
                                                        </div>
                                                        <div class="payment-info">
                                                            <label class=" control-label"><?php echo app('translator')->get('labels.frontend.cart.user_email'); ?>
                                                                :</label>
                                                            <input type="text" autocomplete='off'
                                                                   class="form-control"
                                                                   name="user_email"
                                                                   placeholder="<?php echo app('translator')->get('labels.frontend.cart.user_email'); ?>"
                                                                   value="<?php echo e(auth()->user()->email); ?>" required>
                                                        </div>
                                                        <div class="payment-info">
                                                            <label class=" control-label"><?php echo app('translator')->get('labels.frontend.cart.user_phone'); ?>
                                                                :</label>
                                                            <input type="text" autocomplete='off'
                                                                   class="form-control"
                                                                   name="user_phone"
                                                                   placeholder="<?php echo app('translator')->get('labels.frontend.cart.user_phone'); ?>"
                                                                   value="" required>
                                                        </div>

                                                        <button type="submit"
                                                                class="text-white genius-btn mt25 gradient-bg text-center text-uppercase  bold-font">
                                                            <?php echo app('translator')->get('labels.frontend.cart.pay_now'); ?> <i
                                                                class="fas fa-caret-right"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if(config('services.razorpay.active') == 1): ?>
                                            <div class="payment-method w-100 mb-0">
                                                <div class="payment-method-header">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="method-header-text">
                                                                <div class="radio">
                                                                    <label>
                                                                        <input data-toggle="collapse"
                                                                               href="#collapsePaymentFive"
                                                                               type="radio" name="paymentMethod"
                                                                               value="5">
                                                                        <?php echo app('translator')->get('labels.frontend.cart.razorpay'); ?>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="payment-img float-right">
                                                                <img src="<?php echo e(asset('assets/img/banner/p-4.png')); ?>"
                                                                     alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="check-out-form collapse disabled" id="collapsePaymentFive"
                                                     data-parent="#accordion">

                                                    <form class="w3-container w3-display-middle w3-card-4 "
                                                          method="POST"
                                                          action="<?php echo e(route('cart.razorpay.payment')); ?>">
                                                        <?php echo e(csrf_field()); ?>

                                                        <p> <?php echo app('translator')->get('labels.frontend.cart.pay_securely_razorpay'); ?></p>

                                                        <button type="submit"
                                                                class="text-white genius-btn mt25 gradient-bg text-center text-uppercase  bold-font">
                                                            <?php echo app('translator')->get('labels.frontend.cart.pay_now'); ?> <i
                                                                class="fas fa-caret-right"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if(config('services.cashfree.active') == 1): ?>
                                            <div class="payment-method w-100 mb-0">
                                                <div class="payment-method-header">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="method-header-text">
                                                                <div class="radio">
                                                                    <label>
                                                                        <input data-toggle="collapse"
                                                                               href="#collapsePaymentSix"
                                                                               type="radio" name="paymentMethod"
                                                                               value="6">
                                                                        <?php echo app('translator')->get('labels.frontend.cart.cashfree'); ?>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="payment-img float-right">
                                                                <img src="<?php echo e(asset('assets/img/banner/p-6.png')); ?>"
                                                                     alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="check-out-form collapse disabled" id="collapsePaymentSix"
                                                     data-parent="#accordion">

                                                    <form class="w3-container w3-display-middle w3-card-4 "
                                                          method="POST"
                                                          action="<?php echo e(route('cart.cashfree.payment')); ?>">
                                                        <?php echo e(csrf_field()); ?>

                                                        <p> <?php echo app('translator')->get('labels.frontend.cart.pay_securely_cashfree'); ?></p>

                                                        <div class="payment-info">
                                                            <label class=" control-label"><?php echo app('translator')->get('labels.frontend.cart.user_name'); ?>
                                                                :</label>
                                                            <input type="text" autocomplete='off'
                                                                   class="form-control"
                                                                   name="user_name"
                                                                   placeholder="<?php echo app('translator')->get('labels.frontend.cart.user_name'); ?>"
                                                                   value="<?php echo e(auth()->user()->name); ?>" required>
                                                        </div>
                                                        <div class="payment-info">
                                                            <label class=" control-label"><?php echo app('translator')->get('labels.frontend.cart.user_email'); ?>
                                                                :</label>
                                                            <input type="text" autocomplete='off'
                                                                   class="form-control"
                                                                   name="user_email"
                                                                   placeholder="<?php echo app('translator')->get('labels.frontend.cart.user_email'); ?>"
                                                                   value="<?php echo e(auth()->user()->email); ?>" required>
                                                        </div>
                                                        <div class="payment-info">
                                                            <label class=" control-label"><?php echo app('translator')->get('labels.frontend.cart.user_phone'); ?>
                                                                :</label>
                                                            <input type="text" autocomplete='off'
                                                                   class="form-control"
                                                                   name="user_phone"
                                                                   placeholder="<?php echo app('translator')->get('labels.frontend.cart.user_phone'); ?>"
                                                                   value="" required>
                                                        </div>
                                                        <button type="submit"
                                                                class="text-white genius-btn mt25 gradient-bg text-center text-uppercase  bold-font">
                                                            <?php echo app('translator')->get('labels.frontend.cart.pay_now'); ?> <i
                                                                class="fas fa-caret-right"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if(config('services.payu.active') == 1): ?>
                                            <div class="payment-method w-100 mb-0">
                                                <div class="payment-method-header">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="method-header-text">
                                                                <div class="radio">
                                                                    <label>
                                                                        <input data-toggle="collapse"
                                                                               href="#collapsePaymentPayU"
                                                                               type="radio" name="paymentMethod"
                                                                               value="5">
                                                                        <?php echo app('translator')->get('labels.frontend.cart.payu'); ?>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="payment-img float-right">
                                                                <img src="<?php echo e(asset('assets/img/banner/p-7.png')); ?>"
                                                                     alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="check-out-form collapse disabled" id="collapsePaymentPayU"
                                                     data-parent="#accordion">

                                                    <form class="w3-container w3-display-middle w3-card-4 "
                                                          method="POST"
                                                          action="<?php echo e(route('cart.payu.payment')); ?>">
                                                        <?php echo e(csrf_field()); ?>

                                                        <p> <?php echo app('translator')->get('labels.frontend.cart.pay_securely_payu'); ?></p>

                                                        <div class="payment-info">
                                                            <label class=" control-label"><?php echo app('translator')->get('labels.frontend.cart.user_name'); ?>
                                                                :</label>
                                                            <input type="text" autocomplete='off'
                                                                   class="form-control"
                                                                   name="user_name"
                                                                   placeholder="<?php echo app('translator')->get('labels.frontend.cart.user_name'); ?>"
                                                                   value="<?php echo e(auth()->user()->name); ?>" required>
                                                        </div>
                                                        <div class="payment-info">
                                                            <label class=" control-label"><?php echo app('translator')->get('labels.frontend.cart.user_email'); ?>
                                                                :</label>
                                                            <input type="text" autocomplete='off'
                                                                   class="form-control"
                                                                   name="user_email"
                                                                   placeholder="<?php echo app('translator')->get('labels.frontend.cart.user_email'); ?>"
                                                                   value="<?php echo e(auth()->user()->email); ?>" required>
                                                        </div>
                                                        <div class="payment-info">
                                                            <label class=" control-label"><?php echo app('translator')->get('labels.frontend.cart.user_phone'); ?>
                                                                :</label>
                                                            <input type="text" autocomplete='off'
                                                                   class="form-control"
                                                                   name="user_phone"
                                                                   placeholder="<?php echo app('translator')->get('labels.frontend.cart.user_phone'); ?>"
                                                                   value="" required>
                                                        </div>
                                                        <button type="submit"
                                                                class="text-white genius-btn mt25 gradient-bg text-center text-uppercase  bold-font">
                                                            <?php echo app('translator')->get('labels.frontend.cart.pay_now'); ?> <i
                                                                class="fas fa-caret-right"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if(config('payment_offline_active') == 1): ?>
                                            <div class="payment-method w-100 mb-0">
                                                <div class="payment-method-header">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="method-header-text">
                                                                <div class="radio">
                                                                    <label>
                                                                        <input data-toggle="collapse"
                                                                               href="#collapsePaymentThree" type="radio"
                                                                               name="paymentMethod" value="3">
                                                                        <?php echo app('translator')->get('labels.frontend.cart.offline_payment'); ?>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="check-out-form collapse disabled" id="collapsePaymentThree"
                                                     data-parent="#accordion">
                                                    <p> <?php echo app('translator')->get('labels.frontend.cart.offline_payment_note'); ?></p>
                                                    <p><?php echo e(config('payment_offline_instruction')); ?></p>
                                                    <form method="post" action="<?php echo e(route('cart.offline.payment')); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit"
                                                                class="text-white genius-btn mt25 gradient-bg text-center text-uppercase  bold-font">
                                                            <?php echo app('translator')->get('labels.frontend.cart.request_assistance'); ?> <i
                                                                    class="fas fa-caret-right"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="terms-text pb45 mt25">
                                        <p><?php echo app('translator')->get('labels.frontend.cart.confirmation_note'); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-3">
                        <div class="side-bar-widget first-widget">
                            <h2 class="widget-title text-capitalize"><?php echo app('translator')->get('labels.frontend.cart.order_detail'); ?></h2>
                            <div class="sub-total-item">
                                <?php if(count($courses) > 0): ?>
                                    <div class="purchase-list py-3 ul-li-block">
                                        <?php echo $__env->make('frontend.cart.partials.order-stats', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                <?php else: ?>
                                    <div class="purchase-list mt15 ul-li-block">

                                        <div class="in-total text-uppercase"><?php echo app('translator')->get('labels.frontend.cart.total'); ?> <span><?php echo e($appCurrency['symbol']); ?>

                                                0.00</span></div>
                                    </div>

                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if($global_featured_course != ""): ?>
                            <div class="side-bar-widget">
                                <h2 class="widget-title text-capitalize"><?php echo app('translator')->get('labels.frontend.blog.featured_course'); ?></h2>
                                <div class="featured-course">
                                    <div class="best-course-pic-text relative-position pt-0">
                                        <div class="best-course-pic relative-position "
                                             style="background-image: url(<?php echo e(asset('storage/uploads/'.$global_featured_course->course_image)); ?>)">

                                            <?php if($global_featured_course->trending == 1): ?>
                                                <div class="trend-badge-2 text-center text-uppercase">
                                                    <i class="fas fa-bolt"></i>
                                                    <span><?php echo app('translator')->get('labels.frontend.badges.trending'); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if($global_featured_course->free == 1): ?>
                                                <div class="trend-badge-3 text-center text-uppercase">
                                                    <i class="fas fa-bolt"></i>
                                                    <span><?php echo app('translator')->get('labels.backend.courses.fields.free'); ?></span>
                                                </div>
                                            <?php endif; ?>

                                        </div>
                                        <div class="best-course-text" style="left: 0;right: 0;">
                                            <div class="course-title mb20 headline relative-position">
                                                <h3>
                                                    <a href="<?php echo e(route('courses.show', [$global_featured_course->slug])); ?>"><?php echo e($global_featured_course->title); ?></a>
                                                </h3>
                                            </div>
                                            <div class="course-meta">
                                                <span class="course-category"><a
                                                            href="<?php echo e(route('courses.category',['category'=>$global_featured_course->category->slug])); ?>"><?php echo e($global_featured_course->category->name); ?></a></span>
                                                <span class="course-author"><?php echo e($global_featured_course->students()->count()); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End  of Checkout content
        ============================================= -->
    <?php if(session()->get('razorpay')): ?>

        <button id="razor-pay-btn" class="d-none">Pay</button>
        <form id="razorpay-callback-form" method="post" action="<?php echo e(route('cart.razorpay.status')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
            <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
            <input type="hidden" name="razorpay_signature" id="razorpay_signature">
        </form>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('after-scripts'); ?>
    <?php if(config('services.stripe.active') == 1): ?>
        <script type="text/javascript" src="<?php echo e(asset('js/stripe-form.js')); ?>"></script>
    <?php endif; ?>
    <script>
        $(document).ready(function () {
            $(document).on('click', 'input[type="radio"]:checked', function () {
                $('#accordion .check-out-form').addClass('disabled')
                $(this).closest('.payment-method').find('.check-out-form').removeClass('disabled')
            })

            $(document).on('click', '#applyCoupon', function () {
                var coupon = $('#coupon');
                if (!coupon.val() || (coupon.val() == "")) {
                    coupon.addClass('warning');
                    $('#coupon-error').html("<small><?php echo e(trans('labels.frontend.cart.empty_input')); ?></small>").removeClass('d-none')
                    setTimeout(function () {
                        $('#coupon-error').empty().addClass('d-none')
                        coupon.removeClass('warning');

                    }, 5000);
                } else {
                    $('#coupon-error').empty().addClass('d-none')
                    $.ajax({
                        method: 'POST',
                        url: "<?php echo e(route('cart.applyCoupon')); ?>",
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>',
                            coupon: coupon.val()
                        }
                    }).done(function (response) {
                        if (response.status === 'fail') {
                            coupon.addClass('warning');
                            $('#coupon-error').removeClass('d-none').html("<small>" + response.message + "</small>");
                            setTimeout(function () {
                                $('#coupon-error').empty().addClass('d-none');
                                coupon.removeClass('warning');

                            }, 5000);
                        } else {
                            $('.purchase-list').empty().html(response.html)
                            $('#applyCoupon').removeClass('btn-dark').addClass('btn-success')
                            $('#coupon-error').empty().addClass('d-none');
                            coupon.removeClass('warning');
                        }
                    });

                }
            });


            $(document).on('click','#removeCoupon',function () {
                $.ajax({
                    method: 'POST',
                    url: "<?php echo e(route('cart.removeCoupon')); ?>",
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                    }
                }).done(function (response) {
                    $('.purchase-list').empty().html(response.html)
                });
            })

        })
    </script>

    <?php if(session()->get('razorpay')): ?>
        <?php
            $cart = session()->get('razorpay');
        ?>

        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script>
            var options = {
                "key": "<?php echo e(config('services.razrorpay.key')); ?>", // Enter the Key ID generated from the Dashboard
                "amount": "<?php echo e($cart['amount']); ?>", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                "currency": "<?php echo e($cart['currency']); ?>",
                "name": "<?php echo e(config('app.name')); ?>",
                "description": "<?php echo e($cart['description']); ?>",
                "image": "<?php echo e(asset("storage/logos/".config('logo_b_image'))); ?>",
                "order_id": "<?php echo e($cart['order_id']); ?>", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                "handler": function (response){
                    $('#razorpay_payment_id').val(response.razorpay_payment_id);
                    $('#razorpay_order_id').val(response.razorpay_order_id);
                    $('#razorpay_signature').val(response.razorpay_signature)
                    $("#razorpay-callback-form").submit();
                },
                "prefill": {
                    "name": "<?php echo e($cart['name']); ?>",
                    "email": "<?php echo e($cart['email']); ?>",
                }
            };
            var rzp1 = new Razorpay(options);
            document.getElementById('razor-pay-btn').onclick = function(e){
                rzp1.open();
                e.preventDefault();
            }
            window.onload = function () {
                document.getElementById('razor-pay-btn').click();
            }
        </script>
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('frontend.layouts.app'.config('theme_layout'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/frontend/cart/checkout.blade.php ENDPATH**/ ?>