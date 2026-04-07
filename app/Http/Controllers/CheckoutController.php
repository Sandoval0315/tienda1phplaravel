<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));
        
        return view('checkout.index', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        
        $cart = session()->get('cart', []);
        $total = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));
        
        $paymentIntent = PaymentIntent::create([
            'amount' => $total * 100,
            'currency' => 'eur',
            'metadata' => [
                'user_id' => auth()->id() ?? 0
            ]
        ]);
        
        return view('checkout.payment', [
            'clientSecret' => $paymentIntent->client_secret,
            'total' => $total
        ]);
    }
}