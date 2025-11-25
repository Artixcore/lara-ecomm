<?php

namespace App\Http\Controllers;

use App\Services\Payment\StripePaymentService;
use App\Services\Payment\PayPalPaymentService;
use App\Services\Payment\RazorpayPaymentService;
use App\Services\Payment\CashOnDeliveryService;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function process(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'payment_method' => 'required|in:stripe,paypal,razorpay,cod',
        ]);

        $paymentMethod = $request->payment_method;
        $service = $this->getPaymentService($paymentMethod);

        $paymentData = [
            'amount' => $order->total_amount,
            'currency' => setting('currency', 'USD'),
            'order_id' => $order->id,
            'return_url' => route('payment.success', $order),
            'cancel_url' => route('payment.cancel', $order),
        ];

        // Add payment method specific data
        if ($paymentMethod === 'stripe' && $request->has('payment_method_id')) {
            $paymentData['payment_method_id'] = $request->payment_method_id;
        }

        $result = $service->processPayment($paymentData);

        if ($result['success']) {
            $order->update([
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentMethod === 'cod' ? 'pending' : 'processing',
                'transaction_id' => $result['transaction_id'],
            ]);

            if ($paymentMethod === 'cod') {
                return redirect()->route('orders.show', $order)
                    ->with('success', 'Order placed successfully! Payment will be collected on delivery.');
            }

            // For online payments, redirect to payment gateway
            if (isset($result['approval_url'])) {
                return redirect($result['approval_url']);
            }

            if (isset($result['client_secret'])) {
                return view('payment.stripe', [
                    'order' => $order,
                    'client_secret' => $result['client_secret'],
                ]);
            }
        }

        return redirect()->back()->with('error', $result['error'] ?? 'Payment processing failed');
    }

    public function success(Request $request, Order $order)
    {
        $service = $this->getPaymentService($order->payment_method);
        
        if ($service->verifyPayment($order->transaction_id)) {
            $order->update([
                'payment_status' => 'completed',
                'status' => 'processing',
            ]);

            return redirect()->route('orders.show', $order)
                ->with('success', 'Payment successful! Your order is being processed.');
        }

        return redirect()->route('orders.show', $order)
            ->with('error', 'Payment verification failed. Please contact support.');
    }

    public function cancel(Order $order)
    {
        $order->update([
            'payment_status' => 'cancelled',
        ]);

        return redirect()->route('orders.show', $order)
            ->with('error', 'Payment was cancelled.');
    }

    private function getPaymentService(string $method)
    {
        return match ($method) {
            'stripe' => new StripePaymentService(),
            'paypal' => new PayPalPaymentService(),
            'razorpay' => new RazorpayPaymentService(),
            'cod' => new CashOnDeliveryService(),
            default => throw new \InvalidArgumentException("Unknown payment method: {$method}"),
        };
    }
}
