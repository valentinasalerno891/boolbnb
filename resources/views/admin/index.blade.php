@extends('layouts.app')

@section('title', 'Login')
@section('content')

<div class="container apartments-index col-md-8">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
  <h2>Benvenuto, ecco i tuoi appartamenti</h2>
  <table class="table table-bordered">

      <tbody>



@foreach ($apartments as $apartment)


    <tr>

      <td><a class="apartment-title" href="{{route('apartments.show',$apartment->id)}}">{{$apartment->title}}</a></td>
      <td>{{$apartment->rooms}} stanze in questo appartamento</td>
      <td class="edit-delete-action"><a class="edit" href="{{route('apartments.edit',$apartment->id)}}">Modifica</a></td>
      <td class="edit-delete-action"><form action="{{route('apartments.destroy',$apartment->id)}}" method="post">
          @csrf
          @method('DELETE')
          <button class="btn bool-btn-pink" type="submit">Elimina</button>
      </form></td>
    </tr>

@endforeach

  </tbody>
  </table>
</div>
@endsection
