@php $settings = DB::table('settings')->get(); @endphp
<header id="header">
    <div class="container">
        <div class="topHeader">
            <a href="mailto:@foreach($settings as $data) {{$data->email}} @endforeach">
                <i class="fa fa-envelope-o"></i>
                <span>Email: @foreach($settings as $data) {{$data->email}} @endforeach</span>
             </a>
            <a href="{{route('wishlist')}}">
                <i class="fa fa-heart-o"></i>
                <span>My Wishlist (<span class="wishListCount">{{Helper::wishlistCount()}}</span>)</span>
            </a>
        </div>

        <div class="bottomHeader">
            <div class="leftHeader">
                <div class="logo">
                    <a href="{{route('home')}}">
                        <img src="@foreach($settings as $data) {{$data->logo}} @endforeach" alt="logo">
                    </a>
                </div>
            </div>
            <div class="midHeader">
                <form class="search-form">
                    <div class="searchWrapper">
                        <input type="text" placeholder="Enter search title, keywords here" name="search">
                        <button type="submit" class="searchIcon">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
                <ul class="searchBarNav">
                    <li>
                        <a href="#">Dress</a>
                    </li>
                    <li>
                        <a href="#">Camping</a>
                    </li>
                    <li>
                        <a href="#">RFID</a>
                    </li>
                    <li>
                        <a href="#">Suspenders</a>
                    </li>
                    <li>
                        <a href="#">Posture Corrector</a>
                    </li>

                    <li>
                        <a href="#">Fountain</a>
                    </li>
                    <li>
                        <a href="#">Jewelry Box</a>
                    </li>
                    <li>
                        <a href="#">Picnic Blanket</a>
                    </li>
                    <li>
                        <a href="#">BBQ</a>
                    </li>
                </ul>
            </div>
            <div class="rightHeader">
                @php
                    $total_prod=0;
                    $total_amount=0;
                @endphp
                @if(session('wishlist'))
                    @foreach(session('wishlist') as $wishlist_items)
                        @php
                            $total_prod+=$wishlist_items['quantity'];
                            $total_amount+=$wishlist_items['amount'];
                        @endphp
                    @endforeach
                @endif
                <div class="userInfo">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user-o"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" data-popper-placement="bottom-start">
                            <ul class="list-main">
                                @auth
                                    @if(Auth::user()->role=='admin')
                                        <li>
                                            <a href="{{route('admin')}}"  target="_blank">Dashboard</a>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{route('user')}}"  target="_blank">Dashboard</a>
                                        </li>
                                    @endif
                                    <li>
                                        <a href="{{route('user.logout')}}">Logout</a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{route('login.form')}}">Sign In</a>
                                    </li>
                                    <li>
                                        <a href="{{route('register.form')}}">Register</a>
                                    </li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="cartInfo">
                    <div class="cartList">
                        <a href="{{route('cart')}}" class="cartIcon">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            <span class="total-count">{{Helper::cartCount()}}</span>
                        </a>
                        @auth
                            <div class="shopping-item">
                                @if(count(Helper::getAllProductFromCart()) != 0)
                                <div class="dropdown-cart-header">
                                    <a href="{{route('cart')}}">View Cart</a>
                                    <span>{{count(Helper::getAllProductFromCart())}} Items</span>
                                </div>
                                <ul class="shopping-list">
                                    {{-- {{Helper::getAllProductFromCart()}} --}}
                                    @foreach(Helper::getAllProductFromCart() as $data)
                                        @php
                                            $photo=explode(',',$data->product['photo']);
                                        @endphp
                                        <li>
                                            <a class="cart-img" href="#"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></a>
                                            <h4>
                                                <a href="{{route('product-detail',$data->product['slug'])}}" target="_blank">{{$data->product['title']}}</a>
                                                <p class="quantity">{{$data->quantity}} x - <span class="amount">${{number_format($data->price,2)}}</span></p>
                                            </h4>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="bottom">
                                    <div class="total">
                                        <a href="{{route('cart-delete',$data->id)}}" class="remove" title="Remove this item">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <div class="totalCartPrice">
                                            <span>Total</span>
                                            <span class="total-amount">${{number_format(Helper::totalCartPrice(),2)}}</span>
                                        </div>
                                    </div>
                                    <a href="{{route('checkout')}}" class="btn customBlueBtn">Checkout</a>
                                </div>
                            </div>
                        @else
                            <div class="emptyCart">
                                <p>The Shopping Cart is Empty!</p>
                                <a href="">
                                    <span>Go Shopping</span>
                                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                </a>
                            </div>
                        @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>

    </div>
</header>




