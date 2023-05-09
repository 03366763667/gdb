@extends('frontend.layouts.master')

@section('title','GDB || PRODUCT PAGE')

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
                    <a href="{{route('product-grids')}}">
                        <span class="crumbText">
                            Shop Grid
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Breadcrumbs -->

        <div class="sidebarLayout">
            <!-- Side bar -->
            <aside class="sideBar">
                <div class="sidebarNav">
                    <h4>Categories</h4>
                    <ul>
                        @foreach($productCategory as $cat_info)
                            <li>
                                <a href="{{route('product-cat',$cat_info->slug)}}">
                                    {{$cat_info->title}}
                                </a>
                                @if(count($cat_info->child_cat))
                                    <span class="openSubCategory">
                                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                    </span>
                                @endif
                                <div class="subCategoriesWrapper">
                                      <ul>
                                          @foreach($cat_info->child_cat as $sub_menu)
                                              <li>
                                                  <a href="{{route('product-sub-cat',[$cat_info->slug,$sub_menu->slug])}}">
                                                      {{$sub_menu->title}}
                                                  </a>
                                              </li>
                                          @endforeach
                                      </ul>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            <!-- right content -->
            <div class="sidebarContent">
                <div class="filterBar">
                    <div class="girdView">
                        <span>View: </span>
                        <ul class="gridViewData">
                            <li>
                                <a href="javascript:void(0)" class="gridView active">
                                    <i class="fa fa-th" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li>
{{--                                <a href="{{route('product-lists')}}">--}}
                                <a href="jaavscript:void(0)" class="listView">
                                    <i class="fa fa-list" aria-hidden="true"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="ProductListing">
                    @foreach($recent_products as $product)
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
                <div class="paginationWrapper">
                    {!! $recent_products->links() !!}
                </div>

            </div>
        </div>
    </div>


    <!-- Modal -->
    @if($products)
        @foreach($products as $key=>$product)
            <div class="modal fade" id="{{$product->id}}" tabindex="-1" role="dialog">
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
                                                    @php
                                                        $photo=explode(',',$product->photo);
                                                    // dd($photo);
                                                    @endphp
                                                    @foreach($photo as $data)
                                                        <div class="single-slider">
                                                            <img src="{{$data}}" alt="{{$data}}">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        <!-- End Product slider -->
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                        <div class="quickview-content">
                                            <h2>{{$product->title}}</h2>
                                            <div class="quickview-ratting-review">
                                                <div class="quickview-ratting-wrap">
                                                    <div class="quickview-ratting">
                                                        {{-- <i class="yellow fa fa-star"></i>
                                                        <i class="yellow fa fa-star"></i>
                                                        <i class="yellow fa fa-star"></i>
                                                        <i class="yellow fa fa-star"></i>
                                                        <i class="fa fa-star"></i> --}}
                                                        @php
                                                            $rate=DB::table('product_reviews')->where('product_id',$product->id)->avg('rate');
                                                            $rate_count=DB::table('product_reviews')->where('product_id',$product->id)->count();
                                                        @endphp
                                                        @for($i=1; $i<=5; $i++)
                                                            @if($rate>=$i)
                                                                <i class="yellow fa fa-star"></i>
                                                            @else
                                                            <i class="fa fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <a href="#"> ({{$rate_count}} customer review)</a>
                                                </div>
                                                <div class="quickview-stock">
                                                    @if($product->stock >0)
                                                    <span><i class="fa fa-check-circle-o"></i> {{$product->stock}} in stock</span>
                                                    @else
                                                    <span><i class="fa fa-times-circle-o text-danger"></i> {{$product->stock}} out stock</span>
                                                    @endif
                                                </div>
                                            </div>
                                            @php
                                                $after_discount=($product->price-($product->price*$product->discount)/100);
                                            @endphp
                                            <h3><small><del class="text-muted">${{number_format($product->price,2)}}</del></small>    ${{number_format($after_discount,2)}}  </h3>
                                            <div class="quickview-peragraph">
                                                <p>{!! html_entity_decode($product->summary) !!}</p>
                                            </div>
                                            @if($product->size)
                                                <div class="size">
                                                    <h4>Size</h4>
                                                    <ul>
                                                        @php
                                                            $sizes=explode(',',$product->size);
                                                            // dd($sizes);
                                                        @endphp
                                                        @foreach($sizes as $size)
                                                        <li><a href="#" class="one">{{$size}}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <div class="size">
                                                <div class="row">
                                                    <div class="col-lg-6 col-12">
                                                        <h5 class="title">Size</h5>
                                                        <select>
                                                            @php
                                                            $sizes=explode(',',$product->size);
                                                            // dd($sizes);
                                                            @endphp
                                                            @foreach($sizes as $size)
                                                                <option>{{$size}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    {{-- <div class="col-lg-6 col-12">
                                                        <h5 class="title">Color</h5>
                                                        <select>
                                                            <option selected="selected">orange</option>
                                                            <option>purple</option>
                                                            <option>black</option>
                                                            <option>pink</option>
                                                        </select>
                                                    </div> --}}
                                                </div>
                                            </div>
                                            <form action="{{route('single-add-to-cart')}}" method="POST">
                                                @csrf
                                                <div class="quantity">
                                                    <!-- Input Order -->
                                                    <div class="input-group">
                                                        <div class="button minus">
                                                            <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                                <i class="ti-minus"></i>
                                                            </button>
                                                        </div>
                                                        <input type="hidden" name="slug" value="{{$product->slug}}">
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
                                                    <button type="submit" class="btn">Add to cart</button>
                                                    <a href="{{route('add-to-wishlist',$product->slug)}}" class="btn min"><i class="ti-heart"></i></a>
                                                </div>
                                            </form>
                                            <div class="default-social">
                                            <!-- ShareThis BEGIN --><div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        @endforeach
    @endif
    <!-- Modal end -->

@endsection
@push('styles')
<style>
    .pagination{
        display:inline-flex;
    }
    .filter_button{
        /* height:20px; */
        text-align: center;
        background:#F7941D;
        padding:8px 16px;
        margin-top:10px;
        color: white;
    }
</style>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    {{-- <script>
        $('.cart').click(function(){
            var quantity=1;
            var pro_id=$(this).data('id');
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
							// document.location.href=document.location.href;
						});
                    }
                }
            })
        });
    </script> --}}
    <script>
        $(document).ready(function(){
        /*----------------------------------------------------*/
        /*  Jquery Ui slider js
        /*----------------------------------------------------*/
        if ($("#slider-range").length > 0) {
            const max_value = parseInt( $("#slider-range").data('max') ) || 500;
            const min_value = parseInt($("#slider-range").data('min')) || 0;
            const currency = $("#slider-range").data('currency') || '';
            let price_range = min_value+'-'+max_value;
            if($("#price_range").length > 0 && $("#price_range").val()){
                price_range = $("#price_range").val().trim();
            }

            let price = price_range.split('-');
            $("#slider-range").slider({
                range: true,
                min: min_value,
                max: max_value,
                values: price,
                slide: function (event, ui) {
                    $("#amount").val(currency + ui.values[0] + " -  "+currency+ ui.values[1]);
                    $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                }
            });
            }
        if ($("#amount").length > 0) {
            const m_currency = $("#slider-range").data('currency') || '';
            $("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
                "  -  "+m_currency + $("#slider-range").slider("values", 1));
            };

        // openSubCategory
            $('.openSubCategory').click(function (){
                $(this).toggleClass('rotateIcon');
                $(this).parent().children('.subCategoriesWrapper').slideToggle();
            });

            $(window).scroll(function() {
                var scroll = $(window).scrollTop();
                if (scroll >= 175) {
                    $("body").addClass("stickyHeader");
                }else{
                    $("body").removeClass("stickyHeader");
                }
            });

        //    list view
            $('.listView').click(function (){
                $('.gridView').removeClass('active');
                $('.ProductListing').removeClass('gridViewData');
                $(this).addClass('active');
                $('.ProductListing').addClass('listViewData')
            });

            //    Grid view
            $('.gridView').click(function (){
                $('.listView').removeClass('active');
                $('.ProductListing').removeClass('listViewData');
                $(this).addClass('active');
                $('.ProductListing').addClass('gridViewData');
            });

        });
    </script>
@endpush
