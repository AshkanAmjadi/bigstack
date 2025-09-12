@if(config('view')['cdn'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css">
@else
    <link rel="stylesheet" href="{{asset('assets/css/swal/sweetalert2.min.css')}}">
@endif
