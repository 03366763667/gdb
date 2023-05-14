@extends('frontend.layouts.master')

@section('title','GDB || PRODUCT SEARCH    ')

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
                    @foreach($products as $product)
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
                    {!! $products->links() !!}
                </div>

            </div>
        </div>
    </div>



@endsection
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
