@extends('frontend.layouts.master')

@section('title','GDB || Login Page')

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
                    <a href="{{route('login.form')}}">
                        <span class="crumbText">
                            Login
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Breadcrumbs -->

        <div class="loginFormWrapper">
            <div class="row">
                <div class="col col-md-6 col-lg-7">
                    <div class="loginFormRight">
                        <h2>Sign In</h2>
                        <form class="form" method="post" action="{{route('login.submit')}}">
                            @csrf
                            <div class="form-group">
                                <label for="email">Your Email <span></span></label>
                                <input type="email" name="email" id="email" placeholder="" required="required" value="{{old('email')}}">
                                @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Your Password <span></span></label>
                                <input type="password" name="password" id="password" placeholder="" required="required" value="{{old('password')}}">
                                @error('password')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="passwordWrapper">
                                @if (Route::has('password.request'))
                                    <a class="lost-pass" href="{{ route('password.reset') }}">
                                        Lost your password?
                                    </a>
                                @endif
                            </div>
                            <div class="form-group login-btn">
                                <button class="btn customLoginBtn" type="submit">Login</button>
{{--                                <a href="{{route('register.form')}}" class="btn customLoginBtn">Register</a>--}}
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col col-md-6 col-lg-5">
                    <div class="loginFormLeft">
                        <h2>LOGIN OR CREATE AN ACCOUNT</h2>
                        <h3>NEW CUSTOMERS</h3>
                        <p>By creating an account with our store, you will be able to move through the checkout process faster, store multiple shipping addresses, view and track your orders in your account and more.</p>
                        <a href="{{route('register.form')}}" class="creatAccount">Creat an Account</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

