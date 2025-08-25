@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Survey Details</h1>
        <div class="btn-group">
            <a href="{{ route('surveys.edit', $survey) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit Survey
            </a>
            <a href="{{ route('surveys.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Surveys
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Survey Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="120">ID:</th>
                            <td>{{ $survey->id }}</td>
                        </tr>
                        <tr>
                            <th>Name:</th>
                            <td>{{ $survey->name }}</td>
                        </tr>
                        <tr>
                            <th>Created:</th>
                            <td>{{ $survey->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="120">Questions:</th>
                            <td>
                                <span class="badge bg-primary">{{ $survey->questions->count() }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Last Updated:</th>
                            <td>{{ $survey->updated_at->format('M d, Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Survey Questions</h5>
        </div>
        <div class="card-body">
            @if($survey->questions->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Question Text</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($survey->questions as $question)
                        <tr>
                            <td>{{ $question->id }}</td>
                            <td>
                                <strong>{{ $question->name }}</strong>
                            </td>
                            <td>{{ $question->question_text }}</td>
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
                                <a href="{{ route('questions.edit', $question) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle"></i> This survey doesn't have any questions yet.
                <a href="{{ route('surveys.edit', $survey) }}" class="alert-link">Add questions to this survey</a>.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection