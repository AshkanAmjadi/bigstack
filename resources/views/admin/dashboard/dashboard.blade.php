@extends('admin.master')


@section('cssScripts')


    <link rel="stylesheet" href="{{asset('assets/css/cropper/cropper.css')}}"/>
    @parent

@endsection

@section('title','داشبورد')

@section('content')
    <div id="content" class="mini w-full pt-16 text-slate-700 pb-6">
        <div id="contentWraper" class="w-11/12 mx-auto mt-16 lg:w-96p sm:w-full space-y-6">
            <h2 class="font-bold text-felg mr-6 mb-2 md:mr-3">
                داشبورد
            </h2>

            <div id="addTag"
                  class="space-y-3 space-y-reverse card_c p-4 px-6" >
                <div class="wraper">
                    @include('admin.components.cropImage',['title' => "بنر ",'name' => 'banner','id'=>'tagBanner','size'=>0,'semantic'=>true])
                </div>
                @error('banner')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
            </div>

        </div>
    </div>
@endsection


@section('footerScripts')

    @parent
    <script src="{{asset('assets/js/allert.js')}}"></script>
    <script src="{{asset('assets/js/plugins/cropper/cropper.js')}}"></script>
    <script src="{{asset('assets/js/plugins/cropper/myCropper.js')}}"></script>

    {{--    <script></script>--}}
@endsection
