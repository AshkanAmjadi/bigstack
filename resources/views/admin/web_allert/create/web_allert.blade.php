@extends('admin.master')
@php

    $subject = isset($webAllert) ? $webAllert : null;
    $update = [];
    $action = 'store';
        $prefix = 'admin.webAllert.';
        $name_en = 'webAllert';
        $name_fa = 'اعلان های سایت';
    $name_fa_fard = 'اعلان';

        if ($subject){
        $update[$name_en] = $subject->id;
        $action = 'update';
    }
@endphp
@section('cssScripts')

    @parent
    <link rel="stylesheet" href="{{asset('assets/css/editorjs/editorjs.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/select2/select2.css')}}"/>
    @include('component.cdn.easyMdeCss')


@endsection

@if($action == 'store')
    @section('title',"اضافه کردن به$name_fa")
@elseif($action == 'update')

    @section('title',"ویرایش $name_fa_fard")
@endif

@section('content')

    <div id="content" class="mini w-full pt-16 text-slate-700 pb-6">

        <div id="contentWraper" class="w-11/12 mx-auto mt-16 lg:w-96p sm:w-full space-y-6">
            <h2 class="font-bold text-felg mr-6 mb-2 md:mr-3">
                @if($action == 'store')
                    اضافه کردن {{$name_fa}}
                @elseif($action == 'update')
                    ویرایش {{$name_fa}}
                @endif
            </h2>


            <form id="setArticleDesc" action="{{route("$prefix$action",$update)}}"
                  class="space-y-3 space-y-reverse card_c p-4 px-6" method="POST">
                @csrf
                @if($action == 'store')
                    @method('POST')
                @elseif($action == 'update')
                    @method('PUT')
                @endif


                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">محتوی</h2>
                    <input id="editorJsContent" type="text" name="content" class="hidden">
                    {{--                    <textarea class="autosizeArea form-input text-smid w-full" rows="1" name="description"--}}
                    {{--                              type="text" placeholder="توضیح کوتاه..">{{old('description',$subject ? $subject->description : null)}}</textarea>--}}


                    <div id="editorjs" class="form-input"></div>
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

                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">نوع</h2>


                    @include('admin.components.type_select')

                </div>

{{--                <div class="switchWraper p-2">--}}
{{--                    <input type="checkbox" id="item3" hidden=""--}}
{{--                           @if(old('active') === 'on' or $subject ? $subject->active : false) checked--}}
{{--                           @endif @if(!$subject) checked @endif name="active">--}}
{{--                    @component('component.switch.switchLable',['title' => 'فعال' ,'shape'=> 'square','for' => 'item3'])--}}
{{--                    @endcomponent--}}
{{--                </div>--}}


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





    <script src="{{asset('assets/js/modal.js')}}"></script>
    <script src="{{asset('assets/js/allert.js')}}"></script>
    @include('component.cdn.select2')




    <script>

        $('#type').select2({
            closeOnSelect: false,
            dir: 'rtl',

        })

    </script>


    <script src="{{asset('assets/js/allert.js')}}"></script>

    @component('admin.components.editorScripts')
    @endcomponent

    <script>


            @if($content = old('content',$subject ? $subject->content : null))
        let editorJsData = {!! json_encode(json_decode($content,true)) !!};
            @else
        let editorJsData = [

            ];
        @endif

        window.addEventListener('DOMContentLoaded',function () {
            var editor = new EditorJS({
                /**
                 * Enable/Disable the read only mode
                 */
                placeholder : 'محتوای اطلاعیه؟',
                readOnly: false,

                /**
                 * Wrapper of Editor
                 */
                holder: 'editorjs',

                /**
                 * Common Inline Toolbar settings
                 * - if true (or not specified), the order from 'tool' property will be used
                 * - if an array of tool names, this order will be used
                 */
                // inlineToolbar: ['link', 'marker', 'bold', 'italic'],
                // inlineToolbar: true,
                /**
                 * Tools list
                 */
                tools: editortools,
                i18n: i18n,

                data: {
                    blocks: editorJsData
                },
            })


            document.querySelector('#submitForm').addEventListener('click',function (ev) {
                ev.preventDefault()

                editor.save().then((outputData) => {
                    // console.log(JSON.stringify(outputData))
                    $('#editorJsContent').val(JSON.stringify(outputData.blocks))
                    document.querySelector('#setArticleDesc').submit()

                }).catch((error) => {

                });




            })

        })



    </script>

@endsection
