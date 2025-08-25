@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">{{ isset($question) ? 'Edit Question' : 'Create New Question' }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ isset($question) ? route('questions.update', $question) : route('questions.store') }}" method="POST">
                        @csrf
                        @if(isset($question))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="name" class="form-label">Question Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $question->name ?? '') }}" 
                                   placeholder="Enter question name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="question_text" class="form-label">Question Text *</label>
                            <textarea class="form-control @error('question_text') is-invalid @enderror" 
                                      id="question_text" name="question_text" rows="3" 
                                      placeholder="Enter the question text" required>{{ old('question_text', $question->question_text ?? '') }}</textarea>
                            @error('question_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="question_type" class="form-label">Question Type *</label>
                            <select class="form-select @error('question_type') is-invalid @enderror" 
                                    id="question_type" name="question_type" required>
                                <option value="">Select Question Type</option>
                                <option value="rating" {{ old('question_type', $question->question_type ?? '') === 'rating' ? 'selected' : '' }}>Rating</option>
                                <option value="comment-only" {{ old('question_type', $question->question_type ?? '') === 'comment-only' ? 'selected' : '' }}>Comment Only</option>
                                <option value="multiple-choice" {{ old('question_type', $question->question_type ?? '') === 'multiple-choice' ? 'selected' : '' }}>Multiple Choice</option>
                            </select>
                            @error('question_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Assign to Surveys (Optional)</label>
                            
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="selectAllSurveys">
                                <label class="form-check-label fw-bold" for="selectAllSurveys">
                                    Select All Surveys
                                </label>
                            </div>
                            
                            <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                                @foreach($surveys as $survey)
                                <div class="form-check mb-2">
                                    <input class="form-check-input survey-checkbox" type="checkbox" 
                                           name="surveys[]" value="{{ $survey->id }}"
                                           id="survey_{{ $survey->id }}"
                                           {{ (isset($question) && $question->surveys->contains($survey->id)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="survey_{{ $survey->id }}">
                                        <strong>{{ $survey->name }}</strong> 
                                        <span class="text-muted">(ID: {{ $survey->id }})</span>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            
                            @error('surveys')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('questions.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back to Questions
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> 
                                {{ isset($question) ? 'Update Question' : 'Create Question' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all surveys functionality
    const selectAll = document.getElementById('selectAllSurveys');
    const surveyCheckboxes = document.querySelectorAll('.survey-checkbox');
    
    selectAll.addEventListener('change', function() {
        surveyCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // If any checkbox is unchecked, uncheck select all
    surveyCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (!this.checked) {
                selectAll.checked = false;
            } else {
                // Check if all are checked
                const allChecked = Array.from(surveyCheckboxes).every(cb => cb.checked);
                selectAll.checked = allChecked;
            }
        });
    });
});
</script>
@endsection