@extends('layouts.app')

@section('title', 'Contact Us - Meals on Wheels')

@section('styles')
<style>
    .contact-hero {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset("img/contact-hero.png") }}');
        background-size: cover;
        background-position: top;
        padding: 80px 0;
        color: white;
        
    }

    .contact-info-card {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        height: 100%;
        transition: transform 0.3s ease;
    }

    .contact-info-card:hover {
        transform: translateY(-5px);
    }

    .contact-icon {
        width: 60px;
        height: 60px;
        background: var(--primary-color);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 20px;
    }

    .contact-form {
        background: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .form-control {
        border: 1px solid #ddd;
        padding: 12px;
        margin-bottom: 20px;
        border-radius: 5px;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(46, 204, 113, 0.25);
    }

    .map-container {
        height: 400px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .office-hours {
        background: var(--text-light);
        padding: 80px 0;
    }

    .hours-card {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .hours-list {
        list-style: none;
        padding: 0;
    }

    .hours-list li {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }

    .hours-list li:last-child {
        border-bottom: none;
    }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="contact-hero">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-8 pt-5">
                    <h1 class="mb-4 mt-4 pt-2">Get in Touch</h1>
                    <p class="lead">Have questions? We're here to help and would love to hear from you.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="contact-info-card text-center">
                        <div class="contact-icon mx-auto">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4>Visit Us</h4>
                        <p class="mb-0">123 Charity Street</p>
                        <p>Kuala Lumpur, Malaysia</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-info-card text-center">
                        <div class="contact-icon mx-auto">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h4>Call Us</h4>
                        <p class="mb-0">+60 123-456-789</p>
                        <p>Mon-Fri, 9:00 AM - 6:00 PM</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-info-card text-center">
                        <div class="contact-icon mx-auto">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4>Email Us</h4>
                        <p class="mb-0">info@mealsonwheels.org</p>
                        <p>support@mealsonwheels.org</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form & Map -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="contact-form">
                        <h3 class="mb-4">Send us a Message</h3>
                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Your Name" name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" placeholder="Your Email" name="email" required>
                                </div>
                            </div>
                            <input type="text" class="form-control" placeholder="Subject" name="subject" required>
                            <textarea class="form-control" rows="5" placeholder="Your Message" name="message" required></textarea>
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="map-container">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.7447595951186!2d101.69345931475201!3d3.1569170977175166!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc37d12d669c1f%3A0x9e3afdd17c8a9056!2sKuala%20Lumpur%20City%20Centre!5e0!3m2!1sen!2smy!4v1624942912344!5m2!1sen!2smy" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Office Hours -->
    <section class="office-hours">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="hours-card">
                        <h3 class="text-center mb-4">Office Hours</h3>
                        <ul class="hours-list">
                            <li>
                                <span>Monday - Friday</span>
                                <span>9:00 AM - 6:00 PM</span>
                            </li>
                            <li>
                                <span>Saturday</span>
                                <span>9:00 AM - 1:00 PM</span>
                            </li>
                            <li>
                                <span>Sunday</span>
                                <span>9:00 AM - 1:00 PM</span>
                            </li>
                        </ul>
                        <div class="text-center mt-4">
                            <p class="mb-0 text-muted">Emergency Contact Available 24/7</p>
                            <strong class="text-primary">Hotline: +60 123-456-789</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2>Frequently Asked Questions</h2>
                <p class="lead">Find quick answers to common questions</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    How can I volunteer?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    You can sign up as a volunteer through our registration page. After registration, we'll review your application and contact you for orientation.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    How can I request meal service?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    If you or someone you know needs our meal service, you can register as a member through our website or contact us directly for assistance.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    // Form submission handling
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        // Add your form submission logic here
        alert('Thank you for your message. We will get back to you soon!');
    });
</script>
@endsection 