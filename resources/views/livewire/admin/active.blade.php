<div class="switchWraper flex mr-5">
    <input type="checkbox"
           id="activeSwitch{{$obj->id}}_{{$obj->getTable()}}_{{$subject}}" name="{{$obj->id}}"
           hidden="" {{$checked ? 'checked' : ''}} wire:change.debounce.300ms="toggle($event.target.checked)">
    @component('component.switch.switchLable', ['color' => $color , 'size' => $size,'checkedIcon' => $checkedIcon])
        @slot('for')
            activeSwitch{{$obj->id}}_{{$obj->getTable()}}_{{$subject}}
        @endslot
    @endcomponent
    {{--    todo component the loading--}}
    <div wire:loading class="icon-md text-{{$color}}-500">
        @component('component.loading.loading')
        @endcomponent
    </div>


    {{--    <p wire:loading.remove>{{$name}}</p>--}}
    <script>

        document.addEventListener("livewire:initialized", () => {


            @this.
            on('toast', (event) => {
                swaltoast(event.title, event.type)
            })


        });


    </script>


</div>

