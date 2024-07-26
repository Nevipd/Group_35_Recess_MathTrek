<!-- <x-mail::message>
# Challenge Report

Dear {{ $representativeName }},

Here is the report for the challenge "{{ $challengeName }}".

## Challenge Details
- **Start Date:** {{ $startDate }}
- **End Date:** {{ $endDate }}

## School Performance
### Top 5 Best Performing Students
<ol>
@foreach($bestPerformingStudents as $student)
    <li>{{ $student->username }} - {{ $student->marks }} marks</li>
@endforeach
</ol>

### Top 5 Worst Performing Students
<ol>
@foreach($worstPerformingStudents as $student)
    <li>{{ $student->username }} - {{ $student->marks }} marks</li>
@endforeach
</ol>

<x-mail::button :url="''">
View Detailed Report
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message> -->
