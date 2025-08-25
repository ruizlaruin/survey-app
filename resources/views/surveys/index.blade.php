<!-- resources/views/surveys/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Surveys</h1>
        <a href="{{ route('surveys.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create New Survey
        </a>
    </div>

    @if($surveys->count() > 0)
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Questions</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($surveys as $survey)
                <tr>
                    <td>{{ $survey->id }}</td>
                    <td>
                        <a href="{{ route('surveys.show', $survey) }}" class="text-decoration-none">
                            {{ $survey->name }}
                        </a>
                    </td>
                    <td>
                        <span class="badge bg-primary">{{ $survey->questions_count }}</span>
                    </td>
                    <td>{{ $survey->created_at->format('M d, Y H:i') }}</td>
                    <td>{{ $survey->updated_at->format('M d, Y H:i') }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('surveys.show', $survey) }}" class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <a href="{{ route('surveys.edit', $survey) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('surveys.destroy', $survey) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Are you sure you want to delete this survey?')">
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
    
    <div class="d-flex justify-content-center">
        {{ $surveys->links() }}
    </div>
    @else
    <div class="alert alert-info text-center">
        <i class="bi bi-info-circle"></i> No surveys found. 
        <a href="{{ route('surveys.create') }}" class="alert-link">Create your first survey</a>.
    </div>
    @endif
</div>
@endsection