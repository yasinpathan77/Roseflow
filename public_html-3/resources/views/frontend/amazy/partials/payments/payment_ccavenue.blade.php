<form action="{{route('frontend.order_payment')}}" method="post" class="ccavenue_form_payment_23 d-none">
    @csrf
    <input type="hidden" name="method" value="CCAvenue">
    <input type="hidden" name="purpose" value="order_payment">
    <input type="hidden" name="amount" value="{{$total_amount - $coupon_am}}">

    <button type="submit" class="btn_1 order_submit_btn ccavenue_btn d-none">{{ __('defaultTheme.process_to_payment') }}</button>
</form>