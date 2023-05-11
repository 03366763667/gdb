@extends('frontend.layouts.master')
@section('title','Cart Page')
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
                    <a href="{{route('cart')}}">
                        <span class="crumbText">
                            Shopping Cart
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Breadcrumbs -->

        <section class="cart-section">
            <h2>Shopping Cart</h2>
            @if(Helper::getAllProductFromCart())
                <div class="customTable">
                    <table class="table shopping-summery table-bordered">
                        <thead>
                        <tr class="main-hading">
                            <th class="text-left">No</th>
                            <th class="text-left">PRODUCT</th>
                            <th class="text-left" width="400px">NAME</th>
                            <th class="text-left">UNIT PRICE</th>
                            <th class="text-left" width="50px">QUANTITY</th>
                            <th class="text-left">TOTAL</th>
                            <th class="text-right">ACTIONS</th>
                        </tr>
                        </thead>
                        <tbody id="cart_item_list">
                        <form action="{{route('cart.update')}}" method="POST">
                            @csrf
                            @foreach(Helper::getAllProductFromCart() as $key => $cart)
                                <tr>
                                    @php
                                        $photo=explode(',',$cart->product['photo']);
                                    @endphp
                                    <td>{{$key}}</td>
                                    <td class="image" data-title="No">
                                        <div class="cartProductImage">
                                            <img src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                        </div>
                                    </td>
                                    <td data-title="Description">
                                        <p class="product-name">
                                            <a href="{{route('product-detail',$cart->product['slug'])}}" target="_blank">
                                                {{$cart->product['title']}}
                                            </a>
                                        </p>
                                        <p class="product-des">{!!($cart['summary']) !!}</p>
                                    </td>
                                    <td class="price" data-title="Price"><span>${{number_format($cart['price'],2)}}</span></td>
                                    <td class="qty" data-title="Qty"><!-- Input Order -->
                                        <div class="input-group cartInput">
                                            <input type="text" name="quant[{{$key}}]" class="input-number"  data-min="1" data-max="100" value="{{$cart->quantity}}">
                                            <input type="hidden" name="qty_id[]" value="{{$cart->id}}">
                                            <div class="plusMinusBtns">
                                                <button type="button" class="btn btn-primary btn-number" data-type="minus" data-field="quant[{{$key}}]">
                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                </button>
                                                <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[{{$key}}]">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!--/ End Input Order -->
                                    </td>
                                    <td class="total-amount cart_single_price" data-title="Total">
                                        <span class="money">${{$cart['amount']}}</span>
                                    </td>

                                    <td class="action text-right" data-title="Remove">
                                        <a href="{{route('cart-delete',$cart->id)}}" class="cartDelete">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="float-right">
                                <button class="btn customBlueBtn" type="submit">Update</button>
                            </td>
                            </tr>
                        </form>
                        </tbody>
                    </table>
                </div>

                <div class="coupon">
                    <form action="{{route('coupon-store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input name="code" class="form-control" placeholder="Enter Your Coupon">
                        </div>
                        <button class="btn customBlueBtn">Apply</button>
                    </form>
                </div>

            @else
                <div class="emptyCartWrap">
                    <p>
                <span class="emptyCartIcon">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                </span>
                        The Shopping Cart is Empty!
                        <a href="{{route('product-grids')}}">Continue shopping</a>
                    </p>
                </div>
            @endif
        </section>

        <section class="recentlyAddedSection">
            <h2>
                <span>Recently Added</span>
            </h2>
            <div class="tabDetailWrapper">
                <div class="row">
                    @foreach(Helper::getLatestProduct() as $key => $product)
                        <div class="col col-md-4 col-lg-3 col-xl-2">
                            <div class="productBox">
                                <div class="productImg">
                                    <a href="{{route('product-detail',$product->slug)}}">
                                        <img src="{{$product->photo}}" alt="{{$product->photo}}">
                                    </a>
                                </div>
                                <div class="productContent">
                                    <h4>
                                        <a href="{{route('product-detail',$product->slug)}}">
                                            {{$product->title}}
                                        </a>
                                    </h4>
                                    <span class="productPrice">${{$product->price}}</span>
                                    <div class="productBtns listViewBtns">
                                        <span class="ProductStock">AU Stock {{$product->stock}}</span>
                                        <a href="javascript:void(0)" class="customBlueBtn">Add to Queue</a>
                                        <a href="{{route('add-to-cart',$product->slug)}}" class="productCart">
                                            <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="productBtns">
                                    <span class="ProductStock">AU Stock {{$product->stock}}</span>
                                    <a href="javascript:void(0)" class="customBlueBtn">Add to Queue</a>
                                    <a href="{{route('add-to-cart',$product->slug)}}" class="productCart">
                                        <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

    </div>


	<!-- Shopping Cart -->
	<div class="shopping-cart section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<!-- Total Amount -->
					<div class="total-amount">
						<div class="row">
							<div class="col-lg-8 col-md-5 col-12">
								<div class="left">

									{{-- <div class="checkbox">`
										@php
											$shipping=DB::table('shippings')->where('status','active')->limit(1)->get();
										@endphp
										<label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox" onchange="showMe('shipping');"> Shipping</label>
									</div> --}}
								</div>
							</div>
							<div class="col-lg-4 col-md-7 col-12">
								<div class="right">
									<ul>
										<li class="order_subtotal" data-price="{{Helper::totalCartPrice()}}">Cart Subtotal<span>${{number_format(Helper::totalCartPrice(),2)}}</span></li>

										@if(session()->has('coupon'))
										<li class="coupon_price" data-price="{{Session::get('coupon')['value']}}">You Save<span>${{number_format(Session::get('coupon')['value'],2)}}</span></li>
										@endif
										@php
											$total_amount=Helper::totalCartPrice();
											if(session()->has('coupon')){
												$total_amount=$total_amount-Session::get('coupon')['value'];
											}
										@endphp
										@if(session()->has('coupon'))
											<li class="last" id="order_total_price">You Pay<span>${{number_format($total_amount,2)}}</span></li>
										@else
											<li class="last" id="order_total_price">You Pay<span>${{number_format($total_amount,2)}}</span></li>
										@endif
									</ul>
									<div class="button5">
										<a href="{{route('checkout')}}" class="btn">Checkout</a>
										<a href="{{route('product-grids')}}" class="btn">Continue shopping</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--/ End Total Amount -->
				</div>
			</div>
		</div>
	</div>

	<!--/ End Shopping Cart -->

	<!-- Start Shop Newsletter  -->
{{--	@include('frontend.layouts.newsletter')--}}
	<!-- End Shop Newsletter -->

@endsection

@push('scripts')
	<script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
	<script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
	<script>
		$(document).ready(function() { $("select.select2").select2(); });
  		$('select.nice-select').niceSelect();
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