<header class="header shop">
    <!-- Topbar -->

    <!-- End Topbar -->
    <div class="middle-inner">
        <div class="container">
            <div class="headerWrapper">

                <div class="SearchBarWrapper">
                    <div class="search-bar-top">
                        <div class="search-bar">
                            <select>
                                <option >All Category</option>
                                @foreach(Helper::getAllCategory() as $cat)
                                    <option>{{$cat->title}}</option>
                                @endforeach
                            </select>
                            <form method="POST" action="{{route('product.search')}}">
                                @csrf
                                <input name="search" class="form-control" placeholder="Search By Product" type="search">
                                <button class="searchIcon" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="rightHeader">
                    <div class="right-bar">
                        <!-- Search Form -->
                        <div class="sinlge-bar shopping">
                            @php
                                $total_prod=0;
                                $total_amount=0;
                            @endphp
                           @if(session('wishlist'))
                                @foreach(session('wishlist') as $wishlist_items)
                                    @php
                                        $total_prod+=$wishlist_items['quantity'];
                                        $total_amount+=$wishlist_items['amount'];
                                    @endphp
                                @endforeach
                           @endif
                            <a href="{{route('wishlist')}}" class="single-icon"><i class="fa fa-heart-o"></i> <span class="total-count">{{Helper::wishlistCount()}}</span></a>
                            <!-- Shopping Item -->
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{count(Helper::getAllProductFromWishlist())}} Items</span>
                                        <a href="{{route('wishlist')}}">View Wishlist</a>
                                    </div>
                                    <ul class="shopping-list">
                                        {{-- {{Helper::getAllProductFromCart()}} --}}
                                            @foreach(Helper::getAllProductFromWishlist() as $data)
                                                    @php
                                                        $photo=explode(',',$data->product['photo']);
                                                    @endphp
                                                    <li>
                                                        <a href="{{route('wishlist-delete',$data->id)}}" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
                                                        <a class="cart-img" href="#"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></a>
                                                        <h4><a href="{{route('product-detail',$data->product['slug'])}}" target="_blank">{{$data->product['title']}}</a></h4>
                                                        <p class="quantity">{{$data->quantity}} x - <span class="amount">${{number_format($data->price,2)}}</span></p>
                                                    </li>
                                            @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            <span class="total-amount">${{number_format(Helper::totalWishlistPrice(),2)}}</span>
                                        </div>
                                        <a href="{{route('cart')}}" class="btn animate">Cart</a>
                                    </div>
                                </div>
                            @endauth
                            <!--/ End Shopping Item -->
                        </div>
                        {{-- <div class="sinlge-bar">
                            <a href="{{route('wishlist')}}" class="single-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                        </div> --}}
                        <div class="sinlge-bar shopping">
                            <a href="{{route('cart')}}" class="single-icon"><i class="ti-bag"></i> <span class="total-count">{{Helper::cartCount()}}</span></a>
                            <!-- Shopping Item -->
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{count(Helper::getAllProductFromCart())}} Items</span>
                                        <a href="{{route('cart')}}">View Cart</a>
                                    </div>
                                    <ul class="shopping-list">
                                        {{-- {{Helper::getAllProductFromCart()}} --}}
                                            @foreach(Helper::getAllProductFromCart() as $data)
                                                    @php
                                                        $photo=explode(',',$data->product['photo']);
                                                    @endphp
                                                    <li>
                                                        <a href="{{route('cart-delete',$data->id)}}" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
                                                        <a class="cart-img" href="#"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></a>
                                                        <h4><a href="{{route('product-detail',$data->product['slug'])}}" target="_blank">{{$data->product['title']}}</a></h4>
                                                        <p class="quantity">{{$data->quantity}} x - <span class="amount">${{number_format($data->price,2)}}</span></p>
                                                    </li>
                                            @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            <span class="total-amount">${{number_format(Helper::totalCartPrice(),2)}}</span>
                                        </div>
                                        <a href="{{route('checkout')}}" class="btn animate">Checkout</a>
                                    </div>
                                </div>
                            @endauth
                            <!--/ End Shopping Item -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="menu-area">
                            <!-- Main Menu -->
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">
                                    <div class="nav-inner">
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li class="{{Request::path()=='home' ? 'active' : ''}}"><a href="{{route('home')}}">Home</a></li>
                                            <li class="{{Request::path()=='about-us' ? 'active' : ''}}"><a href="{{route('about-us')}}">About Us</a></li>
                                            <li class="@if(Request::path()=='product-grids'||Request::path()=='product-lists')  active  @endif"><a href="{{route('product-grids')}}">Products</a><span class="new">New</span></li>
                                                {{Helper::getHeaderCategory()}}
                                            <li class="{{Request::path()=='blog' ? 'active' : ''}}"><a href="{{route('blog')}}">Blog</a></li>

                                            <li class="{{Request::path()=='contact' ? 'active' : ''}}"><a href="{{route('contact')}}">Contact Us</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <!--/ End Main Menu -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header>
