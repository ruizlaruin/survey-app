<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::withCount('surveys')
                            ->orderBy('created_at', 'desc')
                            ->paginate(20);
        
        return view('questions.index', compact('questions'));
    }

    public function create()
    {
        $surveys = Survey::all();
        return view('questions.create', compact('surveys'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'question_text' => 'required|string',
            'question_type' => 'required|in:rating,comment-only,multiple-choice',
            'surveys' => 'array',
            'surveys.*' => 'exists:surveys,id'
        ]);

        $question = Question::create($validated);
        
        if (isset($validated['surveys'])) {
            $question->surveys()->attach($validated['surveys']);
        }

        return redirect()->route('questions.index')
                         ->with('success', 'Question created successfully.');
    }

    public function edit(Question $question)
    {
        $question->load('surveys');
        $surveys = Survey::all();
        return view('questions.edit', compact('question', 'surveys'));
    }

    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'question_text' => 'required|string',
            'question_type' => 'required|in:rating,comment-only,multiple-choice',
            'surveys' => 'array',
            'surveys.*' => 'exists:surveys,id'
        ]);

        $question->update($validated);
        
        if (isset($validated['surveys'])) {
            $question->surveys()->sync($validated['surveys']);
        }

        return redirect()->route('questions.index')
                         ->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('questions.index')
                         ->with('success', 'Question deleted successfully.');
    }

    public function massAssign(Request $request)
    {
        $validated = $request->validate([
            'question_ids' => 'required|array',
            'question_ids.*' => 'exists:questions,id',
            'survey_ids' => 'required|array',
            'survey_ids.*' => 'exists:surveys,id'
        ]);

        $questions = Question::whereIn('id', $validated['question_ids'])->get();
        
        foreach ($questions as $question) {
            $question->surveys()->syncWithoutDetaching($validated['survey_ids']);
        }

        return redirect()->route('questions.index')
                         ->with('success', 'Questions assigned to surveys successfully.');
    }

    public function massDelete(Request $request)
    {
        $validated = $request->validate([
            'question_ids' => 'required|array',
            'question_ids.*' => 'exists:questions,id'
        ]);

        Question::whereIn('id', $validated['question_ids'])->delete();

        return redirect()->route('questions.index')
                         ->with('success', 'Questions deleted successfully.');
    }
}
