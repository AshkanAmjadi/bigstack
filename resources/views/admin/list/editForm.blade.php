<form id="edit_list_{{$l1->id}}" action="{{route($prefix.'update',[$name_en=>$l1->id])}}"
      class="space-y-3 space-y-reverse" method="POST">
    @csrf
    @method('PUt')


{{--    <div class="wraper text-center !mt-10">--}}
{{--        <h2 class="text-mid font-semibold mb-2">آیکون حالت روشن</h2>--}}

{{--        <div class="inline-block w-20 h-20 border-8 rounded-2xl border-slate-500/50 bg-white overflow-hidden">--}}
{{--            <label for="listIcon_edit_{{$l1->id}}"--}}
{{--                   class="image w-full h-full inline-flex items-center justify-center back-image-default overflow-hidden"--}}
{{--                   style="background-image: url({{$l1->icon ? imgUrlMaker2($l1,'icon') : ''}})"--}}

{{--            >--}}
{{--                <svg class="uploadIcon fill-slate-800 {{$l1->icon ? 'hidden' : ''}} placeholder w-8 h-8"--}}
{{--                     viewBox="0 0 24 24" fill="none"--}}
{{--                     xmlns="http://www.w3.org/2000/svg">--}}
{{--                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>--}}
{{--                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>--}}
{{--                    <g id="SVGRepo_iconCarrier">--}}
{{--                        <path fill-rule="evenodd" clip-rule="evenodd"--}}
{{--                              d="M12 15.75C12.4142 15.75 12.75 15.4142 12.75 15V4.02744L14.4306 5.98809C14.7001 6.30259 15.1736 6.33901 15.4881 6.06944C15.8026 5.79988 15.839 5.3264 15.5694 5.01191L12.5694 1.51191C12.427 1.34567 12.2189 1.25 12 1.25C11.7811 1.25 11.573 1.34567 11.4306 1.51191L8.43056 5.01191C8.16099 5.3264 8.19741 5.79988 8.51191 6.06944C8.8264 6.33901 9.29988 6.30259 9.56944 5.98809L11.25 4.02744L11.25 15C11.25 15.4142 11.5858 15.75 12 15.75Z"></path>--}}
{{--                        <path class="opacity-75"--}}
{{--                              d="M16 9C15.2978 9 14.9467 9 14.6945 9.16851C14.5853 9.24148 14.4915 9.33525 14.4186 9.44446C14.25 9.69667 14.25 10.0478 14.25 10.75L14.25 15C14.25 16.2426 13.2427 17.25 12 17.25C10.7574 17.25 9.75004 16.2426 9.75004 15L9.75004 10.75C9.75004 10.0478 9.75004 9.69664 9.58149 9.4444C9.50854 9.33523 9.41481 9.2415 9.30564 9.16855C9.05341 9 8.70227 9 8 9C5.17157 9 3.75736 9 2.87868 9.87868C2 10.7574 2 12.1714 2 14.9998V15.9998C2 18.8282 2 20.2424 2.87868 21.1211C3.75736 21.9998 5.17157 21.9998 8 21.9998H16C18.8284 21.9998 20.2426 21.9998 21.1213 21.1211C22 20.2424 22 18.8282 22 15.9998V14.9998C22 12.1714 22 10.7574 21.1213 9.87868C20.2426 9 18.8284 9 16 9Z"></path>--}}
{{--                    </g>--}}
{{--                </svg>--}}

