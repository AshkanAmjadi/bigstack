<div class="w-full card_c p-3">

    <div class="">
        <div class="right ">
            <div class="img -translate-y-5 overflow-hidden rounded-lg shadow-custom_gray w-full">
                <a href="{{route('article.show',['article'=>$subject->slug])}}" class="">
                    <img src="{{semanticImgUrlMaker($subject,'img')}}" class="w-full" alt="{{$subject->alt ? : $subject->page_title}}">
                </a>
            </div>

        </div>
        <div class="left px-2 flex-col">
            <a href="{{route('article.show',['article'=>$subject->slug])}}" class="text-mid font-bold ">
                {{$subject->page_title}}
            </a>
            @if($want == 'star')
                <div class="flexBC gap-2 my-2">
                    <div class="r flexC">
                        @component('front.components.icon.numIcon',['iconSize' => 'fsm' , 'color' =>'amber'])
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-amber-400" width="24" height="24"
                                 viewBox="0 0 24 24">
                                <path fill="currentColor"
                                      d="M9.153 5.408C10.42 3.136 11.053 2 12 2c.947 0 1.58 1.136 2.847 3.408l.328.588c.36.646.54.969.82 1.182c.28.213.63.292 1.33.45l.636.144c2.46.557 3.689.835 3.982 1.776c.292.94-.546 1.921-2.223 3.882l-.434.507c-.476.557-.715.836-.822 1.18c-.107.345-.071.717.001 1.46l.066.677c.253 2.617.38 3.925-.386 4.506c-.766.582-1.918.051-4.22-1.009l-.597-.274c-.654-.302-.981-.452-1.328-.452c-.347 0-.674.15-1.329.452l-.595.274c-2.303 1.06-3.455 1.59-4.22 1.01c-.767-.582-.64-1.89-.387-4.507l.066-.676c.072-.744.108-1.116 0-1.46c-.106-.345-.345-.624-.821-1.18l-.434-.508c-1.677-1.96-2.515-2.941-2.223-3.882c.293-.941 1.523-1.22 3.983-1.776l.636-.144c.699-.158 1.048-.237 1.329-.45c.28-.213.46-.536.82-1.182l.328-.588Z"></path>
                            </svg>
                            @slot('number')
                                {{ round($subject->stars_avg_tact_value,1)}}
                            @endslot
                        @endcomponent

                    </div>
                    <div class="l flexC">
                        @if($item->tact_value == 5)
                            <div class="star1 cursor-pointer flex flex-col items-center text-amber-400">
                                @include('component.star.stars')
                                <p class="font-extrabold text-smid">awesome</p>
                            </div>
                        @elseif($item->tact_value == 4)
                            <div class="star2 cursor-pointer flex flex-col items-center text-green-500">
                                @include('component.star.star')
                                <p class="font-extrabold text-smid">greate</p>
                            </div>
                        @elseif($item->tact_value == 3)
                            <div class="star3 cursor-pointer flex flex-col items-center text-green-400">
                                @include('component.star.star')
                                <p class="font-extrabold text-smid">good</p>
                            </div>
                        @elseif($item->tact_value == 2)
                            <div class="star4 cursor-pointer flex flex-col items-center text-orange-400">
                                @include('component.star.star')
                                <p class="font-extrabold text-smid">bad</p>
                            </div>
                        @elseif($item->tact_value == 1)
                            <div class="star5 cursor-pointer flex flex-col items-center text-rose-600">
                                @include('component.star.star')
                                <p class="font-extrabold text-smid">the worst</p>
                            </div>
                        @endif

                    </div>
                </div>
            @endif

        </div>
    </div>
    <div class="flexBC">
        <div class="marks flex flex-row-reverse ">
            @if($want == 'bookmark')

                @livewire('markable.mark',['obj'=>$subject,'iconSize'=>'sm'],key($subject->getTable() .'_mark_' . $subject->id))
            @endif

            @if($want == 'like')

                @livewire('markable.like',['obj'=>$subject,'iconSize'=>'sm'],key($subject->getTable() .'_like_' . $subject->id))
            @endif


        </div>
    </div>

</div>
