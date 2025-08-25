@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Questions</h1>
    <a href="{{ route('questions.create') }}" class="btn btn-primary mb-3">Create New Question</a>
    
    <form id="massActionForm" method="POST">
        @csrf
        <div class="mb-3">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#assignModal">
                Assign to Surveys
            </button>
            <button type="button" class="btn btn-danger" onclick="confirmMassDelete()">
                Delete Selected
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
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
                        <td><input type="checkbox" name="question_ids[]" value="{{ $question->id }}"></td>
                        <td>{{ $question->id }}</td>
                        <td>{{ $question->name }}</td>
                        <td>{{ Str::limit($question->question_text, 50) }}</td>
                        <td>{{ $question->question_type }}</td>
                        <td>{{ $question->surveys_count }}</td>
                        <td>{{ $question->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            <a href="{{ route('questions.edit', $question) }}" class="btn btn-warning btn-sm">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{ $questions->links() }}
    </form>
</div>

<!-- Assign Modal -->
<div class="modal fade" id="assignModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign to Surveys</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <select name="survey_ids[]" multiple class="form-select" size="8">
                    @foreach(App\Models\Survey::all() as $survey)
                    <option value="{{ $survey->id }}">{{ $survey->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitMassAssign()">Assign</button>
            </div>
        </div>
    </div>
</div>

<script>
// Vanilla JavaScript for mass operations
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkbox
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="question_ids[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });
});

function submitMassAssign() {
    const form = document.getElementById('massActionForm');
    form.action = "{{ route('questions.mass-assign') }}";
    form.method = 'POST';
    form.submit();
}

function confirmMassDelete() {
    if (confirm('Are you sure you want to delete the selected questions?')) {
        const form = document.getElementById('massActionForm');
        form.action = "{{ route('questions.mass-delete') }}";
        form.method = 'POST';
        form.submit();
    }
}
</script>
@endsection