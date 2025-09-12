<nav id="nav" class="relative z-20 w-full px-40 text-white xl:px-20 lg:hidden ">
    <ul class="content w-full rounded-b-3xl px-8 flex gap-9 xl:gap-6 text-smid relative">
        @foreach(\App\facade\BaseCat\BaseCat::getAllHeaderLists() as $navigation)
            <li class="z-10">

                @component('front.temp.headers.'.findInOption('header').'.component.navLink',['list' => $navigation])
                @endcomponent

                @if($navigation->child->count())
                    <div class="icon inline">
                        @include('front.temp.headers.'.findInOption('header').'.component.arrowDown')
                    </div>

                    <ul class="subNav {{ $navigation->menu_type == 'megamenu' ? 'right-0 !w-full grid grid-cols-4 gap-4 !p-4' : '' }}">
                        @if($navigation->menu_type == 'megamenu')

                                @foreach($navigation->child as $child)

                                    <a href="{{route('category.show',['category' => $child->category->slug])}}" class="rounded-lg overflow-hidden flex">

                                        @if($child->type == 'category')
                                            <img class="w-full" src="{{semanticImgUrlMaker($child->category,'mobile_banner')}}" alt="{{$child->category->page_title}}">

                                        @endif

                                    </a>

                                @endforeach
                        @elseif($navigation->menu_type == 'default')
                            @foreach($navigation->child as $child)

                                <li class="">

                                    @component('front.temp.headers.'.findInOption('header').'.component.navLink',['list' => $child])
                                    @endcomponent

                                    @if($child->child->count())
                                        <div class="icon inline">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                 class="fill-slate-700 rotate-90">
                                                <path fill-rule="evenodd"
                                                      d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <ul class="subNav">
                                            @foreach($child->child as $grandchild)
                                                <li>

                                                    @component('front.temp.headers.'.findInOption('header').'.component.navLink',['list' => $grandchild])
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
