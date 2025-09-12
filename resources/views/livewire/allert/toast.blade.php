<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
</div>
<script>

    document.addEventListener("livewire:initialized", () => {


        @this.on('toast',(event)=>{
            swaltoast(event.title,event.type)
        })

    });



</script>




