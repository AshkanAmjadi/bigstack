@extends('admin.master')
@php

    $prefix = 'admin.users.';
    $name_en = 'user';
    $name_fa = 'کاربران';
    $name_fa_fard = 'کاربر';

    $genders = [
        'man'=>'مرد',
        'woman'=>'زن',
        'other'=>'غیره'
]
@endphp
@section('cssScripts')


    @parent

@endsection

@section('title',$name_fa)

@section('content')

    <div id="content" class="mini w-full pt-16 text-slate-700 pb-6 overflow-x-clip">

        <div id="contentWraper" class="w-11/12 mx-auto mt-16 lg:w-96p sm:w-full space-y-6">
            <h2 class="font-bold text-felg mr-6 mb-2 md:mr-3">
                {{$name_fa}}
            </h2>

            @include('user::admin.users.action')


            <div class="overflow-x-auto overflow-y-clip">
                <table class="w-full table-style-shadow-td min-w-[1000px]">
                    <thead>
                    <tr>
                        <th class="text-right">نام</th>
                        <th class="text-right">ایمیل</th>
                        <th class="text-right">شماره تلفن</th>
                        <th class="text-right">ساخته شده توسط</th>
                        <th class="text-right">ویرایش شده توسط</th>
                        <th class="text-right">اعمال</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($list as $subject)

                        <tr>


                            <td class="max-w-[300px]">
                                <div class="flex gap-3 items-center flex-wrap">
                                    <div class="row flex gap-3 items-center flex-wrap">
                                        <div class="avatar">
                                            <img class="pointer-events-none"
                                                 src="{{$subject->avatar ? imgUrlMaker2($subject,'avatar') : asset('assets/img/default.png')}}"
                                                 alt="img/user.png">

                                        </div>
                                        <h2 class="font-bold text-smid">{{$subject->name ? :'بدون نام'}}</h2>
                                    </div>

                                    <div class="row">
                                        <div class="flex flex-wrap gap-2">
                                            @include('user::component.user.semat',['subject' => $subject])

                                            @component('component.badg.badg' ,['color' => 'emerald'])
                                                @slot('title')
                                                    جنسیت : {{$subject->gender ? $genders[$subject->gender] : 'وارد نشده'}}
                                                @endslot
                                            @endcomponent
                                            @if($subject->melicode)
                                                @component('component.badg.badg' ,['color' => 'indigo'])
                                                    @slot('title')
                                                        کد ملی : {{$subject->melicode}}
                                                    @endslot
                                                @endcomponent
                                            @endif
                                            @if($subject->username)
                                                <a href="{{route('profile',['username' => $subject->username])}}" target="_blank">
                                                    @if($subject->username)
                                                        @component('component.badg.badg' ,['color' => 'orange'])
                                                            @slot('title')
                                                                شناسه کاربری : {{$subject->username}}@
                                                            @endslot
                                                        @endcomponent
                                                    @endif
                                                </a>
                                            @endif

                                            @if($subject->year and $subject->day and $subject->month)
                                                    @component('component.badg.badg' ,['color' => 'sky'])
                                                        @slot('title')
                                                            تاریخ تولد :
                                                            {{$subject->day}}\{{$subject->month}}\{{$subject->year}}
                                                        @endslot
                                                    @endcomponent

                                            @endif


                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="row">
                                    <h2 class="font-bold text-smid">{{$subject->email ? :'بدون ایمیل'}}</h2>
                                    @if($subject->email)
                                        @if($subject->email_verify)
                                            @component('component.badg.badg' ,['color' => 'blue'])
                                                @slot('title')
                                                    معتبر
                                                @endslot
                                            @endcomponent
                                        @else
                                            @component('component.badg.badg' ,['color' => 'gray'])
                                                @slot('title')
                                                    نامعتبر
                                                @endslot
                                            @endcomponent
                                        @endif
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <h2 class="font-bold text-smid">{{$subject->phone ? :'بدون شماره تماس'}}</h2>
                                    @if($subject->phone)
                                        @if($subject->phone_verify)
                                            @component('component.badg.badg' ,['color' => 'blue'])
                                                @slot('title')
                                                    معتبر
                                                @endslot
                                            @endcomponent
                                        @else
                                            @component('component.badg.badg' ,['color' => 'gray'])
                                                @slot('title')
                                                    نامعتبر
                                                @endslot
                                            @endcomponent
                                        @endif
                                    @endif
                                </div>
                            </td>
                            <td>

                                <div class="flex items-center gap-3 flex-wrap">
                                    @include('user::admin.component.who' , ['relation' => 'added_by'])
                                </div>

                            </td>
                            <td>

                                <div class="flex items-center gap-3 flex-wrap">
                                    @include('user::admin.component.who' , ['relation' => 'updated_by'])
                                </div>

                            </td>

                            <td>
                                <div class="flex flex-wrap gap-2 items-center">
                                    <form class="delete"
                                          action="{{ route($prefix.'destroy',[$name_en=>$subject->id]) }}"
                                          method="post">
                                        @csrf
                                        @method('DELETE')
                                        @component('component.btn.btnD',['color'=>'red','tabindex' => true])
                                            @slot('icon')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="2 2 22 22">
                                                    <g fill="currentColor">
                                                        <path
                                                            d="M3 6.386c0-.484.345-.877.771-.877h2.665c.529-.016.996-.399 1.176-.965l.03-.1l.115-.391c.07-.24.131-.45.217-.637c.338-.739.964-1.252 1.687-1.383c.184-.033.378-.033.6-.033h3.478c.223 0 .417 0 .6.033c.723.131 1.35.644 1.687 1.383c.086.187.147.396.218.637l.114.391l.03.1c.18.566.74.95 1.27.965h2.57c.427 0 .772.393.772.877s-.345.877-.771.877H3.77c-.425 0-.77-.393-.77-.877Z"/>
                                                        <path fill-rule="evenodd"
                                                              d="M9.425 11.482c.413-.044.78.273.821.707l.5 5.263c.041.433-.26.82-.671.864c-.412.043-.78-.273-.821-.707l-.5-5.263c-.041-.434.26-.821.671-.864Zm5.15 0c.412.043.713.43.671.864l-.5 5.263c-.04.434-.408.75-.82.707c-.413-.044-.713-.43-.672-.864l.5-5.264c.041-.433.409-.75.82-.707Z"
                                                              clip-rule="evenodd"/>
                                                        <path
                                                            d="M11.596 22h.808c2.783 0 4.174 0 5.08-.886c.904-.886.996-2.339 1.181-5.245l.267-4.188c.1-1.577.15-2.366-.303-2.865c-.454-.5-1.22-.5-2.753-.5H8.124c-1.533 0-2.3 0-2.753.5c-.454.5-.404 1.288-.303 2.865l.267 4.188c.185 2.906.277 4.36 1.182 5.245c.905.886 2.296.886 5.079.886Z"
                                                            opacity=".5"/>
                                                    </g>
                                                </svg>
                                            @endslot
                                            @component('component.dropdown.dropdown',['title' => 'توجه!!'])
                                                @slot('text')
                                                    از حذف کردن این {{$name_fa_fard}} مطمئن هستید؟
                                                @endslot
                                                @slot('btns')

                                                    @component('component.btn.btnD',['title' => 'حذف' , 'color' => 'rose' ,'size' => 'sm','id'=>'Delete'.$subject->id,'shadow'=>false])
                                                        @slot('action')
                                                            onclick="this.closest('.delete').submit()"
                                                        @endslot
                                                        @slot('icon')
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                 height="24"
                                                                 viewBox="2 2 22 22">
                                                                <g fill="currentColor">
                                                                    <path
                                                                        d="M3 6.386c0-.484.345-.877.771-.877h2.665c.529-.016.996-.399 1.176-.965l.03-.1l.115-.391c.07-.24.131-.45.217-.637c.338-.739.964-1.252 1.687-1.383c.184-.033.378-.033.6-.033h3.478c.223 0 .417 0 .6.033c.723.131 1.35.644 1.687 1.383c.086.187.147.396.218.637l.114.391l.03.1c.18.566.74.95 1.27.965h2.57c.427 0 .772.393.772.877s-.345.877-.771.877H3.77c-.425 0-.77-.393-.77-.877Z"/>
                                                                    <path fill-rule="evenodd"
                                                                          d="M9.425 11.482c.413-.044.78.273.821.707l.5 5.263c.041.433-.26.82-.671.864c-.412.043-.78-.273-.821-.707l-.5-5.263c-.041-.434.26-.821.671-.864Zm5.15 0c.412.043.713.43.671.864l-.5 5.263c-.04.434-.408.75-.82.707c-.413-.044-.713-.43-.672-.864l.5-5.264c.041-.433.409-.75.82-.707Z"
                                                                          clip-rule="evenodd"/>
                                                                    <path
                                                                        d="M11.596 22h.808c2.783 0 4.174 0 5.08-.886c.904-.886.996-2.339 1.181-5.245l.267-4.188c.1-1.577.15-2.366-.303-2.865c-.454-.5-1.22-.5-2.753-.5H8.124c-1.533 0-2.3 0-2.753.5c-.454.5-.404 1.288-.303 2.865l.267 4.188c.185 2.906.277 4.36 1.182 5.245c.905.886 2.296.886 5.079.886Z"
                                                                        opacity=".5"/>
                                                                </g>
                                                            </svg>
                                                        @endslot

                                                    @endcomponent

                                                @endslot
                                            @endcomponent
                                        @endcomponent

                                    </form>

                                    @component('component.btn.linkBtn',['href' => route($prefix.'edit',[$name_en=>$subject->id])])
                                        @slot('icon')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24">
                                                <g fill="currentColor">
                                                    <path
                                                        d="M1 12c0-5.185 0-7.778 1.61-9.39C4.223 1 6.816 1 12 1c5.185 0 7.778 0 9.39 1.61C23 4.223 23 6.816 23 12c0 5.185 0 7.778-1.61 9.39C19.777 23 17.184 23 12 23c-5.185 0-7.778 0-9.39-1.61C1 19.777 1 17.184 1 12Z"
                                                        opacity=".5"/>
                                                    <path
                                                        d="M13.926 14.302c.245-.191.467-.413.912-.858l5.54-5.54c.134-.134.073-.365-.106-.427a6.066 6.066 0 0 1-2.3-1.449a6.066 6.066 0 0 1-1.45-2.3c-.061-.18-.292-.24-.426-.106l-5.54 5.54c-.445.444-.667.667-.858.912a5.045 5.045 0 0 0-.577.932c-.133.28-.233.579-.431 1.175l-.257.77l-.409 1.226l-.382 1.148a.817.817 0 0 0 1.032 1.033l1.15-.383l1.224-.408l.77-.257c.597-.199.895-.298 1.175-.432a5.03 5.03 0 0 0 .933-.576Zm8.187-8.132a3.028 3.028 0 0 0-4.282-4.283l-.179.178a.734.734 0 0 0-.206.651c.027.15.077.37.168.633a4.911 4.911 0 0 0 1.174 1.863a4.91 4.91 0 0 0 1.862 1.174c.263.09.483.141.633.168c.24.043.48-.035.652-.207l.178-.178Z"/>
                                                </g>
                                            </svg>
                                        @endslot
                                    @endcomponent
                                    @component('component.btn.btnD',['color'=>'indigo','tabindex'=>true])
                                        @slot('action')
                                            onclick="allertPreview({{$subject->id}})"
                                        @endslot
                                        @slot('title')
                                            اعلان های کاربر
                                        @endslot
                                        @slot('icon')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24">
                                                <g fill="currentColor">
                                                    <path
                                                        d="m12.984 22.495l.537-.907c.416-.703.625-1.055.96-1.25c.334-.194.755-.201 1.598-.216c1.243-.021 2.023-.097 2.678-.368a4.952 4.952 0 0 0 2.68-2.68c.186-.446.28-.951.328-1.623c.025-.355.038-.533-.057-.675c-.095-.143-.275-.203-.636-.324c-1.511-.507-5.014-1.796-6.972-3.451c-2.207-1.867-4.182-5.66-4.889-7.115c-.14-.289-.21-.433-.334-.51c-.123-.076-.28-.074-.592-.071c-2.035.021-2.956.134-3.92.724A4.952 4.952 0 0 0 2.73 5.663C2 6.853 2 8.474 2 11.715v.99c0 2.307 0 3.46.377 4.37a4.952 4.952 0 0 0 2.681 2.679c.654.27 1.434.347 2.678.368c.842.015 1.264.022 1.598.216c.335.195.543.547.96 1.25l.537.907c.478.808 1.674.808 2.153 0Z"
                                                        opacity=".5"/>
                                                    <path fill-rule="evenodd"
                                                          d="M14.872.24a.766.766 0 0 1-.008 1.137l-1.102 1.014c.959.009 1.881.03 2.714.083c.715.045 1.386.114 1.97.222c.572.106 1.123.26 1.56.507a5.837 5.837 0 0 1 2 1.839c.48.721.693 1.537.794 2.52c.1.963.1 2.166.1 3.691v.042c0 .445-.387.805-.864.805c-.478 0-.865-.36-.865-.805c0-1.576 0-2.702-.091-3.578c-.09-.864-.26-1.402-.543-1.827a4.16 4.16 0 0 0-1.425-1.31c-.186-.105-.509-.214-1.004-.305a15.098 15.098 0 0 0-1.75-.195A49.94 49.94 0 0 0 13.776 4l1.088 1c.34.313.343.822.008 1.139a.91.91 0 0 1-1.222.007L11.057 3.76a.778.778 0 0 1-.257-.572c0-.215.092-.421.257-.573L13.65.232a.91.91 0 0 1 1.222.007Z"
                                                          clip-rule="evenodd"/>
                                                </g>
                                            </svg>
                                        @endslot
                                    @endcomponent
                                </div>
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>


            </div>
            @if(!$list->first())
                @component('component.divider.divider',[])
                    @slot('title')
                        {{$name_fa_fard}} ای موجود نیست
                    @endslot
                @endcomponent
            @endif

            @include('admin.components.pagination')





        </div>


    </div>
    @component('admin.components.sidebar',['name' => 'user_allerts'])
        {{--            todo component the loader--}}

        <div class="loader absoluteCenter text-blue-500 icon-2xl">
            @include('component.loading.loading')
        </div>
        <div class="top flex flex-wrap justify-between w-full absolute top-0 left-0 p-6">
            <div class="right"></div>
            <div class="left">
                @component('component.btn.btnD',['color'=>'sky' ])
                    @slot('action')
                        onclick="sidebar('hide','user_allerts')"
                    @endslot
                    @slot('icon')
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <g fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M20.75 12a.75.75 0 0 0-.75-.75h-9.25v1.5H20a.75.75 0 0 0 .75-.75Z"
                                      clip-rule="evenodd" opacity=".5"/>
                                <path
                                    d="M10.75 18a.75.75 0 0 1-1.28.53l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.28.53v12Z"/>
                            </g>
                        </svg>
                    @endslot
                @endcomponent

            </div>
        </div>
        <div class="contentWraper px-3 py-10">

        </div>
    @endcomponent

