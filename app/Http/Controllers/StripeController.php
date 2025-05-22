<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeController extends Controller
{
    public function createCheckoutSession($orderId)
{
    Stripe::setApiKey(env('STRIPE_SECRET'));

    $order = Order::with(['orderItems.product'])->findOrFail($orderId);

    $lineItems = [];
    $totalPrice = 0;
    $tableHtml = "<table border='1' style='width:100%; text-align:left;'>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix Unitaire</th>
                    </tr>";

    foreach ($order->orderItems as $item) {
        $product = $item->product;

        if (!$product || !$product->price) {
            continue;
        }

        $unitPrice = intval($product->price * 100);
        $totalPrice += $unitPrice * $item->quantity;

        $tableHtml .= "<tr>
                        <td>{$product->name}</td>
                        <td>{$item->quantity}</td>
                        <td>" . number_format($product->price, 2) . "€</td>
                      </tr>";

        $lineItems[] = [
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => $product->name,
                ],
                'unit_amount' => $unitPrice,
            ],
            'quantity' => $item->quantity,
        ];
    }

    // Ajout du prix total à la fin du tableau
    $tableHtml .= "<tr>
                    <td colspan='2'><strong>Total</strong></td>
                    <td><strong>" . number_format($totalPrice / 100, 2) . "€</strong></td>
                   </tr>
                   </table>";

    $session = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $lineItems,
        'mode' => 'payment',
        'success_url' => env('FRONT_URL') . '/reussi',
        'cancel_url' => env('FRONT_URL') . '/cancel',
        'metadata' => [
            'order_id' => $order->id,
        ],
    ]);

    $order->payment_key = $session->id;
    $order->payment_url = $session->url;
    $order->save();

    return response()->json(['url' => $session->url]);
}



    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            $orderId = $session->metadata->order_id ?? null;

            if ($orderId) {
                $order = Order::find($orderId);
                if ($order) {
                    $order->status = 'completed';
                    $order->payment_key = $session->payment_intent ?? $session->id;
                    $order->save();

                    Log::info("Commande #$orderId payée et mise à jour.");
                }
            }
        }

        return response('Webhook reçu', 200);
    }

    public static function generateStripeUrl(Order $order): string
{
    Stripe::setApiKey(env('STRIPE_SECRET'));

    $order->load(['orderItems.product']);

    $lineItems = [];

    foreach ($order->orderItems as $item) {
        $product = $item->product;
        if (!$product || !$product->price) continue;

        $lineItems[] = [
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => $product->name,
                ],
                'unit_amount' => intval($product->price * 100),
            ],
            'quantity' => $item->quantity,
        ];
    }

    $session = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $lineItems,
        'mode' => 'payment',
        'success_url' => env('FRONT_URL') . '/reussi',
        'cancel_url' => env('FRONT_URL') . '/cancel',
        'metadata' => [
            'order_id' => $order->id,
        ],
    ]);

    $order->payment_key = $session->id;
    $order->payment_url = $session->url;
    $order->save();

    return $session->url;
}

}
