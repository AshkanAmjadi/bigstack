<div>
    <div id="refreshTagLive" wire:click="refresh" class=""></div>

    <div class="subject w-full card_c rounded-2xl p-3  text-mid font-semibold flexC gap-3 md:gap-2">
        <div class="wraper">
            <input id="ArticlesCh" @if($subject == 'about') checked @else wire:change="goToSubject('about')"
                   @endif class="peer hidden" type="radio" name="subject">
            <label for="ArticlesCh"
                   class="DLLL cursor-pointer trans rounded-xl peer-checked:!bg-blue-500 peer-checked:text-white  py-2.5 px-4 md:p-3 flexC gap-3 md:gap-2">

                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="icon-lg" viewBox="0 0 24 24">
                    <g fill="none">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5"
                              d="M9 16c.85.63 1.885 1 3 1s2.15-.37 3-1"/>
                        <ellipse cx="15" cy="10.5" fill="currentColor" rx="1" ry="1.5"/>
                        <ellipse cx="9" cy="10.5" fill="currentColor" rx="1" ry="1.5"/>
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5"
                              d="M22 14c0 3.771 0 5.657-1.172 6.828S17.771 22 14 22m-4 0c-3.771 0-5.657 0-6.828-1.172S2 17.771 2 14m8-12C6.229 2 4.343 2 3.172 3.172S2 6.229 2 10m12-8c3.771 0 5.657 0 6.828 1.172S22 6.229 22 10"
                              opacity="0.5"/>
                    </g>
                </svg>
                About Me
            </label>
        </div>
        <div class="wraper">
            <input id="ConCh" class="peer hidden" type="radio" @if($subject == 'con') checked
                   @else wire:change="goToSubject('con')" @endif name="subject">
            <label for="ConCh"
                   class="DLLL cursor-pointer trans rounded-xl peer-checked:!bg-blue-500 peer-checked:text-white py-2.5 px-4 md:p-3 flexC gap-3 md:gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon-lg" width="24" height="24" viewBox="0 0 24 24">
                    <g fill="none">
                        <path fill="currentColor"
                              d="m10.87 21.51l.645.382l-.646-.382Zm.259-.438l-.646-.382l.646.382Zm-2.258 0l.646-.382l-.646.382Zm.26.438l-.646.382l.646-.382Zm-6.827-4.38l.693-.286l-.693.287Zm3.985 2.455l.024-.75l-.024.75Zm-1.82-.29l-.287.693l.287-.692Zm13.226-2.164l.693.287l-.693-.287Zm-3.984 2.454l-.024-.75l.024.75Zm1.82-.29l.287.693l-.287-.692ZM16.09 6.59l.392-.639l-.392.64Zm1.32 1.321l.64-.392l-.64.392ZM3.91 6.59l-.392-.64l.392.64ZM2.59 7.91l-.64-.392l.64.392Zm5.326 11.912l-.381.646l.381-.646Zm3.599 2.07l.26-.438l-1.292-.764l-.26.438l1.292.764Zm-3.29-.438l.26.438l1.291-.764l-.26-.438l-1.29.764Zm1.999-.326a.25.25 0 0 1-.224.122a.25.25 0 0 1-.224-.122l-1.29.764c.676 1.144 2.352 1.144 3.029 0l-1.291-.764ZM8.8 6.75h2.4v-1.5H8.8v1.5Zm8.45 6.05v.8h1.5v-.8h-1.5Zm-14.5.8v-.8h-1.5v.8h1.5Zm-1.5 0c0 .922 0 1.65.04 2.24c.04.596.125 1.104.322 1.578l1.385-.574c-.108-.261-.175-.587-.21-1.106c-.037-.527-.037-1.196-.037-2.138h-1.5Zm5.063 5.235c-.792-.025-1.223-.094-1.557-.232l-.574 1.385c.597.248 1.255.32 2.083.347l.048-1.5Zm-4.701-1.417a4.75 4.75 0 0 0 2.57 2.57l.574-1.385a3.25 3.25 0 0 1-1.759-1.76l-1.385.575ZM17.25 13.6c0 .942 0 1.611-.036 2.138c-.036.52-.103.845-.211 1.106l1.385.574c.197-.474.281-.982.322-1.578c.04-.59.04-1.318.04-2.24h-1.5Zm-3.515 6.735c.828-.027 1.486-.1 2.083-.347l-.574-1.385c-.335.138-.765.207-1.557.232l.048 1.5Zm3.268-3.491a3.25 3.25 0 0 1-1.76 1.759l.575 1.385a4.75 4.75 0 0 0 2.57-2.57l-1.385-.574ZM11.2 6.75c1.324 0 2.264 0 2.995.07c.72.069 1.16.199 1.503.409l.784-1.279c-.619-.38-1.315-.544-2.145-.623c-.818-.078-1.842-.077-3.137-.077v1.5Zm7.55 6.05c0-1.295 0-2.319-.077-3.137c-.079-.83-.244-1.526-.623-2.145l-1.279.784c.21.343.34.783.409 1.503c.07.73.07 1.671.07 2.995h1.5Zm-3.052-5.571a3.25 3.25 0 0 1 1.073 1.073l1.279-.784a4.75 4.75 0 0 0-1.568-1.568l-.784 1.279ZM8.8 5.25c-1.295 0-2.319 0-3.137.077c-.83.079-1.526.244-2.145.623l.784 1.279c.343-.21.783-.34 1.503-.409c.73-.07 1.671-.07 2.995-.07v-1.5ZM2.75 12.8c0-1.324 0-2.264.07-2.995c.069-.72.199-1.16.409-1.503L1.95 7.518c-.38.619-.544 1.315-.623 2.145c-.078.818-.077 1.842-.077 3.137h1.5Zm.768-6.85A4.75 4.75 0 0 0 1.95 7.518l1.279.784a3.25 3.25 0 0 1 1.073-1.073L3.518 5.95Zm5.999 14.74c-.201-.34-.377-.638-.548-.874a2.23 2.23 0 0 0-.67-.64l-.764 1.292c.046.027.11.077.22.23c.12.165.256.393.47.756l1.292-.764Zm-3.252-.355c.446.014.73.024.947.05c.204.025.281.058.323.083l.763-1.291c-.29-.171-.594-.243-.905-.28c-.298-.037-.661-.048-1.08-.062l-.048 1.5Zm5.51 1.119c.214-.363.35-.591.47-.756c.11-.153.174-.203.22-.23l-.763-1.291a2.23 2.23 0 0 0-.67.64c-.172.235-.348.534-.549.873l1.291.764Zm1.912-2.619c-.419.014-.782.025-1.08.061c-.31.038-.616.11-.905.28l.763 1.292c.042-.025.119-.058.323-.083c.216-.026.501-.036.947-.05l-.048-1.5Z"/>
                        <path fill="currentColor"
                              d="m21.715 12.435l.692.287l-.692-.287Zm-2.03 2.03l.287.693l-.287-.693Zm.524-11.912l-.392.64l.392-.64Zm1.238 1.238l.64-.392l-.64.392ZM8.791 2.553l-.392-.64l.392.64ZM7.553 3.79l-.64-.392l.64.392Zm5.822-1.041h2.25v-1.5h-2.25v1.5Zm7.875 5.625v.75h1.5v-.75h-1.5Zm0 .75c0 .884 0 1.51-.034 2c-.033.486-.096.785-.194 1.023l1.385.574c.187-.451.267-.933.305-1.494c.038-.554.038-1.24.038-2.103h-1.5Zm-.228 3.023a3 3 0 0 1-1.624 1.624l.574 1.386a4.5 4.5 0 0 0 2.435-2.436l-1.385-.574ZM15.625 2.75c1.242 0 2.12 0 2.804.066c.671.064 1.075.184 1.388.376l.784-1.279c-.588-.36-1.249-.516-2.03-.59c-.77-.074-1.733-.073-2.946-.073v1.5Zm7.125 5.625c0-1.213 0-2.175-.073-2.946c-.074-.781-.23-1.442-.59-2.03l-1.28.784c.193.313.313.717.377 1.388c.065.683.066 1.562.066 2.804h1.5Zm-2.933-5.183a3 3 0 0 1 .99.99l1.28-.783A4.5 4.5 0 0 0 20.6 1.913l-.784 1.28ZM13.375 1.25c-1.213 0-2.175 0-2.946.072c-.781.075-1.442.23-2.03.591l.783 1.28c.314-.193.718-.313 1.39-.377c.682-.065 1.56-.066 2.803-.066v-1.5Zm-4.976.663A4.5 4.5 0 0 0 6.913 3.4l1.279.784a3 3 0 0 1 .99-.99L8.4 1.912ZM7.782 6.04c.05-.96.175-1.473.41-1.856L6.913 3.4c-.437.713-.576 1.538-.629 2.562l1.498.078Zm10.243 9.446c.767-.026 1.384-.094 1.947-.327l-.574-1.386c-.302.125-.694.19-1.423.214l.05 1.499Z"
                              opacity=".5"/>
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6.51 13h.008M10 13h.009m3.482 0h.009" opacity=".5"/>
                    </g>
                </svg>
                Discuss
            </label>

        </div>
    </div>


    @if($subject == 'about')
        <div class="mt-5">

            <div class="grid grid-cols-4 card_c p-4 md:grid-cols-2 md:gap-4">
                <p class="p-2 font-bold text-lg text-center">comments : {{$user->comments_count}}</p>
                <p class="p-2 font-bold text-lg text-center border-l border-slate-300"> discuss : {{$user->conversations_count}}</p>
                <p class="p-2 font-bold text-lg text-center border-l border-slate-300 md:border-0">answers : {{$user->answers_count}}</p>
                <p class="p-2 font-bold text-lg text-center border-l border-slate-300">best : {{$user->best_answers_count}}</p>
            </div>


            @if($user->about_me)
                <div class="card_c p-4 mt-8">
                    <p class="paragraphSize font-normal indent-4 leading-8 px-2">
                        {{$user->about_me}}
                    </p>
                </div>
            @else
                <div class="text-elg card_c py-20 text-center col-span-3 mt-5">
                    <p class="font-extrabold mb-6">
                        No Text
                    </p>
                    <div class="icon-xl w-full flex justify-center text-rose-600 mt-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                  d="M22 12v7.206a1.727 1.727 0 0 1-2.5 1.544a2.891 2.891 0 0 0-2.896.18a2.892 2.892 0 0 1-3.208 0l-.353-.234a1.881 1.881 0 0 0-2.086 0l-.353.235a2.892 2.892 0 0 1-3.208 0a2.891 2.891 0 0 0-2.897-.18A1.727 1.727 0 0 1 2 19.205V12C2 6.477 6.477 2 12 2s10 4.477 10 10Z"
                                  opacity=".5"/>
                            <path fill="currentColor"
                                  d="M9.447 14.398a.75.75 0 1 0-.894 1.204A5.766 5.766 0 0 0 12 16.75a5.766 5.766 0 0 0 3.447-1.148a.75.75 0 1 0-.894-1.204A4.267 4.267 0 0 1 12 15.25a4.267 4.267 0 0 1-2.553-.852ZM16 9.5c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5s.448-1.5 1-1.5s1 .672 1 1.5ZM9 11c.552 0 1-.672 1-1.5S9.552 8 9 8s-1 .672-1 1.5s.448 1.5 1 1.5Z"/>
                        </svg>
                    </div>
                </div>
                @endif


        </div>

    @elseif($subject == 'con')
        <div class="grid grid-cols-2 1.5xl:gap-x-3 gap-7 lg:grid-cols-1 mt-5">
            @forelse($items as $item)
                @component('component.conversation.conListItem',['subject' => $item])

                @endcomponent
            @empty
                <div class="text-elg card_c py-20 text-center col-span-3">
                    <p class="font-extrabold mb-6">
                        No items found!!!
                    </p>
                    <div class="icon-xl w-full flex justify-center text-rose-600 mt-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                  d="M22 12v7.206a1.727 1.727 0 0 1-2.5 1.544a2.891 2.891 0 0 0-2.896.18a2.892 2.892 0 0 1-3.208 0l-.353-.234a1.881 1.881 0 0 0-2.086 0l-.353.235a2.892 2.892 0 0 1-3.208 0a2.891 2.891 0 0 0-2.897-.18A1.727 1.727 0 0 1 2 19.205V12C2 6.477 6.477 2 12 2s10 4.477 10 10Z"
                                  opacity=".5"/>
                            <path fill="currentColor"
                                  d="M9.447 14.398a.75.75 0 1 0-.894 1.204A5.766 5.766 0 0 0 12 16.75a5.766 5.766 0 0 0 3.447-1.148a.75.75 0 1 0-.894-1.204A4.267 4.267 0 0 1 12 15.25a4.267 4.267 0 0 1-2.553-.852ZM16 9.5c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5s.448-1.5 1-1.5s1 .672 1 1.5ZM9 11c.552 0 1-.672 1-1.5S9.552 8 9 8s-1 .672-1 1.5s.448 1.5 1 1.5Z"/>
                        </svg>
                    </div>
                </div>
            @endforelse

        </div>
        <div class="flexCC py-8">
            @include('component.pagination.livePagination',['list' => $items,'href'=>''])
        </div>

    @endif
    <div class="flexCC">
        @component('component.loading.fullPage',[])

        @endcomponent
    </div>

</div>
