@php
    if (!isset($position)){
        $position = 'top';
    }
@endphp

<div class="dropdown pop bg-slate-700 dark:bg-slate-100 dark:text-slate-700" data-position="{{$position}}">

    @isset($title)
        <div class="text-sm font-semibold block">{{$title}}</div>
    @endisset
    @isset($text)
        <div class="text-fsm font-light block">
            {{$text}}
        </div>
    @endisset

    @isset($btns)
        <div class="btns">
            {{$btns}}
        </div>
    @endisset



    {{$slot}}
</div>
