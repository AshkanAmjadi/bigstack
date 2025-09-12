@extends('front.temp.master')

@push('schema')
    {!! JsonLd::generate() !!}
@endpush

@section('cssScripts')


    @parent

@endsection


@section('content')

    <div class="mainArticle mb-10 mt-7">

        @livewire('tag.search',['tag' => $tag->name])

    </div>




@endsection



@section('footerScripts')

    @parent





@endsection
