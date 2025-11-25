<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Update</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px;">
        <h1 style="color: #2563eb; margin: 0;">Order Status Update</h1>
    </div>

    <div style="background-color: #fff; padding: 20px; border: 1px solid #e5e7eb; border-radius: 5px; margin-bottom: 20px;">
        <p>Hello {{ $order->user->name }},</p>
        <p>Your order <strong>#{{ $order->id }}</strong> status has been updated.</p>
        
        <div style="background-color: #f3f4f6; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p style="margin: 0;"><strong>Previous Status:</strong> {{ ucfirst($oldStatus) }}</p>
            <p style="margin: 10px 0 0 0;"><strong>New Status:</strong> <span style="color: #2563eb; font-weight: bold;">{{ ucfirst($order->status) }}</span></p>
        </div>

        @if($order->status === 'shipped')
            <p>Your order has been shipped and is on its way to you!</p>
        @elseif($order->status === 'delivered')
            <p>Your order has been delivered. We hope you enjoy your purchase!</p>
        @elseif($order->status === 'processing')
            <p>Your order is being processed and will be shipped soon.</p>
        @endif
    </div>

    <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
        <p style="color: #666; margin: 0;">You can view your order details anytime by visiting your account.</p>
    </div>
</body>
</html>

