@extends('layouts.teacher')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Students in {{$course->title}}</h1>

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

    <div class="row">
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($course->students as $student)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $student->name}}</td>
                    <td>{{ $student->email }}</td>
                    <td>
                        <a class="btn btn-secondary" href="{{ route('create.grade', ['student_id' => $student->id, 'course_id' => $course->id]) }}">Add Grade</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No students yet.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>

@endsection


