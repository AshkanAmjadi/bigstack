@php
    if (!isset($color)){
        $color = 'blue';
    }
    if (!isset($tabindex)){
        $tabindex = false;
    }
    if (!isset($w_full)){
        $w_full = false;
    }
    if (!isset($iconspin)){
        $iconspin = false;
    }
    if (!isset($shadow)){
        $shadow = true;
    }

@endphp
<div @if($tabindex) tabindex="1" @endif id="@isset($id){{$id}}@endisset"
     class="btn @isset($size){{$size}}@endisset @if($w_full) !w-full @endif @if($shadow)  shadow-md shadow-{{$color}}-200 dark:shadow-{{$color}}-500/60 hover:shadow-lg hover:shadow-{{$color}}-200 dark:hover:shadow-{{$color}}-700 @endif bg-{{$color}}-500 text-slate-50 hover:bg-{{$color}}-400 inline-block rounded-md focus:shadow-none focus:bg-{{$color}}-600 focus:ring-2 focus:ring-{{$color}}-600 focus:ring-offset-2 @isset($class){{$class}}@endisset "
@isset($data_attr)
    {{$data_attr}}
    @endisset
@isset($action)
    {{$action}}
    @endisset>
    @isset($title)

        <div class="inline">
            {{$title}}
        </div>
    @endisset

    @isset($icon)

        <div class="@isset($iconsize) icon-{{$iconsize}} @else icon @endisset @if($iconspin) animate-spin @endif">
            {{$icon}}

        </div>
    @endisset

    {{$slot}}
</div>
