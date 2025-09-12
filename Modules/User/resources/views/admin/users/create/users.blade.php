@extends('admin.master')
@php

    $subject = isset($user) ? $user : null;

    $superuser = $subject ? $subject->superuser :false ;

    $staff = $subject ? $subject->staff :false;
    $boss = $subject ? $subject->boss :false;
    $is_user = !$superuser && !$boss && !$staff ? true :false ;

    $birth = $subject && $subject->year && $subject->day && $subject->month ? "$subject->year/$subject->month/$subject->day" : '';

    $update = [];
    $action = 'store';
        $prefix = 'admin.users.';
        $name_en = 'users';
        $name_fa = 'کاربر';

        if ($subject){
        $update['user'] = $subject->id;
        $action = 'update';
    }
@endphp
@section('cssScripts')

    <link rel="stylesheet" href="{{asset('assets/css/datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/cropper/cropper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/select2/select2.css')}}"/>
    @parent



@endsection

@if($action == 'store')
    @section('title',"اضافه کردن $name_fa")
@elseif($action == 'update')

    @section('title',"ویرایش $name_fa ($subject->name)")
@endif

@section('content')

    <div id="content" class="mini w-full pt-16 text-slate-700 pb-6">

        <div id="contentWraper" class="w-11/12 mx-auto mt-16 lg:w-96p sm:w-full space-y-6">
            <h2 class="font-bold text-felg mr-6 mb-2 md:mr-3">
                @if($action == 'store')
                    اضافه کردن {{$name_fa}}
                @elseif($action == 'update')
                    ویرایش {{$name_fa}} ({{$subject->name}})
                @endif
            </h2>


            <form id="addUser"  action="{{route("$prefix$action",$update)}}"
                  class="space-y-3 space-y-reverse card_c p-4 px-6" method="POST">
                @csrf
                @if($action == 'store')
                    @method('POST')
                @elseif($action == 'update')
                    @method('PUT')
                @endif


                <div class="wraper">
                    @include('admin.components.cropImage',['title' => "آواتار ( نمایه ) $name_fa",'name' => 'avatar','id'=>'avatar','size'=>1/1])

                </div>
                @error('avatar')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">نام</h2>
                    <input class="form-input text-smid w-full" name="name" type="text"
                           value="{{old('name',$subject ? $subject->name : null)}}" placeholder="نام کاربر">
                </div>
                @error('name')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">نام کاربری</h2>
                    <input class="form-input text-smid w-full" name="username" type="text"
                           value="{{old('username',$subject ? $subject->username : null)}}" placeholder="نام کاربری">
                </div>
                @error('username')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">ایمیل</h2>
                    <input class="form-input text-smid w-full" name="email" type="email"
                           value="{{old('email',$subject ? $subject->email : null)}}" placeholder="ایمیل کاربر">
                </div>
                @error('email')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="switchWraper p-2">
                    <input type="checkbox" id="email_verify" hidden=""
                           @if(old('email_verify') === 'on' or $subject ? $subject->email_verify : false) checked
                           @endif  name="email_verify">

                    @component('component.switch.switchLable',['shape'=> 'square','for' => 'email_verify'])
                        @slot('title')
                            آیا ایمیل معتبر است؟
                        @endslot
                    @endcomponent
                </div>
                @error('email_verify')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">شماره تماس</h2>
                    <input class="form-input text-smid w-full" name="phone" type="tel"
                           value="{{old('phone',$subject ? $subject->phone : null)}}" placeholder="شماره تماس کاربر">
                </div>
                @error('phone')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="switchWraper p-2">
                    <input type="checkbox" id="phone_verify" hidden=""
                           @if(old('hone_verify') === 'on' or $subject ? $subject->phone_verify : false) checked
                           @endif  name="phone_verify">

                    @component('component.switch.switchLable',['shape'=> 'square','for' => 'phone_verify'])
                        @slot('title')
                            آیا شماره تماس معتبر است؟
                        @endslot
                    @endcomponent
                </div>
                @error('phone_verify')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">کد ملی</h2>
                    <input class="form-input text-smid w-full" name="melicode" type="text"
                           value="{{old('melicode',$subject ? $subject->melicode : null)}}" placeholder="کد ملی کاربر">
                </div>
                @error('melicode')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror

                @if(!$superuser)
                    <div class="wraper">
                        <h2 class="text-sm mr-4 font-semibold">دسترسی عمومی کاربر</h2>


                        @include('admin.components.aclSelect')
                    </div>
                    @error('acl')
                    @component('component.allert.allert' )
                        @slot('title')
                            {{$message}}
                        @endslot
                    @endcomponent
                    @enderror
                @endif

                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">جنسیت</h2>


                    @include('user::admin.component.genderSelect')
                </div>
                @error('acl')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">تاریخ تولد</h2>

                    <input class="form-input text-smid w-full" type="text" name="birth" value="{{old('birth',$birth)}}" placeholder="لطفا یک تاریخ وارد نمایید" data-jdp="" data-jdp-only-date="">
                </div>
                @error('birth')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror


{{--todo active switch component--}}
{{--                <div class="switchWraper p-2">--}}
{{--                    <input type="checkbox" id="active" hidden="" @if(old('active') === 'on' or $subject ? $subject->active : false) checked @endif @if(!$subject) checked @endif name="active">--}}
{{--                    --}}
{{--                    @component('component.switch.switchLable',['shape'=> 'square','for' => 'active'])--}}
{{--                        @slot('title') فعال @endslot--}}
{{--                    @endcomponent--}}
{{--                </div>--}}



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




    <script src="{{asset('assets/js/plugins/datepicker/jalali.js')}}"></script>
    <script src="{{asset('assets/js/datepicker.js')}}"></script>
    <script src="{{asset('assets/js/allert.js')}}"></script>
    @include('component.cdn.autosize')

    <script src="{{asset('assets/js/plugins/cropper/cropper.js')}}"></script>
    <script src="{{asset('assets/js/plugins/cropper/myCropper.js')}}"></script>
    @include('component.cdn.select2')

    <script>





        $('#acl').select2({
            closeOnSelect: false,
            dir: 'rtl',

        })
        $('#gender').select2({
            closeOnSelect: false,
            dir: 'rtl',

        })


    </script>

@endsection
