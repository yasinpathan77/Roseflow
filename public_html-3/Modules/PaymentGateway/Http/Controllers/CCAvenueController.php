<?php

namespace Modules\PaymentGateway\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\OrderRepository;
use App\Repositories\CheckoutRepository;
use Modules\Wallet\Repositories\WalletRepository;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Account\Repositories\TransactionRepository;
use Modules\Account\Entities\Transaction;
use Modules\FrontendCMS\Entities\SubsciptionPaymentInfo;
use \Modules\Setup\Entities\Country;
use \Modules\Setup\Entities\State;
use \Modules\Setup\Entities\City;
use App\Traits\Accounts;
use Carbon\Carbon;
use Modules\UserActivityLog\Traits\LogActivity;

class CCAvenueController extends Controller
{
    use Accounts;

    public function __construct()
    {
        $this->middleware('maintenance_mode');
    } 

    public function payment($data)
    {
        $credential = $this->getCredential();
        
        if (@$credential->perameter_1 == "TEST") {
            $CCAVENUE_BASE_URL = "https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction";
        }else {
            $CCAVENUE_BASE_URL = "https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction";
        }

        $MERCHANT_ID = @$credential->perameter_2;
        $ACCESS_CODE = @$credential->perameter_3;
        $WORKING_KEY = @$credential->perameter_4;

        //Compulsory information
        $tid = substr((time() . mt_rand()) , 0, 17);
        $order_id = substr((time() . mt_rand()), 0, 17);
        $amount = $data['amount'];
        $currency_code = getCurrencyCode(); //app('general_setting')->currency_code;
        $redirect_url = route('ccavenue.ccavenueSuccess');
        $cancel_url = route('ccavenue.ccavenueFailed');
        //$redirect_url = route('paypal.paypalSuccess');
        //$cancel_url = route('paypal.paypalFailed');
        $language = "EN";
        
        //Get Billing and Shipping information
        $checkoutRepo = new CheckoutRepository();
        
        $billing_address_details = null;
        $shipping_address_details = null;
        //if(auth()->check()){
            $shipping_address_details = $checkoutRepo->activeShippingAddress();

            if($checkoutRepo->activeBillingAddress() == null){
                $billing_address_details = $shipping_address_details;
            }else{
                $billing_address_details = $checkoutRepo->activeBillingAddress();
            }
        //}
        
        //Billing information(optional):
        $billing_name = $billing_address_details->name;
        $billing_address = $billing_address_details->address;
        $billing_city = City::find($billing_address_details->city)->name;
        $billing_state = State::find($billing_address_details->state)->name;
        $billing_zip = $billing_address_details->postal_code;
        $billing_country = Country::find($billing_address_details->country)->name;
        $billing_tel = $billing_address_details->phone;
        $billing_email = $billing_address_details->email;
        
        //Shipping information(optional)
        $shipping_name = $shipping_address_details->name;
        $shipping_address = $shipping_address_details->address;
        $shipping_city = City::find($shipping_address_details->city)->name;
        $shipping_state = State::find($shipping_address_details->state)->name;
        $shipping_zip = $shipping_address_details->postal_code;
        $shipping_country = Country::find($shipping_address_details->country)->name;
        $shipping_tel = $shipping_address_details->phone;
        $shipping_email = $shipping_address_details->email;
        
        $merchant_param1 = "";
        
        $merchant_param2 = json_encode($this->get_merchant_param1());
        
        $merchant_param3 = json_encode($this->get_merchant_param2());
        
        $merchant_param4 = json_encode($this->get_merchant_param3());
        
        $merchant_data = "tid=" . $tid . "&merchant_id=" . $MERCHANT_ID . "&order_id=" . $order_id ."&amount=" . $amount . "&currency=" . $currency_code . "&redirect_url=" . $redirect_url . "&cancel_url=" . $cancel_url . "&language=" . $language . "&billing_name=" . $billing_name . "&billing_address=" . $billing_address . "&billing_city=" . $billing_city . "&billing_state=" . $billing_state . "&billing_zip=" . $billing_zip . "&billing_country=" . $billing_country . "&billing_tel=" . $billing_tel . "&billing_email=" . $billing_email . "&delivery_name=" . $shipping_name . "&delivery_address=" . $shipping_address . "&delivery_city=" . $shipping_city . "&delivery_state=" . $shipping_state . "&delivery_zip=" . $shipping_zip . "&delivery_country=" . $shipping_country . "&delivery_tel=" . $shipping_tel . "&merchant_param1=" . $merchant_param1 . "&merchant_param2=" . $merchant_param2 . "&merchant_param3=" . $merchant_param3 . "&merchant_param4=" . $merchant_param4;
        
        $encrypted_data = $this->encrypt($merchant_data, $WORKING_KEY);
        
        return array(
            'CCAVENUE_BASE_URL' => $CCAVENUE_BASE_URL,
            'encrypted_data' => $encrypted_data,
            'ACCESS_CODE' => $ACCESS_CODE,
        );
    }
    
