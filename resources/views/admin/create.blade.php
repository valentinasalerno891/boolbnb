@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{route('apartments.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('POST')
  <div class="form-group">
    <label for="title">Titolo</label>
    <input name="title" type="text" class="form-control" id="title" aria-describedby="emailHelp" placeholder="Inserisci titolo appartamento">
  </div>
  <div class="form-group">
    <label for="rooms">Camere</label>
    <input name="rooms" type="number" class="form-control" id="rooms" placeholder="Numero camere">
  </div>
  <div class="form-group">
    <label for="beds">Letti</label>
    <input name="beds" type="number" class="form-control" id="beds" placeholder="Numero letti">
  </div>
  <div class="form-group">
    <label for="bathrooms">Bagni</label>
    <input name="bathrooms" type="number" class="form-control" id="bathrooms" placeholder="Numero bagni">
  </div>
  <div class="form-group">
    <label for="square_meters">Dimensione</label>
    <input name="square_meters" type="number" class="form-control" id="square_meters" placeholder="Metri quadrati">
  </div>
  <div class="form-group">
    <label for="description">Descrizione</label>
    <textarea name="description" class="form-control" id="description" rows="3"></textarea>
  </div>
  <div class="form-group">
    <label for="latitude">Latitudine</label>
    <input name="latitude" type="number" class="form-control" id="latitude" placeholder="Latitudine">
  </div>
  <div class="form-group">
    <label for="longitude">Longitudine</label>
    <input name="longitude" type="number" class="form-control" id="longitude" placeholder="Longitudine">
  </div>
  <div class="form-group">
    <label for="image">Foto</label>
    <input name="image" type="file" class="form-control" id="image" name="img" accept="image/*">
  </div>
  <div class="form-group form-check">
    <label for="available">Disponibile?</label>
    <input name="available" type="checkbox" class="form-control" id="available" name="available">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>