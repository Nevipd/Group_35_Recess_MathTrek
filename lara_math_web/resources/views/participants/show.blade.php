@extends('dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Participant Details</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <p class="text-gray-700 mb-4"><strong>Username:</strong> {{ $participant->username }}</p>
        <p class="text-gray-700 mb-4"><strong>First Name:</strong> {{ $participant->first_name }}</p>
        <p class="text-gray-700 mb-4"><strong>Last Name:</strong> {{ $participant->last_name }}</p>
        <p class="text-gray-700 mb-4"><strong>Email:</strong> {{ $participant->email }}</p>
        <p class="text-gray-700 mb-4"><strong>D.O.B:</strong> {{ $participant->date_of_birth }}</p>
        <p class="text-gray-700 mb-4"><strong>Reg No:</strong> {{ $participant->school_registration_number }}</p>
        <p class="text-gray-700 mb-4"><strong>Image:</strong> {{ $participant->image_file }}</p>
        <a href="{{ route('participants.index') }}" class="btn btn-secondary bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-md">Back to Participants</a>
    </div>
@endsection