@endsection

@section('footerScripts')

    @parent


    <script src="{{asset('assets/js/plugins/popper/popper.js')}}"></script>
    <script src="{{asset('assets/js/dropdown.js')}}"></script>
    <script src="{{asset('assets/js/allert.js')}}"></script>


    <script>




        let allertTimout;
        function allertPreview(id) {

            clearTimeout(allertTimout);

            let content = selector('#sidebar.user_allerts .contentWraper')
            content.textContent = '';
            sidebar('show', 'user_allerts')
            hidden('#sidebar.user_allerts .loader','show')

            allertTimout = setTimeout(function () {
                ajaxReq(`{{base_web()}}admin/users/${id}/allerts`,{},function (data){
                    hidden('#sidebar .loader')

                    content.insertAdjacentHTML('afterbegin', `` + data + ``);

                },'POST')
            },300)




        }
        function UserAllertDelete(El,id) {

            let loader = El.querySelector('.loader')
            El.querySelector('.deleteIcon').classList.add('hidden')
            loader.classList.remove('hidden');

            setTimeout(function () {
                ajaxReq(`{{base_web()}}admin/userAllert/${id}/delete`,{},function (data){
                    swaltoast('اعلان کاربر با موفقیت حذف شد')
                    El.closest('.allert').remove();
                },'POST')
            },300)



        }


    </script>

@endsection
