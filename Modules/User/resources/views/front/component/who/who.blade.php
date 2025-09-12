@if($person = $subject->getRelations()[$relation])
    <div class="flex items-center gap-3 flex-wrap">

        <div class="text-center  w-full">
            <a href="{{route('profile',['username'=>$person->username])}}" class="avatar 3xl md:!w-16 md:!h-16">
                <img class="pointer-events-none"
                     src="{{$person->avatar ? imgUrlMaker2($person,'avatar') : asset('assets/img/default.png')}}"
                     alt="آواتار">

            </a>
        </div>
        <div class="flex flex-col">

            <p class="inline-block text-smid font-bold">
                {{$person->name ? :'کاربر بدون نام'}}
            </p>
            <p class="inline-block text-fsm font-light">
                {{persianDateOld($subject->created_at)}} توسط {{$person->name ? :'کاربر'}} مطرح شد
            </p>
        </div>
    </div>
@else
    <div class="flex flex-col">

        <p class="inline-block text-smid font-semibold">
            نا معلوم
        </p>
        <p class="inline-block text-esm font-light">
            @if($relation === 'updated_by')
                {{persianDate($subject->updated_at)}}
                - {{persianDateOld($subject->updated_at)}}
            @elseif($relation === 'added_by')
                {{persianDate($subject->created_at)}}
                - {{persianDateOld($subject->created_at)}}
            @endif
        </p>

    </div>
@endif
