@extends('admin.master')
@php

    $subject = isset($plan) ? $plan : null;
    $update = ['project' => $project];
    $action = 'store';
        $prefix = 'admin.plan.';
        $name_en = 'plan';
        $name_fa = 'پلن قیمت ها';
        $name_fa_fard = 'پلن قیمت';

        $selected_possibles = collect([]);

        if ($subject){
        $update[$name_en] = $subject->id;
        $action = 'update';
        $selected_possibles =  $plan->possible()->get(['id']);
    }
        $possibles =  \App\Models\Project::query()->find($project,['id'])->possible()->orderBy('sort')->get();
@endphp
@section('cssScripts')


    <link rel="stylesheet" href="{{asset('assets/css/cropper/cropper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/editorjs/editorjs.css')}}"/>
    @parent



@endsection

@if($action == 'store')
    @section('title',"اضافه کردن $name_fa_fard")
@elseif($action == 'update')

    @section('title',"ویرایش $name_fa_fard ($subject->name)")
@endif

@section('content')

    <div id="content" class="mini w-full pt-16 text-slate-700 pb-6">

        <div id="contentWraper" class="w-11/12 mx-auto mt-16 lg:w-96p sm:w-full space-y-6">
            <h2 class="font-bold text-felg mr-6 mb-2 md:mr-3">
                @if($action == 'store')
                    اضافه کردن {{$name_fa_fard}}
                @elseif($action == 'update')
                    ویرایش {{$name_fa_fard}} ({{$subject->name}})
                @endif
            </h2>


            <form id="addTag"  action="{{route("$prefix$action",$update)}}"
                  class="space-y-3 space-y-reverse card_c p-4 px-6" method="POST">
                @csrf
                @if($action == 'store')
                    @method('POST')
                @elseif($action == 'update')
                    @method('PUT')
                @endif


                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">نام</h2>
                    <input class="form-input text-smid w-full" name="name" type="text"
                           value="{{old('name',$subject ? $subject->name : null)}}" placeholder="نام">
                </div>
                @error('name')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror

                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">قیمت(تومان)</h2>
                    <input class="price_input form-input text-smid w-full" name="price" type="text"
                           value="{{old('price',$subject ? $subject->price : null)}}" placeholder="قیمت">
                </div>
                @error('price')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">زمان پروژه(به صورت ماه)</h2>
                    <input class="form-input text-smid w-full" name="time" type="number"
                           value="{{old('time',$subject ? $subject->time : null)}}" placeholder="زمان پروژه">
                </div>
                @error('time')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror





                <div class="switchWraper">
                    <input type="checkbox" id="itemsugg" hidden="" @if(old('suggest') === 'on' or $subject ? $subject->suggest : false) checked @endif @if(!$subject) checked @endif name="suggest">

                    @component('component.switch.switchLable',['shape'=> 'square','for' => 'itemsugg'])
                        @slot('title')
                            پیشنهاد شود
                        @endslot
                    @endcomponent
                </div>

                <div class="switchWraper">
                    <input type="checkbox" id="iteminfin" hidden="" @if(old('infinity') === 'on' or $subject ? $subject->infinity : false) checked @endif @if(!$subject) checked @endif name="infinity">

                    @component('component.switch.switchLable',['shape'=> 'square','for' => 'iteminfin'])
                        @slot('title')
                            مادام العمر
                        @endslot
                    @endcomponent
                </div>

                <div class="switchWraper">
                    <input type="checkbox" id="item3" hidden="" @if(old('active') === 'on' or $subject ? $subject->active : false) checked @endif @if(!$subject) checked @endif name="active">

                    @component('component.switch.switchLable',['shape'=> 'square','for' => 'item3'])
                        @slot('title')
                            فعال
                        @endslot
                    @endcomponent
                </div>


                @component('component.divider.divider',['title'=> 'امکان های این پلن'])
                @endcomponent

                <div class="flex flex-wrap gap-3 !mt-10 !mb-6">
                    @foreach($possibles as $possible)
                        <div class="checkboxWraper img p-0">

                            <input id="possible{{$possible->id}}" @if($selected_possibles->where('id',$possible->id)->first()) checked @endif type="checkbox" name="possible_ids[]" value="{{$possible->id}}">
                            <label for="possible{{$possible->id}}" class="card_c box !flex items-center">

                                <h2 class="title text-sm ml-6 font-semibold text-center">
                                    {{$possible->name}}
                                </h2>
                                <span class="check border-teal-500 !absolute !ml-0 left-2 bottom-2"></span>

                            </label>
                        </div>
                    @endforeach
                </div>

                @component('component.btn.btnD',['color'=>'rose' , 'id' => 'submitForm'])
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




    <script>




        window.addEventListener('DOMContentLoaded',function () {



            document.querySelector('#submitForm').addEventListener('click',function (ev) {
                ev.preventDefault()


                document.querySelector('#addTag').submit()




            })

        })



    </script>


    <script src="{{asset('assets/js/allert.js')}}"></script>
    @include('component.cdn.autosize')

    <script src="{{asset('assets/js/plugins/cleave/cleave.js')}}"></script>

    <script>
        var cleave = new Cleave('.price_input', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });
    </script>



@endsection
