@extends('frontend.layouts.master')
@section('title','Wishlist Page')
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
                    <a href="{{route('wishlist')}}">
                        <span class="crumbText">
                            Wishlist
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

                <div class="checkoutBtn">
                    <a href="{{route('checkout')}}" class="btn customBlueBtn">Checkout</a>
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
                        There are no any wishlist available.
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
                        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
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



{{--	@include('frontend.layouts.newsletter')--}}



	<!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row no-gutters">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <!-- Product Slider -->
									<div class="product-gallery">
										<div class="quickview-slider-active">
											<div class="single-slider">
												<img src="images/modal1.jpg" alt="#">
											</div>
											<div class="single-slider">
												<img src="images/modal2.jpg" alt="#">
											</div>
											<div class="single-slider">
												<img src="images/modal3.jpg" alt="#">
											</div>
											<div class="single-slider">
												<img src="images/modal4.jpg" alt="#">
											</div>
										</div>
									</div>
								<!-- End Product slider -->
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="quickview-content">
                                    <h2>Flared Shift Dress</h2>
                                    <div class="quickview-ratting-review">
                                        <div class="quickview-ratting-wrap">
                                            <div class="quickview-ratting">
                                                <i class="yellow fa fa-star"></i>
                                                <i class="yellow fa fa-star"></i>
                                                <i class="yellow fa fa-star"></i>
                                                <i class="yellow fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <a href="#"> (1 customer review)</a>
                                        </div>
                                        <div class="quickview-stock">
                                            <span><i class="fa fa-check-circle-o"></i> in stock</span>
                                        </div>
                                    </div>
                                    <h3>$29.00</h3>
                                    <div class="quickview-peragraph">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia iste laborum ad impedit pariatur esse optio tempora sint ullam autem deleniti nam in quos qui nemo ipsum numquam.</p>
                                    </div>
									<div class="size">
										<div class="row">
											<div class="col-lg-6 col-12">
												<h5 class="title">Size</h5>
												<select>
													<option selected="selected">s</option>
													<option>m</option>
													<option>l</option>
													<option>xl</option>
												</select>
											</div>
											<div class="col-lg-6 col-12">
												<h5 class="title">Color</h5>
												<select>
													<option selected="selected">orange</option>
													<option>purple</option>
													<option>black</option>
													<option>pink</option>
												</select>
											</div>
										</div>
									</div>
                                    <div class="quantity">
										<!-- Input Order -->
										<div class="input-group">
											<div class="button minus">
												<button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
													<i class="ti-minus"></i>
												</button>
											</div>
											<input type="text" name="quant[1]" class="input-number"  data-min="1" data-max="1000" value="1">
											<div class="button plus">
												<button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
													<i class="ti-plus"></i>
												</button>
											</div>
										</div>
										<!--/ End Input Order -->
									</div>
									<div class="add-to-cart">
										<a href="#" class="btn">Add to cart</a>
										<a href="#" class="btn min"><i class="ti-heart"></i></a>
										<a href="#" class="btn min"><i class="fa fa-compress"></i></a>
									</div>
                                    <div class="default-social">
										<h4 class="share-now">Share:</h4>
                                        <ul>
                                            <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a class="youtube" href="#"><i class="fa fa-pinterest-p"></i></a></li>
                                            <li><a class="dribbble" href="#"><i class="fa fa-google-plus"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal end -->

@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@endpush
