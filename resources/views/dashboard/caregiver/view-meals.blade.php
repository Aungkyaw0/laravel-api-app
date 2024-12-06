@extends('layouts.app')

@section('title', 'View Meals - ' . $service->service_name)

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Meals for {{ $service->service_name }}</h2>
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
                @forelse($meals as $meal)
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
    <a href="{{ route('caregiver.dashboard') }}" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
@endsection 