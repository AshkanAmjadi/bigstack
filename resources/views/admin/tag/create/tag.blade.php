@extends('admin.master')
@php

    $subject = isset($tag) ? $tag : null;
    $update = [];
    $action = 'store';
        $prefix = 'admin.tag.';
        $name_en = 'tag';
        $name_fa = 'برچسب';
        $name_fa_fard = 'برچسب';

        if ($subject){
        $update[$name_en] = $subject->id;
        $action = 'update';
    }
@endphp
@section('cssScripts')

    <link rel="stylesheet" href="{{asset('assets/css/select2/select2.css')}}"/>

    <link rel="stylesheet" href="{{asset('assets/css/cropper/cropper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/editorjs/editorjs.css')}}"/>
    @parent

@endsection

@if($action == 'store')
    @section('title',"اضافه کردن $name_fa")
@elseif($action == 'update')

    @section('title',"ویرایش $name_fa ($subject->name)")
@endif

@section('content')

    <div id="content" class="mini w-full pt-16 text-slate-700 pb-6">

        <div id="contentWraper" class="w-11/12 mx-auto mt-16 lg:w-96p sm:w-full space-y-6">
            <h2 class="font-bold text-felg mr-6 mb-2 md:mr-3">
                @if($action == 'store')
                    اضافه کردن {{$name_fa}}
                @elseif($action == 'update')
                    ویرایش {{$name_fa}} ({{$subject->name}})
                @endif
            </h2>


            <form id="addTag" action="{{route("$prefix$action",$update)}}"
                  class="space-y-3 space-y-reverse card_c p-4 px-6" method="POST">
                @csrf
                @if($action == 'store')
                    @method('POST')
                @elseif($action == 'update')
                    @method('PUT')
                @endif


                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">نام</h2>
                    <input class="form-input text-smid w-full" name="name" type="text"
                           value="{{old('name',$subject ? $subject->name : null)}}" placeholder="name">
                </div>
                @error('name')
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
                    @include('admin.components.cropImage',['title' => "عکس $name_fa",'name' => 'img','id'=>'Image','size'=>1/1,'semantic'=>true])
                </div>
                @error('img')
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

                @component('component.btn.btnD',['color'=>'rose' , 'id' => 'submitForm'])
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

        craeteTagSelect('#keyword')


        window.addEventListener('DOMContentLoaded', function () {


            document.querySelector('#submitForm').addEventListener('click', function (ev) {
                ev.preventDefault()


                document.querySelector('#addTag').submit()


            })

        })


    </script>


    <script src="{{asset('assets/js/allert.js')}}"></script>
    @include('component.cdn.autosize')

    <script src="{{asset('assets/js/plugins/cropper/cropper.js')}}"></script>
    <script src="{{asset('assets/js/plugins/cropper/myCropper.js')}}"></script>

@endsection
