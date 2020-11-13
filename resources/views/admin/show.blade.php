<ul>
        <li>{{$apartment->title}}</li>
        <li>{{$apartment->rooms}}</li>
        @if ($apartment->user_id == Auth::id())
          <li><a href="{{route('apartments.edit',$apartment->id)}}">Modifica</a></li>
          <li><a href="{{route('stats.show',$apartment->id)}}">Statistiche</a></li>
          <li>
            <form action="{{route('apartments.destroy',$apartment->id)}}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </li>
        @endif

</ul>

@if ($apartment->user_id != Auth::id()) 
  @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
  @endif
  <form action="{{route('messages.store',$apartment->id)}}" method="post">
      @csrf
      @method('POST')
    <div class="form-group">
      <label for="email">Email</label>
      @auth
        <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Inserisci la tua email" value="{{Auth::user()->email}}">
      @endauth
      @guest
          <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Inserisci la tua email">
      @endguest
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
@endif

