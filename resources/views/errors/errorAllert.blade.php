@foreach($errors as $error)
    @component('component.allert.allert')
        @slot('title')
            {{$error[0]}}
        @endslot
    @endcomponent
@endforeach
