@extends('dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Add New Participant</h1>

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('participants.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="form-group">
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" name="username" id="username" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        <div class="form-group">
            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        <div class="form-group">
            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        <div class="form-group">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="text" name="email" id="email" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        <div class="form-group">
            <label for="date_of_birth" class="block text-sm font-medium text-gray-700">D.O.B</label>
            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        <div class="form-group">
            <label for="school_registration_number" class="block text-sm font-medium text-gray-700">Reg No</label>
            <input type="text" name="school_registration_number" id="school_registration_number" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        <div class="form-group">
            <label for="image_file" class="block text-sm font-medium text-gray-700">Image</label>
            <input type="text" name="image_file" id="image_file" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        <button type="submit" class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">Add Participant</button>
    </form>
@endsection
