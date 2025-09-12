@if(config('view')['cdn'])
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
@else
    <link rel="stylesheet" href="{{asset('assets/css/easyMde/easyMde.css')}}">

@endif
