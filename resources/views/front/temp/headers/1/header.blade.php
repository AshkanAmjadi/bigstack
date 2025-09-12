{{--{{session()->getId()}}--}}

<header class="w-full pt-10 px-20 xl:pt-5 xl:px-10 sm:pt-3 sm:px-3 relative z-40">
    <div
        class="grid bg-white dark:bg-zinc-900 grid-cols-9 items-center shadow-xl p-5 rounded-2xl lg:p-2">
        <div class="flex col-span-2 lg-r:hidden pl-5">

            <div onclick="burgerMenu('open')"
                 class="btn line text-gray-500 bg-gray-500/10 hover:bg-gray-500/100 inline-block rounded-md border-gray-500 focus:bg-gray-600 focus:border-gray-600 focus:ring-2 focus:ring-gray-600 focus:ring-offset-2 focus:text-slate-50 hover:text-slate-50 px-2.5">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>


                </div>
            </div>
        </div>
        <div class="col-span-2 lg:col-span-5 lg:text-center flex items-center lg:justify-center">

            <a href="{{route('home')}}" class="logo h-24 w-24 xl:h-16 xl:w-16 inline-block dark:hidden lg-r:h-auto lg-r:py-2 p-2">
                @include('component.logo.logo',['sbj' => 'dark' ,'size' => '','place'=>'home_header'])
            </a>
            <a href="{{route('home')}}" class="logo h-24 w-24 xl:h-16 xl:w-16 hidden dark:inline-block lg-r:h-auto lg-r:py-2 p-2">
                @include('component.logo.logo',['sbj' => 'light' ,'size' => '','place'=>'home_header'])

            </a>
        </div>
        <div id="search" class="col-span-5 lg:hidden relative z-40">

            <form class="form-input-zinc flex items-center w-full rounded-xl relative ">
                <div class="pl-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                         class="fill-slate-500 dark:fill-slate-400 inline">
                        <path fill-rule="evenodd"
                              d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
                <input onclick="openMainsearch()" type="text"
                       class="form-input-zinc text-sm re w-11/12 ml-4 py-4 rounded-xl" placeholder="What are you looking for?">


            </form>

        </div>
        <div class="text-left flex flex-row-reverse pr-5 gap-4 col-span-2">
            @guest()
                <a href="{{route('auth.login')}}" rel="nofollow"
                   class="btn text-slate-50 inline-block rounded-md lg:px-2.5">
                    <p class="inline lg:hidden">
                        Join us
                    </p>
                    <div class="icon !m-0">
                        <svg class="fill-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <circle cx="12" cy="6" r="4"></circle>
                                <path opacity="0.5"
                                      d="M20 17.5C20 19.9853 20 22 12 22C4 22 4 19.9853 4 17.5C4 15.0147 7.58172 13 12 13C16.4183 13 20 15.0147 20 17.5Z"></path>
                            </g>
                        </svg>


                    </div>
                </a>
            @endguest
            @auth()
                <div
                    class="btn text-slate-50 inline-block rounded-md drop lg:px-2.5"
                    style="--color : rgb(79 70 229 / var(--tw-text-opacity))"
                    onclick="openDropContent(this)">
                    <div class="icon pointer-events-none">
                        <svg class="fill-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <circle cx="12" cy="6" r="4"></circle>
                                <path opacity="0.5"
                                      d="M20 17.5C20 19.9853 20 22 12 22C4 22 4 19.9853 4 17.5C4 15.0147 7.58172 13 12 13C16.4183 13 20 15.0147 20 17.5Z"></path>
                            </g>
                        </svg>
                    </div>
                    <p class="inline lg:hidden pointer-events-none">
                        profile
                    </p>
                    <div class="dropContent hasList absolute z-50 top-full-plus-2 right-0 text-slate-700 hidden">
                        <ul class="DL border-none rounded-xl w-72 list flex flex-col  right-0">
                            <li class="link">
                                <div class="avatar lg mr-3">
                                    <img class="pointer-events-none"
                                         src="{{auth()->user()->avatar ? imgUrlMaker2(auth()->user(),'avatar') : asset('assets/img/default.png')}}"
                                         alt="آواتار">

                                </div>
                                <div class="text-right">
                                    <div class="name font-bold block">{{auth()->user()->name}}</div>
                                    @include('user::component.user.semat',['subject' => auth()->user()])

                                </div>
                            </li>

                            <li class="link">
                                <a href="{{route('user-panel.index')}}" rel="nofollow" class="w-full text-right">
                                    <p class="mr-2">user panel</p>

                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" class="icon-md" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="9" r="2"/><path d="M13 15c0 1.105 0 2-4 2s-4-.895-4-2s1.79-2 4-2s4 .895 4 2Z"/><path d="M2 12c0-3.771 0-5.657 1.172-6.828C4.343 4 6.229 4 10 4h4c3.771 0 5.657 0 6.828 1.172C22 6.343 22 8.229 22 12c0 3.771 0 5.657-1.172 6.828C19.657 20 17.771 20 14 20h-4c-3.771 0-5.657 0-6.828-1.172C2 17.657 2 15.771 2 12Z" opacity=".5"/><path stroke-linecap="round" d="M19 12h-4m4-3h-5"/><path stroke-linecap="round" d="M19 15h-3" opacity=".9"/></g></svg>


                                    </div>
                                </a>
                            </li>



                            @if(super())
                                <li class="px-3 py-1">
                                    <a href="{{route('admin.dashboard')}}" rel="nofollow"
                                       class="btn w-full shadow-md shadow-blue-200 dark:shadow-blue-500/60 hover:shadow-lg hover:shadow-blue-200 dark:hover:shadow-blue-700 bg-blue-500 text-slate-50 hover:bg-blue-400 inline-block rounded-md focus:shadow-none focus:bg-blue-600 focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/>
                                            </svg>


                                        </div>
                                        <p>manage website</p>
                                    </a>
                                </li>
                                <li class="px-3 py-1">
                                    <a href="{{route('admin.flushCache')}}" rel="nofollow"
                                       class="btn w-full shadow-md shadow-amber-200 dark:shadow-amber-500/60 hover:shadow-lg hover:shadow-amber-200 dark:hover:shadow-amber-700 bg-amber-500 text-slate-50 hover:bg-amber-400 inline-block rounded-md focus:shadow-none focus:bg-amber-600 focus:ring-2 focus:ring-amber-600 focus:ring-offset-2">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/>
                                            </svg>


                                        </div>
                                        <p>Delete Cache</p>
                                    </a>
                                </li>

                                <li class="px-3 py-1">
                                    <a href="{{route('admin.down')}}" rel="nofollow"
                                       class="btn w-full shadow-md shadow-red-200 dark:shadow-red-500/60 hover:shadow-lg hover:shadow-red-200 dark:hover:shadow-red-700 bg-red-500 text-slate-50 hover:bg-red-400 inline-block rounded-md focus:shadow-none focus:bg-red-600 focus:ring-2 focus:ring-red-600 focus:ring-offset-2">
                                        <p>Down</p>

                                    </a>
                                </li>

                            @endif

                            <li class="px-3 py-1">
                                <form action="{{route('logout')}}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit"
                                            class="btn w-full shadow-md shadow-red-200 dark:shadow-red-500/60 hover:shadow-lg hover:shadow-red-200 dark:hover:shadow-red-700 bg-red-500 text-slate-50 hover:bg-red-400 inline-block rounded-md focus:shadow-none focus:bg-red-600 focus:ring-2 focus:ring-red-600 focus:ring-offset-2">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                 class="w-5 h-5">
                                                <path fill-rule="evenodd"
                                                      d="M10 2a.75.75 0 01.75.75v7.5a.75.75 0 01-1.5 0v-7.5A.75.75 0 0110 2zM5.404 4.343a.75.75 0 010 1.06 6.5 6.5 0 109.192 0 .75.75 0 111.06-1.06 8 8 0 11-11.313 0 .75.75 0 011.06 0z"
                                                      clip-rule="evenodd"></path>
                                            </svg>

                                        </div>
                                        <p>Logout</p>
                                    </button>
                                </form>
                            </li>


                        </ul>
                    </div>
                </div>
                {{--            todo basket--}}
                {{--                @component('component.btn.linkBtn' , ['href' => '#' ,'class'=> 'lg:hidden' , 'color' => 'teal'])--}}
                {{--                    @slot('icon')--}}
                {{--                            <svg class="!h-6 !w-6 fill-white" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="0.00024000000000000003"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.144"></g><g id="SVGRepo_iconCarrier"> <path opacity="0.5" d="M5.57434 4.69147C4.74117 5.38295 4.52171 6.55339 4.0828 8.89427L3.3328 12.8943C2.7156 16.186 2.40701 17.8318 3.30672 18.9159C4.20644 20 5.88097 20 9.23003 20H14.7709C18.12 20 19.7945 20 20.6942 18.9159C21.5939 17.8318 21.2853 16.186 20.6681 12.8943L19.9181 8.89427C19.4792 6.55339 19.2598 5.38295 18.4266 4.69147C17.5934 4 16.4026 4 14.0209 4H9.98003C7.59835 4 6.40752 4 5.57434 4.69147Z" ></path> <path d="M12.0004 9.24996C11.0219 9.24996 10.1875 8.62493 9.87823 7.75003C9.7402 7.35949 9.31171 7.1548 8.92117 7.29283C8.53063 7.43087 8.32594 7.85936 8.46397 8.24989C8.97841 9.70537 10.3665 10.75 12.0004 10.75C13.6343 10.75 15.0224 9.70537 15.5368 8.24989C15.6749 7.85936 15.4702 7.43087 15.0796 7.29283C14.6891 7.1548 14.2606 7.35949 14.1226 7.75003C13.8133 8.62493 12.9789 9.24996 12.0004 9.24996Z" ></path> </g></svg>--}}
                {{--                    @endslot--}}
                {{--                @endcomponent--}}

            @endauth
            @component('component.btn.darkBtn')
                @slot('class')
                    py-2 px-3 DL-I rounded-lg lg:hidden
                @endslot
            @endcomponent

        </div>


    </div>

</header>
@include('front.temp.headers.1.nav')

@include('front.temp.headers.1.aside')






