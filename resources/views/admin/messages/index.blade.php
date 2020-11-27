@extends('layouts.app')

@section('title', 'Lista messaggi')
@section('content')
    <div class="container messages-index">
        <h2>I tuoi messaggi</h2>

@foreach ($apartments as $apartment)
        <table class="table table-bordered">
            <h3>{{$apartment->title}}</h3>
            <tbody>
                <thead>
                    <tr>
                        <th scope="col">Titolo</th>
                        <th scope="col">Mittente</th>
                        <th scope="col">Messaggio</th>
                    </tr>
                    @foreach ($apartment->messages as $message)
                        <tr>
                            <td><a href="{{route('messages.show', $message->id)}}">{{$message->title}}</a></td>
                            <td>{{$message->email}}</td>
                            <td>{{$message->body}}</td>
                        </tr>
                    @endforeach
                </thead>
            </tbody>
        </table>
@endforeach
    </div>
@endsection
