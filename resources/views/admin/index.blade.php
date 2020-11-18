@extends('layouts.app')

@section('title', 'Login')
@section('content')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<div class="container apartments-index">
  <h2>Benvenuto,ecco la lista dei tuoi appartamenti</h2>
  <table class="table table-bordered">
  <tbody>

@foreach ($apartments as $apartment)


    <tr>

      <td><a href="{{route('apartments.show',$apartment->id)}}">{{$apartment->title}}</a></td>
      <td>{{$apartment->rooms}} stanze in questo appartamento</td>
      <td ><a class="edit" href="{{route('apartments.edit',$apartment->id)}}">Modifica</a></td>
      <td><form action="{{route('apartments.destroy',$apartment->id)}}" method="post">
          @csrf
          @method('DELETE')
          <button class="delete"type="submit">Elimina</button>
      </form></td>
    </tr>

@endforeach
  </tbody>
  </table>
</div>
@endsection
