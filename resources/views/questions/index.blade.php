@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Questions</h1>
        <a href="{{ route('questions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create New Question
        </a>
    </div>

    <form id="massActionForm" method="POST">
        @csrf
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h6 class="mb-0">Mass Operations</h6>
            </div>
            <div class="card-body">
                <div class="d-flex gap-2 flex-wrap">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#assignModal">
                        <i class="bi bi-link"></i> Assign to Surveys
                    </button>
                    <button type="button" class="btn btn-danger" onclick="confirmMassDelete()">
                        <i class="bi bi-trash"></i> Delete Selected
                    </button>
                    <div class="ms-auto">
                        <input type="checkbox" id="selectAll" class="form-check-input me-2">
                        <label for="selectAll" class="form-check-label">Select All</label>
                    </div>
                </div>
            </div>
        </div>

        @if($questions->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th width="50"></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Question Text</th>
                        <th>Type</th>
                        <th>Surveys</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($questions as $question)
                    <tr>
                        <td>
                            <input type="checkbox" name="question_ids[]" value="{{ $question->id }}" 
                                   class="question-checkbox form-check-input">
                        </td>
                        <td>{{ $question->id }}</td>
                        <td>
                            <strong>{{ $question->name }}</strong>
                        </td>
                        <td>{{ Str::limit($question->question_text, 80) }}</td>
                        <td>
                            <span class="badge 
                                @if($question->question_type === 'rating') bg-warning
                                @elseif($question->question_type === 'comment-only') bg-info
                                @elseif($question->question_type === 'multiple-choice') bg-success
                                @endif">
                                {{ $question->question_type }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-primary">{{ $question->surveys_count }}</span>
                        </td>
                        <td>{{ $question->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('questions.edit', $question) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('questions.destroy', $question) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Are you sure you want to delete this question?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $questions->links() }}
        </div>
        @else
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle"></i> No questions found. 
            <a href="{{ route('questions.create') }}" class="alert-link">Create your first question</a>.
        </div>
        @endif
    </form>
</div>

<!-- Assign Modal -->
<div class="modal fade" id="assignModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Questions to Surveys</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Selected questions will be assigned to the following surveys:</p>
                
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAllSurveys">
                        <label class="form-check-label fw-bold" for="selectAllSurveys">
                            Select All Surveys
                        </label>
                    </div>
                </div>
                
                <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                    @foreach($allSurveys as $survey)
                    <div class="form-check mb-2">
                        <input class="form-check-input survey-checkbox" type="checkbox" 
                               name="survey_ids[]" value="{{ $survey->id }}"
                               id="survey_{{ $survey->id }}">
                        <label class="form-check-label" for="survey_{{ $survey->id }}">
                            <strong>{{ $survey->name }}</strong>
                            <span class="text-muted">(ID: {{ $survey->id }})</span>
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitMassAssign()">
                    <i class="bi bi-link"></i> Assign Questions
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const questionCheckboxes = document.querySelectorAll('.question-checkbox');
    
    selectAll.addEventListener('change', function() {
        questionCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    const selectAllSurveys = document.getElementById('selectAllSurveys');
    const surveyCheckboxes = document.querySelectorAll('.survey-checkbox');
    
    selectAllSurveys.addEventListener('change', function() {
        surveyCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    questionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectAll);
    });
});

function updateSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const questionCheckboxes = document.querySelectorAll('.question-checkbox');
    
    const allChecked = Array.from(questionCheckboxes).every(cb => cb.checked);
    const someChecked = Array.from(questionCheckboxes).some(cb => cb.checked);
    
    selectAll.checked = allChecked;
    selectAll.indeterminate = someChecked && !allChecked;
}

function submitMassAssign() {
    const selectedQuestions = document.querySelectorAll('.question-checkbox:checked');
    const selectedSurveys = document.querySelectorAll('.survey-checkbox:checked');
    
    if (selectedQuestions.length === 0) {
        alert('Please select at least one question.');
        return;
    }
    
    if (selectedSurveys.length === 0) {
        alert('Please select at least one survey.');
        return;
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = "{{ route('questions.mass-assign') }}";
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = "{{ csrf_token() }}";
    form.appendChild(csrfToken);
    
    selectedQuestions.forEach(question => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'question_ids[]';
        input.value = question.value;
        form.appendChild(input);
    });
    
    selectedSurveys.forEach(survey => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'survey_ids[]';
        input.value = survey.value;
        form.appendChild(input);
    });
    
    document.body.appendChild(form);
    form.submit();
}

function confirmMassDelete() {
    const selectedQuestions = document.querySelectorAll('.question-checkbox:checked');
    
    if (selectedQuestions.length === 0) {
        alert('Please select at least one question to delete.');
        return;
    }
    
    if (confirm(`Are you sure you want to delete ${selectedQuestions.length} question(s)? This action cannot be undone.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('questions.mass-delete') }}";
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = "{{ csrf_token() }}";
        form.appendChild(csrfToken);
        
        selectedQuestions.forEach(question => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'question_ids[]';
            input.value = question.value;
            form.appendChild(input);
        });
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection