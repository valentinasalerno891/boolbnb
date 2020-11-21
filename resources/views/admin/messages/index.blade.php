@extends('layouts.app')

@section('title', 'Login')
@section('content')
  <div class="container messages-index">
    <h2>I tuoi appartamenti hanno ricevuto questi messaggi</h2>

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
      <td>{{$message->title}}</td>
      <td>{{$message->email}}</td>
      <td>{{$message->body}}</td>
     </tr>


      </div>
    @endforeach
    </thead>
  </tbody>
  </table>
@endforeach

@endsection
