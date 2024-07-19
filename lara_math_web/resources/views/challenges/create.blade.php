@extends('dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Add New Challenge</h1>
    <form action="{{ route('challenges.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="form-group">
            <label for="name" class="block text-sm font-medium text-gray-700">Title:</label>
            <input type="text" name="name" id="name" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        <div class="form-group">
            <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
            <textarea name="description" id="description" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></textarea>
        </div>
        <div class="form-group">
            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date:</label>
            <input type="date" name="start_date" id="start_date" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm datepicker" required>
        </div>
        <div class="form-group">
            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date:</label>
            <input type="date" name="end_date" id="end_date" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm datepicker" required>
        </div>
        <button type="submit" class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">Add Challenge</button>
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
