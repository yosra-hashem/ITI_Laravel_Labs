@extends('layouts.app')

@section('content')
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
    <div class="card border-info mb-3" style="max-width: 18rem; margin:50px">
        <div class="card-header">post details</div>
        <div class="card-body text-info">
            <h5 class="card-title"> {{ $data->title}} </h5>
            <p class="card-text"> {{ $data->desc }} </p>
            <p class="card-text"> {{ $data->created_at->diffForHumans() }} </p>
            <a href="{{ route('posts.index') }}" class="btn btn-info">back to all posts </a>
        </div>

    </div>
    @endsection