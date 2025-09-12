@extends('front.temp.master')

@push('schema')
    <script type="application/ld+json">
        {!! clean($article->schema) !!}
    </script>
@endpush

@section('cssScripts')

    @include('component.cdn.highlightecss')

    @parent

@endsection


@section('content')

    <div class="mainArticle grid gap-5 grid-cols-3 mb-10 mt-7">
        <div class="article col-span-2 space-y-4 lg:col-span-3">


            <article class="space-y-5">

                <section id="middle" class="description card_c p-5 md:p-3 space-y-6">
                    <header>
                        @include('content::front.article.top')

                    </header>


                    @include('component.description.description',['desc'=>editorJsDecode($article,'description'),'altImage'=>$article->page_title])

                    <div class="tags flexC gap-3  flex-row-reverse w-full">
                        <input id="shareLink" type="text" class="hidden"
                               value="{{route('article.show',['article'=>$article->slug])}}">
                        @component('component.btn.btnD',['title' => 'Share','size' => 'lg'])
                            @slot('action')
                                onclick="copyUrl('shareLink')"
                            @endslot
                            @slot('icon')
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="icon-sm"
                                     viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9 11.5a2.5 2.5 0 1 1-5 0a2.5 2.5 0 0 1 5 0Z"/>
                                        <path stroke-linecap="round" d="M14.32 16.802L9 13.29m5.42-6.45L9.1 10.35"
                                              opacity=".5"/>
                                        <path
                                                d="M19 18.5a2.5 2.5 0 1 1-5 0a2.5 2.5 0 0 1 5 0Zm0-13a2.5 2.5 0 1 1-5 0a2.5 2.5 0 0 1 5 0Z"/>
                                    </g>
                                </svg>
                            @endslot
                        @endcomponent
                        @foreach($article->tags as $tag)
                            <a href="{{route('tag.show',['tag'=>$tag->name])}}"
                               class="card_cwc inline-flex items-center p-3 md:p-1.5 gap-3 blueHover">
                                <div class="font-bold text-smid">
                                    {{$tag->name}}
                                </div>
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-md text-blue-500" width="24"
                                         height="24" viewBox="0 0 24 24">
                                        <g fill="currentColor">
                                            <path
                                                    d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"
                                                    opacity=".5"></path>
                                            <path fill-rule="evenodd"
                                                  d="M11.718 7.215a.75.75 0 0 0-1.436-.43l-.74 2.465H7a.75.75 0 0 0 0 1.5h2.092l-.75 2.5H6a.75.75 0 1 0 0 1.5h1.892l-.61 2.034a.75.75 0 0 0 1.436.431l.74-2.465h3.434l-.61 2.034a.75.75 0 0 0 1.436.431l.74-2.465H17a.75.75 0 0 0 0-1.5h-2.092l.75-2.5H18a.75.75 0 0 0 0-1.5h-1.892l.61-2.035a.75.75 0 0 0-1.436-.43l-.74 2.465h-3.434l.61-2.035Zm2.374 3.535l-.75 2.5H9.908l.75-2.5h3.434Z"
                                                  clip-rule="evenodd"></path>
                                        </g>
                                    </svg>
                                </div>

                            </a>
                        @endforeach
                    </div>

                </section>

                @if(mobileDevice())
                    @include('content::front.article.authorstar')
                @endif

                @if($related =  $article->related->count())
                    <section class="related">
                        <div class="flex text-lg mt-5 gap-3 font-bold items-center mb-3 sm:grid-cols-1">
                            <div class="icon-lg text-blue-500">
                                @include('component.icon.article')
                            </div>

                            Related
                        </div>
                        <div class="grid grid-cols-2 gap-4 1.5xl:grid-cols-1 lg:grid-cols-2 md:grid-cols-1">

                            @foreach($article->related as $artRel)

                                <a href="{{route('article.show',['article'=>$artRel->slug])}}" class="card_c relative blueHover p-3 flex items-center gap-4">

                                    <span class="indicator absolute w-1 h-4/5  rounded-r-full bg-blue-500 left-0 topToCenter"></span>

                                    <div class="right ">
                                        <div
                                            class="img overflow-hidden rounded-lg shadow-custom_gray w-[150px] fsm:w-[125px]">
                                            <div  class="">
                                                <img src="{{semanticImgUrlMaker($artRel,'img')}}" class="w-full"
                                                     alt="{{$artRel->alt ? : $artRel->page_title}}">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="left">
                                        <div >
                                            <h3 class="text-smid font-bold">
                                                {{$artRel->title}}
                                            </h3>
                                        </div>
                                    </div>

                                </a>

                            @endforeach


                        </div>
                    </section>

                @endif


            </article>

            @livewire('comment.comments',['subject' => $article->id],key($article->id))

        </div>
        <aside class="sideArticle col-span-1 lg:col-span-3 ">
            @if(!mobileDevice())
                @include('content::front.article.authorstar')
            @endif
            @include('front.temp.aside.article')

        </aside>
    </div>

    @component('admin.components.sidebar',['name' => 'AddCommnet','right'=>true])

        <div class="top flex flex-wrap justify-between w-full absolute top-0 left-0 p-6">
            <div class="right"></div>
            <div class="left">
                @component('component.btn.btnD',['color'=>'sky' ])
                    @slot('action')
                        onclick="sidebar('hide','AddCommnet')"
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
            <div class="loader absoluteCenter hidden text-blue-500 icon-2xl">
                @include('component.loading.loading')
            </div>
            <div class="success text-elg !bg-emerald-500 card_cw py-20 text-center hidden">
                <div class="font-extrabold text-white">
                    دیدگاه شما ثبت شد و در انتظار تایید میباشد
                </div>
                <div class="font-extrabold text-white">
                    با تشکر از شما کاربر عزیز💕
                </div>
                <div class="icon-xl w-full flex justify-center mt-6 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor" fill-rule="evenodd"
                              d="m13.087 21.388l.542-.916c.42-.71.63-1.066.968-1.262c.338-.197.763-.204 1.613-.219c1.256-.021 2.043-.098 2.703-.372a5 5 0 0 0 2.706-2.706C22 14.995 22 13.83 22 11.5v-1c0-3.273 0-4.91-.737-6.112a5 5 0 0 0-1.65-1.651C18.41 2 16.773 2 13.5 2h-3c-3.273 0-4.91 0-6.112.737a5 5 0 0 0-1.651 1.65C2 5.59 2 7.228 2 10.5v1c0 2.33 0 3.495.38 4.413a5 5 0 0 0 2.707 2.706c.66.274 1.447.35 2.703.372c.85.015 1.275.022 1.613.219c.337.196.548.551.968 1.262l.542.916c.483.816 1.69.816 2.174 0ZM15.53 8.47a.75.75 0 0 1 0 1.06l-4 4a.75.75 0 0 1-1.05.011l-2-1.92a.75.75 0 1 1 1.04-1.082l1.47 1.411l3.48-3.48a.75.75 0 0 1 1.06 0Z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <form id="sendComment" class="space-y-6">

                <input id="commentParentSave" class="hidden" name="parent" type="number" value="0">
                <div class="wraper">
                    <div class="text-sm mr-4 font-semibold">عنوان(اختیاری)</div>
                    <input class="form-input text-smid w-full" name="title" type="text"
                           value="">
                </div>
                <div class="wraper">
                    <div class="text-sm mr-4 font-semibold">محتوی</div>
                    <textarea class="autosizeArea form-input text-smid w-full" rows="1" name="content"
                              type="text"></textarea>
                </div>

                @component('component.btn.btnD',['color'=>'rose'])
                    @slot('title')
                        ارسال اطلاعات
                    @endslot
                    @slot('action')
                        onclick="sendComment()"
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

            <div id="sendCommentError" class="mt-6 space-y-6">

            </div>
        </div>
    @endcomponent

