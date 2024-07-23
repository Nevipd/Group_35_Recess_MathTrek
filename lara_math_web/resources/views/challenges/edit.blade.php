@extends('dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Edit Challenge</h1>
    <form action="{{ route('challenges.update', $challenge->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name" class="block text-sm font-medium text-gray-700">Title:</label>
            <input type="text" name="name" id="name" value="{{ $challenge->name }}" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        <div class="form-group">
            <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
            <textarea name="description" id="description" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ $challenge->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date:</label>
            <input type="date" name="start_date" id="start_date" value="{{ $challenge->start_date }}" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm datepicker" required>
        </div>
        <div class="form-group">
            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date:</label>
            <input type="date" name="end_date" id="end_date" value="{{ $challenge->end_date }}" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm datepicker" required>
        </div>
        <div class="form-group">
            <label for="num_questions" class="block text-sm font-medium text-gray-700">Number of Questions:</label>
            <input type="number" name="num_questions" id="num_questions" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        <div class="form-group">
            <label for="duration" class="block text-sm font-medium text-gray-700">Duration (minutes):</label>
            <input type="number" name="duration" id="duration" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        <div class="form-group">
            <label for="time_per_question" class="block text-sm font-medium text-gray-700">Time per Question (seconds):</label>
            <input type="number" name="time_per_question" id="time_per_question" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        <button type="submit" class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">Update Challenge</button>
    </form>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr('.datepicker', {
                dateFormat: 'Y-m-d',
            });
        });
    </script>
@endsection
