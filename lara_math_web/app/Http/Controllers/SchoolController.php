<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Representative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\SchoolRepresentativeCredentials;

class SchoolController extends Controller
{
    // to display a listing of the schools
    public function index()
    {
        $schools = School::withCount('participants')->get();
        return view('schools.index', compact('schools'));
        
    }

    // to show the form for creating a new school
    public function create()
    {
        return view('schools.create');
    }

    // to store a newly created school in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'school_registration_number' => 'required|string|max:15|unique:schools,school_registration_number',
            'representative_email' => 'required|string|email|max:255',
            'representative_name' => 'required|string|max:255',
        ]);

        // debugging through logs for easy error resolution
        try {
            $school = School::create($request->all());

            $password = Str::random(8); // generate a random password
            $representativeData = [
                'school_id' => $school->id,
                'representative_email' => $request->representative_email,
                'representative_name' => $request->representative_name,
                'password' => $password, //save the password
            ];

            $representative = Representative::create($representativeData);

            $this->sendRepresentativeCredentials($school, $password);

            logger()->info('School created successfully: ', $school->toArray());
            logger()->info('Representative created successfully: ', $representative->toArray());
        } catch (\Exception $e) {
            logger()->error('Error creating school: ', ['message' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'An error occurred while creating the school.'])->withInput();
        }

        return redirect()->route('schools.index')->with('success', 'School created successfully.');
    }

//     public function store(Request $request)
// {
//     $request->validate([
//         'name' => 'required|string|max:255',
//         'address' => 'required|string|max:255',
//         'school_registration_number' => 'required|string|max:15|unique:schools,school_registration_number',
//         'representative_email' => 'required|string|email|max:255',
//         'representative_name' => 'required|string|max:255',
//     ]);

//     $password = Str::random(8); // to generate a random password
//     $schoolData = $request->all();
//     $schoolData['password'] = $password; // store the password.

//     // debugging through logs for easy error resolution
//     try {
//         $school = School::create($schoolData);
//         $this->sendRepresentativeCredentials($school, $password);

//         logger()->info('School created successfully: ', $school->toArray());
//     } catch (\Exception $e) {
//         logger()->error('Error creating school: ', ['message' => $e->getMessage()]);
//         return redirect()->back()->withErrors(['error' => 'An error occurred while creating the school.'])->withInput();
//     }

//     return redirect()->route('schools.index')->with('success', 'School created successfully.');
// }

private function sendRepresentativeCredentials($school, $password)
{
    try {
        Mail::to($school->representative_email)->send(new SchoolRepresentativeCredentials($school, $password));
    } catch (\Exception $e) {
        logger()->error('Error sending email: ', ['message' => $e->getMessage()]);
    }
}

    // to display the specified school
        public function show(School $school)
    { 
    // if a School has many Participants and a relationship defined
        $participantsCount = $school->participants()->count();

    return view('schools.show', compact('school', 'participantsCount'));
    }


    // to show the form for editing the specified school
    public function edit(School $school)
    {
        return view('schools.edit', compact('school'));
    }

    // to update the specified school in the database
    public function update(Request $request, School $school)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'school_registration_number' => 'required|string|max:15|unique:schools,school_registration_number,' . $school->id,
            'representative_email' => 'required|string|max:255',
            'representative_name' => 'required|string|max:255',
        ]);

        $school->update($request->all());

        return redirect()->route('schools.index')->with('success', 'School updated successfully.');
    }

    // to remove the specified school from the database
    public function destroy(School $school)
    {
        $school->delete();

        return redirect()->route('schools.index')->with('success', 'School deleted successfully.');
    }
}