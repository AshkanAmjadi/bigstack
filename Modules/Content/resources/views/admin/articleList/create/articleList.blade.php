@extends('admin.master')
@php

    $subject = isset($articleList) ? $articleList : null;
    $update = [];
    $action = 'store';
        $prefix = 'admin.articleList.';
        $name_en = 'articleList';
        $name_fa = 'لیست مقاله';

        if ($subject){
        $update[$name_en] = $subject->id;
        $action = 'update';
    }
@endphp
@section('cssScripts')

    <link rel="stylesheet" href="{{asset('assets/css/select2/select2.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/cropper/cropper.css')}}"/>
    @parent



@endsection

@if($action == 'store')
    @section('title',"اضافه کردن $name_fa")
@elseif($action == 'update')

    @section('title',"ویرایش $name_fa ($subject->title)")
@endif


@section('content')

    <div id="content" class="mini w-full pt-16 text-slate-700 pb-6">

        <div id="contentWraper" class="w-11/12 mx-auto mt-16 lg:w-96p sm:w-full space-y-6">
            <h2 class="font-bold text-felg mr-6 mb-2 md:mr-3">
                @if($action == 'store')
                    اضافه کردن {{$name_fa}}
                @elseif($action == 'update')
                    ویرایش {{$name_fa}} ({{$subject->title}})
                @endif
            </h2>


            <form id="addArticleList"  action="{{route("$prefix$action",$update)}}"
                  class="space-y-3 space-y-reverse card_c p-4 px-6" method="POST">
                @csrf
                @if($action == 'store')
                    @method('POST')
                @elseif($action == 'update')
                    @method('PUT')
                @endif

                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">تیتر داکیومنت(برای گوگل)</h2>
                    <input class="form-input text-smid w-full" name="page_title" type="text"
                           value="{{old('page_title',$subject ? $subject->page_title : null)}}" placeholder="page_title">
                </div>
                @error('page_title')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">تیتر لیست مقاله(برای کاربر)</h2>
                    <input class="form-input text-smid w-full" name="title" type="text"
                           value="{{old('title',$subject ? $subject->title : null)}}" placeholder="title">
                </div>
                @error('title')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">اسلاگ(آدرس url لیست مقاله) پیشنهاد میشه معادل انگلیسی تیتر داکیومنت باشه</h2>
                    <input class="form-input text-smid w-full" name="slug" type="text"
                           value="{{old('slug',$subject ? $subject->slug : null)}}" placeholder="slug - در صورت خالی بودن از تیتر داکیومنت استفاده میشود">
                </div>
                @error('slug')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">توضیح کوتاه(meta-description برای گوگل) فقط 165 کارکتر نمایش داده میشود</h2>
                    <textarea class="autosizeArea form-input text-smid w-full" rows="1" name="meta_description"
                              type="text" placeholder="توضیح کوتاه..">{{old('meta_description',$subject ? $subject->meta_description : null)}}</textarea>
                </div>
                @error('meta_description')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror


                <div class="wraper">
                    <h2 class="text-sm mr-4 font-semibold">کلمات کلیدی</h2>

                    <select id="keyword" class="form-input select2 text-smid w-full font-YekanBakh" name="keyword[]"
                            multiple>
                        @php($keyword = old('keyword',$subject ? ($subject->keyword ?explode(',' ,$subject->keyword) : null) : null))


                        @if($keyword)
                            @foreach($keyword as $word)
                                <option
                                    value="{{$word}}" selected>{{$word}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                @error('keyword')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror


                <div class="wraper">
                    @include('admin.components.cropImage',['title' => "بنر $name_fa",'name' => 'banner','id'=>'articleListBanner','size'=>15/7,'semantic'=>true])
                </div>
                @error('banner')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror
                <div class="wraper">
                    @include('admin.components.cropImage',['title' => "بنر موبایل $name_fa",'name' => 'mobile_banner','id'=>'articleListMobileBanner','size'=>3/2,'semantic'=>true])
                </div>
                @error('mobile_banner')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror



                <div class="switchWraper p-2">
                    <input type="checkbox" id="item3" hidden="" @if(old('active') === 'on' or $subject ? $subject->active : false) checked @endif @if(!$subject) checked @endif name="active">
                    @component('component.switch.switchLable',['title' => 'فعال' ,'shape'=> 'square','for' => 'item3'])
                    @endcomponent
                </div>


                <div class="wraper flex flex-wrap gap-3">
                    @component('component.btn.btnD',['title' => 'اضافه کردن مقاله','color'=>'emerald'])
                        @slot('action')
                            onclick="sidebar('show','articleList');selector('#searchArticleLink').focus()"
                        @endslot
                        @slot('icon')
                                <svg xmlns="http://www.w3.org/2000/svg" class="" viewBox="0 0 24 24"><g fill="currentColor"><path d="M3 10c0-3.771 0-5.657 1.172-6.828C5.343 2 7.229 2 11 2h2c3.771 0 5.657 0 6.828 1.172C21 4.343 21 6.229 21 10v4c0 3.771 0 5.657-1.172 6.828C18.657 22 16.771 22 13 22h-2c-3.771 0-5.657 0-6.828-1.172C3 19.657 3 17.771 3 14v-4Z" opacity=".5"></path><path d="M16.519 16.501c.175-.136.334-.295.651-.612l3.957-3.958c.096-.095.052-.26-.075-.305a4.332 4.332 0 0 1-1.644-1.034a4.332 4.332 0 0 1-1.034-1.644c-.045-.127-.21-.171-.305-.075L14.11 12.83c-.317.317-.476.476-.612.651c-.161.207-.3.43-.412.666c-.095.2-.166.414-.308.84l-.184.55l-.292.875l-.273.82a.584.584 0 0 0 .738.738l.82-.273l.875-.292l.55-.184c.426-.142.64-.212.84-.308c.236-.113.46-.25.666-.412Zm5.847-5.809a2.163 2.163 0 1 0-3.058-3.059l-.127.128a.524.524 0 0 0-.148.465c.02.107.055.265.12.452c.13.375.376.867.839 1.33a3.5 3.5 0 0 0 1.33.839c.188.065.345.1.452.12a.525.525 0 0 0 .465-.148l.127-.127Z"></path><path fill-rule="evenodd" d="M7.25 9A.75.75 0 0 1 8 8.25h6.5a.75.75 0 0 1 0 1.5H8A.75.75 0 0 1 7.25 9Zm0 4a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5H8a.75.75 0 0 1-.75-.75Zm0 4a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5H8a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd"></path></g></svg>
                        @endslot
                    @endcomponent


                    <div id="selectedArticle" class="w-full grid grid-cols-3 2xl:grid-cols-2 sm:grid-cols-1 gap-3">


                        @if($articles = old('articles',$subject ? $subject->articles : null))

                            @foreach(\Modules\Content\App\Models\Article::query()->whereIn('id',$articles)->get(['id','title','img']) as $article)

                                <div class="articleSelected card flex items-center p-2 relative">
                                    <input type="checkbox" class="hidden" checked value="{{$article->id}}" name="articles[]">
                                    <div class="border-4 w-1/2 md:w-1/3 dark:border-slate-700 rounded-lg overflow-hidden flex justify-center " >
                                        @if($article->img)
                                            <img class="w-full" src="{{semanticImgUrlMaker($article,'img')}}" alt="">
                                        @else
                                            <h2 class="font-bold text-smid flex flex-wrap gap-1 opacity-50 my-5">بدون عکس</h2>
                                        @endif
                                    </div>
                                    <h2 class="text-sm mr-4 font-semibold w-1/2 md:w-2/3">
                                        {{$article->title}}
                                    </h2>

                                    <div id="deleteSelectedList{{$article->id}}" class="absolute top-2 left-2 p-2 cursor-pointer" onclick="deleteSelectedList(this,{{$article->id}})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                             height="24"
                                             viewBox="0 0 24 24"
                                             class="">
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

                                    </div>
                                </div>

                            @endforeach

                        @endif



                    </div>


                </div>
                @error('articles')
                @component('component.allert.allert' )
                    @slot('title')
                        {{$message}}
                    @endslot
                @endcomponent
                @enderror




            @component('component.btn.btn',['color'=>'rose' , 'id' => 'submitForm'])
                    @slot('title')
                        ارسال اطلاعات
                    @endslot
                    @slot('icon')
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M7.5 7.5h-.75A2.25 2.25 0 004.5 9.75v7.5a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25v-7.5a2.25 2.25 0 00-2.25-2.25h-.75m0-3l-3-3m0 0l-3 3m3-3v11.25m6-2.25h.75a2.25 2.25 0 012.25 2.25v7.5a2.25 2.25 0 01-2.25 2.25h-7.5a2.25 2.25 0 01-2.25-2.25v-.75"/>
                        </svg>
                    @endslot
                @endcomponent
            </form>


        </div>


    </div>



    @component('admin.components.sidebar',['name' => 'articleList'])
        {{--            todo component the loader--}}

        <div class="loader absoluteCenter hidden text-blue-500 icon-2xl">
            @include('component.loading.loading')
        </div>
        <div class="top flex justify-between items-center gap-3 w-full absolute top-0 left-0 p-6">
            <div class="right w-full">
                <input id="searchArticleLink"  class="form-input w-full text-sm card_c border-none" type="text" name="search"  placeholder="جستوجو..." value="" oninput="searchArticleList(this)">
            </div>
            <div class="left">
                @component('component.btn.btnD',['color'=>'sky' ])
                    @slot('action')
                        onclick="sidebar('hide','articleList')"
                    @endslot
                    @slot('icon')
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <g fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M20.75 12a.75.75 0 0 0-.75-.75h-9.25v1.5H20a.75.75 0 0 0 .75-.75Z"
                                      clip-rule="evenodd" opacity=".5"/>
                                <path
                                    d="M10.75 18a.75.75 0 0 1-1.28.53l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.28.53v12Z"/>
                            </g>
                        </svg>
                    @endslot
                @endcomponent

            </div>
        </div>
        <div class="contentWraper px-3 py-14">
            <div class="card_c py-5 px-3">
                <h2 class="text-sm mr-4 font-semibold text-center">برای جست و جو حداقل 3 حرف را وارد کنید</h2>
            </div>
        </div>
    @endcomponent

@endsection

@section('footerScripts')

    @parent

{{--ckeditor--}}
{{--    <script src="{{asset('assets/js/plugins/ckeditor/ckeditor.js')}}"></script>--}}
    <script>
        function selectItem(input){

            let id = input.value
            let wraper = selector(`label[for=${input.id}]`)
            let img = wraper.querySelector('img')
            let text = wraper.querySelector('.title').textContent

            if (input.checked){

                if(img){
                    img = `<img class="w-full" src="${img.src}" alt="">`
                }else {
                    img = `<h2 class="font-bold text-smid flex flex-wrap gap-1 opacity-50 my-5">بدون عکس</h2>`
                }

                selector('#selectedArticle').insertAdjacentHTML(`beforeend`,`
<div class="articleSelected card flex items-center p-2 relative">
<input type="checkbox" class="hidden" checked value="${id}" name="articles[]">
                            <div class="border-4 w-1/2 md:w-1/3 dark:border-slate-700 rounded-lg overflow-hidden flex justify-center " >
                                ${img}
                            </div>
                            <h2 class="text-sm mr-4 font-semibold w-1/2 md:w-2/3">
                                ${text}
                            </h2>

                            <div id="deleteSelectedList${id}" class="absolute top-2 left-2 p-2 cursor-pointer" onclick="deleteSelectedList(this,${id})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                     height="24"
                                     viewBox="0 0 24 24"
                                     class="">
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

                            </div>
                        </div>

                `)

                swaltoast('به لیست اضافه شد')
            }else {

                if(selector(`#deleteSelectedList${id}`)){
                    selector(`#deleteSelectedList${id}`).click()
                }
                swaltoast('از لیست حذف شد','error')
            }

        }
        let Timout;
        function searchArticleList(input) {

            let content = selector('#sidebar .contentWraper')
            content.textContent = '';

            if (input.value.length >= 3){
                hidden('#sidebar .loader','show')
                clearTimeout(Timout);
                let data = {
                    articles : []
                }

                nodeToArr(document.querySelectorAll('input[name="articles[]"]')).forEach(function (El) {
                    data.articles.push(El.value)
                })


                Timout = setTimeout(function () {
                    ajaxReq(`{{route('admin.articleListSearch')}}?search=${input.value}`,data,function (data){
                        hidden('#sidebar .loader')
                        content.textContent = '';

                        content.insertAdjacentHTML('afterbegin', `` + data + ``);

                    },'POST')
                },400)
            }else{
                hidden('#sidebar .loader')
                clearTimeout(Timout);
                content.textContent = '';
                content.insertAdjacentHTML('afterbegin', `
                <div class="card_c py-5 px-3">
                    <h2 class="text-sm mr-4 font-semibold text-center">برای جست و جو حداقل 3 حرف را وارد کنید</h2>
                </div>
                `);
            }
        }
        function deleteSelectedList(btn,id) {
            btn.closest('.articleSelected').remove();
            let sidebarEl =  document.querySelector(`#sidebar.articleList .contentWraper label[for="searchArticle${id}"]`);
            if (sidebarEl){
                sidebarEl.click();
            }else {
                swaltoast('از لیست حذف شد','error')
            }
        }


    </script>



    <script src="{{asset('assets/js/allert.js')}}"></script>
    @include('component.cdn.autosize')

    <script src="{{asset('assets/js/plugins/cropper/cropper.js')}}"></script>
    <script src="{{asset('assets/js/plugins/cropper/myCropper.js')}}"></script>
    @include('component.cdn.select2')


    <script>


        function craeteTagSelect(element) {

            $(element).select2({
                placeholder: "جستو جو ...",
                tags: true,
                closeOnSelect: false,
                dir: 'rtl'
            })


        }
        craeteTagSelect('#keyword')

    </script>



@endsection
