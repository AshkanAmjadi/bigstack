
@php
    if (isset($type)){
        if ($type == 'danger'){
            $color = 'rose';
        }elseif ($type == 'info'){
            $color = 'amber';
        }elseif ($type == 'secondary'){
            $color = 'gray';
        }elseif ($type == 'warning'){
            $color = 'orange';
        }elseif ($type == 'success'){
            $color = 'emerald';
        }
    }else{
        $type = 'info';
        $color = 'blue';
    }
    if (!isset($closeBtn)){
        $closeBtn = true;
    }
    if (!isset($new)){
        $new = false;
    }


@endphp


<div
    class="allert w-full group text-{{$color}}-500 bg-{{$color}}-500/10 hover:bg-{{$color}}-500/100 inline-block rounded-md border-{{$color}}-500 focus:bg-{{$color}}-600 focus:border-{{$color}}-600 focus:ring-2 focus:ring-{{$color}}-600 focus:ring-offset-2 focus:text-slate-50 hover:text-slate-50">
    <div class="content flex flex-wrap">
        <div class="icon ml-2">
            @include('component.allert.icons.'.$type)
        </div>
        <div>
            @if(isset($content))  {!! clean($content) !!} @endif
        </div>
        @isset($old)
            <div class="text-fnsm font-light flex flex-wrap gap-2 w-full mt-2">
        <span class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l2.5 2.5"/><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z" opacity=".5"/></g></svg>
        </span>
                {{$old}}

                @if($new)
                    <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="3" cy="3" r="3" transform="matrix(-1 0 0 1 22 2)"/><path stroke-linecap="round" d="M14 2.2c-.646-.131-1.315-.2-2-.2C6.477 2 2 6.477 2 12c0 1.6.376 3.112 1.043 4.453c.178.356.237.763.134 1.148l-.595 2.226a1.3 1.3 0 0 0 1.591 1.592l2.226-.596a1.634 1.634 0 0 1 1.149.133A9.958 9.958 0 0 0 12 22c5.523 0 10-4.477 10-10c0-.685-.069-1.354-.2-2" opacity="0.5"/></g></svg>
                </span>

                    new
                @endif
            </div>
        @endisset
    </div>
    @if($closeBtn)

        <div @isset($deleteAction) {{$deleteAction}} @endisset
             class="close bg-{{$color}}-200/70 dark:bg-{{$color}}-200/20 group-hover:bg-slate-100/20 cursor-pointer p-1 rounded-md ">
            <div class="deleteIcon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                     class="w-6 h-6 icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <div class="loader hidden">
                <svg class="animate-spin"  viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="48" height="48" fill-opacity="0.01"></rect>
                    <path class="stroke-{{$color}}-500 group-hover:stroke-white transall" d="M4 24C4 35.0457 12.9543 44 24 44V44C35.0457 44 44 35.0457 44 24C44 12.9543 35.0457 4 24 4" stroke="black" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path class="stroke-{{$color}}-500 group-hover:stroke-white transall" stroke-opacity="0.8" d="M36 24C36 17.3726 30.6274 12 24 12C17.3726 12 12 17.3726 12 24C12 30.6274 17.3726 36 24 36V36" stroke="black" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" opacity="0.8"></path>
                </svg>
            </div>

        </div>
    @endif
</div>

