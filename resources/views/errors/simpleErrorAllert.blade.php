@foreach($errors as $error)
    @component('component.allert.allert')
        @slot('title')
            {!! clean($error) !!}
        @endslot
    @endcomponent
@endforeach
