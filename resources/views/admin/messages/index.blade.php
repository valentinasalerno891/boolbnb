@extends('layouts.app')

@section('title', 'Login')
@section('content')
  <div class="container messages-index">
    <h2>Hai ricevuto questi messaggi per i tuoi appartamenti</h2>

@foreach ($apartments as $apartment)
  <table class="table table-bordered">
  <tbody>
    <h3>{{$apartment->title}}</h3>
    @foreach ($apartment->messages as $message)

     <tr>
      <td>{{$message->title}}</td>
      <td>{{$message->email}}</td>
      <td>{{$message->body}}</td>
     </tr>
        {{-- <ul>
            <li><a href="{{ route('message.show',$message->id) }}">{{$message->title}}</a></li>
            <li>{{$message->email}}</li>
        </ul> --}}

      </div>
    @endforeach
  </tbody>
  </table>
@endforeach

@endsection
