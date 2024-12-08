<div class="card">
    <div class="card-header">
        <h3>Members Management</h3>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col">
                <a href="{{ route('admin.members.create') }}" class="btn btn-primary">Add New Member</a>
                <a href="{{ route('admin.members.export') }}" class="btn btn-secondary">Export Members</a>
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
                        <th>Address</th>
                        <th>Dietary Requirements</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                    <tr>
                        <td>{{ $member->id }}</td>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->user->email }}</td>
                        <td>{{ $member->phone ?? 'N/A' }}</td>
                        <td>{{ $member->address ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $member->dietary_requirement ? 'bg-info' : 'bg-secondary' }}">
                                {{ $member->dietary_requirement ?? 'None' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.members.destroy', $member) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $members->links() }}
        </div>
    </div>
</div> 