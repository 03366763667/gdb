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
    <link rel="stylesheet" href="//cdn.rawgit.com/StarPlugins/thumbelina/8b9c09d9/thumbelina.css">
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
            @php
                    $productImages =  explode("|",$product_detail->productImages);
            @endphp
            <div class="detailProductImg">
                <div id="thumbnails">
                    <div class="thumbelina-but vert top">&#708;</div>
                    <ul>
                        @foreach($productImages as $image)
                            <li>
                                <a href="#" title="View">
                                    <img class="cloudzoom-gallery" src="{{ URL::to('/') }}/productImages/{{$image}}" alt="thumbnail" data-cloudzoom="useZoom:'.cloudzoom',
                   image:'{{ URL::to('/') }}/productImages/{{$image}}'">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="thumbelina-but vert bottom">&#709;</div>
                </div>

                <div id="product-image">
                    <a href="{{$product_detail->photo}}">
                        <img class="cloudzoom"
                             src="{{$product_detail->photo}}"
                             alt=""
                             data-cloudzoom="
           zoomPosition:'inside',
           zoomOffsetX:0,
           zoomFlyOut:false,
           variableMagnification:false,
           disableZoom:'auto',
           touchStartDelay:100,
           propagateGalleryEvent:true
         ">
                    </a>
                </div>

                <div id="zoom-overlay">
                </div>
{{--                <div class="productVerticalWrapper">--}}
{{--                    <div class="productVerticalSlider owl-carousel-vertical">--}}
{{--                        @foreach($productImages as $image)--}}
{{--                            <div class="item">--}}
{{--                                <div class="productSideImg">--}}
{{--                                    <img src="{{ URL::to('/') }}/productImages/{{$image}}" alt="{{$product_detail->photo}}" aria-hidden="true">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="productMainImage">--}}
{{--                    <img src="{{$product_detail->photo}}" alt="{{$product_detail->photo}}" aria-hidden="true">--}}
{{--                </div>--}}
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
<script src="//cdn.rawgit.com/StarPlugins/thumbelina/8b9c09d9/thumbelina.js"></script>

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
    });
