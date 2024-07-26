@extends('dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">{{ $school->name }}</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <p class="text-gray-700 mb-4"><strong>District:</strong> {{ $school->address }}</p>
        <p class="text-gray-700 mb-4"><strong>Reg Number:</strong> {{ $school->school_registration_number }}</p>
        <p class="text-gray-700 mb-4"><strong>Rep Email:</strong> {{ $school->representative_email }}</p>
        <p class="text-gray-700 mb-4"><strong>Rep Name:</strong> {{ $school->representative_name }}</p>
        <p class="text-gray-700 mb-4"><strong>Confirmed Participants:</strong> {{ $participantsCount }}</p>
        <a href="{{ route('schools.index') }}" class="btn btn-secondary bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-md">Back to Schools</a>

        <!-- Manual Send Email Button -->
        <form action="{{ route('schools.send-email', $school->id) }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">Send Email</button>
        </form>
    </div>
@endsection
