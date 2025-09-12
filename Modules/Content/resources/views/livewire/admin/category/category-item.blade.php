
<div>
    <div class="head flex justify-between items-center flex-wrap text-smid card_c p-3">
        <div class="title flex items-center space-x-2 space-x-reverse">
            <div class="icon">
                <div class="icon inline">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M4.5 7.5a3 3 0 013-3h9a3 3 0 013 3v9a3 3 0 01-3 3h-9a3 3 0 01-3-3v-9z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>

            <p class="">{{$cat->title}}</p>

        </div>

        <div class="actions flex items-center gap-2 ">
            @component('component.btn.linkBtn',['color'=>'amber'])
                @slot('href')
                    {{route('category.show',['category'=>$cat->slug])}}
                @endslot
                @slot('title')
                    لینک صفحه
                @endslot
                @slot('icon')
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="icon-sm"
                         viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 11.5a2.5 2.5 0 1 1-5 0a2.5 2.5 0 0 1 5 0Z"/>
                            <path stroke-linecap="round" d="M14.32 16.802L9 13.29m5.42-6.45L9.1 10.35"
                                  opacity=".5"/>
                            <path
                                d="M19 18.5a2.5 2.5 0 1 1-5 0a2.5 2.5 0 0 1 5 0Zm0-13a2.5 2.5 0 1 1-5 0a2.5 2.5 0 0 1 5 0Z"/>
                        </g>
                    </svg>
                @endslot
            @endcomponent
            @component('component.btn.btn')
                @slot('action')
                    onclick="editButton(this,{{$cat->id}})"
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

            @if($level <= 1)
                @component('component.btn.btn' , ['color'=>'emerald'])

                    @slot('data_attr')
                        data-modal="addCategoryTo" onclick="document.querySelector('#parentIdCategory_create').value = {{$cat->id}};openModal(this)"
                    @endslot
                    @slot('title')
                        ساخت فرزند
                    @endslot
                    @slot('icon')
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                        </svg>

                    @endslot
                @endcomponent

            @endif




            <div tabindex="1" class="btn shadow-md shadow-red-200 dark:shadow-red-500/60 hover:shadow-lg hover:shadow-red-200 dark:hover:shadow-red-700 bg-red-500 text-slate-50 hover:bg-red-400 inline-block rounded-md focus:shadow-none focus:bg-red-600 focus:ring-2 focus:ring-red-600 focus:ring-offset-2">
                <p class="inline">
                    حذف
                </p>
                <div class="icon">
                    <svg class="fill-white" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 100 125"><path class="st0" d="M20.002,29.232l62.515-0.02l0.007,0.007l-0.046-6.28l-65.014,0.06l0.06,6.234H20.002L20.002,29.232z   M83.46,36.085v44.379c0,8.001-6.533,14.534-14.534,14.534H31.074c-8.001,0-14.534-6.533-14.534-14.534V36.085  c-3.411-0.484-6-3.441-6-6.913v-6.174c0-3.848,3.134-6.982,6.982-6.982h18.217c0-3.393-0.375-6.115,2.262-8.752  c1.396-1.396,3.325-2.262,5.449-2.262h13.1c4.231,0,7.71,3.479,7.71,7.71v3.304h18.217c3.848,0,6.982,3.134,6.982,6.982v6.174  c0,1.921-0.787,3.659-2.055,4.927l0.007,0.007C86.367,35.151,84.992,35.868,83.46,36.085L83.46,36.085z M42.662,16.016h14.676  c0-2.151,0.407-4.092-0.788-4.092h-13.1C42.255,11.925,42.662,13.942,42.662,16.016L42.662,16.016z M76.537,36.155H23.463v44.309  c0,4.179,3.432,7.611,7.611,7.611h37.851c4.179,0,7.612-3.433,7.612-7.611V36.155z"/></svg>
                </div>

                <div class="dropdown pop bg-slate-700 dark:bg-slate-100 dark:text-slate-700" data-position="top">
                    <h2 class="text-sm font-semibold">توجه!!</h2>
                    <p class="text-fsm font-light">
                        با حذف این دسته بندی فرزندان و عکس های آن هم حذف میشوند
                    </p>
                    <div class="btns">
                        <div wire:click="delete" class="btn sm shadow-md shadow-rose-500/60 hover:shadow-lg hover:shadow-rose-700 bg-rose-500 text-slate-50 hover:bg-rose-400 inline-block rounded-md">
                            <p class="inline">
                                حذف
                            </p>
                            <div class="icon">
                                <svg class="fill-white" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 100 125"><path class="st0" d="M20.002,29.232l62.515-0.02l0.007,0.007l-0.046-6.28l-65.014,0.06l0.06,6.234H20.002L20.002,29.232z   M83.46,36.085v44.379c0,8.001-6.533,14.534-14.534,14.534H31.074c-8.001,0-14.534-6.533-14.534-14.534V36.085  c-3.411-0.484-6-3.441-6-6.913v-6.174c0-3.848,3.134-6.982,6.982-6.982h18.217c0-3.393-0.375-6.115,2.262-8.752  c1.396-1.396,3.325-2.262,5.449-2.262h13.1c4.231,0,7.71,3.479,7.71,7.71v3.304h18.217c3.848,0,6.982,3.134,6.982,6.982v6.174  c0,1.921-0.787,3.659-2.055,4.927l0.007,0.007C86.367,35.151,84.992,35.868,83.46,36.085L83.46,36.085z M42.662,16.016h14.676  c0-2.151,0.407-4.092-0.788-4.092h-13.1C42.255,11.925,42.662,13.942,42.662,16.016L42.662,16.016z M76.537,36.155H23.463v44.309  c0,4.179,3.432,7.611,7.611,7.611h37.851c4.179,0,7.612-3.433,7.612-7.611V36.155z"/></svg>
                            </div>
                            <div class="icon hidden animate-spin" wire:target="delete" wire:loading.class.remove="hidden" >
                                <svg  viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="48" height="48" fill-opacity="0.01"></rect>
                                    <path class="stroke-white" d="M4 24C4 35.0457 12.9543 44 24 44V44C35.0457 44 44 35.0457 44 24C44 12.9543 35.0457 4 24 4" stroke="black" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path class="stroke-white" stroke-opacity="0.8" d="M36 24C36 17.3726 30.6274 12 24 12C17.3726 12 12 17.3726 12 24C12 30.6274 17.3726 36 24 36V36" stroke="black" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" opacity="0.8"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="formContent w-full p-3 card mt-3 relative hidden">

            @livewire('content::admin.category.create',['category' => $cat ,'edit'=> true],key("edit_category_$cat->id"))

        </div>
    </div>
    <div class="child space-y-3 mt-3 pr-5 border-r-2 border-blue-400 dark:border-blue-700 ">
        @php($level++)
        @foreach($cat->child as $child)
            @livewire('content::admin.category.category-item',['level' => $level ,'cat' => $child],key(''.now().''))
        @endforeach
    </div>
</div>



<script>
    document.addEventListener("livewire:initialized", () => {
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
