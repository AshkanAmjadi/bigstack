

@if(config('view')['cdn'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css">
@else
    <link rel="stylesheet" href="{{asset('assets/css/select2/select2.css')}}">
@endif


<style>
    .select2-container .select2-search--inline .select2-search__field {

        min-height: 39px;

    }
    .select2-search {

        display: inline-flex;

        align-items: center

    }
</style>
