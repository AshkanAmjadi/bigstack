<div id="aricleComments" class="comments space-y-6 pt-4">
    <div id="refreshComments" wire:click.debounce.150ms="refresh"></div>
    <div  class="title mt-5 flex flex-wrap justify-between items-center">
        <div id="startComment" class="flex text-lg  gap-3 font-bold items-center"  wire:click="start">
            <div class="icon-lg text-emerald-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <g fill="none">
                        <path fill="currentColor"
                              d="m13.087 21.388l.645.382l-.645-.382Zm.542-.916l-.646-.382l.646.382Zm-3.258 0l-.645.382l.645-.382Zm.542.916l.646-.382l-.646.382Zm-8.532-5.475l.693-.287l-.693.287Zm5.409 3.078l-.013.75l.013-.75Zm-2.703-.372l-.287.693l.287-.693Zm16.532-2.706l.693.287l-.693-.287Zm-5.409 3.078l-.012-.75l.012.75Zm2.703-.372l.287.693l-.287-.693Zm.7-15.882l-.392.64l.392-.64Zm1.65 1.65l.64-.391l-.64.392ZM4.388 2.738l-.392-.64l.392.64Zm-1.651 1.65l-.64-.391l.64.392ZM9.403 19.21l.377-.649l-.377.649Zm4.33 2.56l.541-.916l-1.29-.764l-.543.916l1.291.764Zm-4.007-.916l.542.916l1.29-.764l-.541-.916l-1.291.764Zm2.715.152a.52.52 0 0 1-.882 0l-1.291.764c.773 1.307 2.69 1.307 3.464 0l-1.29-.764ZM10.5 2.75h3v-1.5h-3v1.5Zm10.75 7.75v1h1.5v-1h-1.5Zm-18.5 1v-1h-1.5v1h1.5Zm-1.5 0c0 1.155 0 2.058.05 2.787c.05.735.153 1.347.388 1.913l1.386-.574c-.147-.352-.233-.782-.278-1.441c-.046-.666-.046-1.51-.046-2.685h-1.5Zm6.553 6.742c-1.256-.022-1.914-.102-2.43-.316L4.8 19.313c.805.334 1.721.408 2.977.43l.026-1.5ZM1.688 16.2A5.75 5.75 0 0 0 4.8 19.312l.574-1.386a4.25 4.25 0 0 1-2.3-2.3l-1.386.574Zm19.562-4.7c0 1.175 0 2.019-.046 2.685c-.045.659-.131 1.089-.277 1.441l1.385.574c.235-.566.338-1.178.389-1.913c.05-.729.049-1.632.049-2.787h-1.5Zm-5.027 8.241c1.256-.021 2.172-.095 2.977-.429l-.574-1.386c-.515.214-1.173.294-2.428.316l.025 1.5Zm4.704-4.115a4.25 4.25 0 0 1-2.3 2.3l.573 1.386a5.75 5.75 0 0 0 3.112-3.112l-1.386-.574ZM13.5 2.75c1.651 0 2.837 0 3.762.089c.914.087 1.495.253 1.959.537l.783-1.279c-.739-.452-1.577-.654-2.6-.752c-1.012-.096-2.282-.095-3.904-.095v1.5Zm9.25 7.75c0-1.622 0-2.891-.096-3.904c-.097-1.023-.299-1.862-.751-2.6l-1.28.783c.285.464.451 1.045.538 1.96c.088.924.089 2.11.089 3.761h1.5Zm-3.53-7.124a4.25 4.25 0 0 1 1.404 1.403l1.279-.783a5.75 5.75 0 0 0-1.899-1.899l-.783 1.28ZM10.5 1.25c-1.622 0-2.891 0-3.904.095c-1.023.098-1.862.3-2.6.752l.783 1.28c.464-.285 1.045-.451 1.96-.538c.924-.088 2.11-.089 3.761-.089v-1.5ZM2.75 10.5c0-1.651 0-2.837.089-3.762c.087-.914.253-1.495.537-1.959l-1.279-.783c-.452.738-.654 1.577-.752 2.6C1.25 7.61 1.25 8.878 1.25 10.5h1.5Zm1.246-8.403a5.75 5.75 0 0 0-1.899 1.899l1.28.783a4.25 4.25 0 0 1 1.402-1.403l-.783-1.279Zm7.02 17.993c-.202-.343-.38-.646-.554-.884a2.229 2.229 0 0 0-.682-.645l-.754 1.297c.047.028.112.078.224.232c.121.166.258.396.476.764l1.29-.764Zm-3.24-.349c.44.008.718.014.93.037c.198.022.275.054.32.08l.754-1.297a2.244 2.244 0 0 0-.909-.274c-.298-.033-.657-.038-1.069-.045l-.025 1.5Zm6.498 1.113c.218-.367.355-.598.476-.764c.112-.154.177-.204.224-.232l-.754-1.297c-.29.17-.5.395-.682.645c-.173.238-.352.54-.555.884l1.291.764Zm1.924-2.612c-.412.007-.771.012-1.069.045c-.311.035-.616.104-.909.274l.754 1.297c.045-.026.122-.058.32-.08c.212-.023.49-.03.93-.037l-.026-1.5Z"/>
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5"
                              d="M8 9h8m-8 3.5h5.5" opacity=".5"/>
                    </g>
                </svg>
            </div>
            <h2>
                comments and question
            </h2>
        </div>
        <div class="right">
            @component('component.btn.btnD',['title' => 'send your comment','size' => 'lg' , 'iconsize' => 'md','color'=>'emerald'])
                @slot('icon')
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor"
                              d="m13.629 20.472l-.542.916c-.483.816-1.69.816-2.174 0l-.542-.916c-.42-.71-.63-1.066-.968-1.262c-.338-.197-.763-.204-1.613-.219c-1.256-.021-2.043-.098-2.703-.372a5 5 0 0 1-2.706-2.706C2 14.995 2 13.83 2 11.5v-1c0-3.273 0-4.91.737-6.112a5 5 0 0 1 1.65-1.651C5.59 2 7.228 2 10.5 2h3c3.273 0 4.91 0 6.113.737a5 5 0 0 1 1.65 1.65C22 5.59 22 7.228 22 10.5v1c0 2.33 0 3.495-.38 4.413a5 5 0 0 1-2.707 2.706c-.66.274-1.447.35-2.703.372c-.85.015-1.275.022-1.613.219c-.338.196-.548.551-.968 1.262Z"
                              opacity=".5"/>
                        <path fill="currentColor"
                              d="M7.25 9A.75.75 0 0 1 8 8.25h8a.75.75 0 0 1 0 1.5H8A.75.75 0 0 1 7.25 9Zm0 3.5a.75.75 0 0 1 .75-.75h5.5a.75.75 0 0 1 0 1.5H8a.75.75 0 0 1-.75-.75Z"/>
                    </svg>
                @endslot
                @slot('action')
                    onclick="AddComment()"
                @endslot
            @endcomponent
        </div>
    </div>

    @if($show)

        <div class="flex flex-row-reverse" wire:loading.remove>
            @include('component.pagination.livePagination',['list' => $comments,'href'=>'aricleComments'])
        </div>

        <div wire:loading.remove class="space-y-6">
            @include('content::front.article.comments',['comments'=>$comments])
        </div>


        <div class="flexCC" wire:loading.remove>
            @include('component.pagination.livePagination',['list' => $comments,'href'=>'aricleComments'])
        </div>

    @else

        <div class="w-full" wire:loading.remove>
            <div class="card_c icon-xl text-emerald-500 flexCC w-full pt-32 pb-40">
                <p class="w-full text-center block text-mid font-bold">loading ...</p>
                @include('component.loading.loading')
            </div>
        </div>

    @endif
    <div class="w-full" wire:loading>
        <div class="card_c icon-xl text-emerald-500 flexCC w-full pt-32 pb-40">
            <p class="w-full text-center block text-mid font-bold">loading ...</p>
            @include('component.loading.loading')
        </div>
    </div>

</div>

<script>

    document.addEventListener("livewire:initialized", () => {


        @this.
        on('toComments', (event) => {
            document.querySelector('#toComments').click()
        })


    });


</script>
