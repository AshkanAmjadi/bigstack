@extends('admin.master')
@php

    $subject = isset($instaArticle) ? $instaArticle : null;
    $update = [];
    $action = 'store';
    $allCat = \App\facade\BaseCat\BaseCat::getAll();
    $allTag = \App\facade\BaseCat\BaseCat::getAllTag();
         $prefix = 'admin.instaArticle.';
    $fileprefix = 'admin.insta_article.';
    $name_en = 'instaArticle';
    $name_fa = 'پست های اینستاگرام';
    $name_fa_fard = 'پست اینستاگرام';

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
                    اضافه کردن پست
                @elseif($action == 'update')
                    ویرایش پست ({{$subject->title}})
                @endif
            </h2>


            <form id="addArticle" action="{{route($prefix."$action",$update)}}"
                  class="space-y-3 space-y-reverse card_c p-4 px-6" method="POST">
                @csrf
                @if($action == 'store')
                    @method('POST')
                @elseif($action == 'update')
                    @method('PUT')
                @endif



                <div class="wraper">
                    @include('admin.components.cropImage',['title' => "پست",'name' => 'img','id'=>'InstaArticleBanner','size'=>5/4])

                </div>
                @error('img')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">عنوان</h2>
                    <input class="form-input text-smid w-full" name="title" type="text"
                           value="{{old('title',$subject ? $subject->title : null)}}" placeholder="عنوان">
                </div>
                @error('title')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">توضیح کوتاه(caption)</h2>
                    <textarea class="autosizeArea form-input text-smid w-full" rows="1" name="caption"
                              type="text" placeholder="توضیح کوتاه..">{{old('caption',$subject ? $subject->caption : null)}}</textarea>
                </div>
                @error('caption')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">آدرس پست اینستاگرام</h2>
                    <input class="form-input text-smid w-full" name="link" dir="ltr" value="{{old('link',$subject ? $subject->link : null)}}" type="url" placeholder="https://webmooz.com">
                </div>
                @error('link')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror

                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">انتخاب دسته بندی</h2>
                    <div class="inputs">
                        @php($selected = old('category', $subject ? $subject->category : null))
                        @include('content::admin.component.category_select',compact('selected'))
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


                <div class="switchWraper p-2">
                    <input type="checkbox" id="item3" hidden="" @if(old('active') === 'on' or $subject ? $subject->active : false) checked @endif @if(!$subject) checked @endif name="active">

                    @component('component.switch.switchLable',['shape'=> 'square','for' => 'item3'])
                        @slot('title')
                            فعال
                        @endslot
                    @endcomponent
                </div>


                <p class="text-sm font-light text-slate-400 mr-4 px-4">
                    <strong class="font-bold text-rose-500 text-smid">نکته:</strong>
                    پست های اینستاگرام سایت شما فقط هدایت گر کاربران شما به پیج اینستاگرام شماست و کاربرد دیگری ندارد.
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



        craeteTagSelect('#tags')

    </script>

@endsection
