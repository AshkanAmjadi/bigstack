<div>
    @if($show)
        @forelse($comments as $comment)

            <div class="childes space-y-6 pr-4 md:pr-2  !mt-0 py-3 border-r-2 border-teal-400 mr-4 md:mr-2">
                @livewire('comment.comment',['comment' => $comment],key('comment.'.$comment->id))
            </div>

        @empty
            @include('component.divider.divider')
        @endforelse
    @else
        <div class="divider relative !my-10 ">
            <div class="icon-lg absolute text-teal-500 -top-7 right-10 z-10 translate-y-1/2- translate-x-1/2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M5 6.25a.75.75 0 0 0-.488 1.32l7 6c.28.24.695.24.976 0l7-6A.75.75 0 0 0 19 6.25H5Z" opacity=".5"/><path fill="currentColor" fill-rule="evenodd" d="M4.43 10.512a.75.75 0 0 1 1.058-.081L12 16.012l6.512-5.581a.75.75 0 1 1 .976 1.139l-7 6a.75.75 0 0 1-.976 0l-7-6a.75.75 0 0 1-.081-1.058Z" clip-rule="evenodd"/></svg>
            </div>
            <div class="absolute top-1/2 translate-y-1/2- right-0" wire:click.debounce.150ms="showComment" wire:loading.remove>
                @component('component.btn.btnD',[])
                    @slot('title')
                        more ({{$count}})
                    @endslot
                @endcomponent
            </div>
            <div class=" absolute top-1/2 translate-y-1/2- right-0" wire:loading>
                @component('component.btn.btnD',[])
                    @slot('icon')
                        @include('component.loading.loading')
                    @endslot
                @endcomponent
            </div>
        </div>
    @endif
</div>
