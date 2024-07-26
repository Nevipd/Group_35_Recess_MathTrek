@extends('dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Send Report Manually</h1>

    <form action="{{ route('reports.sendReportToEmail') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
            <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">
            Send Report
        </button>
    </form>
@endsection
