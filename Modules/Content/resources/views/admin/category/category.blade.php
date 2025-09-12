@extends('admin.master')
@php

    $prefix = 'admin.category.';
    $name_en = 'category';
    $name_fa = 'دسته بندی'
@endphp
@section('cssScripts')

    <link rel="stylesheet" href="{{asset('assets/css/cropper/cropper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/select2/select2.css')}}"/>
    @parent

@endsection

@section('title',"$name_fa ها")

@section('content')

    <div id="content" class="mini w-full pt-16 text-slate-700 pb-6">

        <div id="contentWraper" class="w-11/12 mx-auto mt-16 lg:w-96p sm:w-full space-y-6">
            <h2 class="font-bold text-felg mr-6 mb-2 md:mr-3">
                دسته بندی ها
            </h2>

            @include('content::admin.category.action')

            @livewire('content::admin.category.cat-list',['parent' => 0],key('category'))

        </div>



    </div>




    @include('content::admin.category.createModal')

@endsection

@section('footerScripts')

    @parent



    <script>
        Livewire.on('cat-deleted', (event) => {
            document.querySelector(`#cat${event.id}head`).remove()
        });
    </script>

    <script src="{{asset('assets/js/modal.js')}}"></script>
    <script src="{{asset('assets/js/allert.js')}}"></script>
    @include('component.cdn.autosize')

    <script src="{{asset('assets/js/plugins/cropper/cropper.js')}}"></script>
    <script src="{{asset('assets/js/plugins/cropper/myCropper.js')}}"></script>
    @include('component.cdn.select2')

    <script src="{{asset('assets/js/plugins/popper/popper.js')}}"></script>
    <script src="{{asset('assets/js/dropdown.js')}}"></script>

    <script>

        Livewire.on('setDropDown',(event)=>{
            setTimeout(function () {
                setDropdown()

            },300)
        })

        Livewire.on('updatedDOM',(event)=>{
            setTimeout(function () {
                setTextArea()

            },300)


        })

        function createFormData($event) {
            $formData = new FormData($event)
            return $formData
        }

        function editButton(El, id) {

            El.parentNode.parentNode.querySelector('.formContent').classList.toggle('hidden')

        }




        function craeteTagSelect(element) {


            document.querySelectorAll(element).forEach(function (El,index,parent) {
                $(`#${El.id}`).select2({
                    placeholder: "جستو جو ...",
                    tags: true,
                    closeOnSelect: false,
                    dir: 'rtl'
                })
            })

        }

        // setTimeout(function () {
        //     craeteTagSelect('.keyword')
        //
        //
        // },300)


    </script>

@endsection
