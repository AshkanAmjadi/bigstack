@extends('front.temp.master')

@push('schema')
    <script type="application/ld+json">
        {!! clean($schema) !!}
    </script>
    {!! JsonLd::generate() !!}

@endpush

@section('cssScripts')

    @parent

@endsection


@section('content')

    <nav class="mainArticle my-6 md:mb-0">
        <div class="breadcrumb card_c p-4 md:p-3">
            @include('component.breadcrump.nav',['items' => $breadCrump])
        </div>
    </nav>
    @livewire('content::category.category-page',['category' => $category])

@endsection


@section('footerScripts')

    @parent
    @include('component.cdn.autosize')

    <script src="{{asset('assets/js/allert.js')}}"></script>
    <script>
        Livewire.on('toArticles', (event) => {

            setTimeout(function () {
                document.querySelector(`#articles`).scrollIntoView();
            },300)

        });
    </script>

@endsection
