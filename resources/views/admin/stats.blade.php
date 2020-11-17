<ul>
    @foreach ($views as $view)
        <li>{{$view->created_at}}</li>
    @endforeach
</ul>

<ul>
    @foreach ($messages as $message)
        <li>{{$message->apartment_id}}</li>
        <li>{{$message->title}}</li>
    @endforeach
</ul>


