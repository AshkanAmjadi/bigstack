@if(config('view')['cdn'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/highlight.min.js"></script>
@else
    <script src="{{asset('assets/js/plugins/highlight/highlight.js')}}"></script>
@endif

<script>hljs.highlightAll();</script>
