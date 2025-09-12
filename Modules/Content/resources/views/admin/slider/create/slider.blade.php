@extends('admin.master')
@php

    $subject = isset($slider) ? $slider : null;
    $update = [];
    $action = 'store';
        $prefix = 'admin.slider.';
        $name_en = 'slider';
        $name_fa = 'اسلادر';
        $name_fa_fard = 'اسلایدر ها';

        if ($subject){
        $update[$name_en] = $subject->id;
        $action = 'update';
    }
@endphp
@section('cssScripts')


    <link rel="stylesheet" href="{{asset('assets/css/cropper/cropper.css')}}"/>
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
                    ویرایش {{$name_fa}} ({{$subject->title}})
                @endif
            </h2>


            <form id="addSlider"  action="{{route("$prefix$action",$update)}}"
                  class="space-y-3 space-y-reverse card_c p-4 px-6" method="POST">
                @csrf
                @if($action == 'store')
                    @method('POST')
                @elseif($action == 'update')
                    @method('PUT')
                @endif


                <input type="hidden" name="type" value="{{request()->type}}">

                <div class="wraper">
                    @include('admin.components.cropImage',['title' => "بنر $name_fa_fard",'name' => 'banner','id'=>'SliderBanner','size'=>15/7,'semantic'=> true ])
                </div>
                @error('banner')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror

                <div class="wraper">
                    @include('admin.components.cropImage',['title' => "بنر موبایل $name_fa_fard",'name' => 'mobile_banner','id'=>'SliderMobileBanner','size'=>3/2,'semantic'=> true ])
                </div>
                @error('mobile_banner')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">نام</h2>
                    <input class="form-input text-smid w-full" name="name" type="text"
                           value="{{old('name',$subject ? $subject->name : null)}}" placeholder="نام">
                </div>
                @error('name')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror


                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">آدرس صفحه مورد نظر</h2>
                    <input class="form-input text-smid w-full" name="link" dir="ltr" value="{{old('link',$subject ? $subject->link : null)}}" type="url" placeholder="https://webmooz.com">
                </div>
                @error('link')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror

                <div class="switchWraper">
                    <input type="checkbox" id="itemsugg" hidden="" @if(old('follow') === 'on' or $subject ? $subject->follow : false) checked @endif @if(!$subject) checked @endif name="follow">

                    @component('component.switch.switchLable',['shape'=> 'square','for' => 'itemsugg'])
                        @slot('title')
                            پیشنهاد شود
                        @endslot
                    @endcomponent
                </div>






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

    <script src="{{asset('assets/js/plugins/cropper/cropper.js')}}"></script>
    <script src="{{asset('assets/js/plugins/cropper/myCropper.js')}}"></script>

    <script>




        window.addEventListener('DOMContentLoaded',function () {



            document.querySelector('#submitForm').addEventListener('click',function (ev) {
                ev.preventDefault()


                document.querySelector('#addSlider').submit()




            })

        })



    </script>


    <script src="{{asset('assets/js/allert.js')}}"></script>


@endsection
