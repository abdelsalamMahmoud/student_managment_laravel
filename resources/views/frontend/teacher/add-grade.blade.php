@extends('layouts.teacher')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Grades of {{$student->name}} in {{$course->title}}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="card-body">
        <form action="{{ route('store.grade',['student_id' => $student->id, 'course_id' => $course->id]) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="value" class="form-label">Grade Value</label>
                <input type="number" name="value" id="value" class="form-control" placeholder="Enter Grade Value" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Add</button>
        </form>
    </div>

@endsection

