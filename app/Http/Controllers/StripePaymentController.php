<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        $cart = Cart::where('user_id',auth()->user()->id)->where('order_id',null)->get()->toArray();

        $shippingPrice = Shipping::where('id',$request->shipping_id)->first();

        $data['items'] = array_map(function ($item) use($cart) {
            $name=Product::where('id',$item['product_id'])->pluck('title');
            return [
                'name' =>$name ,
                'price' => $item['price'],
                'desc'  => 'Thank you for using paypal',
                'qty' => $item['quantity']
            ];
        }, $cart);

        $data['invoice_id'] ='ORD-'.strtoupper(uniqid());
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('payment.success');
        $data['cancel_url'] = route('payment.cancel');

        $total = 0;
        foreach($data['items'] as $item) {
            $total += $item['price']*$item['qty'];
        }

        $totalAmount = $total + $shippingPrice['price'];

        $data['total'] = $total;
        if(session('coupon')){
            $data['shipping_discount'] = session('coupon')['value'];
        }
        Cart::where('user_id', auth()->user()->id)->where('order_id', null)->update(['order_id' => session()->get('id')]);

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET', 'sk_test_51DIwDyJE1LlGBr2sOwyCXECgEaKdHtVoTKDlB9LOKPi6jPUbdNjDYVBbPbUhSNRZ08VAyCz04x9LgG236Fbjk3h4009MIZWyiD'));

        $response = Stripe\Charge::create ([
            "amount" => $totalAmount * 100,
            "currency" => "AUD",
            "source" => $request->stripeToken,
            "description" => "Payment Success"
        ]);

        if ($response){
            $cart = Cart::where('user_id',auth()->user()->id)->where('order_id',null)->get();

            foreach ($cart as $cartVal){
                Cart::destroy($cartVal->id);
            }
        }

        Session::flash('success', 'Payment successful!');

        return redirect()->route('home');
    }
}
