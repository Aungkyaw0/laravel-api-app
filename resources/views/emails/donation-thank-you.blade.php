<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
            background-color: #f9f9f9;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 0.8em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Thank You for Your Donation!</h1>
        </div>
        
        <div class="content">
            <p>Dear {{ $donation->donor_name }},</p>
            
            <p>Thank you for your generous donation of ${{ number_format($donation->amount, 2) }} to Meals on Wheels. Your contribution will help us continue our mission to provide nutritious meals to those in need.</p>
            
            <p><strong>Donation Details:</strong></p>
            <ul>
                <li>Donation ID: {{ $donation->id }}</li>
                <li>Amount: ${{ number_format($donation->amount, 2) }}</li>
                <li>Date: {{ $donation->created_at->format('F j, Y') }}</li>
                <li>Payment Method: {{ ucfirst($donation->payment_method) }}</li>
                <li>Transaction ID: {{ $donation->payment_id }}</li>
            </ul>

            @if($donation->message)
                <p><strong>Your Message:</strong><br>
                {{ $donation->message }}</p>
            @endif

            <p>Your support makes a real difference in our community. We are grateful for your generosity.</p>
            
            <p>Best regards,<br>
            The Meals on Wheels Team</p>
        </div>
        
        <div class="footer">
            <p>This is an automated email. Please do not reply.</p>
            <p>Meals on Wheels © {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html> 