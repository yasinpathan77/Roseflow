<form action="{{ route('payment_gateway.configuration') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-2 mt-20 mb-30">
            <input type="hidden" name="types[]" value="GOOGLE_PAY_ENVIRONMENT">
           <div class="input-effect">
               <div class="input-effect">
                   <div class="text-left float-left">
                       <input type="radio" name="GOOGLE_PAY_ENVIRONMENT" @if ($gateway->perameter_1 == "TEST"  || $gateway->perameter_1 == null) checked @endif id="mode_check_5" value="TEST" class="common-radio relationButton read-only-input">
                       <label for="mode_check_5">{{ __('payment_gatways.test') }}</label>
                   </div>
               </div>
           </div>
       </div>
       <div class="col-lg-2 mt-20 mb-30">
           <div class="input-effect">
               <div class="input-effect">
                   <div class="text-left float-left">
                       <input type="radio" name="GOOGLE_PAY_ENVIRONMENT" id="live_mode_check_6" @if ($gateway->perameter_1 == "PRODUCTION") checked @endif value="PRODUCTION" class="common-radio relationButton read-only-input">
                       <label for="live_mode_check_6">{{ __('payment_gatways.live') }}</label>
                   </div>
               </div>
           </div>
       </div>
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="GOOGLE_PAY_GATEWAY">
                <label class="primary_input_label" for="">{{ __('payment_gatways.gateway_name') }}</label>
                <input name="GOOGLE_PAY_GATEWAY" class="primary_input_field" value="{{ $gateway->perameter_2 }}" placeholder="{{ __('payment_gatways.gateway_name') }}" type="text">
            </div>
        </div>
        <input type="hidden" name="name" value="GOOGLE PAY Configuration">
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="GOOGLE_PAY_MERCHANT_ID">
                <label class="primary_input_label" for="">{{ __('payment_gatways.merchant_id') }}</label>
                <input name="GOOGLE_PAY_MERCHANT_ID" class="primary_input_field" value="{{ $gateway->perameter_3 }}" placeholder="{{ __('payment_gatways.merchant_id') }}" type="text">
            </div>
        </div>
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="GOOGLE_PAY_MERCHANT_NAME">
                <label class="primary_input_label" for="">{{ __('payment_gatways.merchant_name') }}</label>
                <input name="GOOGLE_PAY_MERCHANT_NAME" class="primary_input_field" value="{{ $gateway->perameter_4 }}" placeholder="{{ __('payment_gatways.merchant_name') }}" type="text">
            </div>
        </div>
        <input type="hidden" name="id" value="{{ @$gateway->id }}">
        <input type="hidden" name="method_id" value="{{ @$gateway->method->id }}">
        @if(auth()->user()->role->type != 'seller')
            <div class="col-xl-8">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('payment_gatways.gateway_logo') }} (400x166)PX</label>
                    <div class="primary_file_uploader">
                        <input class="primary-input" type="text" id="googlePay_file" placeholder="{{ __('payment_gatways.gateway_logo') }}" readonly="" />
                        <button class="" type="button">
                            <label class="primary-btn small fix-gr-bg" for="logogooglePay">{{ __('product.Browse') }} </label>
                            <input type="file" class="d-none" name="logo" accept="image/*" id="logogooglePay"/>
                        </button>
                    </div>

                </div>
            </div>
            <div class="col-xl-4">
                <div class="logo_div">
                    @if (@$gateway->method->logo)
                        <img id="logogooglePayDiv" class="" src="{{ showImage(@$gateway->method->logo) }}" alt="">
                    @else
                        <img id="logogooglePayDiv" class="" src="{{ showImage('backend/img/default.png') }}" alt="">
                    @endif
                </div>
            </div>
        @endif
        <div class="col-lg-12 text-center">
            <button class="primary_btn_2 mt-2"><i class="ti-check"></i>{{__("common.update")}} </button>
        </div>
    </div>
</form>

