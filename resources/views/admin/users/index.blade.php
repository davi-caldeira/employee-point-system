@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Employees</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Create New Employee</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>CPF</th>
                <th>Email</th>
                <th>Position</th>
                <th>Birth Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->cpf }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->position ?? 'N/A' }}</td>
                <td>{{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d/m/Y') : 'N/A' }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No employees found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $users->links() }}
</div>
@endsection
