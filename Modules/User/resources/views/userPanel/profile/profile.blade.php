@php($user =auth()->user())
@php($phone =$user->mainPhone()->first())
@php(
    $birth = $user && $user->year && $user->day && $user->month ? "$user->year-$user->month-$user->day" : ''
    )

@extends('user::userPanel.master')

@section('cssScripts')

    @include('component.cdn.jalalicss')
    @include('component.cdn.flatpickerCss')

    <link rel="stylesheet" href="{{asset('assets/css/cropper/cropper.css')}}"/>
    @parent

@endsection
@section('title',"Profile")

{{--todo compelete the web options--}}
@section('content')

    <div id="content" class="mini w-full pt-16 text-slate-700 pb-6">

        <div id="contentWraper" class="w-11/12 mx-auto mt-10 lg:w-96p sm:w-full space-y-6">
            <h2 class="font-bold text-felg mr-6 mb-2 md:mr-3">
                Profile
            </h2>

            @livewire('user::profile.avatar')
            <div class="wraper flexCC flex-col">
                @include('user::admin.component.ProfileCropImage',['title' => "profile image",'name' => 'avatar','id'=>'avatar','size'=>1/1,'subject' =>$user])
            </div>


            <div class="card_c p-4">

                <form id="UsernameForm" class="">

                    @livewire('user::profile.username')
                </form>

            </div>
            <div class="card_c p-4">

                <form id="ProfileForm" class="grid  grid-cols-2 gap-4 md:gap-8">

                    <div class="wraper md:col-span-2">
                        <div class="flex items-center flex-row-reverse gap-3">
                            <h2 class="text-sm mr-4 font-semibold">your full name</h2>
                            <p class="text-sm font-bold text-red-600">(Required)</p>
                        </div>

                        <input class="form-input2 text-smid w-full" name="name" type="text"
                               value="{{$user->name}}" placeholder="Fullname" dir="ltr">
                    </div>
                    <div class="wraper md:col-span-2 @if($user->by_google) opacity-75 @endif">
                        <h2 class="text-sm mr-4 text-red-600 font-semibold" dir="ltr">Email @if($user->email_verify)
                                (Change email is not possible)
                            @endif</h2>
                        <input class="form-input2 text-smid w-full" name="email" dir="ltr" type="email"
                               value="{{$user->email}}" placeholder="Your Email" @if($user->email_verify) disabled @endif>
                    </div>
{{--                    <div class="wraper md:col-span-2">--}}
{{--                        <h2 class="text-sm mr-4 font-semibold">کد ملی</h2>--}}
{{--                        <input class="form-input2 text-smid w-full" dir="ltr" name="melicode" type="text"--}}
{{--                               value="{{$user->melicode}}" placeholder="کد ملی">--}}
{{--                    </div>--}}
                    <div class="wraper md:col-span-2">
                        <div class="flex items-center flex-row-reverse gap-3">
                            <h2 class="text-sm mr-4 font-semibold">birthday</h2>
                            <p class="text-sm font-bold text-red-600">(Required)</p>
                        </div>
                        <input class="form-input2 text-smid w-full" dir="ltr" name="birth" type="text"
                               value="{{$birth}}" placeholder="Ypure birthday"
{{--                               data-jdp="" data-jdp-only-date="" for iranian date--}}
                        >
                    </div>
{{--                    <div class="wraper md:col-span-2">--}}
{{--                        <h2 class="text-sm mr-4 font-semibold">آیدی اینستاگرام(اختیاری)</h2>--}}
{{--                        <input class="form-input2 text-smid w-full" name="insta_id" type="text"--}}
{{--                               value="{{$user->insta_id}}" placeholder="آیدی اینستاگرام">--}}
{{--                    </div>--}}
                    <div class="wraper md:col-span-2">
                        <div class="flex items-center flex-row-reverse gap-3">
                            <h2 class="text-sm mr-4 font-semibold">Gender</h2>
                            <p class="text-sm font-bold text-red-600">(Required)</p>
                        </div>


                        @include('user::admin.component.genderSelect',['subject' => $user])
                    </div>
                    <div class="wraper col-span-2">
                        <h2 class="text-sm mr-4 font-semibold text-left">About</h2>
                        <textarea class="autosizeArea form-input2 text-smid w-full" dir="ltr" rows="1" name="about_me"
                                  type="text" placeholder="Short description..">{{$user->about_me}}</textarea>
                    </div>
                    @livewire('user::profile.send-info')
                </form>

            </div>

            @if(getOption('phone_auth')->value)

                <h2 class="font-bold text-felg mr-6 mb-2 md:mr-3">
                    Change phone
                </h2>

                <div class="card_c p-4 !mb-20">

                    <div class="grid grid-cols-2 gap-4 md:gap-8">


                        <div class="wraper md:col-span-2">
                            <div class="mb-2">
                                @if(!$user->by_phone or !$user->MainPhone)
                                    @component('component.allert.allert', [
        'color' => 'blue',
        'title' => 'Register your mobile number to enable login via mobile for you',
        'closeBtn' => false
    ])
                                        @slot('mainIcon')
                                            @include('component.icon.phone')
                                        @endslot
                                    @endcomponent
                                @endif
                            </div>
                            <h2 class="text-sm mr-4 font-semibold">Current Mobile Number</h2>
                            <input class="form-input2 text-smid w-full" name="name" type="text"
                                   value="{{$user->MainPhone ? $user->MainPhone->phone: 'No Number'}}" disabled>
                        </div>
                        <div class="wraper md:col-span-2 none-show md:hidden">
                            <h2 class="text-sm mr-4 font-semibold">New Mobile Number</h2>
                            <input class="form-input2 text-smid w-full" name="name" type="text"
                                   value="" placeholder="Sample : 9999 999 0999">
                        </div>
                        @livewire('user::profile.phone')


                    </div>

                </div>
            @endif



        </div>


    </div>

@endsection

@section('footerScripts')

    @parent
{{--    @include('component.cdn.jalali')--}}
{{--    <script src="{{asset('assets/js/datepicker.js')}}"></script>--}}
    @include('component.cdn.flatpicker')
    <script>
        let brth = document.querySelector('input[name="birth"]')

        flatpickr(brth, {});
    </script>



    @include('component.cdn.cleavejs')
    @include('component.cdn.cropper')
    @include('component.cdn.autosize')
    <script src="{{asset('assets/js/plugins/cropper/profileCropper.js')}}"></script>
    <script src="{{asset('assets/js/allert.js')}}"></script>

    <script>
        var cleave7 = new Cleave('#phoneUser', {
            prefix: '09',
            blocks: [4, 3, 4],
        });


        function getProfileDataInfo() {

            let data = [];

            document.getElementById('ProfileForm').querySelectorAll('.form-input2').forEach(function (El, index) {
                data[El.getAttribute('name')] = El.value
            })
            console.log(Object.assign({}, data))

            return Object.assign({}, data);
        }


    </script>

@endsection
