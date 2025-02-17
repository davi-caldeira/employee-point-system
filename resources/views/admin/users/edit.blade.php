@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Employee</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control"
                   value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" name="cpf" id="cpf" class="form-control"
                   value="{{ old('cpf', $user->cpf) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control"
                   value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password (Leave blank to keep current)</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>

        <div class="mb-3">
            <label for="position" class="form-label">Position</label>
            <input type="text" name="position" id="position" class="form-control"
                   value="{{ old('position', $user->position) }}">
        </div>

        <div class="mb-3">
            <label for="birth_date" class="form-label">Birth Date</label>
            <input type="date" name="birth_date" id="birth_date" class="form-control"
                   value="{{ old('birth_date', $user->birth_date) }}">
        </div>

        <div class="mb-3">
            <label for="zip_code" class="form-label">Zip Code (CEP)</label>
            <input type="text" name="zip_code" id="zip_code" class="form-control"
                   value="{{ old('zip_code', $user->zip_code) }}">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" id="address" class="form-control"
                   value="{{ old('address', $user->address) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Employee</button>
    </form>
</div>

<!-- JavaScript for CEP auto-fill -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const zipInput = document.getElementById('zip_code');
    const addressInput = document.getElementById('address');

    zipInput.addEventListener('blur', async () => {
        const cep = zipInput.value.replace(/\D/g, '');
        if (cep.length === 8) {
            try {
                const response = await fetch(`/api/cep/${cep}`);
                const data = await response.json();
                if (!data.error) {
                    addressInput.value = `${data.logradouro}, ${data.bairro}, ${data.localidade} - ${data.uf}`;
                } else {
                    console.error('CEP lookup error:', data.error);
                }
            } catch (error) {
                console.error('Error fetching CEP data:', error);
            }
        }
    });
});
</script>
@endsection
