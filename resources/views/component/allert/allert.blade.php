
@php
    if (!isset($color)){
        $color = 'rose';
    }
    if (!isset($icon)){
        $icon = false;
    }
    if (!isset($closeAction)){
        $closeAction = false;
    }
    if (!isset($closeBtn)){
    $closeBtn = true;
}
@endphp
<div class="allert group text-{{$color}}-500 bg-{{$color}}-500/10 hover:bg-{{$color}}-500/100 inline-block rounded-md border-{{$color}}-500 focus:bg-{{$color}}-600 focus:border-{{$color}}-600 focus:ring-2 focus:ring-{{$color}}-600 focus:ring-offset-2 focus:text-slate-50 hover:text-slate-50" @isset($action){{$action}}@endisset>
    <div class="content flex flex-wrap gap-3 items-center">
        @isset($mainIcon)
            {{$mainIcon}}
        @endisset
        <div class="text-smid md:text-lg font-semibold hyphens-auto ">
            @isset($title)
                {{$title}}
            @endisset
        </div>
    </div>
    @if($closeBtn)

    <div class="close bg-{{$color}}-200/70 dark:bg-{{$color}}-200/20 group-hover:bg-slate-100/20 cursor-pointer p-1 rounded-md dark:text-slate-50" @if($closeAction) {{$closeAction}} @else onclick="clossAllert(this)" @endif >
        @if($icon)
            {{$icon}}
        @else
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        @endif

    </div>
    @endif

</div>
