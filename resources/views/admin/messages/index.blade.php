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
        

      </div>
    @endforeach
  </tbody>
  </table>
@endforeach

@endsection
