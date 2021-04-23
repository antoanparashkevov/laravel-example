@extends('layouts.app')

@section('title', 'Blog posts')

@section('content')

    @forelse($posts as $key=>$post)
        @include('posts.partials.post')

                        @break($key == 2)

                        @continue($key == 1)

    @empty
        No posts found
    @endforelse

@endsection
