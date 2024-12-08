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
<div class="dashboard-container" style="margin-top: 100px;">
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
                        @if(session('meal_success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('meal_success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        @forelse($foodServices as $service)
                            <div class="d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                                <div>
                                    <h6 class="mb-1">{{ $service->service_name }}</h6>
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

            <!-- Pending Orders Section -->
            <div class="col-12 mt-4 mb-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Pending Orders</h5>
                    </div>
                    <div class="card-body">
                        @if($pendingOrders->isEmpty())
                            <div class="text-center py-4">
                                <i class="fas fa-clipboard-list fa-2xtext-muted mb-3"></i>
                                <p class="text-muted mb-0">No pending ordersat the moment.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Member Name</th>
                                            <th>Meal Plan</th>
                                            <th>Meal Type</th>
                                            <th>Meals Included</th>
                                            <th>Delivery Period</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendingOrders as $order)
                                            <tr>
                                                <td>#{{ $order->id }}</td>
                                                <td>{{ $order->member->name }}</td>
                                                <td>{{ $order->mealPlan->menu->name }}</td>
                                                <td>{{ ucfirst($order->delivery_meal_type) }}</td>
                                                <td>
                                                    @if($order->mealPlan->menu)  
                                                        <button type="button" 
                                                                class="btn btn-info btn-sm" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#mealDetailsModal{{ $order->id }}">
                                                            View Meals
                                                        </button>

                                                        <!-- Meal Details Modal -->
                                                        <div class="modal fade" id="mealDetailsModal{{ $order->id }}" tabindex="-1">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Meals in Order #{{ $order->id }}</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        @if(is_array($order->mealPlan->menu->menu_items))
                                                                            @foreach($order->mealPlan->menu->menu_items as $menuItem)
                                                                                <div class="card mb-2">
                                                                                    <div class="card-body">
                                                                                        <h6 class="card-title">{{ $menuItem['name'] }}</h6>
                                                                                        <p class="card-text small">{{ $menuItem['description'] ?? 'No description available' }}</p>
                                                                                        <div class="mt-2">
                                                                                            <span class="badge bg-info">{{ ucfirst($order->mealPlan->menu->meal_type) }}</span>
                                                                                            @if(isset($menuItem['dietary_flags']))
                                                                                                @foreach($menuItem['dietary_flags'] as $flag)
                                                                                                    <span class="badge bg-secondary">{{ $flag }}</span>
                                                                                                @endforeach
                                                                                            @endif
                                                                                        </div>
                                                                                        @if(isset($menuItem['availability_status']))
                                                                                            <div class="mt-2">
                                                                                                <small class="text-muted">
                                                                                                    Status: {{ ucfirst($menuItem['availability_status']) }}
                                                                                                </small>
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        @else
                                                                            <p class="text-muted">No menu items available</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">No menu details available</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($order->delivery_start_date && $order->delivery_end_date)
                                                        {{ $order->delivery_start_date->format('M d, Y') }} -
                                                        {{ $order->delivery_end_date->format('M d, Y') }}
                                                    @else
                                                        <span class="text-muted">Not specified</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <form action="{{ route('partner.accept-order', $order) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm">
                                                            Accept Order
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Accepted Orders Section -->
            <div class="col-12 mt-4 mb-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Accepted Orders</h5>
                    </div>
                    <div class="card-body">
                        @if($acceptedOrders->isEmpty())
                            <div class="text-center py-4">
                                <i class="fas fa-check-circle fa-2x text-muted mb-3"></i>
                                <p class="text-muted mb-0">No accepted orders at the moment.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Member Name</th>
                                            <th>Meal Plan</th>
                                            <th>Meal Type</th>
                                            <th>Meals Included</th>
                                            <th>Delivery Period</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($acceptedOrders as $order)
                                            <tr>
                                                <td>#{{ $order->id }}</td>
                                                <td>{{ $order->member->name }}</td>
                                                <td>{{ $order->mealPlan->menu->name }}</td>
                                                <td>{{ ucfirst($order->delivery_meal_type) }}</td>
                                                <td>
                                                    @if($order->mealPlan->menu)  
                                                        <button type="button" 
                                                                class="btn btn-info btn-sm" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#mealDetailsModal{{ $order->id }}">
                                                            View Meals
                                                        </button>

                                                        <!-- Meal Details Modal -->
                                                        <div class="modal fade" id="mealDetailsModal{{ $order->id }}" tabindex="-1">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Meals in Order #{{ $order->id }}</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        @if(is_array($order->mealPlan->menu->menu_items))
                                                                            @foreach($order->mealPlan->menu->menu_items as $menuItem)
                                                                                <div class="card mb-2">
                                                                                    <div class="card-body">
                                                                                        <h6 class="card-title">{{ $menuItem['name'] }}</h6>
                                                                                        <p class="card-text small">{{ $menuItem['description'] ?? 'No description available' }}</p>
                                                                                        <div class="mt-2">
                                                                                            <span class="badge bg-info">{{ ucfirst($order->mealPlan->menu->meal_type) }}</span>
                                                                                            @if(isset($menuItem['dietary_flags']))
                                                                                                @foreach($menuItem['dietary_flags'] as $flag)
                                                                                                    <span class="badge bg-secondary">{{ $flag }}</span>
                                                                                                @endforeach
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        @else
                                                                            <p class="text-muted">No menu items available</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">No menu details available</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($order->delivery_start_date && $order->delivery_end_date)
                                                        {{ $order->delivery_start_date->format('M d, Y') }} -
                                                        {{ $order->delivery_end_date->format('M d, Y') }}
                                                    @else
                                                        <span class="text-muted">Not specified</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-success">
                                                        Accepted
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delivery Status Section -->
    
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
