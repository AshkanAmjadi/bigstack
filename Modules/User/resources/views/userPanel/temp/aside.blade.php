<aside id="aside"
       class="hide mini h-full fixed top-0 right-0 border-l border-slate-300 bg-slate-100 flex flex-col z-30 ">
    <header class="h-20 flex w-full items-center px-4">
        <div id="sideCursor" class="cursor w-1/3 cursor-pointer pl-5" onclick="toggleAside(this)">
            <div class="h-5 w-5 float-left border-2 border-blue-500 rounded-full p-1">
                <div class="hidden h-2 w-2 rounded-full bg-blue-500"></div>
            </div>
        </div>
        <div class="close w-1/3 h-full flex items-center justify-center" onclick="hideMenu()">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" width="24" height="24" viewBox="0 0 24 24"><g fill="currentColor"><path d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22Z" opacity=".5"/><path d="M8.97 8.97a.75.75 0 0 1 1.06 0L12 10.94l1.97-1.97a.75.75 0 1 1 1.06 1.06L13.06 12l1.97 1.97a.75.75 0 1 1-1.06 1.06L12 13.06l-1.97 1.97a.75.75 0 0 1-1.06-1.06L10.94 12l-1.97-1.97a.75.75 0 0 1 0-1.06Z"/></g></svg>
        </div>
        <a href="{{route('home')}}" class="logo w-2/3 dark:hidden">
            <img class="h-16" src="{{logoSrcMaker('logo_img')}}" alt="">
        </a>
        <a href="{{route('home')}}" class="logo w-2/3 dark:!inline-block hidden" dir="rtl">
            <img class="h-16" src="{{logoSrcMaker('logo_dark_img')}}" alt="">
        </a>

    </header>
    <nav id="navList" class="p-4 space-y-2 overflow-y-auto">
        <div class="menuitem">
            <a href="{{route('user-panel.index')}}" class="head listItem {{ returnIf(checkCurrentUrl('user-panel.index'),'active') }}">
                <div class="icon-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M14 4h-4C6.229 4 4.343 4 3.172 5.172C2 6.343 2 8.229 2 12c0 3.771 0 5.657 1.172 6.828C4.343 20 6.229 20 10 20h4c3.771 0 5.657 0 6.828-1.172C22 17.657 22 15.771 22 12c0-3.771 0-5.657-1.172-6.828C19.657 4 17.771 4 14 4Z" opacity=".5"/><path fill="currentColor" d="M13.25 9a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75Zm1 3a.75.75 0 0 1 .75-.75h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75Zm1 3a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75ZM9 11a2 2 0 1 0 0-4a2 2 0 0 0 0 4Zm0 6c4 0 4-.895 4-2s-1.79-2-4-2s-4 .895-4 2s0 2 4 2Z"/></svg>
                </div>
                <div class="name font-semibold mr-3 mt-1 text-nmid">
                    Profile
                </div>
            </a>
        </div>
        {{--todo compelete the web options--}}

