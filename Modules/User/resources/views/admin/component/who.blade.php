@if($person = $subject->getRelations()[$relation])
    <div class="flex items-center gap-3 flex-wrap">

        <a href="{{route('profile',['username'=>$person->username ? : '#'])}}" class="avatar lg">
            <img class="pointer-events-none"
                 src="{{$person->avatar ? imgUrlMaker2($person,'avatar') : asset('assets/img/default.png')}}"
                 alt="img/user.png">

        </a>
        <div class="flex flex-col">

            <p class="inline-block text-smid font-semibold">
                {{$person->name ? :'بدون نام'}}
            </p>
            <p class="inline-block text-esm font-light">
                @if($relation === 'updated_by')
                    {{persianDate($subject->updated_at)}}
                    - {{persianDateOld($subject->updated_at)}}
                @else
                    {{persianDate($subject->created_at)}}
                    - {{persianDateOld($subject->created_at)}}
                @endif
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
            @else
                {{persianDate($subject->created_at)}}
                - {{persianDateOld($subject->created_at)}}
            @endif
        </p>

    </div>
@endif
