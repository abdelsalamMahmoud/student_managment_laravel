@extends('layouts.teacher')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Add Assignment</h1>

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
        <form action="{{ route('store.assignment',$course_id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Assignment Title --}}
            <div class="mb-3">
                <label for="title" class="form-label">Assignment Title</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Enter assignment title" required>
            </div>

            {{-- File Upload --}}
            <div class="mb-3">
                <label for="file" class="form-label">Assignment File</label>
                <input type="file" name="file" id="file" class="form-control" accept=".pdf,.doc,.docx,.zip,.rar" required>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-success w-100">Upload</button>
        </form>
    </div>

@endsection

