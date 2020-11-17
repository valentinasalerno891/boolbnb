@foreach ($apartments as $apartment)
    <h1>{{$apartment->title}}</h1>
    @foreach ($apartment->messages as $message)
        <ul>
            <li><a href="{{ route('message.show',$message->id) }}">{{$message->title}}</a></li>
            <li>{{$message->email}}</li>
        </ul>
    @endforeach
@endforeach