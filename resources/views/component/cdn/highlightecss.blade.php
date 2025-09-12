@if(config('view')['cdn'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">
@else
    <link rel="stylesheet" href="{{asset('assets/css/highlight/github-dark.min.css')}}">

@endif
