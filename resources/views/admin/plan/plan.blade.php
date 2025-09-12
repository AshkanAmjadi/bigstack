@extends('admin.master')
@php

    $prefix = 'admin.plan.';
    $name_en = 'plan';
    $name_fa = 'پلن قیمت ها';
    $name_fa_fard = 'پلن قیمت';

@endphp
@section('cssScripts')

    @parent

@endsection

@section('title',"$name_fa برای $project->name")

@section('content')

    <div id="content" class="mini w-full pt-16 text-slate-700 pb-6 overflow-x-clip">

        <div id="contentWraper" class="w-11/12 mx-auto mt-16 lg:w-96p sm:w-full space-y-6">
            <h2 class="font-bold text-felg mr-6 mb-2 md:mr-3">
                {{$name_fa}} برای پروژه {{$project->name}}
            </h2>

            @include("admin.$name_en.action")


            <div class="overflow-x-auto overflow-y-clip">
                <table class="w-full table-style-shadow-td min-w-[1100px]">
                    <thead>
                    <tr>
                        <th class="text-right">نام</th>
                        <th class="text-right">قیمت</th>
                        <th class="text-right">ساخته شده توسط</th>
                        <th class="text-right">ویرایش شده توسط</th>
                        <th class="text-right">فعال</th>
                        <th class="text-right">اعمال</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($list as $subject)

                        <tr>


                            <td>
                                <h2 class="font-bold text-smid flex flex-wrap gap-1">

                                    {{$subject->name}}
                                </h2>

                            </td>
                            <td>
                                <h2 class="font-bold text-smid flex flex-wrap gap-1">

                                    {{number_format($subject->price)}}
                                </h2>

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

                                @livewire('admin.active',['obj' => $subject , 'size'=>'lg' ,'color' => 'emerald'],key(''.now().''))

                            </td>

                            <td>
                                <div class="flex flex-wrap gap-2 items-center">
                                    <form class="delete"
                                          action="{{ route($prefix.'destroy',['project' => $project->id,$name_en=>$subject->id]) }}"
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

                                    @component('component.btn.linkBtn',['href' => route($prefix.'edit',['project' => $project->id,$name_en=>$subject->id])])
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
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>


            </div>
            @if(!$list->first())
                @component('component.divider.divider',[])
                    @slot('title')
                        {{$name_fa_fard}} ی موجود نیست
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

        let deleteImg

        function deleteImage(El, id, type) {
            let wraper = El.closest('.wraper')
            // let loader  = wraper.querySelector(`#delete_${type}${id}loader`)

            // clearTimeout(deleteImg);

            hidden(`#delete_${type}${id}btn`)
            hidden(`#delete_${type}${id}loader`, 'show')


            deleteImg = setTimeout(function () {
                ajaxReq(`{{url('/')}}/admin/tag/${id}/deleteImg`,
                    {type: type}
                    , function (data) {
                        console.log(data)
                        swaltoast('تصویر با موفقیت حذف شد')
                        hidden(`#delete_${type}${id}loader`)
                        wraper.querySelector('img').remove()
                    }, 'POST')
            }, 300)


        }


    </script>

@endsection
