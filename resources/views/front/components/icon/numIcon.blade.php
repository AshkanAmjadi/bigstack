@php
    if (!isset($color)){
        $color = 'blue';
    }
    if (!isset($iconSize)){
        $iconSize = 'md';
    }
@endphp
<div class="mark flex items-center gap-1 text-{{$color}}-500 cursor-pointer p-1">

    @isset($number)
    <div class="text-sm font-black">
        {{$number}}
    </div>
    @endif

    <div class="icon-{{$iconSize}}">
        {{$slot}}
    </div>
    @isset($text)
        <div class="text-sm font-black">
            {{$text}}
        </div>
    @endif


</div>
