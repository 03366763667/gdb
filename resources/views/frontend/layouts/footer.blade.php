@php $settings = DB::table('settings')->get(); @endphp
<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col col-md-4">
                <div class="footerContent">
                    <h4>INFORMATION</h4>
                    <ul>
                        <li><a href="{{route('about-us')}}">About Go Dropship</a></li>
                        <li><a href="#">Dropship User Guide</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Privacy Statement</a></li>
                        <li><a href="{{route('contact')}}">Contact us</a></li>
                    </ul>
                </div>
            </div>
            <div class="col col-md-4">
                <div class="footerContent">
                    <h4>CUSTOMER SERVICE</h4>
                    <ul>
                        <li><a href="#">Payment Options</a></li>
                        <li><a href="#">Shipping | Tracking</a></li>
                        <li><a href="#">Return | Exchange</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <div class="col col-md-4">
                <div class="footerContent">
                    <h4>INFORMATION</h4>
                    <ul>
                        <li>E-mail:
                            <a href="mailto:@foreach($settings as $data) {{$data->email}} @endforeach">
                                @foreach($settings as $data) {{$data->email}} @endforeach
                            </a>
                        </li>
                        <li>WhatsApp:
                            <a href="tel:@foreach($settings as $data) {{$data->phone}} @endforeach">
                                @foreach($settings as $data) {{$data->phone}} @endforeach
                            </a>
                        </li>
                        <li>Working time: Monday ~ Saturday, except holidays.</li>
                        <li>Address: Johar town, Lahore</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Jquery -->
<script src="{{asset('frontend/js/jquery.min.js')}}"></script>
<script src="{{asset('frontend/js/jquery-migrate-3.0.0.js')}}"></script>
<script src="{{asset('frontend/js/jquery-ui.min.js')}}"></script>
<!-- Popper JS -->
<script src="{{asset('frontend/js/popper.min.js')}}"></script>
<!-- Bootstrap JS -->
<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
<script src="{{asset('frontend/js/frontend-custom.js')}}"></script>
<!-- Color JS -->
{{--	<script src="{{asset('frontend/js/colors.js')}}"></script>--}}
<!-- Slicknav JS -->
<script src="{{asset('frontend/js/slicknav.min.js')}}"></script>
<!-- Owl Carousel JS -->
<script src="{{asset('frontend/js/owl-carousel.js')}}"></script>
<!-- Magnific Popup JS -->
<script src="{{asset('frontend/js/magnific-popup.js')}}"></script>
<!-- Waypoints JS -->
<script src="{{asset('frontend/js/waypoints.min.js')}}"></script>
<!-- Countdown JS -->
<script src="{{asset('frontend/js/finalcountdown.min.js')}}"></script>
<!-- Nice Select JS -->
<script src="{{asset('frontend/js/nicesellect.js')}}"></script>
<!-- Flex Slider JS -->
<script src="{{asset('frontend/js/flex-slider.js')}}"></script>
<!-- ScrollUp JS -->
<script src="{{asset('frontend/js/scrollup.js')}}"></script>
<!-- Onepage Nav JS -->
<script src="{{asset('frontend/js/onepage-nav.min.js')}}"></script>
{{-- Isotope --}}
<script src="{{asset('frontend/js/isotope/isotope.pkgd.min.js')}}"></script>
<!-- Easing JS -->
<script src="{{asset('frontend/js/easing.js')}}"></script>

<!-- Active JS -->
<script src="{{asset('frontend/js/active.js')}}"></script>


@stack('scripts')
<script>
setTimeout(function(){
  $('.alert').slideUp();
},5000);
$(function() {
// ------------------------------------------------------- //
// Multi Level dropdowns
// ------------------------------------------------------ //
    $("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
        event.preventDefault();
        event.stopPropagation();

        $(this).siblings().toggleClass("show");


        if (!$(this).next().hasClass('show')) {
        $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
        }
        $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
        $('.dropdown-submenu .show').removeClass("show");
        });

    });
});
</script>
