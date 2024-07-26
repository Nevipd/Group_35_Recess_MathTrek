@extends('dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Participants</h1>
    <!-- Remove the Add New Participant button -->
    <!-- <a href="{{ route('participants.create') }}" class="btn btn-primary mb-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md">Add New Participant</a> -->
    <table class="table-auto w-full bg-white shadow-md rounded-lg">
        <thead>
            <tr class="bg-gray-200 text-gray-700">
                <th class="px-4 py-2">Username</th>
                <th class="px-4 py-2">First Name</th>
                <th class="px-4 py-2">Last Name</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">D.O.B</th>
                <th class="px-4 py-2">Reg No</th>
                <th class="px-4 py-2">Image</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($participants as $participant)
                <tr class="bg-gray-100 border-b border-gray-200">
                    <td class="px-4 py-2">{{ $participant->username }}</td>
                    <td class="px-4 py-2">{{ $participant->first_name }}</td>
                    <td class="px-4 py-2">{{ $participant->last_name }}</td>
                    <td class="px-4 py-2">{{ $participant->email }}</td>
                    <td class="px-4 py-2">{{ $participant->date_of_birth }}</td>
                    <td class="px-4 py-2">{{ $participant->school_registration_number }}</td>
                    <td class="px-4 py-2">{{ $participant->image_file }}</td>
                    <td class="px-4 py-2 flex space-x-2">
                        <a href="{{ route('participants.show', $participant->id) }}" class="btn btn-info bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded-md">View</a>
                        <a href="{{ route('participants.edit', $participant->id) }}" class="btn btn-warning bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded-md">Edit</a>
                        <form action="{{ route('participants.destroy', $participant->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline-block">
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
