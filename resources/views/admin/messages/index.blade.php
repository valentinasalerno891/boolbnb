@extends('layouts.app')

@section('title', 'Lista messaggi')
@section('content')
    <div class="container messages-index">
        <h2>I tuoi messaggi</h2>

@foreach ($apartments as $apartment)
    <h3>{{$apartment->title}}</h3>
    @isset($apartment->messages[0])
        <table class="table table-bordered message-desktop">
            <tbody>
                <thead>
                    <tr>
                        <th scope="col">Oggetto</th>
                        <th scope="col">Mittente</th>
                        <th scope="col">Messaggio</th>
                    </tr>
                    @foreach ($apartment->messages as $message)
                        <tr>
                            <td><a href="{{route('messages.show', $message->id)}}">{{$message->title}}</a></td>
                            <td><a href="mailto:{{$message->email}}">{{$message->email}}</a></td>
                            <td>{{$message->body}}</td>
                        </tr>
                    @endforeach
                </thead>
            </tbody>
        </table>
        <table class="table table-bordered message-mobile">
            <tbody>
                <thead>
                    <tr>
                        <th scope="col">Oggetto</th>
                    </tr>
                    @foreach ($apartment->messages as $message)
                        <tr>
                            <td><a href="{{route('messages.show', $message->id)}}">{{$message->title}}</a></td>
                        </tr>
                    @endforeach
                </thead>
            </tbody>
        </table>

    @else <p>Nessun messaggio presente</p>
    @endisset

@endforeach
    </div>
@endsection
