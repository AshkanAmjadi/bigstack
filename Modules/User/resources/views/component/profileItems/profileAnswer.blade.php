@php
    if (!isset($my)){
        $user = $answer->user;
    }else{
        $user = auth()->user();
    }
    if (!isset($usefull)){
        $usefull = true;
    }


@endphp
<div class="answer card_c p-6 md:p-4 @if(!$answer->active) border-4 border-rose-500 @endif @if($answer->best) ring-4 ring-emerald-500 @endif">
    <div class="flexBC gap-3">
        <div class="flex items-center gap-3 flex-wrap">

            <div class="avatar xl md:!w-10 md:!h-10">
                <img class="pointer-events-none"
                     src="{{$user->avatar ? imgUrlMaker2($user,'avatar') : asset('assets/img/default.png')}}"
                     alt="Avatar">

            </div>
            <div class="flex flex-col">

                <p class="inline-block text-smid font-bold">
                    {{$user->name ? :'No Name'}}
                </p>
                <p class="inline-block text-sm">
                    {{persianDateOld($answer->created_at)}}
                    Created By
                     {!!  $user->name ?  htmlAlink(route('profile',['username'=>$user->username]),$user->name)  :'کاربر'!!}

                </p>
            </div>
        </div>
        <div class="flexC gap-3">
            @if($usefull)
                @component('front.components.icon.numIcon',['color'=>'emerald','number' => 'Useful for you'])
                    @include('component.icon.usefull')
                @endcomponent
            @endif

            @if(!$answer->active)
                @if($answer->user_id == auth()->id() or super())
                    @component('front.components.icon.numIcon',['color'=>'rose','number' => 'در انتظار تایید'])
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
            @if($answer->best)
                @component('front.components.icon.numIcon',['color'=>'emerald','number' => 'Best'])
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-width="2.5">
                            <path
                                d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"
                                opacity=".5"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5l2 2l5-5"/>
                        </g>
                    </svg>
                @endcomponent
            @endif

        </div>
    </div>

    <div class="card_cwc p-5 md:p-3 mt-5">
        @include('component.description.description',['desc'=>editorJsDecode($answer,'content')])
    </div>
    <div class="w-full mt-5 flexC gap-2">
        @component('component.btn.linkBtn',['title' => 'Show' , 'color'=>'emerald','href'=>route('conversation.show',['conversation'=>$answer->conversation->slug,'toAnswer' => $answer->hash_id]) . '#' .$answer->hash_id])
            @slot('icon')
                @include('component.icon.search')
            @endslot
        @endcomponent
        @if($answer->user_id == auth()->id() and !$answer->active or super())

            @livewire('user::profile.delete-ans',['id'=> $answer->id,'type'=>'Answer','name'=>'Answer'],key("'comment-'.$answer->id.'-'".now()->timestamp))

        @endif
        @if(super())
            @livewire('admin.active',['obj' => $answer , 'size'=>'lg'],key($answer->getTable() .'_answer_' . $answer->id.now()->timestamp))
        @endif
    </div>
    <div class="card_cwc p-3 md:p-3 mt-5 flexC gap-2">
        <p class="text-sm font-bold">In response to :</p>
        <a href="{{route('conversation.show',['conversation'=>$answer->conversation->slug])}}"
           class="text-mid text-blue-500 underline font-bold">
            {{$answer->conversation->title}}
        </a>
    </div>


</div>
