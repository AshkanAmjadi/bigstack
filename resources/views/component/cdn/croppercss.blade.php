@if(config('view')['cdn'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">

@else
    <link rel="stylesheet" href="{{asset('assets/css/cropper/cropper.css')}}">
@endif
