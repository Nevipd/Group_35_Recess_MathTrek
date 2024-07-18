@extends('dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Schools</h1>
    <a href="{{ route('schools.create') }}" class="btn btn-primary mb-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md">Add New School</a>
    <table class="table-auto w-full bg-white shadow-md rounded-lg">
        <thead>
            <tr class="bg-gray-200 text-gray-700">
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">District</th>
                <th class="px-4 py-2">Reg Number</th>
                <th class="px-4 py-2">Rep Email</th>
                <th class="px-4 py-2">Rep Name</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schools as $school)
                <tr class="bg-gray-100 border-b border-gray-200">
                    <td class="px-4 py-2">{{ $school->name }}</td>
                    <td class="px-4 py-2">{{ $school->address }}</td>
                    <td class="px-4 py-2">{{ $school->school_registration_number }}</td>
                    <td class="px-4 py-2">{{ $school->representative_email }}</td>
                    <td class="px-4 py-2">{{ $school->representative_name }}</td>
                    <td class="px-4 py-2 flex space-x-2">
                        <a href="{{ route('schools.show', $school->id) }}" class="btn btn-info bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded-md">View</a>
                        <a href="{{ route('schools.edit', $school->id) }}" class="btn btn-warning bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded-md">Edit</a>
                        <form action="{{ route('schools.destroy', $school->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline-block">
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
