@extends('front.temp.master')

@push('schema')
    {!! JsonLd::generate() !!}
@endpush

@section('cssScripts')

    @include('component.cdn.swipercss')
    <style>
        .homeSlide {
            scale: 0.9;
        }

        .homeSlide.swiper-slide-active {
            scale: 1;
            z-index: 1;
        }
    </style>

    @parent

@endsection


@section('content')

    <div class="mainContainer overflow-hidden ">


        <div class="place-items-center">

            <div class="top place-items-center mt-20">

                <h1 class="text-center font-extrabold text-extr">
                    <span class="top-headline">Turning Code into Business Growth</span>
                    📈
                </h1>
                <h2 class="text-center text-lg middle-headline font-bold">• Full‑Stack Developer •</h2>
                <h2 class="text-center text-elg mt-4">Expert in Laravel, Modern Frontend (React.js/Astro.js) & SEO</h2>
                <h2 class="text-center text-extr font-bold mt-10">A - Starter ————> b - Pro</h2>

            </div>


        </div>


    </div>
    <div class="mainContainer overflow-hidden py-10">
        <div class="grid grid-cols-3 md:grid-cols-2 sm:grid-cols-1 lg w-full gap-5">
            <div class="head-cards">
                <div class="flex items-center gap-3">
                    <span class="label inline-block p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-lg fill-zinc-900" width="24" height="24" viewBox="0 0 24 24">
                            <path  d="M18 2h-2v2h2zM4 4h6v2H4v14h14v-6h2v8H2V4zm4 8H6v6h6v-2h2v-2h-2v2H8zm4-2h-2v2H8v-2h2V8h2V6h2v2h-2zm2-6h2v2h-2zm4 0h2v2h2v2h-2v2h-2v2h-2v-2h2V8h2V6h-2zm-4 8h2v2h-2z" />
                        </svg>
                    </span>

                    <p class="inline-block text-elg font-bold">Articles</p>
                </div>

                <div class="mt-7">
                    <p>
                        Read insights on web development and best practices
                    </p>
                </div>
            </div>
            <a href="{{route('discuss.search')}}" class="head-cards ">
                <div class="flex items-center gap-3">
                    <span class="label inline-block p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-lg fill-zinc-900" width="24" height="24" viewBox="0 0 24 24">
                            <path  d="M10 18h3v3h-3zm7-13v6h-1v1h-1v1h-2v2h-3v-3h1v-1h2v-1h1V6h-4v1H9v1H7V5h1V4h1V3h6v1h1v1z"/>
                        </svg>
                    </span>
                    <p class="inline-block text-elg font-bold">Asq question</p>
                </div>

                <div class="mt-7">
                    <p>
                        Get expert advice on your development challenges
                    </p>
                </div>
            </a>
            <a href="{{route('project.search')}}" class="head-cards">
                <div class="flex items-center gap-3">
                    <span class="label inline-block p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-lg fill-zinc-900" width="24" height="24" viewBox="0 0 24 24">
                            <path  d="M8 9V7h2v2zm-2 2V9h2v2zm0 2H4v-2h2zm2 2v-2H6v2zm0 0h2v2H8zm8-6V7h-2v2zm2 2V9h-2v2zm0 2v-2h2v2zm-2 2v-2h2v2zm0 0v2h-2v-2z" />
                        </svg>
                    </span>
                    <p class="inline-block text-elg font-bold">Projects</p>
                </div>

                <div class="mt-7">
                    <p>
                        Explore innovative solutions and live applications
                    </p>
                </div>
            </a>

        </div>


    </div>
    <div class="mainContainer overflow-hidden ">
        <div class="flex text-lg mt-5 gap-3 font-bold items-center">
            <div class="icon-lg" style="color: var(--accent-color)">
                @include('component.icon.article')
            </div>

            Latest
        </div>
        <div class="swiper articleSlider w-full overflow-visible md:w-full  relative py-8">
            <div class="swiper-wrapper">

                @foreach($articles as $article)
                    <div class="swiper-slide">
                        @component('content::component.article.listedArticleCard',['subject' => $article,'cat' => true])

                        @endcomponent
                    </div>
                @endforeach
                <div class="swiper-slide w-full card_c flex justify-center flex-col gap-4 items-center py-8">

                    <div class="flex text-lg gap-3 font-bold items-center">
                        Reading
                    </div>
                    <div class="flex text-extr gap-3 font-bold items-center">
                        📰
                    </div>
                    <div class="flex text-lg gap-3 font-bold items-center">
                        Expand knowledge
                    </div>


                </div>

            </div>
            <div class="swiper-pagination "></div>

        </div>

    </div>
    <div class="mainContainer overflow-hidden ">
        <div class="flex text-lg mt-5 gap-3 font-bold items-center">
            <div class="icon-lg" style="color: var(--accent-color)">
                @include('component.icon.discuss')

            </div>

            Latest questions
        </div>
        <div class="swiper mySwiper-conversation w-full overflow-visible md:w-full  relative py-8">
            <div class="swiper-wrapper flex ">

                @foreach($conversations as $conversation)
                    <div class="swiper-slide">
                        @component('component.conversation.conListItem',['subject' => $conversation])

                        @endcomponent
                    </div>
                @endforeach


                <div class="swiper-slide w-full card_c flex justify-center flex-col gap-4 items-center py-8">

                    <div class="flex text-lg gap-3 font-bold items-center">
                        I have a problem I can't fix
                    </div>
                    <div class="flex text-extr gap-3 font-bold items-center">
                        🤔
                    </div>
                    <div class="flex text-lg gap-3 font-bold items-center">
                        Ask any questions you have here
                    </div>

                    @component('component.btn.linkBtn' ,['href' => route('discuss.search'),'color'=>'emerald'])
                        @slot('title')
                            <div class="font-bold">
                                Questions and discussion section
                            </div>
                        @endslot
                        @slot('icon')
                            @include('component.icon.discuss')
                        @endslot
                    @endcomponent

                </div>


            </div>
            <div class="swiper-pagination "></div>

        </div>

    </div>
    <div class="mainContainer overflow-hidden ">
        <div class="flex text-lg mt-5 gap-3 font-bold items-center">
            <div class="icon" >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" style="color: var(--accent-color)" class="icon-lg " height="24"
                     viewBox="0 0 24 24">
                    <g fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 7L8 17m8-10l-3 10m5-7H7m10 4H6"/>
                        <path
                            d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"
                            opacity=".5"/>
                    </g>
                </svg>
            </div>

            Tags
        </div>
        <div class="swiper mySwiper-tag w-full overflow-visible md:w-full  relative py-8">
            <div class="swiper-wrapper">

                @foreach(\App\facade\BaseCat\BaseCat::getAllTag() as $tag)
                    <a href="{{route('tag.show',['tag'=>$tag->name])}}"
                       class="swiper-slide card_c p-5 flex items-center justify-between">
                        <h2 class="font-bold text-smid">
                            {{$tag->name}}
                        </h2>
                        <div class="icon-lg" style="color: var(--accent-color)">
                            @include('component.icon.tag')
                        </div>
                    </a>
                @endforeach


            </div>
            <div class="swiper-pagination "></div>

        </div>

    </div>

