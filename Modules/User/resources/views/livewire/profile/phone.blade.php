<div class="wraper md:col-span-2">

    @if(!$gotIt)
        <h2 class="text-sm mr-4 font-semibold">شماره موبایل جدید</h2>
        <input id="phoneUser" class="form-input2 text-smid w-full" name="name" type="text"
               value="" dir="ltr" placeholder="مثال : 9999 999 0999" >

        <div class="inline-block mt-4 md:mt-8" wire:click.debounce.300ms="getPhone(document.getElementById('phoneUser').value)">
            @component('component.btn.btn',['color'=>'rose'])
                @slot('title')
                    ارسال شماره تماس
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
    @else
        <h2 class="text-sm mr-4 font-semibold">کد ارسال شده به شماره تماس {{$secondPhone}} را وارد کنید</h2>
        <input id="activeCode" class="form-input2 text-smid w-full" name="name" type="text"
               value="" dir="ltr" placeholder="مثال : 999999" wire:loading.remove>

        <div class="inline-block mt-4 md:mt-8" wire:click.debounce.160ms="getCode(document.getElementById('activeCode').value)">
            @component('component.btn.btn',['color'=>'rose'])
                @slot('title')
                    ارسال کد
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
    @endif
</div>
