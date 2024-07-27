<!DOCTYPE html>
<html>
<head>
    <title>Report PDF</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Overall Report</h1>
    <!-- the general statistics -->
    <h2>General Statistics</h2>
    <ul>
        <li>Total Schools: {{ $totalSchools }}</li>
        <li>Total Participants: {{ $totalParticipants }}</li>
        <li>Total Challenges: {{ $totalChallenges }}</li>
    </ul>
    <!-- the charts -->
    <h2>Challenge Performance</h2>
    <canvas id="challengePerformanceChart"></canvas>
    
    <h2>School Participation</h2>
    <canvas id="schoolParticipationChart"></canvas>
    
    <h2>Peak Hours of Attempts</h2>
    <canvas id="peakHoursChart"></canvas>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                // more charts
                const challengePerformanceCtx = document.getElementById('challengePerformanceChart').getContext('2d');
                const challengePerformanceChart = new Chart(challengePerformanceCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Best Challenge', 'Worst Challenge'],
                        datasets: [{
                            label: 'Average Marks',
                            data: [{{ $bestChallengeMarks }}, {{ $worstChallengeMarks }}],
                            backgroundColor: ['#4caf50', '#f44336'],
                            borderColor: ['#388e3c', '#d32f2f'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

               
                const schoolParticipationCtx = document.getElementById('schoolParticipationChart').getContext('2d');
                const schoolParticipationChart = new Chart(schoolParticipationCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Most Participants', 'Least Participants'],
                        datasets: [{
                            label: 'Number of Participants',
                            
                            backgroundColor: ['#ffeb3b', '#9c27b0'],
                            borderColor: ['#fbc02d', '#7b1fa2'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });

               
                const peakHoursCtx = document.getElementById('peakHoursChart').getContext('2d');
                const peakHoursChart = new Chart(peakHoursCtx, {
                    type: 'line',
                    data: {
                        labels: ['10 AM', '11 AM', '12 PM', '1 PM', '2 PM', '3 PM', '4 PM'], // dummy data
                        datasets: [{
                            label: 'Number of Attempts',
                            data: {{ json_encode($peakAttemptHours) }},
                            backgroundColor: '#03a9f4',
                            borderColor: '#0288d1',
                            borderWidth: 2,
                            fill: false
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                type: 'category'
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }, 2000); // 2-second delay to allow charts to render
        });
    </script>
</body>
</html>


<!-- <!DOCTYPE html>
<html>
<head>
    <title>Challenge Report</title>
</head>
<body>
    <h1>Challenge Report</h1>
    <p>Challenge: {{ $challenge->name ?? 'No data available' }}</p>
    <p>Description: {{ $challenge->description ?? 'No data available' }}</p>
    <p>Start Date: {{ $challenge->start_date ?? 'No data available' }}</p>
    <p>End Date: {{ $challenge->end_date ?? 'No data available' }}</p>
    <p>Average Marks: {{ $challenge->average_marks ?? 'No data available' }}</p>
    <p>Best Marks: {{ $challenge->best_marks ?? 'No data available' }}</p>
    <p>Worst Marks: {{ $challenge->worst_marks ?? 'No data available' }}</p>
</body>
</html> -->
