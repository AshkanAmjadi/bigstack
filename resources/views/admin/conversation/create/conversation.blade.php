@extends('admin.master')
@php

    $subject = isset($conversation) ? $conversation : null;
    $update = [];
    $action = 'store';
    $allCat = \App\facade\BaseCat\BaseCat::getAll();
    $allTag = \App\facade\BaseCat\BaseCat::getAllTag();
        $prefix = 'admin.conversation.';
        $name_en = 'conversation';
        $name_fa = 'پرسش و پاسخ';

        if ($subject){
        $update[$name_en] = $subject->id;
        $action = 'update';
    }
@endphp
@section('cssScripts')


    <link rel="stylesheet" href="{{asset('assets/css/select2/select2.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/editorjs/editorjs.css')}}"/>
    @include('component.cdn.easyMdeCss')
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


            <form id="addConversation"  action="{{route("$prefix$action",$update)}}"
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
                    <input id="editorJsContent" type="text" name="description" class="hidden">
{{--                    <textarea class="autosizeArea form-input text-smid w-full" rows="1" name="description"--}}
{{--                              type="text" placeholder="توضیح کوتاه..">{{old('description',$subject ? $subject->description : null)}}</textarea>--}}


                    <div id="editorjs" class="form-input"></div>
                </div>
                @error('description')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror

                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">تگ</h2>


                    <select id="tags" class="form-input select2 text-smid w-full font-YekanBakh" name="tags[]" multiple>
                        @php($tags = $subject ? $subject->tags()->get(['id'])->pluck('id')->toArray() : [])

                        @foreach($allTag as $tag)
                            <option
                                value="{{$tag->id}}" {{in_array($tag->id , old('tags' , $tags)) ? 'selected' : ''}}>{{$tag->name}}</option>
                        @endforeach
                    </select>
                </div>
                @error('tag')
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

{{--ckeditor--}}
{{--    <script src="{{asset('assets/js/plugins/ckeditor/ckeditor.js')}}"></script>--}}
    <script>
        // CKEDITOR.replace('description');
    </script>

{{--  editor.js  --}}


    @component('admin.components.editorScripts')
    @endcomponent

    <script>



        @if($description = old('description',$subject ? $subject->description : null))
        let editorJsData = {!! json_encode(json_decode($description,true)) !!};
        @else
        let editorJsData = [
            // {
            //     type: "header",
            //     data: {
            //         text: "Editor.js",
            //         level: 2
            //     }
            // },
            // {
            //     type : 'paragraph',
            //     data : {
            //         text : 'Hey. Meet the new Editor. On this page you can see it in action — try to edit this text. Source code of the page contains the example of connection and configuration.'
            //     }
            // },
            // {
            //     type: "header",
            //     data: {
            //         text: "Key features",
            //         level: 3
            //     }
            // },
            // {
            //     type : 'list',
            //     data : {
            //         items : [
            //             'It is a block-styled editor',
            //             'It returns clean data output in JSON',
            //             'Designed to be extendable and pluggable with a simple API',
            //         ],
            //         style: 'unordered'
            //     }
            // },
            // {
            //     type: "header",
            //     data: {
            //         text: "What does it mean «block-styled editor»",
            //         level: 3
            //     }
            // },
            // {
            //     type : 'paragraph',
            //     data : {
            //         text : 'Workspace in classic editors is made of a single contenteditable element, used to create different HTML markups. Editor.js <mark class=\"cdx-marker\">workspace consists of separate Blocks: paragraphs, headings, images, lists, quotes, etc</mark>. Each of them is an independent contenteditable element (or more complex structure) provided by Plugin and united by Editor\'s Core.'
            //     }
            // },
            // {
            //     type : 'paragraph',
            //     data : {
            //         text : `There are dozens of <a href="https://github.com/editor-js">ready-to-use Blocks</a> and the <a href="https://editorjs.io/creating-a-block-tool">simple API</a> for creation any Block you need. For example, you can implement Blocks for Tweets, Instagram posts, surveys and polls, CTA-buttons and even games.`
            //     }
            // },
            // {
            //     type: "header",
            //     data: {
            //         text: "What does it mean clean data output",
            //         level: 3
            //     }
            // },
            // {
            //     type : 'paragraph',
            //     data : {
            //         text : 'Classic WYSIWYG-editors produce raw HTML-markup with both content data and content appearance. On the contrary, Editor.js outputs JSON object with data of each Block. You can see an example below'
            //     }
            // },
            // {
            //     type : 'paragraph',
            //     data : {
            //         text : `Given data can be used as you want: render with HTML for <code class="inline-code">Web clients</code>, render natively for <code class="inline-code">mobile apps</code>, create markup for <code class="inline-code">Facebook Instant Articles</code> or <code class="inline-code">Google AMP</code>, generate an <code class="inline-code">audio version</code> and so on.`
            //     }
            // },
            // {
            //     type : 'paragraph',
            //     data : {
            //         text : 'Clean data is useful to sanitize, validate and process on the backend.'
            //     }
            // },
            // {
            //     type : 'delimiter',
            //     data : {}
            // },
            // {
            //     type : 'paragraph',
            //     data : {
            //         text : 'We have been working on this project more than three years. Several large media projects help us to test and debug the Editor, to make its core more stable. At the same time we significantly improved the API. Now, it can be used to create any plugin for any task. Hope you enjoy. 😏'
            //     }
            // },
            // {
            //     type: 'image',
            //     data: {
            //         url: 'data:image/jpeg;base64,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',
            //         caption: '',
            //         stretched: false,
            //         withBorder: true,
            //         withBackground: false,
            //     }
            // },
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


    <script src="{{asset('assets/js/allert.js')}}"></script>
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
