@extends('layouts.app')

@section('title',$post->title)

@section('content')

    <h1>{{$post->title}}</h1>
    <p>{{$post->content}}</p>
    <br>

    <p>Added {{$post->created_at->diffForHumans()}}</p>

    @if(now()->diffInMinutes($post->created_at)<5)
        <div class="alert alert-info">
            <h3>New!</h3>
        </div>
    @endif

@endsection

