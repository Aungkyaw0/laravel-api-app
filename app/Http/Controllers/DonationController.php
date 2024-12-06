<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use Illuminate\Support\Facades\Mail;
use App\Mail\DonationThankYou;

class DonationController extends Controller
{
    public function processDonation(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:15',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:credit_card,paypal',
            'message' => 'nullable|string|max:500'
        ]);

        // Create donation record with pending status
        $donation = Donation::create([
            ...$validated,
            'payment_status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Donation initialized successfully',
            'donation_id' => $donation->id,
            'amount' => $donation->amount,
            'payment_method' => $donation->payment_method
        ]);
    }

    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'donation_id' => 'required|exists:donations,id',
            'payment_details' => 'required|array',
            'payment_details.method' => 'required|in:credit_card,paypal'
        ]);

        $donation = Donation::findOrFail($request->donation_id);

        // Process payment based on method
        if ($request->payment_details['method'] === 'credit_card') {
            // Validate credit card details
            $request->validate([
                'payment_details.card_number' => 'required|string|size:16',
                'payment_details.expiry_date' => 'required|string',
                'payment_details.cvv' => 'required|string|size:3',
            ]);
        } else {
            // Validate PayPal details
            $request->validate([
                'payment_details.paypal_email' => 'required|email',
            ]);
        }

        // Simulate payment processing
        $paymentId = 'PAY-' . strtoupper(uniqid());
        
        $donation->update([
            'payment_status' => 'completed',
            'payment_id' => $paymentId
        ]);

        // Send thank you email
        Mail::to($donation->email)->send(new DonationThankYou($donation));

        return response()->json([
            'success' => true,
            'message' => 'Payment processed successfully',
            'payment_id' => $paymentId,
            'transaction_date' => now(),
            'amount' => $donation->amount
        ]);
    }
} 