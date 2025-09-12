@extends('admin.master')
@php

    $prefix = 'admin.list.';
    $name_en = 'list';
    $name_fa = 'فهرست';
    $name_fa_fard = 'فهرست'
@endphp
@section('cssScripts')

    <link rel="stylesheet" href="{{asset('assets/css/virtualselect.css')}}">
    @parent

@endsection

@section('title','فهرست ها')

@section('content')

    <div id="content" class="mini w-full pt-16 text-slate-700 pb-6">

        <div id="contentWraper" class="w-11/12 mx-auto mt-16 lg:w-96p sm:w-full space-y-6">
            <h2 class="font-bold text-felg mr-6 mb-2 md:mr-3">
                فهرست
                @if($parent)

                    :
                    فرزندان
                    ({{$parent->name}})

                @endif
            </h2>

            @include('admin.list.action')

            <div id="sort" class="lists space-y-3 ">


                @include('admin.list.listItems')


            </div>
        </div>


    </div>


    <form id="sortForm" action="{{ route($prefix.'setsort' , $parent_id) }}"
          class="card-body" method="POST">
        @csrf
        @method('POST')

        <input id="sortInputList" type="hidden" name="sort" value="">
    </form>

    @include('admin.list.createModal')

@endsection

@section('footerScripts')

    @parent


    <script src="{{asset('assets/js/plugins/virtualselect/virtualselect.js')}}"></script>
    <script>
        VirtualSelect.init({
            ele: '#categorySelect',
            search: true,
        });
        VirtualSelect.init({
            ele: '#pageSelect',
            search: true,
        });
    </script>
    <script src="{{asset('assets/js/modal.js')}}"></script>
    <script src="{{asset('assets/js/plugins/cropper/cropper.js')}}"></script>
    <script src="{{asset('assets/js/plugins/cropper/myCropper.js')}}"></script>
    <script src="{{asset('assets/js/plugins/sortable/sortable.js')}}"></script>
    <script src="{{asset('assets/js/plugins/popper/popper.js')}}"></script>
    <script src="{{asset('assets/js/dropdown.js')}}"></script>
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

        let deleteImg;
        function deleteImageList(El,id,type){
            let wraper = El.closest('.wraper')
            let label = wraper.querySelector('label.image')
            let uploadIcon =  label.querySelector('.uploadIcon');

            clearTimeout(deleteImg);

            hidden(`#delete_${type}${id} .loader`,'show')

            // let data = {
            //     type : type,
            // }

            deleteImg = setTimeout(function () {
                ajaxReq(`{{url('/')}}/admin/list/${id}/deleteImg`,
                    {type : type}
                    ,function (data){
                    console.log(data)
                    swaltoast('تصویر با موفقیت حذف شد')
                    hidden(`#delete_${type}${id} .loader`)
                    label.style.backgroundImage = '';
                    uploadIcon.classList.remove('hidden')
                    El.classList.add('hidden')
                },'POST')
            },300)



        }


    </script>

@endsection
