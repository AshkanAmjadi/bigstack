
@extends('admin.master')

@section('title',"تنظیمات سایت")

@section('cssScripts')

    <link rel="stylesheet" href="{{asset('assets/css/cropper/cropper.css')}}"/>
    @parent



@endsection

{{--todo compelete the web options--}}
@section('content')

    <div id="content" class="mini w-full pt-16 text-slate-700 pb-6">

        <div id="contentWraper" class="w-11/12 mx-auto mt-16 lg:w-96p sm:w-full space-y-6">
            <h2 class="font-bold text-felg mr-6 mb-2 md:mr-3">
                تنظیمات سایت
            </h2>


            <form id="view" action="{{route('admin.option.updateView')}}"
                  class="space-y-3 space-y-reverse card_c p-4 px-6" method="POST">
                @csrf
                @method('POST')
                <h2 class="font-bold text-lg mr-3 mb-2 md:mr-3">
                    تنظیمات نمایش
                </h2>
                <div class="flex gap-3">
                    <div class="wraper w-1/2">
                        <label for="header_v" class="text-sm mr-4 font-semibold">ورژن هدر</label>
                        <select id="header_v" class="form-input2 text-smid w-full" name="header">
                            <option value="1">1</option>
                        </select>
                    </div>
                    <div class="wraper w-1/2">
                        <label for="footer_v" class="text-sm mr-4 font-semibold">ورژن فوتر</label>
                        <select id="footer_v" class="form-input2 text-smid w-full" name="footer">
                            <option value="1">1</option>
                        </select>
                    </div>


                </div>
                <div class="wraper">
                    <label for="theme-color" class="text-sm mr-4 font-semibold">رنگ تم در مرورگر موبایل</label>
                    <input id="theme-color" name="theme-color" class="form-input2 text-smid w-full h-12" type="color" value="{{findInOption('theme_color')}}">
                </div>




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
            <form id="logo"
                  class="space-y-3 space-y-reverse card_c p-4 px-6" method="POST">

                <h2 class="font-bold text-lg mr-3 mb-2 md:mr-3">
                    لوگو
                </h2>




                <div class="grid grid-cols-5 lg:grid-cols-3 md:grid-cols-1 gap-5">
                    <div class="wraper">
                        <h2 class="font-bold text-md mr-3 mb-2 md:mr-3">
                            لوگو
                        </h2>
                        @livewire('admin.img',['option' => 'logo_img'])
                        @include('admin.components.cropImage',['title' => "",'name' => 'logo_img','id'=>'logo_img','size'=>1,'semantic'=>true,'ajax' => true])
                    </div>
                    <div class="wraper">
                        <h2 class="font-bold text-md mr-3 mb-2 md:mr-3">
                            لوگو تم تاریک
                        </h2>
                        @livewire('admin.img',['option' => 'logo_dark_img'])
                        @include('admin.components.cropImage',['title' => "",'name' => 'logo_dark_img','id'=>'logo_dark_img','size'=>1,'semantic'=>true,'ajax' => true])
                    </div>
                    <div class="wraper">
                        <h2 class="font-bold text-md mr-3 mb-2 md:mr-3">
                            لوگو گسترده
                        </h2>
                        @livewire('admin.img',['option' => 'logo_land_img'])
                        @include('admin.components.cropImage',['title' => "",'name' => 'logo_land_img','id'=>'logo_land_img','size'=>2,'semantic'=>true,'ajax' => true])
                    </div>
                    <div class="wraper">
                        <h2 class="font-bold text-md mr-3 mb-2 md:mr-3">
                            لوگو گسترده تم تاریک
                        </h2>
                        @livewire('admin.img',['option' => 'logo_land_dark_img'])
                        @include('admin.components.cropImage',['title' => "",'name' => 'logo_land_dark_img','id'=>'logo_land_dark_img','size'=>2,'semantic'=>true,'ajax' => true])
                    </div>
                    <div class="wraper">
                        <h2 class="font-bold text-md mr-3 mb-2 md:mr-3">
                            پیشفرض پروفایل کاربران
                        </h2>
                        @livewire('admin.img',['option' => 'avatar_default'])
                        @include('admin.components.cropImage',['title' => "",'name' => 'avatar_default','id'=>'avatar_default','size'=>1,'semantic'=>true,'ajax' => true])
                    </div>
                    <div class="wraper">
                        <h2 class="font-bold text-md mr-3 mb-2 md:mr-3">
                            پیشفرض تصویر پروفایل عمومی کاربر
                        </h2>
                        @livewire('admin.img',['option' => 'user_top_image_default'])
                        @include('admin.components.cropImage',['title' => "",'name' => 'user_top_image_default','id'=>'user_top_image_default','size'=>1,'semantic'=>true,'ajax' => true])
                    </div>
                    <div class="wraper">
                        <h2 class="font-bold text-md mr-3 mb-2 md:mr-3">
                            آیکون تب بار وبسایت
                        </h2>
                        @livewire('admin.img',['option' => 'favicon'])
                        @include('admin.components.cropImage',['title' => "",'name' => 'favicon','id'=>'favicon','size'=>1,'semantic'=>true,'ajax' => true])
                    </div>
                </div>

            </form>

            <form id="robots" class="space-y-3 space-y-reverse card_c p-4 px-6" method="POST">


                <h2 class="font-bold text-lg mr-3 mb-2 md:mr-3">
                    ربات های گوگل
                </h2>


                <div class="grid grid-cols-2 gap-2">
                    <div class="wraper w-1/2">
                        <h2 class="text-md mb-2 md:mr-3">
                            ایندکس
                        </h2>
                        @livewire('admin.active',['obj' => getOption('robotsIndex') , 'size'=>'lg','subject' => 'value'],key(getOption('robotsIndex')->getTable() .'_' . getOption('robotsIndex')->id))
                    </div>
                    <div class="wraper w-1/2">
                        <h2 class="text-md mb-2 md:mr-3">
                            فالو
                        </h2>
                        @livewire('admin.active',['obj' => getOption('robotsFollow') , 'size'=>'lg','subject' => 'value'],key(getOption('robotsFollow')->getTable() .'_' . getOption('robotsFollow')->id))
                    </div>
                </div>



            </form>
            <form id="info" action="{{route('admin.option.updateInfo')}}"
                  class="space-y-3 space-y-reverse card_c p-4 px-6" method="POST">
                @csrf
                @method('POST')

                <h2 class="font-bold text-lg mr-3 mb-2 md:mr-3">
                    اطلاعات کلی
                </h2>

                <div class="grid grid-cols-2 gap-4">
                    <div class="wraper md:col-span-2">
                        <p class="text-sm mr-4 font-semibold">نام سایت</p>
                        <input class="form-input2 text-smid w-full" name="site_name" type="text"
                               value="{{old('site_name',findInOption('site_name'))}}" placeholder="نام سایت">
                    </div>
                    <div class="wraper md:col-span-2">
                        <p class="text-sm mr-4 font-semibold">دامنه سایت</p>
                        <input class="form-input2 text-smid w-full" name="domain_name" type="text"
                               value="{{old('domain_name',findInOption('domain_name'))}}" placeholder="دامنه سایت">
                    </div>
                    <div class="wraper md:col-span-2">
                        <p class="text-sm mr-4 font-semibold">ایمیل</p>
                        <input class="form-input2 text-smid w-full" dir="ltr" name="email" type="text"
                               value="{{old('email',findInOption('email'))}}" placeholder="ایمیل">
                    </div>
                    <div class="wraper md:col-span-2">
                        <p class="text-sm mr-4 font-semibold">تیم سازنده سایت</p>
                        <input class="form-input2 text-smid w-full"  name="site_generator" type="text"
                               value="{{old('site_generator',findInOption('site_generator'))}}" placeholder="تیم سازنده سایت">
                    </div>
                    <div class="wraper col-span-2">
                        <h2 class="text-sm mr-4 font-semibold">شعار وبسایت</h2>
                        <textarea class="autosizeArea form-input2 text-smid w-full" rows="1" name="slogan"
                                  type="text" placeholder="توضیح کوتاه..">{{old('slogan',findInOption('slogan'))}}</textarea>
                    </div>
                    <div class="wraper col-span-2">
                        <p class="text-sm mr-4 font-semibold">شخص سازنده سایت</p>
                        <input class="form-input2 text-smid w-full"  name="creator_name" type="text"
                               value="{{old('creator_name',findInOption('creator_name'))}}" placeholder="شخص سازنده سایت">
                    </div>
                    <div class="wraper col-span-2">
                        <h2 class="text-sm mr-4 font-semibold">درباره سازنده</h2>
                        <textarea class="autosizeArea form-input2 text-smid w-full" rows="1" name="creator_about"
                                  type="text" placeholder="توضیح کوتاه..">{{old('creator_about',findInOption('creator_about'))}}</textarea>
                    </div>
                    <div class="wraper col-span-2">
                        <h2 class="text-sm mr-4 font-semibold">درباره وبسایت</h2>
                        <textarea class="autosizeArea form-input2 text-smid w-full" rows="1" name="about_web"
                                  type="text" placeholder="توضیح کوتاه..">{{old('about_web',findInOption('about_web'))}}</textarea>
                    </div>
                </div>



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

            <form id="insta" action=""
                  class="space-y-3 space-y-reverse card_c p-4 px-6" method="POST">


                <div class="flex !m-0">
                    <h2 class="font-bold text-lg ">
                        اینستاگرام

                    </h2>
                    @livewire('admin.active',['obj' => getOption('instagram_post') , 'size'=>'lg','subject' => 'value'],key(getOption('instagram_post')->getTable() .'_' . getOption('instagram_post')->id))

                </div>
                <div class="flex !m-0">
                    <h2 class="font-bold text-lg ">
                        بخش سرویس

                    </h2>
                    @livewire('admin.active',['obj' => getOption('service') , 'size'=>'lg','subject' => 'value'],key(getOption('service')->getTable() .'_' . getOption('service')->id))

                </div>
                <div class="flex !m-0">
                    <h2 class="font-bold text-lg ">
                        ورود با شماره موبایل

                    </h2>

                    @livewire('admin.active',['obj' => getOption('phone_auth') , 'size'=>'lg','subject' => 'value'],key(getOption('phone_auth')->getTable() .'_' . getOption('phone_auth')->id))

                </div>



                {{--                @component('component.btn.btn',['color'=>'rose' , 'id' => 'submitForm'])--}}
                {{--                    @slot('title')--}}
                {{--                        ارسال اطلاعات--}}
                {{--                    @endslot--}}
                {{--                    @slot('icon')--}}
                {{--                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"--}}
                {{--                             stroke-width="2" stroke="currentColor">--}}
                {{--                            <path stroke-linecap="round" stroke-linejoin="round"--}}
                {{--                                  d="M7.5 7.5h-.75A2.25 2.25 0 004.5 9.75v7.5a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25v-7.5a2.25 2.25 0 00-2.25-2.25h-.75m0-3l-3-3m0 0l-3 3m3-3v11.25m6-2.25h.75a2.25 2.25 0 012.25 2.25v7.5a2.25 2.25 0 01-2.25 2.25h-7.5a2.25 2.25 0 01-2.25-2.25v-.75"/>--}}
                {{--                        </svg>--}}
                {{--                    @endslot--}}
                {{--                @endcomponent--}}

            </form>

            <form id="social" action="{{route('admin.option.updateSocial')}}"
                  class="space-y-3 space-y-reverse card_c p-4 px-6" method="POST">
                @csrf
                @method('POST')

                <h2 class="font-bold text-lg mr-3 mb-2 md:mr-3">
                    شبکه های اجتماعی
                </h2>

                <div class="grid grid-cols-2 gap-4">
                    <div class="wraper md:col-span-2">
                        <div class="flex items-center p-1">
                            <div class="icon-md">
                                @include('component.icon.bale')

                            </div>
                            <p class="text-sm mr-4 font-semibold">بله</p>
                            @livewire('admin.active',['obj' => getOption('bale') ,'subject' => 'value'],key(getOption('bale')->getTable() .'_' . getOption('bale')->id))

                        </div>
                        <p class="text-sm mr-4 font-semibold">پشتیبان(ادمین)</p>
                        <input dir="ltr" class="form-input2 text-smid w-full mb-2" name="bale_channel" type="text"
                               value="{{old('bale_channel',findInOption('bale_channel'))}}" placeholder="لینک پشتیبان">
                        <p class="text-sm mr-4 font-semibold">کانال</p>
                        <input dir="ltr" class="form-input2 text-smid w-full mb-2" name="bale_support" type="text"
                               value="{{old('bale_support',findInOption('bale_support'))}}" placeholder="لینک کانال">
                        <p class="text-sm mr-4 font-semibold">گروه</p>
                        <input dir="ltr" class="form-input2 text-smid w-full mb-2" name="bale_group" type="text"
                               value="{{old('bale_group',findInOption('bale_group'))}}" placeholder="لینک گروه">
                        <p class="text-sm mr-4 font-semibold">ربات</p>
                        <input dir="ltr" class="form-input2 text-smid w-full" name="bale_bot" type="text"
                               value="{{old('bale_bot',findInOption('bale_bot'))}}" placeholder="لینک ربات">
                    </div>
                    <div class="wraper md:col-span-2">
                        <div class="flex items-center p-1">
                            <div class="icon-md">
                                @include('component.icon.telegram')

                            </div>
                            <p class="text-sm mr-4 font-semibold">تلگرام</p>
                            @livewire('admin.active',['obj' => getOption('telegram') ,'subject' => 'value'],key(getOption('telegram')->getTable() .'_' . getOption('telegram')->id))

                        </div>
                        <p class="text-sm mr-4 font-semibold">پشتیبان(ادمین)</p>
                        <input dir="ltr" class="form-input2 text-smid w-full mb-2" name="telegram_channel" type="text"
                               value="{{old('telegram_channel',findInOption('telegram_channel'))}}" placeholder="لینک پشتیبان">
                        <p class="text-sm mr-4 font-semibold">کانال</p>
                        <input dir="ltr" class="form-input2 text-smid w-full mb-2" name="telegram_support" type="text"
                               value="{{old('telegram_support',findInOption('telegram_support'))}}" placeholder="لینک کانال">
                        <p class="text-sm mr-4 font-semibold">گروه</p>
                        <input dir="ltr" class="form-input2 text-smid w-full mb-2" name="telegram_group" type="text"
                               value="{{old('telegram_group',findInOption('telegram_group'))}}" placeholder="لینک گروه">
                        <p class="text-sm mr-4 font-semibold">ربات</p>
                        <input dir="ltr" class="form-input2 text-smid w-full" name="telegram_bot" type="text"
                               value="{{old('telegram_bot',findInOption('telegram_bot'))}}" placeholder="لینک ربات">
                    </div>
                    <div class="wraper md:col-span-2">
                        <div class="flex items-center p-1">
                            <div class="icon-md">
                                @include('component.icon.eitaa')

                            </div>
                            <p class="text-sm mr-4 font-semibold">ایتا</p>
                            @livewire('admin.active',['obj' => getOption('eitaa') ,'subject' => 'value'],key(getOption('eitaa')->getTable() .'_' . getOption('eitaa')->id))

                        </div>
                        <p class="text-sm mr-4 font-semibold">پشتیبان(ادمین)</p>
                        <input dir="ltr" class="form-input2 text-smid w-full mb-2" name="eitaa_channel" type="text"
                               value="{{old('eitaa_channel',findInOption('eitaa_channel'))}}" placeholder="لینک پشتیبان">
                        <p class="text-sm mr-4 font-semibold">کانال</p>
                        <input dir="ltr" class="form-input2 text-smid w-full mb-2" name="eitaa_support" type="text"
                               value="{{old('eitaa_support',findInOption('eitaa_support'))}}" placeholder="لینک کانال">
                        <p class="text-sm mr-4 font-semibold">گروه</p>
                        <input dir="ltr" class="form-input2 text-smid w-full" name="eitaa_group" type="text"
                               value="{{old('eitaa_group',findInOption('eitaa_group'))}}" placeholder="لینک گروه">
                    </div>
                    <div class="wraper md:col-span-2">
                        <div class="flex items-center p-1">
                            <div class="icon-md">
                                @include('component.icon.whatsapp')

                            </div>
                            <p class="text-sm mr-4 font-semibold">واتساپ</p>
                            @livewire('admin.active',['obj' => getOption('whatsapp') ,'subject' => 'value'],key(getOption('whatsapp')->getTable() .'_' . getOption('whatsapp')->id))

                        </div>
                        <p class="text-sm mr-4 font-semibold">پشتیبان(ادمین)</p>
                        <input dir="ltr" class="form-input2 text-smid w-full mb-2" name="whatsapp_channel" type="text"
                               value="{{old('whatsapp_channel',findInOption('whatsapp_channel'))}}" placeholder="لینک پشتیبان">
                        <p class="text-sm mr-4 font-semibold">کانال</p>
                        <input dir="ltr" class="form-input2 text-smid w-full mb-2" name="whatsapp_support" type="text"
                               value="{{old('whatsapp_support',findInOption('whatsapp_support'))}}" placeholder="لینک کانال">
                        <p class="text-sm mr-4 font-semibold">گروه</p>
                        <input dir="ltr" class="form-input2 text-smid w-full" name="whatsapp_group" type="text"
                               value="{{old('whatsapp_group',findInOption('whatsapp_group'))}}" placeholder="لینک گروه">
                    </div>
                    <div class="wraper md:col-span-2">
                        <div class="flex items-center p-1">
                            <div class="icon-md">
                                @include('component.icon.instagram')

                            </div>
                            <p class="text-sm mr-4 font-semibold">اینستاگرام</p>
                            @livewire('admin.active',['obj' => getOption('instagram') ,'subject' => 'value'],key(getOption('instagram')->getTable() .'_' . getOption('instagram')->id))

                        </div>
                        <p class="text-sm mr-4 font-semibold">نام کاربری(آیدی)</p>
                        <input dir="ltr" class="form-input2 text-smid w-full mb-2" name="instagram_id" type="text"
                               value="{{old('instagram_id',findInOption('instagram_id'))}}" placeholder="نام کاربری(آیدی)">
                        <p class="text-sm mr-4 font-semibold">لینک</p>
                        <input dir="ltr" class="form-input2 text-smid w-full mb-2" name="instagram_link" type="text"
                               value="{{old('instagram_link',findInOption('instagram_link'))}}" placeholder="لینک پیج">

                    </div>
                    <div class="wraper md:col-span-2">
                        <div class="flex items-center p-1">
                            <div class="icon-md">
                                @include('component.icon.youtube')

                            </div>
                            <p class="text-sm mr-4 font-semibold">یوتیوب</p>
                            @livewire('admin.active',['obj' => getOption('youtube') ,'subject' => 'value'],key(getOption('youtube')->getTable() .'_' . getOption('youtube')->id))

                        </div>
                        <p class="text-sm mr-4 font-semibold">نام کاربری(آیدی)</p>
                        <input dir="ltr" class="form-input2 text-smid w-full mb-2" name="youtube_name" type="text"
                               value="{{old('youtube_name',findInOption('youtube_name'))}}" placeholder="نام کاربری(آیدی)">
                        <p class="text-sm mr-4 font-semibold">لینک</p>
                        <input dir="ltr" class="form-input2 text-smid w-full mb-2" name="youtube_channel" type="text"
                               value="{{old('youtube_channel',findInOption('youtube_channel'))}}" placeholder="لینک کانال">

                    </div>


                </div>

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

@endsection

@section('footerScripts')

    @parent

    {{--ckeditor--}}
    {{--    <script src="{{asset('assets/js/plugins/ckeditor/ckeditor.js')}}"></script>--}}
    <script>
        // CKEDITOR.replace('description');
    </script>

    {{--  editor.js  --}}




    <script src="{{asset('assets/js/allert.js')}}"></script>
    @include('component.cdn.autosize')
    <script src="{{asset('assets/js/plugins/cropper/cropper.js')}}"></script>
    <script src="{{asset('assets/js/plugins/cropper/myCropper.js')}}"></script>



    <script>


    </script>

@endsection
