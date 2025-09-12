
@php

    $prefix = 'admin.comment.';
    $name_en = 'comment';
    $name_fa = 'نظرات';
    $name_fa_fard = 'نظر';

@endphp
<div class="flex flex-col-reverse pb-20">
@forelse($comments as $comment)
        @include('admin.comment.preview.items',['subject' => $comment])
    @empty
        خالی
    @endforelse
    @include('user::admin.component.who' , ['relation' => 'user' , 'subject' => $mainComment])

</div>

<div class="w-10/12 my-auto absolute bottom-8 right-1/2 translate-x-1/2 glassmorph flex p-2 gap-2">
    <form class="delete w-full"
          action="{{ route($prefix.'destroy',[$name_en=>$mainComment->id]) }}"
          method="post">
        @csrf
        @method('DELETE')


        @component('component.btn.btnD',['color'=>'red','tabindex' => true ,'w_full' => true])
            @slot('action')

                onclick="closeAndDeleteComment('{{$mainComment->id}}')"

            @endslot
            @slot('icon')
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
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

    </form>

    @if($mainComment->active)
        @component('component.btn.btnD',['color'=> 'gray','w_full' => true])
            @slot('title')
                غیر فعال کردن
            @endslot
            @slot('action')

                onclick="closeAndActiveComment('{{$mainComment->id}}')"

            @endslot
            @slot('icon')
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="currentColor"><path d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22Z" opacity=".5"/><path d="M8.97 8.97a.75.75 0 0 1 1.06 0L12 10.94l1.97-1.97a.75.75 0 1 1 1.06 1.06L13.06 12l1.97 1.97a.75.75 0 1 1-1.06 1.06L12 13.06l-1.97 1.97a.75.75 0 0 1-1.06-1.06L10.94 12l-1.97-1.97a.75.75 0 0 1 0-1.06Z"/></g></svg>
            @endslot
        @endcomponent

    @else
        @component('component.btn.btnD',['color'=> 'teal','w_full' => true])
            @slot('title')
                فعال کردن
            @endslot
            @slot('action')

                onclick="closeAndActiveComment({{$mainComment->id}})"

            @endslot
            @slot('icon')
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="currentColor"><path d="m13.629 20.472l-.542.916c-.483.816-1.69.816-2.174 0l-.542-.916c-.42-.71-.63-1.066-.968-1.262c-.338-.197-.763-.204-1.613-.219c-1.256-.021-2.043-.098-2.703-.372a5 5 0 0 1-2.706-2.706C2 14.995 2 13.83 2 11.5v-1c0-3.273 0-4.91.737-6.112a5 5 0 0 1 1.65-1.651C5.59 2 7.228 2 10.5 2h3c3.273 0 4.91 0 6.113.737a5 5 0 0 1 1.65 1.65C22 5.59 22 7.228 22 10.5v1c0 2.33 0 3.495-.38 4.413a5 5 0 0 1-2.707 2.706c-.66.274-1.447.35-2.703.372c-.85.015-1.275.022-1.613.219c-.338.196-.548.551-.968 1.262Z" opacity=".5"/><path d="M15.53 9.53a.75.75 0 0 0-1.06-1.06l-3.48 3.48l-1.47-1.411a.75.75 0 1 0-1.04 1.082l2 1.92a.75.75 0 0 0 1.05-.01l4-4Z"/></g></svg>
            @endslot
        @endcomponent
    @endif
</div>
