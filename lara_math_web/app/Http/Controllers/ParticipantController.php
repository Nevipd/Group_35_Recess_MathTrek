<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    /**
     * to display a listing of the resource.
     */
    public function index()
    {
        $participants = Participant::all();
        return view('participants.index', compact('participants'));
    }

    /**
     * to show the form for creating a new resource.
     */
    public function create()
    {
        return view('participants.create');
    }

    /**
     * to store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username'=> 'required',
            'first_name'=> 'required',
            'last_name'=> 'required',
            'email' => 'required|email|unique:participants,email',
            'date_of_birth'=> 'required|date',
            'school_registration_number'=> 'required',
            'image_file'=> 'required',
        ]);

        try {
        Participant::create($request->all());
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors(['username' => 'The username has already been taken!'])->withInput();
        }

        return redirect()->route('participants.index')
                         ->with('success', 'Participant created successfully.');
    }

    /**
     * to display the specified resource.
     */
    public function show(string $id)
    {
        $participant = Participant::findOrFail($id);
        return view('participants.show', compact('participant'));
    }

    /**
     * to show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $participant = Participant::findOrFail($id);
        return view('participants.edit', compact('participant'));
    }

    /**
     * to update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'username'=> 'required|string|max:255',
            'first_name'=> 'required|string|max:255',
            'last_name'=> 'required|string|max:255',
            'email' => 'required|string|max:255',
            'date_of_birth'=> 'required|date',
            'school_registration_number'=> 'required|string|max:255',
            'image_file'=> 'required',
        ]);

        try {
        $participant = Participant::findOrFail($id);
        $participant->update($request->all());
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors(['username' => 'The username has already been taken.'])->withInput();
        }

        return redirect()->route('participants.index')
                         ->with('success', 'Participant updated successfully.');
    }

    /**
     * to remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $participant = Participant::findOrFail($id);
        $participant->delete();

        return redirect()->route('participants.index')
                         ->with('success', 'Participant deleted successfully.');
    }
}
