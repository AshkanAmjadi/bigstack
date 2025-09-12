
@php
    if (!isset($color)){
        $color = 'blue';
    }
    if (!isset($shape)){
        $shape = '';
    }
    if (!isset($noIcon)){
        $noIcon = false;
    }
    if (!isset($bgAnimate)){
        $bgAnimate = true;
    }

@endphp
<label for="@isset($for){{$for}}@endisset" class="text-smid inline-flex items-center gap-2">
    @isset($pretitle)<div>{{$pretitle}}</div>@endisset

    <div tabindex="1"
         class="switch @if($bgAnimate) bgAnimate @endif  @isset($size){{$size}}@endisset @isset($shape){{$shape}}@endisset inline-block focus:ring-2 ring-slate-300 dark:ring-slate-500 bg-{{$color}}-400 ml-1 cursor-pointer">
        <div class="inCheck relative">
            <i class="icon absolute select trans-250">

                @if(!$noIcon)
                    @isset($checkedIcon)
                        @if($checkedIcon)
                            @include('component.icon.'.$checkedIcon)
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="3" stroke="currentColor" class="">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M4.5 12.75l6 6 9-13.5"></path>
                            </svg>
                        @endif
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="3" stroke="currentColor" class="">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M4.5 12.75l6 6 9-13.5"></path>
                        </svg>
                    @endisset
                @endif


            </i>
            <i class="toop absolute trans-150 "></i>
            @if(!$noIcon)
            <i class="icon absolute deselect trans-250">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="3" stroke="currentColor" class="">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6 18L18 6M6 6l12 12"></path>
                </svg>


            </i>
            @endif
        </div>
    </div>
    <div>@isset($title){{$title}}@endisset</div>

</label>