@endsection


@section('footerScripts')

    @parent
    @include('component.cdn.highlightejs')

    @include('component.cdn.autosize')
    <script src="{{asset('assets/js/allert.js')}}"></script>

    <script>

        let CommentStart = false;

        body.addEventListener('scroll', function () {

            let commentToTopWindow = selector('#startComment').getBoundingClientRect().top + 130

            if (commentToTopWindow < window.innerHeight && !CommentStart) {
                selector('#startComment').click();
                CommentStart = true;
            }

        })
        window.addEventListener('scroll', function () {

            let commentToTopWindow = selector('#startComment').getBoundingClientRect().top + 130

            if (commentToTopWindow < window.innerHeight && !CommentStart) {
                selector('#startComment').click();
                CommentStart = true;
            }

        })
        let form = document.getElementById('sendComment');

        function AddComment(parent = 0) {
            sidebar('show', 'AddCommnet');
            let content = form.closest('.contentWraper');
            document.getElementById('commentParentSave').value = parent;
            content.querySelector('.success').classList.add('hidden')
            form.classList.remove('hidden')
            form.querySelector('[name="title"]').value = '';
            form.querySelector('[name="content"]').value = '';
        }

        let commentTimout;

        function sendComment() {


            clearTimeout(commentTimout)
            let content = form.closest('.contentWraper');
            let loader = content.querySelector('.loader');
            form.classList.add('hidden')
            selector('#sendCommentError').textContent = '';
            loader.classList.remove('hidden')


            let data = {
                title: form.querySelector('[name="title"]').value,
                parent: form.querySelector('[name="parent"]').value,
                content: form.querySelector('[name="content"]').value,
                model: 'Article',
                subject: '{{$article->id}}',
            }
            console.log(data)
            commentTimout = setTimeout(function () {
                ajaxReq(`{{base_web()}}saveComment`, data, function (data) {

                    loader.classList.add('hidden')
                    console.log(data)
                    if (data === 'ok') {

                        selector('#refreshComments').click()
                        content.querySelector('.success').classList.remove('hidden')

                    } else {
                        form.classList.remove('hidden')

                        selector('#sendCommentError').insertAdjacentHTML('afterbegin', `` + data + ``);

                    }

                }, 'POST', function (reject) {
                    swaltoast('تعداد درخواست بیش از حد مجاز', 'error')
                })
            }, 300)
        }


    </script>
@endsection
