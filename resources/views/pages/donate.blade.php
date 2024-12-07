@extends('layouts.app')

@section('title', 'Donate - Meals on Wheels')

@section('styles')
<style>
    .donate-hero {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset("img/donate-hero.png") }}');
        background-size: cover;
        background-position: center;
        padding: 100px 0;
        color: white;
    
    }

    .donation-card {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }

    .donation-amount {
        display: none;
    }

    .donation-amount-label {
        display: block;
        padding: 15px 25px;
        background: #f8f9fa;
        border: 2px solid #dee2e6;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        margin-bottom: 10px;
    }

    .donation-amount:checked + .donation-amount-label {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .custom-amount {
        display: none;
    }

    #custom:checked ~ .custom-amount {
        display: block;
    }

    .payment-method {
        display: none;
    }

    .payment-method-label {
        display: block;
        padding: 20px;
        border: 2px solid #dee2e6;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .payment-method:checked + .payment-method-label {
        border-color: var(--primary-color);
        background: #f8fff9;
    }

    .payment-icon {
        font-size: 2rem;
        margin-bottom: 10px;
        color: var(--primary-color);
    }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="donate-hero">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-8 pt-5">
                    <h1 class="mb-4">Make a Difference Today</h1>
                    <p class="lead">Your donation helps us deliver nutritious meals to those in need. Every contribution counts!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Donation Form Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="donation-card">
                        <form action="{{ route('donation.process') }}" method="POST" id="donationForm">
                            @csrf
                            <!-- Donation Amount -->
                            <h3 class="mb-4">Select Donation Amount</h3>
                            <div class="row g-3 mb-4">
                                <div class="col-6 col-md-3">
                                    <input type="radio" name="amount" id="amount25" value="25" class="donation-amount">
                                    <label for="amount25" class="donation-amount-label">$25</label>
                                </div>
                                <div class="col-6 col-md-3">
                                    <input type="radio" name="amount" id="amount50" value="50" class="donation-amount">
                                    <label for="amount50" class="donation-amount-label">$50</label>
                                </div>
                                <div class="col-6 col-md-3">
                                    <input type="radio" name="amount" id="amount100" value="100" class="donation-amount">
                                    <label for="amount100" class="donation-amount-label">$100</label>
                                </div>
                                <div class="col-6 col-md-3">
                                    <input type="radio" name="amount" id="custom" class="donation-amount">
                                    <label for="custom" class="donation-amount-label">Custom</label>
                                    <div class="custom-amount mt-2">
                                        <input type="number" class="form-control" name="custom_amount" placeholder="Enter amount">
                                    </div>
                                </div>
                            </div>

                            <!-- Donation Frequency -->
                            <h3 class="mb-4">Donation Frequency</h3>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <input type="radio" name="frequency" id="oneTime" value="one_time" class="payment-method">
                                    <label for="oneTime" class="payment-method-label">
                                        <i class="fas fa-gift payment-icon"></i>
                                        <h4>One-Time Donation</h4>
                                        <p class="mb-0 text-muted">Make a single donation</p>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <input type="radio" name="frequency" id="monthly" value="monthly" class="payment-method">
                                    <label for="monthly" class="payment-method-label">
                                        <i class="fas fa-sync-alt payment-icon"></i>
                                        <h4>Monthly Donation</h4>
                                        <p class="mb-0 text-muted">Support us every month</p>
                                    </label>
                                </div>
                            </div>

                            <!-- Personal Information -->
                            <h3 class="mb-4">Your Information</h3>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">First Name</label>
                                    <input type="text" name="first_name" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="tel" name="phone" class="form-control">
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <h3 class="mb-4">Payment Method</h3>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <input type="radio" name="payment_method" id="creditCard" value="credit_card" class="payment-method">
                                    <label for="creditCard" class="payment-method-label">
                                        <i class="fas fa-credit-card payment-icon"></i>
                                        <h4>Credit Card</h4>
                                        <p class="mb-0 text-muted">Safe and secure payment</p>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <input type="radio" name="payment_method" id="paypal" value="paypal" class="payment-method">
                                    <label for="paypal" class="payment-method-label">
                                        <i class="fab fa-paypal payment-icon"></i>
                                        <h4>PayPal</h4>
                                        <p class="mb-0 text-muted">Fast and convenient</p>
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100">Complete Donation</button>
                        </form>
                    </div>
                </div>

                <!-- Impact Information -->
                <div class="col-lg-4">
                    <div class="donation-card">
                        <h3 class="mb-4">Your Impact</h3>
                        <div class="impact-item mb-4">
                            <h5>$25 provides</h5>
                            <p>5 nutritious meals to vulnerable adults</p>
                        </div>
                        <div class="impact-item mb-4">
                            <h5>$50 provides</h5>
                            <p>10 meals and supports delivery costs</p>
                        </div>
                        <div class="impact-item">
                            <h5>$100 provides</h5>
                            <p>20 meals and helps maintain our kitchen facilities</p>
                        </div>
                    </div>

                    <div class="donation-card">
                        <h3 class="mb-4">Why Donate?</h3>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                100% of donations go to meal services
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Tax-deductible contributions
                            </li>
                            <li>
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Transparent impact reporting
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('donationForm');
    const customAmount = document.querySelector('input[name="custom_amount"]');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Basic validation
        const amount = document.querySelector('input[name="amount"]:checked');
        const frequency = document.querySelector('input[name="frequency"]:checked');
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked');

        if (!amount) {
            alert('Please select a donation amount');
            return;
        }

        if (!frequency) {
            alert('Please select donation frequency');
            return;
        }

        if (!paymentMethod) {
            alert('Please select a payment method');
            return;
        }

        try {
            // First, initialize the donation
            const formData = new FormData(form);
            const response = await fetch('/donations', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    donor_name: `${formData.get('first_name')} ${formData.get('last_name')}`,
                    email: formData.get('email'),
                    phone: formData.get('phone'),
                    amount: formData.get('custom') ? formData.get('custom_amount') : formData.get('amount'),
                    payment_method: formData.get('payment_method'),
                    message: ''
                })
            });

            const result = await response.json();

            if (result.donation_id) {
                // Show payment modal based on selected payment method
                if (paymentMethod.value === 'credit_card') {
                    showCreditCardModal(result.donation_id, result.amount);
                } else {
                    showPayPalModal(result.donation_id, result.amount);
                }
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        }
    });

    // Handle custom amount input
    customAmount.addEventListener('input', function() {
        document.getElementById('custom').checked = true;
    });
});

