<div class="top space-y-3 pt-2">
    @include('component.breadcrump.nav',['items' => $breadCrump])

    <div class="imgwraper p-6 lg:p-2">
        @if($article->img and semanticImgUrlMaker($article,'img'))
            <figure class="img overflow-hidden rounded-xl md:rounded-md relative group">
                <img class="w-full" src="{{semanticImgUrlMaker($article,'img')}}" alt="{{$article->alt ? : $article->page_title}}">
                @if($article->caption)
                    <figcaption class="absolute font-bold trans ease-in-out top-2 -translate-x-1/2 left-0 card_c p-3 group-hover:translate-x-2 md:p-2 md:px-4 text-smid md:rounded-md">
                        {{$article->caption}}
                    </figcaption>
                @endif

            </figure>
        @else
            <figure class="img overflow-hidden shadow-custom_gray rounded-xl md:rounded-md relative group">
                <img class="w-full" src="{{defaultImgUrlMaker('article','img')}}" alt="{{findInOption('slogen')}}">
                    <figcaption class="absolute font-bold trans ease-in-out top-2 -translate-x-1/2 left-0 card_c md:rounded-sm p-3 group-hover:translate-x-2 md:p-2 md:px-4 text-smid">
                        {{findInOption('slogen')}}
                    </figcaption>

            </figure>
        @endif
    </div>
    <div class="info grid grid-cols-2 gap-4 md:gap-3 md:px-2 px-4  ">
        {{--            <div--}}
        {{--                class="view card_cwc p-3 md:p-2 flex gap-1 items-center md:justify-center flex-wrap">--}}
        {{--                <div class="icon-lg text-blue-500">--}}
        {{--                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">--}}
        {{--                        <g fill="none" stroke="currentColor" stroke-width="1.5">--}}
        {{--                            <path--}}
        {{--                                d="M3.275 15.296C2.425 14.192 2 13.639 2 12c0-1.64.425-2.191 1.275-3.296C4.972 6.5 7.818 4 12 4c4.182 0 7.028 2.5 8.725 4.704C21.575 9.81 22 10.361 22 12c0 1.64-.425 2.191-1.275 3.296C19.028 17.5 16.182 20 12 20c-4.182 0-7.028-2.5-8.725-4.704Z"--}}
        {{--                                opacity=".5"/>--}}
        {{--                            <path d="M15 12a3 3 0 1 1-6 0a3 3 0 0 1 6 0Z"/>--}}
        {{--                        </g>--}}
        {{--                    </svg>--}}

        {{--                </div>--}}
        {{--                <p class="font-bold text-sm text-center md:w-full">--}}
        {{--                    تعداد بازدید :--}}
        {{--                </p>--}}
        {{--                <p class="font-bold text-sm">--}}
        {{--                    {{$article->view}}--}}
        {{--                </p>--}}
        {{--            </div>--}}
        <div
            class="read_time card_cwc p-3 md:p-2 flex gap-2 items-center md:justify-center flex-wrap">
            <div class="icon-lg text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <g fill="none" stroke="currentColor" stroke-width="1.5">
                        <path
                            d="M5 12c0-2.809 0-4.213.674-5.222a4 4 0 0 1 1.104-1.104C7.787 5 9.19 5 12 5c2.809 0 4.213 0 5.222.674a4 4 0 0 1 1.104 1.104C19 7.787 19 9.19 19 12c0 2.809 0 4.213-.674 5.222a4.003 4.003 0 0 1-1.104 1.104C16.213 19 14.81 19 12 19c-2.809 0-4.213 0-5.222-.674a4.002 4.002 0 0 1-1.104-1.104C5 16.213 5 14.81 5 12Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.077L14 14"
                              opacity=".5"/>
                        <path
                            d="m16.778 5.5l-.082-.368c-.334-1.501-.5-2.252-1.049-2.692C15.1 2 14.33 2 12.791 2H11.21c-1.54 0-2.31 0-2.857.44c-.549.44-.715 1.19-1.05 2.692l-.08.368m9.555 13l-.082.368c-.334 1.501-.5 2.252-1.049 2.692c-.548.44-1.318.44-2.856.44H11.21c-1.539 0-2.308 0-2.856-.44c-.549-.44-.715-1.19-1.05-2.692l-.08-.368"
                            opacity=".5"/>
                    </g>
                </svg>
            </div>
            <p class="font-bold text-sm text-center md:w-full">
                Study time :
            </p>
            <p class="font-bold text-sm">
                {{$article->read_time}} Minute
            </p>
        </div>
        <div
            class="updated_at card_cwc p-3 md:p-2 flex gap-2 items-center md:justify-center flex-wrap">
            <div class="icon-lg text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <g fill="none" stroke="currentColor" stroke-width="1.5">
                        <path
                            d="M2 12c0-3.771 0-5.657 1.172-6.828C4.343 4 6.229 4 10 4h4c3.771 0 5.657 0 6.828 1.172C22 6.343 22 8.229 22 12v2c0 3.771 0 5.657-1.172 6.828C19.657 22 17.771 22 14 22h-4c-3.771 0-5.657 0-6.828-1.172C2 19.657 2 17.771 2 14v-2Z"/>
                        <path stroke-linecap="round" d="M7 4V2.5M17 4V2.5M2 9h20" opacity=".5"/>
                    </g>
                </svg>
            </div>
            <p class="font-bold text-sm text-center md:w-full">
                Last modified :
            </p>
            <p class="font-bold text-sm">
                {{persianDate($article->updated_at,'Y/n/j')}}
            </p>
        </div>
    </div>
    <div class="">
        <div class="title mx-3 md:mx-1.5 px-4 pb-3 pt-4 md:p-2 relative z-10 rounded-xl md:rounded-md flex flex-wrap items-center justify-between gap-4">
            <div class="r">
                <h1 class="font-extrabold text-felg  inline-block p-4 md:p-2">
                    {{$article->title}}
                </h1>
            </div>
        </div>
    </div>

</div>
