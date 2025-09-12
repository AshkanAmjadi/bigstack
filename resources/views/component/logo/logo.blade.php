
@php
    if (!isset($size)){
        $size = 'img-2xl';
    }
    if (!isset($landSize)){
        $landSize = 'img-2xl';
    }
    if (!isset($sbj)){
        $sbj = 'both';
    }
    if (!isset($place)){
        $place = null;
    }
    //todo mobile device
@endphp

@if($place and $place == 'home_header')
    @if($sbj === 'dark')
        <img class="inline-block dark:hidden lg-r:!hidden {{$size}}" src="{{logoSrcMaker('logo_img')}}" alt="{{findInOption('slogan')}}">

        <img class="inline-block dark:hidden lg:!hidden {{$landSize}}-land" src="{{logoSrcMaker('logo_land_img')}}" alt="{{findInOption('slogan')}}">

    @endif
    @if($sbj === 'light')
        <img class="hidden dark:inline-block lg-r:!hidden {{$size}}" src="{{logoSrcMaker('logo_dark_img')}}" alt="{{findInOption('slogan')}}">

        <img class="hidden dark:inline-block lg:!hidden {{$landSize}}-land" src="{{logoSrcMaker('logo_land_dark_img')}}" alt="{{findInOption('slogan')}}">
    @endif
@elseif($place and $place == 'aside')
    @if($sbj === 'dark')

        <img class="inline-block dark:hidden {{$landSize}}-land" src="{{logoSrcMaker('logo_land_img')}}" alt="{{findInOption('slogan')}}">

    @endif
    @if($sbj === 'light')

        <img class="hidden dark:inline-block {{$landSize}}-land" src="{{logoSrcMaker('logo_land_dark_img')}}" alt="{{findInOption('slogan')}}">
    @endif
    @if($sbj === 'both')

        <img class="inline-block dark:hidden {{$landSize}}-land" src="{{logoSrcMaker('logo_land_img')}}" alt="{{findInOption('slogan')}}">

        <img class="hidden dark:inline-block {{$landSize}}-land" src="{{logoSrcMaker('logo_land_dark_img')}}" alt="{{findInOption('slogan')}}">
    @endif
@else
    @if($sbj === 'both')
        <img class="inline-block dark:hidden {{$size}}" src="{{logoSrcMaker('logo_img')}}" alt="{{findInOption('slogan')}}">
        <img class="hidden dark:inline-block {{$size}}" src="{{logoSrcMaker('logo_dark_img')}}" alt="{{findInOption('slogan')}}">
    @endif
    @if($sbj === 'dark')
        <img class="inline-block {{$size}}" src="{{logoSrcMaker('logo_img')}}" alt="{{findInOption('slogan')}}">
    @endif
    @if($sbj === 'light')
        <img class="inline-block {{$size}}" src="{{logoSrcMaker('logo_dark_img')}}" alt="{{findInOption('slogan')}}">
    @endif
@endif

