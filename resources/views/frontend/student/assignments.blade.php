@extends('layouts.student')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Assignments of {{$course->title}}</h1>

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
                <th scope="col">Download ?</th>
            </tr>
            </thead>
            <tbody>
            @forelse($assignments as $assignment)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $assignment->name }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $assignment->path) }}" class="btn btn-primary" target="_blank" download>
                            Download
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No Assignments yet.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{ $assignments->links() }}

    </div>

@endsection


