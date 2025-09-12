<div class="actions flex justify-between">
    <div class="space-x-1 space-x-reverse">

        @component('component.btn.btn')
            @slot('action')
                onclick="document.querySelector('#parentIdList').value = 0"
            @endslot
            @slot('data_attr')
                data-sended="false" data-modal="addListTo"
            @endslot
            @slot('title')
                ساخت فهرست مادر
            @endslot
            @slot('icon')
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                </svg>
            @endslot
        @endcomponent


        @if($level >=1 && $level < 3)

            @component('component.btn.btn')
                @slot('action')
                    onclick="document.querySelector('#parentIdList').value = {{$parent->id}}"
                @endslot
                @slot('data_attr')
                    data-modal="addListTo"
                @endslot
                @slot('title')
                    ساخت فرزند برای
                    ({{$parent->name}})
                @endslot
                @slot('icon')
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                    </svg>
                @endslot
            @endcomponent
        @endif
    </div>
    <div class="space-x-reverse space-x-1">
        @component('component.btn.btn' , ['color'=>'orange'])
            @slot('action')
                onclick="submitSort()"
            @endslot
            @slot('title')
                ثبت ترتیب فهرست
            @endslot
            @slot('icon')
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25"/>
                </svg>
            @endslot
        @endcomponent


        @if($parent)
            @component('component.btn.linkBtn',['color'=>'rose'])
                @slot('href')
                        {{route($prefix.'index',['parent_id' => $parent->parent_id])}}
                @endslot
                @slot('title')
                        برگشت
                @endslot
                @slot('icon')
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18"/>
                        </svg>
                @endslot
            @endcomponent

        @endif
    </div>
</div>
