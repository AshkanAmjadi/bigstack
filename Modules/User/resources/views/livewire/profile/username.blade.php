<div>

    @if(auth()->user()->username)
        <div class="flex flex-col items-center justify-center">
            <a href="{{route('profile',['username'=>auth()->user()->username])}}" class="text-extr font-black border-b inline-block border-slate-300">
                {{ auth()->user()->username . '@'}}
            </a>
            <p class="text-lg font-bold opacity-75 mt-5">
                Your username
            </p>
        </div>
    @endif

    @if($canChange)

            <div class="wraper md:col-span-2">
                <div class="flex items-center gap-3">
                    <h2 class="text-sm mr-4 font-semibold">Username</h2>
                    <p class="text-sm font-bold text-red-600">Required</p>
                </div>

                <div class="relative">
                    <p class="font-extrabold text-flg absolute top-2 left-3">
                        @
                    </p>
                    <div class="icon-md absolute top-2 right-3 hidden" wire:loading.class.remove="hidden"
                         wire:target="username">
                        @component('component.loading.loading',[])

                        @endcomponent
                    </div>

                    <input id="username" class="form-input2 text-smid w-full pl-10"
                           wire:input.debounce.1000ms="username($event.target.value)" name="username" type="text"
                           value="{{auth()->user()->username}}" dir="ltr" placeholder="Username">
                    @if($ok)
                        <div class="mt-5">
                            @component('component.allert.allert', ['closeBtn' => false, 'title' => 'This username is not registered and you can register it.', 'color' => 'emerald'])
                            @endcomponent

                        </div>
                    @endif

                </div>

                <div class="wraper md:col-span-2 mt-3">
                    @if($ok)
                        <div class="inline-block" wire:click.debounce.300ms="setUsername">
                            @component('component.btn.btnD',['color'=>'emerald','tabindex' => true])
                                @slot('title')
                                    User Registration ({{$newUsername}}@)
                                @endslot
                                @slot('icon')

                                    <svg wire:loading.remove wire:target="setUsername" xmlns="http://www.w3.org/2000/svg"
                                         width="24"
                                         height="24" viewBox="0 0 24 24">
                                        <g fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path
                                                d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2s7.071 0 8.535 1.464C22 4.93 22 7.286 22 12s0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5l2 2l5-5"/>
                                        </g>
                                    </svg>
                                    <div class="hidden" wire:loading.class.remove="hidden" wire:target="setUsername">
                                        @component('component.loading.loading',[])

                                        @endcomponent
                                    </div>
                                @endslot
                            @endcomponent
                        </div>

                    @endif
                    @if($errors)
                        <div class="w-full space-y-3 mt-5" wire:loading.remove wire:target="setUsername">
                            @foreach($errors as $error)
                                @foreach($error as $er)
                                    @component('component.allert.allert',['closeBtn' => false,'title' => $er])
                                    @endcomponent
                                @endforeach
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="mt-5">
                    @component('component.allert.allert', ['color' => 'orange','title' => 'Be careful when registering your username. You can change it one year after registration.','closeBtn' => false])
                        @slot('mainIcon')
                            <svg class="icon-md" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                                    <path stroke-dasharray="28" stroke-dashoffset="28" d="M12 10l4 7h-8Z">
                                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.4s" values="28;0"/>
                                    </path>
                                    <path d="M12 10l4 7h-8Z" opacity="0">
                                        <animate attributeName="d" begin="0.4s" dur="0.8s" keyTimes="0;0.25;1"
                                                 repeatCount="indefinite"
                                                 values="M12 10l4 7h-8Z;M12 4l9.25 16h-18.5Z;M12 4l9.25 16h-18.5Z"/>
                                        <animate attributeName="opacity" begin="0.4s" dur="0.8s" keyTimes="0;0.1;0.75;1"
                                                 repeatCount="indefinite" values="0;1;1;0"/>
                                    </path>
                                </g>
                            </svg>
                        @endslot
                    @endcomponent
                </div>
            </div>

        @else

            @if($diffTimeForUsernameChane)
                <div class="mt-5">
                    @component('component.allert.allert', ['color' => 'blue','title' => "You can request to change your username in $diffTimeForUsernameChane.",'closeBtn' => false])
                        @slot('mainIcon')
                            <svg class="icon-md" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                                    <path stroke-dasharray="28" stroke-dashoffset="28" d="M12 10l4 7h-8Z">
                                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.4s" values="28;0"/>
                                    </path>
                                    <path d="M12 10l4 7h-8Z" opacity="0">
                                        <animate attributeName="d" begin="0.4s" dur="0.8s" keyTimes="0;0.25;1"
                                                 repeatCount="indefinite"
                                                 values="M12 10l4 7h-8Z;M12 4l9.25 16h-18.5Z;M12 4l9.25 16h-18.5Z"/>
                                        <animate attributeName="opacity" begin="0.4s" dur="0.8s" keyTimes="0;0.1;0.75;1"
                                                 repeatCount="indefinite" values="0;1;1;0"/>
                                    </path>
                                </g>
                            </svg>
                        @endslot
                    @endcomponent
                </div>
            @endif

    @endif

</div>
