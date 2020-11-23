@extends('layouts.app')

@section('title', 'Login')
@section('content')
<div class="container apartment-edit col-md-6">


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<h2>Modifica i tuoi appartamenti</h2>
<form action="{{route('apartments.update', $apartment->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
  <div class="form-group">
    <label for="title">Titolo</label>
    <input name="title" type="text" class="form-control" id="title" aria-describedby="emailHelp" value="{{$apartment->title}}">
  </div>
  <div class="form-group">
    <label for="rooms">Camere</label>
    <input name="rooms" type="number" class="form-control" id="rooms" value="{{$apartment->rooms}}">
  </div>
  <div class="form-group">
    <label for="beds">Letti</label>
    <input name="beds" type="number" class="form-control" id="beds" value="{{$apartment->beds}}">
  </div>
  <div class="form-group">
    <label for="bathrooms">Bagni</label>
    <input name="bathrooms" type="number" class="form-control" id="bathrooms" value="{{$apartment->bathrooms}}">
  </div>
  <div class="form-group">
    <label for="square_meters">Dimensione</label>
    <input name="square_meters" type="number" class="form-control" id="square_meters" value="{{$apartment->square_meters}}">
  </div>
  <div class="form-group">
    <label for="description">Descrizione</label>
    <textarea name="description" class="form-control" id="description" rows="3">{{$apartment->description}}"</textarea>
  </div>
  <div class="form-group">
    <label for="latitude">Latitudine</label>
    <input name="latitude" type="number" class="form-control" id="latitude" value="{{$apartment->latitude}}">
  </div>
  <div class="form-group">
    <label for="longitude">Longitudine</label>
    <input name="longitude" type="number" class="form-control" id="longitude" value="{{$apartment->longitude}}">
  </div>
  <div class="form-group">
    <label for="image">Foto</label>
    <input src="{{ asset('storage/'. $apartment->image) }}" type="file" class="form-control-file" id="image" name="image" accept="image/*">
  </div>
  <div class="form-group">
      {{-- MODIFICA "disponibile?" --}}
    <label for="available">Disponibile?</label>
    <input name="available" type="checkbox" id="available" name="available"
        {{old('available') ? 'checked' : ''}}>
  </div>
  <button type="submit" class="btn bool-btn-pink">Salva</button>
</form>
</div>
@endsection
