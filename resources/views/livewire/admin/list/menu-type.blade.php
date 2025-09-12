
<div class="mr-5 relative text-smid font-bold flex items-center">
    <div tabindex="1" class="haveDrop flex">
        menu type
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
             class="fill-slate-700">
            <path fill-rule="evenodd"
                  d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                  clip-rule="evenodd"/>
        </svg>
        <ul class="drop shadow-md absolute w-56 top-full-smaler-1 rounded-md p-2 DLL font-medium z-10 transall lg:left-0" >
            <div wire:loading.remove>
                @foreach($list->getMenuTypes() as $type => $name)
                    <li wire:click="setType('{{$type}}')" class="flex items-center text-sm p-2 hoverEffect rounded-md">
                        @if($list->menu_type == $type)
                            <div class="icon bg-blue-100 dark:bg-blue-400 rounded-md p-0.5 ml-1" >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="fill-blue-700" >
                                    <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif
                        {{$name}}
                    </li>
                @endforeach
            </div>

            <div class="text-center">
                {{--    todo component the loading--}}

                <li wire:loading class="loading py-10">
                    <svg  class="inline animate-spin !h-10 !w-10 text-teal-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </li>
            </div>
        </ul>
    </div>
</div>
<script>

    document.addEventListener("livewire:initialized", () => {


        @this.on('toast',(event)=>{
            Swal.fire({
                position: 'bottom-start',
                icon: event.type,
                toast: true,
                timerProgressBar: true,
                html: `<p>
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
