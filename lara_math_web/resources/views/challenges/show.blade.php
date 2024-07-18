@extends('dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">{{ $challenge->name }}</h1>
    <div class="bg-white shadow-md rounded-lg p-6">
        <p class="text-gray-700 mb-4"><strong>Description:</strong> {{ $challenge->description }}</p>
        <p class="text-gray-700 mb-4"><strong>Start Date:</strong> {{ $challenge->start_date }}</p>
        <p class="text-gray-700 mb-4"><strong>End Date:</strong> {{ $challenge->end_date }}</p>
        <a href="{{ route('challenges.index') }}" class="btn btn-secondary bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-md">Back to Challenges</a>
    </div>
@endsection
