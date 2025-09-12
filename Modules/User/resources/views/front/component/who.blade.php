@if($person = $subject->getRelations()[$relation])
        <div class="flex items-center gap-3 flex-wrap">

            <a href="{{route('profile',['username'=>$person->username])}}" class="avatar lg md:!w-10 md:!h-10">
                <img class="pointer-events-none"
                     src="{{$person->avatar ? imgUrlMaker2($person,'avatar') : asset('assets/img/default.png')}}"
                     alt="avatar">

            </a>
            <div class="flex flex-col">

                <a href="{{route('profile',['username'=>$person->username])}}" class="inline-block text-smid font-bold">
                    {{$person->name ? :'unknown'}}
                </a>
                <p class="inline-block text-fsm font-light">
                    Editor
                </p>
            </div>
        </div>
@else
    <div class="flex flex-col">

        <p class="inline-block text-smid font-semibold">
            unknown
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
