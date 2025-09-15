<div class="wraper md:col-span-2" wire:click.debounce.300ms="getProfileData(getProfileDataInfo())">
    <div class="inline-block">
        @component('component.btn.btnD',['color'=>'rose','tabindex' => true])
            @slot('title')
                Send
            @endslot
            @slot('icon')
                    <svg wire:loading.remove xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M7.5 7.5h-.75A2.25 2.25 0 004.5 9.75v7.5a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25v-7.5a2.25 2.25 0 00-2.25-2.25h-.75m0-3l-3-3m0 0l-3 3m3-3v11.25m6-2.25h.75a2.25 2.25 0 012.25 2.25v7.5a2.25 2.25 0 01-2.25 2.25h-7.5a2.25 2.25 0 01-2.25-2.25v-.75"/>
                    </svg>
                    <div class="hidden" wire:loading.class.remove="hidden">
                        @component('component.loading.loading',[])

                        @endcomponent
                    </div>
            @endslot
        @endcomponent
    </div>
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
