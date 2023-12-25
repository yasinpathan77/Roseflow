@extends('backEnd.master')

@section('mainContent')

<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="white_box_30px">
                    <form action="{{ route('opt.configuration_update') }}" method="post">
                        @csrf
                        <div class="col-xl-12">
                            <div class="box_header">
                                <div class="main-title d-flex">
                                    <h3 class="mb-0 mr-30">{{ __('otp.otp_configuration') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8">
                            <div class="primary_input">
                                <label class="primary_input_label" for="">{{ __('otp.code_validation_time_min') }}
                                </label>
                                <input class="primary_input_field name" min="1" required
                                    value="{{ otp_configuration('code_validation_time') }}" name="code_validation_time"
                                    id="status_active" value="" class="active" type="number">
                                <span class="text-danger" id="status_error"></span>
                            </div>
                        </div><br>
                        <div class="col-xl-12">
                            <div class="primary_input">
                                <label class="primary_input_label" for="">{{ __('otp.otp_send_for_customer_registration') }} <small>{{ __('otp.otp_will_be_sent_according_to_customer_register_email_or_phone') }}</small> </label>
                                <ul id="theme_nav" class="permission_list sms_list ">
                                    <li>
                                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                            <input name="otp_activation_for_customer" id="status_active" value="1"
                                                {{otp_configuration('otp_activation_for_customer')==1?'checked':''}}
                                                class="active" type="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('common.active') }}</p>
                                    </li>
                                    <li>
                                        <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                            <input name="otp_activation_for_customer" value="0" id="status_inactive"
                                                {{otp_configuration('otp_activation_for_customer')==0?'checked':''}}
                                                class="de_active" type="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('common.inactive') }}</p>
                                    </li>
                                </ul>

                            </div>
                        </div>
                        @if (isModuleActive('MultiVendor'))
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">{{ __('otp.otp_send_for_seller_registration') }} </label>

                                        <ul id="theme_nav" class="permission_list sms_list ">
                                            <li>

                                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                    <input name="otp_activation_for_seller" id="seller_active" value="1"
                                                        {{otp_configuration('otp_activation_for_seller')==1?'checked':''}}
                                                        class="active seller_regestration" type="radio">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p>{{ __('common.active') }}</p>
                                            </li>
                                            <li>

                                                <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                                    <input name="otp_activation_for_seller" value="0"
                                                        id="seller_inactive"
                                                        {{otp_configuration('otp_activation_for_seller')==0?'checked':''}}
                                                        class="de_active seller_regestration" type="radio">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p>{{ __('common.inactive') }}</p>
                                            </li>

                                        </ul>
                                        <span class="text-danger" id="status_error"></span>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">{{ __('otp.otp_type') }}<small> ({{ __('otp.email_and_sms_should_be_configured_first') }})</small></label>

                                        <ul id="theme_nav" class="permission_list sms_list ">

                                            <li>

                                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                    <input name="otp_type_registration[]" id="status_active"
                                                        value="email"
                                                        {{Str::contains(otp_configuration('otp_type_registration'),'email')
                                                        ? 'checked' :''}} class="active seller_otp_type"
                                                        type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p>{{ __('common.email') }}</p>
                                            </li>
                                            <li>

                                                <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                                    <input name="otp_type_registration[]" value="sms"
                                                        id="status_inactive"
                                                        {{Str::contains(otp_configuration('otp_type_registration'),'sms')
                                                        ? 'checked' :''}} class="de_active seller_otp_type"
                                                        type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p>{{ __('common.sms') }}</p>
                                            </li>
                                        </ul>
                                        <span class="text-danger" id="status_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">{{ __('otp.otp_send_for_order_confiramtion') }} ({{ __('otp.cod') }})
                                        </label>
                                        <ul id="theme_nav" class="permission_list sms_list ">
                                            <li>
                                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                    <input name="otp_activation_for_order" id="status_active" value="1"
                                                        {{otp_configuration('otp_activation_for_order')==1?'checked':''}}
                                                        class="active order" type="radio">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p>{{ __('common.active') }}</p>
                                            </li>
                                            <li>
                                                <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                                    <input name="otp_activation_for_order" value="0"
                                                        id="status_inactive"
                                                        {{otp_configuration('otp_activation_for_order')==0?'checked':''}}
                                                        class="de_active order" type="radio">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p>{{ __('common.inactive') }}</p>
                                            </li>

                                        </ul>
                                        <span class="text-danger" id="status_error"></span>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">{{ __('otp.otp_type') }} <small> ({{ __('otp.email_and_sms_should_be_configured_first') }})</small></label>
                                        <ul id="theme_nav" class="permission_list sms_list ">
                                            <li>

                                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                    <input name="otp_type_order[]" id="status_active" value="email"
                                                        {{Str::contains(otp_configuration('otp_type_order'),'email')
                                                        ? 'checked' :''}} class="active order_otp_type" type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p>{{ __('common.email') }}</p>
                                            </li>
                                            <li>

                                                <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                                    <input name="otp_type_order[]" value="sms" id="status_inactive"
                                                        {{Str::contains(otp_configuration('otp_type_order'),'sms')
                                                        ? 'checked' :''}} class="de_active order_otp_type"
                                                        type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p>{{ __('common.sms') }}</p>
                                            </li>
                                        </ul>
                                        <span class="text-danger" id="status_error"></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">{{ __('Order Confirm OTP On Verified Customer') }} ({{ __('otp.cod') }})
                                        </label>
                                        <ul id="theme_nav" class="permission_list sms_list ">
                                            <li>
                                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                    <input name="order_otp_on_verified_customer" id="status_active" value="1"
                                                        {{otp_configuration('order_otp_on_verified_customer')==1?'checked':''}}
                                                        class="active" type="radio">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p>{{ __('common.active') }}</p>
                                            </li>
                                            <li>
                                                <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                                    <input name="order_otp_on_verified_customer" value="0"
                                                        id="status_inactive"
                                                        {{otp_configuration('order_otp_on_verified_customer')==0?'checked':''}}
                                                        class="de_active" type="radio">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p>{{ __('common.inactive') }}</p>
                                            </li>

                                        </ul>
                                        <span class="text-danger" id="status_error"></span>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">{{ __('Number Of Order Returned Send OTP On Verified Customer') }}
                                        </label>
                                        <input class="primary_input_field name" min="1" required
                                            value="{{ otp_configuration('order_cancel_limit_on_verified_customer') }}" name="order_cancel_limit_on_verified_customer"
                                            id="status_active" value="" class="active" type="number">
                                        <span class="text-danger" id="status_error"></span>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">{{__('OTP Send On User Login')}}</label>
                                        <ul id="theme_nav" class="permission_list sms_list ">
                                            <li>
                                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                    <input name="otp_on_login" id="status_active" value="1"
                                                        {{otp_configuration('otp_on_login')==1?'checked':''}}
                                                        class="active" type="radio">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p>{{ __('common.active') }}</p>
                                            </li>
                                            <li>
                                                <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                                    <input name="otp_on_login" value="0"
                                                        id="status_inactive"
                                                        {{otp_configuration('otp_on_login')==0?'checked':''}}
                                                        class="de_active" type="radio">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p>{{ __('common.inactive') }}</p>
                                            </li>

                                        </ul>
                                        <span class="text-danger" id="status_error"></span>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">{{__('OTP On Password Reset')}}</label>
                                        <ul id="theme_nav" class="permission_list sms_list ">
                                            <li>
                                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                    <input name="otp_on_password_reset" id="status_active" value="1"
                                                        {{otp_configuration('otp_on_password_reset')==1?'checked':''}}
                                                        class="active" type="radio">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p>{{ __('common.active') }}</p>
                                            </li>
                                            <li>
                                                <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                                    <input name="otp_on_password_reset" value="0"
                                                        id="status_inactive"
                                                        {{otp_configuration('otp_on_password_reset')==0?'checked':''}}
                                                        class="de_active" type="radio">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p>{{ __('common.inactive') }}</p>
                                            </li>

                                        </ul>
                                        <span class="text-danger" id="status_error"></span>
                                    </div>
                                </div>
                                
                            </div>

                        </div>
                        <div class="col-xl-12 mt-20">
                            <div class="submit_btn text-center">
                                <button class="primary_btn_2" type="submit"> <i class="ti-check" dusk="save"></i>{{
                                    __('common.update') }}</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection
@push('scripts')
<script type="text/javascript">
    (function($){
            "use strict";
            $(document).ready(function() {
                $(document).on('change', '.seller_regestration', function() {
                    var status = $(this).val();
                    if(status == 1) {
                       $(".seller_otp_type").prop('checked', true);
                       $(".seller_otp_type").prop('disabled', false);
                    }else{
                        $(".seller_otp_type").prop('checked', false);
                        $(".seller_otp_type").prop('disabled', true);
                    }
                });
                $(document).on('change', '.order', function() {
                    var status = $(this).val();
                    if(status == 1) {
                       $(".order_otp_type").prop('checked', true);
                        $(".order_otp_type").prop('disabled', false);
                    }else{
                        $(".order_otp_type").prop('checked', false);
                        $(".order_otp_type").prop('disabled', true);
                    }
                });
            });
        })(jQuery);
</script>
@endpush
