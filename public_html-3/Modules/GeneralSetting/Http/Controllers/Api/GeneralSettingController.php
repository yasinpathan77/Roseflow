<?php

namespace Modules\GeneralSetting\Http\Controllers\Api;

use App\Models\User;
use App\Traits\Otp;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Modules\GeneralSetting\Repositories\CurrencyRepository;
use Modules\GeneralSetting\Transformers\OTPConfigurationResource;
use Modules\Language\Repositories\LanguageRepository;
use Modules\Otp\Entities\OtpConfiguration;
use Modules\Shipping\Entities\PickupLocation;
use Modules\Shipping\Entities\ShippingMethod;

/**
* @group General Setting
*
* APIs for General Setting
*/
class GeneralSettingController extends Controller
{
    use Otp;

    protected $languageRepo;

    public function __construct(LanguageRepository $languageRepo)
    {
        $this->languageRepo = $languageRepo;
    }

    /**
     * Settings info
     * @response{
     *      "settings": [
     *           {
     *               "site_title": "Amaz cart",
     *               "company_name": "Amaz cart",
     *               "country_name": "BD",
     *               "zip_code": "1200",
     *               "address": "Panthapath",
     *               "phone": "0187595662",
     *               "email": "amazcart@spondonit.com",
     *               "currency_symbol": "$",
     *               "logo": "uploads/settings/6127358234608.png",
     *               "favicon": "uploads/settings/6127304e2f2b6.png",
     *               "currency_code": "USD",
     *               "copyright_text": "Copyright © 2019 - 2020 All rights reserved | This application is made by <a href=\"https://codecanyon.net/user/codethemes\">Codethemes</a>",
     *               "language_code": "en"
     *           }
     *       ],
     *       "msg": "success"
     * }
     */
    public function index(){
        $settings = DB::table('general_settings')->select('site_title', 'company_name','country_name', 'zip_code','address','phone','email','currency_symbol','currency_symbol_position','logo','favicon','currency_code','copyright_text','language_code','country_id','state_id','city_id')->first();
        $currencyRepo = new CurrencyRepository();
        $currencies = $currencyRepo->getActiveAll();
        $languages = $this->languageRepo->getActiveAll();
        $vendorType = 'single';
        $otp_configuration = "";
        $pickup_locations = "";
        $free_shipping = "";
        if(isModuleActive('Otp')){
            $otp_config = OtpConfiguration::whereIn('key', ['code_validation_time', 'otp_activation_for_seller', 'otp_activation_for_customer', 'otp_activation_for_order','order_otp_on_verified_customer','order_cancel_limit_on_verified_customer','otp_on_login','otp_on_password_reset'])->get();
            $otp_configuration = OTPConfigurationResource::collection($otp_config);
        }
        if(isModuleActive('MultiVendor')){
            $vendorType = 'multi';
        }
        /*else{
            $free_shipping = ShippingMethod::where('request_by_user', 1)->where('id', '>', 1)->where('cost', 0)->orderBy('minimum_shopping')->first();
            $pickup_locations = PickupLocation::select(['id','pickup_location','name','email','phone','address','address_2','city_id','state_id','country_id','pin_code','status','is_default'])->where('created_by', 1)->where('status', 1)->get();
        }*/

        $free_shipping = ShippingMethod::where('request_by_user', 1)->where('id', '>', 1)->where('cost', 0)->orderBy('minimum_shopping')->first();
        $pickup_locations = PickupLocation::select(['id','pickup_location','name','email','phone','address','address_2','city_id','state_id','country_id','pin_code','status','is_default'])->where('created_by', 1)->where('status', 1)->get();

        $modules = [
            'MultiVendor' => isModuleActive('MultiVendor'),
            'OTP' => isModuleActive('Otp'),
            'AmazonS3' => isModuleActive('AmazonS3'),
            'Affiliate' => isModuleActive('Affiliate'),
            'Bkash' => isModuleActive('Bkash'),
            'SslCommerz' => isModuleActive('SslCommerz'),
            'MercadoPago' => isModuleActive('MercadoPago'),
            'ShipRocket' => isModuleActive('ShipRocket'),
            'Lead' => isModuleActive('Lead'),
            'GoldPrice' => isModuleActive('GoldPrice'),
            'WholeSale' => isModuleActive('WholeSale'),
            'GoogleMerchantCenter' => isModuleActive('GoogleMerchantCenter'),
        ];

        //Replace null to double quotes
        /*$tmp_pickup_locations = (array)$pickup_locations->toArray();
        foreach($tmp_pickup_locations as $k=>$v){
            $a = array_map(function($k1) {
                return ($k1 == null) ? "" : $k1 ;
            },$v);
            unset($pickup_locations[$k]);
            $pickup_locations[$k] = (object) $a;
        }
        
        $tmp_free_shipping = (array)$free_shipping->toArray();
        $a = array_map(function($k1) {
            return ($k1 == null) ? "" : $k1 ;
        },$tmp_free_shipping);
        unset($free_shipping);
        $free_shipping = (object) $a;
        */
        //End Replace null to double quotes
        
        //Convert datatype
        if(isset($settings->country_id) && !empty($settings->country_id)){
            $settings->country_id = (string) $settings->country_id;
        }
        
        if(isset($settings->state_id) && !empty($settings->state_id)){
            $settings->state_id = (string) $settings->state_id;
        }
        
        if(isset($settings->city_id) && !empty($settings->city_id)){
            $settings->city_id = (string) $settings->city_id;
        }
        
        if(isset($currencies) && !empty($currencies)){
            foreach($currencies as $k=>$v){
                $currencies[$k]->status = (string) $currencies[$k]->status;
                $currencies[$k]->convert_rate = (string) $currencies[$k]->convert_rate;
            }
        }
        
        if(isset($languages) && !empty($languages)){
            foreach($languages as $k=>$v){
                $languages[$k]->rtl = (string) $languages[$k]->rtl;
                $languages[$k]->status = (string) $languages[$k]->status;
                $languages[$k]->json_exist = (string) $languages[$k]->json_exist;
            }
        }
        
        if(isset($pickup_locations) && !empty($pickup_locations)){
            foreach($pickup_locations as $k=>$v){
                $pickup_locations[$k]->address_2 = (string) (($v->address_2 !== null) ? $pickup_locations[$k]->address_2 : "");
                $pickup_locations[$k]->city_id = (string) $pickup_locations[$k]->city_id;
                $pickup_locations[$k]->state_id = (string) $pickup_locations[$k]->state_id;
                $pickup_locations[$k]->country_id = (string) $pickup_locations[$k]->country_id;
                $pickup_locations[$k]->pin_code = (string) $pickup_locations[$k]->pin_code;
                $pickup_locations[$k]->status = (string) $pickup_locations[$k]->status;
                $pickup_locations[$k]->is_default = (string) $pickup_locations[$k]->is_default;
            }
        }
        
        if(isset($free_shipping) && !empty($free_shipping)){
            
            $free_shipping->logo = (string) (($free_shipping->logo !== null) ? $free_shipping->logo : "");
            $free_shipping->carrier_id = (string) $free_shipping->carrier_id;
            $free_shipping->cost = (string) $free_shipping->cost;
            $free_shipping->minimum_shopping = (string) $free_shipping->minimum_shopping;
            $free_shipping->is_active = (string) $free_shipping->is_active;
            $free_shipping->request_by_user = (string) $free_shipping->request_by_user;
            $free_shipping->is_approved = (string) $free_shipping->is_approved;
        }
        
        //End convert datatype

        return response()->json([
            'settings' => $settings,
            'currencies' => $currencies,
            'languages' => $languages,
            'vendorType' => $vendorType,
            'otp_configuration' => $otp_configuration,
            'pickup_locations' => $pickup_locations,
            'free_shipping' => $free_shipping,
            'modules' => $modules,
            'msg' => 'success'
        ]);
    }

