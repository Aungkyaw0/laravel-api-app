@extends('layouts.app')

@section('title', 'Member Dashboard - Meals on Wheels')

@section('styles')
<style>
    .dashboard-container {
        padding: 2rem 0;
    }

    .dashboard-header {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset("images/dashboard-hero.jpg") }}');
        background-size: cover;
        background-position: center;
        padding: 7rem 0;
        color: white;
        margin-bottom: 2rem;
    }

    .stats-card {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
        transition: transform 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
    }

    .action-card {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
        border-left: 4px solid var(--primary-color);
    }

    .meal-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
    }

    .meal-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .meal-card-body {
        padding: 1.5rem;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
    }

    .status-approved {
        background-color: #d1fae5;
        color: #065f46;
    }

    .status-delivered {
        background-color: #dbeafe;
        color: #1e40af;
    }

    .status-scheduled {
        background-color: #fef3c7;
        color: #92400e;
    }

    .status-completed {
        background-color: #d1fae5;
        color: #065f46;
    }

    .status-cancelled {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .meal-info {
        background-color: #f8fafc;
        padding: 1rem;
        border-radius: 0.5rem;
    }

    .menu-items {
        background-color: #fff;
        padding: 1rem;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
    }

    .menu-items ul li {
        padding: 0.25rem 0;
    }
</style>
@endsection

@section('content')
    <!-- Dashboard Header -->
    <section class="dashboard-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1>Welcome, {{ Auth::user()->member->name }}!</h1>
                    <p class="lead mb-0">Manage your meal preferences and orders</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <span class="status-badge status-active">Active Member</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Content -->
    <div class="dashboard-container">
        <div class="container">
            <!-- Quick Stats -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stats-card">
                        <h3 class="h5 mb-3">Next Meal Delivery</h3>
                        <p class="mb-0 text-primary fw-bold">Tomorrow, 12:00 PM</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <h3 class="h5 mb-3">Meal Preference</h3>
                        <p class="mb-0 text-primary fw-bold">{{ ucfirst(Auth::user()->member->prefer_meal) }} Meals</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <h3 class="h5 mb-3">Dietary Requirements</h3>
                        <p class="mb-0 text-primary fw-bold">{{ ucfirst(Auth::user()->member->dietary_requirement) }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions and Orders -->
            <div class="row">
                <!-- Left Column - Actions -->
                <div class="col-md-4">
                    <h2 class="h4 mb-4">Quick Actions</h2>
                    
                    <div class="action-card">
                        <h3 class="h5">Request Special Meal</h3>
                        <p>Make a special meal request for dietary needs</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#specialRequestModal">
                            Make Request
                        </button>
                    </div>
                    <div class="action-card">
                        <h3 class="h5">Contact Support</h3>
                        <p>Need help? Get in touch with our support team</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contactSupportModal">
                            Contact Support
                        </button>
                    </div>
                </div>

                <!-- Right Column - Meal Plans -->
                <div class="col-md-8">
                    <h2 class="h4 mb-4">My Meal Plans</h2>
                    @forelse($mealPlans as $mealPlan)
                        <div class="meal-card">
                            <div class="row g-0">
                                <div class="col-md-12">
                                    <div class="meal-card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h3 class="h5">{{ $mealPlan->menu->name }}</h3>
                                                <p class="text-muted mb-2">
                                                    <i class="fas fa-calendar me-2"></i>
                                                    Delivery Date: {{ \Carbon\Carbon::parse($mealPlan->meal_date)->format('M d, Y') }}
                                                </p>
                                            </div>
                                            <span class="status-badge status-{{ strtolower($mealPlan->status) }}">
                                                {{ ucfirst($mealPlan->status) }}
                                            </span>
                                        </div>
                                        
                                        <div class="meal-info mt-3">
                                            <p class="mb-2">
                                                <i class="fas fa-utensils me-2"></i>
                                                <strong>Meal Type:</strong> {{ ucfirst($mealPlan->meal_type) }}
                                            </p>
                                            <p class="mb-2">
                                                <i class="fas fa-user-nurse me-2"></i>
                                                <strong>Caregiver:</strong> {{ $mealPlan->caregiver->name }}
                                            </p>
                                            <p class="mb-2">
                                                <i class="fas fa-leaf me-2"></i>
                                                <strong>Dietary Category:</strong> {{ ucfirst($mealPlan->dietary_category) }}
                                            </p>
                                        </div>

                                        @if($mealPlan->menu->menu_items)
                                            <div class="menu-items mt-3">
                                                <p class="mb-2"><strong>Menu Items:</strong></p>
                                                <ul class="list-unstyled">
                                                    @foreach($mealPlan->menu->menu_items as $item)
                                                        <li><i class="fas fa-check me-2 text-success"></i>{{ $item['name'] }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            No meal plans have been assigned to you yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    @include('dashboard.member.modals.update-preferences')
    @include('dashboard.member.modals.special-request')
    @include('dashboard.member.modals.contact-support')
@endsection


