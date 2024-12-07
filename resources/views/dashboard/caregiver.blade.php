@extends('layouts.app')

@section('title', 'Caregiver Dashboard - Meals on Wheels')

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
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset("img/caregiver-bg.jpg") }}');
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

    .action-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
        border-left: 4px solid var(--primary-color);
        transition: all 0.3s ease;
    }

    .action-card:hover {
        transform: translateX(5px);
    }

    .menu-section {
        background: #f8f9fa;
        padding: 2rem 0;
        margin: 2rem 0;
        border-radius: 15px;
    }

    .meal-card {
        background: white;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .status-active { background: rgba(46, 204, 113, 0.2); color: #27AE60; }
    .status-pending { background: rgba(241, 196, 15, 0.2); color: #F1C40F; }

    /* Dietary Request Card Styles */
    .dietary-request-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
        border: 1px solid #e9ecef;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .dietary-request-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .request-header {
        padding: 1.25rem;
        border-bottom: 1px solid #e9ecef;
        background-color: #f8f9fa;
        border-radius: 12px 12px 0 0;
    }

    .request-body {
        padding: 1.25rem;
    }

    .request-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 1rem;
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: 8px;
    }

    .request-info-item {
        display: flex;
        flex-direction: column;
    }

    .request-info-label {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }

    .request-info-value {
        font-weight: 500;
        color: #2c3e50;
    }

    .request-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .request-actions button {
        flex: 1;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .request-actions .btn-approve {
        background-color: #28a745;
        border-color: #28a745;
        color: white;
    }

    .request-actions .btn-reject {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    .request-actions .btn-approve:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .request-actions .btn-reject:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .request-timestamp {
        font-size: 0.875rem;
        color: #6c757d;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .request-timestamp i {
        font-size: 1rem;
    }

    .request-reason {
        background-color: #fff8dc;
        padding: 1rem;
        border-radius: 8px;
        margin: 1rem 0;
        border-left: 4px solid #ffd700;
    }

    .request-notes {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        margin-top: 1rem;
        border-left: 4px solid #6c757d;
    }

    .pending-requests-header {
        background-color: #fff;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .pending-count {
        background-color: #ffd700;
        color: #000;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.875rem;
    }

    .food-service-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        height: 100%;
    }

    .service-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .service-info {
        margin-bottom: 1.5rem;
    }

    .service-info p {
        margin-bottom: 0.5rem;
        color: #6c757d;
    }

    .service-action {
        margin-top: auto;
    }

    .meal-type-selector {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        margin-top: 0.5rem;
    }

    .dietary-categories {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        margin-top: 0.5rem;
    }

    .form-check-label {
        cursor: pointer;
    }

    .table-responsive {
        max-height: 400px;
        overflow-y: auto;
    }

    .meal-row:hover {
        background-color: #f8f9fa;
        cursor: pointer;
    }

    .meal-row td {
        vertical-align: middle;
    }

    .badge {
        font-size: 0.8rem;
        padding: 0.35em 0.65em;
    }
</style>
@endsection

@section('content')
<div class="dashboard-container">
    <!-- Dashboard Header -->
    <section class="dashboard-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1>Welcome, {{ Auth::user()->name }}!</h1>
                    <p class="lead mb-0">Manage your members and meal services</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <span class="status-badge status-active">Active Caregiver</span>
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

    <div class="container">
        <!-- Quick Stats -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stats-card">
                    <h3 class="h5">Assigned Members</h3>
                    <div class="d-flex align-items-center mt-3">
                        <i class="fas fa-users fa-2x text-primary me-3"></i>
                        <span class="h3 mb-0">{{ $members->count() ?? 0 }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <h3 class="h5">Active Menus</h3>
                    <div class="d-flex align-items-center mt-3">
                        <i class="fas fa-utensils fa-2x text-success me-3"></i>
                        <span class="h3 mb-0">{{ $activeMenus ?? 0 }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <h3 class="h5">Pending Requests</h3>
                    <div class="d-flex align-items-center mt-3">
                        <i class="fas fa-clock fa-2x text-warning me-3"></i>
                        <span class="h3 mb-0">{{ $pendingRequests->count() }}</span>
                    </div>
                </div>
            </div>
        </div>


        <!-- Main Content -->
        <div class="row">
            <!-- Left Column - Member Management -->
            <div class="col-lg-6">
                <div class="action-card">
                    <h2 class="h4 mb-4">Meal Plan Management</h2>
                    <div class="list-group">
                        @forelse($members ?? [] as $member)
                            <div class="list-group-item border-0 mb-3 rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1">{{ $member->name }}</h5>
                                        <p class="mb-1 text-muted">
                                            <i class="fas fa-utensils me-2"></i>
                                            {{ ucfirst($member->dietary_requirement) }}
                                        </p>
                                    </div>
                                    <button class="btn btn-primary btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#assignMealPlanModal"
                                            data-member-id="{{ $member->id }}"
                                            data-member-name="{{ $member->name }}"
                                            data-dietary-requirement="{{ $member->dietary_requirement }}">
                                        <i class="fas fa-calendar-plus me-2"></i>Assign Meal Plan
                                    </button>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">No members assigned yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column - Food Services -->
            <!--
            <div class="col-lg-6">
                <div class="action-card">
                    <h2 class="h4 mb-4">Food Services</h2>
                    <div class="list-group">
                        {{-- {{ $foodServices }} --}}
                        @forelse($foodServices as $service)
                            <div class="list-group-item border-0 mb-3 rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1">{{ $service->service_name }}</h5>
                                        <p class="mb-1 text-muted">
                                            <i class="fas fa-box me-2"></i>
                                            {{ $service->meals_count ?? 0 }} meals available
                                        </p>
                                    </div>
                                    <div class="service-action d-flex gap-2">
                                        <button type="button" 
                                                class="btn btn-outline-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#viewMealsModal{{ $service->id }}">
                                            <i class="fas fa-eye me-2"></i>View Meals
                                        </button>
                                        <button type="button" 
                                                class="btn btn-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#createMenuModal_{{ $service->id }}">
                                            <i class="fas fa-plus-circle me-2"></i>Create Menu
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">No active food services available.</p>
                        @endforelse
                    </div>
                </div>

                
            </div> -->
        </div>
        <!-- Current Menus -->
        <div class="row mb-4">
            <div class="pending-requests-header">
                <h2 class="h4 mb-0"> Draft Menus </h2>
                <span class="pending-count">
                    <i class="fas fa-clock me-2"></i>
                    {{ $draftMenus ?? 0 }} Draft
                </span>
            </div>
            @forelse($menus->where('status', 'draft') as $menu)            
            <div class="meal-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="mb-1">{{ ucfirst($menu->name) }} Menu</h5>
                        <p class="mb-1 text-muted">
                            <i class="fas fa-bars me-2"></i>
                            {{ ucfirst($menu->meal_type) }}
                        </p>
                        <p class="mb-1 text-muted">
                            <i class="fas fa-calendar me-2"></i>
                            {{ \Carbon\Carbon::parse($menu->available_date)->format('M d, Y') }}
                        </p>
                        <span class="badge bg-{{ $menu->status === 'draft' ? 'warning' : 'success' }}">
                            {{ ucfirst($menu->status) }}
                        </span>
                    </div>
                    <button class="btn btn-sm btn-outline-primary" 
                            data-bs-toggle="modal" 
                            data-bs-target="#viewMenuModal_{{ $menu->id }}">
                        <i class="fas fa-eye me-1"></i>View Details
                    </button>
                </div>
            </div>
        @empty
            <p class="text-muted">No menus created yet.</p>
        @endforelse
        </div>
        <!-- Pending Dietary Requests Section -->
        <div class="row mb-4">
            <div class="col-12 mt-4">
                <div class="pending-requests-header">
                    <h2 class="h4 mb-0">Pending Dietary Requests</h2>
                    <span class="pending-count">
                        <i class="fas fa-clock me-2"></i>
                        {{ $pendingRequests->count() }} Pending
                    </span>
                </div>

                @forelse($pendingRequests as $request)
                    <div class="dietary-request-card">
                        <div class="request-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">{{ $request->member->name }}</h5>
                                <span class="request-timestamp">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ $request->created_at->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                        <div class="request-body">
                            <div class="request-info-grid">
                                <div class="request-info-item">
                                    <span class="request-info-label">Current Diet</span>
                                    <span class="request-info-value">{{ ucfirst($request->current_dietary_requirement) }}</span>
                                </div>
                                <div class="request-info-item">
                                    <span class="request-info-label">Requested Diet</span>
                                    <span class="request-info-value">{{ ucfirst($request->requested_dietary_requirement) }}</span>
                                </div>
                                <div class="request-info-item">
                                    <span class="request-info-label">Current Meal Type</span>
                                    <span class="request-info-value">{{ ucfirst($request->current_prefer_meal) }}</span>
                                </div>
                                <div class="request-info-item">
                                    <span class="request-info-label">Requested Meal Type</span>
                                    <span class="request-info-value">{{ ucfirst($request->requested_prefer_meal) }}</span>
                                </div>
                            </div>

                            <div class="request-reason">
                                <h6 class="mb-2"><i class="fas fa-info-circle me-2"></i>Reason for Change</h6>
                                <p class="mb-0">{{ $request->reason }}</p>
                            </div>

                            @if($request->additional_notes)
                                <div class="request-notes">
                                    <h6 class="mb-2"><i class="fas fa-sticky-note me-2"></i>Additional Notes</h6>
                                    <p class="mb-0">{{ $request->additional_notes }}</p>
                                </div>
                            @endif

                            <div class="request-actions">
                                <form action="{{ route('caregiver.manage-dietary-requests', $request->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-approve" onclick="return confirm('Are you sure you want to approve this dietary request? This will update the member\'s dietary preferences.')">
                                        <i class="fas fa-check me-2"></i>Approve
                                    </button>
                                </form>

                                <form action="{{ route('caregiver.manage-dietary-requests', $request->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-reject" onclick="return confirm('Are you sure you want to reject this dietary request?')">
                                        <i class="fas fa-times me-2"></i>Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="dietary-request-card">
                        <div class="request-body text-center py-5">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h5>No Pending Requests</h5>
                            <p class="text-muted mb-0">All dietary requests have been processed</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Food Services Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">Active Food Services</h4>
                    </div>
                    <div class="card-body">
                        @if($foodServices->count() > 0)
                            <div class="row">
                                @foreach($foodServices as $service)
                                    <div class="col-md-6 mb-4">
                                        <div class="food-service-card">
                                            <div class="service-header">
                                                <h5>{{ $service->service_name }}</h5>
                                                <span class="badge bg-success">Active</span>
                                            </div>
                                            <div class="service-info">
                                                <p><i class="fas fa-map-marker-alt me-2"></i>{{ $service->service_area }}</p>
                                                <p><i class="fas fa-utensils me-2"></i>{{ ucfirst($service->cuisine_type) }}</p>
                                                <p><i class="fas fa-clock me-2"></i>{{ $service->operating_hours[0] }}</p>
                                            </div>
                                            <div class="service-action d-flex gap-2">
                                                <button type="button" 
                                                        class="btn btn-outline-primary view-meals-btn" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#viewMealsModal_{{ $service->id }}">
                                                    <i class="fas fa-eye me-2"></i>View Meals
                                                </button>
                                                <button type="button" 
                                                        class="btn btn-primary" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#createMenuModal_{{ $service->id }}">
                                                    <i class="fas fa-plus-circle me-2"></i>Create Menu
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-store-alt-slash fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No active food services available at the moment.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        
        <!-- View Meals Modal -->
        @foreach($foodServices as $service)
        <div class="modal fade" 
             id="viewMealsModal_{{ $service->id }}" 
             tabindex="-1" 
             aria-labelledby="viewMealsModalLabel_{{ $service->id }}" 
             aria-hidden="true"
             data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewMealsModalLabel_{{ $service->id }}">
                            Meals for {{ $service->name }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Dietary Info</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($service->meals as $meal)
                                        <tr>
                                            <td>{{ $meal->id }}</td>
                                            <td>
                                                <div class="fw-bold">{{ $meal->name }}</div>
                                                <small class="text-muted">{{ Str::limit($meal->description, 50) }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $meal->meal_type === 'hot' ? 'danger' : 'info' }}">
                                                    {{ ucfirst($meal->meal_type) }}
                                                </span>
                                            </td>
                                            <td>
                                                @foreach($meal->dietary_flags as $flag)
                                                    <span class="badge bg-secondary me-1">
                                                        {{ ucfirst($flag) }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @if($meal->is_available)
                                                    <span class="badge bg-success">Available</span>
                                                @else
                                                    <span class="badge bg-danger">Unavailable</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No meals available for this service.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Include Modals -->
@include('dashboard.caregiver.modals.update-member')
@include('dashboard.caregiver.modals.assign-mealplan')
@include('dashboard.caregiver.modals.create-menu')
@include('dashboard.caregiver.modals.view-menu-details')
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const createMenuModal = document.getElementById('createMenuModal');
        createMenuModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const serviceId = button.getAttribute('data-service-id');
            const serviceName = button.getAttribute('data-service-name');
            
            document.getElementById('foodServiceId').value = serviceId;
            document.getElementById('selectedServiceName').textContent = serviceName;
        });

        assignMealPlanModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const memberId = button.getAttribute('data-member-id');
        const memberName = button.getAttribute('data-member-name');
        const dietaryRequirement = button.getAttribute('data-dietary-requirement');
        
        // Update modal content
        document.getElementById('memberId').value = memberId;
        document.getElementById('memberName').textContent = memberName;
        document.getElementById('memberDietary').textContent = ucfirst(dietaryRequirement);
    });

    function ucfirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }   


</script>
@endpush


