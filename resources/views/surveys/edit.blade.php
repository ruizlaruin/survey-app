@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('surveys.index') }}">Surveys</a></li>
            <li class="breadcrumb-item"><a href="{{ route('surveys.show', $survey) }}">{{ $survey->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0">Edit Survey: {{ $survey->name }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('surveys.update', $survey) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Survey Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $survey->name) }}" 
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
                                           {{ $survey->questions->contains($question->id) ? 'checked' : '' }}>
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
                            <a href="{{ route('surveys.show', $survey) }}" class="btn btn-info">
                                <i class="bi bi-eye"></i> View Details
                            </a>
                            <div class="btn-group">
                                <a href="{{ route('surveys.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Update Survey
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card mt-4 border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Danger Zone</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Once you delete a survey, there is no going back. Please be certain.</p>
                    <form action="{{ route('surveys.destroy', $survey) }}" method="POST" 
                          onsubmit="return confirm('Are you absolutely sure you want to delete this survey? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Delete this Survey
                        </button>
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

    // Initialize select all state
    const allChecked = Array.from(questionCheckboxes).every(cb => cb.checked);
    selectAll.checked = allChecked;
});
</script>
@endsection