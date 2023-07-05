@foreach($links as $link)
    <div class=links">
        <div>Before: <a href="{{$link["raw_link"]}}">{{$link["raw_link"]}}</a></div>
        <div>After: <a href="{{$link["short_link"]}}">{{$link["short_link"]}}</a></div>
    </div>
@endforeach
