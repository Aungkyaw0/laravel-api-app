@extends('layouts.app')

@section('title', 'Member Dashboard - Meals on Wheels')

@section('styles')
<style>
    .dashboard-container {
        padding: 2rem 0;
    }

    .dashboard-header {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset("") }}');
        background-size: cover;
        background-position: center;
        padding: 7rem 0;
        color: white;
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

    .status-processing {
        background-color: #dbeafe;
        color: #1e40af;
    }

    .status-delivered {
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
    <section class="dashboard-header" style="margin-top: 100px;">
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
    @if(session('success'))
        <div class="container">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="container">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

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
                    @forelse($mealPlans->where('status', 'scheduled') as $mealPlan)
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

                                        <div class="mt-3">
                                            <form action="{{ route('member.create-order') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="meal_plan_id" value="{{ $mealPlan->id }}">
                                                <button type="submit" class="btn btn-primary" 
                                                        {{ $mealPlan->status === 'completed' || $mealPlan->status === 'cancelled' ? 'disabled' : '' }}>
                                                    <i class="fas fa-shopping-cart me-2"></i>Request Order
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            No active meal plans are currently assigned to you.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Order section -->
            <div class="row mt-5">
                <div class="col-md-12">
                    <h2 class="h4 mb-4">My Orders</h2>
                    @forelse(Auth::user()->member->orders()->latest()->get() as $order)
                        <div class="meal-card">
                            <div class="row g-0">
                                <div class="col-md-12">
                                    <div class="meal-card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h3 class="h5">Order #{{ $order->id }}</h3>
                                                <p class="text-muted mb-2">
                                                    <i class="fas fa-calendar me-2"></i>
                                                    Delivery Date: {{ \Carbon\Carbon::parse($order->delivery_start_date)->format('M d, Y') }}
                                                </p>
                                            </div>
                                            <span class="text-muted me-4">
                                                Delivery Status: <span class="status-badge status-{{ strtolower($order->delivery_status) }}">
                                                    {{ ucfirst($order->delivery_status) }}
                                                </span>
                                            </span>
                                            
                                        </div>
                                        
                                        <div class="meal-info mt-3">
                                            <p class="mb-2">
                                                <i class="fas fa-utensils me-2"></i>
                                                <strong>Meal Type:</strong> {{ ucfirst($order->delivery_meal_type) }}
                                            </p>
                                            @if($order->caregiver)
                                            <p class="mb-2">
                                                <i class="fas fa-user-nurse me-2"></i>
                                                <strong>Caregiver:</strong> {{ $order->caregiver->name }}
                                            </p>
                                            @endif
                                            @if($order->volunteer)
                                            <p class="mb-2">
                                                <i class="fas fa-motorcycle me-2"></i>
                                                <strong>Delivery Partner:</strong> {{ $order->volunteer->name }}
                                            </p>
                                            @endif
                                        </div>

                                        @if($order->mealPlan && $order->mealPlan->menu)
                                            <div class="menu-items mt-3">
                                                <p class="mb-2"><strong>Menu Details:</strong></p>
                                                <p class="mb-1">{{ $order->mealPlan->menu->name }}</p>
                                                @if($order->mealPlan->menu->menu_items)
                                                    <ul class="list-unstyled">
                                                        @foreach($order->mealPlan->menu->menu_items as $item)
                                                            <li><i class="fas fa-check me-2 text-success"></i>{{ $item['name'] }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        @endif

                                        @if($order->delivery_status === 'assigned' && !$order->delivery_confirmation_code)
                                            <div class="mt-3">
                                                <button class="btn btn-outline-primary me-2" onclick="window.print()">
                                                    <i class="fas fa-print me-2"></i>Print Receipt
                                                </button>
                                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmDeliveryModal{{ $order->id }}">
                                                    <i class="fas fa-check me-2"></i>Confirm Delivery
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            You haven't placed any orders yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    @foreach(Auth::user()->member->orders()->latest()->get() as $order)
    <div class="modal fade" id="confirmDeliveryModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delivery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('member.confirm-delivery', $order->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="confirmation_code" class="form-label">Enter Delivery Confirmation Code</label>
                            <input type="text" class="form-control" id="confirmation_code" name="confirmation_code" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Confirm Delivery</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('dashboard.member.modals.update-preferences')
    @include('dashboard.member.modals.special-request')
    @include('dashboard.member.modals.contact-support')

    @endforeach
@endsection



