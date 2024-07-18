@extends('dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">{{ $question->title }}</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <p class="text-gray-700 mb-4">{{ $question->content }}</p>
        <a href="{{ route('questions.index') }}" class="btn btn-secondary bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-md">Back to Questions</a>
    </div>
@endsection
