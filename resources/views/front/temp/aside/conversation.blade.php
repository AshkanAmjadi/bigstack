
<div class="space-y-6">
    <div class="filter card_c p-6">
        <div class="title flex gap-3 items-center">
            <div class="icon-lg text-blue-500">
                @include('component.icon.discuss')
            </div>

            <div class="text-mid font-bold">
                sort
            </div>
        </div>



        @php
            $filters = \App\facade\BaseCat\BaseCat::getFilters('filter_con');
        @endphp


        <div class="space-y-5 mt-6">
            @foreach($filters as $filter => $name)

                <a href="{{route('discuss.search',['filter'=>$filter])}}" class="card_cwc relative flex rounded-md pl-3 py-3 blueHover" target="_blank" rel="nofollow noreferrer noopener">
                    <div class="pr-3 flex items-center gap-3 translate-x-4">
                        <div class="p-1.5 rounded-md bg-blue-500 right-0 top-0">
                            <div class="icon-sm text-white">
                                @include('component.icon.filter')
                            </div>
                        </div>
                        <h4 class="text-smid font-bold pr">{{$name}}</h4>
                    </div>
                    <span class="indicator absolute w-1 h-1/2 rounded-r-full bg-blue-500 left-0 top-1/2 translate-y-1/2-"></span>

                </a>

            @endforeach
        </div>



    </div>

    <div class="relate card_c p-6">
        <div class="title flex gap-3 items-center">
            <div class="icon-lg text-amber-500">
                @include('component.icon.discuss')
            </div>

            <div class="text-mid font-bold">
                relate
            </div>
        </div>



        @php
            $related = $conversation->related;
        @endphp


        <div class="space-y-5 mt-6">
            @foreach($related as $con)

                <a href="{{route('conversation.show',['conversation'=>$con->slug])}}" class="card_cwc relative flex rounded-md pl-3 py-3 amberHover">
                    <div class="pr-3 flex items-center gap-3 translate-x-4">
                        <div class="p-1.5 rounded-md bg-amber-500 right-0 top-0">
                            <div class="icon-sm text-white">
                                @include('component.icon.discuss',['st'=> '1.5'])
                            </div>
                        </div>
                        <h4 class="text-smid font-bold pr">{{$con->title}}</h4>
                    </div>
                    <span class="indicator absolute w-1 h-1/2 rounded-r-full bg-amber-500 left-0 top-1/2 translate-y-1/2-"></span>

                </a>

            @endforeach
        </div>



    </div>

    <div class="tags card_c p-6">
        <div class="title flex gap-3 items-center">
            <div class="icon-lg text-blue-500">
                @include('component.icon.tag')
            </div>

            <div class="text-mid font-bold">
                category
            </div>
        </div>



        @php
            $searchable = \App\facade\BaseCat\BaseCat::getAllSearchTag();
        @endphp


        <div class="space-y-5 mt-6">
            @foreach($searchable as $tag)

                <a href="{{url('/')}}/discussions?tags[0]={{$tag->name}}" class="card_cwc relative flex rounded-md pl-3 py-3 blueHover" target="_blank" rel="nofollow noreferrer noopener">
                    <div class="pr-3 flex items-center gap-3 translate-x-4">
                        <div class="p-1.5 rounded-md bg-blue-500 right-0 top-0">
                            <div class="icon-sm text-white">
                                @include('component.icon.tag')

                            </div>
                        </div>
                        <h4 class="text-smid font-bold pr">{{$tag->name}}</h4>
                    </div>
                    <span class="indicator absolute w-1 h-1/2 rounded-r-full bg-blue-500 left-0 top-1/2 translate-y-1/2-"></span>

                </a>

            @endforeach
        </div>



    </div>
</div>