    /**
     * Languages
     * @response{
     *      "languages": [
     *           {
     *               "id": 3,
     *               "code": "ar",
     *               "name": "Arabic",
     *               "native": "العربية",
     *               "rtl": 1,
     *               "status": 1,
     *               "json_exist": 0,
     *               "created_at": null,
     *               "updated_at": null
     *           },
     *           {
     *               "id": 5,
     *               "code": "az",
     *               "name": "Azerbaijani",
     *               "native": "Azərbaycanca / آذربايجان",
     *               "rtl": 0,
     *               "status": 1,
     *               "json_exist": 0,
     *               "created_at": null,
     *               "updated_at": "2021-09-08T10:40:27.000000Z"
     *           },
     *           {
     *               "id": 9,
     *               "code": "bn",
     *               "name": "Bengali",
     *               "native": "বাংলা",
     *               "rtl": 0,
     *               "status": 1,
     *               "json_exist": 0,
     *               "created_at": null,
     *               "updated_at": "2021-09-09T11:21:10.000000Z"
     *           },
     *           {
     *               "id": 19,
     *               "code": "en",
     *               "name": "English",
     *               "native": "English",
     *               "rtl": 0,
     *               "status": 1,
     *               "json_exist": 0,
     *               "created_at": null,
     *               "updated_at": "2021-09-09T10:11:04.000000Z"
     *           }
     *       ],
     *       "msg": "success"
     * }
     */

