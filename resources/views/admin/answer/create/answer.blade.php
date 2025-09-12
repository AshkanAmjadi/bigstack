
@extends('admin.master')
@php

    $subject = isset($answer) ? $answer : null;
    $update = [];
    $action = 'store';
        $prefix = 'admin.answer.';
        $name_en = 'answer';
        $name_fa = 'پاسخ';

        if ($subject){
        $update[$name_en] = $subject->id;
        $action = 'update';
    }
@endphp
@section('cssScripts')
    @include('component.cdn.easyMdeCss')
    <link rel="stylesheet" href="{{asset('assets/css/editorjs/editorjs.css')}}"/>

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
                    ویرایش {{$name_fa}}
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



    {{--  editor.js  --}}


    @component('admin.components.editorScripts')
    @endcomponent

    <script>



        @if($description = old('description',$subject ? $subject->content : null))
        let editorJsData = {!! json_encode(json_decode($description,true)) !!};
        @else
        let editorJsData = [

        ];
        @endif

        window.addEventListener('DOMContentLoaded',function () {
            var editor = new EditorJS({
                /**
                 * Enable/Disable the read only mode
                 */
                placeholder : 'بپرس اینجا جواب میگیری 😇',
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
                    document.querySelector('#addConversation').submit()

                }).catch((error) => {

                });




            })

        })



    </script>
    {{-- end editor.js  --}}


    <script src="{{asset('assets/js/allert.js')}}"></script>



@endsection
