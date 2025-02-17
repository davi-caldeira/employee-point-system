@extends('layouts.app')

@section('content')
<div class="container">
    <h1>View Point Records</h1>

    <form method="GET" action="{{ route('admin.points.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date"
                       value="{{ request('start_date') }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date"
                       value="{{ request('end_date') }}" class="form-control">
            </div>
            <div class="col-md-4 align-self-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Point ID</th>
                <th>Employee Name</th>
                <th>Position</th>
                <th>Age</th>
                <th>Manager Name</th>
                <th>Registered At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($points as $point)
            <tr>
                <td>{{ $point->id }}</td>
                <td>{{ $point->user->name }}</td>
                <td>{{ $point->user->position ?? 'N/A' }}</td>
                <td>
                    @if($point->user->birth_date)
                        {{ \Carbon\Carbon::parse($point->user->birth_date)->age }}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @if($point->user->creator)
                        {{ $point->user->creator->name }}
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $point->registered_at }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No point records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $points->links() }}
</div>
@endsection
