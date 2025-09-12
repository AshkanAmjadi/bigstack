<div>

    <div class="flexBC gap-3 mb-8">
        <div id="articles" class="flex mt-2 gap-3 items-center mb-3 md:mt-0">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="icon-xl" style="color: var(--accent-color)"
                     viewBox="0 0 24 24">
                    <g fill="none" stroke="currentColor" stroke-width="1.5">
                        <path
                            d="M16 4.002c2.175.012 3.353.109 4.121.877C21 5.758 21 7.172 21 10v6c0 2.829 0 4.243-.879 5.122C19.243 22 17.828 22 15 22H9c-2.828 0-4.243 0-5.121-.878C3 20.242 3 18.829 3 16v-6c0-2.828 0-4.242.879-5.121c.768-.768 1.946-.865 4.121-.877"
                            opacity=".5"/>
                        <path stroke-linecap="round" d="M10.5 14H17M7 14h.5M7 10.5h.5m-.5 7h.5m3-7H17m-6.5 7H17"/>
                        <path
                            d="M8 3.5A1.5 1.5 0 0 1 9.5 2h5A1.5 1.5 0 0 1 16 3.5v1A1.5 1.5 0 0 1 14.5 6h-5A1.5 1.5 0 0 1 8 4.5v-1Z"/>
                    </g>
                </svg>
            </div>

            <h3 class="text-elg font-bold translate-y-0.5">
                Articles
            </h3>
        </div>
        <div class="filters flexC gap-3 md:w-full md:gap-2 md:justify-center">
            <div tabindex="1" id="time" class="haveDrop relative text-smid font-bold flex items-center card_c rounded-md p-3 md:p-2">
                Time
                <div class="text-fsm opacity-75">({{$times[$time]}})</div>
                @component('component.divider.hDivider' ,['class' => 'h-6'])

                @endcomponent

                <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm" width="24" height="24" viewBox="0 0 24 24">
                    <g fill="none">
                        <path stroke="currentColor" stroke-width="2"
                              d="M2 12c0-3.771 0-5.657 1.172-6.828C4.343 4 6.229 4 10 4h4c3.771 0 5.657 0 6.828 1.172C22 6.343 22 8.229 22 12v2c0 3.771 0 5.657-1.172 6.828C19.657 22 17.771 22 14 22h-4c-3.771 0-5.657 0-6.828-1.172C2 19.657 2 17.771 2 14z"/>
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5"
                              d="M7 4V2.5M17 4V2.5M2.5 9h19" opacity=".5"/>
                        <path fill="currentColor"
                              d="M18 17a1 1 0 1 1-2 0a1 1 0 0 1 2 0m0-4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m-5 4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m0-4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m-5 4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m0-4a1 1 0 1 1-2 0a1 1 0 0 1 2 0"/>
                    </g>
                </svg>
                <div class="drop shadow-md absolute w-56 top-full-smaler-1 rounded-md p-2 card_c shadow-custom_gray_sm font-medium z-10 transall left-0 md:right-0 "
                    onclick="blurId('time')">
                    <div wire:loading.remove>
                        @foreach($times as $timeItem  => $name)
                            <div wire:click="setTime('{{$timeItem}}')"
                                class="flex items-center text-sm gap-2 p-2 hoverEffect rounded-md">
                                {{$name}}

                                @if($timeItem == $time)
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
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center">
                        {{--    todo component the loading--}}

                        <div wire:loading class="loading py-10">
                            <svg class="inline animate-spin !h-10 !w-10 text-teal-500"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div tabindex="1" id="type" class="haveDrop relative text-smid font-bold flex items-center card_c rounded-md p-3 md:p-2">
                Filter

                <div class="text-fsm opacity-75">({{$types[$type]}})</div>

                @component('component.divider.hDivider' ,['class' => 'h-6'])

                @endcomponent

                <svg xmlns="http://www.w3.org/2000/svg" width="24" class="icon-sm" height="24" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"
                          d="M20.058 9.723c.948-.534 1.423-.801 1.682-1.232c.26-.43.26-.949.26-1.987v-.69c0-1.326 0-1.99-.44-2.402C21.122 3 20.415 3 19 3H5c-1.414 0-2.121 0-2.56.412C2 3.824 2 4.488 2 5.815v.69c0 1.037 0 1.556.26 1.986c.26.43.733.698 1.682 1.232l2.913 1.64c.636.358.955.537 1.183.735c.474.411.766.895.898 1.49c.064.284.064.618.064 1.285v2.67c0 .909 0 1.364.252 1.718c.252.355.7.53 1.594.88c1.879.734 2.818 1.101 3.486.683c.668-.417.668-1.372.668-3.282v-2.67c0-.666 0-1 .064-1.285a2.68 2.68 0 0 1 .899-1.49"/>
                </svg>
                <div class="drop shadow-md absolute w-56 top-full-smaler-1 rounded-md p-2 card_c shadow-custom_gray_sm font-medium z-10 transall left-0"
                    onclick="blurId('type')">
                    <div wire:loading.remove>
                        @foreach($types as  $tipeItem => $name )
                            <div wire:click="setType('{{$tipeItem}}')"
                                class="flex gap-2 items-center text-sm p-2 hoverEffect rounded-md">
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
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center">
                        {{--    todo component the loading--}}

                        <div wire:loading class="loading py-10">
                            <svg class="inline animate-spin !h-10 !w-10 text-teal-500"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="grid grid-cols-3 2xl:grid-cols-2 1.5xl:gap-x-3  gap-7 sm:grid-cols-1" {{--wire:loading.remove--}}>
        @forelse($items as $item)
            @livewire('content::category.item',['subject' => $item],key($item->getTable().$item->id))
        @empty
            <div class="text-elg card_c py-20 text-center col-span-3">
                <div class="font-extrabold mb-6">
                    No items found!!!
                </div>
                <div class="icon-xl w-full flex justify-center text-rose-600 mt-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor"
                              d="M22 12v7.206a1.727 1.727 0 0 1-2.5 1.544a2.891 2.891 0 0 0-2.896.18a2.892 2.892 0 0 1-3.208 0l-.353-.234a1.881 1.881 0 0 0-2.086 0l-.353.235a2.892 2.892 0 0 1-3.208 0a2.891 2.891 0 0 0-2.897-.18A1.727 1.727 0 0 1 2 19.205V12C2 6.477 6.477 2 12 2s10 4.477 10 10Z"
                              opacity=".5"/>
                        <path fill="currentColor"
                              d="M9.447 14.398a.75.75 0 1 0-.894 1.204A5.766 5.766 0 0 0 12 16.75a5.766 5.766 0 0 0 3.447-1.148a.75.75 0 1 0-.894-1.204A4.267 4.267 0 0 1 12 15.25a4.267 4.267 0 0 1-2.553-.852ZM16 9.5c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5s.448-1.5 1-1.5s1 .672 1 1.5ZM9 11c.552 0 1-.672 1-1.5S9.552 8 9 8s-1 .672-1 1.5s.448 1.5 1 1.5Z"/>
                    </svg>
                </div>
            </div>
        @endforelse
    </div>
    <div class="flexCC py-3" wire:loading.remove>
        @include('component.pagination.livePagination',['list' => $items,'href'=>''])
    </div>
    <div class="flexCC">
        @component('component.loading.fullPage',[])

        @endcomponent
    </div>
</div>
