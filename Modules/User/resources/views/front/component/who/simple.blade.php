
@if($person)
    <div class="flex items-center gap-3 flex-wrap p-2 px-4 card_cwc">

        <a href="{{route('profile',['username'=>$person->username])}}" class="avatar sm md:!w-6 md:!h-6">
            <img class="pointer-events-none" src="{{$person->avatar ? imgUrlMaker2($person,'avatar') : asset('assets/img/default.png')}}" alt="آواتار">

        </a>
        <div class="flex flex-col">

            <a href="{{route('profile',['username'=>$person->username])}}" class="inline-block text-sm font-bold">
                {{$person->name ? :'کاربر بدون نام'}}

            </a>
            <p class="inline-block text-fnsm font-light">
                {{$person->username}}@

            </p>
        </div>
    </div>
@endif
