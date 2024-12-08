@extends('layouts.app')

@section('title', 'Volunteer Dashboard - Meals on Wheels')

@section('styles')
<style>
    .dashboard-container {
        padding: 2rem 0;
    }

    .dashboard-header {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset("images/volunteer-hero.jpg") }}');
        background-size: cover;
        background-position: center;
        padding: 3rem 0;
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

    .delivery-item {
        border-left: 4px solid #2ECC71;
        background: white;
        margin-bottom: 1rem;
        padding: 1.5rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .delivery-item:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .delivery-item.pending {
        border-left-color: #F1C40F;
    }

    .delivery-item.completed {
        border-left-color: #3498DB;
    }

    .status-badge {
        padding: 0.35em 0.65em;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
    <!-- Dashboard Header -->
    <div class="dashboard-header" style="margin-top: 100px;">
        <div class="container">
            <h1 class="mb-3">Welcome, {{ $volunteer->name }}</h1>
            <p class="lead mb-0">Thank you for helping deliver meals to those in need.</p>
        </div>
    </div>
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

    <div class="container dashboard-container">
        <!-- Availability Status -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stats-card">
                    <h5 class="card-title mb-3">Your Availability</h5>
                    <form action="{{ route('volunteer.update-availability') }}" method="POST">
                        @csrf
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="available" {{ $volunteer->status === 'available' ? 'selected' : '' }}>
                                🟢 Available
                            </option>
                            <option value="unavailable" {{ $volunteer->status === 'unavailable' ? 'selected' : '' }}>
                                🔴 Unavailable
                            </option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <h5 class="card-title">Pending Deliveries</h5>
                    <h2 class="mb-0 text-warning">{{ $stats['pending'] }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <h5 class="card-title">Completed Deliveries</h5>
                    <h2 class="mb-0 text-success">{{ $stats['completed'] }}</h2>
                </div>
            </div>
        </div>

        <!-- Available Deliveries -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Available Orders</h5>
            </div>
            <div class="card-body">
                @forelse($availableOrders as $order)
                    <div class="delivery-item pending">
                        <div class="row">
                            <!-- Left Side: Order and Member Info -->
                            <div class="col-md-6">
                                <!-- Order Info -->
                                <div class="d-flex align-items-center mb-2">
                                    <h4 class="mb-0">Order #{{ $order->id }}</h4>
                                    <span class="status-badge bg-warning text-dark ms-2">Pending</span>
                                </div>
                                
                                <!-- Member Information -->
                                <div class="mb-3">
                                    <h6 class="text-primary mb-2">Member Details</h6>
                                    <p class="mb-2">
                                        <i class="fas fa-user text-primary me-2"></i>
                                        Member: {{ $order->member->name }}
                                    </p>
                                    <p class="mb-2">
                                        <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                        Address: {{ $order->member->address }}
                                    </p>
                                    <p class="mb-2">
                                        <i class="fas fa-location-dot text-info me-2"></i>
                                        Coordinates: {{ $order->member->latitude }}, {{ $order->member->longitude }}
                                    </p>
                                </div>
            
                                <!-- Order Details -->
                                <div>
                                    <h6 class="text-primary mb-2">Delivery Details</h6>
                                    <p class="mb-2">
                                        <i class="fas fa-utensils text-success me-2"></i>
                                        Meal Type: {{ $order->delivery_meal_type }}
                                    </p>
                                    <p class="mb-2">
                                        <i class="fas fa-calendar text-info me-2"></i>
                                        Delivery Date: {{ \Carbon\Carbon::parse($order->delivery_start_date)->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
            
                            <!-- Right Side: Partner Info -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="text-success mb-2">Partner Details</h6>
                                    <p class="mb-2">
                                        <i class="fas fa-building text-success me-2"></i>
                                        Company: {{ $order->partner->company_name }}
                                    </p>
                                    <p class="mb-2">
                                        <i class="fas fa-phone text-primary me-2"></i>
                                        Phone: {{ $order->partner->phone }}
                                    </p>
                                    <p class="mb-2">
                                        <i class="fas fa-map-pin text-danger me-2"></i>
                                        Address: {{ $order->partner->location }}
                                    </p>
                                    <p class="mb-2">
                                        <i class="fas fa-location-dot text-info me-2"></i>
                                        Coordinates: {{ $order->partner->latitude }}, {{ $order->partner->longitude }}
                                    </p>
                                </div>
            
                                <!-- Accept Button -->
                                <div class="text-end mt-3">
                                    <form action="{{ route('volunteer.accept-order', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-check me-2"></i>Accept
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-box fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No orders available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Active Deliveries -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-truck me-2"></i>Your Active Deliveries</h5>
            </div>
            <div class="card-body">
                @forelse($activeOrders as $order)
                    <div class="delivery-item">
                        <div class="row">
                            <!-- Left Side: Order and Member Info -->
                            <div class="col-md-6">
                                <!-- Order Info -->
                                <div class="d-flex align-items-center mb-2">
                                    <h4 class="mb-0">Order #{{ $order->id }}</h4>
                                    <span class="status-badge bg-primary text-white ms-2">{{ ucfirst($order->delivery_status) }}</span>
                                </div>
                                
                                <!-- Member Information -->
                                <div class="mb-3">
                                    <h6 class="text-primary mb-2">Member Details</h6>
                                    <p class="mb-2">
                                        <i class="fas fa-user text-primary me-2"></i>
                                        Member: {{ $order->member->name }}
                                    </p>
                                    <p class="mb-2">
                                        <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                        Address: {{ $order->member->address }}
                                    </p>
                                    <p class="mb-2">
                                        <i class="fas fa-location-dot text-info me-2"></i>
                                        Coordinates: {{ $order->member->latitude }}, {{ $order->member->longitude }}
                                    </p>
                                </div>
            
                                <!-- Order Details -->
                                <div>
                                    <h6 class="text-primary mb-2">Delivery Details</h6>
                                    <p class="mb-2">
                                        <i class="fas fa-utensils text-success me-2"></i>
                                        Meal Type: {{ $order->delivery_meal_type }}
                                    </p>
                                    <p class="mb-2">
                                        <i class="fas fa-calendar text-info me-2"></i>
                                        Delivery Date: {{ \Carbon\Carbon::parse($order->delivery_start_date)->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
            
                            <!-- Right Side: Partner Info and Actions -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="text-success mb-2">Partner Details</h6>
                                    <p class="mb-2">
                                        <i class="fas fa-building text-success me-2"></i>
                                        Company: {{ $order->partner->company_name }}
                                    </p>
                                    <p class="mb-2">
                                        <i class="fas fa-phone text-primary me-2"></i>
                                        Phone: {{ $order->partner->phone }}
                                    </p>
                                    <p class="mb-2">
                                        <i class="fas fa-map-pin text-danger me-2"></i>
                                        Address: {{ $order->partner->location }}
                                    </p>
                                    <p class="mb-2">
                                        <i class="fas fa-location-dot text-info me-2"></i>
                                        Coordinates: {{ $order->partner->latitude }}, {{ $order->partner->longitude }}
                                    </p>
                                </div>

                                <!-- Status Update and Actions -->
                                <div class="mt-3 pt-5">
        

                                    @if($order->delivery_status !== 'delivered')
                                        <button type="button" class="btn btn-success btn-sm w-100" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#completeModal{{ $order->id }}">
                                            <i class="fas fa-check-circle me-2"></i>Complete Delivery
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Complete Delivery Modal -->
                    @include('dashboard.volunteer.partials.complete-modal', ['delivery' => $order])
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-truck fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No active deliveries.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Completed Deliveries -->
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-check-double me-2"></i>Completed Deliveries</h5>
            </div>
            <div class="card-body">
                @forelse($completedOrders as $order)
                    <div class="delivery-item completed">
                        <div class="row">
                            <!-- Left Side: Order and Member Info -->
                            <div class="col-md-6">
                                <!-- Order Info -->
                                <div class="d-flex align-items-center mb-2">
                                    <h4 class="mb-0">Order #{{ $order->id }}</h4>
                                    <span class="status-badge bg-info text-white ms-2">Completed</span>
                                </div>
                                
                                <!-- Member Information -->
                                <div class="mb-3">
                                    <h6 class="text-primary mb-2">Member Details</h6>
                                    <p class="mb-2">
                                        <i class="fas fa-user text-primary me-2"></i>
                                        Member: {{ $order->member->name }}
                                    </p>
                                    <p class="mb-2">
                                        <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                        Address: {{ $order->member->address }}
                                    </p>
                                </div>
            
                                <!-- Order Details -->
                                <div>
                                    <h6 class="text-primary mb-2">Delivery Details</h6>
                                    <p class="mb-2">
                                        <i class="fas fa-utensils text-success me-2"></i>
                                        Meal Type: {{ $order->delivery_meal_type }}
                                    </p>
                                    <p class="mb-2">
                                        <i class="fas fa-clock text-warning me-2"></i>
                                        Started: {{ \Carbon\Carbon::parse($order->delivery_start_date)->format('M d, Y g:i A') }}
                                    </p>
                                    <p class="mb-2">
                                        <i class="fas fa-flag-checkered text-success me-2"></i>
                                        Completed: {{ \Carbon\Carbon::parse($order->delivery_end_date)->format('M d, Y g:i A') }}
                                    </p>
                                </div>
                            </div>
            
                            <!-- Right Side: Partner Info and Notes -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="text-success mb-2">Partner Details</h6>
                                    <p class="mb-2">
                                        <i class="fas fa-building text-success me-2"></i>
                                        Company: {{ $order->partner->company_name }}
                                    </p>
                                    <p class="mb-2">
                                        <i class="fas fa-map-pin text-danger me-2"></i>
                                        Address: {{ $order->partner->location }}
                                    </p>
                                </div>

                                @if($order->delivery_notes)
                                    <div class="mt-3">
                                        <h6 class="text-primary mb-2">Delivery Notes</h6>
                                        <div class="p-3 bg-light rounded">
                                            <i class="fas fa-comment-alt text-muted me-2"></i>
                                            {{ $order->delivery_notes }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-check fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No completed deliveries yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Show success/error messages with fade effect
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 150);
            }, 3000);
        });
    });

    // Smooth status updates
    const statusSelects = document.querySelectorAll('select[name="status"]');
    statusSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.closest('form').classList.add('updating');
        });
    });
</script>
@endpush