<article class="w-full grid grid-cols-1 card_c p-3">

    <div class="right">
        <div class="img -translate-y-5 overflow-hidden rounded-lg shadow-custom_gray w-full">
            <a href="{{route('project.show',['project'=>$subject->slug])}}" class="w-full">
                <img src="{{semanticImgUrlMaker($subject,'img')}}" class="w-full" alt="{{$subject->page_title}}">
            </a>
        </div>

    </div>
    <div class="left px-2">
        <a href="{{route('project.show',['project'=>$subject->slug])}}" class="text-mid font-bold ">
            {{$subject->title}}
        </a>
        <div class="flex flex-wrap gap-2">
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
        <p class="text-fsm font-light line-clamp-3 mt-2 mb-4">
            {{$subject->meta_description}}
        </p>

    </div>
    <div class="flex flex-wrap gap-2 mb-3">

        @foreach($subject->tags as $tag)
            <a href="{{route('tag.show',['tag'=>$tag->name,'subject'=>'project'])}}">
                @component('component.badg.badg' ,['color' => 'indigo'])
                    @slot('title') #{{$tag->name}} @endslot
                @endcomponent
            </a>
        @endforeach
    </div>
    <div class="flexBC">
        <div class="r">
            @php($service =  $subject->service)
            @component('component.btn.linkBtn',['size' => 'sm','bold' => 'true'])
                @slot('href')
                    {{route('project.search',['service'=>$service->name])}}
                @endslot
                @slot('preTitle')
                    {{$service->name}}
                @endslot
                @slot('icon')
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round"
                                  d="m15.5 9l.172.172c1.333 1.333 2 2 2 2.828c0 .828-.667 1.495-2 2.828L15.5 15m-2.206-7.83L12 12l-1.294 4.83M8.5 9l-.172.172c-1.333 1.333-2 2-2 2.828c0 .828.667 1.495 2 2.828L8.5 15"/>
                            <path
                                d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"
                                opacity="0.5"/>
                        </g>
                    </svg>
                @endslot
            @endcomponent
        </div>
        <div class="marks flex flex-row-reverse ">
            @livewire('markable.like',['obj'=>$subject,'iconSize'=>'sm'],key(''.now().''))
            @livewire('markable.mark',['obj'=>$subject,'iconSize'=>'sm'],key(''.now().''))
        </div>
    </div>

</article>
