@extends('admin.master')
@php

    $prefix = 'admin.webAllert.';
    $name_en = 'webAllert';
    $name_fa = 'اعلان های ادمین';
    $name_fa_fard = 'اعلان';

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

            @include('admin.admin_allert.action')


            <div class="overflow-x-auto overflow-y-clip space-y-4">
                @foreach($list as $subject)
                    @component('component.allert.publicAllert',['type' => $subject->type,'closeBtn'=>true,'new'=>$subject->new])
                        @slot('content')
                            {!! clean($subject->content) !!}
                        @endslot
                        @slot('old')
                            {{persianDateOld($subject->created_at)}}
                        @endslot
                            @slot('deleteAction')
                                onclick="AdminAllertDelete(this,{{$subject->id}})"
                            @endslot
                    @endcomponent
                        @php
                            if ($subject->new){
                                $subject->update(['new'=>false]);
                            }
                        @endphp
                @endforeach


            </div>
            @if(!$list->first())

                @component('component.divider.divider',[])
                    @slot('title')
                        {{$name_fa_fard}}ی موجود نیست
                    @endslot
                @endcomponent
            @endif

            @include('admin.components.pagination')


        </div>


    </div>

@endsection

@section('footerScripts')

    @parent
    <script src="{{asset('assets/js/plugins/popper/popper.js')}}"></script>
    <script src="{{asset('assets/js/dropdown.js')}}"></script>


@endsection
