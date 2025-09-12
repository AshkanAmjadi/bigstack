<div class="w-full relative h-full flex flex-col justify-between card_c p-4 @if(super() and !$subject->active) ring-4 ring-red-600
@endif">

    @if(mobileDevice())
        <div class="absolute top-3 left-3 sm-r:hidden">
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
    @endif
    <div class="sm:flex">
        <div class="right ">
            <div class="img relative -translate-y-8 fsm:-translate-y-0 overflow-hidden rounded-lg shadow-custom_gray w-full sm:w-[150px] fsm:w-[125px]">

                <a href="{{route('article.show',['article'=>$subject->slug])}}" class="">
                    <img src="{{semanticImgUrlMaker($subject,'img')}}" class="w-full" alt="{{$subject->alt ? : $subject->page_title}}">
                </a>

                @if(!mobileDevice())
                    <div class="absolute top-2 left-2 sm:hidden">
                        @if($subject->level == 0)

                        @elseif($subject->level == 1)
                            @component('component.badg.badg' ,['color' => 'teal','shadow' => false])
                                @slot('title') Starter @endslot
                            @endcomponent
                        @elseif($subject->level == 2)
                            @component('component.badg.badg' ,['color' => 'orange','shadow' => false])
                                @slot('title') Mid level @endslot
                            @endcomponent
                        @elseif($subject->level == 3)
                            @component('component.badg.badg' ,['color' => 'red','shadow' => false])
                                @slot('title') Advanced @endslot
                            @endcomponent
                        @endif
                    </div>
                @endif
            </div>

        </div>
        <div class="left px-2 inline-flex flex-col w-full">
            @if(super() and !$subject->active)
                <div class="text-mid text-red-600 font-extrabold">
                    غیر فعال
                </div>
            @endif

            <a href="{{route('article.show',['article'=>$subject->slug])}}" class="text-mid font-bold mb-3 fsm:mt-3">
                <h3>
                    {{$subject->title}}
                </h3>
            </a>
            <div class="flexBC gap-2">
                <div class="r flexC">
                    @if($subject->stars_avg_tact_value)
                        @component('front.components.icon.numIcon',['iconSize' => 'fsm' , 'color' =>'amber'])
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-amber-400" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M9.153 5.408C10.42 3.136 11.053 2 12 2c.947 0 1.58 1.136 2.847 3.408l.328.588c.36.646.54.969.82 1.182c.28.213.63.292 1.33.45l.636.144c2.46.557 3.689.835 3.982 1.776c.292.94-.546 1.921-2.223 3.882l-.434.507c-.476.557-.715.836-.822 1.18c-.107.345-.071.717.001 1.46l.066.677c.253 2.617.38 3.925-.386 4.506c-.766.582-1.918.051-4.22-1.009l-.597-.274c-.654-.302-.981-.452-1.328-.452c-.347 0-.674.15-1.329.452l-.595.274c-2.303 1.06-3.455 1.59-4.22 1.01c-.767-.582-.64-1.89-.387-4.507l.066-.676c.072-.744.108-1.116 0-1.46c-.106-.345-.345-.624-.821-1.18l-.434-.508c-1.677-1.96-2.515-2.941-2.223-3.882c.293-.941 1.523-1.22 3.983-1.776l.636-.144c.699-.158 1.048-.237 1.329-.45c.28-.213.46-.536.82-1.182l.328-.588Z"></path>
                            </svg>
                            @slot('number')
                                {{ round($subject->stars_avg_tact_value,1)}}
                            @endslot
                        @endcomponent
                    @endif

                </div>
                <div class="l">
                    <p class="text-fnesm card_cwc py-0.5 px-2">
                        <span class="text-fesm opacity-75">
                            Last moified:
                        </span>
                        {{persianDateOld($subject->updated_at)}}
                    </p>
                </div>


            </div>


        </div>
    </div>
    <div class="flexBC mt-3">
        <p class="w-full indent-3 opacity-90 text-fsm font-light line-clamp-3 sm:line-clamp-2 mb-2">
            {{$subject->meta_description}}
        </p>
        <div class="r pr-1">
            @isset($cat)
                @php($category =  $subject->cat)
                @include('component.breadcrump.link',['link' => route('category.show',['category'=>$category->slug]),'icon'=>'category','title'=>$category->title])
            @endisset
        </div>
        <div class="marks flex flex-row-reverse ">
            @livewire('markable.mark',['obj'=>$subject,'iconSize'=>'sm'],key($subject->getTable() .'_mark_' . $subject->id))
            @include('component.divider.hDivider')
            @livewire('markable.like',['obj'=>$subject,'iconSize'=>'sm'],key($subject->getTable() .'_like_' . $subject->id))


        </div>
    </div>

</div>
