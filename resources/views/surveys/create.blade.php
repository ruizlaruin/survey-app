@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">{{ isset($survey) ? 'Edit Survey' : 'Create New Survey' }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ isset($survey) ? route('surveys.update', $survey) : route('surveys.store') }}" method="POST">
                        @csrf
                        @if(isset($survey))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="name" class="form-label">Survey Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $survey->name ?? '') }}" 
                                   placeholder="Enter survey name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Select Questions</label>
                            
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="selectAllQuestions">
                                <label class="form-check-label fw-bold" for="selectAllQuestions">
                                    Select All Questions
                                </label>
                            </div>
                            
                            <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                @foreach($questions as $question)
                                <div class="form-check mb-2">
                                    <input class="form-check-input question-checkbox" type="checkbox" 
                                           name="questions[]" value="{{ $question->id }}"
                                           id="question_{{ $question->id }}"
                                           {{ (isset($survey) && $survey->questions->contains($question->id)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="question_{{ $question->id }}">
                                        <strong>{{ $question->name }}</strong> 
                                        <span class="text-muted">({{ $question->question_type }})</span>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($question->question_text, 100) }}</small>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            
                            @error('questions')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('surveys.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back to Surveys
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> 
                                {{ isset($survey) ? 'Update Survey' : 'Create Survey' }}
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
    // Select all questions functionality
    const selectAll = document.getElementById('selectAllQuestions');
    const questionCheckboxes = document.querySelectorAll('.question-checkbox');
    
    selectAll.addEventListener('change', function() {
        questionCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // If any checkbox is unchecked, uncheck select all
    questionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (!this.checked) {
                selectAll.checked = false;
            } else {
                // Check if all are checked
                const allChecked = Array.from(questionCheckboxes).every(cb => cb.checked);
                selectAll.checked = allChecked;
            }
        });
    });
});
</script>
@endsection