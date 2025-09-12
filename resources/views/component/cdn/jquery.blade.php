@if(config('view')['cdn'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@else
    <script src="{{asset('assets/js/plugins/jquery/jquery.js')}}"></script>
@endif
