<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Participant;
use App\Models\School;
use App\Models\Challenge;
use App\Mail\ReportMail;
use App\Mail\ChallengeReportMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;;
use Illuminate\Support\Facades\Mail;
use Spatie\Browsershot\Browsershot;



class ReportController extends Controller
{
    // to display a listing of the reports
    public function index()
    {
        $totalSchools = School::count();
        $totalParticipants = Participant::count();
        $totalChallenges = Challenge::count();

        // get top 5 participants by total marks
        $topParticipants = Participant::select('participants.id', 'participants.first_name', 'participants.last_name', DB::raw('SUM(challenge_participant.marks) as total_marks'))
            ->join('challenge_participant', 'participants.id', '=', 'challenge_participant.participant_id')
            ->groupBy('participants.id', 'participants.first_name', 'participants.last_name')
            ->orderBy('total_marks', 'desc')
            ->limit(5)
            ->get();
    
        // getting top 5 schools by participant count
        $topSchools = School::withCount('participants')
            ->orderBy('participants_count', 'desc')
            ->limit(5)
            ->get();

        // getting bottom 3 schools by participant count
        $bottomSchools = School::withCount('participants')
            ->orderBy('participants_count', 'asc')
            ->limit(3)
            ->get();

        // calculating challenge performance
        $bestChallenge = Challenge::with('participants')->get()->sortByDesc(function($challenge) {
            return $challenge->participants->avg('pivot.marks');
        })->first();

        $worstChallenge = Challenge::with('participants')->get()->sortBy(function($challenge) {
            return $challenge->participants->avg('pivot.marks');
        })->first();

        // compute schools with most and least participants
        $schoolsWithMostParticipants = School::withCount('participants')->orderBy('participants_count', 'desc')->first();
        $schoolsWithLeastParticipants = School::withCount('participants')->orderBy('participants_count', 'asc')->first();

        // compute peak attempt hours
        $peakAttemptHours = DB::table('challenge_participant')
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw('HOUR(created_at)'))
            ->orderBy('count', 'desc')
            ->get();

        // fetching all reports
        $reports = Report::all();

        return view('reports.index', compact(
            'totalSchools',
            'totalParticipants',
            'totalChallenges',
            'topParticipants',
            'topSchools',
            'bottomSchools',
            'bestChallenge',
            'worstChallenge',
            'schoolsWithMostParticipants',
            'schoolsWithLeastParticipants',
            'peakAttemptHours',
            'reports'
        ));
    }
    // to show the form for creating a new report
    // public function create()
    // {
    //     return view('reports.create');
    // }

    // to store a newly created report in the database
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'content' => 'required|string',
    //     ]);

    //     Report::create($request->all());

    //     return redirect()->route('reports.index')->with('success', 'Report created successfully.');
    // }

    // to display the specified report
    // public function show(Report $report)
    // {
    //     return view('reports.show', compact('report'));
    // }

    // // to show the form for editing the specified report
    // public function edit(Report $report)
    // {
    //     return view('reports.edit', compact('report'));
    // }

    // to update the specified report in the database
    // public function update(Request $request, Report $report)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'content' => 'required|string',
    //     ]);

    //     $report->update($request->all());

    //     return redirect()->route('reports.index')->with('success', 'Report updated successfully.');
    // }

    // to remove the specified report from the database
    // public function destroy(Report $report)
    // {
    //     $report->delete();

    //     return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    // }
    // function to create pdf report file
        public function generatePdfReport()
        {
            $html = view('reports.pdf')->render();

            $pdfPath = storage_path('app/public/overall_report.pdf');

            Browsershot::html($html)->save($pdfPath);

            return $pdfPath;
        }

    // function to handle manual sending of pdf report
    public function sendReportToAll()
    {
        $schoolReps = School::pluck('representative_email');
        $pdfPath = $this->generatePdfReport();
    
        foreach ($schoolReps as $email) {
            Mail::to($email)->send(new ChallengeReportMail(null, $pdfPath));
        }
    
        return redirect()->route('reports.index')->with('success', 'Report sent to all school representatives.');
    }
    

    // function to show the form for manual emails
    public function showManualEmailForm()
    {
        return view('reports.manual_email');
    }

    // function to send email
    public function sendReportToEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
    
        $pdfPath = $this->generatePdfReport();
    
        Mail::to($request->email)->send(new ChallengeReportMail(null, $pdfPath)); // Pass null for $challenge
    
        return redirect()->route('reports.index')->with('success', 'Report sent to ' . $request->email);
    }
    

}
