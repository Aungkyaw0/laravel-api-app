@extends('layouts.app')

@section('title', 'Partner Dashboard - Meals on Wheels')

@section('styles')
<style>
    :root {
        --primary-color: #2ECC71;
        --secondary-color: #27AE60;
        --warning-color: #F1C40F;
        --danger-color: #E74C3C;
    }

    .dashboard-container {
        padding-top: 76px;
    }

    .dashboard-header {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset("img/partner-bg.jpg") }}');
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

    .stats-card:hover {
        transform: translateY(-5px);
    }
</style>
@endsection

@section('content')
<div class="dashboard-container">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="container">
            <h1 class="display-4">Welcome, {{ Auth::user()->name }}</h1>
            <p class="lead">Manage your partnership with Meals on Wheels</p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Statistics Overview -->
            <div class="col-md-4">
                <div class="stats-card">
                    <h3 class="h5 mb-3">Active Food Services</h3>
                    <h2 class="display-6 mb-0">{{ $activeFoodServices }}</h2>
                    <small class="text-muted">Currently active services</small>
                </div>
            </div>

            <!-- Food Services Section -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Your Food Services</h5>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createFoodServiceModal">
                            <i class="fas fa-plus"></i> Add New Service
                        </button>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        @forelse($foodServices as $service)
                            <div class="d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                                <div>
                                    <h6 class="mb-1">{{ $service->name }}</h6>
                                    <small class="text-muted d-block">{{ $service->description }}</small>
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> {{ $service->operating_hours[0]}}
                                    </small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-{{ $service->status === 'active' ? 'success' : ($service->status === 'pending' ? 'warning' : 'secondary') }} me-2">
                                        {{ ucfirst($service->status) }}
                                    </span>
                                    <button class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#manageMealsModal"
                                            data-service-id="{{ $service->id }}">
                                        Manage Meals
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="fas fa-utensils fa-2x text-muted mb-3"></i>
                                <p class="text-muted mb-0">No food services added yet.</p>
                                <small class="text-muted">Click the "Add New Service" button to get started.</small>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Modals -->
@include('dashboard.partner.modals.create-food-service')
@include('dashboard.partner.modals.manage-meals')
@include('dashboard.partner.modals.update-profile')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var manageMealsModal = document.getElementById('manageMealsModal');
        manageMealsModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var serviceId = button.getAttribute('data-service-id');
            console.log('Service ID:', serviceId); // Debugging line
            
            var form = document.getElementById('addMealForm');
            if (serviceId) {
                var baseUrl = "{{ url('/partner/food-services') }}";
                form.action = `${baseUrl}/${serviceId}/meals`;
                console.log('Form action updated to:', form.action); // Debugging line

                // Fetch meals for the selected food service
                fetch(`${baseUrl}/${serviceId}/meals`)
                    .then(response => response.json())
                    .then(meals => {
                        var mealsList = document.getElementById('mealsList');
                        mealsList.innerHTML = ''; // Clear existing meals
                        if (meals.length > 0) {
                            meals.forEach(meal => {
                                var mealItem = document.createElement('div');
                                mealItem.className = 'list-group-item';
                                mealItem.innerHTML = `
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">${meal.name}</h6>
                                            <small>${meal.description}</small>
                                            <div class="mt-1">
                                                <span class="badge bg-info">${meal.meal_type}</span>
                                                ${meal.dietary_flags.map(flag => `<span class="badge bg-secondary">${flag}</span>`).join('')}
                                            </div>
                                        </div>
                                    </div>
                                `;
                                mealsList.appendChild(mealItem);
                            });
                        } else {
                            mealsList.innerHTML = '<p class="text-muted">No meals added yet.</p>';
                        }
                    })
                    .catch(error => console.error('Error fetching meals:', error));
            } else {
                console.error('Service ID not found');
            }
        });
    });
</script>
@endsection 