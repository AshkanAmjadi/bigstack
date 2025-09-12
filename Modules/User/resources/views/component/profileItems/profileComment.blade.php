
@php
    if (!isset($my)){
        $user = $comment->user;
    }else{
        $user = auth()->user();
    }

@endphp

    <div class="card_c paragraph p-3 relative">
        <div class="userComment w-full flexBC gap-5 p-5">
            <div class="r flexC gap-5">
                <a href="{{route('profile',['username'=>$user->username])}}">
                    @component('user::component.avatar.subjectAvatar',['class' => 'lg','subject' => $user])


                    @endcomponent
                </a>


                <div class="flex flex-col">

                    <a href="{{route('profile',['username'=>$user->username])}}" class="inline-block text-smid font-semibold">
                        {{$user->name ? :'No name'}}
                    </a>
                    <p class="inline-block text-esm font-light">
                        {{persianDate($comment->updated_at)}}
                        - {{persianDateOld($comment->updated_at)}}
                    </p>
                </div>
            </div>
            <div class="l">
                @if(!$comment->active)
                    @if($comment->user_id == auth()->id() or super())
                        @component('front.components.icon.numIcon',['color'=>'rose','number' => 'Pending'])
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2.5">
                                    <path stroke-dasharray=".5 3.5"
                                          d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2s10 4.477 10 10Z"
                                          opacity=".5"/>
                                    <path d="M22 12c0-5.523-4.477-10-10-10"/>
                                    <path stroke-linejoin="round" d="M12 9v4h4"/>
                                </g>
                            </svg>
                        @endcomponent
                    @endif
                @endif
            </div>
        </div>
        @component('component.divider.divider')

        @endcomponent
        <h1 class="text-lg font-bold mt-6">

            {{$comment->title}}
        </h1>
        <p class="p-3 card_cwc my-3 indent-4 leading-8 paragraphSize">
            {{$comment->content}}
        </p>


        <div class="bottom flex items-center justify-between">
            <div class="marks flexC gap-3 md:gap-1">
                @if($want == 'like')
                    @livewire('markable.like',['obj'=>$comment,'title' => 'Comment'],key($comment->id.'likeComment'))
                @endif

            </div>

        </div>

        @if($commentable = isset($comment->getRelations()['commentable']) ? $comment->getRelations()['commentable']: false)
            @php($table = $commentable->getTable())
            @php($name_fa = \App\facade\BaseQuery\BaseQuery::getPersionOfTable($table))
                <div class="p-3 md:p-3 mt-5 flexC gap-2">
                    <p class="text-sm font-bold">In response to {{$name_fa}}:</p>
                    <a href="{{route("$table.show",[$table=>$commentable->slug])}}" class="text-smid text-blue-500 underline font-bold">
                        @if($table === 'article')
                            {{$commentable->page_title}}
                        @else
                            {{$commentable->page_title}}
                        @endif
                    </a>
                </div>
        @endif


    </div>

