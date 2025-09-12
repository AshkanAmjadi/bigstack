<div>
    <div class="namaye w-full flexCC flex-col" wire:loading.remove>
        <div class="avatar 5xl">
            <img class="pointer-events-none w-full h-full"
                 src="{{$user->avatar ? imgUrlMaker2($user,'avatar') : asset('assets/img/default.png')}}"
                 alt="img/user.png">

        </div>
        <label for="profile" class="-mt-3">
            @component('component.btn.btnD',['title' => 'Change','size' => 'sm'])

            @endcomponent
        </label>


    </div>
    <div class="w-full py-10" wire:loading>

        <div class="!w-full flex flex-wrap justify-center icon-xl text-blue-500" >
            <p class="font-bold text-mid w-full text-center">Uploading ...</p>
            @component('component.loading.loading',[])

            @endcomponent
        </div>
    </div>
    <div id="setAvatar" wire:click="setAvatar(getAvatarImg())"></div>
</div>
