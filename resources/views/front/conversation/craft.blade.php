@extends('front.temp.master')

@push('schema')
    <script type="application/ld+json">
        {{--        {!! clean($article->schema) !!}--}}
    </script>
@endpush
@section('cssScripts')
    @include('component.cdn.select2css')
    <link rel="stylesheet" href="{{asset('assets/css/editorjs/editorjs.css')}}"/>
    @parent

@endsection

@php
    $tags = \App\facade\BaseCat\BaseCat::getAllTag();
@endphp
@section('content')

    <div class="mainArticle grid gap-5 grid-cols-3 mb-10 mt-7">
        <div class="article col-span-2 space-y-4 lg:col-span-3">


            <article class="space-y-5">

                <div class="contentWraper card_c p-5 md:p-3 relative">

                    <div class="loader absoluteCenter icon-2xl text-blue-500 @if(!$conversation) none-show @endif">
                        @include('component.loading.loading')
                    </div>
                    <div class="success text-elg !bg-indigo-500 card_cw py-20 text-center hidden">
                        <div class="font-extrabold text-white">
                            Your answer has been sended and is awaiting approval.
                        </div>
                        <div class="font-extrabold text-white">
                            Thank you, dear user💕
                        </div>
                        <div class="icon-xl w-full flex justify-center mt-6 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                      d="m12.984 22.495l.537-.907c.416-.703.625-1.055.96-1.25c.334-.194.755-.201 1.598-.216c1.243-.021 2.023-.097 2.678-.368a4.952 4.952 0 0 0 2.68-2.68c.186-.446.28-.951.328-1.623c.025-.355.038-.533-.057-.675c-.095-.143-.275-.203-.636-.324c-1.511-.507-5.014-1.796-6.972-3.451c-2.207-1.867-4.182-5.66-4.889-7.115c-.14-.289-.21-.433-.334-.51c-.123-.076-.28-.074-.592-.071c-2.035.021-2.956.134-3.92.724A4.952 4.952 0 0 0 2.73 5.663C2 6.853 2 8.474 2 11.715v.99c0 2.307 0 3.46.377 4.37a4.952 4.952 0 0 0 2.681 2.679c.654.27 1.434.347 2.678.368c.842.015 1.264.022 1.598.216c.335.195.543.547.96 1.25l.537.907c.478.808 1.674.808 2.153 0Z"
                                      opacity=".5"/>
                                <path fill="currentColor" fill-rule="evenodd"
                                      d="M14.872.24a.766.766 0 0 1-.008 1.137l-1.102 1.014c.959.009 1.881.03 2.714.083c.715.045 1.386.114 1.97.222c.572.106 1.123.26 1.56.507a5.837 5.837 0 0 1 2 1.839c.48.721.693 1.537.794 2.52c.1.963.1 2.166.1 3.691v.042c0 .445-.387.805-.864.805c-.478 0-.865-.36-.865-.805c0-1.576 0-2.702-.091-3.578c-.09-.864-.26-1.402-.543-1.827a4.16 4.16 0 0 0-1.425-1.31c-.186-.105-.509-.214-1.004-.305a15.098 15.098 0 0 0-1.75-.195A49.94 49.94 0 0 0 13.776 4l1.088 1c.34.313.343.822.008 1.139a.91.91 0 0 1-1.222.007L11.057 3.76a.778.778 0 0 1-.257-.572c0-.215.092-.421.257-.573L13.65.232a.91.91 0 0 1 1.222.007Z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="edited text-elg !bg-sky-500 card_cw py-20 text-center hidden">
                        <div class="font-extrabold text-white">
                            Your answer has been changed and is awaiting approval.
                        </div>
                        <div class="font-extrabold text-white">
                            Thank you, dear user💕
                        </div>
                        <div class="icon-xl w-full flex justify-center mt-6 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                      d="m12.984 22.495l.537-.907c.416-.703.625-1.055.96-1.25c.334-.194.755-.201 1.598-.216c1.243-.021 2.023-.097 2.678-.368a4.952 4.952 0 0 0 2.68-2.68c.186-.446.28-.951.328-1.623c.025-.355.038-.533-.057-.675c-.095-.143-.275-.203-.636-.324c-1.511-.507-5.014-1.796-6.972-3.451c-2.207-1.867-4.182-5.66-4.889-7.115c-.14-.289-.21-.433-.334-.51c-.123-.076-.28-.074-.592-.071c-2.035.021-2.956.134-3.92.724A4.952 4.952 0 0 0 2.73 5.663C2 6.853 2 8.474 2 11.715v.99c0 2.307 0 3.46.377 4.37a4.952 4.952 0 0 0 2.681 2.679c.654.27 1.434.347 2.678.368c.842.015 1.264.022 1.598.216c.335.195.543.547.96 1.25l.537.907c.478.808 1.674.808 2.153 0Z"
                                      opacity=".5"/>
                                <path fill="currentColor" fill-rule="evenodd"
                                      d="M14.872.24a.766.766 0 0 1-.008 1.137l-1.102 1.014c.959.009 1.881.03 2.714.083c.715.045 1.386.114 1.97.222c.572.106 1.123.26 1.56.507a5.837 5.837 0 0 1 2 1.839c.48.721.693 1.537.794 2.52c.1.963.1 2.166.1 3.691v.042c0 .445-.387.805-.864.805c-.478 0-.865-.36-.865-.805c0-1.576 0-2.702-.091-3.578c-.09-.864-.26-1.402-.543-1.827a4.16 4.16 0 0 0-1.425-1.31c-.186-.105-.509-.214-1.004-.305a15.098 15.098 0 0 0-1.75-.195A49.94 49.94 0 0 0 13.776 4l1.088 1c.34.313.343.822.008 1.139a.91.91 0 0 1-1.222.007L11.057 3.76a.778.778 0 0 1-.257-.572c0-.215.092-.421.257-.573L13.65.232a.91.91 0 0 1 1.222.007Z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <form id="sendConversation" class="space-y-6 @if($conversation) none-show @endif">
                        <p id="titleCon"
                           class=" w-full text-center font-extrabold text-extr underline decoration-blue-500 decoration-8 underline-offset-[20px] mb-5">
                            get your answer
                        </p>

                        <input id="ConEdit" class="hidden" name="con_edit" type="text" value="add">

                        <div class="wraper">
                            <div class="text-sm mr-4 font-semibold">title</div>
                            <textarea class="form-input text-smid w-full" name="title" placeholder="title"></textarea>
                        </div>

                        <div class="wraper">
                            <div class="text-sm mr-4 font-semibold">content</div>
                            <input id="editorJsContent" type="text" name="description" class="hidden">
                            {{--                    <textarea class="autosizeArea form-input text-smid w-full" rows="1" name="description"--}}
                            {{--                              type="text" placeholder="توضیح کوتاه..">{{old('description',$subject ? $subject->description : null)}}</textarea>--}}


                            <div id="editorjsCon" class="form-input"></div>
                        </div>
                        <div class="wraper">
                            <div id="tagtag" class="text-sm mr-4 font-semibold">tag</div>


                            <select id="ConTags" class="form-input select2 text-smid w-full font-YekanBakh"
                                    name="tags[]"
                                    multiple>

                                @foreach($tags as $tag)
                                    <option
                                        value="{{$tag->id}}">{{$tag->name}}</option>
                                @endforeach
                            </select>



                        </div>
                        @include('component.jsScripts.usermention.temp',['select2'=>'ConMention','wraper'=>'mentions'])

                        <div class="switchWraper p-2">
                            <input type="checkbox" id="private" hidden=""
                                   name="private">
                            @component('component.switch.switchLable',['shape'=> 'square','for' => 'private','noIcon' => true,'bgAnimate' => false])
                                @slot('title')
                                    <b>private with the mentioned user</b>
                                @endslot
                                @slot('pretitle')
                                    <b>public</b>
                                @endslot
                            @endcomponent
                        </div>

                        <div class="flex flex-wrap gap-3">
                            @component('component.btn.btnD',['color'=>'rose'])
                                @slot('title')
                                    send
                                @endslot
                                @slot('action')
                                    onclick="sendCon()"
                                @endslot
                                @slot('icon')
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M7.5 7.5h-.75A2.25 2.25 0 004.5 9.75v7.5a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25v-7.5a2.25 2.25 0 00-2.25-2.25h-.75m0-3l-3-3m0 0l-3 3m3-3v11.25m6-2.25h.75a2.25 2.25 0 012.25 2.25v7.5a2.25 2.25 0 01-2.25 2.25h-7.5a2.25 2.25 0 01-2.25-2.25v-.75"/>
                                    </svg>
                                @endslot
                            @endcomponent
                            @component('component.btn.btnD',['color'=>'blue'])
                                @slot('title')
                                    asq question
                                @endslot
                                @slot('action')
                                    onclick="AddConversation('add')"
                                @endslot
                                @slot('icon')
                                    @include('component.icon.discuss')
                                @endslot
                            @endcomponent
                            @component('component.btn.btnD',['color'=>'emerald'])
                                @slot('title')
                                    create private question
                                @endslot
                                @slot('action')
                                    onclick="AddConversation('addticket')"
                                @endslot
                                @slot('icon')
                                    @include('component.icon.comment')
                                @endslot
                            @endcomponent
                        </div>


                    </form>

                    <div id="sendConError" class="mt-6 space-y-6">

                    </div>
                </div>


            </article>


        </div>
        <aside class="sideArticle col-span-1 lg:col-span-3 ">

            @include('front.temp.aside.article')

        </aside>
    </div>


