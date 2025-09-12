<section class="author card_c p-5 mb-4">

    <div class="w-full flexBC gap-2">
        @include('user::front.component.who' , ['relation' => 'added_by','subject' => $article])
        <div class="marks flex flex-row-reverse gap-3 md:gap-1">
            @livewire('markable.like',['obj'=>$article],key($article->getTable() .'_like_' . $article->id))
            @livewire('markable.mark',['obj'=>$article],key($article->getTable() .'_mark_' . $article->id))
            <a href="#aricleComments" class="flex items-center">
                @component('front.components.icon.numIcon',['number' => $article->commentNum,'color'=>'emerald'])
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24">
                        <path fill="currentColor" fill-rule="evenodd"
                              d="m13.629 20.472l-.542.916c-.483.816-1.69.816-2.174 0l-.542-.916c-.42-.71-.63-1.066-.968-1.262c-.338-.197-.763-.204-1.613-.219c-1.256-.021-2.043-.098-2.703-.372a5 5 0 0 1-2.706-2.706C2 14.995 2 13.83 2 11.5v-1c0-3.273 0-4.91.737-6.112a5 5 0 0 1 1.65-1.651C5.59 2 7.228 2 10.5 2h3c3.273 0 4.91 0 6.113.737a5 5 0 0 1 1.65 1.65C22 5.59 22 7.228 22 10.5v1c0 2.33 0 3.495-.38 4.413a5 5 0 0 1-2.707 2.706c-.66.274-1.447.35-2.703.372c-.85.015-1.275.022-1.613.219c-.338.196-.548.551-.968 1.262ZM8 11.75a.75.75 0 0 0 0 1.5h5.5a.75.75 0 0 0 0-1.5H8ZM7.25 9A.75.75 0 0 1 8 8.25h8a.75.75 0 0 1 0 1.5H8A.75.75 0 0 1 7.25 9Z"
                              clip-rule="evenodd"/>
                    </svg>
                @endcomponent
            </a>
        </div>
    </div>

    @livewire('markable.star',['obj'=>$article],key($article->getTable() .'_star_' . $article->id))


</section>
