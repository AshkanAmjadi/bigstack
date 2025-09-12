<a  class="navLink @if($list->parent_id != 0) p-2  @endif w-full font-semibold @isset($class){{$class}}@endisset" @if($list->haveLink())@else href="{{$list->makeLink()}}" @endif>
    @if($list->icon)


    @else
        {{--                    todo pisfarz icon option--}}
{{--        <div class="icon inline">--}}
{{--            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">--}}
{{--                <path fill-rule="evenodd" d="M4.5 7.5a3 3 0 013-3h9a3 3 0 013 3v9a3 3 0 01-3 3h-9a3 3 0 01-3-3v-9z" clip-rule="evenodd" />--}}
{{--            </svg>--}}
{{--        </div>--}}
    @endif
    {{$list->name}}
</a>
