@extends('layouts.app')

@section('content')
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="container">
            <form method="POST" action="{{ route('posts.update', $data->id) }}">
                @method('put')
                @csrf
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $data->title }}"
                        class="@error('title') is-invalid @enderror">

                    @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <input type="text" name="desc" class="form-control" value="{{ $data->desc }}"
                        class="@error('desc') is-invalid @enderror">

                    @error('desc')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                </div>

                <div class="mb-3">
                    <label class="form-label">user</label>
                    <select class="form-select" aria-label="Default select example" name="user_id">
                        @foreach ($users as $user)
                            <option value=" {{ $user->id }} "> {{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="mb-3 text-center">
                    <input type="submit" class="btn btn-success">
                </div>
            </form>

        </div>
    </div>
@endsection
