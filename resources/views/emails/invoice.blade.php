<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="text-align: center; margin-bottom: 30px;">
        <h1 style="color: #2563eb; margin: 0;">INVOICE</h1>
        <p style="color: #666; margin: 5px 0;">Order #{{ $order->id }}</p>
    </div>

    <div style="background-color: #fff; padding: 20px; border: 1px solid #e5e7eb; border-radius: 5px; margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <div>
                <h3 style="margin: 0 0 10px 0;">Bill To:</h3>
                <p style="margin: 0;">{{ $order->user->name }}<br>
                {{ $order->user->email }}<br>
                {{ $order->shipping_address }}</p>
            </div>
            <div style="text-align: right;">
                <p style="margin: 0;"><strong>Invoice Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
                <p style="margin: 5px 0 0 0;"><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            </div>
        </div>
    </div>

    <div style="background-color: #fff; padding: 20px; border: 1px solid #e5e7eb; border-radius: 5px; margin-bottom: 20px;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f3f4f6;">
                    <th style="padding: 10px; text-align: left; border-bottom: 2px solid #e5e7eb;">Item</th>
                    <th style="padding: 10px; text-align: center; border-bottom: 2px solid #e5e7eb;">Qty</th>
                    <th style="padding: 10px; text-align: right; border-bottom: 2px solid #e5e7eb;">Price</th>
                    <th style="padding: 10px; text-align: right; border-bottom: 2px solid #e5e7eb;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">{{ $item->product->name }}</td>
                    <td style="padding: 10px; text-align: center; border-bottom: 1px solid #e5e7eb;">{{ $item->quantity }}</td>
                    <td style="padding: 10px; text-align: right; border-bottom: 1px solid #e5e7eb;">${{ number_format($item->price, 2) }}</td>
                    <td style="padding: 10px; text-align: right; border-bottom: 1px solid #e5e7eb;">${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                @if($order->discount_amount > 0)
                <tr>
                    <td colspan="3" style="padding: 10px; text-align: right;">Subtotal:</td>
                    <td style="padding: 10px; text-align: right;">${{ number_format($order->total_amount + $order->discount_amount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="padding: 10px; text-align: right;">Discount:</td>
                    <td style="padding: 10px; text-align: right; color: #10b981;">-${{ number_format($order->discount_amount, 2) }}</td>
                </tr>
                @endif
                @if($order->shipping_cost > 0)
                <tr>
                    <td colspan="3" style="padding: 10px; text-align: right;">Shipping:</td>
                    <td style="padding: 10px; text-align: right;">${{ number_format($order->shipping_cost, 2) }}</td>
                </tr>
                @endif
                <tr style="background-color: #f3f4f6;">
                    <td colspan="3" style="padding: 10px; text-align: right; font-weight: bold; font-size: 1.1em;">Total:</td>
                    <td style="padding: 10px; text-align: right; font-weight: bold; font-size: 1.1em;">${{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
        <p style="color: #666; margin: 0;">Thank you for your business!</p>
    </div>
</body>
</html>

