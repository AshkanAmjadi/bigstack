
@php
    if ($marked){
        if ($marked == 'marked'){
            $bool = true;
        }elseif($marked == 'deleted'){
            $bool = false;
        }

    }else{
        $bool =$obj->marked->first();
    }
@endphp
<div class="mark flex items-center gap-1 text-blue-500 cursor-pointer p-1">
    <div class="icon-{{$iconSize}}" wire:click.debounce.150ms="toggle()" wire:loading.remove>

        @if($bool)
            <svg xmlns="http://www.w3.org/2000/svg"  width="24" height="24" viewBox="0 0 24 24"><g fill="currentColor"><path d="M3.464 20.536C4.93 22 7.286 22 12 22c4.714 0 7.071 0 8.535-1.464C22 19.07 22 16.714 22 12c0-4.714 0-7.071-1.465-8.536C19.072 2 16.714 2 12 2S4.929 2 3.464 3.464C2 4.93 2 7.286 2 12c0 4.714 0 7.071 1.464 8.536Z" opacity=".5"/><path d="M7 17.25a.75.75 0 0 0 0 1.5h10a.75.75 0 0 0 0-1.5H7Zm.765-5.352a21.485 21.485 0 0 1-.015-1.09v-8.74C8.906 2 10.3 2 12 2c1.7 0 3.094 0 4.25.069v8.739c0 .496 0 .836-.015 1.09c-.015.262-.043.343-.05.358a.75.75 0 0 1-.862.425c-.016-.004-.097-.032-.315-.18a20.93 20.93 0 0 1-.872-.653l-.067-.052c-.37-.285-.659-.507-.973-.644a2.75 2.75 0 0 0-2.192 0c-.314.137-.603.359-.973.644l-.067.052c-.393.303-.663.51-.873.653c-.217.148-.298.176-.314.18a.75.75 0 0 1-.862-.425c-.007-.015-.035-.096-.05-.358Z"/></g></svg>

        @else
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/><path d="M17 2v6.808c0 .975 0 1.462-.13 1.753a1.5 1.5 0 0 1-1.724.848c-.31-.075-.695-.372-1.468-.967c-.436-.336-.654-.504-.881-.602a2 2 0 0 0-1.594 0c-.227.098-.445.266-.881.602c-.773.595-1.159.892-1.468.967a1.5 1.5 0 0 1-1.725-.848C7 10.27 7 9.783 7 8.808V2" opacity=".5"/></g></svg>
        @endif
    </div>
    <div class="icon-{{$iconSize}}" wire:loading>
        @component('component.loading.loading',[])

        @endcomponent
    </div>


</div>

