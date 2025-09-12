
@extends('user::userPanel.master')

@section('title',"اعلانات")

{{--todo compelete the web options--}}
@section('content')

    <div id="content" class="mini w-full pt-16 text-slate-700 pb-6">

        <div id="contentWraper" class="w-11/12 mx-auto mt-16 lg:w-96p sm:w-full space-y-6">
            <h2 id="allertsHead" class="font-bold text-felg mr-6 mb-2 md:mr-3">
                اعلانات
            </h2>

            @livewire('user::profile.allerts')



        </div>


    </div>

@endsection

@section('footerScripts')

    @parent

    {{--ckeditor--}}
    {{--    <script src="{{asset('assets/js/plugins/ckeditor/ckeditor.js')}}"></script>--}}
    <script>
        // CKEDITOR.replace('description');
    </script>

    {{--  editor.js  --}}




    <script src="{{asset('assets/js/allert.js')}}"></script>
    @include('component.cdn.autosize')



    <script>


    </script>

@endsection
