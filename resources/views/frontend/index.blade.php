@extends('frontend.layouts.master')
@section('title','GDB || HOME PAGE')
@section('main-content')

    <div class="container">

        <!-- Banner Section -->
        <section class="banner-section">
            <div class="row no-gutters">
                <div class="col-lg-12 col-xl-8">
                    <div class="bannerSlider">
                        @if(count($banners)>0)
                            @foreach($banners as $key=>$banner)
                                <div class="bannerSlide">
                                    <a href="{{route('product-grids')}}" aria-hidden="true">
                                        <img class="first-slide" src="{{$banner->photo}}" alt="slide{{$key}}">
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-lg-12 col-xl-4">
                    <div class="bannerContent">
                        <div class="noticeBorad">
                            <h3>
                                <i class="fa fa-volume-up" aria-hidden="true"></i>
                                Notice Board
                            </h3>
                            <div class="noticeBoardDesc">
                                <p>To celebrate the new king, it is a public holiday for whole AU today. All the orders should be collected buy the courier tomorrow. We will still booking label and upload the tracking number today.</p>
                            </div>
                        </div>
                        <div class="noticeBorad">
                            <h3>
                                <i class="fa fa-volume-up" aria-hidden="true"></i>
                                Godropship Academy
                            </h3>
                            <div class="noticeBoardDesc">
                                <ul>
                                    <li>
                                        <a href="">
                                            <i class="fa fa-book" aria-hidden="true"></i>
                                            How Godropship works
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                            <i class="fa fa-question-circle-o" aria-hidden="true"></i>
                                            FAQ
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                            <i class="fa fa-address-book" aria-hidden="true"></i>
                                            User guide
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                            <i class="fa fa-truck" aria-hidden="true"></i>
                                            Shipping
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            Return & exchange terms
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="goDropShipPolicy">
            <div class="policyWrap">
                <i class="fa fa-building" aria-hidden="true"></i>
                <span>All in Stock in AU warehouse</span>
            </div>
            <div class="policyWrap">
                <i class="fa fa-archive" aria-hidden="true"></i>
                <span>Blank Package Without Sender Info</span>
            </div>
            <div class="policyWrap">
                <i class="fa fa-truck" aria-hidden="true"></i>
                <span>2-7 business days Free AU Delivery</span>
            </div>
            <div class="policyWrap">
                <i class="fa fa-clock-o" aria-hidden="true"></i>
                <span>Same Day Despatch Before 9:30AM</span>
            </div>
            <div class="policyWrap">
                <i class="fa fa-sort-numeric-desc" aria-hidden="true"></i>
                <span>All Parcel With Tracking Number</span>
            </div>
        </section>

        <section class="tabsSection">
            <div class="tab">
                <ul class="nav nav-pills">
                    <li class="active"><a href="#newArrival" data-toggle="tab">new arrival</a></li>
                    <li><a href="#weekly" data-toggle="tab">weekly</a></li>
                    <li><a href="#special" data-toggle="tab">special</a></li>
                </ul>
            </div>
            <div class="tab-content well">
            <div id="newArrival" class="tab-pane active">
                <div class="tabDetailWrapper">
                    <div class="row">
                        @if(!empty($newProducts))
                            @foreach($newProducts as $product)
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
                        @else
                            <p>No New Products</p>
                        @endif
                    </div>
                </div>
            </div>

            <div id="weekly" class="tab-pane">
                <div class="tabDetailWrapper">
                    <div class="row">
                        @if(!empty($weeklyProducts))
                            @foreach($weeklyProducts as $product)
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
                        @else
                            <p>No New Products</p>
                        @endif
                    </div>
                </div>
            </div>

            <div id="special" class="tab-pane">
                <div class="tabDetailWrapper">
                    <div class="row">
                        @if(!empty($hotProducts))
                            @foreach($hotProducts as $product)
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
                        @else
                            <p>No New Products</p>
                        @endif
                    </div>
                </div>
            </div>
            </div>
        </section>

    </div>


{{--@include('frontend.layouts.newsletter')--}}

@endsection

@push('scripts')
    {{--    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons' async='async'></script>--}}
    {{--    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons' async='async'></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>

    $(document).ready(function (){
        $('.bannerSlider').owlCarousel({
            loop: false,
            margin: 10,
            nav: false,
            autoplay: true,
            autoplaySpeed:500,
            item: 1,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });

        // hover tabs
        $(".tabsSection .tab ul li a").hover(function(){
            $(this).tab('show');
        });
    });

    </script>

@endpush
