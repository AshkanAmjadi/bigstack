<div class="space-y-6">

    <div class="flex" wire:loading.remove>
        @include('component.pagination.livePagination',['list' => $answers,'href'=>'answers'])
    </div>
    <div id="refreshAnswers" wire:click.debounce.150ms="deleteAnswer" class="hidden" >refresh</div>
    <div class="space-y-6" wire:loading.class="hidden">
        @forelse($answers as $answer)
            @include('component.answer.answer')
        @empty
            <div class="text-elg card_c py-20 text-center">
                <p class="font-extrabold mb-6">
                    No response recorded. Be the first to record your response✍
                </p>
                @component('component.btn.btnD',['title' => 'Send the first answer','size' => 'xl' , 'iconsize' => 'md','color'=>'indigo'])
                    @slot('icon')
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m12.984 22.495l.537-.907c.416-.703.625-1.055.96-1.25c.334-.194.755-.201 1.598-.216c1.243-.021 2.023-.097 2.678-.368a4.952 4.952 0 0 0 2.68-2.68c.186-.446.28-.951.328-1.623c.025-.355.038-.533-.057-.675c-.095-.143-.275-.203-.636-.324c-1.511-.507-5.014-1.796-6.972-3.451c-2.207-1.867-4.182-5.66-4.889-7.115c-.14-.289-.21-.433-.334-.51c-.123-.076-.28-.074-.592-.071c-2.035.021-2.956.134-3.92.724A4.952 4.952 0 0 0 2.73 5.663C2 6.853 2 8.474 2 11.715v.99c0 2.307 0 3.46.377 4.37a4.952 4.952 0 0 0 2.681 2.679c.654.27 1.434.347 2.678.368c.842.015 1.264.022 1.598.216c.335.195.543.547.96 1.25l.537.907c.478.808 1.674.808 2.153 0Z" opacity=".5"/><path fill="currentColor" fill-rule="evenodd" d="M14.872.24a.766.766 0 0 1-.008 1.137l-1.102 1.014c.959.009 1.881.03 2.714.083c.715.045 1.386.114 1.97.222c.572.106 1.123.26 1.56.507a5.837 5.837 0 0 1 2 1.839c.48.721.693 1.537.794 2.52c.1.963.1 2.166.1 3.691v.042c0 .445-.387.805-.864.805c-.478 0-.865-.36-.865-.805c0-1.576 0-2.702-.091-3.578c-.09-.864-.26-1.402-.543-1.827a4.16 4.16 0 0 0-1.425-1.31c-.186-.105-.509-.214-1.004-.305a15.098 15.098 0 0 0-1.75-.195A49.94 49.94 0 0 0 13.776 4l1.088 1c.34.313.343.822.008 1.139a.91.91 0 0 1-1.222.007L11.057 3.76a.778.778 0 0 1-.257-.572c0-.215.092-.421.257-.573L13.65.232a.91.91 0 0 1 1.222.007Z" clip-rule="evenodd"/></svg>
                    @endslot
                    @slot('action')
                            onclick="AddAnswer('add')"
                    @endslot
                @endcomponent
                <div class="icon-xl w-full flex justify-center mt-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m11.985 21.449l.489-.824c.378-.64.568-.96.872-1.136c.304-.177.687-.184 1.453-.197c1.13-.02 1.84-.089 2.434-.335a4.502 4.502 0 0 0 2.438-2.435c.161-.39.247-.83.292-1.406c.027-.354.041-.53-.053-.674c-.095-.143-.276-.205-.638-.327C17.864 13.64 14.752 12.481 13 11c-1.98-1.674-3.754-5.054-4.418-6.414c-.142-.29-.213-.435-.336-.511c-.123-.076-.28-.074-.592-.07c-1.808.02-2.637.126-3.504.657a4.502 4.502 0 0 0-1.486 1.486C2 7.23 2 8.703 2 11.65v.9c0 2.096 0 3.145.343 3.972a4.502 4.502 0 0 0 2.437 2.435c.595.246 1.304.316 2.434.335c.766.013 1.15.02 1.453.197c.305.177.494.496.873 1.136l.488.824c.435.735 1.522.735 1.957 0Z"/><path fill="currentColor" fill-rule="evenodd" d="M13.702 1.217a.696.696 0 0 1-.007 1.035l-1.002.921a47.2 47.2 0 0 1 2.467.076c.65.041 1.26.104 1.79.202c.52.096 1.022.237 1.42.46c.74.418 1.363.99 1.817 1.672c.438.656.63 1.398.723 2.292c.09.875.09 1.969.09 3.355v.038c0 .404-.352.732-.786.732c-.434 0-.785-.328-.785-.732c0-1.433-.001-2.456-.084-3.253c-.08-.785-.236-1.274-.493-1.66a3.78 3.78 0 0 0-1.296-1.191c-.168-.096-.462-.195-.912-.278a13.727 13.727 0 0 0-1.59-.177a45.123 45.123 0 0 0-2.348-.072l.989.91a.696.696 0 0 1 .007 1.034a.828.828 0 0 1-1.111.006L10.234 4.42A.707.707 0 0 1 10 3.899c0-.196.084-.383.234-.52L12.59 1.21a.828.828 0 0 1 1.11.006Z" clip-rule="evenodd"/></svg>
                </div>
            </div>
        @endforelse

    </div>

    <div class="w-full" wire:loading>
        <div class="card_c icon-xl text-indigo-500 flexCC w-full pt-32 pb-40">
            <p class="w-full text-center block text-mid font-bold">loading ...</p>
            @include('component.loading.loading')
        </div>
    </div>

    <div class="flexCC" wire:loading.remove>
        @include('component.pagination.livePagination',['list' => $answers,'href'=>'answers'])
    </div>
</div>


<script>

    document.addEventListener("livewire:initialized", () => {


        @this.
        on('toAnswers', (event) => {
            document.querySelector('#toAnswers').scrollIntoView()
        })


    });


</script>

