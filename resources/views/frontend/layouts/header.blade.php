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
            <div class="customHeader">
                <div class="leftHeader">
                    <div class="logo">
                        <a href="{{route('home')}}">
                            <img src="@foreach($settings as $data) {{$data->logo}} @endforeach" alt="logo">
                        </a>
                    </div>
                </div>
                <div class="midHeader">
                    <form class="search-form" method="POST" action="{{route('product.search')}}">
                        @csrf
                        <div class="searchWrapper">
                            <input type="text" placeholder="Enter search title, keywords here" name="search">
                            <button type="submit" class="searchIcon">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                    <ul class="searchBarNav">
                        @foreach(Helper::getAllCategoryForSubHeader() as $cat)
                            <li>
                                <a href="{{route('product-cat',$cat->slug)}}">{{$cat->title}}</a>
                            </li>
                        @endforeach
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
                                    <a href="{{route('product-grids')}}">
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
                    <div class="mobileSearch">
                        <i class="fa fa-search"></i>
                        <div class="mobileSearchForm">
                            <form class="search-form" method="POST" action="{{route('product.search')}}">
                                @csrf
                                <div class="searchWrapper">
                                    <input type="text" placeholder="Enter search title, keywords here" name="search">
                                    <button type="submit" class="searchIcon" style="display: none">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="mobileBtn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="menuNanBar">
            {{Helper::getHeaderCategory()}}
        </div>
    </div>
</header>


<!-- mobile fixed bar -->
<div class="fixedBar">
    <div class="container">
        <ul>
            <li>
                <a href="{{route('product-grids')}}">
                    <i class="fa fa-list" aria-hidden="true"></i>
                    <span>Category</span>
                </a>
            </li>
            <li>
                <a href="{{route('cart')}}">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    <span>Cart</span>
                    <span class="total-count">{{Helper::cartCount()}}</span>
                </a>
            </li>
            <li>
                <a href="{{route('login.form')}}">
                    <i class="fa fa-user-o" aria-hidden="true"></i>
                    <span>Sign In</span>
                </a>
            </li>
        </ul>
    </div>
</div>
