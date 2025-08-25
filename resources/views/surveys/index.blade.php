@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Surveys</h1>
    <a href="{{ route('surveys.create') }}" class="btn btn-primary mb-3">Create New Survey</a>
    
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
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
                    <td>{{ $survey->name }}</td>
                    <td>{{ $survey->questions_count }}</td>
                    <td>{{ $survey->created_at->format('M d, Y H:i') }}</td>
                    <td>{{ $survey->updated_at->format('M d, Y H:i') }}</td>
                    <td>
                        <a href="{{ route('surveys.show', $survey) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('surveys.edit', $survey) }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    {{ $surveys->links() }}
</div>
@endsection