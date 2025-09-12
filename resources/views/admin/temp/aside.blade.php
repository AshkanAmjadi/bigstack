<aside id="aside"
       class="hide mini h-full fixed top-0 right-0 border-l border-slate-300 DL-I flex flex-col z-30 ">
    <header class="h-20 flex w-full items-center px-4 mt-4">
        <a href="{{route('home')}}" class="logo w-2/3 dark:hidden">
            <img class="h-16" src="{{logoSrcMaker('logo_img')}}" alt="">
        </a>
        <a href="{{route('home')}}" class="logo w-2/3 dark:!inline-block hidden">
            <img class="h-16" src="{{logoSrcMaker('logo_dark_img')}}" alt="">
        </a>
        <div id="sideCursor" class="cursor w-1/3 cursor-pointer pl-5" onclick="toggleAside(this)">
            <div class="h-5 w-5 float-left border-2 border-blue-500 rounded-full flex justify-center items-center">
                <div class="hidden h-2 w-2 rounded-full bg-blue-500"></div>
            </div>
        </div>
        <div class="close w-1/3 h-full flex items-center justify-center" onclick="hideMenu()">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" width="24" height="24" viewBox="0 0 24 24"><g fill="currentColor"><path d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22Z" opacity=".5"/><path d="M8.97 8.97a.75.75 0 0 1 1.06 0L12 10.94l1.97-1.97a.75.75 0 1 1 1.06 1.06L13.06 12l1.97 1.97a.75.75 0 1 1-1.06 1.06L12 13.06l-1.97 1.97a.75.75 0 0 1-1.06-1.06L10.94 12l-1.97-1.97a.75.75 0 0 1 0-1.06Z"/></g></svg>
        </div>
    </header>
    <nav id="navList" class="p-4 space-y-2 overflow-y-auto">
        @foreach(config('admin-menu')['start'] as $group => $section)
            <div class="divider relative !my-6 ">
                <div class="title absolute w-full text-sm font-medium justify-center flex -top-2">
                    <p class="bg-slate-100 text-slate-400 px-2">{{$section['label']}}</p>
                </div>
            </div>
            @foreach($section['items'] as $item)
                <div class="menuitem">
                    <a href="{{route($item['route'])}}" class="head listItem {{ returnIf(checkCurrentUrlAdm($item['active']),'active') }}">
                        <div class="icon">
                            {!! $item['icon'] !!}
                        </div>
                        <div class="name font-semibold mr-3 mt-1 text-nmid">
                            {{$item['label']}}
                        </div>
                    </a>
                </div>
            @endforeach
        @endforeach
        @foreach(config('admin-menu')['middle'] as $group => $section)
            <div class="divider relative !my-6 ">
                <div class="title absolute w-full text-sm font-medium justify-center flex -top-2">
                    <p class="bg-slate-100 text-slate-400 px-2">{{$section['label']}}</p>
                </div>
            </div>
            @foreach($section['items'] as $item)
                <div class="menuitem">
                    <a href="{{route($item['route'])}}" class="head listItem {{ returnIf(checkCurrentUrlAdm($item['active']),'active') }}">
                        <div class="icon">
                            {!! $item['icon'] !!}
                        </div>
                        <div class="name font-semibold mr-3 mt-1 text-nmid">
                            {{$item['label']}}
                        </div>
                    </a>
                </div>
            @endforeach
        @endforeach



        @if(findInOption('service'))
            <div class="divider relative !my-6 ">
                <div class="title absolute w-full text-sm font-medium justify-center flex -top-2">
                    <p class="bg-slate-100 text-slate-400 px-2">خدمات</p>
                </div>
            </div>

            <div class="menuitem">
                <a href="{{route('admin.service.index')}}" class="head listItem {{ returnIf(checkCurrentUrlAdm(['service.index' , 'service.create']),'active') }}">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" class="w-7 h-7" viewBox="0 0 24 24"><path fill="currentColor" d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12" opacity="0.5"/><path fill="currentColor" d="M13.488 6.446a.75.75 0 0 1 .53.918l-2.588 9.66a.75.75 0 0 1-1.449-.389l2.589-9.659a.75.75 0 0 1 .918-.53M14.97 8.47a.75.75 0 0 1 1.06 0l.209.208c.635.635 1.165 1.165 1.529 1.642c.384.504.654 1.036.654 1.68c0 .644-.27 1.176-.654 1.68c-.364.477-.894 1.007-1.53 1.642l-.208.208a.75.75 0 1 1-1.06-1.06l.171-.172c.682-.682 1.139-1.14 1.434-1.528c.283-.37.347-.586.347-.77c0-.184-.064-.4-.347-.77c-.295-.387-.752-.846-1.434-1.528l-.171-.172a.75.75 0 0 1 0-1.06m-7 0a.75.75 0 0 1 1.06 1.06l-.171.172c-.682.682-1.138 1.14-1.434 1.528c-.283.37-.346.586-.346.77c0 .184.063.4.346.77c.296.387.752.846 1.434 1.528l.172.172a.75.75 0 1 1-1.061 1.06l-.208-.208c-.636-.635-1.166-1.165-1.53-1.642c-.384-.504-.653-1.036-.653-1.68c0-.644.27-1.176.653-1.68c.364-.477.894-1.007 1.53-1.642z"/></svg>
                    </div>
                    <div class="name font-semibold mr-3 mt-1 text-nmid">
                        سرویس ها
                    </div>
                </a>
            </div>
            <div class="menuitem">
                <a href="{{route('admin.project.index')}}" class="head listItem {{ returnIf(checkCurrentUrlAdm(['project.index' , 'project.create']),'active') }}">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" class="w-7 h-7" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M7.292 4.786A5.966 5.966 0 0 0 3 10.416l-.001.18v2.323a.75.75 0 0 1 .305.064a21.543 21.543 0 0 0 17.39 0A.751.751 0 0 1 21 12.92v-2.503a5.966 5.966 0 0 0-4.291-5.63c-.278-.091-1.12-.254-1.506-.324c-2.12-.36-4.286-.36-6.406 0c-.405.076-1.272.248-1.506.324M10 11.926a.747.747 0 0 0-.75.745c0 .411.336.745.75.745h4c.414 0 .75-.334.75-.745a.747.747 0 0 0-.75-.745z" clip-rule="evenodd"/><path fill="currentColor" d="M8.873 3.992A2.25 2.25 0 0 1 11 2.49h2c.983 0 1.82.626 2.126 1.502c.045.13.068.28.077.47c.386.07 1.227.233 1.505.324v-.061c0-.339-.011-.782-.165-1.222A3.75 3.75 0 0 0 13 1h-2a3.75 3.75 0 0 0-3.544 2.503c-.153.44-.165.883-.165 1.222v.06c.233-.075 1.1-.247 1.505-.323c.01-.19.032-.34.077-.47M21 14.477c-.9.382-1.819.704-2.75.966v1.2a.748.748 0 0 1-.75.746a.748.748 0 0 1-.75-.745v-.832A23.055 23.055 0 0 1 3 14.477v1.546a4.495 4.495 0 0 0 3.539 4.381c3.597.794 7.325.794 10.923 0A4.495 4.495 0 0 0 21 16.023z" opacity="0.5"/></svg>
                    </div>
                    <div class="name font-semibold mr-3 mt-1 text-nmid">
                        پروژه ها
                    </div>
                </a>
            </div>
            <div class="menuitem">
                <a href="{{route('admin.possible.index')}}" class="head listItem {{ returnIf(checkCurrentUrlAdm(['possible.index' , 'possible.create']),'active') }}">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" class="w-7 h-7" viewBox="0 0 24 24"><path fill="currentColor" d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12" opacity="0.5"/><path fill="currentColor" d="M10.543 7.517a.75.75 0 1 0-1.086-1.034l-2.314 2.43l-.6-.63a.75.75 0 1 0-1.086 1.034l1.143 1.2a.75.75 0 0 0 1.086 0zM13 8.25a.75.75 0 0 0 0 1.5h5a.75.75 0 0 0 0-1.5zm-2.457 6.267a.75.75 0 1 0-1.086-1.034l-2.314 2.43l-.6-.63a.75.75 0 1 0-1.086 1.034l1.143 1.2a.75.75 0 0 0 1.086 0zM13 15.25a.75.75 0 0 0 0 1.5h5a.75.75 0 0 0 0-1.5z"/></svg>
                    </div>
                    <div class="name font-semibold mr-3 mt-1 text-nmid">
                        امکانات
                    </div>
                </a>
            </div>
        @endif

        <div class="divider relative !my-6 ">
            <div class="title absolute w-full text-sm font-medium justify-center flex -top-2">
                <p class="bg-slate-100 text-slate-400 px-2">اعضای سایت</p>
            </div>
        </div>


        <div class="menuitem relative">
            @if($newCom = \App\Models\Comment::query()->where('new' , '=' , '1')->count())
                @component('component.badg.badg',['shadow'=>false,'color'=>'rose' ,'class' => 'number absolute -right-1 -top-1 z-10'])
                    @slot('title')
                        {{$newCom}}
                    @endslot
                @endcomponent
            @endif
            <a href="{{route('admin.comment.index')}}" class="head listItem {{ returnIf(checkCurrentUrlAdm(['comment.index' ]),'active') }}">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="h-7 w-7" viewBox="0 0 24 24"><g fill="currentColor"><path d="m13.629 20.472l-.542.916c-.483.816-1.69.816-2.174 0l-.542-.916c-.42-.71-.63-1.066-.968-1.262c-.338-.197-.763-.204-1.613-.219c-1.256-.021-2.043-.098-2.703-.372a5 5 0 0 1-2.706-2.706C2 14.995 2 13.83 2 11.5v-1c0-3.273 0-4.91.737-6.112a5 5 0 0 1 1.65-1.651C5.59 2 7.228 2 10.5 2h3c3.273 0 4.91 0 6.113.737a5 5 0 0 1 1.65 1.65C22 5.59 22 7.228 22 10.5v1c0 2.33 0 3.495-.38 4.413a5 5 0 0 1-2.707 2.706c-.66.274-1.447.35-2.703.372c-.85.015-1.275.022-1.613.219c-.338.196-.548.551-.968 1.262Z" opacity=".5"/><path d="M7.25 9A.75.75 0 0 1 8 8.25h8a.75.75 0 0 1 0 1.5H8A.75.75 0 0 1 7.25 9Zm0 3.5a.75.75 0 0 1 .75-.75h5.5a.75.75 0 0 1 0 1.5H8a.75.75 0 0 1-.75-.75Z"/></g></svg>
                </div>
                <div class="name font-semibold mr-3 mt-1 text-nmid">
                    نظرات کاربران
                </div>
            </a>
        </div>
        <div class="menuitem relative ">
            @if($newCon = \App\Models\Conversation::query()->where('new' , '=' , '1')->count())
                @component('component.badg.badg',['shadow'=>false,'color'=>'rose' ,'class' => 'number absolute -right-1 -top-1 z-10'])
                    @slot('title')
                        {{$newCon}}
                    @endslot
                @endcomponent
            @endif

            <a href="{{route('admin.conversation.index')}}" class="head listItem {{ returnIf(checkCurrentUrlAdm(['conversation.index' , 'conversation.create']),'active') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="w-6 h-6" viewBox="0 0 24 24"><g fill="currentColor"><path d="m13.087 21.388l.542-.916c.42-.71.63-1.066.968-1.262c.338-.197.763-.204 1.613-.219c1.256-.021 2.043-.098 2.703-.372a5 5 0 0 0 2.706-2.706C22 14.995 22 13.83 22 11.5v-1l-.001-1.048c-.001-.427-.524-.669-.902-.47a4.5 4.5 0 0 1-6.08-6.08c.2-.377-.041-.9-.469-.9C14.218 2 13.87 2 13.5 2h-3c-3.273 0-4.91 0-6.112.737a5 5 0 0 0-1.651 1.65C2 5.59 2 7.228 2 10.5v1c0 2.33 0 3.495.38 4.413a5 5 0 0 0 2.707 2.706c.66.274 1.447.35 2.703.372c.85.015 1.275.022 1.613.219c.337.196.548.551.968 1.262l.542.916c.483.816 1.69.816 2.174 0Z"/><circle opacity=".8" cx="19" cy="5" r="3"/></g></svg>
                <div class="name font-semibold mr-3 mt-1 text-nmid">
                    Discuss
                </div>
            </a>
        </div>
        <div class="menuitem relative">
            @if($newAns = \App\Models\Answer::query()->where('new' , '=' , '1')->count())
                @component('component.badg.badg',['shadow'=>false,'color'=>'rose' ,'class' => 'number absolute -right-1 -top-1 z-10'])
                    @slot('title')
                        {{$newAns}}
                    @endslot
                @endcomponent
            @endif
            <a href="{{route('admin.answer.index')}}" class="head listItem {{ returnIf(checkCurrentUrlAdm(['answer.index']),'active') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="w-6 h-6" viewBox="0 0 24 24"><g fill="currentColor"><path d="m12.984 22.495l.537-.907c.416-.703.625-1.055.96-1.25c.334-.194.755-.201 1.598-.216c1.243-.021 2.023-.097 2.678-.368a4.952 4.952 0 0 0 2.68-2.68c.186-.446.28-.951.328-1.623c.025-.355.038-.533-.057-.675c-.095-.143-.275-.203-.636-.324c-1.511-.507-5.014-1.796-6.972-3.451c-2.207-1.867-4.182-5.66-4.889-7.115c-.14-.289-.21-.433-.334-.51c-.123-.076-.28-.074-.592-.071c-2.035.021-2.956.134-3.92.724A4.952 4.952 0 0 0 2.73 5.663C2 6.853 2 8.474 2 11.715v.99c0 2.307 0 3.46.377 4.37a4.952 4.952 0 0 0 2.681 2.679c.654.27 1.434.347 2.678.368c.842.015 1.264.022 1.598.216c.335.195.543.547.96 1.25l.537.907c.478.808 1.674.808 2.153 0Z" opacity=".5"/><path fill-rule="evenodd" d="M14.872.24a.766.766 0 0 1-.008 1.137l-1.102 1.014c.959.009 1.881.03 2.714.083c.715.045 1.386.114 1.97.222c.572.106 1.123.26 1.56.507a5.837 5.837 0 0 1 2 1.839c.48.721.693 1.537.794 2.52c.1.963.1 2.166.1 3.691v.042c0 .445-.387.805-.864.805c-.478 0-.865-.36-.865-.805c0-1.576 0-2.702-.091-3.578c-.09-.864-.26-1.402-.543-1.827a4.16 4.16 0 0 0-1.425-1.31c-.186-.105-.509-.214-1.004-.305a15.098 15.098 0 0 0-1.75-.195A49.94 49.94 0 0 0 13.776 4l1.088 1c.34.313.343.822.008 1.139a.91.91 0 0 1-1.222.007L11.057 3.76a.778.778 0 0 1-.257-.572c0-.215.092-.421.257-.573L13.65.232a.91.91 0 0 1 1.222.007Z" clip-rule="evenodd"/></g></svg>
                <div class="name font-semibold mr-3 mt-1 text-nmid">
                    Answers
                </div>
            </a>
        </div>


        <div class="divider relative !my-6 ">
            <div class="title absolute w-full text-sm font-medium justify-center flex -top-2">
                <p class="bg-slate-100 text-slate-400 px-2">اینسنتاگرام</p>
            </div>
        </div>


        @if(findInOption('instagram_post'))
            <div class="menuitem">
                <a href="{{route('admin.instaArticle.index')}}" class="head listItem {{ returnIf(checkCurrentUrlAdm(['instaArticle.index' , 'instaArticle.create']),'active') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24"><path opacity="0.9" fill="currentColor" d="M12 0C8.74 0 8.333.015 7.053.072C5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053C.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913a5.885 5.885 0 0 0 1.384 2.126A5.868 5.868 0 0 0 4.14 23.37c.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558a5.898 5.898 0 0 0 2.126-1.384a5.86 5.86 0 0 0 1.384-2.126c.296-.765.499-1.636.558-2.913c.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913a5.89 5.89 0 0 0-1.384-2.126A5.847 5.847 0 0 0 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071c1.17.055 1.805.249 2.227.415c.562.217.96.477 1.382.896c.419.42.679.819.896 1.381c.164.422.36 1.057.413 2.227c.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227a3.81 3.81 0 0 1-.899 1.382a3.744 3.744 0 0 1-1.38.896c-.42.164-1.065.36-2.235.413c-1.274.057-1.649.07-4.859.07c-3.211 0-3.586-.015-4.859-.074c-1.171-.061-1.816-.256-2.236-.421a3.716 3.716 0 0 1-1.379-.899a3.644 3.644 0 0 1-.9-1.38c-.165-.42-.359-1.065-.42-2.235c-.045-1.26-.061-1.649-.061-4.844c0-3.196.016-3.586.061-4.861c.061-1.17.255-1.814.42-2.234c.21-.57.479-.96.9-1.381c.419-.419.81-.689 1.379-.898c.42-.166 1.051-.361 2.221-.421c1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678a6.162 6.162 0 1 0 0 12.324a6.162 6.162 0 1 0 0-12.324zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4s4 1.79 4 4s-1.79 4-4 4zm7.846-10.405a1.441 1.441 0 0 1-2.88 0a1.44 1.44 0 0 1 2.88 0z"/></svg>
                    <div class="name font-semibold mr-3 mt-1 text-nmid">
                        پست اینستاگرام
                    </div>
                </a>
            </div>

        @endif
        <div class="menuitem">
            <a href="#" class="head listItem">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="w-7 h-7" viewBox="0 0 24 24"><g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 2.75A9.25 9.25 0 0 1 21.25 12a.75.75 0 0 0 1.5 0c0-5.937-4.813-10.75-10.75-10.75a.75.75 0 0 0 0 1.5Zm0 5.5a.75.75 0 0 1 .75.75v3.25H16a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75V9a.75.75 0 0 1 .75-.75Z"/><path d="M9.1 2.398a.75.75 0 0 1-.43.97a9.187 9.187 0 0 0-.42.174a.75.75 0 1 1-.608-1.371c.16-.072.323-.139.488-.203a.75.75 0 0 1 .97.43ZM5.648 4.241a.75.75 0 0 1-.026 1.06c-.11.105-.217.212-.321.321a.75.75 0 1 1-1.087-1.034c.122-.127.246-.252.373-.373a.75.75 0 0 1 1.06.026ZM3.16 7.26a.75.75 0 0 1 .381.99c-.061.138-.12.278-.174.42a.75.75 0 0 1-1.399-.54c.063-.165.13-.328.202-.488a.75.75 0 0 1 .99-.381Zm-1.139 3.744a.75.75 0 0 1 .732.768a9.446 9.446 0 0 0 0 .456a.75.75 0 1 1-1.5.036a10.949 10.949 0 0 1 0-.529a.75.75 0 0 1 .768-.731ZM21.602 14.9a.75.75 0 0 1 .43.97c-.064.164-.13.327-.202.487a.75.75 0 1 1-1.371-.608c.061-.138.12-.278.174-.42a.75.75 0 0 1 .97-.429Zm-19.204 0a.75.75 0 0 1 .97.43c.054.141.112.28.173.419a.75.75 0 1 1-1.37.608a9.426 9.426 0 0 1-.203-.487a.75.75 0 0 1 .43-.97Zm17.362 3.452c.3.285.311.76.026 1.06a10.75 10.75 0 0 1-.373.373a.75.75 0 1 1-1.035-1.086c.11-.104.217-.212.321-.321a.75.75 0 0 1 1.06-.026Zm-15.52 0a.75.75 0 0 1 1.06.026c.105.11.212.216.322.32a.75.75 0 0 1-1.035 1.087a10.785 10.785 0 0 1-.373-.373a.75.75 0 0 1 .026-1.06Zm3.021 2.488a.75.75 0 0 1 .99-.382c.138.062.278.12.419.174a.75.75 0 0 1-.54 1.4a10.723 10.723 0 0 1-.488-.203a.75.75 0 0 1-.381-.99Zm9.478 0a.75.75 0 0 1-.381.99c-.16.07-.323.138-.488.202a.75.75 0 0 1-.54-1.4c.141-.054.281-.112.42-.174a.75.75 0 0 1 .989.382Zm-5.735 1.139a.75.75 0 0 1 .768-.732a9.606 9.606 0 0 0 .456 0a.75.75 0 0 1 .036 1.5a11.066 11.066 0 0 1-.528 0a.75.75 0 0 1-.732-.768Z" opacity=".5"/></g></svg>
                <div class="name font-semibold mr-3 mt-1 text-nmid">
                    داستان(استوری)
                </div>
            </a>
        </div>


            @foreach(config('admin-menu')['end'] as $group => $section)
                <div class="divider relative !my-6 ">
                    <div class="title absolute w-full text-sm font-medium justify-center flex -top-2">
                        <p class="bg-slate-100 text-slate-400 px-2">{{$section['label']}}</p>
                    </div>
                </div>
                @foreach($section['items'] as $item)
                    <div class="menuitem">
                        <a href="{{route($item['route'])}}" class="head listItem {{ returnIf(checkCurrentUrlAdm($item['active']),'active') }}">
                            <div class="icon">
                                {!! $item['icon'] !!}
                            </div>
                            <div class="name font-semibold mr-3 mt-1 text-nmid">
                                {{$item['label']}}
                            </div>
                        </a>
                    </div>
                @endforeach
            @endforeach




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
