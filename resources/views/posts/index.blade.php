@extends('layouts.app')

@section('content')
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="container">
            <div class="text-center">
                <td><a href="/posts/create" class="btn btn-success">Add New Post </a></td>

            </div>
            <table class="table">
                <tr>
                    <th> ID </th>
                    <th> Title </th>
                    <th> Description </th>
                    <th> Slug </th>
                    <th> created at </th>
                    <th> View </th>
                    <th> Edit </th>
                    <th> Delete </th>
                </tr>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->desc }}</td>
                        <td>{{ $post->slug }}</td>
                        <td>{{ $post->created_at->diffForHumans() }}</td>


                        {{-- @if (Auth::id() == $post->user_id)
                            <td><a href="{{ route('posts.show', $post->id) }}" class="btn btn-info">View </a></td>
                            <td><a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit </a></td>
                            <td>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        @else
                            <td><p>cant</p></td>
                            <td><p>access</p></td>
                            <td><p>this post</p></td>

                        @endif --}}

                        <td><a href="{{ route('posts.show', $post->id) }}" class="btn btn-info">View </a></td>
                        <td><a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit </a></td>
                        <td>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                        
                    </tr>
                @endforeach

            </table>

            {{ $posts->links() }}

        </div>

    </div>
@endsection
