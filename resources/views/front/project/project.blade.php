@extends('front.temp.master')

@push('schema')
    <script type="application/ld+json">
        {!! clean($project->schema) !!}
    </script>
    {!! JsonLd::generate() !!}

@endpush

@section('cssScripts')
    @include('component.cdn.swipercss')

    @parent

@endsection


@section('content')

    <article class="mainArticle  mb-10 mt-7">
        <div class="breadcrumb card_c p-4 mb-6 md:p-3">
            @include('component.breadcrump.nav',[
    'manual' => [
        'title' => $project->getRelation('service')->name ,
        'link' => route('project.search',['service'=>$project->getRelation('service')->name]),
        'icon' => 'service'
        ]
        ])
        </div>
        <div class="wraper w-full px-20 md:px-0 grid gap-5 grid-cols-5 relative">
            <div class="article col-span-3 space-y-4 lg:col-span-5 relative">

                @include('front.project.top')

            </div>
            <div class="col-span-2 lg:col-span-5 relative p-3">

                <h1 class="w-full text-center mt-5 font-bold text-mid border-b border-slate-700 dark:border-white mb-6 pb-4">{{$project->title}}</h1>

                <p class="p-normal font-semibold text-justify">
                    {{$project->meta_description}}
                </p>

                <div class="grid grid-cols-1 mt-10">
                    @component('component.btn.linkBtn',['title' => 'preview','color'=> 'amber','size'=>'lg','nofollow'=>true])
                        @slot('href')
                            {{$project->preview_page}}
                        @endslot
                        @slot('icon')
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" class="icon-sm"
                                 viewBox="0 0 24 24">
                                <defs>
                                    <clipPath id="lineMdWatchTwotoneLoop0">
                                        <rect width="24" height="12"/>
                                    </clipPath>
                                    <symbol id="lineMdWatchTwotoneLoop1">
                                        <path fill="#fff" fill-opacity="0" stroke="#fff" stroke-linecap="round"
                                              stroke-linejoin="round" stroke-width="2"
                                              d="M23 16.5C23 10.4249 18.0751 5.5 12 5.5C5.92487 5.5 1 10.4249 1 16.5z"
                                              clip-path="url(#lineMdWatchTwotoneLoop0)">
                                            <animate attributeName="d" dur="6s" keyTimes="0;0.07;0.93;1"
                                                     repeatCount="indefinite"
                                                     values="M23 16.5C23 11.5 18.0751 12 12 12C5.92487 12 1 11.5 1 16.5z;M23 16.5C23 10.4249 18.0751 5.5 12 5.5C5.92487 5.5 1 10.4249 1 16.5z;M23 16.5C23 10.4249 18.0751 5.5 12 5.5C5.92487 5.5 1 10.4249 1 16.5z;M23 16.5C23 11.5 18.0751 12 12 12C5.92487 12 1 11.5 1 16.5z"/>
                                            <animate fill="freeze" attributeName="fill-opacity" begin="0.6s" dur="0.15s"
                                                     values="0;0.3"/>
                                        </path>
                                    </symbol>
                                    <mask id="lineMdWatchTwotoneLoop2">
                                        <use href="#lineMdWatchTwotoneLoop1"/>
                                        <use href="#lineMdWatchTwotoneLoop1" transform="rotate(180 12 12)"/>
                                        <circle cx="12" cy="12" r="0" fill="#fff">
                                            <animate attributeName="r" dur="6s" keyTimes="0;0.03;0.97;1"
                                                     repeatCount="indefinite" values="0;3;3;0"/>
                                        </circle>
                                    </mask>
                                </defs>
                                <rect width="24" height="24" fill="currentColor" mask="url(#lineMdWatchTwotoneLoop2)"/>
                            </svg>
                        @endslot
                    @endcomponent
                </div>

            </div>

        </div>
        <div id="plans" class="swiper plan w-full overflow-visible md:w-full  relative py-8">
            <div class="swiper-wrapper flex ">


                @foreach($project->plans as $plan)


                    <div class="swiper-slide">
                        <div class="w-full card_c @if($plan->suggest) !bg-blue-500 !text-white @endif p-3 px-5 flex flex-col items-center pb-9">

                            <div class="text-lg p-2 font-bold text-center inline-block">{{$plan->name}}</div>
                            <div class="flex pt-2 px-4 text-white rounded-2xl shadow-xl shadow-emerald-700/30 !bg-emerald-500">
                                <div class="font-bold text-extr">{{number_format($plan->price)}}</div>
                                <div class="font-extrabold text-lg mt-2 mr-1">تومان</div>
                            </div>
                            <div class="w-5/6 bdb @if($plan->suggest) !border-white @endif mt-8 mb-6"></div>
                            <div class="possible w-full mb-4">

                                @foreach($project->possible as $posible)

                                    <div class="text-smid font-semibold py-3">
                                        @if($plan->getRelation('possible')->where('id',$posible->id)->first())
                                            ✔️
                                        @else
                                            ❌
                                        @endif
                                        {{$posible->name}}
                                    </div>
                                @endforeach


                            </div>
                            @component('component.btn.linkBtn',['title' => 'مشاوره رایگان','color'=> 'indigo','size'=>'lg','shadow'=>false])
                                @slot('href')
                                    #
                                @endslot
                                @slot('icon')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" class="icon-sm"
                                         viewBox="0 0 24 24">
                                        <defs>
                                            <clipPath id="lineMdWatchTwotoneLoop0">
                                                <rect width="24" height="12"/>
                                            </clipPath>
                                            <symbol id="lineMdWatchTwotoneLoop1">
                                                <path fill="#fff" fill-opacity="0" stroke="#fff" stroke-linecap="round"
                                                      stroke-linejoin="round" stroke-width="2"
                                                      d="M23 16.5C23 10.4249 18.0751 5.5 12 5.5C5.92487 5.5 1 10.4249 1 16.5z"
                                                      clip-path="url(#lineMdWatchTwotoneLoop0)">
                                                    <animate attributeName="d" dur="6s" keyTimes="0;0.07;0.93;1"
                                                             repeatCount="indefinite"
                                                             values="M23 16.5C23 11.5 18.0751 12 12 12C5.92487 12 1 11.5 1 16.5z;M23 16.5C23 10.4249 18.0751 5.5 12 5.5C5.92487 5.5 1 10.4249 1 16.5z;M23 16.5C23 10.4249 18.0751 5.5 12 5.5C5.92487 5.5 1 10.4249 1 16.5z;M23 16.5C23 11.5 18.0751 12 12 12C5.92487 12 1 11.5 1 16.5z"/>
                                                    <animate fill="freeze" attributeName="fill-opacity" begin="0.6s" dur="0.15s"
                                                             values="0;0.3"/>
                                                </path>
                                            </symbol>
                                            <mask id="lineMdWatchTwotoneLoop2">
                                                <use href="#lineMdWatchTwotoneLoop1"/>
                                                <use href="#lineMdWatchTwotoneLoop1" transform="rotate(180 12 12)"/>
                                                <circle cx="12" cy="12" r="0" fill="#fff">
                                                    <animate attributeName="r" dur="6s" keyTimes="0;0.03;0.97;1"
                                                             repeatCount="indefinite" values="0;3;3;0"/>
                                                </circle>
                                            </mask>
                                        </defs>
                                        <rect width="24" height="24" fill="currentColor" mask="url(#lineMdWatchTwotoneLoop2)"/>
                                    </svg>
                                @endslot
                            @endcomponent
                        </div>

                    </div>

                @endforeach




            </div>
            <div class="swiper-pagination !bottom-0"></div>

        </div>
        <div class="space-y-5 mt-10 md:mt-5 relative z-10">
            <div class="description card_c p-5 md:p-3">
                <div class="flexBC mb-5">
                    <div class="r">

                    </div>
                    <div class="l"></div>
                </div>
                @include('component.description.description',['desc'=>editorJsDecode($project,'description'),'altImage'=>$project->page_title])

                @livewire('markable.star',['obj'=>$project ],key($project->getTable() .'_star_' . $project->id))
                <div class="tags flexC gap-3  flex-row-reverse mt-4 w-full">
                    <input id="shareLink" type="text" class="hidden"
                           value="{{route('project.show',['project'=>$project->slug])}}">
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
                    @foreach($project->tags as $tag)
                        <a href="{{route('tag.show',['tag'=>$tag->name,'subject'=>'project'])}}"
                           class="card_cwc inline-flex items-center p-3 md:p-1.5 gap-3">
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

            </div>
            <div class="author card_c p-5 mb-4 flexBC gap-2">

                @include('user::front.component.who' , ['relation' => 'added_by','subject' => $project])
                <div class="marks flex flex-row-reverse gap-3 md:gap-1">
                    @livewire('markable.like',['obj'=>$project],key($project->getTable() .'_like_' . $project->id))
                    @livewire('markable.mark',['obj'=>$project],key($project->getTable() .'_mark_' . $project->id))
                    <a href="#aricleComments" class="flex items-center">
                        @component('front.components.icon.numIcon',['number' => $project->commentNum,'color'=>'emerald'])
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="currentColor" fill-rule="evenodd"
                                      d="m13.629 20.472l-.542.916c-.483.816-1.69.816-2.174 0l-.542-.916c-.42-.71-.63-1.066-.968-1.262c-.338-.197-.763-.204-1.613-.219c-1.256-.021-2.043-.098-2.703-.372a5 5 0 0 1-2.706-2.706C2 14.995 2 13.83 2 11.5v-1c0-3.273 0-4.91.737-6.112a5 5 0 0 1 1.65-1.651C5.59 2 7.228 2 10.5 2h3c3.273 0 4.91 0 6.113.737a5 5 0 0 1 1.65 1.65C22 5.59 22 7.228 22 10.5v1c0 2.33 0 3.495-.38 4.413a5 5 0 0 1-2.707 2.706c-.66.274-1.447.35-2.703.372c-.85.015-1.275.022-1.613.219c-.338.196-.548.551-.968 1.262ZM8 11.75a.75.75 0 0 0 0 1.5h5.5a.75.75 0 0 0 0-1.5H8ZM7.25 9A.75.75 0 0 1 8 8.25h8a.75.75 0 0 1 0 1.5H8A.75.75 0 0 1 7.25 9Z"
                                      clip-rule="evenodd"/>
                            </svg>
                        @endcomponent
                    </a>
                </div>


            </div>

            @livewire('comment.comments',['subject' => $project->id,'model' => class_basename($project)],key($project->id))
        </div>
    </article>

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
                    Your comment has been submitted and is awaiting approval
                </div>
                <div class="font-extrabold text-white">
                    Thank you dear user 💕
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
                    <div class="text-sm mr-4 font-semibold">title</div>
                    <input class="form-input text-smid w-full" name="title" type="text"
                           value="">
                </div>
                <div class="wraper">
                    <div class="text-sm mr-4 font-semibold">content <span class="text-rose-600">(required)</span></div>
                    <textarea class="autosizeArea form-input text-smid w-full" rows="1" name="content"
                              type="text"></textarea>
                </div>

                @component('component.btn.btnD',['color'=>'rose'])
                    @slot('title')
                        send
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
    @include('component.cdn.autosize')
    <script src="{{asset('assets/js/allert.js')}}"></script>
    @include('component.cdn.swiper')


    <script>

        new Swiper(".plan", {
            pagination: {
                el: ".swiper-pagination",
            },
            centeredSlides: true,
            initialSlide : 1,
            slidesPerView: 1.3,
            spaceBetween: 10,
            breakpoints: {
                640: {
                    slidesPerView: 1.8,
                    spaceBetween: 15,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 2.5,
                    spaceBetween: 25,
                },
                1536: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
            },
        });

        let CommentStart = false;

        //open comment when we arive
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
                model: 'Project',
                subject: '{{$project->id}}',
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
