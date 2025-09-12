@extends('admin.master')
@php

    $prefix = 'admin.slider.';
    $name_en = 'slider';
    $name_fa = 'اسلایدر ها';
    $name_fa_fard = 'اسلایدر';

@endphp
@section('cssScripts')

    @parent

@endsection

@section('title',$name_fa)

@section('content')

    <div id="content" class="mini w-full pt-16 text-slate-700 pb-6 overflow-x-clip">

        <div id="contentWraper" class="w-11/12 mx-auto mt-16 lg:w-96p sm:w-full space-y-6">
            <h2 class="font-bold text-felg mr-6 mb-2 md:mr-3">
                {{$name_fa}}
            </h2>

            @if($type)
                @include("content::admin.$name_en.action")
            @endif

            <div id="sort" class=" space-y-3">

                @if(!$type)
                    <div class="grid grid-cols-3 lg:grid-cols-2 md:grid-cols-1 gap-5">


                        @foreach($list as $type => $name)

                            <a href="{{route('admin.slider.index',['type'=>$type])}}" class="card_c p-5 pb-10 text-extr font-bold text-center">
                                <div class="icon inline handler icon-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path fill="currentColor" fill-rule="evenodd"
                                              d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2s7.071 0 8.535 1.464C22 4.93 22 7.286 22 12s0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12m12-4.25a.75.75 0 0 1 0-1.5h3a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0V8.81l-2.22 2.22a.75.75 0 1 1-1.06-1.06l2.22-2.22zm-2.97 5.22a.75.75 0 0 1 0 1.06l-2.22 2.22H10a.75.75 0 0 1 0 1.5H7a.75.75 0 0 1-.75-.75v-3a.75.75 0 0 1 1.5 0v1.19l2.22-2.22a.75.75 0 0 1 1.06 0M10.75 7a.75.75 0 0 1-.75.75H8.81l2.22 2.22a.75.75 0 1 1-1.06 1.06L7.75 8.81V10a.75.75 0 0 1-1.5 0V7A.75.75 0 0 1 7 6.25h3a.75.75 0 0 1 .75.75m2.22 7.03a.75.75 0 1 1 1.06-1.06l2.22 2.22V14a.75.75 0 0 1 1.5 0v3a.75.75 0 0 1-.75.75h-3a.75.75 0 0 1 0-1.5h1.19z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <p class="w-full">
                                    {{$name}}
                                </p>
                            </a>

                        @endforeach
                    </div>

                @else
                    @forelse($list as $subject)

                        <div data-listId="{{$subject->id}}" class="sortItem card_c p-3">

                            <div class="flex items-center justify-between gap-2 flex-wrap" style="">

                                <div class="flex text-smid flex-wrap lg:gap-5 items-center">

                                    {{--                    todo pisfarz icon option--}}
                                    <div class="icon  handler p-1 ">
                                        <svg class="icon-md" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                            <path fill="currentColor" fill-rule="evenodd"
                                                  d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2s7.071 0 8.535 1.464C22 4.93 22 7.286 22 12s0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12m12-4.25a.75.75 0 0 1 0-1.5h3a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0V8.81l-2.22 2.22a.75.75 0 1 1-1.06-1.06l2.22-2.22zm-2.97 5.22a.75.75 0 0 1 0 1.06l-2.22 2.22H10a.75.75 0 0 1 0 1.5H7a.75.75 0 0 1-.75-.75v-3a.75.75 0 0 1 1.5 0v1.19l2.22-2.22a.75.75 0 0 1 1.06 0M10.75 7a.75.75 0 0 1-.75.75H8.81l2.22 2.22a.75.75 0 1 1-1.06 1.06L7.75 8.81V10a.75.75 0 0 1-1.5 0V7A.75.75 0 0 1 7 6.25h3a.75.75 0 0 1 .75.75m2.22 7.03a.75.75 0 1 1 1.06-1.06l2.22 2.22V14a.75.75 0 0 1 1.5 0v3a.75.75 0 0 1-.75.75h-3a.75.75 0 0 1 0-1.5h1.19z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </div>

                                    <p>
                                        {{$subject->name}}

                                    </p>


                                </div>

                                <div class="left flex gap-2">

                                    @component('component.btn.linkBtn')
                                        @slot('href')
                                            {{route($prefix.'edit',[$name_en=>$subject->id,'type' => $type])}}
                                        @endslot
                                        @slot('title')
                                            ویرایش
                                        @endslot
                                        @slot('icon')
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                            </svg>
                                        @endslot
                                    @endcomponent


                                    <form class="delete"
                                          action="{{ route($prefix.'destroy',[$name_en=>$subject->id]) }}"
                                          method="post">
                                        @csrf
                                        @method('DELETE')
                                        @component('component.btn.btnD',['color'=>'red','tabindex' => true])
                                            @slot('title')
                                                حذف
                                            @endslot
                                            @slot('icon')
                                                <svg class="fill-white" xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px"
                                                     y="0px" viewBox="0 0 100 125">
                                                    <path class="st0"
                                                          d="M20.002,29.232l62.515-0.02l0.007,0.007l-0.046-6.28l-65.014,0.06l0.06,6.234H20.002L20.002,29.232z   M83.46,36.085v44.379c0,8.001-6.533,14.534-14.534,14.534H31.074c-8.001,0-14.534-6.533-14.534-14.534V36.085  c-3.411-0.484-6-3.441-6-6.913v-6.174c0-3.848,3.134-6.982,6.982-6.982h18.217c0-3.393-0.375-6.115,2.262-8.752  c1.396-1.396,3.325-2.262,5.449-2.262h13.1c4.231,0,7.71,3.479,7.71,7.71v3.304h18.217c3.848,0,6.982,3.134,6.982,6.982v6.174  c0,1.921-0.787,3.659-2.055,4.927l0.007,0.007C86.367,35.151,84.992,35.868,83.46,36.085L83.46,36.085z M42.662,16.016h14.676  c0-2.151,0.407-4.092-0.788-4.092h-13.1C42.255,11.925,42.662,13.942,42.662,16.016L42.662,16.016z M76.537,36.155H23.463v44.309  c0,4.179,3.432,7.611,7.611,7.611h37.851c4.179,0,7.612-3.433,7.612-7.611V36.155z"/>
                                                </svg>
                                            @endslot
                                            @component('component.dropdown.dropdown',['title' => 'توجه!!'])
                                                @slot('text')
                                                    از حذف کردن این {{$name_fa_fard}} مطمئن هستید؟
                                                @endslot
                                                @slot('btns')

                                                    @component('component.btn.btnD',['title' => 'حذف' , 'color' => 'rose' ,'size' => 'sm','id'=>'Delete'.$subject->id,'shadow'=>false])
                                                        @slot('action')
                                                            onclick="this.closest('.delete').submit()"
                                                        @endslot
                                                        @slot('icon')
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                 height="24"
                                                                 viewBox="2 2 22 22">
                                                                <g fill="currentColor">
                                                                    <path
                                                                        d="M3 6.386c0-.484.345-.877.771-.877h2.665c.529-.016.996-.399 1.176-.965l.03-.1l.115-.391c.07-.24.131-.45.217-.637c.338-.739.964-1.252 1.687-1.383c.184-.033.378-.033.6-.033h3.478c.223 0 .417 0 .6.033c.723.131 1.35.644 1.687 1.383c.086.187.147.396.218.637l.114.391l.03.1c.18.566.74.95 1.27.965h2.57c.427 0 .772.393.772.877s-.345.877-.771.877H3.77c-.425 0-.77-.393-.77-.877Z"/>
                                                                    <path fill-rule="evenodd"
                                                                          d="M9.425 11.482c.413-.044.78.273.821.707l.5 5.263c.041.433-.26.82-.671.864c-.412.043-.78-.273-.821-.707l-.5-5.263c-.041-.434.26-.821.671-.864Zm5.15 0c.412.043.713.43.671.864l-.5 5.263c-.04.434-.408.75-.82.707c-.413-.044-.713-.43-.672-.864l.5-5.264c.041-.433.409-.75.82-.707Z"
                                                                          clip-rule="evenodd"/>
                                                                    <path
                                                                        d="M11.596 22h.808c2.783 0 4.174 0 5.08-.886c.904-.886.996-2.339 1.181-5.245l.267-4.188c.1-1.577.15-2.366-.303-2.865c-.454-.5-1.22-.5-2.753-.5H8.124c-1.533 0-2.3 0-2.753.5c-.454.5-.404 1.288-.303 2.865l.267 4.188c.185 2.906.277 4.36 1.182 5.245c.905.886 2.296.886 5.079.886Z"
                                                                        opacity=".5"/>
                                                                </g>
                                                            </svg>
                                                        @endslot

                                                    @endcomponent

                                                @endslot
                                            @endcomponent
                                        @endcomponent

                                    </form>

                                </div>


                            </div>


                        </div>

                    @empty

                        <div class="divider relative ">
                            <div class="title absolute w-full text-sm font-medium justify-center flex -top-2">
                                <p class="bg-slate-100 text-slate-400 px-2">آیتمی وجود ندارد</p>
                            </div>
                        </div>

                    @endforelse


                    <form id="sortForm" action="{{ route($prefix.'setsort',['type' => $type]) }}"
                          class="card-body" method="POST">
                        @csrf
                        @method('POST')

                        <input id="sortInputList" type="hidden" name="sort" value="">
                    </form>
                @endif


            </div>


        </div>


    </div>

@endsection

@section('footerScripts')

    @parent


    <script src="{{asset('assets/js/plugins/popper/popper.js')}}"></script>
    <script src="{{asset('assets/js/dropdown.js')}}"></script>

    @if($type)
        <script src="{{asset('assets/js/plugins/sortable/sortable.js')}}"></script>

        <script>
            new Sortable(document.getElementById('sort'), {
                group: {
                    name: 'shared1',
                },
                handle: '.handler', // handle's class

                animation: 200
            });

            function submitSort() {

                let sort = [];

                document.getElementById('sort').querySelectorAll('.sortItem').forEach(function (El) {

                    sort.push(El.getAttribute('data-listId'))

                })

                console.log(sort)
                document.getElementById('sortInputList').value = sort;
                document.getElementById('sortForm').submit();


            }


        </script>
    @endif

@endsection
