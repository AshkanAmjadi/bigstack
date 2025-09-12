@extends('front.temp.master')

@push('schema')
    {!! JsonLd::generate() !!}
@endpush

@section('cssScripts')

    @parent

@endsection


@section('content')

    <div class="mainArticle flex gap-5 lg:flex-wrap lg:flex-col-reverse mb-10 mt-7">
        <div class="side w-[27%] 2xl:w-[33%] lg:w-full">
            <div class="l w-full lg:hidden">

                @include('content::front.articleList.topImage')

            </div>
            @include('front.temp.aside.article')


        </div>

        <div class=" w-[73%] 2xl:w-[67%] lg:space-y-4 lg:w-full">
            <div class="l w-full lg-r:hidden">
                @include('content::front.articleList.topImage')



            </div>

            @livewire('content::article-list.items',['articleIds' => $articleList->articles])


        </div>
    </div>

@endsection


@section('footerScripts')

    @parent
    <script src="{{asset('assets/js/allert.js')}}"></script>
    <script>
        Livewire.on('toArticles', (event) => {

            setTimeout(function () {
                document.querySelector(`#articles`).scrollIntoView();
            }, 300)

        });
    </script>

@endsection
