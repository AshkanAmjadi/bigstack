<div>
    <form class="bg-slate-200 dark:bg-slate-800  w-full rounded-xl relative mb-2 flex">
        <div id="searchBtn" class="p-5" wire:click.debounce.100ms="setSearch(getValueOfSearch('searchInput'))">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                 class="fill-slate-500 dark:fill-slate-400 inline">
                <path fill-rule="evenodd"
                      d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z"
                      clip-rule="evenodd"/>
            </svg>
        </div>
        <input id="searchInput" type="search"
               class="text-sm  w-full bg-slate-200 dark:bg-slate-800 py-5"
               oninput="ifUpTo3Click(this,'searchBtn','mustSet3')" placeholder="what ar you looking for?">


        <div class="p-5 cursor-pointer" onclick="closeMainsearch()">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"
                 class="fill-slate-500 dark:fill-slate-400 inline">
                <g fill="none">
                    <path fill="currentColor" d="M20 12.75a.75.75 0 0 0 0-1.5zm0-1.5H4v1.5h16z" opacity="0.5"/>
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="m10 6l-6 6l6 6"/>
                </g>
            </svg>
        </div>

    </form>
    <div class="loader w-full h-full absolute top-0 left-0 flex justify-center items-center pointer-events-none"
         wire:loading.class.remove="pointer-events-none">

        <div class="icon-2xl text-blue-500" wire:loading>
            @include('component.loading.loading')

        </div>

    </div>

    <div id="mustSet3" class="card_c flex justify-center mb-2 p-2 py-6 @if($show) hidden @endif">
        <div class="font-bold text-smid">Enter at least 3 letters to search🔎</div>
    </div>


    @if($show)

        <div class="select_subject flex items-center mt-2 gap-3">

            @foreach($subjects as $sbj => $name_fa)

                <div
                    @if($subject !== $sbj) wire:click.debounce.200ms="goToSubject('{{$sbj}}',getValueOfSearch('searchInput'))"
                    @endif  class="cursor-pointer @if($subject == $sbj) bg-blue-500 text-white @else bg-blue-500/60 text-white/80 @endif text-sm font-bold p-2 pt-2.5 px-4 rounded-lg">
                    {{$name_fa}}
                </div>

            @endforeach

        </div>

        <div class="result">

            @if($subject == 'article')

                @forelse($items as $item)

                    <article>
                        <a href="{{route('article.show',['article'=>$item->slug])}}" rel="nofollow noreferrer noopener" target="_blank"
                           class="flex items-center gap-2 p-4 pl-7 my-4 card_cwc rounded-xl md:p-2.5 md:pl-4">

                            <div class="w-32 border-4 dark:border-slate-700 rounded-lg overflow-hidden flex justify-center">
                                @if($item->img)
                                    <img class="w-full" src="{{semanticImgUrlMaker($item,'img')}}" alt="">
                                @else
                                    <div class="font-bold text-smid flex flex-wrap gap-1 opacity-50 my-5">
                                        no image
                                    </div>
                                @endif
                            </div>
                            <h3 class="p-normal font-bold text-smid w-full p-0">{{$item->title}}</h3>
                            <div class=" text-blue-500 flex flex-col ">
                                <div class="font-extrabold text-smid">Article</div>
                                <div class="icon-md">
                                    @include('component.icon.article')
                                </div>
                            </div>


                        </a>
                    </article>

                @empty
                    @include('component.notFound.notFound',['card' => false])
                @endforelse

                @if($items->pluck('cat_name','cat_slug')->unique()->first())
                    @include('component.divider.divider')
                    <div class="text-lg font-bold mt-4 mr-5">
                        More articles in the category:
                    </div>
                    <div class="flex flex-wrap mt-3 items-center w-full gap-2">
                        @foreach($items->pluck('cat_name','cat_slug')->unique() as $slug => $category)
                            <a href="{{route('category.show',['category'=>$slug])}}" rel="nofollow noreferrer noopener" target="_blank"
                               class="card_cwc rounded-xl flex items-center p-4 gap-2">
                                <div class="icon-md text-indigo-500">
                                    @include('component.icon.category')
                                </div>
                                <div class="p-normal font-extrabold text-smid">{{$category}}</div>
                            </a>
                        @endforeach
                    </div>

                @endif

            @elseif($subject == 'project')

                @forelse($items as $item)

                    <article>
                        <a href="{{route('project.show',['project'=>$item->slug])}}" rel="nofollow noreferrer noopener" target="_blank"
                           class="flex items-center gap-2 p-4 pl-7 my-4 card_cwc rounded-xl md:p-2.5 md:pl-4">

                            <div class="w-32 border-4 dark:border-slate-700 rounded-lg overflow-hidden flex justify-center">
                                @if($item->img)
                                    <img class="w-full" src="{{semanticImgUrlMaker($item,'img')}}" alt="">
                                @else
                                    <div class="font-bold text-smid flex flex-wrap gap-1 opacity-50 my-5">
                                        no image
                                    </div>
                                @endif
                            </div>
                            <h3 class="p-normal font-bold text-smid w-full">{{$item->title}}</h3>
                            <div class=" text-blue-500 flex flex-col ">
                                <div class="font-extrabold text-smid">Projects</div>
                                <div class="icon-md">
                                    @include('component.icon.project')
                                </div>
                            </div>
                        </a>
                    </article>

                @empty
                    @include('component.notFound.notFound',['card' => false])
                @endforelse

                @if($items->pluck('srvc_name')->unique()->first())
                    @include('component.divider.divider')
                    <div class="text-lg font-bold mt-4 mr-5">
                        More projects in services:
                    </div>
                    <div class="flex flex-wrap mt-3 items-center w-full gap-2">
                        @foreach($items->pluck('srvc_name')->unique() as $srvc)
                            <a href="{{route('project.search',['service'=>$srvc])}}" rel="nofollow noreferrer noopener" target="_blank"
                               class="card_cwc rounded-xl flex items-center p-4 gap-2">
                                <div class="icon-md text-blue-500">
                                    @include('component.icon.service')
                                </div>
                                <p class="p-normal font-extrabold text-smid">{{$srvc}}</p>
                            </a>
                        @endforeach
                    </div>

                @endif

            @elseif($subject == 'tag')

                @forelse($items as $item)

                    <articel>
                        <a href="{{route('tag.show',['tag'=>$item->name])}}" rel="nofollow noreferrer noopener" target="_blank"
                           class="flex items-center gap-2 p-6 my-4 card_cwc rounded-xl md:p-5">

                            <div class="p-normal font-extrabold text-nsmid w-full">{{$item->name}}</div>
                            <div class=" text-blue-500 flex flex-col ">
                                <div class="icon-md">
                                    @include('component.icon.tag')
                                </div>
                            </div>


                        </a>
                    </articel>

                @empty
                    @include('component.notFound.notFound',['card' => false])
                @endforelse

            @elseif($subject == 'discuss')

                @forelse($items as $item)

                    <article>
                        <a href="{{route('conversation.show',['conversation'=>$item->slug])}}" rel="nofollow noreferrer noopener" target="_blank"
                           class="flex items-center gap-2 p-6 pl-7 my-4 card_cwc rounded-xl md:p-2.5 md:pl-4">

                            <div class="flex items-center">
                                <div class="avatar xl">
                                    <img class="pointer-events-none"
                                         src="{{$item->user->avatar ? imgUrlMaker2($item->user,'avatar') : asset('assets/img/default.png')}}"
                                         alt="img/user.png">

                                </div>
                            </div>
                            <div class="w-full">
                                <h3 class="p-normal font-bold text-smid w-full p-0">
                                    {{$item->title}}
                                </h3>
                                <p class="inline-block text-sm opacity-80 pr-4">
                                    <strong class="mx-0.5">{{persianDateOld($item->created_at)}}</strong>
                                    created by
                                    <strong class="mx-0.5">{{$item->user->name ? :'user'}}</strong>

                                </p>
                            </div>
                            <div class=" text-emerald-500 flex flex-col w-16 items-center">
                                <div class="font-extrabold text-smid">discuss</div>
                                <div class="icon-md">
                                    @include('component.icon.discuss')
                                </div>
                            </div>


                        </a>
                    </article>


                @empty
                    @include('component.notFound.notFound',['card' => false])
                @endforelse

                @if($items->first())
                        <a href="{{route('discuss.search',['search'=>$search])}}" rel="nofollow noreferrer noopener" target="_blank"
                           class="flex items-center gap-2 p-6 pl-7 my-4 card_cwc rounded-xl md:p-2.5 md:pl-4">
                            <div class="icon-md text-emerald-500">
                                @include('component.icon.search')
                            </div>
                            <div class="text-smid flex items-center opacity-80 pr-4 font-bold">
                                More search about
                                <p class="font-extrabold text-emerald-500 mx-3">"{{$search}}"</p>
                            </div>
                        </a>
                @endif
            @endif

        </div>
    @endif
</div>
