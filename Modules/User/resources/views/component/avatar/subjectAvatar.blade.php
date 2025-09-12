<div class="avatar @isset($class){{$class}}@endisset"
     onclick="openList(this)" @isset($action){{$action}}@endisset>
    @if($subject->avatar)
        <img class="pointer-events-none" src="{{imgUrlMaker2($subject,'avatar')}}"
             alt="{{$subject->name}}">
    @else
        <img class="pointer-events-none" src="{{asset('assets/img/default.png')}}" alt="img/default.png">
    @endif

</div>
