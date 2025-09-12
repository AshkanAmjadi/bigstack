@php

    @endphp

<header id="header"
        class="mini w-full h-16 border-b border-slate-300 flex flex-row-reverse items-center px-5 space-x-5 fixed top-0 z-20 lg:space-x-3 text-slate-700 bg-slate-100">
    <div class="profile hasList flex">

        @component('user::component.avatar.avatar',['class' => 'dropBtn cursor-pointer'])
            @if($user = auth()->user())

                @slot('image')
                    <img class="pointer-events-none" src="{{imgUrlMaker2($user,'avatar')}}"
                         alt="img/default.png">

                @endslot
            @endif
            @slot('action')
                onclick="openList(this)"
            @endslot
        @endcomponent
        <ul class="list hide left-0 top-10 w-72 flex flex-col">
            <li class="link">

                @component('user::component.avatar.avatar',['class' => 'ml-3'])
                    @if($user = auth()->user())

                        @slot('image')
                            <img class="pointer-events-none" src="{{imgUrlMaker2($user,'avatar')}}"
                                 alt="img/default.png">

                        @endslot
                    @endif

                @endcomponent
                <div>
                    <div class="name font-bold">{{auth()->user()->name}}</div>
                    @if(auth()->user()->superuser)
                        @component('component.badg.badg' ,['color' => 'rose'])
                            @slot('title')
                                بنیان گذار
                            @endslot
                        @endcomponent
                    @endif
                    @if(auth()->user()->boss)
                        @component('component.badg.badg' ,['color' => 'orange'])
                            @slot('title')
                                مدیر
                            @endslot
                        @endcomponent
                    @endif
                    @if(auth()->user()->staff)
                        @component('component.badg.badg' ,['color' => 'blue'])
                            @slot('title')
                                کارمند
                            @endslot
                        @endcomponent
                    @endif
                </div>
            </li>

            <li class="link">
                <a href="{{route('user-panel.index')}}" class="flex gap-2">
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
                    <p>پروفایل</p>
                </a>
            </li>

            @component('component.divider.divider',[])

            @endcomponent


            <li class="px-3 py-2">
                <a href="{{route('logout')}}"
                   class="btn w-full shadow-md shadow-red-200 dark:shadow-red-500/60 hover:shadow-lg hover:shadow-red-200 dark:hover:shadow-red-700 bg-red-500 text-slate-50 hover:bg-red-400 inline-block rounded-md focus:shadow-none focus:bg-red-600 focus:ring-2 focus:ring-red-600 focus:ring-offset-2">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                  d="M10 2a.75.75 0 01.75.75v7.5a.75.75 0 01-1.5 0v-7.5A.75.75 0 0110 2zM5.404 4.343a.75.75 0 010 1.06 6.5 6.5 0 109.192 0 .75.75 0 111.06-1.06 8 8 0 11-11.313 0 .75.75 0 011.06 0z"
                                  clip-rule="evenodd"/>
                        </svg>

                    </div>
                    <p>خروج</p>
                </a>
            </li>


        </ul>
    </div>
    <div class="notification hasList">
        <div class="dropBtn cursor-pointer relative p-2" onclick="openList(this)">
            @if($newCon = \App\Models\AdminAllert::query()->where(['new'=>true])->count())
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

                <h2 class="font-bold">اعلان ها</h2>
                @component('component.btn.linkBtn',['title' => 'مشاهده اعلان ها' , 'size' => 'sm','href' => route('admin.adminAllert.index')])
                    @slot('action')
                    @endslot
                @endcomponent
            </div>

            <div class="max-h-96 overflow-y-auto flex flex-wrap px-2 space-y-2">
                @forelse(\App\Models\AdminAllert::query()->limit('3')->orderBy('id','desc')->get() as $adminAllert)

                    @component('component.allert.publicAllert',['type' => $adminAllert->type,'closeBtn' => false])
                        @slot('content')
                            {!! clean($adminAllert->content) !!}
                        @endslot
                        @slot('old')
                            {{persianDateOld($adminAllert->created_at)}}
                        @endslot
                    @endcomponent

                @empty
                    @component('component.divider.divider',['title' => 'اعلانی ثبت نشده' ,'class' => 'my-6'])
                    @endcomponent
                @endforelse
            </div>

        </div>
    </div>
    @component('component.btn.darkBtn')
    @endcomponent
    <div class="search flex items-center space-x-reverse space-x-1 w-full" onclick="openMainsearch()">
        <label for="search" class="pr-4 lg:pr-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11.5" cy="11.5" r="9.5" opacity=".5"/><path stroke-linecap="round" d="M18.5 18.5L22 22"/></g></svg>
        </label>
        <input id="search" class="w-full p-4 bg-slate-100 outline-none text-smid font-medium lg:hidden" type="text"
               placeholder="جستوجو  ...">
    </div>
    <div class="openMenu lg-r:hidden" onclick="openMenu()">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="w-6 h-6"><g fill="currentColor"><path d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22Z" opacity=".5"/><path d="M18.75 8a.75.75 0 0 1-.75.75H6a.75.75 0 0 1 0-1.5h12a.75.75 0 0 1 .75.75Zm0 4a.75.75 0 0 1-.75.75H6a.75.75 0 0 1 0-1.5h12a.75.75 0 0 1 .75.75Zm0 4a.75.75 0 0 1-.75.75H6a.75.75 0 0 1 0-1.5h12a.75.75 0 0 1 .75.75Z"/></g></svg>

    </div>
    <div id="mainsearch"
         class="miansearch absolute w-full top-0 right-0 bg-slate-100 border-b border-slate-300 pr-72 z-20 hidden">
        <form id="searchForm" action="#" class="w-full h-16 flex items-center relative">
            <input class="w-full p-4 bg-slate-100 outline-none text-smid font-medium" type="text"
                   placeholder="جستوجو  ..." onkeyup="searching(this)">
            <div class="close absolute h-full w-16 left-0 flex items-center justify-center cursor-pointer"
                 onclick="closeMainsearch()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="w-6 h-6"><g fill="currentColor"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z" opacity=".5"/><path fill-rule="evenodd" d="M9.301 6.915a.75.75 0 0 1-.042 1.06l-.84.775h5.657c.652 0 1.196 0 1.637.044c.462.046.89.145 1.28.397c.327.211.605.49.816.816c.252.39.351.819.397 1.28c.044.441.044.985.044 1.637V13c0 .652 0 1.196-.044 1.638c-.046.461-.145.89-.397 1.28a2.76 2.76 0 0 1-.816.816c-.39.251-.818.35-1.28.397c-.44.043-.985.043-1.637.043H9.5a.75.75 0 1 1 0-1.5h4.539c.699 0 1.168 0 1.526-.036c.347-.034.507-.095.614-.164a1.25 1.25 0 0 0 .37-.371c.07-.106.13-.267.165-.613c.035-.359.036-.828.036-1.527c0-.7 0-1.169-.036-1.527c-.035-.346-.096-.507-.164-.613a1.249 1.249 0 0 0-.371-.371c-.107-.07-.267-.13-.614-.164c-.358-.036-.827-.037-1.526-.037h-5.62l.84.776a.75.75 0 1 1-1.018 1.102l-2.25-2.077a.75.75 0 0 1 0-1.102l2.25-2.077a.75.75 0 0 1 1.06.043Z" clip-rule="evenodd"/></g></svg>
            </div>
            <div id="searchReturn"
                 class="rounded-b-lg border border-slate-300 bg-slate-100 w-11/12 absolute top-full right-2 pt-6 px-4 hidden">
                <div class="pages">

                    <h2 class="text-smid font-bold text-sky-600">صفحات</h2>

                    <div class="p-2 text-slate-700 space-y-2">
                        <a href="#" class="flex items-center pr-4 border-r-2 border-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                 class="w-5 h-5">
                                <path
                                    d="M12.232 4.232a2.5 2.5 0 013.536 3.536l-1.225 1.224a.75.75 0 001.061 1.06l1.224-1.224a4 4 0 00-5.656-5.656l-3 3a4 4 0 00.225 5.865.75.75 0 00.977-1.138 2.5 2.5 0 01-.142-3.667l3-3z"/>
                                <path
                                    d="M11.603 7.963a.75.75 0 00-.977 1.138 2.5 2.5 0 01.142 3.667l-3 3a2.5 2.5 0 01-3.536-3.536l1.225-1.224a.75.75 0 00-1.061-1.06l-1.224 1.224a4 4 0 105.656 5.656l3-3a4 4 0 00-.225-5.865z"/>
                            </svg>
                            <p class="text-smid font-semibold mr-3">
                                صفحه نظرات
                            </p>
                        </a>

                        <a href="#" class="flex items-center pr-4 border-r-2 border-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                 class="w-5 h-5">
                                <path
                                    d="M12.232 4.232a2.5 2.5 0 013.536 3.536l-1.225 1.224a.75.75 0 001.061 1.06l1.224-1.224a4 4 0 00-5.656-5.656l-3 3a4 4 0 00.225 5.865.75.75 0 00.977-1.138 2.5 2.5 0 01-.142-3.667l3-3z"/>
                                <path
                                    d="M11.603 7.963a.75.75 0 00-.977 1.138 2.5 2.5 0 01.142 3.667l-3 3a2.5 2.5 0 01-3.536-3.536l1.225-1.224a.75.75 0 00-1.061-1.06l-1.224 1.224a4 4 0 105.656 5.656l3-3a4 4 0 00-.225-5.865z"/>
                            </svg>

                            <p class="text-smid font-semibold mr-3">
                                صهحه نظرات
                            </p>
                        </a>

                        <a href="#" class="flex items-center pr-4 border-r-2 border-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                 class="w-5 h-5">
                                <path
                                    d="M12.232 4.232a2.5 2.5 0 013.536 3.536l-1.225 1.224a.75.75 0 001.061 1.06l1.224-1.224a4 4 0 00-5.656-5.656l-3 3a4 4 0 00.225 5.865.75.75 0 00.977-1.138 2.5 2.5 0 01-.142-3.667l3-3z"/>
                                <path
                                    d="M11.603 7.963a.75.75 0 00-.977 1.138 2.5 2.5 0 01.142 3.667l-3 3a2.5 2.5 0 01-3.536-3.536l1.225-1.224a.75.75 0 00-1.061-1.06l-1.224 1.224a4 4 0 105.656 5.656l3-3a4 4 0 00-.225-5.865z"/>
                            </svg>

                            <p class="text-smid font-semibold mr-3">
                                صهحه نظرات
                            </p>
                        </a>

                    </div>
                </div>
            </div>
        </form>

    </div>

</header>