// Add these modal templates to your donate.blade.php
function showCreditCardModal(donationId, amount) {
    const modalHtml = `
        <div class="modal fade" id="creditCardModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Complete Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="creditCardForm">
                            <input type="hidden" name="donation_id" value="${donationId}">
                            <div class="mb-3">
                                <label class="form-label">Card Number</label>
                                <input type="text" class="form-control" name="card_number" required pattern="[0-9]{16}">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Expiry Date</label>
                                    <input type="text" class="form-control" name="expiry_date" placeholder="MM/YY" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">CVV</label>
                                    <input type="text" class="form-control" name="cvv" required pattern="[0-9]{3}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Pay $${amount}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalHtml);
    const modal = new bootstrap.Modal(document.getElementById('creditCardModal'));
    modal.show();

    document.getElementById('creditCardForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(e.target);
        
        try {
            const response = await fetch('/donations/payment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    donation_id: donationId,
                    payment_details: {
                        method: 'credit_card',
                        card_number: formData.get('card_number'),
                        expiry_date: formData.get('expiry_date'),
                        cvv: formData.get('cvv')
                    }
                })
            });

            const result = await response.json();
            
            if (result.success) {
                modal.hide();
                showSuccessModal(result);
            } else {
                alert(result.message || 'Payment failed. Please try again.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred processing your payment.');
        }
    });
}

function showPayPalModal(donationId, amount) {
    const modalHtml = `
        <div class="modal fade" id="paypalModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">PayPal Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="paypalForm">
                            <input type="hidden" name="donation_id" value="${donationId}">
                            <div class="mb-3">
                                <label class="form-label">PayPal Email</label>
                                <input type="email" class="form-control" name="paypal_email" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Pay with PayPal $${amount}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalHtml);
    const modal = new bootstrap.Modal(document.getElementById('paypalModal'));
    modal.show();

    document.getElementById('paypalForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(e.target);
        
        try {
            const response = await fetch('/api/donations/payment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    donation_id: donationId,
                    payment_details: {
                        method: 'paypal',
                        paypal_email: formData.get('paypal_email')
                    }
                })
            });

            const result = await response.json();
            
            if (result.success) {
                modal.hide();
                showSuccessModal(result);
            } else {
                alert(result.message || 'Payment failed. Please try again.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred processing your payment.');
        }
    });
}

function showSuccessModal(result) {
    const modalHtml = `
        <div class="modal fade" id="successModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Thank You for Your Donation!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <i class="fas fa-check-circle text-success" style="font-size: 48px;"></i>
                        </div>
                        <h4>Donation Receipt</h4>
                        <ul class="list-unstyled">
                            <li><strong>Transaction ID:</strong> ${result.payment_id}</li>
                            <li><strong>Amount:</strong> $${result.amount}</li>
                            <li><strong>Date:</strong> ${result.transaction_date}</li>
                        </ul>
                        <p class="mt-3">A confirmation email has been sent to your email address.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><a class="btn btn-secondary link-underline-opacity-0" href="{{ route('home') }}">Home</a></button>
                        <button type="button" class="btn btn-primary" onclick="window.print()">Print Receipt</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalHtml);
    const modal = new bootstrap.Modal(document.getElementById('successModal'));
    modal.show();
}
</script>
@endsection 