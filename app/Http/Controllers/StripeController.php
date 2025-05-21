<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    // public function createCheckoutSession($orderId)
    // {
    //     $order = Order::findOrFail($orderId);

    //     Stripe::setApiKey(env('STRIPE_SECRET'));

    //     $session = Session::create([
    //         'payment_method_types' => ['card'],
    //         'line_items' => [[
    //             'price_data' => [
    //                 'currency' => 'eur',
    //                 'product_data' => [
    //                     'name' => 'Commande #' . $order->id,
    //                 ],
    //                 'unit_amount' => intval($order->total_cost * 100), // en centimes
    //             ],
    //             'quantity' => 1,
    //         ]],
    //         'mode' => 'payment',
    //         'success_url' => env('APP_URL') . '/payment-success?order_id=' . $order->id,
    //         'cancel_url' => env('APP_URL') . '/payment-cancel?order_id=' . $order->id,
    //         'metadata' => [
    //             'order_id' => $order->id,
    //         ],
    //     ]);

    //     // Enregistre la session_id pour vérification plus tard (optionnel)
    //     $order->payment_key = $session->id;
    //     $order->save();

    //     return response()->json([
    //         'url' => $session->url,
    //     ]);
    // }
}