{{--        <div class="menuitem">--}}
{{--            <a href="{{route('admin.option.index')}}" class="head listItem {{ returnIf(checkCurrentUrlAdm('option.index'),'active') }}">--}}
{{--                <div class="icon">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" width="24" height="24" viewBox="0 0 24 24"><g fill="currentColor"><path fill-rule="evenodd" d="M12.428 2c-1.114 0-2.129.6-4.157 1.802l-.686.406C5.555 5.41 4.542 6.011 3.985 7c-.557.99-.557 2.19-.557 4.594v.812c0 2.403 0 3.605.557 4.594c.557.99 1.57 1.59 3.6 2.791l.686.407C10.299 21.399 11.314 22 12.428 22c1.114 0 2.128-.6 4.157-1.802l.686-.407c2.028-1.2 3.043-1.802 3.6-2.791c.557-.99.557-2.19.557-4.594v-.812c0-2.403 0-3.605-.557-4.594c-.557-.99-1.572-1.59-3.6-2.792l-.686-.406C14.555 2.601 13.542 2 12.428 2Z" clip-rule="evenodd" opacity=".5"/><path d="M12.428 8.25a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5Z"/></g></svg>--}}
{{--                </div>--}}
{{--                <div class="name font-semibold mr-3 mt-1 text-nmid">--}}
{{--                    تنظیمات سایت--}}
{{--                </div>--}}
{{--            </a>--}}
{{--        </div>--}}



        <div class="divider relative !my-6 ">
            <div class="title absolute w-full text-sm font-medium justify-center flex -top-2">
            </div>
        </div>


        <div class="menuitem">
            <a href="{{route('user-panel.conversation')}}" class="head listItem {{ returnIf(checkCurrentUrl('user-panel.conversation'),'active') }}">
                <div class="icon-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M18 14a8 8 0 0 1-11.45 7.22a1.671 1.671 0 0 0-1.15-.13l-1.227.329a1.3 1.3 0 0 1-1.591-1.592L2.91 18.6a1.67 1.67 0 0 0-.13-1.15A8 8 0 1 1 18 14ZM6.5 15a1 1 0 1 0 0-2a1 1 0 0 0 0 2Zm3.5 0a1 1 0 1 0 0-2a1 1 0 0 0 0 2Zm3.5 0a1 1 0 1 0 0-2a1 1 0 0 0 0 2Z" clip-rule="evenodd"/><path fill="currentColor" d="M17.984 14.508a6.43 6.43 0 0 0 .32-.142c.291-.14.622-.189.934-.105l.996.267a1.056 1.056 0 0 0 1.294-1.294l-.267-.996a1.358 1.358 0 0 1 .105-.935A6.5 6.5 0 1 0 9.492 6.016a8 8 0 0 1 8.493 8.493Z" opacity=".6"/></svg>
                </div>
                <div class="name font-semibold mr-3 mt-1 text-nmid">
                    Discuss
                </div>
            </a>
        </div>
        <div class="menuitem">
            <a href="{{route('user-panel.comments')}}" class="head listItem {{ returnIf(checkCurrentUrl('user-panel.comments'),'active') }}">
                <div class="icon-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m13.629 20.472l-.542.916c-.483.816-1.69.816-2.174 0l-.542-.916c-.42-.71-.63-1.066-.968-1.262c-.338-.197-.763-.204-1.613-.219c-1.256-.021-2.043-.098-2.703-.372a5 5 0 0 1-2.706-2.706C2 14.995 2 13.83 2 11.5v-1c0-3.273 0-4.91.737-6.112a5 5 0 0 1 1.65-1.651C5.59 2 7.228 2 10.5 2h3c3.273 0 4.91 0 6.113.737a5 5 0 0 1 1.65 1.65C22 5.59 22 7.228 22 10.5v1c0 2.33 0 3.495-.38 4.413a5 5 0 0 1-2.707 2.706c-.66.274-1.447.35-2.703.372c-.85.015-1.275.022-1.613.219c-.338.196-.548.551-.968 1.262Z" opacity=".5"/><path fill="currentColor" d="M17 11a1 1 0 1 1-2 0a1 1 0 0 1 2 0Zm-4 0a1 1 0 1 1-2 0a1 1 0 0 1 2 0Zm-4 0a1 1 0 1 1-2 0a1 1 0 0 1 2 0Z"/></svg>
                </div>
                <div class="name font-semibold mr-3 mt-1 text-nmid">
                    Comments
                </div>
            </a>
        </div>
        <div class="menuitem">
            <a href="{{route('user-panel.tacts')}}" class="head listItem {{ returnIf(checkCurrentUrl('user-panel.tacts'),'active') }}">
                <div class="icon-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M18 10.853V6h-4v4.853c0 .29 0 .435.095.494c.095.058.224-.007.484-.136l1.242-.622c.088-.043.132-.065.179-.065c.047 0 .091.022.179.065l1.242.622c.26.13.39.194.484.136c.095-.06.095-.204.095-.494Z"/><path fill="currentColor" d="M2 6.95c0-.883 0-1.324.07-1.692A4 4 0 0 1 5.257 2.07C5.626 2 6.068 2 6.95 2c.386 0 .58 0 .766.017a4 4 0 0 1 2.18.904c.144.119.28.255.554.529L11 4c.816.816 1.224 1.224 1.712 1.495a4 4 0 0 0 .848.352C14.098 6 14.675 6 15.828 6h.374c2.632 0 3.949 0 4.804.77c.079.07.154.145.224.224c.77.855.77 2.172.77 4.804V14c0 3.771 0 5.657-1.172 6.828C19.657 22 17.771 22 14 22h-4c-3.771 0-5.657 0-6.828-1.172C2 19.657 2 17.771 2 14V6.95Z" opacity=".5"/></svg>
                </div>
                <div class="name font-semibold mr-3 mt-1 text-nmid">
                    Activity
                </div>
            </a>
        </div>



        <div class="divider relative !my-6 ">
            <div class="title absolute w-full text-sm font-medium justify-center flex -top-2">
            </div>
        </div>

        <div class="menuitem">
            <a href="{{route('user-panel.logins')}}" class="head listItem {{ returnIf(checkCurrentUrl('user-panel.logins'),'active') }}">
                <div class="icon-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z" opacity=".5"/><path fill="currentColor" d="M17.576 10.48a.75.75 0 0 0-1.152-.96l-1.797 2.156c-.37.445-.599.716-.786.885a.764.764 0 0 1-.163.122l-.011.005l-.008-.004l-.003-.001a.764.764 0 0 1-.164-.122c-.187-.17-.415-.44-.786-.885l-.292-.35c-.328-.395-.625-.75-.901-1c-.301-.272-.68-.514-1.18-.514c-.5 0-.878.242-1.18.514c-.276.25-.572.605-.9 1l-1.83 2.194a.75.75 0 0 0 1.153.96l1.797-2.156c.37-.445.599-.716.786-.885a.769.769 0 0 1 .163-.122l.007-.003l.004-.001c.003 0 .006.002.011.004a.768.768 0 0 1 .164.122c.187.17.415.44.786.885l.292.35c.329.395.625.75.901 1c.301.272.68.514 1.18.514c.5 0 .878-.242 1.18-.514c.276-.25.572-.605.9-1l1.83-2.194Z"/></svg>
                </div>
                <div class="name font-semibold mr-3 mt-1 text-nmid">
                    Sessions
                </div>
            </a>
        </div>
        <div class="divider relative !my-6 ">
            <div class="title absolute w-full text-sm font-medium justify-center flex -top-2">
            </div>
        </div>
        <div class="menuitem relative">
            @if($newCom = \Modules\User\App\Models\UserAllert::query()->where('user_id','=',auth()->id())->where('new' , '=' , '1')->count())
                @component('component.badg.badg',['shadow'=>false,'color'=>'rose' ,'class' => 'number absolute -right-1 -top-1 z-10'])
                    @slot('title')
                        {{$newCom}}
                    @endslot
                @endcomponent
            @endif
            <a href="{{route('user-panel.allerts')}}" class="head listItem {{ returnIf(checkCurrentUrl('user-panel.allerts'),'active') }}">
                <div class="icon-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M18.75 9v.704c0 .845.24 1.671.692 2.374l1.108 1.723c1.011 1.574.239 3.713-1.52 4.21a25.794 25.794 0 0 1-14.06 0c-1.759-.497-2.531-2.636-1.52-4.21l1.108-1.723a4.393 4.393 0 0 0 .693-2.374V9c0-3.866 3.022-7 6.749-7s6.75 3.134 6.75 7Z" opacity=".5"/><path fill="currentColor" d="M12.75 6a.75.75 0 0 0-1.5 0v4a.75.75 0 0 0 1.5 0V6ZM7.243 18.545a5.002 5.002 0 0 0 9.513 0c-3.145.59-6.367.59-9.513 0Z"/></svg>
                </div>
                <div class="name font-semibold mr-3 mt-1 text-nmid">
                    Allerts
                </div>
            </a>
        </div>
        <div class="divider relative !my-6 ">
            <div class="title absolute w-full text-sm font-medium justify-center flex -top-2">
            </div>
        </div>

        <div class="menuitem ">
            <a href="{{route('logout')}}" class="head !text-rose-600 listItem hover:!bg-rose-600 hover:!text-white">
                <div class="icon-md ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M9.052 4.5C9 5.078 9 5.804 9 6.722v10.556c0 .918 0 1.644.052 2.222H8c-2.357 0-3.536 0-4.268-.732C3 18.035 3 16.857 3 14.5v-5c0-2.357 0-3.536.732-4.268C4.464 4.5 5.643 4.5 8 4.5h1.052Z" opacity=".5"/><path fill="currentColor" fill-rule="evenodd" d="M9.707 2.409C9 3.036 9 4.183 9 6.476v11.048c0 2.293 0 3.44.707 4.067c.707.627 1.788.439 3.95.062l2.33-.406c2.394-.418 3.591-.627 4.302-1.505c.711-.879.711-2.149.711-4.69V8.948c0-2.54 0-3.81-.71-4.689c-.712-.878-1.91-1.087-4.304-1.504l-2.328-.407c-2.162-.377-3.243-.565-3.95.062Zm3.043 8.545c0-.434-.336-.785-.75-.785s-.75.351-.75.784v2.094c0 .433.336.784.75.784s.75-.351.75-.784v-2.094Z" clip-rule="evenodd"/></svg>
                </div>
                <div class="name font-semibold mr-3 mt-1 text-nmid">
                    Log Out
                </div>
            </a>
        </div>



{{--        <div class="divider relative !my-6 ">--}}
{{--            <div class="title absolute w-full text-sm font-medium justify-center flex -top-2">--}}
{{--                <p class="bg-slate-100 text-slate-400 px-2">غیره</p>--}}
{{--            </div>--}}
{{--        </div>--}}




{{--        <div class="menuList">--}}
{{--            <a class="head listItem">--}}
{{--                <div class="icon">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">--}}
{{--                        <path d="M10 3.75a2 2 0 10-4 0 2 2 0 004 0zM17.25 4.5a.75.75 0 000-1.5h-5.5a.75.75 0 000 1.5h5.5zM5 3.75a.75.75 0 01-.75.75h-1.5a.75.75 0 010-1.5h1.5a.75.75 0 01.75.75zM4.25 17a.75.75 0 000-1.5h-1.5a.75.75 0 000 1.5h1.5zM17.25 17a.75.75 0 000-1.5h-5.5a.75.75 0 000 1.5h5.5zM9 10a.75.75 0 01-.75.75h-5.5a.75.75 0 010-1.5h5.5A.75.75 0 019 10zM17.25 10.75a.75.75 0 000-1.5h-1.5a.75.75 0 000 1.5h1.5zM14 10a2 2 0 10-4 0 2 2 0 004 0zM10 16.25a2 2 0 10-4 0 2 2 0 004 0z"/>--}}
{{--                    </svg>--}}
{{--                </div>--}}
{{--                <div class="name font-semibold mr-3 mt-1 text-nmid">--}}
{{--                    تنظیمات--}}
{{--                </div>--}}
{{--                <div class="extra">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"--}}
{{--                         stroke="currentColor" class="">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round"--}}
{{--                              d="M16.5 8.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v8.25A2.25 2.25 0 006 16.5h2.25m8.25-8.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-7.5A2.25 2.25 0 018.25 18v-1.5m8.25-8.25h-6a2.25 2.25 0 00-2.25 2.25v6"/>--}}
{{--                    </svg>--}}
{{--                </div>--}}
{{--            </a>--}}
{{--            <ul class="listItems h-0 overflow-hidden trans px-2">--}}
{{--                <li class="listItem">--}}
{{--                    <div class="icon">--}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">--}}
{{--                            <path d="M5.25 3A2.25 2.25 0 003 5.25v9.5A2.25 2.25 0 005.25 17h9.5A2.25 2.25 0 0017 14.75v-9.5A2.25 2.25 0 0014.75 3h-9.5z"/>--}}
{{--                        </svg>--}}
{{--                    </div>--}}
{{--                    <div class="name font-semibold mr-3 mt-1 text-nmid">--}}
{{--                        هدر--}}
{{--                    </div>--}}
{{--                </li>--}}

{{--                <li class="subMenuList open">--}}
{{--                    <a class="head listItem">--}}
{{--                        <div class="icon">--}}
{{--                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"--}}
{{--                                 class="w-5 h-5">--}}
{{--                                <path d="M10 3.75a2 2 0 10-4 0 2 2 0 004 0zM17.25 4.5a.75.75 0 000-1.5h-5.5a.75.75 0 000 1.5h5.5zM5 3.75a.75.75 0 01-.75.75h-1.5a.75.75 0 010-1.5h1.5a.75.75 0 01.75.75zM4.25 17a.75.75 0 000-1.5h-1.5a.75.75 0 000 1.5h1.5zM17.25 17a.75.75 0 000-1.5h-5.5a.75.75 0 000 1.5h5.5zM9 10a.75.75 0 01-.75.75h-5.5a.75.75 0 010-1.5h5.5A.75.75 0 019 10zM17.25 10.75a.75.75 0 000-1.5h-1.5a.75.75 0 000 1.5h1.5zM14 10a2 2 0 10-4 0 2 2 0 004 0zM10 16.25a2 2 0 10-4 0 2 2 0 004 0z"/>--}}
{{--                            </svg>--}}
{{--                        </div>--}}
{{--                        <div class="name font-semibold mr-3 mt-1 text-nmid">--}}
{{--                            تنظیمات--}}
{{--                        </div>--}}
{{--                        <div class="extra">--}}
{{--                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"--}}
{{--                                 stroke="currentColor" class="">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round"--}}
{{--                                      d="M16.5 8.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v8.25A2.25 2.25 0 006 16.5h2.25m8.25-8.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-7.5A2.25 2.25 0 018.25 18v-1.5m8.25-8.25h-6a2.25 2.25 0 00-2.25 2.25v6"/>--}}
{{--                            </svg>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                    <ul class="listItems h-0 overflow-hidden trans px-2">--}}
{{--                        <li class="listItem active">--}}
{{--                            <div class="icon">--}}
{{--                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"--}}
{{--                                     class="w-5 h-5">--}}
{{--                                    <path d="M5.25 3A2.25 2.25 0 003 5.25v9.5A2.25 2.25 0 005.25 17h9.5A2.25 2.25 0 0017 14.75v-9.5A2.25 2.25 0 0014.75 3h-9.5z"/>--}}
{{--                                </svg>--}}
{{--                            </div>--}}
{{--                            <div class="name font-semibold mr-3 mt-1 text-nmid">--}}
{{--                                هدر--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="listItem">--}}
{{--                            <div class="icon">--}}
{{--                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"--}}
{{--                                     class="w-5 h-5">--}}
{{--                                    <path d="M5.25 3A2.25 2.25 0 003 5.25v9.5A2.25 2.25 0 005.25 17h9.5A2.25 2.25 0 0017 14.75v-9.5A2.25 2.25 0 0014.75 3h-9.5z"/>--}}
{{--                                </svg>--}}
{{--                            </div>--}}
{{--                            <div class="name font-semibold mr-3 mt-1 text-nmid">--}}
{{--                                هدر--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--        </div>--}}



    </nav>
</aside>
