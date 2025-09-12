@php
$mytact = $this->obj->starTacts->where('user_id',auth()->id())->first()
 @endphp
<div class="card_cwc rounded-xl p-5 flex flex-wrap gap-4 mt-6">
    <div class="w-full flexBC gap-3">
        <div class="r">
            @if(!$mytact)

                <div class="font-extrabold text-amber-400 text-lg  inline-block">
                    Rate this : {{$title}}
                </div>
            @else
                <div class="flex items-center flex-wrap gap-2">
                    <div class="font-bold  text-mid  inline-block">
                        your rate
                    </div>
                    <div>
                        @if($mytact->tact_value == 5)
                            <div class="font-extrabold text-mid inline-block text-amber-400">
                                awesome
                            </div>
                        @elseif($mytact->tact_value == 4)
                            <div class="font-extrabold text-mid inline-block text-green-500">
                                greate
                            </div>
                        @elseif($mytact->tact_value == 3)
                            <div class="font-extrabold text-mid inline-block text-green-400">
                                good
                            </div>
                        @elseif($mytact->tact_value == 2)
                            <div class="font-extrabold text-mid inline-block text-orange-400">
                                bad
                            </div>
                        @elseif($mytact->tact_value == 1)
                            <div class="font-extrabold text-mid inline-block text-rose-600">
                                the worst
                            </div>
                        @endif
                    </div>
                    <div wire:click.debounce.150ms="deleteScore()" >
                        @component('component.btn.btnD',['title' => 'delete','color'=>'rose','size' => 'sm'])

                        @endcomponent
                    </div>
                </div>
            @endif

        </div>
        <div class="l flex items-center gap-2">


            <div class="icon-sm text-amber-400 -translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="currentColor"
                          d="M9.153 5.408C10.42 3.136 11.053 2 12 2c.947 0 1.58 1.136 2.847 3.408l.328.588c.36.646.54.969.82 1.182c.28.213.63.292 1.33.45l.636.144c2.46.557 3.689.835 3.982 1.776c.292.94-.546 1.921-2.223 3.882l-.434.507c-.476.557-.715.836-.822 1.18c-.107.345-.071.717.001 1.46l.066.677c.253 2.617.38 3.925-.386 4.506c-.766.582-1.918.051-4.22-1.009l-.597-.274c-.654-.302-.981-.452-1.328-.452c-.347 0-.674.15-1.329.452l-.595.274c-2.303 1.06-3.455 1.59-4.22 1.01c-.767-.582-.64-1.89-.387-4.507l.066-.676c.072-.744.108-1.116 0-1.46c-.106-.345-.345-.624-.821-1.18l-.434-.508c-1.677-1.96-2.515-2.941-2.223-3.882c.293-.941 1.523-1.22 3.983-1.776l.636-.144c.699-.158 1.048-.237 1.329-.45c.28-.213.46-.536.82-1.182l.328-.588Z"/>
                </svg>
            </div>
            <p class="text-smid font-bold">
                {{round($obj->starTacts->avg('tact_value'),1)}}
                -
                ({{$obj->starTacts->count()}})
            </p>
        </div>
    </div>

    @if($tactSaved)
        <div class="success w-full text-elg !bg-amber-500 card_cw py-6 text-center">
            <div class="font-extrabold text-white">
                Your rate has been recorded.
            </div>
            <div class="font-extrabold text-white">
                Thank you, dear user💕
            </div>
            <div class="icon-xl w-full flex justify-center mt-6 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M15.252 10.689c-.987-1.18-1.48-1.77-2.048-1.68c-.567.091-.832.803-1.362 2.227l-.138.368c-.15.405-.226.607-.373.756c-.146.149-.348.228-.75.386l-.367.143c-1.417.555-2.126.833-2.207 1.4c-.08.567.52 1.049 1.721 2.011l.31.25c.342.273.513.41.611.597c.1.187.115.404.146.837l.029.394c.11 1.523.166 2.285.683 2.545c.517.26 1.154-.155 2.427-.983l.329-.215c.362-.235.543-.353.75-.387c.208-.033.42.022.841.132l.385.1c1.485.386 2.228.58 2.629.173c.4-.407.193-1.144-.221-2.62l-.108-.38c-.117-.42-.176-.63-.147-.837c.03-.208.145-.39.374-.756l.21-.332c.807-1.285 1.21-1.927.94-2.438c-.269-.511-1.033-.553-2.562-.635l-.396-.022c-.434-.023-.652-.035-.841-.13c-.19-.095-.33-.263-.61-.599l-.255-.305Z"/><path fill="currentColor" d="M10.331 4.252c1.316-1.574 1.974-2.361 2.73-2.24s1.11 1.07 1.817 2.969l.183.491c.201.54.302.81.497 1.008c.196.199.464.304 1.001.514l.489.192c1.89.74 2.835 1.11 2.942 1.866c.108.757-.693 1.398-2.294 2.682l-.414.332c-.455.365-.683.547-.815.797c-.131.25-.152.538-.194 1.115l-.038.526c-.148 2.031-.222 3.047-.911 3.393c-.69.347-1.538-.206-3.236-1.311l-.439-.286c-.482-.314-.723-.47-1-.515c-.277-.045-.558.028-1.121.175l-.513.133c-1.98.516-2.971.773-3.505.231c-.534-.542-.258-1.526.295-3.492l.142-.509c.157-.559.236-.838.197-1.115c-.04-.277-.193-.52-.499-1.008l-.278-.443C4.29 8.044 3.752 7.187 4.11 6.507c.36-.682 1.379-.737 3.418-.848l.527-.028c.58-.031.869-.047 1.122-.174c.252-.127.439-.35.813-.798l.34-.407Z" opacity=".5"/></svg>
            </div>
        </div>
    @endif
    @if(!$mytact)
        <div class="inline-block text-smid font-bold w-full !text-amber-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block icon-md" width="24" height="24"
                 viewBox="0 0 24 24">
                <path fill="currentColor"
                      d="M15.252 10.689c-.987-1.18-1.48-1.77-2.048-1.68c-.567.091-.832.803-1.362 2.227l-.138.368c-.15.405-.226.607-.373.756c-.146.149-.348.228-.75.386l-.367.143c-1.417.555-2.126.833-2.207 1.4c-.08.567.52 1.049 1.721 2.011l.31.25c.342.273.513.41.611.597c.1.187.115.404.146.837l.029.394c.11 1.523.166 2.285.683 2.545c.517.26 1.154-.155 2.427-.983l.329-.215c.362-.235.543-.353.75-.387c.208-.033.42.022.841.132l.385.1c1.485.386 2.228.58 2.629.173c.4-.407.193-1.144-.221-2.62l-.108-.38c-.117-.42-.176-.63-.147-.837c.03-.208.145-.39.374-.756l.21-.332c.807-1.285 1.21-1.927.94-2.438c-.269-.511-1.033-.553-2.562-.635l-.396-.022c-.434-.023-.652-.035-.841-.13c-.19-.095-.33-.263-.61-.599l-.255-.305Z"/>
                <path fill="currentColor"
                      d="M10.331 4.252c1.316-1.574 1.974-2.361 2.73-2.24s1.11 1.07 1.817 2.969l.183.491c.201.54.302.81.497 1.008c.196.199.464.304 1.001.514l.489.192c1.89.74 2.835 1.11 2.942 1.866c.108.757-.693 1.398-2.294 2.682l-.414.332c-.455.365-.683.547-.815.797c-.131.25-.152.538-.194 1.115l-.038.526c-.148 2.031-.222 3.047-.911 3.393c-.69.347-1.538-.206-3.236-1.311l-.439-.286c-.482-.314-.723-.47-1-.515c-.277-.045-.558.028-1.121.175l-.513.133c-1.98.516-2.971.773-3.505.231c-.534-.542-.258-1.526.295-3.492l.142-.509c.157-.559.236-.838.197-1.115c-.04-.277-.193-.52-.499-1.008l-.278-.443C4.29 8.044 3.752 7.187 4.11 6.507c.36-.682 1.379-.737 3.418-.848l.527-.028c.58-.031.869-.047 1.122-.174c.252-.127.439-.35.813-.798l.34-.407Z"
                      opacity=".5"/>
            </svg>
            What rate would you give?

        </div>
        <div class="stars flex flex-wrap justify-around w-full gap-5 md:gap-3" wire:loading.remove>
            <div class="star1 cursor-pointer flex flex-col items-center text-amber-400"
                 wire:click.debounce.150ms="star(5)">
                @include('component.star.stars')
                <div class="font-extrabold text-smid">awesome</div>
            </div>
            <div class="star2 cursor-pointer flex flex-col items-center text-green-500"
                 wire:click.debounce.150ms="star(4)">
                @include('component.star.star')
                <div class="font-extrabold text-smid">greate</div>
            </div>
            <div class="star3 cursor-pointer flex flex-col items-center text-green-400"
                 wire:click.debounce.150ms="star(3)">
                @include('component.star.star')
                <div class="font-extrabold text-smid">good</div>
            </div>
            <div class="star4 cursor-pointer flex flex-col items-center text-orange-400"
                 wire:click.debounce.150ms="star(2)">
                @include('component.star.star')
                <div class="font-extrabold text-smid">bad</div>
            </div>
            <div class="star5 cursor-pointer flex flex-col items-center text-rose-600"
                 wire:click.debounce.150ms="star(1)">
                @include('component.star.star')
                <div class="font-extrabold text-smid">the worst</div>
            </div>
        </div>
    @endif
    <div class="w-full py-6 justify-center hidden" wire:loading.class.remove="hidden" wire:loading.class="flex">
        <div class="icon-lg">
            @component('component.loading.loading',[])

            @endcomponent
        </div>
    </div>
</div>


