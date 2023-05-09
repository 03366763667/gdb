@extends('frontend.layouts.master')

@section('meta')
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='copyright' content=''>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="keywords" content="online shop, purchase, cart, ecommerce site, best online shopping">
	<meta name="description" content="{{$product_detail->summary}}">
	<meta property="og:url" content="{{route('product-detail',$product_detail->slug)}}">
	<meta property="og:type" content="article">
	<meta property="og:title" content="{{$product_detail->title}}">
	<meta property="og:image" content="{{$product_detail->photo}}">
	<meta property="og:description" content="{{$product_detail->description}}">
@endsection
@section('title','GDB || PRODUCT DETAIL')
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
                    <a href="">
                        <span class="crumbText">
                            Shop Detail
                        </span>
                    </a>
                </li>
            </ul>
        </div>
		<!-- End Breadcrumbs -->

        <div class="detailProductWrapper">
            <div class="detailProductImg">
                <img src="{{$product_detail->photo}}" alt="{{$product_detail->photo}}" aria-hidden="true">
            </div>
            <div class="detailProductContent">
                <h2>{{$product_detail->title}}</h2>
                <ul class="rating">
                    @php
                        $rate=ceil($product_detail->getReview->avg('rate'))
                    @endphp
                    @for($i=1; $i<=5; $i++)
                        @if($rate>=$i)
                            <li><i class="fa fa-star"></i></li>
                        @else
                            <li><i class="fa fa-star-o"></i></li>
                        @endif
                    @endfor
                </ul>

                @php
                    $after_discount = ($product_detail->price-(($product_detail->price*$product_detail->discount)/100));
                @endphp

                <div class="detailProductPrice">
                    <span class="featureHeading">Price: </span>
                    <span class="discount">${{number_format($after_discount,2)}}</span>
                    <s>${{number_format($product_detail->price,2)}}</s>
                </div>

                @if($product_detail->size)
                    <div class="productSize">
                        <span class="featureHeading">Sizes: </span>
                        <ul>
                            @php
                                $sizes=explode(',',$product_detail->size);
                            @endphp
                            @foreach($sizes as $key => $size)
                                <li><a href="#" class="{{$key}}">{{$size}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="productStock">
                    <span class="featureHeading">Stock: </span>
                    @if($product_detail->stock > 0)
                        <span class="badge badge-success">{{$product_detail->stock}}</span>
                    @else
                        <span class="badge badge-danger">{{$product_detail->stock}}</span>
                    @endif
                </div>

                <div class="detailProductCategory">
                    <p>
                        <span class="featureHeading">Category : </span>
                        <a href="{{route('product-cat',$product_detail->cat_info['slug'])}}">
                            {{$product_detail->cat_info['title']}}
                        </a>
                    </p>
                    @if($product_detail->sub_cat_info)
                        <p>
                            <span class="featureHeading">Sub Category :</span>
                            <a href="{{route('product-sub-cat',[$product_detail->cat_info['slug'],$product_detail->sub_cat_info['slug']])}}">
                                {{$product_detail->sub_cat_info['title']}}
                            </a>
                        </p>
                    @endif
                </div>

                <div class="detailProductBtns">
                    <form action="{{route('single-add-to-cart')}}" method="POST">
                        @csrf
                        <div class="productQuantity">
                            <h6 class="featureHeading">Quantity :</h6>
                            <div class="input-group">
                                <div class="button minus">
                                    <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                        <i class="ti-minus"></i>
                                    </button>
                                </div>
                                <input type="hidden" name="slug" value="{{$product_detail->slug}}">
                                <input type="text" name="quant[1]" class="input-number"  data-min="1" data-max="1000" value="1" id="quantity">
                                <div class="button plus">
                                    <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                        <i class="ti-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="add-to-cart">
                            <button type="submit" class="customBlueBtn">Add to cart</button>
                            <a href="{{route('add-to-wishlist',$product_detail->slug)}}" class="btn min">
                                <i class="fa fa-heart-o" aria-hidden="true"></i>
                                <span>My Wishlist</span>
                            </a>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <div class="tabWrapper">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Description</a></li>
                <li><a href="#tab2" data-toggle="tab">Reviews</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent=".tab-pane" href="#collapseOne">
                                    Description
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <p>{!!($product_detail->summary)!!}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent=".tab-pane" href="#collapseTwo">
                                    Reviews
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse">
                            <div class="panel-body">
                                <a href="javascript:void(0)" class="total-review">
                                    ({{$product_detail['getReview']->count()}}) Review
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="relatedProducts">
            <div class="container">
                <h2>Related Products</h2>
                <div id="relatedProducts" class="owl-carousel owl-theme">
                    @foreach($product_detail->rel_prods as $product)
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
                    @endforeach
                </div>
            </div>
        </div>

    </div>

  <!-- Modal -->
  <div class="modal fade" id="modelExample" tabindex="-1" role="dialog">
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
                                        <img src="images/modal1.png" alt="#">
                                    </div>
                                    <div class="single-slider">
                                        <img src="images/modal2.png" alt="#">
                                    </div>
                                    <div class="single-slider">
                                        <img src="images/modal3.png" alt="#">
                                    </div>
                                    <div class="single-slider">
                                        <img src="images/modal4.png" alt="#">
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
                                    <input type="text" name="qty" class="input-number"  data-min="1" data-max="1000" value="1">
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

<script>
    $('#relatedProducts').owlCarousel({
        loop: true,
        margin: 10,
        dots: false,
        nav: true,
        navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
        responsive:{
            0: {
                items:1,
            },
            300: {
                items:1,
            },
            480: {
                items:1,
            },
            768: {
                items:3,
            },
            1170: {
                items:4,
            },
        }
    })
</script>

    {{-- <script>
        $('.cart').click(function(){
            var quantity=$('#quantity').val();
            var pro_id=$(this).data('id');
            // alert(quantity);
            $.ajax({
                url:"{{route('add-to-cart')}}",
                type:"POST",
                data:{
                    _token:"{{csrf_token()}}",
                    quantity:quantity,
                    pro_id:pro_id
                },
                success:function(response){
                    console.log(response);
					if(typeof(response)!='object'){
						response=$.parseJSON(response);
					}
					if(response.status){
						swal('success',response.msg,'success').then(function(){
							document.location.href=document.location.href;
						});
					}
					else{
                        swal('error',response.msg,'error').then(function(){
							document.location.href=document.location.href;
						});
                    }
                }
            })
        });
    </script> --}}

@endpush
