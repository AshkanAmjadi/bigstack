<div class="switchWraper flex mr-5">
    <input type="checkbox"
           id="footer{{$list->id}}" name="{{$list->id}}"
           hidden="" {{$checked ? 'checked' : ''}} wire:change.debounce.300ms="toggle($event.target.checked)">
    @component('component.switch.switchLable', ['color' => 'blue'])
        @slot('for')footer{{$list->id}}@endslot
    @endcomponent
    {{--    todo component the loading--}}

    <div wire:loading class="icon-md text-blue-500">
        @component('component.loading.loading')
        @endcomponent
    </div>
    <p wire:loading.remove>{{$name}}</p>
    <script>

        document.addEventListener("livewire:initialized", () => {


            @this.on('toast',(event)=>{
                Swal.fire({
                    position: 'bottom-start',
                    icon: event.type,
                    toast: true,
                    timerProgressBar: true,
                    html: `<p class="font-bold">
                ${event.title}
                </p>`,
                    showConfirmButton: false,
                    timer: 5000,
                    customClass: {
                        popup: 'colored-toast'
                    }
                })
            })


        });



    </script>


</div>

