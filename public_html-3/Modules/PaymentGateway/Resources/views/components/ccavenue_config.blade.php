<form action="{{ route('payment_gateway.configuration') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <input type="hidden" name="name" value="CCAvenue Configuration">
        
        <div class="col-lg-2 mt-20 mb-30">
            <input type="hidden" name="types[]" value="CCAVENUE_MODE">
            <div class="input-effect">
                <div class="input-effect">
                    <div class="text-left float-left">
                        <input type="radio" name="CCAVENUE_MODE" @if ($gateway->perameter_1 == "TEST"  || $gateway->perameter_1 == null) checked @endif
                            id="CCAVENUE_mode_check_1" value="TEST" class="common-radio relationButton read-only-input">
                        <label for="CCAVENUE_mode_check_1">{{ __('payment_gatways.test') }}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 mt-20 mb-30">
            <div class="input-effect">
                <div class="input-effect">
                    <div class="text-left float-left">
                        <input type="radio" name="CCAVENUE_MODE" id="CCAVENUE_live_mode_check_1" @if ($gateway->perameter_1 == "LIVE") checked @endif value="LIVE" class="common-radio relationButton read-only-input">
                        <label for="CCAVENUE_live_mode_check_1">{{ __('payment_gatways.live') }}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="CCAVENUE_MERCHANT_ID">
                <label class="primary_input_label" for="">{{ __('payment_gatways.ccavenue_merchant_id') }}</label>
                <input name="CCAVENUE_MERCHANT_ID" class="primary_input_field" value="{{ $gateway->perameter_2 }}"
                    placeholder="{{ __('payment_gatways.ccavenue_merchant_id') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="CCAVENUE_ACCESS_CODE">
                <label class="primary_input_label" for="">{{ __('payment_gatways.ccavenue_access_code') }}</label>
                <input name="CCAVENUE_ACCESS_CODE" class="primary_input_field" value="{{ $gateway->perameter_3 }}"
                    placeholder="{{ __('payment_gatways.ccavenue_access_code') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="CCAVENUE_WORKING_KEY">
                <label class="primary_input_label" for="">{{ __('payment_gatways.ccavenue_working_key') }}</label>
                <input name="CCAVENUE_WORKING_KEY" class="primary_input_field" value="{{ $gateway->perameter_4 }}"
                    placeholder="{{ __('payment_gatways.ccavenue_working_key') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <input type="hidden" name="id" value="{{ @$gateway->id }}">
        <input type="hidden" name="method_id" value="{{ @$gateway->method->id }}">
        @if(auth()->user()->role->type != 'seller')
            <div class="col-xl-8">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('payment_gatways.gateway_logo') }} (400x166)PX</label>
                    <div class="primary_file_uploader">
                        <input class="primary-input" type="text" id="thumbnail_image_file"
                            placeholder="{{ __('payment_gatways.gateway_logo') }}" readonly="" />
                        <button class="" type="button">
                            <label class="primary-btn small fix-gr-bg" for="ccavenue_logo">{{ __('product.Browse') }} </label>
                            <input type="file" class="d-none" name="logo" accept="image/*" id="ccavenue_logo" />
                        </button>
                    </div>

                </div>
            </div>
            <div class="col-xl-4">
                <div class="logo_div">
                    @if (@$gateway->method->logo)
                    <img id="ThumbnailImgDiv" class=""
                        src="{{ showImage(@$gateway->method->logo) }}" alt="">
                    @else
                    <img id="ThumbnailImgDiv" class="" src="{{ showImage('backend/img/default.png') }}" alt="">
                    @endif
                </div>
            </div>
        @endif
        <div class="col-lg-12 text-center">
            <button class="primary_btn_2 mt-2"><i class="ti-check"></i>{{__("common.update")}} </button>
        </div>
    </div>
</form>
