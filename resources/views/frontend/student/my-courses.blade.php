@extends('layouts.student')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('My courses') }}</h1>

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
                <th scope="col">title</th>
                <th scope="col">description</th>
                <th scope="col">capacity</th>
                <th scope="col">Teacher</th>
                <th scope="col">Assignments</th>
            </tr>
            </thead>
            <tbody>
            @forelse($registrations as $registration)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $registration->course->title }}</td>
                    <td>{{ $registration->course->description }}</td>
                    <td>{{ $registration->course->capacity }}</td>
                    <td>{{$registration->course->teacher->name}}</td>
                    <td>
                        <a class="btn btn-secondary" href="{{route('student.assignments',$registration->course->id)}}">See Assignments</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No enrollments yet.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{ $registrations->links() }}

    </div>

@endsection


