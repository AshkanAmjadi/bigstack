
@php
    $right = isset($right) ?? $right
@endphp

<div id="sidebarOverley" class="fixed {{$name}} hide left-0 top-0 h-full w-full bg-slate-800 opacity-60 z-50"
     onclick="sidebar('hide','{{$name}}')">

</div>
<div id="sidebar" class="fixed {{$name}} hide @if($right) right-0 @else left-0 @endif top-0 h-full w-200 lg:w-3/4 md:w-full z-50 p-3">
    <div class="wraper w-full h-full card_c overflow-y-auto p-3">
        {{$slot}}
    </div>
</div>
