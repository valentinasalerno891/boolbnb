@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<ul>
        <li>{{$apartment->title}}</li>
        <li>{{$apartment->rooms}}</li>
</ul>
<form action="{{route('messages.store',$apartment->id)}}" method="post">
        @csrf
        @method('POST')
      <div class="form-group">
        <label for="email">Email</label>
        <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Inserisci la tua email">
      </div>
      <div class="form-group">
        <label for="title">Oggetto</label>
        <input name="title" type="text" class="form-control" id="title" placeholder="Inserisci il titolo">
      </div>
      <div class="form-group">
        <label for="body">Messaggio</label>
        <input name="body" type="text" class="form-control" id="body" placeholder="Inserisci il messaggio">
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
