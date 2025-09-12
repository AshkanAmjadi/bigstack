
@php

if (!isset($ring)){
    $ring = true;
}

@endphp

@if($category->banner or $category->mobile_banner)

    <div class="inline-block w-full @if($ring) shiar ring-blue-600 @endif rounded-md overflow-hidden ">
        @if(mobileDevice())
            @if($category->mobile_banner)
                <img class="w-full" src="{{semanticImgUrlMaker($category,'mobile_banner')}}" alt="{{$category->page_title}}">
            @elseif($category->banner)
                <img class="w-full" src="{{semanticImgUrlMaker($category,'banner')}}" alt="{{$category->page_title}}">
            @endif

        @else
            @if($category->banner)
                <img class="w-full" src="{{semanticImgUrlMaker($category,'banner')}}" alt="{{$category->page_title}}">
            @elseif($category->mobile_banner)
                <img class="w-full" src="{{semanticImgUrlMaker($category,'mobile_banner')}}" alt="{{$category->page_title}}">
            @endif

        @endif
    </div>


@endif
