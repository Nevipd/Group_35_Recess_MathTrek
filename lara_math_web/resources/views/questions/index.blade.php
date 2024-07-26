@extends('dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Manage question and answer Files</h1>
    <!-- <a href="{{ route('questions.create') }}" class="btn btn-primary mb-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md">Add New Question</a> -->
    <a href="{{ route('questions.importForm') }}" class="btn btn-secondary mb-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-md">Import Files</a>
    <table class="table-auto w-full bg-white shadow-md rounded-lg">
        <thead>
            <tr class="bg-gray-200 text-gray-700">
                <th class="px-4 py-2">File Name</th>
                <th class="px-4 py-2">Description</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questions as $question)
                <tr class="bg-gray-100 border-b border-gray-200">
                    <td class="px-4 py-2">{{ $question->file_name }}</td>
                    <td class="px-4 py-2">{{ $question->description }}</td>
                    <td class="px-4 py-2 flex space-x-2">
                        <a href="{{ route('questions.show', $question->id) }}" class="btn btn-info bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded-md">View</a>
                        <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded-md">Edit</a>
                        <form action="{{ route('questions.destroy', $question->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded-md">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

<!-- @extends('dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Questions</h1>
    <a href="{{ route('questions.create') }}" class="btn btn-primary mb-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md">Add New Question</a>
    
    <a href="{{ route('questions.importForm') }}" class="btn btn-secondary mb-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-md">Import Questions</a>
    <table class="table-auto w-full bg-white shadow-md rounded-lg">
        <thead>
            <tr class="bg-gray-200 text-gray-700">
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Content</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questions as $question)
                <tr class="bg-gray-100 border-b border-gray-200">
                    <td class="px-4 py-2">{{ $question->title }}</td>
                    <td class="px-4 py-2">{{ $question->content }}</td>
                    <td class="px-4 py-2 flex space-x-2">
                        <a href="{{ route('questions.show', $question->id) }}" class="btn btn-info bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded-md">View</a>
                        <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded-md">Edit</a>
                        <form action="{{ route('questions.destroy', $question->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded-md">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection -->
