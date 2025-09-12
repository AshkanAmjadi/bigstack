<div>
    <div class="namaye w-full flexCC flex-col" wire:loading.remove>
        <div class="w-full">
            @if($obj)
                @if($obj->value)
                    <img class="pointer-events-none w-full h-full rounded-md DLLLL p-5"
                         src="{{$obj->value ? semanticImgUrlMaker($obj,'value') : ''}}"
                         alt="option">
                @else
                    <div class="card_cwc p-4">

                        <p class="font-bold text-mid">
                            no image
                        </p>

                    </div>
                @endif
            @else
                <div class="card_cwc">

                </div>
            @endif


        </div>

    </div>
    <div class="w-full py-10" wire:loading>

        <div class="!w-full flex flex-wrap justify-center icon-xl text-blue-500">
            <p class="font-bold text-mid w-full text-center">loading ...</p>
            @component('component.loading.loading',[])

            @endcomponent
        </div>
    </div>
    <div id="{{$option}}_set" wire:click="setImage(getImg('{{$option}}'))"></div>
    @if($errors)
        <div class="w-full space-y-3 mt-5" wire:loading.remove>
            @foreach($errors as $error)
                @foreach($error as $er)
                    @component('component.allert.allert',['closeBtn' => false,'title' => $er])
                    @endcomponent
                @endforeach
            @endforeach
        </div>
    @endif
</div>
