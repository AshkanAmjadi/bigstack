<article class="w-full grid grid-cols-8 card_c p-3 items-center">
    <div class="right col-span-2 lg:col-span-3">
        <div class="img overflow-hidden rounded-lg shadow-custom_gray w-full">
            <a href="{{route('article.show',['article'=>$subject->slug])}}" class="">
                <img src="{{semanticImgUrlMaker($subject,'img')}}" class="w-full" alt="{{$subject->alt ? : $subject->page_title}}">
            </a>
        </div>

    </div>

    <div class="left py-3 pr-2 pl-2 space-y-3 lg:py-1 lg:space-y-1 col-span-6 lg:col-span-5">
        <a href="{{route('article.show',['article'=>$subject->slug])}}" class="text-mid font-bold">
            <h3>
                {{$subject->page_title}}
            </h3>
        </a>
        <div class="flex flex-wrap gap-2">
            @if($subject->level == 0)

            @elseif($subject->level == 1)
                @component('component.badg.badg' ,['color' => 'teal'])
                    @slot('title') Starter @endslot
                @endcomponent
            @elseif($subject->level == 2)
                @component('component.badg.badg' ,['color' => 'orange'])
                    @slot('title') Mid level @endslot
                @endcomponent
            @elseif($subject->level == 3)
                @component('component.badg.badg' ,['color' => 'red'])
                    @slot('title') Advanced @endslot
                @endcomponent
            @endif

            @foreach($subject->tags()->limit(2)->get() as $tag)
                @component('component.badg.badg' ,['color' => 'indigo'])
                    @slot('title') #{{$tag->name}} @endslot
                @endcomponent
            @endforeach
        </div>

        <div class="marks flex flex-row-reverse ">
            @livewire('markable.like',['obj'=>$subject],key($subject->getTable() .'_like_' . $subject->id))
            @livewire('markable.mark',['obj'=>$subject],key($subject->getTable() .'_mark_' . $subject->id))
        </div>
    </div>
</article>
