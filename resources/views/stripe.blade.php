@extends('frontend.layouts.master')

@section('title','Stripe Checkout page')

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
            <li>
                <a href="{{route('checkout')}}">
                    <span class="crumbText">
                        Checkout
                    </span>
                </a>
            </li>
            <li class="active">
                <a href="{{route('stripe')}}">
                    <span class="crumbText">
                        Payment
                    </span>
                </a>
            </li>
        </ul>
    </div>
    <!-- End Breadcrumbs -->
    <section class="paymentSection">
        <h2>Payment Details </h2>
        <div class="row justify-content-center">
            <div class="col col-md-8 col-lg-6">
                <div class="stripePaymentWrapper">
                    <div class="panel panel-default credit-card-box">
                        <div class="panel-heading display-table" >
                            <h3 class="panel-title" >Payment Details</h3>
                        </div>
                        <div class="panel-body">

                            @if (Session::has('success'))
                                <div class="alert alert-success text-center">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                    <p>{{ Session::get('success') }}</p>
                                </div>
                            @endif

{{--                            @dd($shipping_id)--}}

                            <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="pk_test_cGwIdoLnp3RZ6YaqzjWbhFqk" id="payment-form">
                                @csrf
                                <input type="hidden" name="shipping_id" value="{{$shipping_id}}">
                                <div class="form-group required">
                                    <label>Name on Card <span></span></label>
                                    <input class='form-control' size='4' type='text' name="cardName">
                                </div>
                                <div class='form-group required'>
                                    <label>Card Number <span></span></label>
                                    <input autocomplete='off' class='form-control card-number' size='20' type='text' name="cardNumber">
                                </div>

                                <div class='form-row row'>
                                    <div class='col-xs-12 col-md-4 form-group cvc required'>
                                        <label>CVC <span></span></label>
                                        <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text' name="cvc">
                                    </div>
                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                        <label>Expiration Month <span></span></label>
                                        <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text' name="expiryMonth">
                                    </div>
                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                        <label>Expiration Year <span></span></label>
                                        <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text' name="expiryYear">
                                    </div>
                                </div>

                                <div class='form-row row'>
                                    <div class='col-md-12 error form-group hide'>
                                        <div class='alert-danger alert'>Please correct the errors and try again.</div>
                                    </div>
                                </div>

                                <div class="payButtons">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Pay</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">

    $(document).ready(function (){
        $("#payment-form").validate({
            // Specify validation rules
            rules: {
                cardName: "required",
                cardNumber: "required",
                cvc: "required",
                expiryMonth: "required",
                expiryYear: "required",
            },
            messages: {
                cardName: {
                    required: "Please enter Candidate First Name",
                },
                cardNumber: {
                    required: "Please enter Candidate Last Name",
                },
                cvc: {
                    required: "Please select country",
                },
                expiryMonth: {
                    required: "Please select state",
                },
                expiryYear: {
                    required: "Please select state",
                }
            },

        });
    });

    $(function() {

        /*------------------------------------------
        --------------------------------------------
        Stripe Payment Code
        --------------------------------------------
        --------------------------------------------*/

        var $form = $(".require-validation");

        $('form.require-validation').bind('submit', function(e) {
            var $form = $(".require-validation"),
                inputSelector = ['input[type=email]', 'input[type=password]',
                    'input[type=text]', 'input[type=file]',
                    'textarea'].join(', '),
                $inputs = $form.find('.required').find(inputSelector),
                $errorMessage = $form.find('div.error'),
                valid = true;
            $errorMessage.addClass('hide');

            $('.has-error').removeClass('has-error');
            $inputs.each(function(i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    $input.parent().addClass('has-error');
                    $errorMessage.removeClass('hide');
                    e.preventDefault();
                }
            });

            if (!$form.data('cc-on-file')) {
                e.preventDefault();
                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeResponseHandler);
            }

        });

        /*------------------------------------------
        --------------------------------------------
        Stripe Response Handler
        --------------------------------------------
        --------------------------------------------*/
        function stripeResponseHandler(status, response) {
            if (response.error) {
                $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
            } else {
                /* token contains id, last4, and card type */
                var token = response['id'];

                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }

    });
</script>
@endpush