@endsection


@section('footerScripts')

    @parent
    @include('component.cdn.swiper')


    <script>
        new Swiper(".mainSlider", {
            slidesPerView: 1,
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true
            },
            autoplay: {
                delay: 7000,
                disableOnInteraction: false,
            },
            initialSlide: 1,
            loop: true,

            centeredSlides: true,
            spaceBetween: -40,
            breakpoints: {

                768: {
                    slidesPerView: 1,
                    spaceBetween: -60,
                },
            },

        });


        new Swiper(".mySwiper-tag", {
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true
            },
            slidesPerView: 2.5,
            spaceBetween: 10,
            breakpoints: {
                640: {
                    slidesPerView: 4,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 5,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 7,
                    spaceBetween: 30,
                },
            },
        });
        new Swiper(".articleSlider", {
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true

            },
            slidesPerView: 1,
            spaceBetween: 10,
            breakpoints: {
                640: {
                    slidesPerView: 1.5,
                    spaceBetween: 15,
                },
                768: {
                    slidesPerView: 2.5,
                    spaceBetween: 20,
                },
                1200: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
            },
        });

        new Swiper(".mySwiper-conversation", {
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true

            },
            slidesPerView: 1,
            spaceBetween: 15,
            breakpoints: {
                640: {
                    slidesPerView: 1.1,
                    spaceBetween: 15,
                },
                768: {
                    slidesPerView: 1.2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 1.5,
                    spaceBetween: 25,
                },
                1536: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
            },
        });


        new Swiper(".projectSlider", {
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true

            },
            slidesPerView: 1,
            spaceBetween: 10,
            breakpoints: {
                640: {
                    slidesPerView: 1.5,
                    spaceBetween: 15,
                },
                768: {
                    slidesPerView: 2.5,
                    spaceBetween: 20,
                },
                1200: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
            },
        });


    </script>
@endsection

