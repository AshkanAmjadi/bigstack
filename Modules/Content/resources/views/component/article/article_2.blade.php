<article class="w-full grid grid-cols-1 card_c p-3">

    <div class="right">
        <div class="img -translate-y-5 overflow-hidden rounded-lg shadow-custom_gray w-full">
            <a href="{{route('article.show',['article'=>$subject->slug])}}" class="w-full">
                <img src="{{semanticImgUrlMaker($subject,'img')}}" class="w-full" alt="{{$subject->alt ? : $subject->page_title}}">
            </a>
        </div>

    </div>
    <div class="left px-2">
        <a href="{{route('article.show',['article'=>$subject->slug])}}" class="text-mid font-bold ">
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


        </div>
        <p class="text-fsm font-light line-clamp-3 mt-2 mb-4">
            {{$subject->meta_description}}
        </p>

    </div>
    <div class="flexBC">
        <div class="r">
            @isset($cat)
                @php($category =  $subject->cat)
                @component('component.btn.linkBtn',['color'=>'indigo','size' => 'sm','bold' => 'true'])
                    @slot('href')
                        {{route('category.show',['category'=>$category->name])}}
                    @endslot
                    @slot('preTitle')
                        {{$category->name}}
                    @endslot
                    @slot('icon')
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm" width="24" height="24" viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-width="2.5">
                                <path
                                    d="M18 6v4.853c0 .29 0 .435-.095.494c-.095.058-.224-.007-.484-.136l-1.242-.622c-.088-.043-.132-.065-.179-.065c-.047 0-.091.022-.179.065l-1.242.622c-.26.13-.39.194-.484.136c-.095-.06-.095-.204-.095-.494V6"
                                    opacity=".5"/>
                                <path
                                    d="M2 6.95c0-.883 0-1.324.07-1.692A4 4 0 0 1 5.257 2.07C5.626 2 6.068 2 6.95 2c.386 0 .58 0 .766.017a4 4 0 0 1 2.18.904c.144.119.28.255.554.529L11 4c.816.816 1.224 1.224 1.712 1.495a4 4 0 0 0 .848.352C14.098 6 14.675 6 15.828 6h.374c2.632 0 3.949 0 4.804.77c.079.07.154.145.224.224c.77.855.77 2.172.77 4.804V14c0 3.771 0 5.657-1.172 6.828C19.657 22 17.771 22 14 22h-4c-3.771 0-5.657 0-6.828-1.172C2 19.657 2 17.771 2 14V6.95Z"/>
                            </g>
                        </svg>
                    @endslot
                @endcomponent
            @endisset
        </div>
        <div class="marks flex flex-row-reverse ">
            @livewire('markable.like',['obj'=>$subject,'iconSize'=>'sm'],key($subject->getTable() .'_like_' . $subject->id))
            @livewire('markable.mark',['obj'=>$subject,'iconSize'=>'sm'],key($subject->getTable() .'_mark_' . $subject->id))
        </div>
    </div>

</article>
