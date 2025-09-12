@php
    if (!isset($noChild)){
            $noChild = false;
        }
@endphp

<div class="head flex gap-2 mb-2 justify-between items-center @if($list->haveLink()) open-box @endif">

    <a
            @if($list->haveLink())@else href="{{$list->makeLink()}}" @endif
    class="flex w-full items-center gap-2 text-mid font-medium p-2.5">
        @if($list->icon)


        @else
{{--                                todo pisfarz icon option--}}
            <div class="icon inline">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.5 7.5a3 3 0 013-3h9a3 3 0 013 3v9a3 3 0 01-3 3h-9a3 3 0 01-3-3v-9z"
                          clip-rule="evenodd"/>
                </svg>
            </div>
        @endif
        {{$list->name}}
    </a>

    @if(!$noChild)
        @if($list->child->count())
            <div class="icon @if(!$list->haveLink()) open-box @endif p-2.5 DLL rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16.5 8.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v8.25A2.25 2.25 0 006 16.5h2.25m8.25-8.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-7.5A2.25 2.25 0 018.25 18v-1.5m8.25-8.25h-6a2.25 2.25 0 00-2.25 2.25v6"></path>
                </svg>
            </div>
        @endif
    @endif

</div>
