<!doctype html>
<html id="html" lang="fa" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="robots" content="NOINDEX,NOFOLLOW">
    <link rel="shortcut icon" href="{{logoSrcMaker('favicon')}}">


    @section('cssScripts')
        @livewireStyles
        <script src="{{asset('assets/js/darkTop.js')}}"></script>
        @include('component.cdn.swal2css')
        <link rel="stylesheet" href="{{asset('app/final.css')}}"/>

    @show
    <title>@yield('title','dashboard')</title>
</head>
<body class="bg-slate-100 text-slate-700 font-medium">
@include('user::userPanel.temp.header')
@include('user::userPanel.temp.aside')

@yield('content')
<script>
    let asideExpend;

    if (localStorage.getItem('aside') !== 'expand'){
        document.getElementById('header').classList.add('mini');
        document.getElementById('content').classList.add('mini');
        document.getElementById('sideCursor').classList.remove('active');
        asideExpend = false

    }else {
        document.getElementById('header').classList.remove('mini');
        document.getElementById('content').classList.remove('mini');
        document.getElementById('aside').classList.remove('mini');
        document.getElementById('aside').classList.add('expanded');
        document.getElementById('sideCursor').classList.add('active');

        asideExpend = true

    }
</script>



{{--preloade--}}
@include('component.loading.webPreLoader')

@include('user::userPanel.temp.end')

{{--@dd(\Illuminate\Support\Facades\Session::all())--}}

@section('footerScripts')
    @livewireScripts
    @include('component.cdn.jquery')
    @include('component.cdn.swal2')
    @include('sweetalert::alert')
    <script src="{{asset('assets/js/userPanle.js')}}"></script>

    <script src="{{asset('assets/js/default.js')}}"></script>
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
        })
    </script>
    <script>



        @if($errors->all())


        Swal.fire({
            position: 'bottom-start',
            icon: 'error',
            toast: true,
            timerProgressBar: true,
            html: `@foreach($errors->all() as $error)<p>
                {{$error}}
                </p>@endforeach`,
            showConfirmButton: false,
            timer: 5000,
            customClass: {
                popup: 'colored-toast'
            }
        })

            @endif
    </script>

@show

<script>

</script>

</body>


</html>
