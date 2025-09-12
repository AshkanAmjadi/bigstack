@extends('front.temp.master')

@push('schema')
    <script type="application/ld+json">
        {!! clean($conversation->schema) !!}
    </script>
@endpush

@section('cssScripts')
    @include('component.cdn.select2css')
    <link rel="stylesheet" href="{{asset('assets/css/editorjs/editorjs.css')}}"/>
    @parent

@endsection


@section('content')

    <div class="mainArticle mb-10 mt-7">
        <article class="conversation w-full space-y-4">
            @include('front.conversation.top')
        </article>

        <div class="bottom flex gap-5 lg:flex-wrap lg:flex-col-reverse">
            <aside class="side w-1/3 lg:w-full">
                <div class="w-full lg:hidden mb-5" >
                    @component('component.btn.linkBtn',['title' => 'Asq question','href' =>route('conversation.cratf'),'size' => 'xl','class' => 'w-full','iconsize' => 'md'])
{{--                        @slot('action')--}}
{{--                            onclick="AddConversation('add')"--}}
{{--                        @endslot--}}
                        @slot('icon')
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" class="mr-3" height="24"
                                 viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path
                                        d="M16.652 3.455s.081 1.379 1.298 2.595c1.216 1.217 2.595 1.298 2.595 1.298M10.1 15.588L8.413 13.9"
                                        opacity=".5"/>
                                    <path
                                        d="m16.652 3.455l.649-.649A2.753 2.753 0 0 1 21.194 6.7l-.65.649l-5.964 5.965c-.404.404-.606.606-.829.78a4.59 4.59 0 0 1-.848.524c-.255.121-.526.211-1.068.392l-1.735.579l-1.123.374a.742.742 0 0 1-.939-.94l.374-1.122l.579-1.735c.18-.542.27-.813.392-1.068c.144-.301.32-.586.524-.848c.174-.223.376-.425.78-.83l5.965-5.964Z"/>
                                    <path stroke-linecap="round"
                                          d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2"
                                          opacity=".5"/>
                                </g>
                            </svg>
                        @endslot
                    @endcomponent
                </div>


                <div >

                    @include('front.temp.aside.conversation')
                </div>

            </aside>
            <div id="answers" class="answers w-2/3 lg:w-full space-y-6">
                <div class="w-full lg-r:hidden">
                    @component('component.btn.linkBtn',['title' => 'asq question','href' => route('conversation.cratf'),'size' => 'xl','class' => 'w-full','iconsize' => 'md'])
{{--                        @slot('action')--}}
{{--                            onclick="AddConversation('add')"--}}
{{--                        @endslot--}}
                        @slot('icon')
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" class="mr-3" height="24"
                                 viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path
                                        d="M16.652 3.455s.081 1.379 1.298 2.595c1.216 1.217 2.595 1.298 2.595 1.298M10.1 15.588L8.413 13.9"
                                        opacity=".5"/>
                                    <path
                                        d="m16.652 3.455l.649-.649A2.753 2.753 0 0 1 21.194 6.7l-.65.649l-5.964 5.965c-.404.404-.606.606-.829.78a4.59 4.59 0 0 1-.848.524c-.255.121-.526.211-1.068.392l-1.735.579l-1.123.374a.742.742 0 0 1-.939-.94l.374-1.122l.579-1.735c.18-.542.27-.813.392-1.068c.144-.301.32-.586.524-.848c.174-.223.376-.425.78-.83l5.965-5.964Z"/>
                                    <path stroke-linecap="round"
                                          d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2"
                                          opacity=".5"/>
                                </g>
                            </svg>
                        @endslot
                    @endcomponent
                </div>
                @include('front.conversation.answers')
            </div>


        </div>
    </div>

    @component('admin.components.sidebar',['name' => 'AddAnswer'])

        <div class="top flex flex-wrap justify-between w-full absolute top-0 left-0 p-6 z-10">
            <div class="right"></div>
            <div class="left">
                @component('component.btn.btnD',['color'=>'sky' ])
                    @slot('action')
                        onclick="sidebar('hide','AddAnswer')"
                    @endslot
                    @slot('icon')
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <g fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M20.75 12a.75.75 0 0 0-.75-.75h-9.25v1.5H20a.75.75 0 0 0 .75-.75Z"
                                      clip-rule="evenodd" opacity=".5"/>
                                <path
                                    d="M10.75 18a.75.75 0 0 1-1.28.53l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.28.53v12Z"/>
                            </g>
                        </svg>
                    @endslot
                @endcomponent

            </div>
        </div>
        <div class="contentWraper px-3 py-12">
            <div class="loader absoluteCenter icon-2xl text-blue-500 hidden">
                @include('component.loading.loading')
            </div>
            <div class="success text-elg !bg-indigo-500 card_cw py-20 text-center hidden">
                <div class="font-extrabold text-white">
                    Your response has been registered and is awaiting approval.
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
            <form id="sendAnswer" class="space-y-6">


                <input id="AnswerEdit" class="hidden" name="answer_edit" type="text">

                <div class="wraper">
                    <div class="text-sm mr-4 font-semibold">content</div>
                    <input id="editorJsContent" type="text" name="description" class="hidden">
                    {{--                    <textarea class="autosizeArea form-input text-smid w-full" rows="1" name="description"--}}
                    {{--                              type="text" placeholder="توضیح کوتاه..">{{old('description',$subject ? $subject->description : null)}}</textarea>--}}


                    <div id="editorjs" class="form-input"></div>
                </div>

                @include('component.jsScripts.usermention.temp',['select2'=>'AnsMention','wraper'=>'answer_mentions'])

                @component('component.btn.btnD',['color'=>'rose'])
                    @slot('title')
                        send
                    @endslot
                    @slot('action')
                        onclick="sendAnswer()"
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

            <div id="sendAnswerError" class="mt-6 space-y-6">

            </div>
        </div>
    @endcomponent


