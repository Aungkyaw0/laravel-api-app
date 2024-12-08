<div class="card">
    <div class="card-header">
        <h3>Caregivers Management</h3>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col">
                <a href="{{ route('admin.caregivers.create') }}" class="btn btn-primary">Add New Caregiver</a>
                <a href="{{ route('admin.caregivers.export') }}" class="btn btn-secondary">Export Caregivers</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Location</th>
                        <th>Experience</th>
                        <th>Availability</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($caregivers as $caregiver)
                    <tr>
                        <td>{{ $caregiver->id }}</td>
                        <td>{{ $caregiver->name }}</td>
                        <td>{{ $caregiver->user->email }}</td>
                        <td>{{ $caregiver->phone ?? 'N/A' }}</td>
                        <td>{{ $caregiver->location ?? 'N/A' }}</td>
                        <td>{{ $caregiver->experience ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $caregiver->availability ? 'bg-success' : 'bg-warning' }}">
                                {{ $caregiver->availability ? 'Available' : 'Unavailable' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.caregivers.edit', $caregiver) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.caregivers.destroy', $caregiver) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            <a href="{{ route('admin.caregivers.members', $caregiver) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-users"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $caregivers->links() }}
        </div>
    </div>
</div> 