<!doctype html>

<html id="html" lang="fa" dir="rtl" class="">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{asset('assets/img/favicon.png')}}">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="apple-mobile-web-app-capable" content="yes">

    <meta name="theme-color" content="{{findInOption('theme-color')}}">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="canonical" href="{{request()->url()}}">
    <meta name="robots" content="NOINDEX,NOFOLLOW">
    <script src="{{asset('assets/js/darkTop.js')}}"></script>
    <link rel="stylesheet" href="{{asset('app/final.css')}}"/>
    <title>کد اعتبار سنجی</title>

</head>
<body class="font-YekanBakh bg-slate-100 text-slate-700">


    <div class="w-full text-slate-700 pt-[20vh] px-3 ">

        <div class="logo m-auto text-center p-5 ">
            @include('component.logo.logo',['size'=>'img-4xl'])

        </div>

        <div class="bg-white shadow-2xl shadow-blue-300/40 dark:shadow-blue-600/50 p-4 max-w-xl m-auto rounded-2xl dark:bg-slate-900">

            <form action="{{route('auth.verifyCode')}}" class="cardContent p-4 md:p-2 space-y-4 md:space-y-2 text-center" method="post">
                @csrf
                @method('POST')
                <h2 class="text-smid font-semibold text-slate-400">کد ورودی که برایتان ارسال شده وارد کنید</h2>






                <div class="wraper px-4 mt-2 ">
                    <input class="form-input text-lg w-full text-center" type="tel" name="verifyCode">
                </div>
                <p class="text-sm font-light text-slate-400 mr-4 px-4">
                    <strong class="font-bold text-rose-500 text-smid">نکته:</strong>اگر کدی برای شما ارسال نشد 2 دقیقه دیگر امتحان کنید
                </p>
                @if($errors)
                    @foreach ($errors->all() as $error)
                        <div class="allert group text-rose-500 bg-rose-500/10 hover:bg-rose-500/100 inline-block rounded-md border-rose-500 focus:bg-rose-600 focus:border-rose-600 focus:ring-2 focus:ring-rose-600 focus:ring-offset-2 focus:text-slate-50 hover:text-slate-50">
                            <div class="content">
                                <p>
                                <span class="icon ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="inline-block">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"></path>
                                </svg>
                                </span>
                                    {{$error}}
                                </p>
                            </div>
                            <div class="close bg-rose-200/70 dark:bg-rose-200/20 group-hover:bg-slate-100/20 cursor-pointer p-1 rounded-md dark:text-slate-50">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>

                            </div>
                        </div>
                    @endforeach
                @endif
                <button class="btn lg shadow-md shadow-blue-200 dark:shadow-blue-500/60 hover:shadow-lg hover:shadow-blue-200 dark:hover:shadow-blue-700 bg-blue-500 text-slate-50 hover:bg-blue-400 inline-block rounded-md focus:shadow-none focus:bg-blue-600 focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" >
                        <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                    </svg>


                    <p class="inline">
                        ارسال

                    </p>
                </button>

            </form>

        </div>

    </div>


</body>

<script src="{{asset('assets/js/allert.js')}}">

</script>
</html>
