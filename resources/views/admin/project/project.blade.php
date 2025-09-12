@extends('admin.master')
@php

    $prefix = 'admin.project.';
    $name_en = 'project';
    $name_fa = 'پروژه ها';
    $name_fa_fard = 'پروژه'
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

            @include('admin.'.$name_en.'.action')


            <div class="overflow-x-auto overflow-y-clip">
                <table class="w-full table-style-shadow-td min-w-[1000px]">
                    <thead>
                    <tr>
                        <th class="text-right">عکس</th>
                        <th class="text-right">نام</th>
                        <th class="text-right">تیتر</th>
                        <th class="text-right">سرویس</th>
                        <th class="text-right">نوشته شده توسط</th>
                        <th class="text-right">ویرایش شده توسط</th>
                        <th class="text-right">فعال</th>
                        <th class="text-right">اعمال</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($list as $subject)

                        <tr>
                            <td class="w-36 p-3">
                                <div class="border-4 dark:border-slate-700 rounded-lg overflow-hidden ">
                                    <img class="w-full" src="{{semanticImgUrlMaker($subject,'img')}}" alt="">
                                </div>

                            </td>
                            <td>
                                <h2 class="font-bold text-smid">{{$subject->title}}</h2>
                                <div class="flex flex-wrap gap-2">
                                    @component('component.badg.badg' ,['color' => 'sky'])
                                        @slot('title') تعداد بازدید : {{$subject->view}} @endslot
                                    @endcomponent
                                    @if($subject->level == 0)
                                        @component('component.badg.badg' ,['color' => 'gray'])
                                            @slot('title') بدون سطح @endslot
                                        @endcomponent
                                    @elseif($subject->level == 1)
                                        @component('component.badg.badg' ,['color' => 'teal'])
                                            @slot('title') مبتدی @endslot
                                        @endcomponent
                                    @elseif($subject->level == 2)
                                        @component('component.badg.badg' ,['color' => 'orange'])
                                            @slot('title') متوسط @endslot
                                        @endcomponent
                                    @elseif($subject->level == 3)
                                        @component('component.badg.badg' ,['color' => 'red'])
                                            @slot('title') پیشرفته @endslot
                                        @endcomponent
                                    @endif

                                    @foreach($subject->tags as $tag)
                                        @component('component.badg.badg' ,['color' => 'indigo'])
                                            @slot('title') #{{$tag->name}} @endslot
                                        @endcomponent
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <h2 class="font-bold text-smid">{{$subject->page_title}}</h2>
                            </td>
                            <td>
                                <h2 class="font-bold text-smid">{{$subject->service->name}}</h2>
                                <div class="w-20 border-4 dark:border-slate-700 rounded-lg overflow-hidden  p-2">
                                    <img class="w-full" src="{{semanticImgUrlMaker($subject->service,'img')}}" alt="">
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

                                @livewire('admin.active',['obj' => $subject , 'size'=>'lg'],key($subject->getTable() .'_' . $subject->id))

                            </td>
                            <td>
                                <div class="flex flex-wrap gap-2 items-center">
                                    <form class="delete" action="{{ route($prefix.'destroy',[$name_en=>$subject->id]) }}" method="post">
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
                                    @component('component.btn.linkBtn',['href' => route($prefix."desc.show",[$name_en=>$subject->id]),'color'=>'emerald'])
                                        @slot('icon')
                                            <svg xmlns="http://www.w3.org/2000/svg" class=""  viewBox="0 0 24 24"><g fill="currentColor"><path d="M3 10c0-3.771 0-5.657 1.172-6.828C5.343 2 7.229 2 11 2h2c3.771 0 5.657 0 6.828 1.172C21 4.343 21 6.229 21 10v4c0 3.771 0 5.657-1.172 6.828C18.657 22 16.771 22 13 22h-2c-3.771 0-5.657 0-6.828-1.172C3 19.657 3 17.771 3 14v-4Z" opacity=".5"></path><path d="M16.519 16.501c.175-.136.334-.295.651-.612l3.957-3.958c.096-.095.052-.26-.075-.305a4.332 4.332 0 0 1-1.644-1.034a4.332 4.332 0 0 1-1.034-1.644c-.045-.127-.21-.171-.305-.075L14.11 12.83c-.317.317-.476.476-.612.651c-.161.207-.3.43-.412.666c-.095.2-.166.414-.308.84l-.184.55l-.292.875l-.273.82a.584.584 0 0 0 .738.738l.82-.273l.875-.292l.55-.184c.426-.142.64-.212.84-.308c.236-.113.46-.25.666-.412Zm5.847-5.809a2.163 2.163 0 1 0-3.058-3.059l-.127.128a.524.524 0 0 0-.148.465c.02.107.055.265.12.452c.13.375.376.867.839 1.33a3.5 3.5 0 0 0 1.33.839c.188.065.345.1.452.12a.525.525 0 0 0 .465-.148l.127-.127Z"></path><path fill-rule="evenodd" d="M7.25 9A.75.75 0 0 1 8 8.25h6.5a.75.75 0 0 1 0 1.5H8A.75.75 0 0 1 7.25 9Zm0 4a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5H8a.75.75 0 0 1-.75-.75Zm0 4a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5H8a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd"></path></g></svg>
                                        @endslot
                                    @endcomponent
                                    @component('component.btn.linkBtn',['href' => route($prefix."possible.show",[$name_en=>$subject->id]),'color'=>'indigo'])
                                        @slot('title')
                                            امکانات
                                        @endslot
                                        @slot('icon')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12" opacity="0.5"/><path fill="currentColor" d="M10.543 7.517a.75.75 0 1 0-1.086-1.034l-2.314 2.43l-.6-.63a.75.75 0 1 0-1.086 1.034l1.143 1.2a.75.75 0 0 0 1.086 0zM13 8.25a.75.75 0 0 0 0 1.5h5a.75.75 0 0 0 0-1.5zm-2.457 6.267a.75.75 0 1 0-1.086-1.034l-2.314 2.43l-.6-.63a.75.75 0 1 0-1.086 1.034l1.143 1.2a.75.75 0 0 0 1.086 0zM13 15.25a.75.75 0 0 0 0 1.5h5a.75.75 0 0 0 0-1.5z"/></svg>
                                        @endslot
                                    @endcomponent
                                    @component('component.btn.linkBtn',['href' => route("admin.plan.index",[$name_en=>$subject->id]),'color'=>'orange'])
                                        @slot('title')
                                            پلن قیمت ها
                                        @endslot
                                        @slot('icon')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M3.172 7.172c.843-.844 2.058-1.08 4.08-1.146l1.5-.024C9.143 6 9.56 6 10 6h4c.441 0 .857 0 1.248.002l1.5.024c2.022.066 3.237.302 4.08 1.146C22 8.343 22 10.229 22 14c0 3.771 0 5.657-1.172 6.828C19.657 22 17.771 22 14 22h-4c-3.771 0-5.657 0-6.828-1.172C2 19.657 2 17.771 2 14c0-3.771 0-5.657 1.172-6.828" opacity="0.5"/><path fill="currentColor" d="M12.75 10a.75.75 0 0 0-1.5 0v.01c-1.089.274-2 1.133-2 2.323c0 1.457 1.365 2.417 2.75 2.417c.824 0 1.25.533 1.25.917s-.426.916-1.25.916c-.824 0-1.25-.532-1.25-.916a.75.75 0 0 0-1.5 0c0 1.19.911 2.048 2 2.323V18a.75.75 0 0 0 1.5 0v-.01c1.089-.274 2-1.133 2-2.323c0-1.457-1.365-2.417-2.75-2.417c-.824 0-1.25-.533-1.25-.917s.426-.916 1.25-.916c.824 0 1.25.532 1.25.916a.75.75 0 0 0 1.5 0c0-1.19-.911-2.049-2-2.323zm-.698-8.75h-.104c-.898 0-1.648 0-2.242.08c-.628.084-1.195.27-1.65.725c-.456.456-.642 1.023-.726 1.65c-.057.427-.073 1.446-.078 2.32l1.5-.023c.005-.847.02-1.758.065-2.097c.062-.461.169-.659.3-.789c.13-.13.327-.237.789-.3c.483-.064 1.13-.066 2.094-.066s1.612.002 2.095.067c.461.062.659.169.789.3c.13.13.238.327.3.788c.045.34.06 1.25.064 2.097l1.5.024c-.004-.875-.02-1.894-.078-2.32c-.084-.628-.27-1.195-.725-1.65c-.456-.456-1.023-.642-1.65-.726c-.595-.08-1.344-.08-2.243-.08"/></svg>
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

@endsection

@section('footerScripts')

    @parent


    <script src="{{asset('assets/js/plugins/popper/popper.js')}}"></script>
    <script src="{{asset('assets/js/dropdown.js')}}"></script>


    <script>


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