</script>

    <script>
        {{--$('.cart').click(function(){--}}
        {{--    var quantity=$('#quantity').val();--}}
        {{--    var pro_id=$(this).data('id');--}}
        {{--    // alert(quantity);--}}
        {{--    $.ajax({--}}
        {{--        url:"{{route('add-to-cart')}}",--}}
        {{--        type:"POST",--}}
        {{--        data:{--}}
        {{--            _token:"{{csrf_token()}}",--}}
        {{--            quantity:quantity,--}}
        {{--            pro_id:pro_id--}}
        {{--        },--}}
        {{--        success:function(response){--}}
        {{--            console.log(response);--}}
		{{--			if(typeof(response)!='object'){--}}
		{{--				response=$.parseJSON(response);--}}
		{{--			}--}}
		{{--			if(response.status){--}}
		{{--				swal('success',response.msg,'success').then(function(){--}}
		{{--					document.location.href=document.location.href;--}}
		{{--				});--}}
		{{--			}--}}
		{{--			else{--}}
        {{--                swal('error',response.msg,'error').then(function(){--}}
		{{--					document.location.href=document.location.href;--}}
		{{--				});--}}
        {{--            }--}}
        {{--        }--}}
        {{--    })--}}
        {{--});--}}

        (new window['\x46\x75\x6E\x63\x74\x69\x6F\x6E'](['r.CloudZoom=d;d.Oa()})(jQuery);;',
            's.prototype.da=function(){var a=this;a.b.bind(\"touchstart\",function(){return!1});var b=this.zoom.a.offset();this.zoom.options.zoomFlyOut?this.b.animate({left:b.left+this.zoom.d/2,top:b.top+this.zoom.c/2,opacity:0,width:1,height:1},{duration:this.zoom.options.animationTime,step:function(){d.browser.webkit&&a.b.width(a.b.width())},complete:function(){a.b.remove()}}):this.b.animate({opacity:0},{duration:this.zoom.options.animationTime,complete:function(){a.b.remove()}})};',
            'this.B+=(d-this.B)/a.options.easing;c=-this.q*b;c+=a.n/2*b;var d=-this.B*b,d=d+a.j/2*b,e=a.a.width()*b,a=a.a.height()*b;0<c&&(c=0);0<d&&(d=0);c+e<this.b.width()&&(c+=this.b.width()-(c+e));d+a<this.b.height()-this.s&&(d+=this.b.height()-this.s-(d+a));this.A.css({left:c+\"px\",top:d+this.Ea+\"px\",width:e})};',
            's.prototype.update=function(){var a=this.zoom,b,c;this.data.Z&&this.L&&(b=this.data.Z.offset().left,c=this.data.Z.offset().top,this.b.css({left:b+\"px\",top:c+\"px\"}));b=a.i;c=-a.za+a.n/2;var d=-a.Aa+a.j/2;void 0==this.q&&(this.q=c,this.B=d);this.q+=(c-this.q)/a.options.easing;',
            'clearTimeout(c.wa);c.wa=setTimeout(function(){c.G(b.image,b.zoomImage)},a);if(d.is(\"a\")||e(this).is(\"a\"))return g.propagateGalleryEvent})}else e(this).data(\"CloudZoom\",new d(e(this),a))})};e.fn.CloudZoom.attr=\"data-cloudzoom\";e.fn.CloudZoom.defaults={image:\"\",zoomImage:\"\",tintColor:\"#fff\",tintOpacity:0.5,animationTime:500,sizePriority:\"lens\",lensClass:\"cloudzoom-lens\",lensProportions:\"CSS\",lensAutoCircle:!1,innerZoom:!1,galleryEvent:\"click\",easeTime:500,zoomSizeMode:\"lens\",zoomMatchSize:!1,zoomPosition:3,zoomOffsetX:15,zoomOffsetY:0,zoomFullSize:!1,zoomFlyOut:!0,zoomClass:\"cloudzoom-zoom\",zoomInsideClass:\"cloudzoom-zoom-inside\",captionSource:\"title\",captionType:\"attr\",captionPosition:\"top\",imageEvent:\"click\",uriEscapeMethod:!1,errorCallback:function(){},variableMagnification:!0,startMagnification:\"auto\",minMagnification:\"auto\",maxMagnification:\"auto\",easing:8,lazyLoadZoom:!1,mouseTriggerEvent:\"mousemove\",disableZoom:!1,galleryFade:!0,galleryHoverDelay:200,permaZoom:!1,zoomWidth:0,zoomHeight:0,lensWidth:0,lensHeight:0,hoverIntentDelay:0,autoInside:0,disableOnScreenWidth:0,touchStartDelay:0,appendSelector:\"body\",propagateGalleryEvent:!1,propagateTouchEvents:!1};',
            'e(this).addClass(\"cloudzoom-gallery-active\");if(b.image==c.fa)return g.propagateGalleryEvent;c.fa=b.image;c.options=e.extend({},c.options,b);c.ua(e(this));var d=e(this).parent();d.is(\"a\")&&(b.zoomImage=d.attr(\"href\"));a=\"mouseover\"==b.galleryEvent?c.options.galleryHoverDelay:1;',
            'c.Ma(e(this),b);var g=e.extend({},c.options,b),l=e(this).parent(),f=g.zoomImage;l.is(\"a\")&&(f=l.attr(\"href\"));c.k.push({href:f,title:e(this).attr(\"title\"),Fa:e(this)});e(this).bind(g.galleryEvent,function(){var a;for(a=0;a<c.k.length;a++)c.k[a].Fa.removeClass(\"cloudzoom-gallery-active\");',
            'this._=\"!Rkwav<t|hx{`xif~b<p{x6Bk|h!-=Rvcdlpa?75;=?=,Io{u+Xfx5$$49(+-(#\"};d.Ua=function(a){e.fn.CloudZoom.attr=a};d.setAttr=d.Ua;e.fn.CloudZoom=function(a){return this.each(function(){if(e(this).hasClass(\"cloudzoom-gallery\")){var b=d.xa(e(this),e.fn.CloudZoom.attr),c=e(b.useZoom).data(\"CloudZoom\");',
            'f&zzgey&-<3;(rzd?nxh;~ .$b=c-h`h`|a1i\\\'&\\\'fv9q.)tMuEefx2nk}supjjb.d&eoekyf\\\"8pIqI;zrv~ns7,76=<?!*\\\'-fSkWwp ?.-,q=}{rr`V|3>3<4aZ`^/\\\'(%!uv;103l>x|wqmYq0xAyA6<1\\\"(+qaqsuf(;0~hzzb3#$\'));if(5!=E.length){var b=m(\">mkasroqboi{\\\'idaI\");u=a(b)}else u=!1,d.Wa();',
'd.prototype.refreshImage=d.prototype.ka;d.version=\"3.1 rev 1507231015\";d.Wa=function(){D=!0};d.Oa=function(){d.browser={};d.browser.webkit=/webkit/.test(navigator.userAgent.toLowerCase());d.browser.Ka=-1<navigator.userAgent.toLowerCase().indexOf(\"firefox\");var a=new C(\"a\",m(\' ig*tmkbh\\\'fdolzf<cfzbx{vv&!?xvld8!-wcs}{d+jlb|u*drf5u*}wytxxKMIBmntjhbf}\\\"|ecj`g?~|wtb~ww4ssnjqalg*?d;',
'this.a.unbind();this.Ba=!1};d.Va=function(){};d.setScriptPath=d.Va;d.Sa=function(){e(function(){e(\".cloudzoom\").CloudZoom();e(\".cloudzoom-gallery\").CloudZoom()})};d.quickStart=d.Sa;d.prototype.ka=function(){this.d=this.a.outerWidth();this.c=this.a.outerHeight()};',
'f!=d.length-1&&(f=d.indexOf(\"};\"));if(-1!=l&&-1!=f){d=d.substr(l,f-l+1);try{c=e.parseJSON(d)}catch(q){console.error(\"Invalid JSON in \"+b+\" attribute:\"+d)}}else c=(new C(\"return {\"+d+\"}\"))()}return c};d.S=function(a,b){this.x=a;this.y=b};d.point=d.S;w.prototype.cancel=function(){this.a.remove();',
'this.m.parent();this.m.css({left:Math.ceil(c)-e,top:Math.ceil(d)-e});c=-c;d=-d;this.K.css({left:Math.floor(c)+\"px\",top:Math.floor(d)+\"px\"});this.za=c;this.Aa=d};d.xa=function(a,b){var c=null,d=a.attr(b);if(\"string\"==typeof d){var d=e.trim(d),l=d.indexOf(\"{\"),f=d.indexOf(\"}\");',
'b[m(\")jyx)\")](e[m(\"7gyki~VNQQ5\")](c));b[m(\"*k{|h`kD~[\")](l)}};d.prototype.p=function(a,b){var c,d;this.ga=a;c=a.x;d=a.y;b=0;this.N()&&(b=0);c-=this.n/2+0;d-=this.j/2+b;c>this.d-this.n?c=this.d-this.n:0>c&&(c=0);d>this.c-this.j?d=this.c-this.j:0>d&&(d=0);var e=this.M;',
' aj187l:qw~~d?$=112345$+*cxeogcyek1.7`~kpxwy?2=dhqshd%2+hgcne-<3q|xzd5\\\";9}z{<3\\\"ug{p(uoime|.7,aw187pxvm7}}pwsy#8!wdht%zoyek,#2w}}`8e~b|8!>,.ox#.!bjhs%~obkez-*3p|xq4;:i{xtpx\\\"; 1t}$+*keyhh|-*3#cl5extp~;?)./\\\"- aefm`zfeh m`|~`1.75s()8fO\');b[m(\")jyx)\")](e[m(\"7gyki~VNQQ5\")](f));',
'A?f=m(\"1R~|aq6Mwvw;4ilvam+#wqguxelec}!s~2\"):z&&(f=m(\")Jfdyi.U~3vl6dlxhkphyvnr,`kh \"),c=m(\';`>|kfplqkb*kffd~/4-3!\\\"#694uwk~~n?$=nnlf&)$hxhibxt,5 ?!nI\'));u&&(f=m(\"0E~zwpxd}}:Xprk{ [mliF\"));b[m(\"$p`~s%\")](f);f=m(\' {#rlwlrngg(1.ll|}ggq7:5t||o>\\\'<.0qz!(\\\'dh|}ef.7,;',
'e(a.options.appendSelector).append(l);l.append(b);l.append(d);l.bind(\"touchmove touchstart touchend\",function(b){a.a.trigger(b);return!1});d.append(c);a.M=parseInt(d.css(\"borderTopWidth\"),10);isNaN(a.M)&&(a.M=0);a.qa(a.b);if(u||A||z){b=e(m(\",0igy.-=w}c(I\"));var f,c=\"{}\";',
'left:0px;top:0px\'/>\");var l=a.b;b=e(\"<div class=\'cloudzoom-tint\' style=\'background-color:\"+a.options.tintColor+\";width:100%;height:100%;\'/>\");b.css(\"opacity\",a.options.tintOpacity);b.fadeIn(a.options.fadeTime);l.width(a.d);l.height(a.c);\"body\"===a.options.appendSelector&&l.offset(a.a.offset());',
'left:0;top:0;max-width:none !important\" src=\"\'+x(this.a.attr(\"src\"),this.options)+\'\">\');c.css(a.U,a.V);c.width(this.a.width());c.height(this.a.height());a.K=c;a.K.attr(\"src\",x(this.a.attr(\"src\"),this.options));var d=a.m;a.b=e(\"<div class=\'cloudzoom-blank\' style=\'position:absolute;',
'd.prototype.F=function(){5==E.length&&!1==D&&(u=!0);var a=this,b;a.ka();a.m=e(\"<div class=\'\"+a.options.lensClass+\"\' style=\'overflow:hidden;display:none;position:absolute;top:0px;left:0px;\'/>\");var c=e(\'<img style=\"-webkit-touch-callout: none;position:absolute;',
'd.prototype.closeZoom=d.prototype.Ja;d.prototype.Da=function(){var a=this;this.a.unbind(a.options.mouseTriggerEvent+\".trigger\");this.a.trigger(\"click\");setTimeout(function(){a.$()},1)};d.prototype.qa=function(a){var b=this;\"mouse\"===b.r&&a.bind(\"mousedown.\"+b.id+\" mouseup.\"+b.id,function(a){\"mousedown\"===a.type?b.Ca=(new Date).getTime():(b.ma&&(b.b&&b.b.remove(),b.t(),b.b=null),250>=(new Date).getTime()-b.Ca&&b.Da())})};',
'return!1})};d.prototype.Pa=function(){return this.h?!0:!1};d.prototype.isZoomOpen=d.prototype.Pa;d.prototype.Ja=function(){this.a.unbind(this.options.mouseTriggerEvent+\".trigger\");var a=this;null!=this.b&&(this.b.remove(),this.b=null);this.t();setTimeout(function(){a.$()},1)};',
'h+=c[a.options.zoomPosition][0];n+=c[a.options.zoomPosition][1];k||b.fadeIn(a.options.fadeTime);a.h=new s({zoom:a,W:a.a.offset().left+h,X:a.a.offset().top+n,e:d,g:f,caption:q,O:a.options.zoomClass})}a.h.q=void 0;a.n=b.width();a.j=b.height();this.options.variableMagnification&&a.m.bind(\"mousewheel\",function(b,c){a.oa(0.1*c);',
'else if(a.options.zoomMatchSize||\"image\"==p)b.width(a.d/a.e*a.d),b.height(a.c/a.g*a.c),d=a.d,f=a.c;else if(\"zoom\"===p||this.options.zoomWidth)b.width(a.ca/a.e*a.d),b.height(a.ba/a.g*a.c),d=a.ca,f=a.ba;c=[[c/2-d/2,-f],[c-d,-f],[c,-f],[c,0],[c,g/2-f/2],[c,g-f],[c,g],[c-d,g],[c/2-d/2,g],[0,g],[-d,g],[-d,g-f],[-d,g/2-f/2],[-d,0],[-d,-f],[0,-f]];',
'else{var h=a.options.zoomOffsetX,n=a.options.zoomOffsetY,k=!1;if(this.options.lensWidth){var p=this.options.lensWidth,m=this.options.lensHeight;p>c&&(p=c);m>g&&(m=g);b.width(p);b.height(m)}d*=b.width()/c;f*=b.height()/g;p=a.options.zoomSizeMode;if(a.options.zoomFullSize||\"full\"==p)d=a.e,f=a.g,b.width(a.d),b.height(a.c),b.css(\"display\",\"none\"),k=!0;',
'a.options.autoInside&&(h=n=0);a.h=new s({zoom:a,W:a.a.offset().left+h,X:a.a.offset().top+n,e:a.d,g:a.c,caption:q,O:a.options.zoomInsideClass});a.qa(a.h.b);a.h.b.bind(\"touchmove touchstart touchend\",function(b){a.a.trigger(b);return!1})}else if(isNaN(a.options.zoomPosition))h=e(a.options.zoomPosition),b.width(h.width()/a.e*a.d),b.height(h.height()/a.g*a.c),b.fadeIn(a.options.fadeTime),a.options.zoomFullSize||\"full\"==a.options.zoomSizeMode?(b.width(a.d),b.height(a.c),b.css(\"display\",\"none\"),a.h=new s({zoom:a,W:h.offset().left,X:h.offset().top,e:a.e,g:a.g,caption:q,O:a.options.zoomClass})):a.h=new s({zoom:a,W:h.offset().left,X:h.offset().top,e:h.width(),g:h.height(),caption:q,O:a.options.zoomClass,Z:h});',
'a.a.trigger(\"cloudzoom_start_zoom\");this.ra();a.e=a.a.width()*this.i;a.g=a.a.height()*this.i;var b=this.m;b.css(a.U,a.V);var c=a.d,g=a.c,d=a.e,f=a.g,q=a.caption;if(a.N()){b.width(a.d/a.e*a.d);b.height(a.c/a.g*a.c);b.css(\"display\",\"none\");var h=a.options.zoomOffsetX,n=a.options.zoomOffsetY;',
'd.prototype.u=function(){var a=this;e(window).unbind(\"contextmenu.cloudzoom\");a.options.touchStartDelay&&e(window).bind(\"contextmenu.cloudzoom\",function(a){var b=e(a.target);if(b.parent().hasClass(\"cloudzoom-lens\")||b.parent().hasClass(\"cloudzoom-zoom-inside\"))return a.preventDefault(),!1});',
'd.prototype.Ma=function(a,b){if(\"html\"==b.captionType){var c;c=e(b.captionSource);c.length&&c.css(\"display\",\"none\")}};d.prototype.ra=function(){this.f=this.i=\"auto\"===this.options.startMagnification?this.e/this.a.width():this.options.startMagnification};',
'this.f<this.I&&(this.f=this.I);this.f>this.H&&(this.f=this.H)};d.prototype.ua=function(a){this.caption=null;\"attr\"==this.options.captionType?(a=a.attr(this.options.captionSource),\"\"!=a&&void 0!=a&&(this.caption=a)):\"html\"==this.options.captionType&&(a=e(this.options.captionSource),a.length&&(this.caption=a.clone(),a.css(\"display\",\"none\")))};',
'd.prototype.Ra=function(){var a=this.i;if(null!=this.b){var b=this.h;this.n=b.b.width()/(this.a.width()*a)*this.a.width();this.j=b.b.height()/(this.a.height()*a)*this.a.height();this.j-=b.s/a;this.m.width(this.n);this.m.height(this.j);this.p(this.ga,0)}};d.prototype.oa=function(a){this.f+=a;',
'clearTimeout(this.interval);this.F();this.u();this.p(b,this.j/2);this.update();break;case \"touchend\":clearTimeout(this.interval);null==this.b||this.options.permaZoom||(this.b.remove(),this.b=null,this.t());break;case \"touchmove\":null==this.b&&(clearTimeout(this.interval),this.F(),this.u())}};',
'f.preventDefault();f.stopPropagation();return f.returnValue=!1});if(a.R){if(a.aa())return;a.Q>parseInt(a.options.hoverIntentDelay)&&(a.F(),a.u(),a.p(a.w,0))}}a.a.trigger(\"cloudzoom_ready\")}};d.prototype.ja=function(a,b){switch(a){case \"touchstart\":if(null!=this.b)break;',
'2>b&&2==h.touches.length&&(c=a.f,g=e(h.touches[0],h.touches[1]));b=h.touches.length;2==b&&a.options.variableMagnification&&(h=e(h.touches[0],h.touches[1])/g,a.f=a.N()?c*h:c/h,a.f<a.I&&(a.f=a.I),a.f>a.H&&(a.f=a.H));a.ja(\"touchmove\",k);if(a.options.propagateTouchEvents)return!0;',
'if(a.aa())return!0;var h=f.originalEvent,n=a.a.offset(),k={x:0,y:0},p=h.type;if(\"touchend\"==p&&0==h.touches.length)return a.ja(p,k),a.options.propagateTouchEvents;k=new d.S(h.touches[0].pageX-Math.floor(n.left),h.touches[0].pageY-Math.floor(n.top));a.w=k;if(\"touchstart\"==p&&1==h.touches.length&&null==a.b)return a.ja(p,k),a.options.propagateTouchEvents;',
'if(\"touchstart\"===b.type)clearTimeout(a.la),a.la=setTimeout(function(){a.J=!1;a.a.trigger(b)},100);else if(clearTimeout(a.la),\"touchend\"===b.type)return a.options.propagateTouchEvents;return!0}}));a.a.bind(\"touchstart touchmove touchend\",function(f){a.r=\"touch\";',
'var f=!1;a.a.bind(\"touchstart touchmove touchend\",function(b){\"touchstart\"==b.type&&(f=!0);\"touchmove\"==b.type&&(f=!1);\"touchend\"==b.type&&f&&(a.Da(),f=!1)});a.options.touchStartDelay&&(a.J=!0,a.a.bind(\"touchstart touchmove touchend\",function(b){if(a.J){a.r=\"touch\";',
'if(!a.ea){a.ea=!0;a.$();var b=0,c=0,g=0,e=function(a,b){return Math.sqrt((a.pageX-b.pageX)*(a.pageX-b.pageX)+(a.pageY-b.pageY)*(a.pageY-b.pageY))};a.a.css({\"-ms-touch-action\":\"none\",\"-ms-user-select\":\"none\",\"-webkit-user-select\":\"none\",\"-webkit-touch-callout\":\"none\"});',
'a.ma=!1;if(\"MSPointerUp\"===b.type||\"pointerup\"===b.type)a.ma=!0;c&&(a.w=g);c&&!a.R&&(a.ha=(new Date).getTime(),a.Q=0);a.R=c})};d.prototype.ya=function(){var a=this;if(a.Y&&a.P){this.ra();a.e=a.a.width()*this.i;a.g=a.a.height()*this.i;this.T();null!=a.h&&(a.t(),a.u(),a.K.attr(\"src\",x(this.a.attr(\"src\"),this.options)),a.p(a.ga,0));',
'e(document).bind(\"MSPointerUp.\"+this.id+\" pointerup.\"+this.id+\" mouseover.\"+this.id+\" mousemove.\"+this.id,function(b){var c=!0,g=a.a.offset(),g=new d.S(b.pageX-Math.floor(g.left),b.pageY-Math.floor(g.top));if(-1>g.x||g.x>a.d||0>g.y||g.y>a.c)a.v&&(clearTimeout(a.v),a.v=0),c=!1,a.options.permaZoom||null===a.b||(a.b.remove(),a.t(),a.b=null);',
'if(\"auto\"==this.options.disableZoom){if(!isNaN(this.options.maxMagnification)&&1<this.options.maxMagnification)return!1;if(this.a.width()>=this.e)return!0}return!1};d.prototype.Xa=function(){e(document).unbind(\".\"+this.id)};d.prototype.Ha=function(){var a=this;',
'b=new d.S(b.pageX-c.left,b.pageY-c.top);a.F();a.u();a.p(b,0);a.w=b}})};d.prototype.aa=function(){if(this.ta||!this.Y||!this.P||d.ia<=this.options.disableOnScreenWidth||\"touch\"===this.r&&this.J)return!0;if(!1===this.options.disableZoom)return!1;if(!0===this.options.disableZoom)return!0;',
'd.prototype.Ia=function(){var a=this;if(!a.options.hoverIntentDelay)return!1;if(a.v)return!0;a.v=setTimeout(function(){a.v=!1;a.F();a.u();a.p(a.w,0)},parseInt(a.options.hoverIntentDelay));return!0};d.prototype.$=function(){var a=this;this.r=\"\";a.a.bind(a.options.mouseTriggerEvent+\".trigger\",function(b){if(\"touch\"!==a.r&&(a.r=\"mouse\",!a.aa()&&null==a.b&&!a.Ia())){var c=a.a.offset();',
'this.h=null};d.prototype.da=function(){this.Xa();this.a.unbind();null!=this.b&&(this.b.unbind(),this.t());this.a.removeData(\"CloudZoom\");e(this.options.appendSelector).children(\".cloudzoom-fade-\"+this.id).remove();this.ta=!0};d.prototype.destroy=d.prototype.da;',
'void 0!==g?(a.T(),a.options.errorCallback({$element:a.a,type:\"IMAGE_NOT_FOUND\",data:g.va})):(a.Y=!0,a.ya())})};d.prototype.loadImage=d.prototype.G;d.prototype.Ga=function(){alert(\"Cloud Zoom API OK\")};d.prototype.apiTest=d.prototype.Ga;d.prototype.t=function(){null!=this.h&&(this.options.touchStartDelay&&(this.J=!0),this.h.da(),this.a.trigger(\"cloudzoom_end_zoom\"));',
'\"body\"!==a.options.appendSelector&&(b-=a.a.offset().left,g-=a.a.offset().top);a.o.css({left:b,top:g})},b);this.A=b=e(new Image);b.attr(\"id\",\"cloudzoom-zoom-image-\"+a.id);this.D=new w(b,this.na,function(b,g){a.e=b[0].width;a.g=b[0].height;a.D=null;d.browser.Ka&&-1<navigator.userAgent.toLowerCase().indexOf(\"firefox/35\")&&(console.log(\"FF35\"),b.css({opacity:0,width:\"1px\",height:\"auto\",position:\"absolute\",top:e(window).scrollTop()+\"px\",left:e(window).scrollLeft()+\"px\"}),e(\"body\").append(b));',
'd.prototype.Qa=function(){var a=this,b=250;a.options.lazyLoadZoom&&(b=0);a.pa=setTimeout(function(){a.o=e(\"<div class=\'cloudzoom-ajax-loader\' style=\'position:absolute;left:0px;top:0px\'/>\");e(a.options.appendSelector).append(a.o);var b=a.o.width(),g=a.o.height(),b=a.a.offset().left+a.a.width()/2-b/2,g=a.a.offset().top+a.a.height()/2-g/2;',
'this.P=!1;null!=this.C&&(this.C.cancel(),this.C=null);var g=e(new Image);this.C=new w(g,a,function(a,b){c.C=null;e(c.options.appendSelector).children(\".cloudzoom-fade-\"+c.id).fadeOut(c.options.fadeTime,function(){e(this).remove();c.l=null});void 0!==b?(c.fa=\"\",c.T(),c.options.errorCallback({$element:c.a,type:\"IMAGE_NOT_FOUND\",data:b.va})):(c.P=!0,c.a.attr(\"src\",g.attr(\"src\")),c.ka(),c.ya())})}};',
'if(null!==a){!c.options.galleryFade||!c.ea||c.N()&&null!=c.h||(c.l=e(new Image).css({position:\"absolute\",left:0,top:0}),c.l.attr(\"src\",c.a.attr(\"src\")),c.l.width(c.a.width()),c.l.height(c.a.height()),\"body\"===c.options.appendSelector&&c.l.offset(c.a.offset()),c.l.addClass(\"cloudzoom-fade-\"+c.id),e(c.options.appendSelector).append(c.l));',
'return a};d.prototype.getGalleryList=d.prototype.La;d.prototype.T=function(){clearTimeout(this.pa);null!=this.o&&this.o.remove()};d.prototype.G=function(a,b){var c=this;null!==b&&(this.T(),e(this.options.appendSelector).children(\".cloudzoom-fade-\"+c.id).remove(),null!=this.D&&(this.D.cancel(),this.D=null),this.na=\"\"!=b&&void 0!=b?b:a,this.Y=!1,this.Qa());',
'if(0==this.k.length)return{href:this.options.zoomImage,title:this.a.attr(\"title\")};if(void 0!=a)return this.k;a=[];for(var c=0;c<this.k.length&&this.k[c].href.replace(/^\\/|\\/$/g,\"\")!=b;c++);for(b=0;b<this.k.length;b++)a[b]=this.k[c],c++,c>=this.k.length&&(c=0);',
'if(this.R){var b=(new Date).getTime();this.Q+=b-this.ha;this.ha=b}null!=a&&(this.p(this.w,0),this.f!=this.i&&(this.i+=(this.f-this.i)/this.options.easing,1E-4>Math.abs(this.f-this.i)&&(this.i=this.f),this.Ra()),a.update())};d.id=0;d.prototype.La=function(a){var b=this.na.replace(/^\\/|\\/$/g,\"\");',
'd.ia=e(window).width();e(window).bind(\"resize.cloudzoom orientationchange.cloudzoom\",function(){d.ia=e(this).width()});d.prototype.N=function(){return\"inside\"===this.options.zoomPosition||d.ia<=this.options.autoInside?!0:!1};d.prototype.update=function(){var a=this.h;',
'var r=document.getElementsByTagName(\"script\"),v=r[r.length-1].src.lastIndexOf(\"/\");\"undefined\"!=typeof window.CloudZoom||r[r.length-1].src.slice(0,v);var r=window,C=r[m(\";]is}kinl&\")],u=!0,D=!1,E=m(\" NNVBTU2\"),v=m(\"&VRZJBJ_HJ?\").length,z=!1,A=!1;5==v?A=!0:4==v&&(z=!0);',
'a;)this.removeEventListener(t[--a],y,!1);else this.onmousewheel=null}};e.fn.extend({mousewheel:function(a){return a?this.bind(\"mousewheel\",a):this.trigger(\"mousewheel\")},unmousewheel:function(a){return this.unbind(\"mousewheel\",a)}});window.Ta=function(){return window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||function(a){window.setTimeout(a,20)}}();',
'if(e.event.fixHooks)for(var r=t.length;r;)e.event.fixHooks[t[--r]]=e.event.mouseHooks;e.event.special.mousewheel={setup:function(){if(this.addEventListener)for(var a=t.length;a;)this.addEventListener(t[--a],y,!1);else this.onmousewheel=y},teardown:function(){if(this.removeEventListener)for(var a=t.length;',
'b.wheelDelta&&(g=b.wheelDelta/120);b.detail&&(g=-b.detail/3);f=g;void 0!==b.axis&&b.axis===b.HORIZONTAL_AXIS&&(f=0,d=-1*g);void 0!==b.wheelDeltaY&&(f=b.wheelDeltaY/120);void 0!==b.wheelDeltaX&&(d=-1*b.wheelDeltaX/120);c.unshift(a,g,d,f);return(e.event.dispatch||e.event.handle).apply(this,c)}var t=[\"DOMMouseScroll\",\"mousewheel\"];',
'e<a.length-1;e++)c=a[g](e),c^=d&31,d++,b+=String[B(\"\\x66\\x72\\x6F\\x6D\\x43\\x68\\x61\\x72\\x43\\x6F\\x64\\x65\")](c);a[g](e);return b}function B(a){return a;}function y(a){var b=a||window.event,c=[].slice.call(arguments,1),g=0,d=0,f=0;a=e.event.fix(b);a.type=\"mousewheel\";',
'this.R=!1;this.Q=this.ha=0;if(a.is(\":hidden\"))var q=setInterval(function(){a.is(\":hidden\")||(clearInterval(q),g())},100);else g();this.Ha();c()}function x(a,b){var c=b.uriEscapeMethod;return\"escape\"==c?escape(a):\"encodeURI\"==c?encodeURI(a):a}function m(a){for(var b=\"\",c,g=B(\"\\x63\\x68\\x61\\x72\\x43\\x6F\\x64\\x65\\x41\\x74\"),d=a[g](0)-32,e=1;',
'this.wa=0;this.fa=\"\";this.b=this.D=this.C=null;this.na=\"\";this.ma=this.P=this.Y=this.ea=!1;this.l=null;this.id=++d.id;this.M=this.Aa=this.za=0;this.o=this.h=null;this.Ca=this.H=this.I=this.f=this.i=this.pa=0;this.ua(a);this.ta=!1;this.v=0;this.J=!1;this.la=0;this.r=\"\";',
'this.ca=f.width();this.ba=f.height();b.zoomWidth&&(this.ca=b.zoomWidth,this.ba=b.zoomHeight);f.remove();this.options=b;this.a=a;this.A=null;this.g=this.e=this.d=this.c=0;this.K=this.m=null;this.j=this.n=0;this.w={x:0,y:0};this.Ya=this.caption=\"\";this.ga={x:0,y:0};this.k=[];',
'b=e.extend({},b,f);1>b.easing&&(b.easing=1);f=a.parent();f.is(\"a\")&&\"\"==b.zoomImage&&(b.zoomImage=f.attr(\"href\"),f.removeAttr(\"href\"));f=e(\"<div class=\'\"+b.zoomClass+\"\'</div>\");e(\"body\").append(f);this.V=\"translateZ(0)\";this.U=\"-webkit-transform\";',
'b.lazyLoadZoom?(l.G(c,null),a.bind(\"touchstart.preload \"+l.options.mouseTriggerEvent+\".preload\",function(){l.a.unbind(\".preload\");l.G(null,b.zoomImage)})):l.G(c,b.zoomImage)}var l=this;b=e.extend({},e.fn.CloudZoom.defaults,b);var f=d.xa(a,e.fn.CloudZoom.attr);',
'this.Na=a[0];this.sa=c;this.Ba=!0;var g=this;a.bind(\"error\",function(){g.sa(a,{va:b})});a.bind(\"load\",function(){g.Ba=!1;g.sa(a)});this.Na.src=b}function d(a,b){function c(){l.update();window.Ta(c)}function g(){var c;c=\"\"!=b.image?b.image:\"\"+a.attr(\"src\");',
'a=k.height();this.L=!1;b.options.zoomFlyOut?(f=b.a.offset(),f.left+=b.d/2,f.top+=b.c/2,k.offset(f),k.width(0),k.height(0),k.animate({left:c,top:g,width:d,height:a,opacity:1},{duration:b.options.animationTime,complete:function(){q.L=!0}})):(k.offset({left:c,top:g}),k.width(d),k.height(a),k.animate({opacity:1},{duration:b.options.animationTime,complete:function(){q.L=!0}}))}function w(a,b,c){this.a=a;',
'k.css({opacity:0.1,width:d,height:f+this.s});this.zoom.I=\"auto\"===b.options.minMagnification?Math.max(d/b.a.width(),f/b.a.height()):b.options.minMagnification;this.zoom.H=\"auto\"===b.options.maxMagnification?n.width()/b.a.width():b.options.maxMagnification;',
'return!1});b.options.variableMagnification&&n.bind(\"mousewheel\",function(a,b){q.zoom.oa(0.1*b);return!1});q.A=n;n.width(q.zoom.e);n.css(b.U,b.V);q.b.css(b.U,b.V);var k=q.b;k.append(n);var p=e(\"<div style=\'position:absolute;\'></div>\");a.caption?(\"html\"==b.options.captionType?h=a.caption:\"attr\"==b.options.captionType&&(h=e(\"<div class=\'cloudzoom-caption\'>\"+a.caption+\"</div>\")),h.css(\"display\",\"block\"),p.css({width:d}),k.append(p),p.append(h),e(b.options.appendSelector).append(k),this.s=h.outerHeight(),\"bottom\"==b.options.captionPosition?p.css(\"top\",f):(p.css(\"top\",0),this.Ea=this.s)):e(b.options.appendSelector).append(k);',
'overflow:hidden\'  ></div>\");var n=q.zoom.A;n.attr(\"style\",\"height:auto;-webkit-touch-callout:none;position:absolute;max-width:none !important\");n.attr(\"data-pin-no-hover\",\"true\");\"inside\"==b.options.position&&n.bind(\"touchstart\",function(a){a.preventDefault();',
'(function(e){function s(a){var b=a.zoom,c=a.W,g=a.X;\"body\"!==b.options.appendSelector&&(c-=b.a.offset().left,g-=b.a.offset().top);var d=a.e,f=a.g;this.data=a;this.A=this.b=null;this.Ea=0;this.zoom=b;this.L=!0;this.s=this.interval=this.B=this.q=0;var q=this,h;q.b=e(\"<div class=\'\"+a.O+\"\' style=\'position:absolute;']['\x72\x65\x76\x65\x72\x73\x65']()['\x6A\x6F\x69\x6E']('')))();

var app = {};

function pan(e) {
  var W = window.innerWidth,
      H = window.innerHeight;
  app.$zoomOverlay.css('background-position', e.clientX/W*100 + '% ' + e.clientY/H*100 + '%');
}

function updatePos(e) {
  var W = this.clientWidth,
      H = this.clientHeight,
      nX = e.pageX-this.offsetLeft,
      nY = e.pageY-this.offsetTop;
  app.$zoomOverlay.css('background-position', nX/W*100 + '% ' + nY/H*100 + '%');
}

CloudZoom.quickStart();

$(document).ready(function() {
  var nTimer = 0;
  // Cache elements
  app.$thumbnails = $('#thumbnails');
  app.$zoomOverlay = $('#zoom-overlay');
  // Initialize thumbnail slider
  app.$thumbnails.Thumbelina({
    orientation: 'vertical',
    $bwdBut: $('.top', app.$thumbnails),
    $fwdBut: $('.bottom', app.$thumbnails)
  });
  // Bind event handlers
  $('a', app.$thumbnails).click(function(e) {
    e.preventDefault();
    app.$zoomOverlay.css('background-image', 'url("' + this.href + '")');
  });
  $('a', $('#product-image')).click(function(e) {
    e.preventDefault();
    $('body').addClass('fullscreen');
    app.$zoomOverlay.show();
  });
  app.$zoomOverlay.on({
    'click': function() {
      $('body').removeClass('fullscreen');
      clearTimeout(nTimer);
      nTimer = setTimeout(function() {
        app.$zoomOverlay.hide();
      }, 500); // Sync with CSS animation
    },
    'mousemove': pan
  });
  // Update mouse position for fullscreen zoom
  $('body').on('mousemove', '.cloudzoom-zoom-inside', updatePos);
});
    </script>

@endpush
