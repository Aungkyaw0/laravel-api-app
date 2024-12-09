@extends('layouts.app')

@section('title', 'Admin Dashboard - Meals on Wheels')

@section('styles')
<style>
    .dashboard-container {
        display: flex;
        min-height: 100vh;
        background: #f8f9fa;
    }

    .sidebar {
        width: 250px;
        background: #2c3e50;
        color: white;
        padding: 20px;
    }

    .main-content {
        flex: 1;
        padding: 20px;
    }

    .nav-item {
        padding: 10px 15px;
        border-radius: 8px;
        margin-bottom: 5px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .nav-item:hover, .nav-item.active {
        background: rgba(255, 255, 255, 0.1);
    }

    .nav-item i {
        margin-right: 10px;
    }

    .stats-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }

    .chart-container {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        height: 300px;
    }

    .progress-circle {
        position: relative;
        width: 120px;
        height: 120px;
    }

    .content-section {
        display: none; /* Hide all content sections by default */
    }
    
    .content-section.active {
        display: block; /* Show only active section */
    }

    /* Modern Card Styling */
    .management-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        border: none;
        overflow: hidden;
        margin-bottom: 30px;
    }

    .management-card .card-header {
        background: linear-gradient(45deg, #2c3e50, #3498db);
        color: white;
        padding: 20px;
        border: none;
    }

    .management-card .card-header h3 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
    }

    /* Button Styling */
    .action-buttons {
        background: #f8f9fa;
        padding: 15px 20px;
        border-bottom: 1px solid #edf2f7;
    }

    .action-buttons .btn {
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: #3498db;
        border: none;
    }

    .btn-primary:hover {
        background: #2980b9;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: #95a5a6;
        border: none;
    }

    /* Table Styling */
    .table-container {
        padding: 20px;
    }

    .table {
        border-collapse: separate;
        border-spacing: 0 8px;
        margin-top: -8px;
    }

    .table thead th {
        border: none;
        background: #f8f9fa;
        padding: 15px;
        font-weight: 600;
        color: #2c3e50;
    }

    .table tbody tr {
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .table tbody td {
        padding: 15px;
        vertical-align: middle;
        background: white;
        border: none;
    }

    .table tbody tr td:first-child {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    .table tbody tr td:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    /* Badge Styling */
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.85rem;
    }

    /* Action Buttons */
    .action-btn {
        padding: 6px 12px;
        border-radius: 6px;
        margin: 0 3px;
        transition: all 0.3s ease;
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }

    .action-btn.edit {
        background: #3498db;
        color: white;
        border: none;
    }

    .action-btn.delete {
        background: #e74c3c;
        color: white;
        border: none;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #95a5a6;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 15px;
    }

    .action-btn.approve:hover {
        background: #27ae60 !important;
    }

    .action-btn.reject:hover {
        background: #c0392b !important;
    }

    .text-wrap {
        white-space: normal;
        word-wrap: break-word;
    }

    .text-wrap small {
        display: block;
        margin-top: 4px;
        font-size: 0.75rem;
    }

    /* Status color variations */
    .status-badge.bg-warning {
        background-color: #f1c40f !important;
        color: #000 !important;
    }

    .status-badge.bg-success {
        background-color: #2ecc71 !important;
    }

    .status-badge.bg-danger {
        background-color: #e74c3c !important;
    }

    .status-badge.bg-info {
        background-color: #3498db !important;
    }

    .action-btn.view:hover {
        background: #2980b9 !important;
    }

    .menu-items-tooltip {
        max-width: 300px;
        white-space: normal;
        word-wrap: break-word;
    }

    .avatar-sm {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(52, 152, 219, 0.1);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .status-badge i {
        font-size: 0.8rem;
    }

    .gap-2 {
        gap: 0.5rem;
    }
    
    .status-badge i {
        font-size: 0.8rem;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .action-btn.approve:hover {
        background: #27ae60 !important;
        transform: translateY(-2px);
    }

    .modal-content {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .modal-header {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        padding: 1rem 1.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        padding: 1rem 1.5rem;
    }

    .form-label {
        font-weight: 500;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        padding: 0.6rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }
</style>
@endsection

@section('content')
<div class="dashboard-container" style="margin-top: 100px">
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="mb-4">MOW Admin</h4>
        {{-- <div class="nav-item"data-content="dashboard">
            <i class="fas fa-home"></i> Dashboard
        </div> --}}
        <div class="nav-item" data-content="members">
            <i class="fas fa-users"></i> Members
        </div>
        <div class="nav-item" data-content="caregivers">
            <i class="fas fa-user-nurse"></i> Caregivers
        </div>
        <div class="nav-item" data-content="partners">
            <i class="fas fa-handshake"></i> Partners
        </div>
        <div class="nav-item" data-content="volunteers">
            <i class="fas fa-hands-helping"></i> Volunteers
        </div>
        <div class="nav-item" data-content="meals">
            <i class="fas fa-calendar-alt"></i> Meal Plans
        </div>
        <div class="nav-item" data-content="deliveries">
            <i class="fas fa-truck"></i> Orders & Deliveries
        </div>
        <div class="nav-item" data-content="dietary-requests">
            <i class="fas fa-utensils"></i> Dietary Requests
        </div>
        <div class="nav-item" data-content="food-services">
            <i class="fas fa-utensils"></i> Food Services
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        {{-- <!-- Dashboard Section -->
        <div id="dashboard-content" class="content-section active">
            <!-- Your existing dashboard content -->
            <div class="row">
                <!-- Stats Cards -->
                <div class="col-md-3">
                    <div class="stats-card">
                        <h5>Total Users</h5>
                        <h2>{{ $totalUsers }}</h2>
                        <div class="progress mt-2" style="height: 5px;">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <h5>Active Partners</h5>
                        <h2></h2>
                        <div class="progress mt-2" style="height: 5px;">
                            <div class="progress-bar bg-success" style="width: 60%"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <h5>Active Caregivers</h5>
                        <h2></h2>
                        <div class="progress mt-2" style="height: 5px;">
                            <div class="progress-bar bg-info" style="width: 45%"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <h5>Registered Members</h5>
                        <h2></h2>
                        <div class="progress mt-2" style="height: 5px;">
                            <div class="progress-bar bg-warning" style="width: 80%"></div>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="col-md-8">
                    <div class="chart-container">
                        <canvas id="usersChart"></canvas>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="chart-container">
                        <canvas id="deliveriesChart"></canvas>
                    </div>
                </div>
            </div>
       </div> --}}

        <!-- MembersSection -->
        <div id="members-content" class="content-section active">
            <div class="management-card">
                <div class="card-header">
                    <h3><i class="fas fa-users me-2"></i>Members Management</h3>
                </div>
                
                <div class="action-buttons">
                    

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
                </div>

                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Dietary Requirement</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($member as $m)
                                    <tr>
                                        <td>#{{ $m->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <i class="fas fa-user-circle fa-2x text-primary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $m->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $m->phone }}</td>
                                        <td>{{ $m->address }}</td>
                                        <td>
                                            <span class="status-badge bg-info text-white">
                                                {{ $m->dietary_requirement }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="action-btn edit" 
                                                    onclick="openUpdateMemberModal({{ $m->id }}, '{{ $m->name }}', '{{ $m->phone }}', '{{ $m->address }}', '{{ $m->dietary_requirement }}')"
                                                    title="Edit Member">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="action-btn delete" 
                                                    onclick="openDeleteMemberModal({{ $m->id }}, '{{ $m->name }}')"
                                                    title="Delete Member">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="empty-state">
                                                <i class="fas fa-users"></i>
                                                <h5>No Members Found</h5>
                                                <p>Start by adding your first member</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Caregivers Section -->
        <div id="caregivers-content" class="content-section">
            <div class="management-card">
                <div class="card-header">
                    <h3><i class="fas fa-user-nurse me-2"></i>Caregivers Management</h3>
                </div>
                
                <div class="action-buttons">
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
                </div>

                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Phone</th>
                                    <th>Location</th>
                                    <th>Experience</th>
                                    <th>Availability</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($caregiver as $c)
                                    <tr>
                                        <td>#{{ $c->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <i class="fas fa-user-md fa-2x text-info"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $c->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $c->age }}</td>
                                        <td>{{ $c->phone }}</td>
                                        <td>{{ $c->location }}</td>
                                        <td>{{ $c->experience }}</td>
                                        <td>
                                            <span class="status-badge bg-success text-white">
                                                {{ $c->availability }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="action-btn edit" 
                                                    onclick="openUpdateCaregiverModal({{ $c->id }}, '{{ $c->name }}', {{ $c->age }}, '{{ $c->phone }}', '{{ $c->location }}', {{ $c->experience }}, '{{ $c->availability }}')"
                                                    title="Edit Caregiver">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="action-btn delete" 
                                                    onclick="openDeleteCaregiverModal({{ $c->id }}, '{{ $c->name }}')"
                                                    title="Delete Caregiver">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">
                                            <div class="empty-state">
                                                <i class="fas fa-user-nurse"></i>
                                                <h5>No Caregivers Found</h5>
                                                <p>Start by adding your first caregiver</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Partners Section -->
        <div id="partners-content" class="content-section">
            <div class="management-card">
                <div class="card-header">
                    <h3><i class="fas fa-handshake me-2"></i>Partners Management</h3>
                </div>
                
                <div class="action-buttons">
                    
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
                </div>

                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Company Email</th>
                                    <th>Company</th>
                                    <th>Contact</th>
                                    <th>Location</th>
                                    <th>Business Type</th>
                                    <th>Service Offer</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($partner as $p)
                                    <tr>
                                        <td>#{{ $p->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <i class="fas fa-building fa-2x text-warning"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $p->name }}</h6>
                                                    <small class="text-muted">{{ $p->company_email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $p->company_name }}</td>
                                        <td>{{ $p->phone }}</td>
                                        <td>{{ $p->location }}</td>
                                        <td>
                                            <span class="status-badge bg-primary text-white">
                                                {{ $p->business_type }}
                                            </span>
                                        </td>
                                        <td>{{ $p->service_offer }}</td>
                                        <td>
                                            <button class="action-btn edit" 
                                                    onclick="openUpdatePartnerModal(
                                                        {{ $p->id }}, 
                                                        '{{ $p->company_name }}', 
                                                        '{{ $p->business_type }}', 
                                                        '{{ $p->contact_person }}', 
                                                        '{{ $p->contact_number }}', 
                                                        '{{ $p->address }}', 
                                                        '{{ $p->email }}', 
                                                        '{{ $p->service_area }}'
                                                    )"
                                                    title="Edit Partner">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="action-btn delete" 
                                                    onclick="openDeletePartnerModal({{ $p->id }}, '{{ $p->company_name }}')"
                                                    title="Delete Partner">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">
                                            <div class="empty-state">
                                                <i class="fas fa-handshake"></i>
                                                <h5>No Partners Found</h5>
                                                <p>Start by adding your first partner</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Volunteers Section -->
        <div id="volunteers-content" class="content-section">
            <div class="management-card">
                <div class="card-header">
                    <h3><i class="fas fa-hands-helping me-2"></i>Volunteers Management</h3>
                </div>
                
                <div class="action-buttons">
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
                </div>

                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Contact No</th>
                                    <th>Emergency Contact</th>
                                    <th>Vehicle Info</th>
                                    <th>License</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($volunteer as $v)
                                    <tr>
                                        <td>#{{ $v->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <i class="fas fa-user-friends fa-2x text-success"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $v->name }}</h6>
                                                    <small class="text-muted">{{ $v->address }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $v->phone }}</td>
                                        <td>
                                            <div>
                                                {{ $v->emergency_contact }}
                                                <small class="d-block text-muted">{{ $v->emergency_phone }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if($v->has_vehicle)
                                                <span class="status-badge bg-success text-white">
                                                    {{ $v->vehicle_type }}
                                                </span>
                                            @else
                                                <span class="status-badge bg-secondary text-white">
                                                    No Vehicle
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $v->license_number }}</td>
                                        <td>
                                            <span class="status-badge bg-{{ $v->status === 'active' ? 'success' : 'warning' }} text-white">
                                                {{ ucfirst($v->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="action-btn edit" 
                                                    onclick="openUpdateVolunteerModal(
                                                        {{ $v->id }}, 
                                                        '{{ $v->name }}', 
                                                        '{{ $v->phone }}', 
                                                        '{{ $v->address }}', 
                                                        '{{ $v->emergency_contact }}', 
                                                        '{{ $v->emergency_number }}', 
                                                        '{{ $v->vehicle_type }}', 
                                                        '{{ $v->license_number }}', 
                                                        '{{ $v->status }}'
                                                    )"
                                                    title="Edit Volunteer">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="action-btn delete" 
                                                    onclick="openDeleteVolunteerModal({{ $v->id }}, '{{ $v->name }}')"
                                                    title="Delete Volunteer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">
                                            <div class="empty-state">
                                                <i class="fas fa-hands-helping"></i>
                                                <h5>No Volunteers Found</h5>
                                                <p>Start by adding your first volunteer</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dietary Requests Section -->
        <div id="dietary-requests-content" class="content-section">
            <div class="management-card">
                <div class="card-header">
                    <h3><i class="fas fa-utensils me-2"></i>Dietary Requests Management</h3>
                </div>
                
                <div class="action-buttons">
                    {{-- <button class="btn btn-primary me-2">
                        <i class="fas fa-plus me-2"></i>Add New Request
                    </button>
                    <button class="btn btn-secondary">
                        <i class="fas fa-download me-2"></i>Export Requests
                    </button> --}}
                </div>

                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Member</th>
                                    <th>Current Diet</th>
                                    <th>Requested Diet</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dietaryRequest as $request)
                                    <tr>
                                        <td>#{{ $request->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <i class="fas fa-user fa-2x text-primary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $request->member->name ?? 'N/A' }}</h6>
                                                    <small class="text-muted">
                                                        Caregiver: {{ $request->caregiver->name ?? 'Unassigned' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="status-badge bg-info text-white">
                                                    {{ $request->current_dietary_requirement }}
                                                </span>
                                                <small class="d-block text-muted mt-1">
                                                    Prefers: {{ $request->current_prefer_meal }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="status-badge bg-primary text-white">
                                                    {{ $request->requested_dietary_requirement }}
                                                </span>
                                                <small class="d-block text-muted mt-1">
                                                    Prefers: {{ $request->requested_prefer_meal }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-wrap" style="max-width: 200px;">
                                                <p class="mb-1">{{ $request->reason }}</p>
                                                @if($request->additional_notes)
                                                    <small class="text-muted">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        {{ $request->additional_notes }}
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $statusColor = [
                                                    'pending' => 'warning',
                                                    'approved' => 'success',
                                                    'rejected' => 'danger',
                                                    'processing' => 'info'
                                                ][$request->status] ?? 'secondary';
                                            @endphp
                                            <span class="status-badge bg-{{ $statusColor }} text-white">
                                                {{ ucfirst($request->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="empty-state">
                                                <i class="fas fa-utensils"></i>
                                                <h5>No Dietary Requests Found</h5>
                                                <p>There are no pending dietary change requests</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Meal Plans Section -->
        <div id="meals-content" class="content-section">
            <div class="management-card">
                <div class="card-header">
                    <h3><i class="fas fa-calendar-alt me-2"></i>Meal Plans Management</h3>
                </div>
                
                <div class="action-buttons">
                    {{-- <button class="btn btn-primary me-2">
                        <i class="fas fa-plus me-2"></i>Add New Meal Plan
                    </button>
                    <button class="btn btn-secondary">
                        <i class="fas fa-download me-2"></i>Export Meal Plans
                    </button> --}}
                </div>

                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Member</th>
                                    <th>Menu Details</th>
                                    <th>Assignment</th>
                                    <th>Delivery Info</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mealPlan as $plan)
                                    <tr>
                                        <td>#{{ $plan->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <i class="fas fa-user fa-2x text-primary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $plan->member->name ?? 'N/A' }}</h6>
                                                    <small class="text-muted">
                                                        Dietary: {{ $plan->dietary_category }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <h6 class="mb-1">{{ $plan->menu->name ?? 'N/A' }}</h6>
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-utensils me-1"></i>
                                                    {{ $plan->menu->meal_type ?? 'N/A' }}
                                                </small>
                                                @if($plan->menu && $plan->menu->menu_items)
                                                    <button class="btn btn-sm btn-light mt-1" 
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-placement="top" 
                                                            title="{{ implode(', ', array_column($plan->menu->menu_items, 'name')) }}">
                                                        <i class="fas fa-eye me-1"></i>View Items
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mb-2">
                                                <span class="status-badge bg-info text-white">
                                                    <i class="fas fa-user-nurse me-1"></i>
                                                    {{ $plan->caregiver->name ?? 'Unassigned' }}
                                                </span>
                                            </div>
                                            <div>
                                                <span class="status-badge bg-warning text-dark">
                                                    <i class="fas fa-building me-1"></i>
                                                    {{ $plan->partner->company_name ?? 'Unassigned' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <p class="mb-1">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $plan->meal_date->format('M d, Y') }}
                                                </p>
                                                <span class="status-badge bg-primary text-white">
                                                    {{ $plan->deliver_meal_type }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $statusColor = [
                                                    'scheduled' => 'info',
                                                    'preparing' => 'warning',
                                                    'ready' => 'primary',
                                                    'delivered' => 'success',
                                                    'cancelled' => 'danger'
                                                ][$plan->status] ?? 'secondary';
                                            @endphp
                                            <span class="status-badge bg-{{ $statusColor }} text-white">
                                                {{ ucfirst($plan->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="empty-state">
                                                <i class="fas fa-calendar-alt"></i>
                                                <h5>No Meal Plans Found</h5>
                                                <p>Start by creating a new meal plan</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Section -->
        <div id="deliveries-content" class="content-section">
            <div class="management-card">
                <div class="card-header">
                    <h3><i class="fas fa-truck me-2"></i>Orders Management</h3>
                </div>
                
                <div class="action-buttons">
                    {{-- <button class="btn btn-primary me-2">
                        <i class="fas fa-plus me-2"></i>Add New Order
                    </button>
                    <button class="btn btn-secondary">
                        <i class="fas fa-download me-2"></i>Export Orders
                    </button> --}}
                </div>

                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Member</th>
                                    <th>Menu & Delivery</th>
                                    <th>Assigned Team</th>
                                    <th>Delivery Details</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($order as $o)
                                    <tr>
                                        <td>#{{ $o->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <i class="fas fa-user fa-2x text-primary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $o->member->name ?? 'N/A' }}</h6>
                                                    <small class="text-muted">
                                                        {{ $o->delivery_meal_type }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <h6 class="mb-1">{{ $o->mealPlan->menu->name ?? 'N/A' }}</h6>
                                                @if($o->mealPlan && $o->mealPlan->menu && $o->mealPlan->menu->menu_items)
                                                    <button class="btn btn-sm btn-light mt-1" 
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-placement="top" 
                                                            title="{{ implode(', ', array_column($o->mealPlan->menu->menu_items, 'name')) }}">
                                                        <i class="fas fa-utensils me-1"></i>View Menu
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mb-2">
                                                <span class="status-badge bg-info text-white">
                                                    <i class="fas fa-user-nurse me-1"></i>
                                                    {{ $o->caregiver->name ?? 'Unassigned' }}
                                                </span>
                                            </div>
                                            <div class="mb-2">
                                                <span class="status-badge bg-warning text-dark">
                                                    <i class="fas fa-building me-1"></i>
                                                    {{ $o->partner->company_name ?? 'Unassigned' }}
                                                </span>
                                            </div>
                                            <div>
                                                <span class="status-badge bg-success text-white">
                                                    <i class="fas fa-motorcycle me-1"></i>
                                                    {{ $o->volunteer->name ?? 'Unassigned' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <p class="mb-1">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    Start: {{ \Carbon\Carbon::parse($o->delivery_start_date)->format('M d, Y') }}
                                                </p>
                                                <p class="mb-1">
                                                    <i class="fas fa-calendar-check me-1"></i>
                                                    End: {{ \Carbon\Carbon::parse($o->delivery_end_date)->format('M d, Y') }}
                                                </p>
                                                @if($o->delivery_confirmation_code)
                                                    <span class="status-badge bg-primary text-white">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        Code: {{ $o->delivery_confirmation_code }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-2">
                                                <span class="status-badge bg-{{ $o->partner_status === 'completed' ? 'success' : 'warning' }} text-white">
                                                    <i class="fas fa-store me-1"></i>
                                                    Partner: {{ ucfirst($o->partner_status) }}
                                                </span>
                                                <span class="status-badge bg-{{ $o->delivery_status === 'delivered' ? 'success' : 'info' }} text-white">
                                                    <i class="fas fa-truck me-1"></i>
                                                    Delivery: {{ ucfirst($o->delivery_status) }}
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="empty-state">
                                                <i class="fas fa-truck"></i>
                                                <h5>No Orders Found</h5>
                                                <p>No delivery orders have been created yet</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Member Modal -->
        <div class="modal fade" id="updateMemberModal" tabindex="-1" aria-labelledby="updateMemberModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="updateMemberModalLabel">
                            <i class="fas fa-user-edit me-2"></i>Update Member
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="updateMemberForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" id="update_member_id" name="member_id">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" id="update_name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Phone</label>
                                        <input type="tel" class="form-control" id="update_phone" name="phone" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control" id="update_address" name="address" rows="2" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Dietary Requirement</label>
                                        <select class="form-select" id="update_dietary_requirement" name="dietary_requirement" required>
                                            <option value="None">None</option>
                                            <option value="Vegetarian">Vegetarian</option>
                                            <option value="Vegan">Vegan</option>
                                            <option value="Gluten-Free">Gluten-Free</option>
                                            <option value="Dairy-Free">Dairy-Free</option>
                                            <option value="Halal">Halal</option>
                                            <option value="Kosher">Kosher</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Member
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Update Caregiver Modal -->
        <div class="modal fade" id="updateCaregiverModal" tabindex="-1" aria-labelledby="updateCaregiverModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title" id="updateCaregiverModalLabel">
                            <i class="fas fa-user-nurse me-2"></i>Update Caregiver
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="updateCaregiverForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" id="update_caregiver_id" name="caregiver_id">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" id="update_caregiver_name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Age</label>
                                        <input type="number" class="form-control" id="update_age" name="age" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Phone</label>
                                        <input type="tel" class="form-control" id="update_caregiver_phone" name="phone" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Location</label>
                                        <input type="text" class="form-control" id="update_location" name="location" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Experience (Years)</label>
                                        <input type="number" class="form-control" id="update_experience" name="experience" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Availability</label>
                                        <select class="form-select" id="update_availability" name="availability" required>
                                            <option value="Full-time">Full-time</option>
                                            <option value="Part-time">Part-time</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-info text-white">
                                <i class="fas fa-save me-2"></i>Update Caregiver
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Update Partner Modal --}}
        <div class="modal fade" id="updatePartnerModal" tabindex="-1" aria-labelledby="updatePartnerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="updatePartnerModalLabel">
                            <i class="fas fa-building me-2"></i>Update Partner
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="updatePartnerForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" id="update_partner_id" name="partner_id">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Company Name</label>
                                        <input type="text" class="form-control" id="update_company_name" name="company_name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Business Type</label>
                                        <select class="form-select" id="update_business_type" name="business_type">
                                            <option value="Restaurant">Restaurant</option>
                                            <option value="Catering">Catering Service</option>
                                            <option value="Food Supplier">Food Supplier</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Contact Person</label>
                                        <input type="text" class="form-control" id="update_contact_person" name="contact_person">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Contact Number</label>
                                        <input type="tel" class="form-control" id="update_contact_number" name="contact_number">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control" id="update_address" name="address" rows="2" ></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" id="update_email" name="email" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Service Area</label>
                                        <input type="text" class="form-control" id="update_service_area" name="service_area" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Update Partner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Update Volunteer Modal --}}
        <div class="modal fade" id="updateVolunteerModal" tabindex="-1" aria-labelledby="updateVolunteerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="updateVolunteerModalLabel">
                            <i class="fas fa-motorcycle me-2"></i>Update Volunteer
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="updateVolunteerForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" id="update_volunteer_id" name="volunteer_id">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" id="update_volunteer_name" name="name" value="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Phone</label>
                                        <input type="tel" class="form-control" id="update_volunteer_phone" name="phone" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control" id="update_volunteer_address" name="address" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label"> Emergency Contact</label>
                                        <input type="text" class="form-control" id="update_volunteer_emergency_contact" name="emergency_contact" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label"> Emergency Number</label>
                                        <input type="tel" class="form-control" id="update_volunteer_emergency_number" name="emergency_number" required>
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Vehicle Type</label>
                                        <select class="form-select" id="update_vehicle_type" name="vehicle_type" required>
                                            <option value="Motorcycle">Motorcycle</option>
                                            <option value="Car">Car</option>
                                            <option value="Bicycle">Bicycle</option>
                                            <option value="Van">Van</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">License Number</label>
                                        <input type="text" class="form-control" id="update_volunteer_license_number" name="license_number" required>
                                    </div>
                                </div>
                                
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Status</label>
                                        <select class="form-select" id="update_volunteer_status" name="status" required>
                                            <option value="active">Available</option>
                                            <option value="inactive">Unavailable</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Update Volunteer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Delete Member Modal --}}
        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteMemberModal" tabindex="-1" aria-labelledby="deleteMemberModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white border-0">
                        <h5 class="modal-title" id="deleteMemberModalLabel">
                            <i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="deleteMemberForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body text-center py-4">
                            <input type="hidden" id="delete_member_id" name="member_id">
                            <input type="hidden" name="confirm" value="1">
                            
                            <div class="mb-3">
                                <i class="fas fa-user-times fa-3x text-danger mb-3"></i>
                                <h5 class="mb-2">Delete Member Account</h5>
                                <p class="mb-0">Are you sure you want to delete <span id="member_name_display" class="fw-bold"></span>?</p>
                                <p class="text-muted small"> All data related to this member will be deleted. This action cannot be undone.</p>
                            </div>
                        </div>
                        <div class="modal-footer bg-light border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>Delete Member
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Delete Caregiver Modal --}}
        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteCaregiverModal" tabindex="-1" aria-labelledby="deleteCaregiverModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white border-0">
                        <h5 class="modal-title" id="deleteCaregiverModalLabel">
                            <i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="deleteCaregiverForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body text-center py-4">
                            <input type="hidden" id="delete_caregiver_id" name="caregiver_id">
                            <input type="hidden" name="confirm" value="1">
                            
                            <div class="mb-3">
                                <i class="fas fa-user-nurse fa-3x text-danger mb-3"></i>
                                <h5 class="mb-2">Delete Caregiver Account</h5>
                                <p class="mb-0">Are you sure you want to delete <span id="caregiver_name_display" class="fw-bold"></span>?</p>
                                <p class="text-muted small">All data related to this caregiver will be deleted. This action cannot be undone.</p>
                            </div>
                        </div>
                        <div class="modal-footer bg-light border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>Delete Caregiver
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Delete Partner Modal --}}
        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deletePartnerModal" tabindex="-1" aria-labelledby="deletePartnerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white border-0">
                        <h5 class="modal-title" id="deletePartnerModalLabel">
                            <i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="deletePartnerForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body text-center py-4">
                            <input type="hidden" id="delete_partner_id" name="partner_id">
                            <input type="hidden" name="confirm" value="1">
                            
                            <div class="mb-3">
                                <i class="fas fa-building fa-3x text-danger mb-3"></i>
                                <h5 class="mb-2">Delete Partner Account</h5>
                                <p class="mb-0">Are you sure you want to delete <span id="partner_name_display" class="fw-bold"></span>?</p>
                                <p class="text-muted small">All services and meal plans associated with this partner will be deleted. This action cannot be undone.</p>
                            </div>
                        </div>
                        <div class="modal-footer bg-light border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>Delete Partner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Delete Volunteer Modal --}}
        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteVolunteerModal" tabindex="-1" aria-labelledby="deleteVolunteerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white border-0">
                        <h5 class="modal-title" id="deleteVolunteerModalLabel">
                            <i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="deleteVolunteerForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body text-center py-4">
                            <input type="hidden" id="delete_volunteer_id" name="volunteer_id">
                            <input type="hidden" name="confirm" value="1">
                            
                            <div class="mb-3">
                                <i class="fas fa-motorcycle fa-3x text-danger mb-3"></i>
                                <h5 class="mb-2">Delete Volunteer Account</h5>
                                <p class="mb-0">Are you sure you want to delete <span id="volunteer_name_display" class="fw-bold"></span>?</p>
                                <p class="text-muted small">All delivery assignments associated with this volunteer will be unassigned. This action cannot be undone.</p>
                            </div>
                        </div>
                        <div class="modal-footer bg-light border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>Delete Volunteer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add the new content section -->
        {{-- Food Service --}}
        <div id="food-services-content" class="content-section">
            <div class="management-card">
                <div class="card-header">
                    <h3><i class="fas fa-utensils me-2"></i>Food Services Management</h3>
                </div>
                
                <div class="action-buttons">
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
                </div>

                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Service Name</th>
                                    <th>Partner</th>
                                    <th>Cuisine Type</th>
                                    <th>Service Area</th>
                                    <th>Operating Hours</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($foodService as $service)
                                    <tr>
                                        <td>#{{ $service->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <i class="fas fa-store fa-2x text-primary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $service->service_name }}</h6>
                                                    <small class="text-muted">{{ $service->description }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $service->partner->company_name }}</td>
                                        <td>{{ $service->cuisine_type }}</td>
                                        <td>{{ $service->service_area }}</td>
                                        <td>{{ $service->operating_hours[0] }}</td>                                          
                                        
                                        <td>
                                            <span class="status-badge bg-{{ $service->status === 'active' ? 'success' : 'warning' }} text-white">
                                                {{ ucfirst($service->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($service->status !== 'active')
                                                <button class="action-btn approve" 
                                                        onclick="openActivateFoodServiceModal({{ $service->id }}, '{{ $service->service_name }}')"
                                                        title="Activate Service">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">
                                            <div class="empty-state">
                                                <i class="fas fa-utensils"></i>
                                                <h5>No Food Services Found</h5>
                                                <p>No food services have been registered yet</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add the Activate Food Service Modal -->
        <div class="modal fade" id="activateFoodServiceModal" tabindex="-1" aria-labelledby="activateFoodServiceModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white border-0">
                        <h5 class="modal-title" id="activateFoodServiceModalLabel">
                            <i class="fas fa-check-circle me-2"></i>Activate Food Service
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="activateFoodServiceForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body py-4">
                            <input type="hidden" name="confirm" value="1">
                            
                            <div class="text-center mb-4">
                                <i class="fas fa-store-alt fa-3x text-success mb-3"></i>
                                <h5 class="mb-2">Activate Food Service</h5>
                                <p class="mb-0">You are about to activate <span id="service_name_display" class="fw-bold"></span></p>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Safety Rating <span class="text-danger">*</span></label>
                                <div class="rating-input-wrapper d-flex align-items-center gap-2">
                                    <input type="range" class="form-range" id="safety_rating" name="safety_rating" 
                                           min="1" max="5" value="3" 
                                           oninput="document.getElementById('rating_display').textContent = this.value">
                                    <span id="rating_display" class="badge bg-primary">3</span>
                                    <small class="text-muted ms-2">(1-Poor, 5-Excellent)</small>
                                </div>
                            </div>

                            <div class="alert alert-info mt-3">
                                <small>
                                    <i class="fas fa-info-circle me-1"></i>
                                    Please rate the food service based on their safety standards, cleanliness, and food handling practices.
                                </small>
                            </div>
                        </div>
                        <div class="modal-footer bg-light border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-2"></i>Activate Service
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

     

        <!-- Add more content sections for other menu items -->
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        // Function to show selected content
        function showContent(contentId) {
            // Remove active class from all items
            $('.nav-item').removeClass('active');
            $('.nav-item[data-content="' + contentId + '"]').addClass('active');

            // Hide all content sections
            $('.content-section').removeClass('active');

            // Show selected content section
            $('#' + contentId + '-content').addClass('active');

            // Save the selected section to localStorage
            localStorage.setItem('selectedSection', contentId);
        }

        // Handle sidebar navigation clicks
        $('.nav-item').click(function() {
            const contentId = $(this).data('content');
            showContent(contentId);
        });

        // Check if there's a saved section on page load
        const savedSection = localStorage.getItem('selectedSection');
        if (savedSection) {
            showContent(savedSection);
        } else {
            // If no saved section, default to dashboard
            showContent('dashboard');
        }

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });

    function openActivateFoodServiceModal(id, serviceName) {
            // Set form action
            $('#activateFoodServiceForm').attr('action', `/admin/food-services/${id}/activate`);
            
            // Set service name in modal
            $('#service_name_display').text(serviceName);
            
            // Open modal
            $('#activateFoodServiceModal').modal('show');
        }

    function openUpdateMemberModal(id, name, phone, address, dietary_requirement) {
        // Set form action
        $('#updateMemberForm').attr('action', `/admin/members/${id}`);
        
        // Fill form fields
        $('#update_member_id').val(id);
        $('#update_name').val(name);
        $('#update_phone').val(phone);
        $('#update_address').val(address);
        $(`#update_dietary_requirement option[value="${dietary_requirement}"]`).prop('selected', true);
        
        // Open modal
        $('#updateMemberModal').modal('show');
    }

    function openUpdateCaregiverModal(id, name, age, phone, location, experience, availability) {
        // Set form action
        $('#updateCaregiverForm').attr('action', `/admin/caregivers/${id}`);
        
        // Fill form fields
        $('#update_caregiver_id').val(id);
        $('#update_caregiver_name').val(name);
        $('#update_age').val(age);
        $('#update_caregiver_phone').val(phone);
        $('#update_location').val(location);
        $('#update_experience').val(experience);
        $(`#update_availability option[value="${availability}"]`).prop('selected', true);
        
        // Open modal
        $('#updateCaregiverModal').modal('show');
    }

    function openUpdatePartnerModal(id, company_name, business_type, contact_person, contact_number, address, email, service_area) {
        // Set form action
        $('#updatePartnerForm').attr('action', `/admin/partners/${id}`);
        
        // Fill form fields
        $('#update_partner_id').val(id);
        $('#update_company_name').val(company_name);
        $('#update_business_type').val(business_type);
        $('#update_contact_person').val(contact_person);
        $('#update_contact_number').val(contact_number);
        $('#update_address').val(address);
        $('#update_email').val(email);
        $('#update_service_area').val(service_area);
        
        // Open modal
        $('#updatePartnerModal').modal('show');
    }

    function openUpdateVolunteerModal(id, name, phone, address, emergency_contact, emergency_number, vehicle_type, license_number, status) {
        // Set form action
        $('#updateVolunteerForm').attr('action', `/admin/volunteers/${id}`);
        
        // Fill form fields
        $('#update_volunteer_id').val(id);
        $('#update_volunteer_name').val(name);
        $('#update_volunteer_phone').val(phone);
        $('#update_volunteer_address').val(address);
        $('#update_volunteer_emergency_contact').val(emergency_contact);
        $('#update_volunteer_emergency_number').val(emergency_number);
        $('#update_vehicle_type').val(vehicle_type);
        $('#update_volunteer_license_number').val(license_number);
        $('#update_volunteer_status').val(status);
        
        // Open modal
        $('#updateVolunteerModal').modal('show');
    }

    function openDeleteMemberModal(id, name) {
        // Set form action
        $('#deleteMemberForm').attr('action', `/admin/members/${id}`);
        
        // Set hidden input and display name
        $('#delete_member_id').val(id);
        $('#member_name_display').text(name);
        
        // Open modal
        $('#deleteMemberModal').modal('show');
    }

    function openDeleteCaregiverModal(id, name) {
        // Set form action
        $('#deleteCaregiverForm').attr('action', `/admin/caregivers/${id}`);
        
        // Set hidden input and display name
        $('#delete_caregiver_id').val(id);
        $('#caregiver_name_display').text(name);
        
        // Open modal
        $('#deleteCaregiverModal').modal('show');
    }

    function openDeletePartnerModal(id, name) {
        // Set form action
        $('#deletePartnerForm').attr('action', `/admin/partners/${id}`);
        
        // Set hidden input and display name
        $('#delete_partner_id').val(id);
        $('#partner_name_display').text(name);
        
        // Open modal
        $('#deletePartnerModal').modal('show');
    }

    function openDeleteVolunteerModal(id, name) {
        // Set form action
        $('#deleteVolunteerForm').attr('action', `/admin/volunteers/${id}`);
        
        // Set hidden input and display name
        $('#delete_volunteer_id').val(id);
        $('#volunteer_name_display').text(name);
        
        // Open modal
        $('#deleteVolunteerModal').modal('show');
    }
</script>
@endsection 
