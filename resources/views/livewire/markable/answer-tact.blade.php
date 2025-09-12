@php
    $tacts = $obj->tacts;
    $mines = $tacts->where('tact_value','0')->count();
    $plus = $tacts->where('tact_value','1')->count();
    $myTact = $tacts->where('user_id',auth()->id())->first();
    $isMyne = $obj->user_id == auth()->id();
@endphp
<div class="mt-5 space-y-3">

    <div class="tacts flex gap-3 justify-between flex-wrap sm:flex-col-reverse">
        @if(!$isMyne)
            <div class="w-1/3 py-6 justify-center hidden" wire:loading.class.remove="hidden" wire:loading.class="flex">
                <div class="icon-lg">
                    @component('component.loading.loading',[])

                    @endcomponent
                </div>
            </div>
        @endif

        <div class="r flex gap-3 flex-wrap items-center" wire:loading.remove>

            @if(!$isMyne)
                @if(!$myTact)
                    <div class="inline-block text-smid font-bold w-full !text-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" class="inline-block icon-md" height="24"
                             viewBox="0 0 24 24">
                            <path fill="currentColor"
                                  d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22Z"
                                  opacity=".5"/>
                            <path fill="currentColor"
                                  d="M12 7.75c-.621 0-1.125.504-1.125 1.125a.75.75 0 0 1-1.5 0a2.625 2.625 0 1 1 4.508 1.829c-.092.095-.18.183-.264.267a6.666 6.666 0 0 0-.571.617c-.22.282-.298.489-.298.662V13a.75.75 0 0 1-1.5 0v-.75c0-.655.305-1.186.614-1.583c.229-.294.516-.58.75-.814c.07-.07.136-.135.193-.194A1.125 1.125 0 0 0 12 7.75ZM12 17a1 1 0 1 0 0-2a1 1 0 0 0 0 2Z"/>
                        </svg>
                        What do you think about this answer?

                    </div>
                @endif

                @if(!$myTact)

                    <div wire:click.debounce.150ms="tact(true)">
                        @component('component.btn.btnD',['title' => 'useful','class' => 'w-full','color'=>'emerald'])
                            @slot('icon')
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" class="icon-md" height="24"
                                     viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                          d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22Z"
                                          opacity=".5"/>
                                    <path fill="currentColor"
                                          d="M16.03 8.97a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0Z"/>
                                </svg>
                            @endslot

                        @endcomponent
                    </div>
                    <div wire:click.debounce.150ms="tact(false)">
                        @component('component.btn.btnD',['title' => 'not useful','class' => 'w-full','color'=>'rose'])
                            @slot('icon')
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon-md" width="24" height="24"
                                     viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                          d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22Z"
                                          opacity=".5"/>
                                    <path fill="currentColor"
                                          d="M8.97 8.97a.75.75 0 0 1 1.06 0L12 10.94l1.97-1.97a.75.75 0 1 1 1.06 1.06L13.06 12l1.97 1.97a.75.75 0 1 1-1.06 1.06L12 13.06l-1.97 1.97a.75.75 0 0 1-1.06-1.06L10.94 12l-1.97-1.97a.75.75 0 0 1 0-1.06Z"/>
                                </svg>
                            @endslot
                        @endcomponent
                    </div>
                @endif
                @if($myTact)

                    <div class="font-bold  text-mid  inline-block">
                        your vote
                    </div>
                    @if($myTact->tact_value)
                        <div class="font-extrabold text-mid inline-block text-green-500">
                            useful
                        </div>
                    @else
                        <div class="font-extrabold text-mid inline-block text-rose-500">
                            not useful
                        </div>
                    @endif



                    <div wire:click.debounce.150ms="deleteScore()">


                            @component('front.components.icon.numIcon',['color'=>'red','number' => 'delete vote'])
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon-md" width="24" height="24"
                                     viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                          d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22Z"
                                          opacity=".5"/>
                                    <path fill="currentColor"
                                          d="M8.97 8.97a.75.75 0 0 1 1.06 0L12 10.94l1.97-1.97a.75.75 0 1 1 1.06 1.06L13.06 12l1.97 1.97a.75.75 0 1 1-1.06 1.06L12 13.06l-1.97 1.97a.75.75 0 0 1-1.06-1.06L10.94 12l-1.97-1.97a.75.75 0 0 1 0-1.06Z"/>
                                </svg>
                            @endcomponent
                    </div>
                @endif

            @endif

        </div>


        <div class="l">
            <div class="teraz flex items-center">
                <div class="card_cwc p-2">
                    <p class="font-bold text-sm">balance</p>
                </div>

                <svg xmlns="http://www.w3.org/2000/svg" class="icon-md text-indigo-500" width="24" height="24"
                     viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="1.5" d="m11 19l6-7l-1.5-1.75M11 5l2 2.333M7 5l6 7l-1.5 1.75M7 19l2-2.333"/>
                </svg>
                <div class="card_cwc p-2">
                    <p class="font-bold text-sm tracking-widest" dir="ltr">{{$plus + (-$mines)}}</p>
                </div>


            </div>
        </div>
    </div>
    @if($tactSaved == 'ok')
        <div class="success text-elg !bg-emerald-500 card_cw py-10 px-4 text-center" onclick="this.remove()">
            <div class="font-extrabold text-white">
                Your comment has been recorded. We are glad that it was useful for you.
            </div>
            <div class="font-extrabold text-white">
                Thank you, dear user💕
            </div>
            <div class="icon-xl w-full flex justify-center mt-6 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="currentColor"
                          d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22Z"
                          opacity=".5"/>
                    <path fill="currentColor"
                          d="M16.03 8.97a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0Z"/>
                </svg>
            </div>
        </div>
    @endif

    @if($tactSaved == 'bad')
        <div class="success text-elg !bg-rose-500 card_cw py-10 px-4 text-center" onclick="this.remove()">
            <div class="font-extrabold text-white">
                This answer was not useful for you.
            </div>
            <div class="font-extrabold text-white">
                We would be grateful if you could provide an answer that would help our friend.
            </div>
            <div class="font-extrabold text-white">
                Thank you, dear user💕
            </div>
            <div class="icon-xl w-full flex justify-center mt-6 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="currentColor"
                          d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22Z"
                          opacity=".5"/>
                    <path fill="currentColor"
                          d="M8.97 8.97a.75.75 0 0 1 1.06 0L12 10.94l1.97-1.97a.75.75 0 1 1 1.06 1.06L13.06 12l1.97 1.97a.75.75 0 1 1-1.06 1.06L12 13.06l-1.97 1.97a.75.75 0 0 1-1.06-1.06L10.94 12l-1.97-1.97a.75.75 0 0 1 0-1.06Z"/>
                </svg>
            </div>
        </div>
    @endif


</div>


