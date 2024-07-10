<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;

class RegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:participants',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:participants',
            'date_of_birth' => 'required|date',
            'school_registration_number' => 'required',
            'image_file' => 'required|image',
        ]);

        $participant = new Participant();
        $participant->username = $request->username;
        $participant->first_name = $request->first_name;
        $participant->last_name = $request->last_name;
        $participant->email = $request->email;
        $participant->date_of_birth = $request->date_of_birth;
        $participant->school_registration_number = $request->school_registration_number;

        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')->store('public/images');
            $participant->image_file = basename($imagePath);
        }

        $participant->save();

        return redirect()->route('register')->with('success', 'Registration successful! Please wait for approval.');
    }
}