{{--            </label>--}}
{{--        </div>--}}
{{--        --}}{{--        <h2 class="text-sm font-bold mt-2 text-rose-600">بدون آیکون</h2>--}}
{{--        <h2 id="delete_icon{{$l1->id}}" class="deleteImg @if(!$l1->icon) hidden @endif" onclick="deleteImageList(this,{{$l1->id}},'icon')">--}}
{{--            <div class="flex justify-center flex-col items-center gap-3">--}}
{{--                @component('component.btn.btnD',['title' => 'حذف عکس','color'=>'rose','tabindex'=>true])--}}
{{--                @endcomponent--}}
{{--                <svg class="animate-spin loader !h-6 !w-6 text-teal-500 hidden" xmlns="http://www.w3.org/2000/svg" fill="none"--}}
{{--                     viewBox="0 0 24 24">--}}
{{--                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>--}}
{{--                    <path class="opacity-75" fill="currentColor"--}}
{{--                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>--}}
{{--                </svg>--}}
{{--            </div>--}}
{{--        </h2>--}}
{{--        <input id="listIcon_edit_{{$l1->id}}" class="form-file w-full hidden" type="file" onchange="simpleImage(this)">--}}
{{--        <input class="mainInputImage form-file w-full hidden" type="text" name="icon">--}}

{{--    </div>--}}

{{--    <div class="wraper text-center !mt-10">--}}
{{--        <h2 class="text-mid font-semibold mb-2">آیکون حالت تاریک</h2>--}}

{{--        <div class="inline-block w-20 h-20 border-8 rounded-2xl border-slate-500/50 bg-slate-900 overflow-hidden">--}}
{{--            <label for="list_dark_icon_edit_{{$l1->id}}"--}}
{{--                   class="image w-full h-full inline-flex items-center justify-center back-image-default overflow-hidden"--}}
{{--                   style="background-image: url({{$l1->dark_icon ? imgUrlMaker2($l1,'dark_icon') : ''}})"--}}

{{--            >--}}
{{--                <svg class="uploadIcon fill-white {{$l1->dark_icon ? 'hidden' : ''}} placeholder w-8 h-8"--}}
{{--                     viewBox="0 0 24 24" fill="none"--}}
{{--                     xmlns="http://www.w3.org/2000/svg">--}}
{{--                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>--}}
{{--                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>--}}
{{--                    <g id="SVGRepo_iconCarrier">--}}
{{--                        <path fill-rule="evenodd" clip-rule="evenodd"--}}
{{--                              d="M12 15.75C12.4142 15.75 12.75 15.4142 12.75 15V4.02744L14.4306 5.98809C14.7001 6.30259 15.1736 6.33901 15.4881 6.06944C15.8026 5.79988 15.839 5.3264 15.5694 5.01191L12.5694 1.51191C12.427 1.34567 12.2189 1.25 12 1.25C11.7811 1.25 11.573 1.34567 11.4306 1.51191L8.43056 5.01191C8.16099 5.3264 8.19741 5.79988 8.51191 6.06944C8.8264 6.33901 9.29988 6.30259 9.56944 5.98809L11.25 4.02744L11.25 15C11.25 15.4142 11.5858 15.75 12 15.75Z"></path>--}}
{{--                        <path class="opacity-75"--}}
{{--                              d="M16 9C15.2978 9 14.9467 9 14.6945 9.16851C14.5853 9.24148 14.4915 9.33525 14.4186 9.44446C14.25 9.69667 14.25 10.0478 14.25 10.75L14.25 15C14.25 16.2426 13.2427 17.25 12 17.25C10.7574 17.25 9.75004 16.2426 9.75004 15L9.75004 10.75C9.75004 10.0478 9.75004 9.69664 9.58149 9.4444C9.50854 9.33523 9.41481 9.2415 9.30564 9.16855C9.05341 9 8.70227 9 8 9C5.17157 9 3.75736 9 2.87868 9.87868C2 10.7574 2 12.1714 2 14.9998V15.9998C2 18.8282 2 20.2424 2.87868 21.1211C3.75736 21.9998 5.17157 21.9998 8 21.9998H16C18.8284 21.9998 20.2426 21.9998 21.1213 21.1211C22 20.2424 22 18.8282 22 15.9998V14.9998C22 12.1714 22 10.7574 21.1213 9.87868C20.2426 9 18.8284 9 16 9Z"></path>--}}
{{--                    </g>--}}
{{--                </svg>--}}

{{--            </label>--}}
{{--        </div>--}}
{{--        --}}{{--        <h2 class="text-sm font-bold mt-2 text-rose-600">بدون آیکون</h2>--}}


