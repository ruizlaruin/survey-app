<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::withCount('questions')
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);
        
        return view('surveys.index', compact('surveys'));
    }

    public function create()
    {
        $questions = Question::all();
        return view('surveys.create', compact('questions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'questions' => 'array',
            'questions.*' => 'exists:questions,id'
        ]);

        $survey = Survey::create($validated);
        
        if (isset($validated['questions'])) {
            $survey->questions()->attach($validated['questions']);
        }

        return redirect()->route('surveys.index')
                         ->with('success', 'Survey created successfully.');
    }

    public function show(Survey $survey)
    {
        $survey->load('questions');
        return view('surveys.show', compact('survey'));
    }

    public function edit(Survey $survey)
    {
        $survey->load('questions');
        $questions = Question::all();
        return view('surveys.edit', compact('survey', 'questions'));
    }

    public function update(Request $request, Survey $survey)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'questions' => 'array',
            'questions.*' => 'exists:questions,id'
        ]);

        $survey->update($validated);
        
        if (isset($validated['questions'])) {
            $survey->questions()->sync($validated['questions']);
        }

        return redirect()->route('surveys.index')
                         ->with('success', 'Survey updated successfully.');
    }

    public function destroy(Survey $survey)
    {
        $survey->delete();
        return redirect()->route('surveys.index')
                         ->with('success', 'Survey deleted successfully.');
    }
}
