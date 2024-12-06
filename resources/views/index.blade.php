@extends('layouts.app')

@section('title', 'Welcome to Meals on Wheels')

@section('styles')
<style>
    /* Hero Section */
    .hero {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset("img/hero-banner.png") }}');
        background-size: cover;
        background-position: center;
        height: 80vh;
        display: flex;
        align-items: center;
        color: white;
    }

    .hero h1 {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    /* Features Section */
    .features {
        padding: 80px 0;
        background-color: #f8f9fa;
    }

    .feature-card {
        text-align: center;
        padding: 30px;
        border-radius: 10px;
        transition: transform 0.3s ease;
        background: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .feature-card:hover {
        transform: translateY(-10px);
    }

    .feature-icon {
        font-size: 2.5rem;
        color: var(--primary-color);
        margin-bottom: 20px;
    }

    /* Impact Section */
    .impact {
        padding: 80px 0;
        background: var(--primary-color);
        color: white;
    }

    .stat-card {
        text-align: center;
        padding: 20px;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    /* Call to Action */
    .cta {
        padding: 100px 0;
        background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('{{ asset("images/cta-bg.jpg") }}');
        background-size: cover;
        background-position: center;
        color: white;
        text-align: center;
    }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1>Delivering Hope, One Meal at a Time</h1>
                    <p class="lead mb-4">Join us in our mission to ensure no one in our community goes hungry. Together, we can make a difference.</p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('donate') }}" class="btn btn-primary btn-lg">Donate Now</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Volunteer</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2>How We Help</h2>
                    <p class="lead">Our comprehensive approach to fighting hunger in the community</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-utensils feature-icon"></i>
                        <h3>Nutritious Meals</h3>
                        <p>We provide balanced, healthy meals tailored to individual dietary needs.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-truck feature-icon"></i>
                        <h3>Home Delivery</h3>
                        <p>Our dedicated volunteers ensure meals reach those who need them most.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-heart feature-icon"></i>
                        <h3>Community Care</h3>
                        <p>Building stronger communities through compassion and support.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Impact Section -->
    <section class="impact">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2>Our Impact</h2>
                    <p class="lead">Making a difference in our community every day</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-number">50,000+</div>
                        <div>Meals Delivered</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-number">1,000+</div>
                        <div>Active Volunteers</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-number">100+</div>
                        <div>Communities Served</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h2 class="mb-4">Ready to Make a Difference?</h2>
                    <p class="lead mb-4">Whether through volunteering, donating, or spreading awareness, your support helps us serve those in need.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('donate') }}" class="btn btn-primary btn-lg">Donate</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Join Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection 