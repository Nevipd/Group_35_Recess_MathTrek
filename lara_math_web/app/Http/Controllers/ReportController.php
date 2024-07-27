<?php

namespace App\Http\Controllers;
// import all externally referenced classes
use App\Models\Report;
use App\Models\Participant;
use App\Models\School;
use App\Models\Challenge;
use App\Mail\ReportMail;
use App\Mail\ChallengeReportMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Spatie\Browsershot\Browsershot;

class ReportController extends Controller
{
    // this is the function controlling the main view of the reports section
    public function index()
    {
        $totalSchools = School::count();
        $totalParticipants = Participant::count();
        $totalChallenges = Challenge::count();

        // vairiables to retrieve and store dtabase values used for analytics
        $topParticipants = Participant::select('participants.id', 'participants.first_name', 'participants.last_name', DB::raw('SUM(challenge_participant.marks) as total_marks'))
            ->join('challenge_participant', 'participants.id', '=', 'challenge_participant.participant_id')
            ->groupBy('participants.id', 'participants.first_name', 'participants.last_name')
            ->orderBy('total_marks', 'desc')
            ->limit(5)
            ->get();
    
        $topSchools = School::withCount('participants')
            ->orderBy('participants_count', 'desc')
            ->limit(5)
            ->get();

        $bottomSchools = School::withCount('participants')
            ->orderBy('participants_count', 'asc')
            ->limit(3)
            ->get();

        $bestChallenge = Challenge::with('participants')->get()->sortByDesc(function($challenge) {
            return $challenge->participants->avg('pivot.marks');
        })->first();
        $bestChallengeMarks = $bestChallenge ? $bestChallenge->participants->avg('pivot.marks') : 0;

        $worstChallenge = Challenge::with('participants')->get()->sortBy(function($challenge) {
            return $challenge->participants->avg('pivot.marks');
        })->first();
        $worstChallengeMarks = $worstChallenge ? $worstChallenge->participants->avg('pivot.marks') : 0;

        $schoolsWithMostParticipants = School::withCount('participants')->orderBy('participants_count', 'desc')->first();
        $schoolsWithLeastParticipants = School::withCount('participants')->orderBy('participants_count', 'asc')->first();

        $peakAttemptHours = DB::table('challenge_participant')
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw('HOUR(created_at)'))
            ->orderBy('count', 'desc')
            ->get();

        $reports = Report::all();

        // return respective views
        return view('reports.index', compact(
            'totalSchools',
            'totalParticipants',
            'totalChallenges',
            'topParticipants',
            'topSchools',
            'bottomSchools',
            'bestChallengeMarks',
            'worstChallengeMarks',
            'schoolsWithMostParticipants',
            'schoolsWithLeastParticipants',
            'peakAttemptHours',
            'reports'
        ));
    }

    // functions named according to the role they perform
    public function generatePdfReport()
    {
        $html = view('reports.pdf')->render();
        $pdfPath = storage_path('app/public/overall_report.pdf');
        // Browsershot::html($html)->save($pdfPath);
        Browsershot::html($html)
            ->setNodeBinary('C:\Program Files\nodejs\node.exe')
            ->setNpmBinary('C:\Program Files\nodejs\npm.cmd') 
            ->setChromiumPath('C:\Users\nevip\.cache\puppeteer\chrome\win64-127.0.6533.72\chrome-win64\chrome.exe')
            ->waitUntilNetworkIdle() // waiting until all network requests are finished
            ->timeout(120)
            ->save($pdfPath);
        return $pdfPath;
    }

    public function sendReportToAll()
    {
        $schoolReps = School::pluck('representative_email');
        $pdfPath = $this->generatePdfReport();
    
        foreach ($schoolReps as $email) {
            Mail::to($email)->send(new ChallengeReportMail(null, $pdfPath));
        }
    
        return redirect()->route('reports.index')->with('success', 'Report sent to all school representatives.');
    }
    
    public function showManualEmailForm()
    {
        return view('reports.manual_email');
    }

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
