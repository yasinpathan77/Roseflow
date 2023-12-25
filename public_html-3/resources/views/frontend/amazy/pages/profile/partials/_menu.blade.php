<div class="dashboard_sidebar_wized mb_30">
    <!-- dashboard_sidebar_wized_user  -->
    <div class="dashboard_sidebar_wized_user d-flex flex-column justify-content-center align-items-center">
        <div class="thumb">
            <img src="{{auth()->user()->avatar?showImage(auth()->user()->avatar):showImage('frontend/default/img/avatar.jpg')}}" alt="{{auth()->user()->first_name}} {{auth()->user()->last_name}}" title="{{auth()->user()->first_name}} {{auth()->user()->last_name}}">
        </div>
        <h4 class="font_20 f_w_700">{{auth()->user()->first_name}} {{auth()->user()->last_name}}</h4>
        <div class="user_desc">
            @if(auth()->user()->email)
            <span class="email_text font_14 f_w_400 mute_text position-relative">{{auth()->user()->email}}</span>
            @endif
            @if(auth()->user()->phone)
            <span  class="number_text font_14 f_w_400 mute_text">{{auth()->user()->phone}}</span>
            @endif
        </div>
        @if (auth()->user()->role->type == 'customer' && isModuleActive('MultiVendor'))
            <!-- 005-add -->
            <!--<a href="{{route('frontend.merchant-register-step-first')}}" target="_blank" class="mb_10 text_color">{{ __('common.convert_as_seller') }}</a>-->
            <!-- End 005-add -->
        @endif
    </div>
    <!-- dashboard_sidebar_balance -->
    <div class="dashboard_sidebar_balance d-flex flex-column text-center">
        <span class="font_14 f_w_400">{{__('common.total_balance')}}</span>
        <h4 class="font_30 f_w_700 secondary_text mb_25">{{ auth()->check()?single_price(auth()->user()->CustomerCurrentWalletAmounts + auth()->user()->CustomerCurrentWalletPendingAmounts):single_price(0.00) }}</h4>
        <!-- dashboard_sidebar_balance_lists  -->
        @if(auth()->user()->LastRehcarge)
        <div class="dashboard_sidebar_balance_lists d-flex flex-column w-100">
            <div class="dashboard_sidebar_balance_list d-flex align-items-center position-relative mb_20">
                <div class="dashboard_sidebar_balance_list_left flex-fill text-start">
                    <h5 class="font_14 f_w_500 mute_text ">{{__('wallet.last_transaction')}}</h5>
                    <p class="font_12 f_w_400 mute_text m-0 lh-1">{{date(app('general_setting')->dateFormat->format, strtotime(auth()->user()->LastRehcarge->created_at))}}</p>
                </div>
                <a href="#" class="amaz_badge_btn ">{{single_price(auth()->user()->LastRehcarge->amount)}}</a>
            </div>
        </div>
        @endif
        @if(url()->current() != url('/wallet/my-wallet-create'))
            <button data-bs-toggle="modal" data-bs-target="#recharge_wallet" class="recharge_wallet_btn d-flex align-items-center justify-content-center gap_10 w-100 dynamic_svg">
                <svg xmlns="http://www.w3.org/2000/svg" width="17.999" height="17.999" viewBox="0 0 17.999 17.999">
                    <path id="plus" d="M9,0a9,9,0,1,0,9,9A9.009,9.009,0,0,0,9,0ZM9,16.875A7.874,7.874,0,1,1,16.875,9,7.883,7.883,0,0,1,9,16.875ZM13.992,9a.562.562,0,0,1-.562.562H9.563V13.43a.562.562,0,0,1-1.125,0V9.563H4.571a.562.562,0,0,1,0-1.125H8.438V4.571a.562.562,0,1,1,1.125,0V8.438H13.43A.562.562,0,0,1,13.992,9Z" transform="translate(-0.001 -0.001)" fill="#fd4949"/>
                </svg>
                <span class="font_14 f_w_700 secondary_text text-uppercase">{{__('wallet.recharge_wallet')}}</span>
            </button>
        @endif
    </div>
    <!-- dashboard_sidebar_menuList -->
    <div class="dashboard_sidebar_menuList">
        <ul>
            <li>
                <a class="position-relative d-flex align-items-center " href="{{url('/profile/dashboard')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <g id="element-equal" transform="translate(-1.25 -1.25)">
                            <path id="Path_4124" data-name="Path 4124" d="M18.627,9.622H15.245A2.193,2.193,0,0,1,12.75,7.127V3.745A2.193,2.193,0,0,1,15.245,1.25h3.382a2.193,2.193,0,0,1,2.495,2.495V7.127A2.2,2.2,0,0,1,18.627,9.622ZM15.245,2.506c-.988,0-1.239.251-1.239,1.239V7.127c0,.988.251,1.239,1.239,1.239h3.382c.988,0,1.239-.251,1.239-1.239V3.745c0-.988-.251-1.239-1.239-1.239Z" transform="translate(-1.872 0)" fill="#fd4949"/>
                            <path id="Path_4125" data-name="Path 4125" d="M7.127,9.622H3.745c-1.683,0-2.495-.745-2.495-2.286v-3.8C1.25,2,2.07,1.25,3.745,1.25H7.127C8.81,1.25,9.622,2,9.622,3.536V7.328C9.622,8.877,8.8,9.622,7.127,9.622ZM3.745,2.506c-1.122,0-1.239.318-1.239,1.03V7.328c0,.72.117,1.03,1.239,1.03H7.127c1.122,0,1.239-.318,1.239-1.03V3.536c0-.72-.117-1.03-1.239-1.03Z" transform="translate(0 0)" fill="#fd4949"/>
                            <path id="Path_4126" data-name="Path 4126" d="M7.127,21.122H3.745A2.193,2.193,0,0,1,1.25,18.627V15.245A2.193,2.193,0,0,1,3.745,12.75H7.127a2.193,2.193,0,0,1,2.495,2.495v3.382A2.2,2.2,0,0,1,7.127,21.122ZM3.745,14.006c-.988,0-1.239.251-1.239,1.239v3.382c0,.988.251,1.239,1.239,1.239H7.127c.988,0,1.239-.251,1.239-1.239V15.245c0-.988-.251-1.239-1.239-1.239Z" transform="translate(0 -1.872)" fill="#fd4949"/>
                            <path id="Path_4127" data-name="Path 4127" d="M19.9,16.006H14.878a.628.628,0,1,1,0-1.256H19.9a.628.628,0,1,1,0,1.256Z" transform="translate(-2.116 -2.197)" fill="#fd4949"/>
                            <path id="Path_4128" data-name="Path 4128" d="M19.9,20.006H14.878a.628.628,0,1,1,0-1.256H19.9a.628.628,0,1,1,0,1.256Z" transform="translate(-2.116 -2.848)" fill="#fd4949"/>
                        </g>
                    </svg>
                {{__('common.dashboard')}}</a>
            </li>
            <li>
                <a class="position-relative d-flex align-items-center" href="{{route('frontend.my_purchase_histories')}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16.326" height="18" viewBox="0 0 16.326 18">
                <g  transform="translate(-2.25 -1.25)">
                    <path  data-name="Path 4129" d="M13.762,19.25h-6.7c-3.056,0-4.814-1.758-4.814-4.814V6.064c0-3.056,1.758-4.814,4.814-4.814h6.7c3.056,0,4.814,1.758,4.814,4.814v8.372C18.576,17.492,16.817,19.25,13.762,19.25ZM7.064,2.506c-2.394,0-3.558,1.164-3.558,3.558v8.372c0,2.394,1.164,3.558,3.558,3.558h6.7c2.394,0,3.558-1.164,3.558-3.558V6.064c0-2.394-1.164-3.558-3.558-3.558Z" transform="translate(0 0)" fill="#00124e"/>
                    <path  data-name="Path 4130" d="M8.8,9.515A1.037,1.037,0,0,1,7.75,8.476v-6.6a.633.633,0,0,1,.629-.629h5.868a.633.633,0,0,1,.629.629V8.467a1.025,1.025,0,0,1-.629.956,1.046,1.046,0,0,1-1.132-.193l-1.8-1.651-1.8,1.66A1.044,1.044,0,0,1,8.8,9.515Zm2.515-3.269a1.06,1.06,0,0,1,.713.277l1.593,1.467V2.507H9.007V7.989L10.6,6.523A1.06,1.06,0,0,1,11.313,6.246Z" transform="translate(-0.9)" fill="#00124e"/>
                    <path  data-name="Path 4131" d="M16.691,14.507H13.129a.629.629,0,0,1,0-1.257h3.563a.629.629,0,1,1,0,1.257Z" transform="translate(-1.673 -1.954)" fill="#00124e"/>
                    <path  data-name="Path 4132" d="M16,18.507H8.879a.629.629,0,0,1,0-1.257H16a.629.629,0,1,1,0,1.257Z" transform="translate(-0.983 -2.606)" fill="#00124e"/>
                </g>
                </svg>
                 {{__('amazy.Purchase History')}}</a>
            </li>
            <li>
                <a class="position-relative d-flex align-items-center" href="{{route('frontend.my-wishlist')}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16.326" height="18" viewBox="0 0 16.326 18">
                <g  transform="translate(-2.25 -1.25)">
                    <path  data-name="Path 4129" d="M13.762,19.25h-6.7c-3.056,0-4.814-1.758-4.814-4.814V6.064c0-3.056,1.758-4.814,4.814-4.814h6.7c3.056,0,4.814,1.758,4.814,4.814v8.372C18.576,17.492,16.817,19.25,13.762,19.25ZM7.064,2.506c-2.394,0-3.558,1.164-3.558,3.558v8.372c0,2.394,1.164,3.558,3.558,3.558h6.7c2.394,0,3.558-1.164,3.558-3.558V6.064c0-2.394-1.164-3.558-3.558-3.558Z" transform="translate(0 0)" fill="#00124e"/>
                    <path  data-name="Path 4130" d="M8.8,9.515A1.037,1.037,0,0,1,7.75,8.476v-6.6a.633.633,0,0,1,.629-.629h5.868a.633.633,0,0,1,.629.629V8.467a1.025,1.025,0,0,1-.629.956,1.046,1.046,0,0,1-1.132-.193l-1.8-1.651-1.8,1.66A1.044,1.044,0,0,1,8.8,9.515Zm2.515-3.269a1.06,1.06,0,0,1,.713.277l1.593,1.467V2.507H9.007V7.989L10.6,6.523A1.06,1.06,0,0,1,11.313,6.246Z" transform="translate(-0.9)" fill="#00124e"/>
                    <path  data-name="Path 4131" d="M16.691,14.507H13.129a.629.629,0,0,1,0-1.257h3.563a.629.629,0,1,1,0,1.257Z" transform="translate(-1.673 -1.954)" fill="#00124e"/>
                    <path  data-name="Path 4132" d="M16,18.507H8.879a.629.629,0,0,1,0-1.257H16a.629.629,0,1,1,0,1.257Z" transform="translate(-0.983 -2.606)" fill="#00124e"/>
                </g>
                </svg>
                {{__('customer_panel.my_wishlist')}}</a>
            </li>
            <li>
                <a class="position-relative d-flex align-items-center" href="{{ route('frontend.my_purchase_order_list') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18.121" height="18" viewBox="0 0 18.121 18">
                <path  d="M15.085,19.32a3.477,3.477,0,0,1-1.737-.565l-2.521-1.492a1.2,1.2,0,0,0-1.02,0L7.278,18.755c-1.492.885-2.369.531-2.765.244s-.995-1.02-.6-2.706l.6-2.588a1.19,1.19,0,0,0-.27-.936L2.152,10.679A2.289,2.289,0,0,1,1.334,8.3,2.316,2.316,0,0,1,3.383,6.843L6.073,6.4a1.206,1.206,0,0,0,.725-.54L8.29,2.88c.674-1.357,1.56-1.56,2.023-1.56s1.349.2,2.023,1.56l1.484,2.968a1.248,1.248,0,0,0,.733.54l2.689.447a2.291,2.291,0,0,1,2.049,1.459,2.324,2.324,0,0,1-.818,2.378l-2.091,2.1a1.213,1.213,0,0,0-.27.936l.6,2.588c.388,1.686-.211,2.42-.6,2.706A1.725,1.725,0,0,1,15.085,19.32Zm-4.772-3.44a2.308,2.308,0,0,1,1.155.3l2.521,1.492c.733.438,1.2.438,1.374.312s.3-.573.118-1.4l-.6-2.588a2.466,2.466,0,0,1,.607-2.116l2.091-2.091c.413-.413.6-.818.514-1.1s-.481-.506-1.054-.6l-2.689-.447A2.471,2.471,0,0,1,12.7,6.421L11.215,3.453c-.27-.54-.607-.86-.9-.86s-.632.32-.894.86L7.927,6.421A2.471,2.471,0,0,1,6.275,7.643L3.594,8.09c-.573.093-.961.32-1.054.6s.1.691.514,1.1l2.091,2.091a2.459,2.459,0,0,1,.607,2.116l-.6,2.588c-.194.835-.059,1.273.118,1.4s.632.118,1.374-.312l2.521-1.492A2.254,2.254,0,0,1,10.313,15.88Z" transform="translate(-1.25 -1.32)" fill="#00124e"/>
                </svg>
                {{__('order.my_order')}}</a>
            </li>
            <li>
                <a class="position-relative d-flex align-items-center" href="{{ route('frontend.purchased-gift-card') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17.998" viewBox="0 0 18 17.998">
                <g id="bag" transform="translate(-1.25 -1.254)">
                    <path id="Path_4133" data-name="Path 4133" d="M5.069,5.547a.642.642,0,0,1-.444-.184.632.632,0,0,1,0-.887L7.665,1.436a.628.628,0,0,1,.887.887L5.513,5.363A.658.658,0,0,1,5.069,5.547Z" transform="translate(-0.52)" fill="#00124e"/>
                    <path id="Path_4134" data-name="Path 4134" d="M18.1,5.547a.621.621,0,0,1-.444-.184L14.614,2.323a.628.628,0,0,1,.887-.887L18.54,4.475a.632.632,0,0,1,0,.887A.642.642,0,0,1,18.1,5.547Z" transform="translate(-2.146)" fill="#00124e"/>
                    <path id="Path_4135" data-name="Path 4135" d="M17.124,9.706H3.552a2.255,2.255,0,0,1-1.741-.477A2.433,2.433,0,0,1,1.25,7.4c0-2.3,1.683-2.3,2.487-2.3H16.764c.8,0,2.487,0,2.487,2.3a2.421,2.421,0,0,1-.561,1.825A2.076,2.076,0,0,1,17.124,9.706ZM3.737,8.45h13.22c.377.008.728.008.846-.109.059-.059.184-.26.184-.938,0-.946-.234-1.047-1.231-1.047H3.737c-1,0-1.231.1-1.231,1.047,0,.678.134.879.184.938a1.685,1.685,0,0,0,.846.109Z" transform="translate(0 -0.626)" fill="#00124e"/>
                    <path id="Path_4136" data-name="Path 4136" d="M9.638,17.478a.632.632,0,0,1-.628-.628V13.878a.628.628,0,0,1,1.256,0V16.85A.627.627,0,0,1,9.638,17.478Z" transform="translate(-1.263 -1.953)" fill="#00124e"/>
                    <path id="Path_4137" data-name="Path 4137" d="M14.237,17.478a.632.632,0,0,1-.628-.628V13.878a.628.628,0,0,1,1.256,0V16.85A.627.627,0,0,1,14.237,17.478Z" transform="translate(-2.012 -1.953)" fill="#00124e"/>
                    <path id="Path_4138" data-name="Path 4138" d="M12.915,20.553H7.866c-3,0-3.667-1.783-3.927-3.332L2.759,9.979A.628.628,0,0,1,4,9.778l1.18,7.234c.243,1.482.745,2.286,2.688,2.286h5.048c2.152,0,2.394-.754,2.671-2.21l1.407-7.326A.627.627,0,0,1,18.223,10L16.816,17.33C16.49,19.029,15.945,20.553,12.915,20.553Z" transform="translate(-0.244 -1.302)" fill="#00124e"/>
                </g>
                </svg>
                {{__('marketing.giftcard')}}</a>
            </li>
            <li>
                <a class="position-relative d-flex align-items-center {{ request()->is('wallet/*') ?'active' : '' }}" href="{{route('my-wallet.index', 'customer')}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18.002" viewBox="0 0 18 18.002">
                <g  transform="translate(-1.25 -1.254)">
                    <path  data-name="Path 4166" d="M14.436,20.068H6.064A4.558,4.558,0,0,1,1.25,15.253V11.065A4.518,4.518,0,0,1,5.31,6.309a5.391,5.391,0,0,1,.753-.059h8.372a4.764,4.764,0,0,1,.728.05,4.514,4.514,0,0,1,4.086,4.765v4.187A4.558,4.558,0,0,1,14.436,20.068ZM6.064,7.506a4.489,4.489,0,0,0-.586.042,3.286,3.286,0,0,0-2.972,3.517v4.187a3.336,3.336,0,0,0,3.558,3.559h8.372a3.336,3.336,0,0,0,3.558-3.559V11.065A3.288,3.288,0,0,0,14.989,7.54a3.2,3.2,0,0,0-.553-.034Z" transform="translate(0 -0.812)" fill="#00124e"/>
                    <path  data-name="Path 4167" d="M6.069,6.746a.631.631,0,0,1-.511-.26.616.616,0,0,1-.05-.653,3.008,3.008,0,0,1,.6-.812l2.72-2.73a3.581,3.581,0,0,1,5.039,0l1.465,1.482a3.478,3.478,0,0,1,1.038,2.3.63.63,0,0,1-.209.5.623.623,0,0,1-.519.151,3.564,3.564,0,0,0-.527-.033H6.747a4.488,4.488,0,0,0-.586.042A.314.314,0,0,1,6.069,6.746Zm1.4-1.306h7.5a2.23,2.23,0,0,0-.519-.779L12.975,3.17a2.334,2.334,0,0,0-3.264,0Z" transform="translate(-0.681)" fill="#00124e"/>
                    <path  data-name="Path 4168" d="M21.065,16.356H18.553a2.3,2.3,0,0,1,0-4.606h2.512a.628.628,0,1,1,0,1.256H18.553a1.047,1.047,0,0,0,0,2.094h2.512a.628.628,0,1,1,0,1.256Z" transform="translate(-2.443 -1.706)" fill="#00124e"/>
                </g>
                </svg>
                {{__('wallet.my_wallet')}}</a>
            </li>
            <li>
                <a class="position-relative d-flex align-items-center" href="{{url('/profile/coupons')}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="17.167" height="18.001" viewBox="0 0 17.167 18.001">
                <g id="gift" transform="translate(-1.75 -1.254)">
                    <path id="Path_4154" data-name="Path 4154" d="M13.9,20.555H7.2c-2.864,0-3.978-1.114-3.978-3.978v-6.7a.633.633,0,0,1,.628-.628h13.4a.633.633,0,0,1,.628.628v6.7C17.873,19.441,16.759,20.555,13.9,20.555ZM4.475,10.506v6.071c0,2.16.561,2.722,2.722,2.722h6.7c2.16,0,2.721-.561,2.721-2.722V10.506Z" transform="translate(-0.239 -1.3)" fill="#00124e"/>
                    <path id="Path_4155" data-name="Path 4155" d="M16.614,9.693H4.053a2.094,2.094,0,0,1-2.3-2.3V6.553a2.094,2.094,0,0,1,2.3-2.3H16.614a2.134,2.134,0,0,1,2.3,2.3V7.39A2.134,2.134,0,0,1,16.614,9.693ZM4.053,5.506c-.762,0-1.047.285-1.047,1.047V7.39c0,.762.285,1.047,1.047,1.047H16.614c.737,0,1.047-.31,1.047-1.047V6.553c0-.737-.31-1.047-1.047-1.047Z" transform="translate(0 -0.487)" fill="#00124e"/>
                    <path id="Path_4156" data-name="Path 4156" d="M10.58,5.018H5.957a.633.633,0,0,1-.461-.2,1.419,1.419,0,0,1,.042-1.959L6.728,1.668a1.435,1.435,0,0,1,2.018,0l2.278,2.278a.631.631,0,0,1,.134.687A.612.612,0,0,1,10.58,5.018ZM6.418,3.762H9.073L7.858,2.556a.172.172,0,0,0-.243,0L6.426,3.745C6.426,3.754,6.418,3.754,6.418,3.762Z" transform="translate(-0.549)" fill="#00124e"/>
                    <path id="Path_4157" data-name="Path 4157" d="M16.851,5.018H12.228a.62.62,0,0,1-.578-.385.634.634,0,0,1,.134-.687l2.278-2.278a1.435,1.435,0,0,1,2.018,0l1.189,1.189a1.411,1.411,0,0,1,.042,1.959A.633.633,0,0,1,16.851,5.018Zm-3.1-1.256h2.655l-.017-.017L15.2,2.556a.172.172,0,0,0-.243,0Z" transform="translate(-1.602)" fill="#00124e"/>
                    <path id="Path_4158" data-name="Path 4158" d="M9.657,15.656a1.467,1.467,0,0,1-1.465-1.465V9.878a.633.633,0,0,1,.628-.628h5.058a.633.633,0,0,1,.628.628v4.3a1.462,1.462,0,0,1-2.278,1.214l-.745-.5a.2.2,0,0,0-.234,0l-.787.519A1.424,1.424,0,0,1,9.657,15.656Zm-.209-5.15v3.676a.211.211,0,0,0,.327.176l.787-.519a1.455,1.455,0,0,1,1.616,0l.745.5a.211.211,0,0,0,.327-.176V10.5h-3.8Z" transform="translate(-1.047 -1.3)" fill="#00124e"/>
                </g>
                </svg>
                {{__('customer_panel.my_coupons')}}</a>
            </li>
            <li>
                <a class="position-relative d-flex align-items-center" href="{{route('refund.frontend.index')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18.002" viewBox="0 0 18 18.002">
                    <g  transform="translate(-1.25 -1.254)">
                        <path  data-name="Path 4166" d="M14.436,20.068H6.064A4.558,4.558,0,0,1,1.25,15.253V11.065A4.518,4.518,0,0,1,5.31,6.309a5.391,5.391,0,0,1,.753-.059h8.372a4.764,4.764,0,0,1,.728.05,4.514,4.514,0,0,1,4.086,4.765v4.187A4.558,4.558,0,0,1,14.436,20.068ZM6.064,7.506a4.489,4.489,0,0,0-.586.042,3.286,3.286,0,0,0-2.972,3.517v4.187a3.336,3.336,0,0,0,3.558,3.559h8.372a3.336,3.336,0,0,0,3.558-3.559V11.065A3.288,3.288,0,0,0,14.989,7.54a3.2,3.2,0,0,0-.553-.034Z" transform="translate(0 -0.812)" fill="#00124e"/>
                        <path  data-name="Path 4167" d="M6.069,6.746a.631.631,0,0,1-.511-.26.616.616,0,0,1-.05-.653,3.008,3.008,0,0,1,.6-.812l2.72-2.73a3.581,3.581,0,0,1,5.039,0l1.465,1.482a3.478,3.478,0,0,1,1.038,2.3.63.63,0,0,1-.209.5.623.623,0,0,1-.519.151,3.564,3.564,0,0,0-.527-.033H6.747a4.488,4.488,0,0,0-.586.042A.314.314,0,0,1,6.069,6.746Zm1.4-1.306h7.5a2.23,2.23,0,0,0-.519-.779L12.975,3.17a2.334,2.334,0,0,0-3.264,0Z" transform="translate(-0.681)" fill="#00124e"/>
                        <path  data-name="Path 4168" d="M21.065,16.356H18.553a2.3,2.3,0,0,1,0-4.606h2.512a.628.628,0,1,1,0,1.256H18.553a1.047,1.047,0,0,0,0,2.094h2.512a.628.628,0,1,1,0,1.256Z" transform="translate(-2.443 -1.706)" fill="#00124e"/>
                    </g>
                    </svg>
                    {{__('customer_panel.refund_dispute')}}</a>
            </li>
            <li>
                <a class="position-relative d-flex align-items-center" href="{{url('/profile')}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18.005" height="18" viewBox="0 0 18.005 18">
                <g id="profile-circle" transform="translate(-1.25 -1.25)">
                    <path id="Path_4163" data-name="Path 4163" d="M11.447,12.222h-.142a3.341,3.341,0,1,1,.167,0Zm-.1-5.494a2.12,2.12,0,0,0-.084,4.237.7.7,0,0,1,.193,0,2.12,2.12,0,0,0-.109-4.237Z" transform="translate(-1.094 -0.689)" fill="#00124e"/>
                    <path id="Path_4164" data-name="Path 4164" d="M10.783,21.441a8.969,8.969,0,0,1-6.071-2.362.632.632,0,0,1-.2-.528,3.692,3.692,0,0,1,1.759-2.613,8.813,8.813,0,0,1,9.028,0,3.708,3.708,0,0,1,1.759,2.613.6.6,0,0,1-.2.528A8.969,8.969,0,0,1,10.783,21.441ZM5.825,18.384a7.726,7.726,0,0,0,9.915,0,2.722,2.722,0,0,0-1.147-1.407,7.578,7.578,0,0,0-7.629,0A2.7,2.7,0,0,0,5.825,18.384Z" transform="translate(-0.53 -2.191)" fill="#00124e"/>
                    <path id="Path_4165" data-name="Path 4165" d="M10.252,19.25a9,9,0,1,1,9-9A9.009,9.009,0,0,1,10.252,19.25Zm0-16.744A7.744,7.744,0,1,0,18,10.25,7.754,7.754,0,0,0,10.252,2.506Z" fill="#00124e"/>
                </g>
                </svg>
                {{__('customer_panel.my_account')}}</a>
            </li>
            <li>
                <a class="position-relative d-flex align-items-center" href="{{ route('frontend.digital_product') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="17.607" height="17.999" viewBox="0 0 17.607 17.999">
                <g id="wallet-minus" transform="translate(-1.488 -1.25)">
                    <path id="Path_4142" data-name="Path 4142" d="M13.564,16.506H9.378a.628.628,0,0,1,0-1.256h4.186a.628.628,0,0,1,0,1.256Z" transform="translate(-1.183 -2.28)" fill="#00124e"/>
                    <path id="Path_4143" data-name="Path 4143" d="M5.08,8.96a.658.658,0,0,1-.444-.184A.63.63,0,0,1,4.5,8.089L6.059,4.373a1.806,1.806,0,0,1,.075-.167C7.374,1.35,8.956.656,11.752,1.727a.616.616,0,0,1,.352.343.632.632,0,0,1,0,.494L9.651,8.257a.635.635,0,0,1-.578.377H6.687a3.457,3.457,0,0,0-1.365.276A.6.6,0,0,1,5.08,8.96ZM9.609,2.506c-1.038,0-1.674.678-2.336,2.218-.008.025-.025.05-.033.075l-1.1,2.6c.184-.017.36-.025.544-.025H8.654L10.672,2.69A3.506,3.506,0,0,0,9.609,2.506Z" transform="translate(-0.483)" fill="#00124e"/>
                    <path id="Path_4144" data-name="Path 4144" d="M16.811,8.886a.7.7,0,0,1-.184-.025,3.553,3.553,0,0,0-1-.142H9.846a.641.641,0,0,1-.527-.285.65.65,0,0,1-.05-.594L11.7,2.205a.688.688,0,0,1,.8-.4c.1.033.193.075.293.117l1.976.829A6.059,6.059,0,0,1,17.2,4.332a2.674,2.674,0,0,1,.26.368,2.241,2.241,0,0,1,.234.494,1.625,1.625,0,0,1,.092.285A4.651,4.651,0,0,1,17.4,8.5.64.64,0,0,1,16.811,8.886ZM10.8,7.463h4.83a4.91,4.91,0,0,1,.787.067,2.982,2.982,0,0,0,.151-1.741c-.017-.075-.033-.109-.042-.142A1.493,1.493,0,0,0,16.4,5.37a1.77,1.77,0,0,0-.167-.243A4.9,4.9,0,0,0,14.292,3.9L12.634,3.21Z" transform="translate(-1.259 -0.086)" fill="#00124e"/>
                    <path id="Path_4145" data-name="Path 4145" d="M13.555,20.441H7.025a5.752,5.752,0,0,1-.67-.042,4.724,4.724,0,0,1-4.814-4.847,4.868,4.868,0,0,1-.042-.636V13.284A4.7,4.7,0,0,1,6.213,8.57h8.171a4.56,4.56,0,0,1,1.365.2A4.751,4.751,0,0,1,19.1,13.284v1.632c0,.184-.008.36-.017.527C18.9,18.717,16.987,20.441,13.555,20.441ZM6.2,9.826a3.445,3.445,0,0,0-3.457,3.457v1.632c0,.176.017.352.033.519.159,2.386,1.331,3.558,3.684,3.717a4.54,4.54,0,0,0,.553.042h6.53c2.763,0,4.119-1.214,4.253-3.809.008-.151.017-.3.017-.469V13.284a3.5,3.5,0,0,0-2.453-3.315,3.552,3.552,0,0,0-1-.142Z" transform="translate(-0.002 -1.192)" fill="#00124e"/>
                    <path id="Path_4146" data-name="Path 4146" d="M2.116,13.3a.632.632,0,0,1-.628-.628V10.216A5.517,5.517,0,0,1,5.934,4.8a.652.652,0,0,1,.611.218.626.626,0,0,1,.092.636l-1.465,3.5a.67.67,0,0,1-.326.335,3.468,3.468,0,0,0-2.093,3.181A.64.64,0,0,1,2.116,13.3ZM4.929,6.491A4.274,4.274,0,0,0,2.836,9.379,4.57,4.57,0,0,1,4.117,8.45Z" transform="translate(0 -0.576)" fill="#00124e"/>
                    <path id="Path_4147" data-name="Path 4147" d="M21.075,13.386a.632.632,0,0,1-.628-.628,3.5,3.5,0,0,0-2.453-3.315.622.622,0,0,1-.4-.829,3.545,3.545,0,0,0,.335-2.244c-.017-.075-.033-.109-.042-.142a.629.629,0,0,1,.142-.712.622.622,0,0,1,.72-.1A5.5,5.5,0,0,1,21.7,10.3v2.453A.632.632,0,0,1,21.075,13.386Zm-2.1-4.906a4.591,4.591,0,0,1,1.39,1,4.2,4.2,0,0,0-1.13-2.152A6.213,6.213,0,0,1,18.974,8.48Z" transform="translate(-2.615 -0.667)" fill="#00124e"/>
                </g>
                </svg>
                {{__('customer_panel.digital_products')}}</a>
            </li>
            <li>
                <a class="position-relative d-flex align-items-center" href="{{url('/profile/referral')}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="17.431" height="18" viewBox="0 0 17.431 18">
                <g id="profile-2user" transform="translate(-1.602 -1.25)">
                    <path id="Path_4169" data-name="Path 4169" d="M8.33,10.014H8.262a.459.459,0,0,0-.152,0,4.348,4.348,0,1,1,.245,0Zm-.135-7.5a3.115,3.115,0,0,0-.118,6.228,1.407,1.407,0,0,1,.27,0,3.116,3.116,0,0,0-.152-6.228Z" transform="translate(-0.342)" fill="#00124e"/>
                    <path id="Path_4170" data-name="Path 4170" d="M16.389,10.433a.234.234,0,0,1-.076-.008.669.669,0,0,1-.735-.558.616.616,0,0,1,.524-.7c.1-.008.211-.008.3-.008a2.326,2.326,0,0,0-.127-4.648.626.626,0,0,1-.634-.625.638.638,0,0,1,.634-.634,3.593,3.593,0,0,1,.135,7.183Z" transform="translate(-2.164 -0.31)" fill="#00124e"/>
                    <path id="Path_4171" data-name="Path 4171" d="M8,20.984a8.348,8.348,0,0,1-4.58-1.268,3.626,3.626,0,0,1-1.817-3A3.664,3.664,0,0,1,3.419,13.7a8.948,8.948,0,0,1,9.161,0,3.646,3.646,0,0,1,1.817,3,3.664,3.664,0,0,1-1.817,3.017A8.368,8.368,0,0,1,8,20.984ZM4.12,14.764a2.43,2.43,0,0,0-1.251,1.961A2.425,2.425,0,0,0,4.12,18.668a7.637,7.637,0,0,0,7.758,0,2.43,2.43,0,0,0,1.251-1.961,2.425,2.425,0,0,0-1.251-1.944A7.677,7.677,0,0,0,4.12,14.764Z" transform="translate(0 -1.733)" fill="#00124e"/>
                    <path id="Path_4172" data-name="Path 4172" d="M18.223,19.587a.624.624,0,0,1-.617-.507.642.642,0,0,1,.49-.752,3.423,3.423,0,0,0,1.4-.617,1.508,1.508,0,0,0,.008-2.594,3.538,3.538,0,0,0-1.386-.617.637.637,0,1,1,.279-1.242,4.716,4.716,0,0,1,1.876.845,2.906,2.906,0,0,1,1.234,2.307,2.943,2.943,0,0,1-1.242,2.316,4.577,4.577,0,0,1-1.91.845A.4.4,0,0,1,18.223,19.587Z" transform="translate(-2.477 -1.858)" fill="#00124e"/>
                </g>
                </svg>
                    {{__('common.referral')}}</a>
            </li>
            <li>
                <a class="position-relative d-flex align-items-center {{ request()->is('support-ticket/*') ?'active' : '' }}" href="{{url('/support-ticket')}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17.999" viewBox="0 0 18 17.999">
                <g id="like-1" transform="translate(-1.631 -1.898)">
                    <path id="Path_4173" data-name="Path 4173" d="M14.96,19.9H11.692a3.209,3.209,0,0,1-2.09-.731L7,17.082l.791-1.06,2.666,2.138a2.009,2.009,0,0,0,1.238.392H14.96a1.96,1.96,0,0,0,1.78-1.363l2.081-6.548a1.094,1.094,0,0,0-.069-1.007A1.117,1.117,0,0,0,17.8,9.2h-3.44a1.484,1.484,0,0,1-1.144-.535,1.63,1.63,0,0,1-.353-1.292l.43-2.86A1.114,1.114,0,0,0,12.6,3.29a1.071,1.071,0,0,0-1.152.356L7.926,9.081,6.859,8.342l3.526-5.435a2.3,2.3,0,0,1,2.657-.873,2.426,2.426,0,0,1,1.522,2.735l-.421,2.806a.279.279,0,0,0,.052.223.236.236,0,0,0,.172.071h3.44a2.365,2.365,0,0,1,2,1,2.447,2.447,0,0,1,.232,2.21l-2.055,6.486A3.223,3.223,0,0,1,14.96,19.9Z" transform="translate(-0.57 0)" fill="#00124e"/>
                    <path id="Path_4174" data-name="Path 4174" d="M4.972,19.352H4.081c-1.648,0-2.45-.775-2.45-2.361V8.259c0-1.586.8-2.361,2.45-2.361h.891c1.648,0,2.45.775,2.45,2.361v8.731C7.422,18.577,6.62,19.352,4.972,19.352ZM4.081,7.235c-.971,0-1.114.232-1.114,1.025v8.731c0,.793.143,1.025,1.114,1.025h.891c.971,0,1.114-.232,1.114-1.025V8.259c0-.793-.143-1.025-1.114-1.025Z" transform="translate(0 -0.436)" fill="#00124e"/>
                </g>
                </svg>
                {{__('ticket.support_ticket')}}</a>
            </li>
            @if(isModuleActive('MultiVendor'))
                <li>
                    <a class="position-relative d-flex align-items-center" href="{{route('frontend.profile.follow-customer')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17.999" viewBox="0 0 18 17.999">
                    <g id="like-1" transform="translate(-1.631 -1.898)">
                        <path id="Path_4173" data-name="Path 4173" d="M14.96,19.9H11.692a3.209,3.209,0,0,1-2.09-.731L7,17.082l.791-1.06,2.666,2.138a2.009,2.009,0,0,0,1.238.392H14.96a1.96,1.96,0,0,0,1.78-1.363l2.081-6.548a1.094,1.094,0,0,0-.069-1.007A1.117,1.117,0,0,0,17.8,9.2h-3.44a1.484,1.484,0,0,1-1.144-.535,1.63,1.63,0,0,1-.353-1.292l.43-2.86A1.114,1.114,0,0,0,12.6,3.29a1.071,1.071,0,0,0-1.152.356L7.926,9.081,6.859,8.342l3.526-5.435a2.3,2.3,0,0,1,2.657-.873,2.426,2.426,0,0,1,1.522,2.735l-.421,2.806a.279.279,0,0,0,.052.223.236.236,0,0,0,.172.071h3.44a2.365,2.365,0,0,1,2,1,2.447,2.447,0,0,1,.232,2.21l-2.055,6.486A3.223,3.223,0,0,1,14.96,19.9Z" transform="translate(-0.57 0)" fill="#00124e"/>
                        <path id="Path_4174" data-name="Path 4174" d="M4.972,19.352H4.081c-1.648,0-2.45-.775-2.45-2.361V8.259c0-1.586.8-2.361,2.45-2.361h.891c1.648,0,2.45.775,2.45,2.361v8.731C7.422,18.577,6.62,19.352,4.972,19.352ZM4.081,7.235c-.971,0-1.114.232-1.114,1.025v8.731c0,.793.143,1.025,1.114,1.025h.891c.971,0,1.114-.232,1.114-1.025V8.259c0-.793-.143-1.025-1.114-1.025Z" transform="translate(0 -0.436)" fill="#00124e"/>
                    </g>
                    </svg>
                    {{__('common.follow')}}</a>
                </li>
            @endif
            <li>
                <span class="amazy_bb2 d-block"></span>
            </li>
            <li>
                <a class="position-relative d-flex align-items-center" href="{{route('frontend.notifications')}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="14.593" height="18" viewBox="0 0 14.593 18">
                <g id="notification" transform="translate(-3.227 -1.18)">
                    <path id="Path_4148" data-name="Path 4148" d="M10.545,17.452a18.038,18.038,0,0,1-5.717-.924,2.315,2.315,0,0,1-1.465-1.373,2.248,2.248,0,0,1,.225-1.981l.957-1.59a3.369,3.369,0,0,0,.383-1.39V7.789a5.618,5.618,0,0,1,11.235,0v2.405a3.478,3.478,0,0,0,.383,1.4l.949,1.581a2.3,2.3,0,0,1,.183,1.981,2.264,2.264,0,0,1-1.423,1.373A17.949,17.949,0,0,1,10.545,17.452Zm0-14.031A4.374,4.374,0,0,0,6.175,7.789v2.405a4.694,4.694,0,0,1-.558,2.031l-.957,1.59a1.034,1.034,0,0,0-.125.907,1.053,1.053,0,0,0,.691.616,16.644,16.644,0,0,0,10.644,0,1.016,1.016,0,0,0,.641-.624,1.037,1.037,0,0,0-.083-.9l-.957-1.59a4.677,4.677,0,0,1-.558-2.039v-2.4A4.369,4.369,0,0,0,10.545,3.42Z" transform="translate(0 -0.166)" fill="#00124e"/>
                    <path id="Path_4149" data-name="Path 4149" d="M13.133,3.477a.634.634,0,0,1-.175-.025,5.865,5.865,0,0,0-.7-.15,4.866,4.866,0,0,0-2.031.15.62.62,0,0,1-.757-.824,2.279,2.279,0,0,1,4.244,0,.635.635,0,0,1-.117.649A.643.643,0,0,1,13.133,3.477Z" transform="translate(-1.04)" fill="#00124e"/>
                    <path id="Path_4150" data-name="Path 4150" d="M11.39,22.179A3.126,3.126,0,0,1,8.27,19.059H9.518a1.873,1.873,0,1,0,3.745,0h1.248A3.122,3.122,0,0,1,11.39,22.179Z" transform="translate(-0.846 -2.999)" fill="#00124e"/>
                </g>
                </svg>
                {{__('common.notification')}}</a>
            </li>
            <li>
                <a class="position-relative d-flex align-items-center log_out" href="{{ route('logout') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16.472" height="18" viewBox="0 0 16.472 18">
                <g id="user-octagon" transform="translate(-2.16 -1.246)">
                    <path id="Path_4175" data-name="Path 4175" d="M10.4,19.246a3.246,3.246,0,0,1-1.632-.435L3.792,15.94A3.286,3.286,0,0,1,2.16,13.111V7.385A3.286,3.286,0,0,1,3.792,4.556L8.764,1.686a3.251,3.251,0,0,1,3.264,0L17,4.556a3.286,3.286,0,0,1,1.632,2.829v5.725A3.286,3.286,0,0,1,17,15.94l-4.972,2.871A3.246,3.246,0,0,1,10.4,19.246Zm0-16.74a2.052,2.052,0,0,0-1,.268L4.42,5.645a2.014,2.014,0,0,0-1,1.741v5.725a2.024,2.024,0,0,0,1,1.741l4.972,2.871a2,2,0,0,0,2.009,0l4.972-2.871a2.014,2.014,0,0,0,1-1.741V7.385a2.024,2.024,0,0,0-1-1.741L11.4,2.774A2.052,2.052,0,0,0,10.4,2.506Z" fill="#00124e"/>
                    <path id="Path_4176" data-name="Path 4176" d="M11.5,10.746a2.578,2.578,0,1,1,2.578-2.578A2.579,2.579,0,0,1,11.5,10.746Zm0-3.9a1.322,1.322,0,1,0,1.322,1.322A1.325,1.325,0,0,0,11.5,6.845Z" transform="translate(-1.102 -0.708)" fill="#00124e"/>
                    <path id="Path_4177" data-name="Path 4177" d="M14.574,16.633A.632.632,0,0,1,13.946,16c0-1.155-1.222-2.1-2.72-2.1s-2.72.946-2.72,2.1A.628.628,0,0,1,7.25,16c0-1.85,1.783-3.356,3.976-3.356S15.2,14.155,15.2,16A.632.632,0,0,1,14.574,16.633Z" transform="translate(-0.83 -1.859)" fill="#00124e"/>
                </g>
                </svg>
                {{__('defaultTheme.log_out')}}</a>
            </li>
        </ul>
    </div>
    @include(theme('pages.profile.wallets.components._recharge_modal'))
</div>