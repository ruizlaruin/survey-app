<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::withCount('surveys')
                            ->orderBy('created_at', 'desc')
                            ->paginate(20);
        
        $allSurveys = Survey::all();
        
        return view('questions.index', compact('questions', 'allSurveys'));
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

        try {
            DB::beginTransaction();

            $questions = Question::whereIn('id', $validated['question_ids'])->get();
            
            foreach ($questions as $question) {
                $question->surveys()->syncWithoutDetaching($validated['survey_ids']);
            }

            DB::commit();

            return redirect()->route('questions.index')
                             ->with('success', count($validated['question_ids']) . ' questions assigned to ' . count($validated['survey_ids']) . ' surveys successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('questions.index')
                             ->with('error', 'Failed to assign questions: ' . $e->getMessage());
        }
    }

    public function massDelete(Request $request)
    {
        $validated = $request->validate([
            'question_ids' => 'required|array',
            'question_ids.*' => 'exists:questions,id'
        ]);

        try {
            DB::beginTransaction();

            $count = Question::whereIn('id', $validated['question_ids'])->delete();

            DB::commit();

            return redirect()->route('questions.index')
                             ->with('success', $count . ' questions deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('questions.index')
                             ->with('error', 'Failed to delete questions: ' . $e->getMessage());
        }
    }
}
