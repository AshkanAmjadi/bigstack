<!doctype html>
<html id="html" lang="fa" dir="ltr" class="overflow-x-hidden overflow-y-auto">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{logoSrcMaker('favicon')}}">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
{{--    <link rel="shortcut icon" href="{{asset('altImage/1.jpg')}}">--}}
    <meta name="mobile-web-app-capable" content="yes">
    {{--    <link rel="manifest" href="/manifest.json">--}}
    <meta name="theme-color" content="{{findInOption('theme_color')}}">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="email" content="{{findInOption('email')}}">
    <meta name="author" content="{{findInOption('site_name')}}">
    <meta name="copyright" content="{{findInOption('site_name')}}">
    <meta name="generator" content="{{findInOption('site_generator')}}">
    <meta property="business:contact_data:email" content="{{findInOption('email')}}">
    <meta property="business:contact_data:phone_number" content="{{findInOption('webPhone')}}">
    <meta property="business:contact_data:website" content="{{route('home')}}">

    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}

    @stack('schema')


    @section('cssScripts')
        @livewireStyles
        <script src="{{asset('assets/js/darkTop.js')}}"></script>
        @include('component.cdn.swal2css')

        {{--        @vite('resources/css/app.css')--}}
        <link rel="stylesheet" href="{{asset('app/final.css')}}"/>

    @show
    @stack('cssStyles')
    @livewireScripts
</head>
<body class="text-slate-700 overflow-x-hidden">
{{--<div id="wbAllerts" class="fixed top-0 right-0 w-full h-20 z-[70] p-5" >--}}

{{--    <div class="card_c border border-rose-500">--}}

{{--    </div>--}}

{{--</div>--}}
{{--{{session()->getId()}}--}}
{{--{{session('login_id')}}--}}
{{--{{request()->user()->current_login}}--}}


@include('front.temp.headers.'.findInOption('header').'.header')


<main>
    @yield('content')
</main>

@include('front.temp.footers.'.findInOption('footer').'.footer')



@include('component.loading.webPreLoader')

@include('front.temp.headers.'.findInOption('header').'.search')

@include('component.cdn.swal2')

@include('sweetalert::alert')
@section('footerScripts')
    <script src="{{asset('assets/js/front.js')}}"></script>
    <script src="{{asset('assets/js/default.js')}}"></script>
    @include('component.cdn.jquery')
    <script>
        Livewire.on('toast', ({ title , type }) => {
            swaltoast(title,type)
        })
        Livewire.on('toTitle', ({ el }) => {

            setTimeout(function () {
                document.querySelector(`#${el}`).scrollIntoView();
            },300)

        });
        Livewire.on('click', ({ el }) => {

            setTimeout(function () {
                document.querySelector(el).click();
            },300)

        });
        //preloader
        $(document).ready(function(){
            $("#preloader").addClass('hidden');
            window.scrollY = 0;
        })
    </script>
    <script>

    @if($errors->all())

        Swal.fire({
        position: 'bottom-start',
        icon: 'error',
        toast: true,
        timerProgressBar: true,
        html: `@foreach ($errors->all() as $error)
            <p>
                {{$error}}
            </p>

        @endforeach`,
        showConfirmButton: false,
        timer: 5000,
        customClass: {
        popup: 'colored-toast'
        }
        })


    @endif
    </script>

    <script>

        @if(app('web_allerts')->get('forview')->first())


            let webAllerts = {!! json_encode(app('web_allerts')->get('forview')->toArray(),JSON_FORCE_OBJECT) !!};

            let notshowed = []

        Object.keys(webAllerts).forEach(key => {
            if (!localStorage.getItem(key+'showed')){
                localStorage.setItem(key,webAllerts[key])
                localStorage.setItem(key+'showed','no')
            }else {
                if (localStorage.getItem(key+'showed') == 'no'){

                    notshowed.push(key)

                }else if(localStorage.getItem(key+'showed') == 'yes'){
                    localStorage.removeItem(key)
                }
            }
        });

            setTimeout(function () {

            },3000)
        @endif



    </script>


@show


</body>



</html>