    public function success(Request $request)
    {
        
        error_reporting(0);
	
	    $credential = $this->getCredential();
	    
	    $MERCHANT_ID = @$credential->perameter_2;
        $ACCESS_CODE = @$credential->perameter_3;
        $WORKING_KEY = @$credential->perameter_4;
	    
	    $response = array();
    	$workingKey = $WORKING_KEY;		//Working Key should be provided here.
    	$encResponse = $request->input("encResp");			//This is the response sent by the CCAvenue Server
    	$rcvdString = $this->decrypt($encResponse, $workingKey);		//Crypto Decryption used as per the specified working key.
    	$order_status = "";
    	$decryptValues = explode('&', $rcvdString);
    	$dataSize = sizeof($decryptValues);
        
        for($i = 0; $i < $dataSize; $i++) 
    	{
    		$information=explode('=',$decryptValues[$i]);
    		if($i==3){
    		    $order_status=$information[1];
    		}
    		
    		$response[$information[0]] = $information[1];
    	}
    	
        if ($response['order_status'] == "Success") {
            if (session()->has('wallet_recharge')) {
                $amount = $response['amount'];
                $walletService = new WalletRepository;
                return $walletService->walletRecharge($amount, "18", $response['bank_ref_no']);
                
            }
            if (session()->has('order_payment')) {
                $amount = $response['amount'];
                $orderPaymentService = new OrderRepository;
                $order_payment = $orderPaymentService->orderPaymentDone($amount, "18", $response['bank_ref_no'], (auth()->check())?auth()->user():null);
                if($order_payment == 'failed'){
                    Toastr::error('Invalid Payment');
                    return redirect(url('/checkout'));
                }
                $payment_id = $order_payment->id;
                $data['payment_id'] = encrypt($payment_id);
                $data['gateway_id'] = encrypt(18);
                $data['step'] = 'complete_order';
                Toastr::success(__('common.payment_successfully'),__('common.success'));
                LogActivity::successLog('checkout payment successful.');
                return redirect()->route('frontend.checkout', $data);
            }
            if (session()->has('subscription_payment')) {
                $amount = $response['amount'];
                $defaultIncomeAccount = $this->defaultIncomeAccount();
                $transactionRepo = new TransactionRepository(new Transaction);
                $seller_subscription = getParentSeller()->SellerSubscriptions;
                $transaction = $transactionRepo->makeTransaction(getParentSeller()->first_name." - Subsriction Payment", "in", "CCAvenue", "subscription_payment", $defaultIncomeAccount, "Subscription Payment", $seller_subscription, $amount, Carbon::now()->format('Y-m-d'), getParentSellerId(), null, null);
                $seller_subscription->update(['last_payment_date' => Carbon::now()->format('Y-m-d')]);
                SubsciptionPaymentInfo::create([
                    'transaction_id' => $transaction->id,
                    'txn_id' => $response['bank_ref_no'],
                    'seller_id' => getParentSellerId(),
                    'subscription_type' => getParentSeller()->sellerAccount->subscription_type,
                    'commission_type' => @$seller_subscription->pricing->name
                ]);
                session()->forget('subscription_payment');

                Toastr::success(__('common.payment_successfully'),__('common.success'));
                LogActivity::successLog('Subscription payment successful.');
                return redirect()->route('seller.dashboard');
            }
        }else {
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }

    public function failed()
    {
        Toastr::error(__('common.operation_failed'));
        return redirect()->route('frontend.welcome');
    }

    private function getCredential(){
        $url = explode('?',url()->previous());
        if(isset($url[0]) && $url[0] == url('/checkout')){
            $is_checkout = true;
        }else{
            $is_checkout = false;
        }
        if(session()->has('order_payment') && app('general_setting')->seller_wise_payment && session()->has('seller_for_checkout') && $is_checkout){
            $credential = getPaymentInfoViaSellerId(session()->get('seller_for_checkout'), 18);
        }else{
            $credential = getPaymentInfoViaSellerId(1, 18);
        }
        return $credential;
    }
    
    //////////////////
    // For merchant param 1, merchant param 2 and merchant param 3
    //////////////////
    private function get_merchant_param1(){
        
        //If user login then send user data
        if(auth()->check()){
            return array(
                "user_details" => array(
                    "id" => auth()->user()->id,
                    "first_name" => auth()->user()->first_name,
                    "last_name" => auth()->user()->last_name,
                    "role_id" => auth()->user()->role_id,
                    "email" => auth()->user()->email,
                    "is_verified" => auth()->user()->is_verified,
                    "is_active" => auth()->user()->is_active,
                    "phone" => auth()->user()->phone,
                    "date_of_birth" => auth()->user()->date_of_birth,
                    "currency_id" => auth()->user()->currency_id,
                    "currency_code" => auth()->user()->currency_code,
                )
            );
            
        //If user not login then send shipping data as a user information
        }else{
            
            $checkoutRepo = new CheckoutRepository();
            $shipping_address_details = $checkoutRepo->activeShippingAddress();
            return (array) $shipping_address_details;
        }
    }
    
    private function get_merchant_param2(){
        
        $products = array();
        
        $checkoutRepo = new CheckoutRepository();
        
        $cartDataGroup = $checkoutRepo->getCartItem();
        $cartData = $cartDataGroup['cartData'];
        
        foreach($cartData as $seller_id => $packages){
            foreach($packages as $key => $item){
                
                if($item->product_type == 'product'){
                    
                    $product = array(
                        "id" => $item->product->product->product->id,
                        "name" => $item->product->product->product->product_name,
                        "tax" => $item->product->product->tax,
                        "tax_type" => $item->product->product->tax_type,
                        "discount" => $item->product->product->discount,
                        "discount_type" => $item->product->product->discount_type,
                        "discount_start_date" => $item->product->product->discount_start_date,
                        "discount_end_date" => $item->product->product->discount_end_date,
                        "tax_type" => $item->product->product->tax_type,
                        "min_sell_price" => $item->product->product->min_sell_price,
                        "max_sell_price" => $item->product->product->max_sell_price,
                        "total_sale" => $item->product->product->total_sale,
                        "variantDetails" => array(),
                        "MaxSellingPrice" => $item->product->product->MaxSellingPrice,
                        "hasDeal" => $item->product->product->hasDeal,
                        "hasDiscount" => $item->product->product->hasDiscount,
                        "product_type" => $item->product->product->product->product_type,
                        "ProductType" => $item->product->product->ProductType,
                        "unit_type_id" => $item->product->product->product->unit_type_id,
                        "brand_id" => $item->product->product->product->brand_id,
                        "barcode_type" => $item->product->product->product->barcode_type,
                        "model_number" => $item->product->product->product->model_number,
                        "shipping_type" => $item->product->product->product->shipping_type,
                        "shipping_cost" => $item->product->product->product->shipping_cost,
                        "discount_type" => $item->product->product->product->discount_type,
                        "gst_group_id" => $item->product->product->product->gst_group_id,
                        "minimum_order_qty" => $item->product->product->product->minimum_order_qty,
                        "max_order_qty" => $item->product->product->product->max_order_qty,
                        "is_physical" => $item->product->product->product->is_physical,
                        "is_approved" => $item->product->product->product->is_approved,
                        "status" => $item->product->product->product->status,
                        "display_in_details" => $item->product->product->product->display_in_details,
                        "sku" => $item->product->sku->toArray(),
                        );
                    
                        //Variant Details like color, size etc..
                        foreach($item->product->product_variations as $key => $combination){
                            if($combination->attribute->name == 'Color'){
                                $product['variantDetails'][$combination->attribute->name] = array(
                                        "id" => $combination->attribute_value->color->id,
                                        $combination->attribute->name => $combination->attribute_value->color->name
                                );
                            }else{
                                $product['variantDetails'][$combination->attribute->name] = array(
                                        "id" => $combination->attribute_value->id,
                                        $combination->attribute->name => $combination->attribute_value->value
                                );
                            }
                        }
                    
                    $products["products"][] = $product;
                    
                    
                }
            }
        }
        return $products;
    }
    
    private function get_merchant_param3(){
        
        $checkoutRepo = new CheckoutRepository();
        
        $cartDataGroup = $checkoutRepo->getCartItem();
        $cartData = $cartDataGroup['cartData'];
        
        $address = $checkoutRepo->activeShippingAddress();
        
        $coupon = [];
        if(isModuleActive('MultiVendor')){
            if(isModuleActive('INTShipping') && app('theme')->folder_path == 'amazy'){
                $shipping_method_rate = $request->get('intshipping_cartItem');
                $selected_shipping_method = $checkoutRepo->totalAmountForPayment($cartData,$shipping_method_rate,$address)['shipping_method'];
                $total_amount = $checkoutRepo->totalAmountForPayment($cartData,$shipping_method_rate,$address)['grand_total'];
                $subtotal_without_discount = $checkoutRepo->totalAmountForPayment($cartData,$shipping_method_rate,$address)['subtotal'];
                $discount = $checkoutRepo->totalAmountForPayment($cartData,$shipping_method_rate,$address)['discount'];
                $number_of_package = $checkoutRepo->totalAmountForPayment($cartData,$shipping_method_rate,$address)['number_of_package'];
                $number_of_item = $checkoutRepo->totalAmountForPayment($cartData,$shipping_method_rate,$address)['number_of_item'];
                $shipping_cost = $checkoutRepo->totalAmountForPayment($cartData,$shipping_method_rate,$address)['shipping_cost'];
                $tax_total = $checkoutRepo->totalAmountForPayment($cartData,$shipping_method_rate,$address)['tax_total'];
                $delivery_date = $checkoutRepo->totalAmountForPayment($cartData,$shipping_method_rate,$address)['delivery_date'];
                $packagewise_tax = $checkoutRepo->totalAmountForPayment($cartData,$shipping_method_rate,$address)['packagewise_tax'];
                $actual_total = $checkoutRepo->totalAmountForPayment($cartData,$shipping_method_rate,$address)['actual_total'];
            }else{
                $selected_shipping_method = $checkoutRepo->totalAmountForPayment($cartData,null,$address)['shipping_method'];
                $total_amount = $checkoutRepo->totalAmountForPayment($cartData,null,$address)['grand_total'];
                $subtotal_without_discount = $checkoutRepo->totalAmountForPayment($cartData,null,$address)['subtotal'];
                $discount = $checkoutRepo->totalAmountForPayment($cartData,null,$address)['discount'];
                $number_of_package = $checkoutRepo->totalAmountForPayment($cartData,null,$address)['number_of_package'];
                $number_of_item = $checkoutRepo->totalAmountForPayment($cartData,null,$address)['number_of_item'];
                $shipping_cost = $checkoutRepo->totalAmountForPayment($cartData,null,$address)['shipping_cost'];
                $tax_total = $checkoutRepo->totalAmountForPayment($cartData,null,$address)['tax_total'];
                $delivery_date = $checkoutRepo->totalAmountForPayment($cartData,null,$address)['delivery_date'];
                $packagewise_tax = $checkoutRepo->totalAmountForPayment($cartData,null,$address)['packagewise_tax'];
                $actual_total = $checkoutRepo->totalAmountForPayment($cartData,null,$address)['actual_total'];
            }
            if(Session::has('coupon_type')&&Session::has('coupon_discount')){
                $coupon = $this->couponCount($subtotal_without_discount-$discount, collect($shipping_cost)->sum());
            }
        }else{
            if(isModuleActive('INTShipping') && app('theme')->folder_path == 'amazy'){
                $selected_shipping_method = $request->get('intshipping_cartItem');
            }else{
                $selected_shipping_method = $checkoutRepo->selectedShippingMethod(decrypt($request->get('shipping_method')));
            }
            $total_amount = $checkoutRepo->totalAmountForPayment($cartData,$selected_shipping_method,$address)['grand_total'];
            $subtotal_without_discount = $checkoutRepo->totalAmountForPayment($cartData,$selected_shipping_method,$address)['subtotal'];
            $discount = $checkoutRepo->totalAmountForPayment($cartData,$selected_shipping_method,$address)['discount'];
            $number_of_package = $checkoutRepo->totalAmountForPayment($cartData,$selected_shipping_method,$address)['number_of_package'];
            $number_of_item = $checkoutRepo->totalAmountForPayment($cartData,$selected_shipping_method,$address)['number_of_item'];
            $shipping_cost = $checkoutRepo->totalAmountForPayment($cartData,$selected_shipping_method,$address)['shipping_cost'];
            $tax_total = $checkoutRepo->totalAmountForPayment($cartData,$selected_shipping_method,$address)['tax_total'];
            $delivery_date = $checkoutRepo->totalAmountForPayment($cartData,$selected_shipping_method,$address)['delivery_date'];
            $packagewise_tax = $checkoutRepo->totalAmountForPayment($cartData,$selected_shipping_method,$address)['packagewise_tax'];
            $actual_total = $checkoutRepo->totalAmountForPayment($cartData,$selected_shipping_method,$address)['actual_total'];
            if(isModuleActive('INTShipping') && app('theme')->folder_path == 'amazy'){
                $selected_shipping_method = $checkoutRepo->totalAmountForPayment($cartData,$selected_shipping_method,$address)['shipping_method'];
            }
            if(Session::has('coupon_type')&&Session::has('coupon_discount')){
                $coupon = $this->couponCount($subtotal_without_discount-$discount,$shipping_cost);
            }
        }
        
        $total = array(
                "selected_shipping_method" => $selected_shipping_method,
                "total_amount" => $total_amount,
                "subtotal_without_discount" => $subtotal_without_discount,
                "discount" => $discount,
                "number_of_package" => $number_of_package,
                "number_of_item" => $number_of_item,
                "shipping_cost" => $shipping_cost,
                "tax_total" => $tax_total,
                "delivery_date" => $delivery_date,
                "packagewise_tax" => $packagewise_tax,
                "actual_total" => $actual_total,
                "coupon" => $coupon,
        );
        return $total;
    }
    
    private function couponCount($total_for_coupon,$shippingtotal){
        $coupon = 0;
        if(Session::has('coupon_type')&&Session::has('coupon_discount')){
            $coupon_type = Session::get('coupon_type');
            $coupon_discount = Session::get('coupon_discount');
            $coupon_discount_type = Session::get('coupon_discount_type');
            $coupon_id = Session::get('coupon_id');

            if($coupon_type == 1){
                $couponProducts = Session::get('coupon_products');
                if($coupon_discount_type == 0){

                    foreach($couponProducts as  $key => $item){
                        $cart = \App\Models\Cart::where('user_id',auth()->user()->id)->where('is_select',1)->where('product_type', 'product')->whereHas('product',function($query) use($item){
                            $query->whereHas('product', function($q) use($item){
                                $q->where('id', $item);
                            });
                        })->first();
                        $coupon += ($cart->total_price/100)* $coupon_discount;
                    }
                }else{
                    if($total_for_coupon > $coupon_discount){
                        $coupon = $coupon_discount;
                    }else {
                        $coupon = $total_for_coupon;
                    }
                }

            }
            elseif($coupon_type == 2){

                if($coupon_discount_type == 0){

                    $maximum_discount = Session::get('maximum_discount');
                    $coupon = ($total_for_coupon/100)* $coupon_discount;

                    if($coupon > $maximum_discount && $maximum_discount > 0){
                        $coupon = $maximum_discount;
                    }
                }else{
                    $coupon = $coupon_discount;
                }
            }
            elseif($coupon_type == 3){
                $maximum_discount = Session::get('maximum_discount');
                $coupon = $shippingtotal;

                if($coupon > $maximum_discount && $maximum_discount > 0){
                    $coupon = $maximum_discount;
                }

            }
        }
        return [
            'coupon_amount' => $coupon,
            'coupon_id' => $coupon_id
        ];
    }
    //////////////////
    // End for merchant param 1, merchant param 2 and merchant param 3
    //////////////////
    
    
    //////////////////
    // Crypto.php
    //////////////////
    /*
    * @param1 : Plain String
    * @param2 : Working key provided by CCAvenue
    * @return : Decrypted String
    */
    private function encrypt($plainText,$key){
        
    	$key = $this->hextobin(md5($key));
    	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    	$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
    	$encryptedText = bin2hex($openMode);
    	return $encryptedText;
    }

    /*
    * @param1 : Encrypted String
    * @param2 : Working key provided by CCAvenue
    * @return : Plain String
    */
    private function decrypt($encryptedText,$key){
        
    	$key = $this->hextobin(md5($key));
    	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    	$encryptedText = $this->hextobin($encryptedText);
    	$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
    	return $decryptedText;
    }

    private function hextobin($hexString){
        
    	$length = strlen($hexString); 
    	$binString="";   
    	$count=0; 
    	while($count<$length) 
    	{       
    	    $subString =substr($hexString,$count,2);           
    	    $packedString = pack("H*",$subString); 
    	    if ($count==0)
    	    {
    			$binString=$packedString;
    	    } 
    	    
    	    else 
    	    {
    			$binString.=$packedString;
    	    } 
    	    
    	    $count+=2; 
    	} 
        return $binString; 
    } 
    //////////////////
    // End Crypto.php
    //////////////////
}
