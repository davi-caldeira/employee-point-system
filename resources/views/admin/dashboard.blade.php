@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="card p-4 shadow-sm">
        <h1 class="text-center mb-4">Admin Dashboard</h1>
        <p class="lead text-center">Welcome, {{ auth()->user()->name }}!</p>
        <hr>
        <div class="row">
            <!-- Manage Employees Card -->
            <div class="col-md-6 mb-3">
                <a href="{{ route('admin.users.index') }}" class="text-decoration-none text-dark">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-2">Manage Employees</h5>
                            <p class="card-text">
                                Create, edit, and remove employees in the system.
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <!-- View Point Records Card -->
            <div class="col-md-6 mb-3">
                <a href="{{ route('admin.points.index') }}" class="text-decoration-none text-dark">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-2">View Point Records</h5>
                            <p class="card-text">
                                See employees point records with filters and detailed info.
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
