@extends('admin.master')
@php

    $subject = isset($project) ? $project : null;
    $update = [];
    $action = 'store';
    $allService = \App\facade\BaseCat\BaseCat::getAllService();
    $allTag = \App\facade\BaseCat\BaseCat::getAllTag();
        $prefix = 'admin.project.';
        $name_en = 'project';
        $name_fa = 'پروژه ها';
        $name_fa_fard = 'پروژه';

        if ($subject){
        $update[$name_en] = $subject->id;
        $action = 'update';
    }
@endphp
@section('cssScripts')

    <link rel="stylesheet" href="{{asset('assets/css/virtualselect.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/cropper/cropper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/select2/select2.css')}}"/>
    @parent

@endsection


@if($action == 'store')
    @section('title',"اضافه کردن $name_fa_fard")
@elseif($action == 'update')
    @section('title',"ویرایش $name_fa_fard ($subject->title)")
@endif
@section('content')

    <div id="content" class="mini w-full pt-16 text-slate-700 pb-6">

        <div id="contentWraper" class="w-11/12 mx-auto mt-16 lg:w-96p sm:w-full space-y-6">
            <h2 class="font-bold text-felg mr-6 mb-2 md:mr-3">
                @if($action == 'store')
                    اضافه کردن {{$name_fa_fard}}
                @elseif($action == 'update')
                    ویرایش {{$name_fa_fard}} ({{$subject->title}})
                @endif
            </h2>


            <form id="addProject" action="{{route("admin.$name_en.$action",$update)}}"
                  class="space-y-3 space-y-reverse card_c p-4 px-6" method="POST">
                @csrf
                @if($action == 'store')
                    @method('POST')
                @elseif($action == 'update')
                    @method('PUT')
                @endif


                <div class="wraper">
                    @include('admin.components.cropImage',['title' => "عکس $name_fa_fard",'name' => 'img','id'=>'articleImage','size'=>3/2,'semantic'=> true ])
                </div>
                @error('img')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">تیتر داکیومنت(برای گوگل)</h2>
                    <input class="form-input text-smid w-full" name="page_title" type="text"
                           value="{{old('page_title',$subject ? $subject->page_title : null)}}"
                           placeholder="page_title">
                </div>
                @error('page_title')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">تیتر پروژه(برای کاربر)</h2>
                    <input class="form-input text-smid w-full" name="title" type="text"
                           value="{{old('title',$subject ? $subject->title : null)}}" placeholder="title">
                </div>
                @error('title')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">اسلاگ(آدرس url پروژه) پیشنهاد میشه معادل انگلیسی تیتر
                        داکیومنت باشه</h2>
                    <input class="form-input text-smid w-full" name="slug" type="text"
                           value="{{old('slug',$subject ? $subject->slug : null)}}"
                           placeholder="slug - در صورت خالی بودن از تیتر داکیومنت استفاده میشود">
                </div>
                @error('slug')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">توضیح کوتاه(meta-description برای گوگل) فقط 165 کارکتر نمایش
                        داده میشود</h2>
                    <textarea class="autosizeArea form-input text-smid w-full" rows="1" name="meta_description"
                              type="text"
                              placeholder="توضیح کوتاه..">{{old('meta_description',$subject ? $subject->meta_description : null)}}</textarea>
                </div>
                @error('meta_description')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror

                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">کلمات کلیدی</h2>

                    <select id="keyword" class="form-input select2 text-smid w-full font-YekanBakh" name="keyword[]"
                            multiple>
                        @php($keyword = old('keyword',$subject ? ($subject->keyword ?explode(',' ,$subject->keyword) : null) : null))


                        @if($keyword)
                            @foreach($keyword as $word)
                                <option
                                    value="{{$word}}" selected>{{$word}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                @error('keyword')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror

                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">انتخاب سرویس</h2>
                    <div class="inputs">
                        @php($selected = old('service_id', $subject ? $subject->service_id : null))
                        @include('admin.components.service_select',compact('selected'))
                    </div>
                </div>
                @error('category_id')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror

                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">تگ</h2>


                    @include('admin.components.tag_select')
                </div>
                @error('level')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">آدرس پیش نمایش</h2>
                    <input class="form-input text-smid w-full" name="preview_page" dir="ltr"
                           value="{{old('preview_page',$subject ? $subject->preview_page : null)}}" type="url"
                           placeholder="https://webmooz.com">
                </div>
                @error('preview_page')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="wraper">
                    @include('admin.components.cropImage',['title' => "بنر $name_fa",'name' => 'banner','id'=>'tagBanner','size'=>15/7,'semantic'=>true])
                </div>
                @error('banner')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="wraper">
                    @include('admin.components.cropImage',['title' => "بنر موبایل $name_fa",'name' => 'mobile_banner','id'=>'tagMobileBanner','size'=>3/2,'semantic'=>true])
                </div>
                @error('mobile_banner')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror

                <div class="switchWraper p-2">
                    <input type="checkbox" id="item3" hidden=""
                           @if(old('active') === 'on' or $subject ? $subject->active : false) checked
                           @endif @if(!$subject) checked @endif name="active">
                    @component('component.switch.switchLable',['shape'=> 'square','for' => 'item3'])
                        @slot('title')
                            فعال
                        @endslot
                    @endcomponent
                </div>


                <p class="text-sm font-light text-slate-400 mr-4 px-4">
                    <strong class="font-bold text-rose-500 text-smid">نکته:</strong>
                    توضیحات اصلی مقاله را بعد از ساختن مقاله میتوانید تعیین کنید.
                </p>

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


        </div>


    </div>

@endsection

@section('footerScripts')

    @parent


    <script src="{{asset('assets/js/plugins/virtualselect/virtualselect.js')}}"></script>
    <script>
        VirtualSelect.init({
            ele: '#categorySelect',
            search: true,
        });
    </script>

    <script src="{{asset('assets/js/allert.js')}}"></script>
    @include('component.cdn.autosize')

    <script src="{{asset('assets/js/plugins/cropper/cropper.js')}}"></script>
    <script src="{{asset('assets/js/plugins/cropper/myCropper.js')}}"></script>
    @include('component.cdn.select2')


    <script>


        function craeteTagSelect(element) {

            $(element).select2({
                placeholder: "جستو جو ...",
                tags: true,
                closeOnSelect: false,
                dir: 'rtl'
            })


        }


        $('#level').select2({
            closeOnSelect: false,
            dir: 'rtl',

        })

        craeteTagSelect('#tags')

        craeteTagSelect('#keyword')
    </script>

@endsection
