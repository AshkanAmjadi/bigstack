@if(config('view')['cdn'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.12.3/sweetalert2.all.min.js"></script>
@else
    <script src="{{asset('assets/js/plugins/swal/sweetalert2.all.min.js')}}"></script>
@endif
