@php
    $childes = $category->getRelation('child');
@endphp
<div>

    <div class="mainArticle flex gap-10 md:gap-3 lg:flex-wrap  mb-10 mt-2">

        <div class="category w-[73%] 2xl:w-[67%] lg:space-y-4 lg:w-full">


            <div class="flex gap-2 lg:flex-wrap lg:items-center lg:flex-col-reverse  justify-center  lg:mt-4 md:mt-2">
                @if($childes->first())

                    <div class="r lg:w-full lg-r:hidden">
                        <div class="flex my-3 gap-3  items-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" class="icon-lg text-blue-500" height="24"
                                 viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" d="M16.5 7.5h-3" opacity=".5"/>
                                    <path
                                        d="M5 5.217c0-.573 0-.86.049-1.099c.213-1.052 1.1-1.874 2.232-2.073C7.538 2 7.847 2 8.465 2c.27 0 .406 0 .536.011c.56.049 1.093.254 1.526.587c.1.078.196.167.388.344l.385.358c.571.53.857.795 1.198.972c.188.097.388.174.594.228c.377.1.78.1 1.588.1h.261c1.843 0 2.764 0 3.363.5c.055.046.108.095.157.146C19 5.802 19 6.658 19 8.369V9.8c0 2.451 0 3.677-.82 4.438c-.82.762-2.14.762-4.78.762h-2.8c-2.64 0-3.96 0-4.78-.761C5 13.476 5 12.25 5 9.8V5.217Z"/>
                                    <path stroke-linecap="round" d="M22 20h-8M2 20h8m2-2v-3" opacity=".5"/>
                                    <circle cx="12" cy="20" r="2"/>
                                </g>
                            </svg>

                            <div class="text-mid font-bold translate-y-0.5">
                                Subcategories
                            </div>
                        </div>

                        <div class="flexC gap-3 md:gap-1 flex-wrap">
                            @foreach($childes as $child)
                                <a href="{{route('category.show',['category'=>$child->slug])}}"
                                   class="DLLLL p-3 rounded-md inline-flex indigoHover flex-col items-center relative">
                                    @if($child->img)
                                        <img class="img-xl" src="{{semanticImgUrlMaker($child,'img')}}"
                                             alt="{{$child->page_title}}">
                                    @else
                                        @include('component.logo.logo',['size'=>'img-xl'])

                                    @endif
                                    <div class="text-smid font-bold mt-6">{{$child->title}}</div>

                                    <span class="indicator h-1 w-10 bg-indigo-500 rounded-t-full absolute bottom-0"></span>
                                </a>

                            @endforeach

                        </div>
                    </div>
                @endif

                <div class="l w-[600px] lg:w-3/5  md:w-[95%] lg-r:hidden">
                    <div class="descImage w-full">
                        @include('content::front.category.topImage')


                    </div>

                </div>
            </div>


            @livewire('content::category.items',['catIds' => $catIds])


        </div>
        <div class="sideCategory w-[27%] 2xl:w-[33%] lg:w-full ">
            <div class="l w-full lg:hidden">
                <div class="descImage w-full">
                    @include('content::front.category.topImage')
                </div>

            </div>
            @if($childes->first())

                <div class="r lg:hidden">
                    <div class="flex my-3 gap-3  items-center ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" class="icon-lg text-blue-500" height="24"
                             viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" d="M16.5 7.5h-3" opacity=".5"/>
                                <path
                                    d="M5 5.217c0-.573 0-.86.049-1.099c.213-1.052 1.1-1.874 2.232-2.073C7.538 2 7.847 2 8.465 2c.27 0 .406 0 .536.011c.56.049 1.093.254 1.526.587c.1.078.196.167.388.344l.385.358c.571.53.857.795 1.198.972c.188.097.388.174.594.228c.377.1.78.1 1.588.1h.261c1.843 0 2.764 0 3.363.5c.055.046.108.095.157.146C19 5.802 19 6.658 19 8.369V9.8c0 2.451 0 3.677-.82 4.438c-.82.762-2.14.762-4.78.762h-2.8c-2.64 0-3.96 0-4.78-.761C5 13.476 5 12.25 5 9.8V5.217Z"/>
                                <path stroke-linecap="round" d="M22 20h-8M2 20h8m2-2v-3" opacity=".5"/>
                                <circle cx="12" cy="20" r="2"/>
                            </g>
                        </svg>

                        <div class="text-mid font-bold translate-y-0.5">
                            Subcategories
                        </div>
                    </div>

                    <div class="flexC gap-3 md:gap-1 flex-wrap">
                        @foreach($childes as $child)
                            <a href="{{route('category.show',['category'=>$child->slug])}}"
                               class="DLLLL p-4 rounded-md inline-flex indigoHover flex-col items-center relative">
                                @if($child->img)
                                    <img class="img-mxl" src="{{semanticImgUrlMaker($child,'img')}}"
                                         alt="{{$child->page_title}}">
                                @else
                                    @include('component.logo.logo',['size'=>'img-mxl'])

                                @endif
                                <div class="paragraphSize font-bold mt-6">{{$child->title}}</div>

                                <span class="indicator h-1 w-10 bg-indigo-500 rounded-t-full absolute bottom-0"></span>
                            </a>

                        @endforeach

                    </div>
                </div>
            @endif
            @include('front.temp.aside.article')

        </div>

    </div>
    {{--  todo filters component  @livewire('category.filters')--}}
</div>