    public function getActiveLanguages(){
        $languages = $this->languageRepo->getActiveAll();
        return response()->json([
            'languages' => $languages,
            'msg' => 'success'
        ]);
    }

    public function sendOTPForAPI(Request $request){

        $request->validate([
            'type' => 'required'
        ]);
        if($request->type == 'otp_on_customer_registration'){
            $request->validate([
                'code' => ['required', 'numeric', 'digits:6'],
                'email' => ['required', 'string', 'max:255', 'unique:users,email', 'check_unique_phone'],
                'first_name' => 'required'
            ]);

        }elseif($request->type == 'otp_on_order_with_cod'){
            $request->validate([
                'code' => ['required', 'numeric', 'digits:6'],
                'email' => 'required',
                'name' => 'required',
                'phone' => 'required'
            ]);
        }
        elseif($request->type == 'otp_on_seller_registration'){
            $request->validate([
                'code' => ['required', 'numeric', 'digits:6'],
                'email' => 'required',
                'name' => 'required',
                'phone' => 'required'
            ]);
        }
        elseif($request->type == 'otp_on_login'){
            
            $request->validate([
                'code' => ['required', 'numeric', 'digits:6'],
                'email' => ['required'],
                'password' => ['required', 'string','min:8']
            ]);
            $user = User::where('email', $request->email)->where('is_active', 1)->whereHas('role', function($q){
                $q->where('type', 'customer');
            })->first();
            if(!$user){
                $user = User::where('username', $request->email)->where('is_active', 1)->whereHas('role', function($q){
                    $q->where('type', 'customer');
                })->first();
            }

            if(!$user || !Hash::check($request->password,$user->password)){
                throw ValidationException::withMessages([
                    'email' => __('auth.failed')
                ]);
            }

        }
        elseif($request->type == 'otp_on_password_reset'){
            $request->validate([
                'code' => ['required', 'numeric', 'digits:6'],
                'email' => 'required'
            ]);
            $user = User::where('email', $request->email)->where('is_active', 1)->whereHas('role', function($q){
                $q->where('type', 'customer');
            })->first();
            if(!$user){
                $user = User::where('username', $request->email)->where('is_active', 1)->whereHas('role', function($q){
                    $q->where('type', 'customer');
                })->first();
            }
            if(!$user){
                throw ValidationException::withMessages([
                    'email' => __('auth.failed')
                ]);
            }

        }else{
            throw ValidationException::withMessages([
                'type' => 'invalid type.'
            ]);
        }
        
        $result = $this->sendOTPFromAPI($request);
        if($result){
            return response()->json([
                'msg' => 'success'
            ], 200);
        }else{
            return response()->json([
                'msg' => 'failed'
            ], 403);
        }
    }
}
