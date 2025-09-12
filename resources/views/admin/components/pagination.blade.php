@if($list->hasPages())

    <div class="wraper">

        <div class="pagination-group flex items-center">
            {{--        <a href="#" class="prev-d-pagination page-btn">--}}
            {{--            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">--}}
            {{--                <path fill-rule="evenodd" d="M10.21 14.77a.75.75 0 01.02-1.06L14.168 10 10.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"></path>--}}
            {{--                <path fill-rule="evenodd" d="M4.21 14.77a.75.75 0 01.02-1.06L8.168 10 4.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"></path>--}}
            {{--            </svg>--}}

            {{--        </a>--}}


            @if($list->currentPage() != 1)
                <a href="{{request()->fullUrlWithQuery(['page' =>$list->currentPage() - 1])}}"
                   class="prev-pagination page-btn mx-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd"
                              d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                              clip-rule="evenodd"></path>
                    </svg>


                </a>
            @endif
            <div class="pages flex items-center ">
                {{--                @if($list->currentPage() != 1)--}}
                {{--                    <a href="{{request()->fullUrlWithQuery(['page' =>$list->currentPage() - 1])}}"--}}
                {{--                       class="page-btn">{{$list->currentPage() - 1}}</a>--}}
                {{--                @endif--}}



                @for($i = 6 ; $i >= 1 ; $i --)
                    @if(checkNumber($list->currentPage() - $i))
                        <a href="{{$list->url($list->currentPage() - $i)}}"
                           class="page-btn">{{$list->currentPage() - $i}}</a>

                    @endif
                @endfor


                <a href="#"
                   class="page-btn-active shadow-md shadow-teal-200 dark:shadow-teal-500/60 hover:shadow-lg hover:shadow-teal-200 dark:hover:shadow-teal-700 bg-teal-500 dark:bg-teal-500 text-slate-50 hover:bg-teal-400">{{$list->currentPage()}}</a>


                @for($i = 1 ; $i <= 6 ; $i ++)
                    @if($list->lastPage() >= $list->currentPage() + $i)
                        <a href="{{$list->url($list->currentPage() + $i)}}"
                           class="page-btn">{{$list->currentPage() + $i}}</a>

                    @endif
                @endfor




                {{--                @if($list->hasMorePages())--}}
                {{--                    <a href="{{request()->fullUrlWithQuery(['page' =>$list->currentPage() + 1])}}" class="page-btn">{{$list->currentPage() + 1}}</a>--}}

                {{--                @endif--}}
            </div>
                        @if($list->hasMorePages())
                            <a href="{{request()->fullUrlWithQuery(['page' =>$list->currentPage() + 1])}}" class="next-pagination page-btn mx-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd"></path>
                                </svg>

                            </a>
                        @endif


            {{--        <a href="#" class="next-d-pagination page-btn">--}}
            {{--            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">--}}
            {{--                <path fill-rule="evenodd" d="M15.79 14.77a.75.75 0 01-1.06.02l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 111.04 1.08L11.832 10l3.938 3.71a.75.75 0 01.02 1.06zm-6 0a.75.75 0 01-1.06.02l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 111.04 1.08L5.832 10l3.938 3.71a.75.75 0 01.02 1.06z" clip-rule="evenodd"></path>--}}
            {{--            </svg>--}}


            {{--        </a>--}}

        </div>
    </div>
@endif

