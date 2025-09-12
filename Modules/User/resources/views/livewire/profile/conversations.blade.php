<div class="wraper w-full mt-5">
    <div id="refreshCons" wire:click="refresh"></div>
    <div class="filters flexC gap-3 md:w-full md:gap-2 md:justify-center">

        <div tabindex="1" id="type"
             class="haveDrop relative text-smid font-bold flexBC card_c rounded-md p-3.5 w-80 min-w-[250px] ">
            <div class="flexC gap-2">
                <div class="icon-md">
                    @component('component.icon.'.$type,[])
                    @endcomponent
                </div>
                {{$types[$type]}}
            </div>


            <div class="flexC gap-2">
                @component('component.divider.hDivider' ,['class' => 'h-8'])

                @endcomponent
                <div class="icon-md">
                    @component('component.icon.arrowDown',[])
                    @endcomponent
                </div>
            </div>
            <ul class="drop shadow-md absolute w-full top-full-smaler-1 rounded-md p-2 card_c shadow-custom_gray_sm font-medium z-10 transall right-0"
                onclick="blurId('type')">
                <div wire:loading.remove>
                    @foreach($types as  $tipeItem => $name )
                        <li wire:click="setType('{{$tipeItem}}')"
                            class="flex gap-2 items-center text-smid p-3 hoverEffect rounded-md font-semibold">
                            <div class="icon-md">
                                @component('component.icon.'.$tipeItem,[])
                                @endcomponent
                            </div>
                            {{$name}}
                            @if($tipeItem == $type)
                                <div class="icon bg-blue-400 rounded-md p-0.5 ml-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-white icon-sm" width="24"
                                         height="24" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                              d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22"
                                              opacity=".5"/>
                                        <path fill="currentColor"
                                              d="M16.03 8.97a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0"/>
                                    </svg>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </div>

                <div class="text-center">
                    {{--    todo component the loading--}}

                    <li wire:loading class="loading py-10">
                        @include('component.loading.loading')
                    </li>
                </div>
            </ul>
        </div>

    </div>


    <div class="grid grid-cols-3 2xl:grid-cols-3 1.5xl:gap-x-3 lg:grid-cols-2 gap-7 sm:grid-cols-1 mt-5">

        @forelse($items as $item)
            @if($type == 'discuss')
                <div class="col-span-3">
                    @include('user::component.profileItems.profileCon',['want' => 'answers','subject' => $item])
                </div>
            @elseif($type == 'answer')
                <div class="col-span-3">
                    @include('user::component.profileItems.profileAnswer',['answer' => $item,'my' => true,'usefull' => false])
                </div>
            @endif
        @empty
            @include('component.notFound.notFound')
        @endforelse

    </div>

    {{--    <div class="flexCC py-8">--}}
    {{--        @include('component.pagination.livePagination',['list' => $items,'href'=>''])--}}
    {{--    </div>--}}
    <div class="flexCC">
        @include('component.loading.fullPage')

    </div>
</div>