@endsection


@section('footerScripts')

    @parent

    <script src="{{asset('assets/js/allert.js')}}"></script>
    @include('component.cdn.select2')
    @include('component.cdn.autosize')



    @include('component.jsScripts.usermention.default')
    @include('component.jsScripts.usermention.usermention',['select2'=>'ConMention','wraper'=>'mentions'])


    @component('front.components.editorScripts')
    @endcomponent

    <script>

        let tagSelect = $('#ConTags').select2({
            placeholder: "search ...",
            closeOnSelect: false,
            dir: 'rtl'
        })

        let editorCon;


        let editorJsDataCon = [];


        let Conform = document.getElementById('sendConversation');
        let Concontent = Conform.closest('.contentWraper');
        let Conloader = Concontent.querySelector('.loader');

        let GetConTimout;

        function AddConversation(type, id = null) {
            clearTimeout(GetConTimout)
            Concontent.querySelector('.success').classList.add('hidden')
            Concontent.querySelector('.edited').classList.add('hidden')
            Conloader.classList.add('none-show')
            tagSelect.val(null).trigger('change')
            Conform.querySelector('[name="title"]').innerText = ''
            editorCon.blocks.clear()

            if (type == 'add') {
                Conform.classList.remove('none-show')
                Conform.querySelector('[name="con_edit"]').value = 'add';
                document.querySelector('#titleCon').innerText = 'get your answer'
                Conform.querySelector('#private').checked = false;
                setMention([], '#mentions' , true);



            } else if (type == 'addticket') {
                Conform.classList.remove('none-show')
                Conform.querySelector('[name="con_edit"]').value = 'add';
                document.querySelector('#titleCon').innerText = 'Start a private question';
                Conform.querySelector('#private').checked = true;
                setMention([], '#mentions' , true);


            } else if (type == 'edit') {
                Conform.querySelector('[name="con_edit"]').value = id;
                document.querySelector('#titleCon').innerText = 'change question'
                Conform.classList.add('none-show')
                Conloader.classList.remove('none-show')
                editorCon.blocks.clear()
                GetConTimout = setTimeout(function () {
                    ajaxReq(`{{base_web()}}getConInfo/${id}`, {}, function (data) {

                            console.log(data)
                            Conloader.classList.add('none-show')

                            //set Values
                            Conform.querySelector('#private').checked = data['private']
                            Conform.querySelector('[name="title"]').innerText = data['title']
                            tagSelect.val(data['tags']).trigger('change')
                            editorCon.render({
                                blocks: JSON.parse(data['content'])
                            })
                            setMention(data['mention'], '#mentions', true)

                            //set Values end
                            Conform.classList.remove('none-show')

                            document.querySelector('#titleCon').scrollIntoView()


                        },
                        'POST',
                        function (reject) {
                            swaltoast('The number of requests exceeds the allowed limit.', 'error')
                        })
                }, 300)

            }

        }

        let ConversationTimout;


        function sendCon() {

            clearTimeout(ConversationTimout)

            $([document.documentElement, document.body]).animate({
                scrollTop: 100
            }, 100);

            Conform.classList.add('none-show')


            selector('#sendConError').textContent = '';
            Conloader.classList.remove('none-show')

            editorCon.save().then((outputData) => {

                Conform.getElementsByClassName('usernameSelected')

                var mention = [];

                document.querySelectorAll('.usernameSelected').forEach(function (El, index) {

                    mention.push(El.dataset.value)

                })

                let data = {
                    title: Conform.querySelector('[name="title"]').value,
                    tags: getSelectValues(Conform.querySelector('[name="tags[]"]')),
                    content: JSON.stringify(outputData.blocks),
                    conversation: Conform.querySelector('[name="con_edit"]').value,
                    mention: mention,
                    private: Conform.querySelector('#private').checked
                }

                console.log(data)

                ConversationTimout = setTimeout(function () {
                    ajaxReq(`{{base_web()}}saveConversation`, data, function (data) {


                            console.log(data)

                            Conloader.classList.add('none-show')
                            if (data['stat'] === 'ok') {

                                if (Conform.querySelector('[name="con_edit"]').value != 'add') {
                                    Concontent.querySelector('.edited').classList.remove('hidden')

                                } else {
                                    Concontent.querySelector('.success').classList.remove('hidden')

                                }

                                setTimeout(function () {
                                    location.replace(data['nextpage']);
                                }, 500)

                            } else {
                                Conform.classList.remove('none-show')

                                document.querySelector('#tagtag').scrollIntoView()

                                selector('#sendConError').insertAdjacentHTML('afterbegin', `` + data + ``);

                            }

                        },
                        'POST',
                        function (reject) {
                            swaltoast('The number of requests exceeds the allowed limit.', 'error')
                        })
                }, 300)

            }).catch((error) => {

            });

        }


        window.addEventListener('DOMContentLoaded', function () {


            editorCon = new EditorJS({
                /**
                 * Enable/Disable the read only mode
                 */
                placeholder: 'Ask your question, we will help you find the answer😊💕',
                readOnly: false,

                /**
                 * Wrapper of Editor
                 */
                holder: 'editorjsCon',

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
                    blocks: editorJsDataCon
                },
            })
            @if($conversation)
            setTimeout(function () {
                AddConversation('edit', "{{$conversation}}")

            }, 500)
            @endif


        })


    </script>




@endsection

