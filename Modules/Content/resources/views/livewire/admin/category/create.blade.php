<form wire:submit.prevent="{{$onEdit ? 'edit' : 'create'}}(Object.fromEntries(new FormData($event.target)))" class="space-y-3 space-y-reverse"
      enctype="application/x-www-form-urlencoded">

    <input id="parentIdCategory{{!$onEdit ? '_create':''}}" type="hidden" name="parent_id" value="{{$parent_id}}">
    @error('parent_id')
    @component('component.allert.allert' )
        @slot('title')
            {{$message}}
        @endslot
    @endcomponent
    @enderror



    <div class="wraper {{!$onEdit ? '!mt-10' :''}}">
        <h2 class="text-sm mr-4 font-semibold">نام(برای کاربر)</h2>
        <input class="form-input text-smid w-full" name="title" type="text" value="{{$category ? $category->title : ''}}"  placeholder="نام..">
    </div>
    @error('title')
    @component('component.allert.allert' )
        @slot('title')
            {{$message}}
        @endslot
    @endcomponent
    @enderror
    <div class="wraper">
        <h2 class="text-sm mr-4 font-semibold">تیتر داکیومنت(برای گوگل)</h2>
        <input class="form-input text-smid w-full" name="page_title" type="text" value="{{$category ? $category->page_title : ''}}"  placeholder="page_title">
    </div>
    @error('page_title')
    @component('component.allert.allert' )
        @slot('title')
            {{$message}}
        @endslot
    @endcomponent
    @enderror
    <div class="wraper">
        <h2 class="text-sm mr-4 font-semibold">اسلاگ(آدرس url این مقاله) پیشنهاد میشه انگلیسی معادل تیتر داکیومنت باشه</h2>
        <input class="form-input text-smid w-full" name="slug" type="text" value="{{$category ? $category->slug : ''}}"  placeholder="slug">
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
        <textarea class="autosizeArea form-input text-smid w-full" rows="1" name="meta_description" type="text" placeholder="توضیح کوتاه..">{{$category ? $category->meta_description : ''}}</textarea>
    </div>

    @error('meta_description')
    @component('component.allert.allert' )
        @slot('title')
            {{$message}}
        @endslot
    @endcomponent
    @enderror
    <div class="wraper">
        <h2 class="text-sm mr-4 font-semibold">کلمات کلیدی (بین کلمات کاما قرار دهید)</h2>
        <textarea class="autosizeArea form-input text-smid w-full" rows="1" name="keyword" type="text" placeholder="توضیح کوتاه..">{{$category ? $category->keyword : ''}}</textarea>
    </div>

    @error('keyword')
    @component('component.allert.allert' )
        @slot('title')
            {{$message}}
        @endslot
    @endcomponent
    @enderror






    <div class="wraper">
        @include('admin.components.cropImage',['subject'=>$category,'title' => 'عکس دسته بندی','name' => 'img','id'=>'catImage','size'=>1/1,'semantic' => true])
    </div>
    @error('img')
    @component('component.allert.allert' )
        @slot('title')
            {{$message}}
        @endslot
    @endcomponent
    @enderror
    <div class="wraper">
        @include('admin.components.cropImage',['subject'=>$category,'title' => 'بنر دسته بندی','name' => 'banner','id'=>'catBanner','size'=>15/7,'semantic' => true])
    </div>
    @error('banner')
    @component('component.allert.allert' )
        @slot('title')
            {{$message}}
        @endslot
    @endcomponent
    @enderror
    <div class="wraper">
        @include('admin.components.cropImage',['subject'=>$category,'title' => 'بنر دسته بندی','name' => 'mobile_banner','id'=>'catMobileBanner','size'=>3/2,'semantic' => true])
    </div>
    @error('banner')
    @component('component.allert.allert' )
        @slot('title')
            {{$message}}
        @endslot
    @endcomponent
    @enderror


    @component('component.btn.btn',['color'=>'rose'])
        @slot('title')
            <p class="!m-0 inline">
                ارسال اطلاعات
            </p>
        @endslot
        @slot('icon')
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M7.5 7.5h-.75A2.25 2.25 0 004.5 9.75v7.5a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25v-7.5a2.25 2.25 0 00-2.25-2.25h-.75m0-3l-3-3m0 0l-3 3m3-3v11.25m6-2.25h.75a2.25 2.25 0 012.25 2.25v7.5a2.25 2.25 0 01-2.25 2.25h-7.5a2.25 2.25 0 01-2.25-2.25v-.75"/>
            </svg>

        @endslot
    @endcomponent

    <svg wire:target="create" wire:loading class="animate-spin text-slate-700 dark:text-white"
         xmlns="http://www.w3.org/2000/svg"
         fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
</form>
<script>
    document.addEventListener("livewire:initialized", () => {




        @this.on('close_modal', (event) => {

            document.querySelectorAll('.modal .close').forEach(function (el) {
                el.click()
            })

        })

        @this.on('toast',(event)=>{
            Swal.fire({
                position: 'bottom-start',
                icon: event.type,
                toast: true,
                timerProgressBar: true,
                html: `<p>
                ${event.title}
                </p>`,
                showConfirmButton: false,
                timer: 5000,
                customClass: {
                    popup: 'colored-toast'
                }
            })
        })
        // init Tagify script on the above inputs
    });


</script>


