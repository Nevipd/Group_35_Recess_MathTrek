@extends('dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Edit School</h1>

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('schools.update', $school->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" id="name" value="{{ $school->name }}" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        <div class="form-group">
            <label for="address" class="block text-sm font-medium text-gray-700">District</label>
            <input type="text" name="address" id="address" value="{{ $school->address }}" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        <div class="form-group">
            <label for="school_registration_number" class="block text-sm font-medium text-gray-700">Reg Number</label>
            <input type="text" name="school_registration_number" id="school_registration_number" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        <div class="form-group">
            <label for="representative_email" class="block text-sm font-medium text-gray-700">Rep Email</label>
            <input type="email" name="representative_email" id="representative_email" value="{{ $school->representative_email }}" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        <div class="form-group">
            <label for="representative_name" class="block text-sm font-medium text-gray-700">Rep Name</label>
            <input type="text" name="representative_name" id="representative_name" value="{{ $school->representative_name }}" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        <button type="submit" class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">Update School</button>
    </form>
@endsection
