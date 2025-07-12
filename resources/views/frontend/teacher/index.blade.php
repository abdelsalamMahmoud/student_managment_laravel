@extends('layouts.teacher')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Courses</h1>

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
        <div class="pb-4"><a class="btn btn-primary" href="{{route('teacher.courses.create')}}">Create Course</a></div>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">title</th>
                <th scope="col">description</th>
                <th scope="col">capacity</th>
                <th scope="col">Assignments</th>
                <th scope="col">actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($courses as $course)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $course->title }}</td>
                    <td>{{ $course->description }}</td>
                    <td>{{ $course->capacity }}</td>
                    <td><a class="btn btn-primary">Upload</a></td>
                    <td>
                        <a class="btn btn-secondary" href="{{ route('teacher.courses.edit', $course->id) }}">Edit</a>
                        <a class="btn btn-danger" href="{{ route('teacher.courses.delete', $course->id) }}">Delete</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No courses yet.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{ $courses->links() }}

    </div>

@endsection

