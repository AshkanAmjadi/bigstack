@php
    if (!isset($color)){
        $color = 'blue';
    }
@endphp
<button id="@isset($id){{$id}}@endisset"
        class="btn shadow-md shadow-{{$color}}-200 dark:shadow-{{$color}}-500/60 hover:shadow-lg hover:shadow-{{$color}}-200 dark:hover:shadow-{{$color}}-700 bg-{{$color}}-500 text-slate-50 hover:bg-{{$color}}-400 inline-block rounded-md focus:shadow-none focus:bg-{{$color}}-600 focus:ring-2 focus:ring-{{$color}}-600 focus:ring-offset-2 "
@isset($data_attr){{$data_attr}}@endisset
@isset($action){{$action}}@endisset>
    <div class="inline">
        @isset($title)
            {{$title}}
        @endisset
    </div>
    @isset($icon)

        <div class="icon">
            {{$icon}}

        </div>
    @endisset

    {{$slot}}

</button>
