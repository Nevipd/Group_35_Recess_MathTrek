import Chart from 'chart.js/auto';
// the js to handle chart appearance
document.addEventListener('DOMContentLoaded', function () {
    // chart on challenges
    const challengePerformanceCtx = document.getElementById('challengePerformanceChart').getContext('2d');
    const challengePerformanceChart = new Chart(challengePerformanceCtx, {
        type: 'bar',
        data: {
            labels: ['Best Challenge', 'Worst Challenge'],
            datasets: [{
                label: 'Average Marks',
                data: [85, 40], // dummy
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

    // chart on schools
    const schoolParticipationCtx = document.getElementById('schoolParticipationChart').getContext('2d');
    const schoolParticipationChart = new Chart(schoolParticipationCtx, {
        type: 'pie',
        data: {
            labels: ['Most Participants', 'Least Participants'],
            datasets: [{
                label: 'Number of Participants',
                data: [150, 10], // dummy
                backgroundColor: ['#ffeb3b', '#9c27b0'],
                borderColor: ['#fbc02d', '#7b1fa2'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });

    // hours chart
    const peakHoursCtx = document.getElementById('peakHoursChart').getContext('2d');
    const peakHoursChart = new Chart(peakHoursCtx, {
        type: 'line',
        data: {
            labels: ['10 AM', '11 AM', '12 PM', '1 PM', '2 PM', '3 PM', '4 PM'], // dummy
            datasets: [{
                label: 'Number of Attempts',
                data: [5, 15, 30, 50, 40, 25, 10], // dummy
                backgroundColor: '#03a9f4',
                borderColor: '#0288d1',
                borderWidth: 2,
                fill: false
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'category',
                    labels: ['10 AM', '11 AM', '12 PM', '1 PM', '2 PM', '3 PM', '4 PM'] //dummy
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
