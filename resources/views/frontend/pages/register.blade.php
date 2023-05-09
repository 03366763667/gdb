@extends('frontend.layouts.master')

@section('title','GDB || Register Page')

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
                    <a href="{{route('register.form')}}">
                        <span class="crumbText">
                            Register
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
                        <h2>Create an Account</h2>
                        <form class="form" method="post" action="{{route('register.submit')}}">
                            @csrf

                            <div class="form-group">
                                <label for="name">Your Name <span></span></label>
                                <input type="text" name="name" id="name" placeholder="" required="required" value="{{old('name')}}">
                                @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Your Email <span></span></label>
                                <input type="text" name="email" id="email" placeholder="" required="required" value="{{old('email')}}">
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

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password <span></span></label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required="required" value="{{old('password_confirmation')}}">
                                @error('password_confirmation')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="form-group login-btn">
                                <button class="btn customLoginBtn" type="submit">Register</button>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="col col-md-6 col-lg-5">
                    <div class="loginFormLeft">
                        <h3>Welcome to become a Godropship Member.</h3>
                        <p>You focus on sales, we help with dispatching. Everyone can become a seller and get profit easily.</p>
                        <p>We have a simple and convenient process system. Check below information, and then you will know all about us.</p>
                    </div>
                </div>

            </div>
        </div>

    </div>


@endsection
