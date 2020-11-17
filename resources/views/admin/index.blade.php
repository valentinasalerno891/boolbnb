
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
@foreach ($apartments as $apartment)
    <ul>
        <li><a href="{{route('apartments.show',$apartment->id)}}">{{$apartment->title}}</a></li>
        <li>{{$apartment->rooms}}</li>
        <li><a href="{{route('apartments.edit',$apartment->id)}}">Modifica</a></li>

        <li>
            <form action="{{route('apartments.destroy',$apartment->id)}}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </li>
    </ul>
@endforeach