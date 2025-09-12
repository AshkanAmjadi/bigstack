@if(config('view')['cdn'])
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
@else
    <script src="{{asset('assets/js/plugins/easyMde/easyMde.js')}}"></script>
@endif
