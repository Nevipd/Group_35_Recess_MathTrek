<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Display a listing of the reports
    public function index()
    {
        $reports = Report::all();
        return view('reports.index', compact('reports'));
    }

    // Show the form for creating a new report
    public function create()
    {
        return view('reports.create');
    }

    // Store a newly created report in the database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Report::create($request->all());

        return redirect()->route('reports.index')->with('success', 'Report created successfully.');
    }

    // Display the specified report
    public function show(Report $report)
    {
        return view('reports.show', compact('report'));
    }

    // Show the form for editing the specified report
    public function edit(Report $report)
    {
        return view('reports.edit', compact('report'));
    }

    // Update the specified report in the database
    public function update(Request $request, Report $report)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $report->update($request->all());

        return redirect()->route('reports.index')->with('success', 'Report updated successfully.');
    }

    // Remove the specified report from the database
    public function destroy(Report $report)
    {
        $report->delete();

        return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    }
}
