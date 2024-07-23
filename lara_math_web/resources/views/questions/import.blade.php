@extends('dashboard')
<!-- display the form -->
@section('content')
<h1 class="text-2xl font-bold mb-6">Import Questions</h1>

@if ($errors->any())
    <div class="alert alert-danger mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('questions.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <div class="form-group">
        <label for="questions_file" class="block text-sm font-medium text-gray-700">Questions File</label>
        <input type="file" name="questions_file" id="questions_file" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
    </div>
    <div class="form-group">
        <label for="answers_file" class="block text-sm font-medium text-gray-700">Answers File</label>
        <input type="file" name="answers_file" id="answers_file" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
    </div>
    <button type="submit" class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">Import</button>
</form>
@endsection
