

@if(config('view')['cdn'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"></script>
@else
    <script src="{{asset('assets/js/plugins/cleave/cleave.js')}}"></script>
@endif
