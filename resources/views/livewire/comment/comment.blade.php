<div>

    <article>
        <div class="card_c paragraph p-3 relative">
            <div class="userComment w-full flexBC gap-5 p-5">
                <div class="r flexC gap-5">
                    <a href="{{route('profile',['username'=>$comment->user->username])}}">
                        @component('user::component.avatar.subjectAvatar',['class' => 'lg','subject' => $comment->getRelations()['user']])


                        @endcomponent
                    </a>

                    <div class="flex flex-col">

                        <a href="{{route('profile',['username'=>$comment->user->username])}}" class="inline-block text-smid font-semibold">
                            {{$comment->user->name ? :'no name'}}
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
                            @component('front.components.icon.numIcon',['color'=>'rose','number' => 'Awaiting approval'])
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
            <h3 class="text-lg font-bold mt-6">

                {{$comment->title}}
            </h3>
            <p class="p-3 card_cwc my-3 indent-4 leading-8 paragraphSize">
                {{$comment->content}}
            </p>
            @if($comment->parent != 0)
                <div class="icon-lg absolute text-teal-500 right-4  top-1/2 translate-y-1/2- translate-x-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor"
                              d="M17.75 19a.75.75 0 0 1-1.32.488l-6-7a.75.75 0 0 1 0-.976l6-7A.75.75 0 0 1 17.75 5v14Z"
                              opacity=".5"/>
                        <path fill="currentColor" fill-rule="evenodd"
                              d="M13.488 19.57a.75.75 0 0 0 .081-1.058L7.988 12l5.581-6.512a.75.75 0 1 0-1.138-.976l-6 7a.75.75 0 0 0 0 .976l6 7a.75.75 0 0 0 1.057.082Z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
            @endif
            <div class="bottom flex items-center justify-between">
                <div class="right flex gap-2">
                    @component('component.btn.btnD',['title' => 'Answer','color'=>'emerald'])
                        @slot('icon')
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                      d="m13.629 20.472l-.542.916c-.483.816-1.69.816-2.174 0l-.542-.916c-.42-.71-.63-1.066-.968-1.262c-.338-.197-.763-.204-1.613-.219c-1.256-.021-2.043-.098-2.703-.372a5 5 0 0 1-2.706-2.706C2 14.995 2 13.83 2 11.5v-1c0-3.273 0-4.91.737-6.112a5 5 0 0 1 1.65-1.651C5.59 2 7.228 2 10.5 2h3c3.273 0 4.91 0 6.113.737a5 5 0 0 1 1.65 1.65C22 5.59 22 7.228 22 10.5v1c0 2.33 0 3.495-.38 4.413a5 5 0 0 1-2.707 2.706c-.66.274-1.447.35-2.703.372c-.85.015-1.275.022-1.613.219c-.338.196-.548.551-.968 1.262Z"
                                      opacity=".5"/>
                                <path fill="currentColor"
                                      d="M7.25 9A.75.75 0 0 1 8 8.25h8a.75.75 0 0 1 0 1.5H8A.75.75 0 0 1 7.25 9Zm0 3.5a.75.75 0 0 1 .75-.75h5.5a.75.75 0 0 1 0 1.5H8a.75.75 0 0 1-.75-.75Z"/>
                            </svg>
                        @endslot
                        @slot('action')
                            onclick="AddComment({{$comment->id}})"
                        @endslot
                    @endcomponent
                    @if($comment->user_id == auth()->id() and !$comment->active or super())
                        @livewire('comment.delete-comm',['id' => $comment->id,'type' => 'Comment' , 'name' => ''],key(''.now().''))
                    @endif
                </div>

                <div class="marks flexC gap-3 md:gap-1">

                    @if(super() and !$comment->active)
                        @livewire('admin.active',['obj' => $comment , 'size'=>'lg'],key($comment->getTable() .'_comment_' . $comment->id))
                    @elseif(isset($comment->child_count) and super() and !$comment->child_count)
                        @livewire('admin.active',['obj' => $comment , 'size'=>'lg'],key($comment->getTable() .'_comment_' . $comment->id))
                    @elseif(super() and isset($comment->getRelations()['child']) and !$comment->getRelations()['child']->first())
                        @livewire('admin.active',['obj' => $comment , 'size'=>'lg'],key($comment->getTable() .'_comment_' . $comment->id))
                    @endif
                    @livewire('markable.like',['obj'=>$comment,'title' => 'comment'],key($comment->id.'likeComment'))

                </div>

            </div>


        </div>
        @isset($comment->getRelations()['child'])
            @if($comment->getRelations()['child']->first())
                <div class="childes space-y-6 pr-4 md:pr-2  !mt-0 py-3 border-r-2 border-teal-400 mr-4 md:mr-2">
                    @include('content::front.article.comments',['comments' => $comment->getRelations()['child'] ])
                </div>
            @endif
        @endif

        @isset($comment->child_count)
            @if($comment->child_count > 0)
                @livewire('comment.more-comments',['parent'=>$comment->id,'count'=>$comment->child_count])
            @endif
        @endisset
    </article>
</div>
