@extends('front.temp.master')

@push('schema')
    <script type="application/ld+json">
        {!! clean($schema) !!}
    </script>
@endpush

@section('cssScripts')


    @parent

@endsection


@section('content')

    <div class="mainArticle mb-10 mt-7">

        @livewire('conversation.search')

    </div>


@endsection



@section('footerScripts')

    @parent
    <script src="{{asset('assets/js/allert.js')}}"></script>
    <script>
        Livewire.on('toArticles', (event) => {

            setTimeout(function () {
                document.querySelector(`#toAnswers`).scrollIntoView();
            },300)

        });
    </script>






@endsection