@endsection


@section('footerScripts')

    @parent

    <script src="{{asset('assets/js/allert.js')}}"></script>
    @include('component.cdn.select2')



    @include('component.jsScripts.usermention.default')
    @include('component.jsScripts.usermention.usermention',['select2'=>'AnsMention','wraper'=>'answer_mentions'])


    @component('front.components.editorScripts')
    @endcomponent

    <script>


        let editor;


        let editorJsData = [];

        let form = document.getElementById('sendAnswer');
        let content = form.closest('.contentWraper');
        let loader = content.querySelector('.loader');


        let GetAnswerTimout;

        function AddAnswer(type, id = null) {
            sidebar('show', 'AddAnswer');
            content.querySelector('.success').classList.add('hidden')
            content.querySelector('.edited').classList.add('hidden')
            content.querySelector('.success').classList.add('hidden')
            loader.classList.add('hidden')

            if (type == 'add') {
                form.classList.remove('hidden')
                form.querySelector('[name="answer_edit"]').value = 'add';
                setMention([],'#answer_mentions',true)

            } else if (type == 'edit') {
                form.classList.add('hidden')
                loader.classList.remove('hidden')
                editor.blocks.clear()
                form.querySelector('[name="answer_edit"]').value = id;
                GetAnswerTimout = setTimeout(function () {
                    ajaxReq(`{{base_web()}}getAnswerContent/${id}`, {}, function (data) {

                            loader.classList.add('hidden')

                            editor.render({
                                blocks: JSON.parse(data['content'])
                            })
                            form.classList.remove('hidden')
                            setMention(data['mention'],'#answer_mentions',true)


                        },
                        'POST',
                        function (reject) {
                            swaltoast('The number of requests exceeds the allowed limit.', 'error')
                        })
                }, 300)

            }
        }

        let AnswerTimout;


        function sendAnswer() {

            clearTimeout(AnswerTimout)

            form.classList.add('hidden')
            selector('#sendAnswerError').textContent = '';
            loader.classList.remove('hidden')

            editor.save().then((outputData) => {

                form.getElementsByClassName('usernameSelected')

                var mention = [];

                document.querySelectorAll('.usernameSelected').forEach(function (El, index) {

                    mention.push(El.dataset.value)

                })

                let data = {
                    conversation: '{{$conversation->id}}',
                    content: JSON.stringify(outputData.blocks),
                    answer: form.querySelector('[name="answer_edit"]').value,
                    mention: mention,
                }


                AnswerTimout = setTimeout(function () {
                    ajaxReq(`{{base_web()}}saveAnswer`, data, function (data) {


                            loader.classList.add('hidden')
                            if (data['stat'] === 'ok') {

                                if (data['req'] != 'add') {
                                    content.querySelector('.edited').classList.remove('hidden')

                                } else {
                                    content.querySelector('.success').classList.remove('hidden')

                                }

                                setTimeout(function () {
                                    sidebar('hide', 'AddAnswer');
                                    selector('#refreshAnswers').click()
                                    document.querySelector('#toAnswers').scrollIntoView()

                                },1000)

                            } else {
                                form.classList.remove('hidden')

                                selector('#sendAnswerError').insertAdjacentHTML('afterbegin', `` + data + ``);

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
            setTimeout(function () {
                $('.forDelete').hide()
            },5000)
        })
        window.addEventListener('DOMContentLoaded', function () {
            editor = new EditorJS({
                /**
                 * Enable/Disable the read only mode
                 */
                placeholder: 'Record your answer and help our friend find the answer so we can progress together 😊💕',
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

        })


    </script>

@endsection
