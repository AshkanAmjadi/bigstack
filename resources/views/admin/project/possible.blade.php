@extends('admin.master')
@php

 $allPos = \App\facade\BaseCat\BaseCat::getAllPossible();
 $selectedPoss = $project->possible()->get(['id']);
    $subject = $project;
    $prefix = 'admin.project.';
    $name_en = 'project';
    $name_fa = 'پروژه ها';
    $name_fa_fard = 'پروژه';


@endphp
@section('cssScripts')

    <link rel="stylesheet" href="{{asset('assets/css/editorjs/editorjs.css')}}"/>

    @parent

@endsection

@section('title',"ویرایش امکانات $name_fa_fard ($subject->page_title)")

@section('content')

    <div id="content" class="mini w-full pt-16 text-slate-700 pb-6">

        <div id="contentWraper" class="w-11/12 mx-auto mt-16 lg:w-96p sm:w-full space-y-6">
            <h2 class="font-bold text-felg mr-6 mb-2 md:mr-3">
                ویرایش امکانات {{$name_fa_fard}} ({{$subject->page_title}})

            </h2>


            <form id="setArticleDesc" action="{{route($prefix."possible.store",[$name_en => $subject->id])}}"
                  class="space-y-3 space-y-reverse card_c p-4 px-6" method="POST">
                @csrf
                @method('POST')

                <div class="flex flex-wrap gap-3">
                    @foreach($allPos as $possible)
                        <div class="checkboxWraper img p-0">

                            <input id="possible{{$possible->id}}" @if($selectedPoss->where('id',$possible->id)->first()) checked @endif type="checkbox" name="possible_ids[]" value="{{$possible->id}}">
                            <label for="possible{{$possible->id}}" class="card_c box !flex items-center">

                                <h2 class="title text-sm ml-6 font-semibold text-center">
                                    {{$possible->name}}
                                </h2>
                                <span class="check border-teal-500 !absolute !ml-0 left-2 bottom-2"></span>

                            </label>
                        </div>
                    @endforeach
                </div>



                @component('component.btn.btn',['color'=>'rose' , 'id' => 'submitForm'])
                    @slot('title')
                        ارسال اطلاعات
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

{{--            <div class="input-group">--}}
{{--                <input type="text" id="image_label" class="form-control" name="image"--}}
{{--                       aria-label="Image" aria-describedby="button-image">--}}
{{--                <div class="input-group-append">--}}
{{--                    <button class="btn btn-outline-secondary" type="button" id="button-image">Select</button>--}}
{{--                </div>--}}
{{--            </div>--}}


        </div>


    </div>

@endsection

@section('footerScripts')

    @parent


    <script src="{{asset('assets/js/allert.js')}}"></script>


@endsection
