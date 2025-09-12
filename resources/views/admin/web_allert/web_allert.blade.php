@extends('admin.master')
@php

    $prefix = 'admin.webAllert.';
    $name_en = 'webAllert';
    $name_fa = 'اعلان های سایت';
    $name_fa_fard = 'اعلان';

@endphp
@section('cssScripts')

    <link rel="stylesheet" href="{{asset('assets/css/spiner.css')}}">
    @parent

@endsection

@section('title',$name_fa)

@section('content')

    <div id="content" class="mini w-full pt-16 text-slate-700 pb-6 overflow-x-clip">

        <div id="contentWraper" class="w-11/12 mx-auto mt-16 lg:w-96p sm:w-full space-y-6">
            <h2 class="font-bold text-felg mr-6 mb-2 md:mr-3">
                {{$name_fa}}
            </h2>

            @include('admin.web_allert.action')


            <div class="overflow-x-auto overflow-y-clip space-y-4">
                @foreach($list as $subject)
                    <div>
                        @component('component.allert.publicAllert',['type' => $subject->type])
                            @slot('content')
                                @include('component.description.description',['desc'=>editorJsDecode($subject,'content')])
                            @endslot
                            @slot('old')
                                {{persianDateOld($subject->created_at)}}
                            @endslot
                            @slot('deleteAction')
                                onclick="WebAllertDelete(this,{{$subject->id}})"
                            @endslot
                        @endcomponent
                        <div class="flex gap-2 flex-row-reverse p-3">
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
                        </div>
                    </div>
                @endforeach


            </div>
            @if(!$list->first())

                @component('component.divider.divider',[])
                    @slot('title')
                        {{$name_fa_fard}}ی موجود نیست
                    @endslot
                @endcomponent
            @endif

            @include('admin.components.pagination')


        </div>


    </div>

@endsection

@section('footerScripts')

    @parent


    <script src="{{asset('assets/js/plugins/popper/popper.js')}}"></script>
    <script src="{{asset('assets/js/dropdown.js')}}"></script>


    <script>
        let WebAllertTimout;

        function WebAllertDelete(El,id) {

            let loader = El.querySelector('.loader')
            El.querySelector('.deleteIcon').classList.add('hidden')
            loader.classList.remove('hidden');

            console.log('ok')
            WebAllertTimout = setTimeout(function () {
                ajaxReq(`{{base_web()}}admin/webAllert/${id}/delete`,{},function (data){
                    swaltoast('اعلان با موفقیت حذف شد')
                    El.closest('.allert').remove();
                },'POST')
            },300)



        }

        // function craeteTagSelect(element) {
        //
        //     $(element).select2({
        //         tags: true,
        //         closeOnSelect: false,
        //         dir: 'rtl'
        //     })
        //
        //
        // }


    </script>

@endsection
