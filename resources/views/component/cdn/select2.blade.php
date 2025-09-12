@if(config('view')['cdn'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
@else
    <script src="{{asset('assets/js/plugins/select2/select2.js')}}"></script>
@endif
