@if(config('view')['cdn'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/autosize.js/6.0.1/autosize.min.js"></script>
@else
    <script src="{{asset('assets\js\plugins\autosize\autosize.min.js')}}"></script>
@endif
<script>
    autosize(document.querySelectorAll('textarea'));

</script>
