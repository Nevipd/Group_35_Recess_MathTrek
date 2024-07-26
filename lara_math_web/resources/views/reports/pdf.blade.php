<!DOCTYPE html>
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
</html>
