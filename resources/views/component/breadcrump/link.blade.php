<a href="{{$link}}"
   class="breadcrumb_item p-2 px-4 lg:p-1.5 lg:px-3 card_cwc flex items-center skew-x-[-21deg]  cursor-pointer">
    <div class="skew-x-[21deg] flex items-center gap-2">
        @if(isset($icon))
            <div class="icon-fsm">
                @include('component.icon.'.$icon,['strock' => 2.3])
            </div>
        @endif
        <div class="font-semibold translate-y-0.5 max-w-14 truncate text-fsm">
            {{$title}}
        </div>
    </div>
</a>
