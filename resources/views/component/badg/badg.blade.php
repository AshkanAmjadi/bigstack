
@php
    if (!isset($color)){
        $color = 'blue';
    }
    if (!isset($shadow)){
        $shadow = true;
    }
@endphp
<div
    class="badg @if($shadow) shadow-md  shadow-{{$color}}-200 dark:shadow-{{$color}}-500/60 hover:shadow-lg hover:shadow-{{$color}}-200 dark:hover:shadow-{{$color}}-700 @endif bg-{{$color}}-500 text-slate-50 hover:bg-{{$color}}-400 inline-block rounded-md md:rounded @isset($class){{$class}} @endisset">
    <div class="inline">
        @isset($title)
            {{$title}}
        @endisset
    </div>
</div>
