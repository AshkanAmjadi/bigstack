@if(config('view')['cdn'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

@else
    <script src="{{asset('assets/js/plugins/cropper/cropper.js')}}"></script>
@endif
