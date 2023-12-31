@extends('frontend.default.auth.layouts.app')
@section('styles')
    <style>
        .register_form .form-group input {
            padding: 24px 20px!important;
            border: 1px solid var(--border_color);
            border-radius: 0;
            font-size: 13px;
            color: #8f8f8f;
            text-transform: none;
        }
        .register_form .form-group textarea {
            height: 160px;
            width: 100%;
            padding: 20px;
            font-size: 13px;
            border: 1px solid var(--border_color);
        }
        .nc_select {
            border-radius: 0;
            font-size: 13px;
            color: #8f8f8f;
            display: block;
            width: 100%;
            text-transform: none;
            padding: 0 20px;
            margin-bottom: 15px;
        }
        .login_logo img {
            max-width: 140px;
            margin: 0 auto;
        }
        .mb-10{
            margin-bottom: 10px;
        }
    </style>
@endsection
@section('title')
    {{ __('Merchant Register') }}
@endsection
@section('content')
<section class="register_part">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6">
                <div class="register_form_iner">
                    <div class="login_logo text-center mb-3">
                        <a href="{{url('/')}}"><img src="{{showImage(app('general_setting')->logo)}}" alt=""></a>
                    </div>
                    <h2>{{ __('common.welcome') }}! {{ __('common.please') }} <br>{{ __('defaultTheme.create_your_merchant_account') }}</h2>
                    <form id="registerForm" action="{{route('frontend.merchant.store')}}" method="POST" class="register_form">
                        @csrf
                        <div class="form-row">
                            @php
                                $custom_field = [];
                                $default_field = [];
                            @endphp
                            @if(!empty($row) && !empty($form_data))
                                @foreach($form_data as $row)
                                    @php
                                        if($row->type != 'header' && $row->type !='paragraph'){
                                            if(property_exists($row,'className') && strpos($row->className, 'default-field') !== false){
                                                $default_field[] = $row->name;
                                            }else{
                                                $custom_field[] = $row->name;
                                            }
                                            $required = property_exists($row,'required');
                                            $type = property_exists($row,'subtype') ? $row->subtype : $row->type;
                                            $placeholder = property_exists($row,'placeholder') ? $row->placeholder : $row->label;
                                        }
                                    @endphp

                                    @if($row->type =='header' || $row->type =='paragraph')
                                        <div class="col-lg-12 form-group">
                                            <{{ $row->subtype }}>{{ $row->label }} </{{ $row->subtype }}>
                                        </div>
                                    @elseif($row->type == 'text' || $row->type == 'number' || $row->type == 'email' || $row->type == 'date')
                                        <div class="col-md-6 mb-10">
                                            <label for="{{$row->name}}"> {{$row->label}} @if($required) <span class="text-danger">*</span> @endif</label>
                                            <input {{$required ? 'required' :''}} type="{{$type}}" id="{{$row->name}}" class="@error($row->name) is-invalid @enderror" name="{{$row->name}}" value="{{ old($row->name) }}" placeholder="{{$placeholder}}">
                                            @error($row->name)
                                            <span class="text-danger" >{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @elseif($row->type=='select')
                                        @if($row->name == 'account_type')
                                            @if (session()->has('pricing_id'))
                                                <div class="form-group col-md-6">
                                                    <label for={{$row->name}}>{{$row->label}} @if($required) <span class="text-danger">*</span> @endif</label>
                                                    <select {{$required ? 'required' :''}} name="subscription_type" id="{{$row->name}}" class="nc_select">
                                                        @foreach($row->values as $value)
                                                            <option value="{{$value->value}}" {{old($row->name) == $value->value? 'selected': ''}}>{{$value->label}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger">{{$errors->first($row->name)}}</span>
                                                </div>
                                            @endif
                                        @else
                                            <div class="form-group col-md-6">
                                                <label for={{$row->name}}>{{$row->label}}@if($required) <span class="text-danger">*</span> @endif</label>
                                                <select {{$required ? 'required' :''}} name="{{$row->name}}" id="{{$row->name}}" class="nc_select">
                                                    @foreach($row->values as $value)
                                                        <option value="{{$value->value}}" {{old($row->name) == $value->value? 'selected': ''}}>{{$value->label}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">{{$errors->first($row->name)}}</span>
                                            </div>
                                        @endif


                                    @elseif($row->type == 'date')
                                        <div class="col-md-6 form-group">
                                            <label for="datepicker"> {{$row->label}} @if($required) <span class="text-danger">*</span> @endif</label>
                                            <input {{$required ? 'required' :''}} type="{{$type}}" id="datepicker" class="@error($row->name) is-invalid @enderror" name="{{$row->name}}" value="{{ old($row->name) }}" placeholder="{{$placeholder}}">
                                            @error($row->name)
                                            <span class="text-danger" >{{ $message }}</span>
                                            @enderror
                                        </div>

                                    @elseif($row->type=='textarea')
                                        <div class="col-md-12 form-group">
                                            <label for={{$row->name}}>{{$row->label}}@if($required) <span class="text-danger">*</span> @endif</label>
                                            <textarea class="form-control" {{$required ? 'required' :''}} name="{{$row->name}}" id="{{$row->name}}" placeholder="{{$placeholder}}">{{old($row->name)}}</textarea>
                                            <span class="text-danger">{{$errors->first($row->name)}}</span>
                                        </div>

                                    @elseif($row->type=="radio-group")
                                        <div class="col-lg-12 form-group  mt-10 mb-10">
                                            <label for="">{{ $row->label }}</label>
                                            <div class="d-flex radio-btn-flex">
                                                @foreach($row->values as $value)
                                                    <label class="primary_bulet_checkbox mr-10">
                                                        <input type="radio" name="{{ $row->name }}" value="{{ $value->value }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <span class="mr-10">{{ $value->label }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif($row->type=="checkbox-group")
                                        <div class="col-lg-12 form-group mt-10 mb-10">
                                            <label>{{@$row->label}}</label>
                                            <div class="checkbox">
                                                @foreach($row->values as $value)
                                                    <label class="cs_checkbox mr-10">
                                                        <input  type="checkbox" name="{{ $row->name }}[]" value="{{ $value->value }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <p class="mr-10">{{$value->label}}</p>
                                                @endforeach
                                            </div>
                                        </div>

                                    @elseif($row->type =='file')

                                        <div class="col-lg-6">
                                            <div class="customer_img">
                                                <label for={{$row->name}}>{{$row->label}}@if($required) <span class="text-danger">*</span> @endif</label>
                                                <div class="form-group">
                                                    <input type="{{$type}}" name="{{$row->name}}" id="{{$row->name}}" >
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($row->type =='checkbox')
                                        <div class="col-md-12">
                                            <div class="checkbox">
                                                <label class="cs_checkbox">
                                                    <input id="policyCheck" type="checkbox" checked>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p>{!! $row->label !!}</p>
                                            </div>
                                        </div>
                                    @endif

                                @endforeach
                                <input type="hidden" name="custom_field" value="{{json_encode($custom_field)}}">

                            @else
                                @if (session()->has('pricing_id'))
                                    <div class="form-group col-md-6 mb-10">
                                        <label for="Shop">{{ __('Account Type') }} <span class="text-danger">*</span></label>
                                        <select name="subscription_type" class="nc_select" disabled>
                                            @foreach ($pricing_plans as $pricing_plan)
                                                <option value="{{ $pricing_plan->id }}" @if (session()->get('pricing_id') == $pricing_plan->id) selected @endif>{{ $pricing_plan->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="col-md-6 mb-10">
                                    <label for="Shop">{{ __('common.shop_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="Shop" value="{{old('name')}}" placeholder="{{ __('common.shop_name') }}" onfocus="this.placeholder = ''"
                                           onblur="this.placeholder = ''">
                                    @error('name')
                                    <span class="text-danger" >{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-10">
                                    <label for="email">{{ __('common.email_address') }} <span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email" value="{{old('email')}}" placeholder="{{ __('common.email_address') }} " onfocus="this.placeholder = ''"
                                           onblur="this.placeholder = 'Enter email address'">
                                    @error('email')
                                    <span class="text-danger" >{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-10">
                                    <label for="phone">{{ __('common.phone_number') }} <span class="text-danger">*</span></label>
                                    <input type="text" id="phone" name="phone" value="{{old('phone')}}" placeholder="{{ __('common.phone_number') }} " onfocus="this.placeholder = ''"
                                           onblur="this.placeholder = ''">
                                    @error('phone')
                                    <span class="text-danger" >{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-10">
                                    <label for="password">{{ __('common.password') }} <span class="text-danger">*</span></label>
                                    <input type="password" id="password" name="password" value="{{old('password')}}" placeholder="{{ __('common.password') }} " onfocus="this.placeholder = ''"
                                           onblur="this.placeholder = ''">
                                    @error('password')
                                    <span class="text-danger" >{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-10">
                                    <label for="re_password">{{ __('common.confirm_password') }}<span class="text-danger">*</span></label>
                                    <input type="password" id="re_password" name="password_confirmation" placeholder="{{ __('common.confirm_password') }}" onfocus="this.placeholder = ''"
                                           onblur="this.placeholder = ''">

                                </div>
                                <div class="col-md-12">
                                    <div class="checkbox">
                                        <label class="cs_checkbox">
                                            <input type="checkbox" id="termCheck" checked value="1">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('defaultTheme.by_signing_up_you_agree_to_terms_of_service_and_privacy_policy') }}</p>
                                    </div>
                                </div>

                            @endif
                            <div class="col-md-12 text-center">
                                <div class="register_area">
                                    <button type="submit" id="submitBtn" class="btn_1">{{ __('defaultTheme.register') }}</button>
                                    <p>{{ __('defaultTheme.already_a_merchant') }} <a href="{{route('seller.login')}}">{{ __('defaultTheme.login_account') }}</a> {{ __('common.here') }}.</p>
                                </div>
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
<script>
    (function($){
        "use strict";
        $(document).ready(function(){
            $(document).on('click','#termCheck',function(event){

                if($("#termCheck").prop('checked') == true){
                    //do something
                    $('#submitBtn').prop('disabled', false);
                }else{
                    $('#submitBtn').prop('disabled', true);
                }

            });
        });
    })(jQuery);
</script>
@endpush
