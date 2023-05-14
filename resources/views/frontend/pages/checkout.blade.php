@extends('frontend.layouts.master')

@section('title','Checkout page')

@section('main-content')

    <div class="container">
        <!-- Breadcrumbs -->
        <div class="breadcrumbs">
            <ul class="bread-list">
                <li>
                    <a href="{{route('home')}}">
                        <span class="crumbText">
                            Home
                        </span>
                    </a>
                </li>
                <li class="active">
                    <a href="{{route('checkout')}}">
                        <span class="crumbText">
                            Checkout
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Breadcrumbs -->

        <section class="checkoutFromSection">
            <form class="form" method="POST" action="{{route('cart.order')}}">
                @csrf
                <div class="row">

                    <div class="col-lg-8 col-12">
                        <div class="checkout-form">
                            <h2>Make Your Checkout Here</h2>
                            <p>Please register in order to checkout more quickly</p>
                            <!-- Form -->
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>First Name<span></span></label>
                                        <input type="text" name="first_name" placeholder="" value="{{old('first_name')}}" value="{{old('first_name')}}">
                                        @error('first_name')
                                        <span class='text-danger'>{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Last Name<span></span></label>
                                        <input type="text" name="last_name" placeholder="" value="{{old('lat_name')}}">
                                        @error('last_name')
                                        <span class='text-danger'>{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Email Address<span></span></label>
                                        <input type="email" name="email" placeholder="" value="{{old('email')}}">
                                        @error('email')
                                        <span class='text-danger'>{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Phone Number <span></span></label>
                                        <input type="number" name="phone" placeholder="" required value="{{old('phone')}}">
                                        @error('phone')
                                        <span class='text-danger'>{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group customSelect">
                                        <label>Country <span></span></label>
                                        <select name="country" id="country">
                                            <option value="AU">Australia</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Address Line 1 <span></span></label>
                                        <input type="text" name="address1" placeholder="" value="{{old('address1')}}">
                                        @error('address1')
                                        <span class='text-danger'>{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Address Line 2 </label>
                                        <input type="text" name="address2" placeholder="" value="{{old('address2')}}">
                                        @error('address2')
                                        <span class='text-danger'>{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Postal Code</label>
                                        <input type="text" name="post_code" placeholder="" value="{{old('post_code')}}">
                                        @error('post_code')
                                        <span class='text-danger'>{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <!--/ End Form -->
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="order-details">
                            <!-- Order Widget -->
                            <div class="single-widget">
                                <h2>CART  TOTALS</h2>
                                <div class="content checkoutDetails">
                                    <ul>
                                        <li class="order_subtotal" data-price="{{Helper::totalCartPrice()}}">
                                            <span>Cart Subtotal</span>
                                            <span class="cartDetailValue">${{number_format(Helper::totalCartPrice(),2)}}</span>
                                        </li>
                                        <li class="shipping">
                                            <span>Shipping Cost</span>
                                            <div class="customSelect">
                                                @if(count(Helper::shipping())>0 && Helper::cartCount()>0)
                                                    <select name="shipping" class="nice-select">
                                                        <option value="">Select your address</option>
                                                        @foreach(Helper::shipping() as $shipping)
                                                            <option value="{{$shipping->id}}" class="shippingOption" data-price="{{$shipping->price}}">{{$shipping->type}}: ${{$shipping->price}}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <span>Free</span>
                                                @endif
                                            </div>
                                        </li>

                                        @if(session('coupon'))
                                            <li class="coupon_price" data-price="{{session('coupon')['value']}}">You Save<span>${{number_format(session('coupon')['value'],2)}}</span></li>
                                        @endif
                                        @php
                                            $total_amount=Helper::totalCartPrice();
                                            if(session('coupon')){
                                                $total_amount=$total_amount-session('coupon')['value'];
                                            }
                                        @endphp
                                        @if(session('coupon'))
                                            <li class="last"  id="order_total_price">
                                                Total
                                                <span class="cartDetailValue">${{number_format($total_amount,2)}}</span>
                                            </li>
                                        @else
                                            <li class="last" id="order_total_price">
                                                Total
                                                <span class="cartDetailValue">${{number_format($total_amount,2)}}</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>

                            <div class="single-widget">
                                <h2>Payments</h2>
                                <div class="content">
                                    <div class="checkbox">
                                        {{-- <label class="checkbox-inline" for="1"><input name="updates" id="1" type="checkbox"> Check Payments</label> --}}
                                        <form-group>
                                            {{--                                                <input name="payment_method"  type="radio" value="cod"> <label> Cash On Delivery</label><br>--}}
                                            <div class="form-group">
                                            <input name="payment_method"  type="radio" value="stripe">
                                                <label> Credit / Debit</label>
                                            </div>
                                            <div class="form-group">
                                                <input name="payment_method"  type="radio" value="paypal">
                                                <label> PayPal</label>
                                            </div>
                                        </form-group>

                                    </div>
                                </div>
                            </div>
                            <div class="get-button">
                                <div class="content">
                                    <div class="button">
                                        <button type="submit" class="btn customBlueBtn">proceed to checkout</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </section>


    </div>

@endsection

@push('scripts')
	<script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
	<script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
	<script>
		$(document).ready(function() { $("select.select2").select2(); });
  		$('select.nice-select').niceSelect();
	</script>
	<script>
		function showMe(box){
			var checkbox=document.getElementById('shipping').style.display;
			// alert(checkbox);
			var vis= 'none';
			if(checkbox=="none"){
				vis='block';
			}
			if(checkbox=="block"){
				vis="none";
			}
			document.getElementById(box).style.display=vis;
		}
	</script>
	<script>
		$(document).ready(function(){
			$('.shipping select[name=shipping]').change(function(){
				let cost = parseFloat( $(this).find('option:selected').data('price') ) || 0;
				let subtotal = parseFloat( $('.order_subtotal').data('price') );
				let coupon = parseFloat( $('.coupon_price').data('price') ) || 0;
				// alert(coupon);
				$('#order_total_price span').text('$'+(subtotal + cost-coupon).toFixed(2));
			});

		});

	</script>

@endpush
