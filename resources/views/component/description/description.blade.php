@if($desc)



    <div class="descContent space-y-8 md:space-y-4">
        @foreach($desc as $el)
            @if($el['type'] === 'header' || $el['type'] === 'header3' || $el['type'] === 'header4')

                @if($el['data']['level'] == 1)
                    <h1 class="font-bold text-sextr">
                        {!! clean($el['data']['text']) !!}
                    </h1>
                @elseif($el['data']['level'] == 2)
                    <h2 class="font-bold text-felg">
                        {!! clean($el['data']['text']) !!}
                    </h2>
                @elseif($el['data']['level'] == 3)
                    <h3 class="font-bold text-elg">
                        {!! clean($el['data']['text']) !!}
                    </h3>
                @elseif($el['data']['level'] == 4)
                    <h4 class="font-bold text-lg">
                        {!! clean($el['data']['text']) !!}
                    </h4>
                @elseif($el['data']['level'] == 5)
                    <h5 class="font-bold text-mid">
                        {!! clean($el['data']['text']) !!}
                    </h5>
                @elseif($el['data']['level'] == 6)
                    <h6 class="font-bold text-smid">
                        {!! clean($el['data']['text']) !!}
                    </h6>
                @else
                    @php(abort(404))
                @endif

            @elseif($el['type'] === 'paragraph')
                <p class="paragraphSize font-normal indent-4 leading-8 px-2">
                    {!! clean($el['data']['text']) !!}
                </p>
            @elseif($el['type'] === 'allert')
                @component('component.allert.allert',['title' => clean($el['data']['text']),'closeBtn'=>false,'color'=>$el['data']['type']])
                    @slot('mainIcon')
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-md" width="24" height="24"
                             viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round"
                                      d="M22 10.5V12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2h1.5"
                                      opacity=".5"/>
                                <circle cx="19" cy="5" r="3"/>
                                <path stroke-linecap="round" d="M7 14h9m-9 3.5h6"/>
                            </g>
                        </svg>
                    @endslot
                @endcomponent

            @elseif($el['type'] === 'image')
                <div class="descImage text-center">
                    <div class="inline-block rounded-md overflow-hidden">
                        <img class="" src="{{$el['data']['url']}}" alt="{{$altImage}}">
                    </div>
                    @if($el['data']['alt'] != "")
                        <div>
                            <p class="card_cw font-bold inline-block py-2 px-4 shadow-custom_gray translate-y-1/2-">
                                {{$el['data']['alt']}}
                            </p>
                        </div>
                    @endif
                </div>
            @elseif($el['type'] === 'list')
                <ul class="listDesc paragraphSize font-semibold space-y-4 pr-4 py-2 border-r-2 border-blue-500 ">
                    @foreach($el['data']['items'] as $item)
                        <li>
                            <p class="paragraphSize font-normal indent-4 leading-8">
                                {!! clean($item) !!}
                            </p>
                        </li>
                    @endforeach
                </ul>
            @elseif($el['type'] === 'quote')
                <div class="quote text-center">
                    <div class="card_cwc p-3 relative @if($el['data']['caption'] != "") pb-6 @endif">
                        <blockquote class="paragraphSize font-semibold">{!! clean($el['data']['text']) !!}</blockquote>
                        <div class="icon-md absolute text-teal-500 top-0 translate-y-1/2-">
                            <svg xmlns="http://www.w3.org/2000/svg" width="256" height="256" viewBox="0 0 256 256">
                                <g fill="currentColor">
                                    <path
                                        d="M108 72v72H40a8 8 0 0 1-8-8V72a8 8 0 0 1 8-8h60a8 8 0 0 1 8 8Zm108-8h-60a8 8 0 0 0-8 8v64a8 8 0 0 0 8 8h68V72a8 8 0 0 0-8-8Z"
                                        opacity=".2"/>
                                    <path
                                        d="M100 56H40a16 16 0 0 0-16 16v64a16 16 0 0 0 16 16h60v8a32 32 0 0 1-32 32a8 8 0 0 0 0 16a48.05 48.05 0 0 0 48-48V72a16 16 0 0 0-16-16Zm0 80H40V72h60Zm116-80h-60a16 16 0 0 0-16 16v64a16 16 0 0 0 16 16h60v8a32 32 0 0 1-32 32a8 8 0 0 0 0 16a48.05 48.05 0 0 0 48-48V72a16 16 0 0 0-16-16Zm0 80h-60V72h60Z"/>
                                </g>
                            </svg>
                        </div>
                        <div class="icon-md absolute text-teal-500 left-2 bottom-0 translate-y-1/2 rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" width="256" height="256" viewBox="0 0 256 256">
                                <g fill="currentColor">
                                    <path
                                        d="M108 72v72H40a8 8 0 0 1-8-8V72a8 8 0 0 1 8-8h60a8 8 0 0 1 8 8Zm108-8h-60a8 8 0 0 0-8 8v64a8 8 0 0 0 8 8h68V72a8 8 0 0 0-8-8Z"
                                        opacity=".2"/>
                                    <path
                                        d="M100 56H40a16 16 0 0 0-16 16v64a16 16 0 0 0 16 16h60v8a32 32 0 0 1-32 32a8 8 0 0 0 0 16a48.05 48.05 0 0 0 48-48V72a16 16 0 0 0-16-16Zm0 80H40V72h60Zm116-80h-60a16 16 0 0 0-16 16v64a16 16 0 0 0 16 16h60v8a32 32 0 0 1-32 32a8 8 0 0 0 0 16a48.05 48.05 0 0 0 48-48V72a16 16 0 0 0-16-16Zm0 80h-60V72h60Z"/>
                                </g>
                            </svg>
                        </div>

                    </div>
                    @if($el['data']['caption'] != "")
                        <div>
                            <p class="card_c font-bold inline-block py-2 px-4 shadow-custom_gray translate-y-1/2-">
                                {!! clean($el['data']['caption']) !!}
                            </p>
                        </div>
                    @endif
                </div>
            @elseif($el['type'] === 'delimiter')
                @component('component.divider.divider',[])

                @endcomponent
            @elseif($el['type'] === 'table')
                <div class="overflow-x-auto overflow-y-clip">
                    <table class="w-full table-style-normal zebra paragraphSize">
                        @if( $el['data']['withHeadings'] )
                            <thead>
                            <tr>
                                @foreach($el['data']['content'][0] as $head)
                                    <th class="text-right p-2">{!! clean($head) !!}</th>
                                @endforeach
                            </tr>
                            </thead>
                        @endif
                        <tbody>
                        @foreach($el['data']['content'] as $key => $tr)
                            @if($key != 0)
                                <tr>
                                    @foreach($tr as $td)
                                        <td class="card_cwc font-semibold">{!! clean($td) !!}</td>
                                    @endforeach
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>

                </div>
            @elseif($el['type'] === 'columns')
                <div class="grid grid-cols-{{count($el['data']['cols'])}} gap-3 lg:grid-cols-1 lg:gap-6">
                @foreach($el['data']['cols'] as $col)
                    <div class="">
                        @include('component.description.description',['altImage'=>$altImage,'desc'=>$col['blocks']])
                    </div>
                @endforeach
                </div>


            @elseif($el['type'] === 'code')

            @elseif($el['type'] === 'easymde')
                <div class="markdown space-y-8 md:space-y-4">
                    {!! markdown($el['data']['text']) !!}
                </div>
            @else
                @php(abort(404))
            @endif

        @endforeach
    </div>
@endif
