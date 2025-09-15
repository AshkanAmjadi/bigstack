@php

    @endphp

<header id="header" class="mini w-full h-16 border-b border-slate-300 flex items-center px-5 space-x-5 fixed top-0 z-20 lg:space-x-3 text-slate-700 DL-I">
    <div class="profile hasList flex">

        @component('user::component.avatar.avatar',['class' => 'dropBtn cursor-pointer'])
            @if($user = auth()->user())

                @slot('image')
                    <img class="pointer-events-none" src="{{auth()->user()->avatar ? imgUrlMaker2(auth()->user(),'avatar') : asset('assets/img/default.png')}}"
                         alt="img/default.png">

                @endslot
            @endif
            @slot('action')
                onclick="openList(this)"
            @endslot
        @endcomponent
        <ul class="list hide left-0 top-10 w-72 flex flex-col">
            <li class="link">

                @component('user::component.avatar.avatar',['class' => 'mr-3'])
                    @if($user = auth()->user())

                        @slot('image')
                            <img class="pointer-events-none" src="{{auth()->user()->avatar ? imgUrlMaker2(auth()->user(),'avatar') : asset('assets/img/default.png')}}"
                                 alt="img/default.png">

                        @endslot
                    @endif

                @endcomponent
                <div>
                    <div class="name font-bold">{{auth()->user()->name ?: 'User'}}</div>
                    @include('user::component.user.semat',['subject' => auth()->user()])

                </div>
            </li>

            <a href="{{route('user-panel.index')}}" class="link">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24">
                        <g fill="currentColor">
                            <path
                                d="M14 4h-4C6.229 4 4.343 4 3.172 5.172C2 6.343 2 8.229 2 12c0 3.771 0 5.657 1.172 6.828C4.343 20 6.229 20 10 20h4c3.771 0 5.657 0 6.828-1.172C22 17.657 22 15.771 22 12c0-3.771 0-5.657-1.172-6.828C19.657 4 17.771 4 14 4Z"
                                opacity=".5"/>
                            <path
                                d="M13.25 9a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75Zm1 3a.75.75 0 0 1 .75-.75h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75Zm1 3a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75ZM9 11a2 2 0 1 0 0-4a2 2 0 0 0 0 4Zm0 6c4 0 4-.895 4-2s-1.79-2-4-2s-4 .895-4 2s0 2 4 2Z"/>
                        </g>
                    </svg>


                </div>
                <p>Profile</p>
            </a>

            @component('component.divider.divider',[])

            @endcomponent


            <li class="px-3 py-2">
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
    <div class="notification hasList">
        <div class="dropBtn cursor-pointer relative p-2" onclick="openList(this)">
            @if($newCon = \Modules\User\App\Models\UserAllert::query()->where(['user_id'=>auth()->id(),'new'=>true])->count())
                @component('component.badg.badg',['shadow'=>false,'color'=>'rose' ,'class' => 'number absolute -right-1 -top-1 z-10 pointer-events-none'])
                    @slot('title')
                        {{$newCon}}
                    @endslot
                @endcomponent
            @endif

            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                 class="pointer-events-none w-5.5 h-5.5">
                <g fill="currentColor">
                    <path
                        d="M18.75 9v.704c0 .845.24 1.671.692 2.374l1.108 1.723c1.011 1.574.239 3.713-1.52 4.21a25.794 25.794 0 0 1-14.06 0c-1.759-.497-2.531-2.636-1.52-4.21l1.108-1.723a4.393 4.393 0 0 0 .693-2.374V9c0-3.866 3.022-7 6.749-7s6.75 3.134 6.75 7Z"
                        opacity=".5"/>
                    <path d="M7.243 18.545a5.002 5.002 0 0 0 9.513 0c-3.145.59-6.367.59-9.513 0Z"/>
                </g>
            </svg>
        </div>

        <div class="list hide -left-8 top-10 w-72 overflow-hidden !pt-16 ">
            <div
                class="header w-full h-16 absolute top-0 border-b border-slate-300 flex items-center justify-between px-6">

                <h2 class="font-bold">Notifications</h2>
                @component('component.btn.linkBtn',['title' => 'Show Allerts' , 'size' => 'sm'])
                    @slot('href')
                        {{route('user-panel.allerts')}}
                    @endslot
                @endcomponent
            </div>

            <div class="max-h-96 overflow-y-auto flex flex-wrap px-2 space-y-2">
                @forelse(\Modules\User\App\Models\UserAllert::query()->where('user_id','=',auth()->id())->limit('3')->orderBy('id','desc')->get() as $adminAllert)

                    @component('component.allert.publicAllert',['type' => $adminAllert->type,'closeBtn' => false])
                        @slot('content')
                            {!! clean($adminAllert->content) !!}
                        @endslot
                        @slot('old')
                            {{persianDateOld($adminAllert->created_at)}}
                        @endslot
                    @endcomponent

                @empty
                    @component('component.divider.divider',['title' => 'No Allerts' ,'class' => 'my-6'])
                    @endcomponent
                @endforelse
            </div>

        </div>
    </div>
    @component('component.btn.darkBtn')
    @endcomponent

    <div class="welcome w-full flexC gap-3 pr-6 md:flex-col md:items-start md:gap-0 md:pr-0 flex-row-reverse">
        <h2 class="font-semibold text-smid">
            👋 Hi dear {{auth()->user()->name ?: 'User'}} welcome.
        </h2>
        @component('component.divider.hDivider',['class' => 'h-8 md:hidden'])

        @endcomponent
        <h2 class="text-sm font-thin">
            {{persianDate(now(),'l, %d  %B %Y')}}
        </h2>
    </div>
    <div class="">
        <div class="openMenu lg-r:hidden" onclick="openMenu()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="w-6 h-6"><g fill="currentColor"><path d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22Z" opacity=".5"/><path d="M18.75 8a.75.75 0 0 1-.75.75H6a.75.75 0 0 1 0-1.5h12a.75.75 0 0 1 .75.75Zm0 4a.75.75 0 0 1-.75.75H6a.75.75 0 0 1 0-1.5h12a.75.75 0 0 1 .75.75Zm0 4a.75.75 0 0 1-.75.75H6a.75.75 0 0 1 0-1.5h12a.75.75 0 0 1 .75.75Z"/></g></svg>

        </div>
    </div>
</header>
