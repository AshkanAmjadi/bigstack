@extends('front.temp.master')

@push('schema')
{{--    <script type="application/ld+json">--}}
{{--        {!! clean($page->schema) !!}--}}
{{--    </script>--}}
@endpush

@section('cssScripts')

    @parent

@endsection


@section('content')

    <div class="mainArticle mb-10 mt-7">

{{--        <h1 class=" w-full text-center font-extrabold text-extr underline decoration-blue-500 decoration-8 underline-offset-[20px] mb-5">--}}
{{--            {{$user->username.'@'}}--}}
{{--        </h1>--}}

        <div class="w-3/4 m-auto p-6 card_c 2xl:w-5/6 xl:w-11/12 lg:w-full lg:p-4">

            <div class="card_c overflow-hidden">
                <img class="w-full" src="{{$user->top_img ? imgUrlMaker2($user,'top_img') : logoSrcMaker('user_top_image_default')}}" alt="">

            </div>

            <div class="flex flex-wrap mt-8 gap-4 sm:justify-center sm:mt-4">
                <div class="avatar 6xl  mr-10 -mt-28 md:!w-24 md:!h-24 md:-mt-16 md:mr-8 sm:m-0">
                    <img class="pointer-events-none w-full"
                         src="{{$user->avatar ? imgUrlMaker2($user,'avatar') : asset('assets/img/default.png')}}"
                         alt="avatar">

                </div>
                <div class="flex flex-col sm:justify-center gap-2 pr-3 sm:pr-0">
                    <p class="font-bold text-extr sm:text-center">
                        {{$user->name}}
                    </p>
                    <div class="flex items-center">
                        <p class="text-smid font-light opacity-75 mr-2">
                            {{$user->username.'@'}}
                        </p>
                        <div class="h-5 border-r border-slate-300 mx-4">
                        </div>
                        <p class="text-smid font-light opacity-75 mr-2">
                            joined {{persianDateOld($user->created_at)}}
                        </p>
                    </div>
                </div>

            </div>


        </div>
        <div class="w-3/4 m-auto 2xl:w-5/6 xl:w-11/12 lg:w-full mt-5">
            @livewire('user::profile.profile',['username' => $user->username])

        </div>


    </div>

@endsection


@section('footerScripts')

    @parent


@endsection
