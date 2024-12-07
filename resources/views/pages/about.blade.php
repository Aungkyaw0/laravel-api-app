@extends('layouts.app')

@section('title', 'About Us - Meals on Wheels')

@section('styles')
<style>
    .about-hero {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset("img/about-hero.png") }}');
        background-size: cover;
        background-position: center;
        padding: 100px 0;
        color: white;
    }

    .mission-section {
        background-color: var(--text-light);
        padding: 80px 0;
    }

    .value-card {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        height: 100%;
        transition: transform 0.3s ease;
    }

    .value-card:hover {
        transform: translateY(-5px);
    }

    .value-icon {
        font-size: 2.5rem;
        color: var(--primary-color);
        margin-bottom: 20px;
    }

    .team-section {
        padding: 80px 0;
    }

    .service-process {
        padding: 80px 0;
        background-color: #f8f9fa;
    }

    .process-step {
        text-align: center;
        padding: 20px;
        position: relative;
    }

    .step-number {
        background-color: var(--primary-color);
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-weight: bold;
    }

    .achievement-section {
        background: var(--primary-color);
        color: white;
        padding: 60px 0;
    }

    .achievement-card {
        text-align: center;
        padding: 20px;
    }

    .achievement-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="about-hero">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-8 pt-5">
                    <h1 class="mb-4">Our Mission to Serve</h1>
                    <p class="lead">MerryMeal is dedicated to providing nutritious meals to vulnerable adults who cannot cook for themselves due to age, illness, or disability.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="mission-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="value-card">
                        <i class="fas fa-heart value-icon"></i>
                        <h3>Our Mission</h3>
                        <p>To ensure that no vulnerable adult goes hungry, providing them with nutritious meals and compassionate support.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="value-card">
                        <i class="fas fa-eye value-icon"></i>
                        <h3>Our Vision</h3>
                        <p>A community where every vulnerable adult has access to proper nutrition and care, enabling them to live with dignity.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="value-card">
                        <i class="fas fa-star value-icon"></i>
                        <h3>Our Values</h3>
                        <p>Compassion, Dignity, Reliability, and Community Service guide everything we do.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Process -->
    <section class="service-process">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2>How We Work</h2>
                    <p class="lead">Our streamlined process ensures efficient and reliable meal delivery</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="process-step">
                        <div class="step-number">1</div>
                        <h4>Member Registration</h4>
                        <p>Vulnerable adults or their caregivers register for our service</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="process-step">
                        <div class="step-number">2</div>
                        <h4>Meal Planning</h4>
                        <p>Caregivers create personalized meal plans based on dietary needs</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="process-step">
                        <div class="step-number">3</div>
                        <h4>Food Preparation</h4>
                        <p>Partner kitchens prepare fresh, nutritious meals</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="process-step">
                        <div class="step-number">4</div>
                        <h4>Delivery</h4>
                        <p>Volunteers deliver meals directly to members' homes</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Achievement Section -->
    <section class="achievement-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="achievement-card">
                        <div class="achievement-number">5000+</div>
                        <div>Members Served</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="achievement-card">
                        <div class="achievement-number">1000+</div>
                        <div>Volunteers</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="achievement-card">
                        <div class="achievement-number">50+</div>
                        <div>Partner Kitchens</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="achievement-card">
                        <div class="achievement-number">100K+</div>
                        <div>Meals Delivered</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-8">
                    <h2 class="mb-4">Join Our Mission</h2>
                    <p class="lead mb-4">Whether you want to volunteer, donate, or become a partner, there are many ways to help make a difference.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Become a Volunteer</a>
                        <a href="{{ route('donate') }}" class="btn btn-outline-primary btn-lg">Support Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection 