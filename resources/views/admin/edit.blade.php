@extends('layouts.app')

@section('title', 'Modifica un appartamento')
@section('content')
<div class="container apartment-edit">


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<h2>Modifica "{{$apartment->title}}"</h2>
<form id="myForm" action="{{route('apartments.update', $apartment->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
  <div class="form-group">
    <label for="title">Titolo</label>
    <input name="title" type="text" class="form-control" id="title" aria-describedby="emailHelp" value="{{($errors->any()) ? old('title') : $apartment->title}}">
  </div>
  <div class="form-group">
    <label for="rooms">Camere</label>
    <input min="0" oninput="validity.valid||(value='');" name="rooms" type="number" class="form-control" id="rooms" value="{{($errors->any()) ? old('rooms') : $apartment->rooms}}">
  </div>
  <div class="form-group">
    <label for="beds">Letti</label>
    <input min="1" oninput="validity.valid||(value='');" name="beds" type="number" class="form-control" id="beds" value="{{($errors->any()) ? old('beds') : $apartment->beds}}">
  </div>
  <div class="form-group">
    <label for="bathrooms">Bagni</label>
    <input min="1" oninput="validity.valid||(value='');" name="bathrooms" type="number" class="form-control" id="bathrooms" value="{{($errors->any()) ? old('bathrooms') : $apartment->bathrooms}}">
  </div>
  <div class="form-group">
    <label for="square_meters">Dimensione</label>
    <input min="0" oninput="validity.valid||(value='');" name="square_meters" type="number" class="form-control" id="square_meters" value="{{($errors->any()) ? old('square_meters') : $apartment->square_meters}}">
  </div>
  <div class="form-group">
    <label for="description">Descrizione</label>
    <textarea name="description" class="form-control" id="description" rows="3">{{($errors->any()) ? old('description') : $apartment->description}}</textarea>
  </div>
  <div class="form-group">
    <label for="city">Città</label>
    <input required name="city" class="form-control" id="city" placeholder="Città" value="{{($errors->any()) ? old('city') : $apartment->city}}">
  </div>
  <div class="form-group">
    <input name="latitude" hidden class="form-control" id="latitude" placeholder="Latitudine" value="{{($errors->any()) ? old('latitude') : $apartment->latitude}}">
  </div>
  <div class="form-group">
    <input name="longitude" hidden class="form-control" id="longitude" placeholder="Longitudine" value="{{($errors->any()) ? old('longitude') : $apartment->longitude}}">
  </div>
  <div class="form-group">
    <label for="image">Foto</label>
    <input src="{{ asset('storage/'. $apartment->image) }}" type="file" class="form-control-file" id="image" name="image" accept="image/*">
    <img class="img-fluid pt-3" src="{{Storage::url($apartment->image)}}" alt="apartment-image">
  </div>
  <div class="form-group">
      {{-- MODIFICA "disponibile?" --}}
    <label for="available">Disponibile?</label>
    <input name="available" type="checkbox" id="available" name="available"
    {{$apartment->available ? 'checked' : ''}}
                @if (old('public'))
                    checked
                @endif>
  </div>

{{-- Inserimento categoria --}}
    <div class="form-group">
        <label for="category_id">Categoria</label>
        <select name="category_id" id="category_id">

            @foreach ($categories as $category)
                @if ($errors->any())
                    @if ($category->id == old('category_id') || $apartment->category_id == $category->id)
                        <option value="{{$category->id}}" selected>{{$category->name}}</option>
                    @else
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endif
                @else
                    @if ($apartment->category_id == $category->id)
                        <option value="{{$category->id}}" selected>{{$category->name}}</option>
                    @else
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endif
                @endif
            @endforeach
        </select>
    </div>

{{-- Inserimento servizi --}}
    <div class="form-group">
        @foreach ($services as $service)
            <label class="service" for="{{$service->name}}">{{$service->name}} <input type="checkbox" name="services[{{$service->id}}]" value="{{$service->id}}" id="{{$service->name}}" {{$apartment->services->contains($service->id) ? 'checked' : ''}}
              @if (is_array(old('services')) && in_array($service->id, array_keys(old('services'))))
                checked
              @endif></label>

        @endforeach
    </div>
  <div id="error" style="display: none" class="alert alert-danger">
        <ul>
          <li>Inserire una città valida</li>
        </ul>
  </div>
  <button id="myButton" type="button" class="btn bool-btn-pink">Salva</button>
  {{-- <button type="submit" class="btn bool-btn-pink">Salva</button> --}}
</form>
</div>
@endsection
@section('script')
  <script src="{{asset('js/getCoordinates.js')}}"></script>
@endsection
