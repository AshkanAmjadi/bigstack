@if(mobileDevice())
    @if($articleList->mobile_banner)

        <div class="descImage text-center w-full">
            <div class="inline-block shiar ring-blue-600 rounded-md overflow-hidden w-full">
                <img class="w-full" src="{{semanticImgUrlMaker($articleList,'mobile_banner')}}"
                     alt="{{$articleList->page_title}}">

            </div>

        </div>
    @elseif($articleList->banner)
        <div class="descImage text-center w-full">
            <div class="inline-block shiar ring-blue-600 rounded-md overflow-hidden w-full">
                <img class="w-full" src="{{semanticImgUrlMaker($articleList,'banner')}}"
                     alt="{{$articleList->page_title}}">

            </div>

        </div>
    @endif

@else
    @if($articleList->banner)

        <div class="descImage text-center w-full">
            <div class="inline-block shiar ring-blue-600 rounded-md overflow-hidden w-full">
                <img class="w-full" src="{{semanticImgUrlMaker($articleList,'banner')}}"
                     alt="{{$articleList->page_title}}">

            </div>

        </div>
    @elseif($articleList->mobile_banner)
        <div class="descImage text-center w-full">
            <div class="inline-block shiar ring-blue-600 rounded-md overflow-hidden w-full">
                <img class="w-full" src="{{semanticImgUrlMaker($articleList,'mobile_banner')}}"
                     alt="{{$articleList->page_title}}">

            </div>

        </div>
    @endif
@endif
