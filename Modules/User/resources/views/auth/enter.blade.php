<!doctype html>

<html id="html" lang="fa" dir="ltr" class="">

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
    <title>Join Us</title>
</head>
<body class="font-YekanBakh bg-slate-100 text-slate-700">


<div class="w-full text-slate-700 px-3 ">

    <div class="logo m-auto text-center p-5 ">
        @include('component.logo.logo',['size'=>'img-4xl'])

    </div>
    <div class="bg-white shadow-2xl shadow-blue-300/40 dark:shadow-blue-600/50 p-4 max-w-xl m-auto rounded-2xl dark:bg-slate-900">

        <form action="{{route('auth.login')}}" class="cardContent p-4 md:p-2 space-y-4 md:space-y-2 text-center" method="post">
            @csrf
            @method('POST')
            <h2 class="font-bold text-felg">Hi bro 👋</h2>
            <h2 class="text-sm font-semibold text-slate-400">Google</h2>



            <div class="">
                <a href="{{route('auth.google')}}" class="btn px-14 shadow-md shadow-rose-200 dark:shadow-rose-500/60 hover:shadow-lg hover:shadow-rose-200 dark:hover:shadow-rose-700 bg-rose-500 text-slate-50 hover:bg-rose-400 inline-block rounded-md focus:shadow-none focus:bg-rose-600 focus:ring-2 focus:ring-rose-600 focus:ring-offset-2">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="800px" height="800px" viewBox="0 0 24 24"><path d="m14.969 11.814c.001.043.001.095.001.146 0 1.357-.336 2.635-.929 3.757l.021-.044c-.6 1.121-1.481 2.023-2.55 2.632l-.032.017c-1.066.6-2.34.953-3.696.953-.052 0-.104-.001-.155-.002h.008c-.006 0-.014 0-.022 0-1.065 0-2.078-.222-2.995-.623l.048.019c-1.848-.775-3.288-2.215-4.044-4.013l-.018-.049c-.382-.876-.604-1.896-.604-2.969s.222-2.093.623-3.018l-.019.049c.775-1.848 2.215-3.288 4.013-4.044l.049-.018c.87-.383 1.884-.606 2.951-.606h.018-.001c.037-.001.081-.001.125-.001 1.937 0 3.695.762 4.992 2.004l-.003-.003-2.073 1.99c-.755-.73-1.785-1.179-2.92-1.179-.042 0-.084.001-.126.002h.006c-.009 0-.02 0-.031 0-.864 0-1.671.24-2.36.657l.02-.011c-1.429.865-2.37 2.411-2.37 4.177s.941 3.312 2.348 4.165l.022.012c.668.406 1.476.646 2.339.646h.033-.002.052c.549 0 1.077-.088 1.572-.25l-.036.01c.455-.143.852-.347 1.204-.607l-.011.008c.31-.238.579-.507.81-.807l.008-.01c.198-.25.369-.535.5-.841l.009-.024c.093-.22.17-.478.22-.746l.004-.024h-4.334v-2.625h7.208c.078.382.124.821.126 1.27v.002zm9.031-1.273v2.189h-2.177v2.177h-2.189v-2.177h-2.174v-2.189h2.177v-2.177h2.189v2.177z"/></svg>
                    </div>
                    <p class="inline">
                        Google
                    </p>
                </a>
            </div>

            @if(getOption('phone_auth')->value)
                <div class="divider-1 relative !my-8 ">
                    <div class="title absolute w-full text-sm font-medium justify-center flex -top-2">
                        <p class="bg-slate-50 dark:bg-slate-900 text-slate-400 px-2">Phone</p>
                    </div>
                </div>

                <div class="wraper px-4 mt-2 ">
                    <input id="phone" name="phone" value="{{old('phone')}}" class="form-input text-lg w-full text-center" type="tel">
                </div>

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
                        <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 013-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 01-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 006.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 011.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 01-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5z" clip-rule="evenodd" />
                    </svg>

                    <p class="inline">
                        Send Phone

                    </p>
                </button>
            @endif


            <p class="text-slate-400 px-3 md:p-5 text-smid font-medium">
                By registering on our website, you agree to the terms and conditions of using our services.
            </p>
        </form>

    </div>

</div>

</body>

<script src="{{asset('assets/js/allert.js')}}">

</script>

</html>
