@extends('front.temp.master')

@push('schema')
    <script type="application/ld+json">
        {!! clean($page->schema) !!}
    </script>
@endpush

@section('cssScripts')

    @parent

@endsection


@section('content')

    <div class="mainArticle mb-10 mt-7">

        <h1 class=" w-full text-center font-extrabold text-extr underline decoration-blue-500 decoration-8 underline-offset-[20px] mb-5">
            {{$page->title}}
        </h1>

        <div class="w-3/4 m-auto p-6 card_c 2xl:w-5/6 xl:w-11/12 lg:w-full lg:px-4">



            @include('component.description.description',['desc'=>editorJsDecode($page,'content'),'altImage'=>$page->page_title ? : $page->title])

        </div>

    </div>

@endsection


@section('footerScripts')

    @parent


@endsection
