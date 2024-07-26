@extends('dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Reports</h1>

    <div class="mb-4">
        
        <form action="{{ route('reports.sendToAll') }}" method="POST" class="inline-block">
            @csrf
            <button type="submit" class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">
                Send Report to All
            </button>
        </form>
        <a href="{{ route('reports.manualEmailForm') }}" class="btn btn-primary bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-md">Send Report Manually</a>
    </div>

    <h2 class="text-xl font-semibold mb-4">Analytics Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <h3 class="text-lg font-medium mb-2">General Statistics</h3>
            <ul class="list-disc list-inside bg-white p-4 rounded-lg shadow-md">
                <li>Total Schools: {{ $totalSchools }}</li>
                <li>Total Participants: {{ $totalParticipants }}</li>
                <li>Total Challenges: {{ $totalChallenges }}</li>
            </ul>
        </div>
        <div>
            <h3 class="text-lg font-medium mb-2">Leaderboards</h3>
            <h4 class="font-medium">Top 5 Schools</h4>
            <ul class="list-disc list-inside bg-white p-4 rounded-lg shadow-md mb-4">
                @foreach($topSchools as $school)
                    <li>{{ $school->name }} ({{ $school->participants_count }} participants)</li>
                @endforeach
            </ul>
            <h4 class="font-medium">Top 5 Participants</h4>
            <ul class="list-disc list-inside bg-white p-4 rounded-lg shadow-md mb-4">
                @foreach($topParticipants as $participant)
                    <li>{{ $participant->first_name }} {{ $participant->last_name }} ({{ $participant->total_marks }} marks)</li>
                @endforeach
            </ul>
            <h4 class="font-medium">Bottom 3 Schools</h4>
            <ul class="list-disc list-inside bg-white p-4 rounded-lg shadow-md">
                @foreach($bottomSchools as $school)
                    <li>{{ $school->name }} ({{ $school->participants_count }} participants)</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <h3 class="text-lg font-medium mb-2">Challenge Performance</h3>
            <canvas id="challengePerformanceChart" class="bg-white p-4 rounded-lg shadow-md"></canvas>
        </div>
        <div>
            <h3 class="text-lg font-medium mb-2">School Participation</h3>
            <canvas id="schoolParticipationChart" class="bg-white p-4 rounded-lg shadow-md"></canvas>
        </div>
    </div>

    <div class="mb-6">
        <h3 class="text-lg font-medium mb-2">Attempt Hours</h3>
        <canvas id="peakHoursChart" class="bg-white p-4 rounded-lg shadow-md"></canvas>
    </div>

    <h2 class="text-xl font-semibold mb-4">All Reports</h2>
    <!-- <table class="table-auto w-full bg-white shadow-md rounded-lg">
        <thead>
            <tr class="bg-gray-200 text-gray-700">
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Content</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
                <tr class="bg-gray-100 border-b border-gray-200">
                    <td class="px-4 py-2">{{ $report->title }}</td>
                    <td class="px-4 py-2">{{ $report->content }}</td>
                    <td class="px-4 py-2 flex space-x-2">
                        <a href="{{ route('reports.show', $report->id) }}" class="btn btn-info bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded-md">View</a>
                        <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-warning bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded-md">Edit</a>
                        <form action="{{ route('reports.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded-md">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table> -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('challengePerformanceChart').getContext('2d');
        var challengePerformanceChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Best Challenge', 'Worst Challenge'],
                datasets: [{
                    label: 'Average Marks',
                    data: [{{ $bestChallenge->average_marks }}, {{ $worstChallenge->average_marks }}],
                    backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                    borderWidth: 1
                }]
            }
        });

        var ctx2 = document.getElementById('schoolParticipationChart').getContext('2d');
        var schoolParticipationChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Most Participants', 'Least Participants'],
                datasets: [{
                    data: [{{ $schoolsWithMostParticipants->participants_count }}, {{ $schoolsWithLeastParticipants->participants_count }}],
                    backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
                    borderWidth: 1
                }]
            }
        });

        var ctx3 = document.getElementById('peakHoursChart').getContext('2d');
        var peakHoursChart = new Chart(ctx3, {
            type: 'line',
            data: {
                labels: {!! json_encode($peakAttemptHours->pluck('hour')) !!},
                datasets: [{
                    label: 'Attempts',
                    data: {!! json_encode($peakAttemptHours->pluck('count')) !!},
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            }
        });
    </script>
@endsection
