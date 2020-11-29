@extends('layouts.app')

@section('title', $message->title)
@section('content')
    <div class="container">
        <h2>{{$message->title}}</h2>
        <small>{{$message->created_at}} {{$message->hour}}</small>
        <p>{{$message->email}}</p>
        <p>{{$message->body}}</p>
    </div>

@endsection
