<div id="asideOverlay" class="fixed z-40 w-full h-full bg-slate-900/30 dark:bg-slate-900/50 top-0 lg-r:hidden hide"
     onclick="burgerMenu('close')">

</div>
<div id="front-aside" class="lg-r:hidden p-2 w-80 h-full fixed top-0 right-0 z-40 xsm:w-64 transall hide ease-in-out">


    <div class="content aside DL rounded-2xl w-full h-full p-3 text-center overflow-y-auto">

        <a href="{{route('home')}}" class="logo mb-4">

            @include('component.logo.logo',['place' => 'aside'])


        </a>

        <div class="actions flex  gap-2 justify-center my-3">
            @component('component.btn.darkBtn' )
                @slot('class')
                    card py-2 px-3
                @endslot
            @endcomponent
            {{--            todo basket--}}
            {{--            @component('component.btn.linkBtn' , ['href' => '#' , 'color' => 'teal'])--}}
            {{--                @slot('icon')--}}
            {{--                        <svg class="!h-6 !w-6 fill-white" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="0.00024000000000000003"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.144"></g><g id="SVGRepo_iconCarrier"> <path opacity="0.5" d="M5.57434 4.69147C4.74117 5.38295 4.52171 6.55339 4.0828 8.89427L3.3328 12.8943C2.7156 16.186 2.40701 17.8318 3.30672 18.9159C4.20644 20 5.88097 20 9.23003 20H14.7709C18.12 20 19.7945 20 20.6942 18.9159C21.5939 17.8318 21.2853 16.186 20.6681 12.8943L19.9181 8.89427C19.4792 6.55339 19.2598 5.38295 18.4266 4.69147C17.5934 4 16.4026 4 14.0209 4H9.98003C7.59835 4 6.40752 4 5.57434 4.69147Z" ></path> <path d="M12.0004 9.24996C11.0219 9.24996 10.1875 8.62493 9.87823 7.75003C9.7402 7.35949 9.31171 7.1548 8.92117 7.29283C8.53063 7.43087 8.32594 7.85936 8.46397 8.24989C8.97841 9.70537 10.3665 10.75 12.0004 10.75C13.6343 10.75 15.0224 9.70537 15.5368 8.24989C15.6749 7.85936 15.4702 7.43087 15.0796 7.29283C14.6891 7.1548 14.2606 7.35949 14.1226 7.75003C13.8133 8.62493 12.9789 9.24996 12.0004 9.24996Z" ></path> </g></svg>--}}
            {{--                @endslot--}}
            {{--            @endcomponent--}}
        </div>
        <div class="divider-1 my-2"></div>

        <form class="DLL flex  w-full p-4 rounded-xl relative ">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                 class="fill-slate-500 dark:fill-slate-400 inline">
                <path fill-rule="evenodd"
                      d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z"
                      clip-rule="evenodd"/>
            </svg>
            <input onclick="openMainsearch()" type="search"
                   class="text-sm re w-11/12 mr-4 DLL" placeholder="What are you looking for?">


        </form>
        <div class="divider-1 my-2"></div>

        <nav>
            <ul class="lists content flex flex-col overflow-y-auto">

                @foreach(\App\facade\BaseCat\BaseCat::getAllHeaderLists() as $navigation)
                    <li>

                        @component('front.temp.headers.1.component.asideNavLink',['list' => $navigation ])
                        @endcomponent

                        @if($navigation->child->count())
                            <ul class="subNav hidden DLL rounded-lg p-4 mb-2">
                                @if($navigation->menu_type == 'megamenu')
                                    @foreach($navigation->child as $child)

                                        <a href="{{route('category.show',['category' => $child->category->slug])}}" class="rounded-md overflow-hidden flex  {{$loop->last ? '' : 'mb-4'}}">

                                            @if($child->type == 'category')
                                                <img class="w-full" src="{{semanticImgUrlMaker($child->category,'mobile_banner')}}" alt="{{$child->category->page_title}}">

                                            @endif

                                        </a>

                                    @endforeach
                                @elseif($navigation->menu_type == 'default')
                                    @foreach($navigation->child as $child)

                                        <li>

                                            @component('front.temp.headers.1.component.asideNavLink',['list' => $child])
                                            @endcomponent

                                            @if($child->child->count())
                                                <ul class="subNav hidden DLL rounded-md p-2">
                                                    @foreach($child->child as $grandchild)
                                                        <li>
                                                            @component('front.temp.headers.1.component.asideNavLink',['list' => $grandchild,'noChild'=> true])
                                                            @endcomponent

                                                        </li>
                                                    @endforeach
                                                </ul>

                                            @endif


                                        </li>
                                    @endforeach
                                @endif

                            </ul>

                        @endif
                    </li>

                @endforeach

            </ul>

        </nav>
    </div>


</div>

<div
    class="aside transall lg-r:hidden fixed left-2 top-2 z-40 w-12 h-12 bg-slate-50 rounded-xl xsm:w-10 xsm:h-10 flex dark:bg-slate-900 justify-center items-center hide"
    onclick="burgerMenu('close')">
    <div class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path fill-rule="evenodd"
                  d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z"
                  clip-rule="evenodd"/>
        </svg>
    </div>

</div>

{{--<div class="aside lg-r:hidden fixed left-2 bottom-2 z-40 p-2 rounded-md DL flex flex-col gap-2 hide">--}}
{{--    <button--}}
{{--        class="btn icon shadow-md shadow-rose-200 dark:shadow-rose-500/60 hover:shadow-lg hover:shadow-rose-200 dark:hover:shadow-rose-700 bg-rose-500 text-slate-50 hover:bg-rose-400 inline-block rounded-md focus:shadow-none focus:bg-rose-600 focus:ring-2 focus:ring-rose-600 focus:ring-offset-2">--}}
{{--        <div class="icon">--}}
{{--            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">--}}
{{--                <path fill-rule="evenodd"--}}
{{--                      d="M10 2a.75.75 0 01.75.75v7.5a.75.75 0 01-1.5 0v-7.5A.75.75 0 0110 2zM5.404 4.343a.75.75 0 010 1.06 6.5 6.5 0 109.192 0 .75.75 0 111.06-1.06 8 8 0 11-11.313 0 .75.75 0 011.06 0z"--}}
{{--                      clip-rule="evenodd"></path>--}}
{{--            </svg>--}}

{{--        </div>--}}

{{--    </button>--}}
{{--    <button--}}
{{--        class="btn icon shadow-md shadow-rose-200 dark:shadow-rose-500/60 hover:shadow-lg hover:shadow-rose-200 dark:hover:shadow-rose-700 bg-rose-500 text-slate-50 hover:bg-rose-400 inline-block rounded-md focus:shadow-none focus:bg-rose-600 focus:ring-2 focus:ring-rose-600 focus:ring-offset-2">--}}
{{--        <div class="icon">--}}
{{--            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">--}}
{{--                <path fill-rule="evenodd"--}}
{{--                      d="M10 2a.75.75 0 01.75.75v7.5a.75.75 0 01-1.5 0v-7.5A.75.75 0 0110 2zM5.404 4.343a.75.75 0 010 1.06 6.5 6.5 0 109.192 0 .75.75 0 111.06-1.06 8 8 0 11-11.313 0 .75.75 0 011.06 0z"--}}
{{--                      clip-rule="evenodd"></path>--}}
{{--            </svg>--}}

{{--        </div>--}}

{{--    </button>--}}
{{--    <button--}}
{{--        class="btn icon shadow-md shadow-rose-200 dark:shadow-rose-500/60 hover:shadow-lg hover:shadow-rose-200 dark:hover:shadow-rose-700 bg-rose-500 text-slate-50 hover:bg-rose-400 inline-block rounded-md focus:shadow-none focus:bg-rose-600 focus:ring-2 focus:ring-rose-600 focus:ring-offset-2">--}}
{{--        <div class="icon">--}}
{{--            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">--}}
{{--                <path fill-rule="evenodd"--}}
{{--                      d="M10 2a.75.75 0 01.75.75v7.5a.75.75 0 01-1.5 0v-7.5A.75.75 0 0110 2zM5.404 4.343a.75.75 0 010 1.06 6.5 6.5 0 109.192 0 .75.75 0 111.06-1.06 8 8 0 11-11.313 0 .75.75 0 011.06 0z"--}}
{{--                      clip-rule="evenodd"></path>--}}
{{--            </svg>--}}

{{--        </div>--}}

{{--    </button>--}}
{{--</div>--}}


