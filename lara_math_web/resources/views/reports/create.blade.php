@extends('dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Add New Report</h1>

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reports.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="form-group">
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" id="title" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        <div class="form-group">
            <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
            <textarea name="content" id="content" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">Add Report</button>
    </form>
@endsection
