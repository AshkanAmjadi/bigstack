
<div class="avatar @isset($class){{$class}}@endisset"
     onclick="openList(this)" @isset($action){{$action}}@endisset>
    @isset($image)
        {{$image}}
    @else
        <img class="pointer-events-none" src="{{asset('assets/img/default.png')}}" alt="img/default.png">
    @endisset

</div>
