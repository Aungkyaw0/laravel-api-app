@extends('layouts.app')

@section('title', 'Volunteer Dashboard - Meals on Wheels')

@section('styles')
<style>
    .dashboard-container {
        padding-top: 76px;
    }

    .dashboard-header {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset("img/volunteer-bg.jpg") }}');
        background-size: cover;
        background-position: center;
        padding: 4rem 0;
        color: white;
        margin-bottom: 2rem;
    }

    .stats-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .delivery-item {
        border-left: 4px solid #2ECC71;
        background: white;
        margin-bottom: 1rem;
        padding: 1rem;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .delivery-item.pending {
        border-left-color: #F1C40F;
    }

    .delivery-item.completed {
        border-left-color: #3498DB;
    }
</style>
@endsection

@section('content')
<div class="dashboard-container">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="container">
            <h1 class="display-4">Welcome, {{ Auth::user()->name }}</h1>
            <p class="lead">Thank you for volunteering with Meals on Wheels</p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Availability Status -->
            <div class="col-md-4">
                <div class="stats-card">
                    <h5 class="card-title mb-3">Your Availability</h5>
                    <form id="availabilityForm">
                        @csrf
                        <div class="mb-3">
                            <select class="form-select" name="status" id="availabilityStatus">
                                <option value="available" {{ $volunteer->status === 'available' ? 'selected' : '' }}>Available</option>
                                <option value="unavailable" {{ $volunteer->status === 'unavailable' ? 'selected' : '' }}>Not Available</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </form>
                </div>
            </div>

            <!-- Delivery Statistics -->
            <div class="col-md-8">
                <div class="stats-card">
                    <h5 class="card-title mb-3">Your Deliveries</h5>
                    <div class="row text-center">
                        <div class="col">
                            <h3 class="text-primary">{{ $stats['pending'] ?? 0 }}</h3>
                            <p class="text-muted">Pending</p>
                        </div>
                        <div class="col">
                            <h3 class="text-success">{{ $stats['completed'] ?? 0 }}</h3>
                            <p class="text-muted">Completed</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Deliveries -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Available Deliveries</h5>
                    </div>
                    <div class="card-body">
                        @forelse($availableDeliveries as $delivery)
                            <div class="delivery-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Delivery #{{ $delivery->id }}</h6>
                                        <small class="text-muted d-block">
                                            <i class="fas fa-map-marker-alt"></i> 
                                            {{ $delivery->delivery_address }}
                                        </small>
                                    </div>
                                    <button class="btn btn-primary btn-sm accept-delivery" 
                                            data-delivery-id="{{ $delivery->id }}">
                                        Accept Delivery
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="fas fa-box fa-2x text-muted mb-3"></i>
                                <p class="text-muted mb-0">No deliveries available at the moment.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Deliveries -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Your Active Deliveries</h5>
                    </div>
                    <div class="card-body">
                        @forelse($activeDeliveries as $delivery)
                            <div class="delivery-item {{ $delivery->status }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Delivery #{{ $delivery->id }}</h6>
                                        <small class="text-muted d-block">
                                            <i class="fas fa-map-marker-alt"></i> 
                                            {{ $delivery->delivery_address }}
                                        </small>
                                    </div>
                                    <select class="form-select form-select-sm delivery-status" 
                                            style="width: auto;"
                                            data-delivery-id="{{ $delivery->id }}">
                                        <option value="picked_up" {{ $delivery->status === 'picked_up' ? 'selected' : '' }}>Picked Up</option>
                                        <option value="in_transit" {{ $delivery->status === 'in_transit' ? 'selected' : '' }}>In Transit</option>
                                        <option value="delivered" {{ $delivery->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    </select>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="fas fa-truck fa-2x text-muted mb-3"></i>
                                <p class="text-muted mb-0">No active deliveries.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update Availability
        document.getElementById('availabilityForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const status = document.getElementById('availabilityStatus').value;
            
            fetch('/volunteer/availability', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        });

        // Accept Delivery
        document.querySelectorAll('.accept-delivery').forEach(button => {
            button.addEventListener('click', function() {
                const deliveryId = this.getAttribute('data-delivery-id');
                
                fetch(`/volunteer/deliveries/${deliveryId}/accept`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
            });
        });

        // Update Delivery Status
        document.querySelectorAll('.delivery-status').forEach(select => {
            select.addEventListener('change', function() {
                const deliveryId = this.getAttribute('data-delivery-id');
                const status = this.value;
                
                fetch(`/volunteer/deliveries/${deliveryId}/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ status: status })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
            });
        });
    });
</script>
@endpush
@endsection