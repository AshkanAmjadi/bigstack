@extends('admin.master')
@php

    $subject = isset($comment) ? $comment : null;
    $update = [];
    $action = 'store';
        $prefix = 'admin.comment.';
        $name_en = 'comment';
        $name_fa = 'نظر';

        if ($subject){
        $update[$name_en] = $subject->id;
        $action = 'update';
    }
@endphp
@section('cssScripts')

    @parent

@endsection

@if($action == 'store')
    @section('title',"اضافه کردن $name_fa")
@elseif($action == 'update')

    @section('title',"ویرایش $name_fa ($subject->title)")
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


            <form id="addConversation" action="{{route("$prefix$action",$update)}}"
                  class="space-y-3 space-y-reverse card_c p-4 px-6" method="POST">
                @csrf
                @if($action == 'store')
                    @method('POST')
                @elseif($action == 'update')
                    @method('PUT')
                @endif


                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">عنوان</h2>
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
                    <h2 class="text-sm mr-4 font-semibold">محتوی</h2>
                    <textarea class="autosizeArea form-input text-smid w-full" rows="1" name="content"
                              type="text"
                              placeholder="توضیح کوتاه..">{{old('content',$subject ? $subject->content : null)}}</textarea>


                </div>
                @error('content')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
{{--                <div class="wraper" >--}}
{{--                    <div class="feedback flex mt-10 gap-2">--}}
{{--                        <label class="cursor-pointer angry">--}}
{{--                            <input type="radio" class="starInput hidden" value="1" @if($subject->star == '1') checked @endif name="star" />--}}
{{--                            <div class="text-felg grayscale">--}}
{{--                                😠--}}
{{--                            </div>--}}
{{--                        </label>--}}
{{--                        <label class="cursor-pointer sad">--}}
{{--                            <input type="radio" class="starInput hidden" value="2" @if($subject->star == '2') checked @endif name="star" />--}}
{{--                            <div class="text-felg grayscale">--}}
{{--                                😟--}}
{{--                            </div>--}}
{{--                        </label>--}}
{{--                        <label class="cursor-pointer ok">--}}
{{--                            <input type="radio" class="starInput hidden" value="3" @if($subject->star == '3') checked @endif name="star" />--}}
{{--                            <div class="text-felg grayscale">--}}
{{--                                😐--}}
{{--                            </div>--}}
{{--                        </label>--}}
{{--                        <label class="cursor-pointer good">--}}
{{--                            <input type="radio" class="starInput hidden" value="4" @if($subject->star == '4') checked @endif name="star" />--}}
{{--                            <div class="text-felg grayscale">--}}
{{--                                😊--}}
{{--                            </div>--}}
{{--                        </label>--}}
{{--                        <label class="cursor-pointer happy">--}}
{{--                            <input type="radio" class="starInput hidden" value="5" @if($subject->star == '5') checked @endif name="star" />--}}
{{--                            <div class="text-felg grayscale">--}}
{{--                                🤩--}}
{{--                            </div>--}}
{{--                        </label>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                @error('star')--}}
{{--                @component('component.allert.allert' )--}}
{{--                    @slot('title')--}}
{{--                        {{$message}}--}}
{{--                    @endslot--}}
{{--                @endcomponent--}}
{{--                @enderror--}}


                <div class="switchWraper p-2">
                    <input type="checkbox" id="item3" hidden=""
                           @if(old('active') === 'on' or $subject ? $subject->active : false) checked
                           @endif @if(!$subject) checked @endif name="active">
                    @component('component.switch.switchLable',['title' => 'فعال' ,'shape'=> 'square','for' => 'item3'])
                    @endcomponent
                </div>


                @component('component.btn.btn',['color'=>'rose' , 'id' => 'submitForm'])
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

    {{--ckeditor--}}
    {{--    <script src="{{asset('assets/js/plugins/ckeditor/ckeditor.js')}}"></script>--}}
    <script>
        // CKEDITOR.replace('description');
    </script>

    {{--  editor.js  --}}




    <script src="{{asset('assets/js/allert.js')}}"></script>
    @include('component.cdn.autosize')



    <script>


    </script>

@endsection
