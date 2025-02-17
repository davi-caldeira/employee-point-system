@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Employee Dashboard</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form to register a point -->
    <form action="{{ route('employee.registerPoint') }}" method="POST" class="mb-4">
        @csrf
        <button type="submit" class="btn btn-primary">Register Point</button>
    </form>

    <h3>Your Registered Points</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Registered At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($points as $point)
                <tr>
                    <td>{{ $point->id }}</td>
                    <td>{{ $point->registered_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center">No points registered.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
