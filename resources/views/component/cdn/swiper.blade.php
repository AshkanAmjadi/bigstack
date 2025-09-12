@if(config('view')['cdn'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"></script>
@else
    <script src="{{asset('assets/js/plugins/swiper/swiper-bundle.min.js')}}"></script>
@endif
