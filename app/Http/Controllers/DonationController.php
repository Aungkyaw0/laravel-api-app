<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Mail\DonationThankYou;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\Exception\TransportException;
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

        if ($validated['payment_details']['method'] === 'credit_card') {
            $request->validate([
                'payment_details.card_number' => 'required|string|size:16',
                'payment_details.expiry_date' => 'required|string',
                'payment_details.cvv' => 'required|string|size:3',
            ]);
        } else { // PayPal
            $request->validate([
                'payment_details.paypal_email' => 'required|email',
            ]);
        }

        // Simulate payment processing delay
        sleep(rand(1, 2));

        // Simulate success rate (90% success)
        $isSuccessful = (rand(1, 100) <= 90);

        $donation = Donation::findOrFail($validated['donation_id']);

        if ($isSuccessful) {
            $paymentId = $this->generatePaymentId($donation);
            
            $donation->update([
                'payment_status' => 'completed',
                'payment_id' => $paymentId
            ]);
            $resultEmailSend = $this->sendThankYouEmail($donation);
            return response()->json([
                'success' => true,
                'message' => 'Payment processed successfully',
                'payment_id' => $paymentId,
                'transaction_date' => now(),
                'amount' => $donation->amount,
                'email_sent' => $resultEmailSend
            ]);
        }

        $donation->update(['payment_status' => 'failed']);

        return response()->json([
            'success' => false,
            'message' => 'Payment could not be processed. Please try again.',
            'error_code' => 'PAYMENT_FAILED_' . rand(1000, 9999)
        ], 422);
    }

    private function generatePaymentId($donation)
    {
        // Generate a realistic-looking payment ID
        $prefix = $donation->payment_method === 'credit_card' ? 'CC' : 'PP';
        $timestamp = now()->format('YmdHis');
        $random = strtoupper(substr(uniqid(), -4));
        
        return "{$prefix}-{$timestamp}-{$random}";
    }

    private function sendThankYouEmail(Donation $donation)
    {
        try {
            // Add timeout to quickly catch connection issues
            config(['mail.mailers.smtp.timeout' => 5]);
            
            Mail::to($donation->email)->send(new DonationThankYou($donation));
            
            Log::info('Thank you email sent successfully to donor', [
                'donation_id' => $donation->id,
                'email' => $donation->email
            ]);
            
            return true;
        } catch (TransportException $e) {
            Log::error('SMTP Connection Error', [
                'donation_id' => $donation->id,
                'email' => $donation->email,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
} 