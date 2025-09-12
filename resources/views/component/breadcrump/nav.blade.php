<nav>
    <ul class="breadcrumb flex items-center flex-wrap gap-y-3">

        <li class="">
            <a href="{{route('home')}}"
               class="breadcrumb_item p-2 px-4 lg:p-1.5 lg:px-3 card_cwc flex items-center skew-x-[-21deg] mr-2 cursor-pointer">
                <div class="skew-x-[21deg] flex items-center gap-2">
                    <div class="icon-fsm">
                        @include('component.icon.home',['strock' => 2.3])
                    </div>
                </div>
            </a>
        </li>
        @if(isset($items))
            @foreach($items as $item)
                <li class="">
                    <a href="{{route($item->getTable().'.show',[$item->getTable() => $item->slug])}}"
                       class="breadcrumb_item p-2 px-4 lg:p-1.5 lg:px-3 card_cwc flex items-center skew-x-[-21deg] mr-3 cursor-pointer">
                        <div class="skew-x-[21deg] flex items-center gap-2">
                            <div class="icon-fsm">
                                @include('component.icon.'.$item->getTable(),['strock' => 2.3])
                            </div>
                            <div class="font-semibold translate-y-0.5 max-w-14 truncate text-fsm">
                                {{$item->title}}
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        @endif
        @if(isset($manuals))

            @foreach($manuals as $manual)
                <li class="">
                    <a href="{{$manual['link']}}"
                       class="breadcrumb_item p-2 px-4 lg:p-1.5 lg:px-3 card_cwc flex items-center skew-x-[-21deg] mr-3 cursor-pointer">
                        <div class="skew-x-[21deg] flex items-center gap-2">
                            @if(isset($manual['icon']))
                                <div class="icon-fsm">
                                    @include('component.icon.'.$manual['icon'],['strock' => 2.3])
                                </div>
                            @endif
                            <div class="font-semibold translate-y-0.5 text-fsm">
                                {{$manual['title']}}
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach

        @endif
        @if(isset($manual))
            <li class="">
                <a href="{{$manual['link']}}"
                   class="breadcrumb_item p-2 px-4 lg:p-1.5 lg:px-3 card_cwc flex items-center skew-x-[-21deg] mr-3 cursor-pointer">
                    <div class="skew-x-[21deg] flex items-center gap-2">
                        @if(isset($manual['icon']))
                            <div class="icon-fsm">
                                @include('component.icon.'.$manual['icon'],['strock' => 2.3])
                            </div>
                        @endif
                        <div class="font-semibold translate-y-0.5 text-fsm">
                            {{$manual['title']}}
                        </div>
                    </div>
                </a>
            </li>
        @endif


    </ul>
</nav>
