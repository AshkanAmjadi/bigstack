@php
    if (!isset($color)){
        $color = 'blue';
    }
    if (!isset($w_full)){
        $w_full = false;
    }
    if (!isset($shadow)){
        $shadow = true;
    }
    if (!isset($nofollow)){
        $nofollow = false;
    }
@endphp
<a href="@isset($href){{$href}}@endisset" @if($nofollow) rel="nofollow" @endif
   class="btn @isset($size){{$size}}@endisset @if($w_full) !w-full @endif @if($shadow) shadow-md shadow-{{$color}}-200 dark:shadow-{{$color}}-500/60 hover:shadow-lg hover:shadow-{{$color}}-200 dark:hover:shadow-{{$color}}-700 @endif bg-{{$color}}-500 text-slate-50 hover:bg-{{$color}}-400 inline-block rounded-md focus:shadow-none focus:bg-{{$color}}-600 focus:ring-2 focus:ring-{{$color}}-600 focus:ring-offset-2 @isset($class){{$class}}@endisset"
@isset($data_attr)
    {{$data_attr}}
    @endisset
@isset($action)
    {{$action}}
    @endisset>
    @isset($title)
        <div class="inline @isset($bold) font-bold @endisset">
            {{$title}}
        </div>
    @endisset

    @isset($icon)
        <div class="@isset($iconsize) icon-{{$iconsize}} @else icon @endisset">
            {{$icon}}
        </div>
    @endisset

    @isset($preTitle)
        <div class="inline @isset($bold) font-bold @endisset">
            {{$preTitle}}
        </div>
    @endisset

    {{$slot}}
</a>