{{--        <h2 id="delete_dark_icon{{$l1->id}}" class="deleteImg @if(!$l1->dark_icon) hidden @endif"--}}
{{--            onclick="deleteImageList(this,{{$l1->id}},'dark_icon')">--}}
{{--            <div class="flex justify-center flex-col items-center gap-3">--}}
{{--                @component('component.btn.btnD',['title' => 'حذف عکس','color'=>'rose','tabindex'=>true])--}}

{{--                @endcomponent--}}
{{--                <svg class="animate-spin loader !h-6 !w-6 text-teal-500 hidden" xmlns="http://www.w3.org/2000/svg" fill="none"--}}
{{--                     viewBox="0 0 24 24">--}}
{{--                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>--}}
{{--                    <path class="opacity-75" fill="currentColor"--}}
{{--                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>--}}
{{--                </svg>--}}
{{--            </div>--}}
{{--        </h2>--}}
{{--        <input id="list_dark_icon_edit_{{$l1->id}}" class="form-file w-full hidden" type="file"--}}
{{--               onchange="simpleImage(this)">--}}
{{--        <input class="mainInputImage form-file w-full hidden" type="text" name="dark_icon">--}}

{{--    </div>--}}

    <input type="hidden" name="parent_id" value="{{$l1->parent_id}}">
    <div class="wraper">
        <h2 class="text-sm mr-4 font-semibold">نام</h2>
        <input class="form-input text-smid w-full" name="name" type="text"
               placeholder="نام.." value="{{$l1->name}}">
    </div>

    <div class="row link space-y-2">
        <div class="right">
            <div class="switchWraper">
                <input type="radio" name="type" id="radioLink_edit{{$l1->id}}" value="link"
                       {{$l1->type == 'link' ? 'checked':''}}
                       hidden="">
                @component('component.switch.switchLable')
                    @slot('title')
                        لینک
                    @endslot
                    @slot('for')
                        radioLink_edit{{$l1->id}}
                    @endslot
                @endcomponent
            </div>
        </div>
        <div class="inputs">
            <input class="form-input text-smid w-full" name="link" dir="ltr"
                   placeholder="https://webmooz.com" value="{{$l1->link}}">
        </div>
    </div>
    <div class="row category space-y-2">
        <div class="right">
            <div class="switchWraper">
                <input type="radio" name="type" id="radioCat_edit{{$l1->id}}" value="category"
                       {{$l1->type == 'category' ? 'checked':''}}
                       hidden="">
                @component('component.switch.switchLable')
                    @slot('title')
                        دسته
                    @endslot
                    @slot('for')
                        radioCat_edit{{$l1->id}}
                    @endslot
                @endcomponent
            </div>
        </div>
        <div class="inputs">
            @include('admin.list.categorySelect',compact('allCat','l1'))
        </div>
    </div>
    <div class="row page space-y-2">
        <div class="right">
            <div class="switchWraper">
                <input type="radio" name="type" id="radioPage_edit{{$l1->id}}" value="page"
                       {{$l1->type == 'page' ? 'checked':''}} hidden="">
                @component('component.switch.switchLable')
                    @slot('title')
                        برگه
                    @endslot
                    @slot('for')
                        radioPage_edit{{$l1->id}}
                    @endslot
                @endcomponent
            </div>
        </div>
        <div class="inputs">
            @include('admin.list.pageSelect')


        </div>
    </div>

    @component('component.btn.btn',['color'=>'rose'])
        @slot('title')
            ارسال اطلاعات
        @endslot
        @slot('icon')
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M7.5 7.5h-.75A2.25 2.25 0 004.5 9.75v7.5a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25v-7.5a2.25 2.25 0 00-2.25-2.25h-.75m0-3l-3-3m0 0l-3 3m3-3v11.25m6-2.25h.75a2.25 2.25 0 012.25 2.25v7.5a2.25 2.25 0 01-2.25 2.25h-7.5a2.25 2.25 0 01-2.25-2.25v-.75"/>
            </svg>
        @endslot
    @endcomponent

</form>

