<div class="author card_c p-5 mb-5 grid grid-cols-1 gap-3 @if(!$conversation->active) border-4 border-rose-500 @endif">
    @include('component.breadcrump.nav',[
    'manual' => [
        'title' => 'Discussions' ,
        'link' => route('discuss.search'),
        'icon' => 'discuss'
        ]
        ])
    <section id="top" class="flex flex-wrap justify-between items-center gap-2 mt-2">
        <div class="md:col-span-2 mb-3">
            @include('front.components.who.conversation' , ['relation' => 'user','subject' => $conversation])
        </div>
        <div class="marks flex flex-row-reverse md:justify-center md:w-full">
            @livewire('markable.like',['obj'=>$conversation,'title'=>'discuss'],key($conversation->getTable() .'_like_' . $conversation->id))
            @include('component.divider.hDivider')
            @livewire('markable.mark',['obj'=>$conversation,'title'=>'discuss'],key($conversation->getTable() .'_mark_' . $conversation->id))
            @include('component.divider.hDivider')
            <a href="#answers" class="flex items-center">
                @component('front.components.icon.numIcon',['number' => $conversation->active_answers_count,'color'=>'indigo','text' => 'Answer'])
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor"
                              d="m12.984 22.495l.537-.907c.416-.703.625-1.055.96-1.25c.334-.194.755-.201 1.598-.216c1.243-.021 2.023-.097 2.678-.368a4.952 4.952 0 0 0 2.68-2.68c.186-.446.28-.951.328-1.623c.025-.355.038-.533-.057-.675c-.095-.143-.275-.203-.636-.324c-1.511-.507-5.014-1.796-6.972-3.451c-2.207-1.867-4.182-5.66-4.889-7.115c-.14-.289-.21-.433-.334-.51c-.123-.076-.28-.074-.592-.071c-2.035.021-2.956.134-3.92.724A4.952 4.952 0 0 0 2.73 5.663C2 6.853 2 8.474 2 11.715v.99c0 2.307 0 3.46.377 4.37a4.952 4.952 0 0 0 2.681 2.679c.654.27 1.434.347 2.678.368c.842.015 1.264.022 1.598.216c.335.195.543.547.96 1.25l.537.907c.478.808 1.674.808 2.153 0Z"
                              opacity=".5"/>
                        <path fill="currentColor" fill-rule="evenodd"
                              d="M14.872.24a.766.766 0 0 1-.008 1.137l-1.102 1.014c.959.009 1.881.03 2.714.083c.715.045 1.386.114 1.97.222c.572.106 1.123.26 1.56.507a5.837 5.837 0 0 1 2 1.839c.48.721.693 1.537.794 2.52c.1.963.1 2.166.1 3.691v.042c0 .445-.387.805-.864.805c-.478 0-.865-.36-.865-.805c0-1.576 0-2.702-.091-3.578c-.09-.864-.26-1.402-.543-1.827a4.16 4.16 0 0 0-1.425-1.31c-.186-.105-.509-.214-1.004-.305a15.098 15.098 0 0 0-1.75-.195A49.94 49.94 0 0 0 13.776 4l1.088 1c.34.313.343.822.008 1.139a.91.91 0 0 1-1.222.007L11.057 3.76a.778.778 0 0 1-.257-.572c0-.215.092-.421.257-.573L13.65.232a.91.91 0 0 1 1.222.007Z"
                              clip-rule="evenodd"/>
                    </svg>
                @endcomponent
            </a>

            @livewire('markable.has-best',['obj'=>$conversation])

            @if(!$conversation->active)
                @if($conversation->user_id == auth()->id() or super())
                    @include('component.divider.hDivider')
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
            @if($conversation->private)
                @include('component.divider.hDivider')
                @component('front.components.icon.numIcon',['color'=>'sky','number' => 'Private'])
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="6" r="4"/>
                            <path
                                d="M15 13.327A13.6 13.6 0 0 0 12 13c-4.418 0-8 2.015-8 4.5S4 22 12 22c5.687 0 7.331-1.018 7.807-2.5"
                                opacity="0.5"/>
                            <path stroke-linejoin="round"
                                  d="M15.172 18.828a4 4 0 1 0 5.657-5.657m-5.658 5.657a4 4 0 0 1 5.657-5.657m-5.656 5.657l5.656-5.656"/>
                        </g>
                    </svg>
                @endcomponent
            @endif
        </div>
    </section>
    <section id="description" class="description">
        <h1 class="text-elg font-extrabold mb-4 mr-5">
            {{$conversation->title}}
        </h1>
        <div class="card_cwc p-5 md:p-2">
            @include('component.description.description',['desc'=>editorJsDecode($conversation,'description'),'altImage'=>$conversation->title])
            <div class="w-full mt-5 flexC gap-2">
                @component('component.btn.btnD',['title' => 'asq question' , 'color'=>'indigo'])
                    @slot('action')
                        onclick="AddAnswer('add')"
                    @endslot
                    @slot('icon')
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                  d="m12.984 22.495l.537-.907c.416-.703.625-1.055.96-1.25c.334-.194.755-.201 1.598-.216c1.243-.021 2.023-.097 2.678-.368a4.952 4.952 0 0 0 2.68-2.68c.186-.446.28-.951.328-1.623c.025-.355.038-.533-.057-.675c-.095-.143-.275-.203-.636-.324c-1.511-.507-5.014-1.796-6.972-3.451c-2.207-1.867-4.182-5.66-4.889-7.115c-.14-.289-.21-.433-.334-.51c-.123-.076-.28-.074-.592-.071c-2.035.021-2.956.134-3.92.724A4.952 4.952 0 0 0 2.73 5.663C2 6.853 2 8.474 2 11.715v.99c0 2.307 0 3.46.377 4.37a4.952 4.952 0 0 0 2.681 2.679c.654.27 1.434.347 2.678.368c.842.015 1.264.022 1.598.216c.335.195.543.547.96 1.25l.537.907c.478.808 1.674.808 2.153 0Z"
                                  opacity=".5"/>
                            <path fill="currentColor" fill-rule="evenodd"
                                  d="M14.872.24a.766.766 0 0 1-.008 1.137l-1.102 1.014c.959.009 1.881.03 2.714.083c.715.045 1.386.114 1.97.222c.572.106 1.123.26 1.56.507a5.837 5.837 0 0 1 2 1.839c.48.721.693 1.537.794 2.52c.1.963.1 2.166.1 3.691v.042c0 .445-.387.805-.864.805c-.478 0-.865-.36-.865-.805c0-1.576 0-2.702-.091-3.578c-.09-.864-.26-1.402-.543-1.827a4.16 4.16 0 0 0-1.425-1.31c-.186-.105-.509-.214-1.004-.305a15.098 15.098 0 0 0-1.75-.195A49.94 49.94 0 0 0 13.776 4l1.088 1c.34.313.343.822.008 1.139a.91.91 0 0 1-1.222.007L11.057 3.76a.778.778 0 0 1-.257-.572c0-.215.092-.421.257-.573L13.65.232a.91.91 0 0 1 1.222.007Z"
                                  clip-rule="evenodd"/>
                        </svg>
                    @endslot
                @endcomponent
                @if($conversation->user_id == auth()->id() and !$conversation->active or super())
                    @component('component.btn.linkBtn',['title' => 'edit' , 'color'=>'emerald','href'=> route('conversation.cratf.edit',[$conversation->hash_id])])
                        {{--                        @slot('action')--}}
                        {{--                            onclick="AddConversation('edit','{{$conversation->hash_id}}')"--}}
                        {{--                        @endslot--}}
                        @slot('icon')
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g fill="currentColor">
                                    <path
                                        d="M1 12c0-5.185 0-7.778 1.61-9.39C4.223 1 6.816 1 12 1c5.185 0 7.778 0 9.39 1.61C23 4.223 23 6.816 23 12c0 5.185 0 7.778-1.61 9.39C19.777 23 17.184 23 12 23c-5.185 0-7.778 0-9.39-1.61C1 19.777 1 17.184 1 12Z"
                                        opacity=".5"></path>
                                    <path
                                        d="M13.926 14.302c.245-.191.467-.413.912-.858l5.54-5.54c.134-.134.073-.365-.106-.427a6.066 6.066 0 0 1-2.3-1.449a6.066 6.066 0 0 1-1.45-2.3c-.061-.18-.292-.24-.426-.106l-5.54 5.54c-.445.444-.667.667-.858.912a5.045 5.045 0 0 0-.577.932c-.133.28-.233.579-.431 1.175l-.257.77l-.409 1.226l-.382 1.148a.817.817 0 0 0 1.032 1.033l1.15-.383l1.224-.408l.77-.257c.597-.199.895-.298 1.175-.432a5.03 5.03 0 0 0 .933-.576Zm8.187-8.132a3.028 3.028 0 0 0-4.282-4.283l-.179.178a.734.734 0 0 0-.206.651c.027.15.077.37.168.633a4.911 4.911 0 0 0 1.174 1.863a4.91 4.91 0 0 0 1.862 1.174c.263.09.483.141.633.168c.24.043.48-.035.652-.207l.178-.178Z"></path>
                                </g>
                            </svg>
                        @endslot
                    @endcomponent

                    @livewire('conversation.delete',['id'=> $conversation->id,'type'=>'Conversation','name'=>'question'])

                @endif
                @if(super())
                    <div class=" p-2 px-4 flexC rounded-md">
                        <p class="text-sm font-semibold translate-y-0.5">
                            active
                        </p>
                        @livewire('admin.active',['obj' => $conversation , 'size'=>'lg'],key($conversation->getTable() .'_con_' . $conversation->id))
                    </div>
                @endif
            </div>
        </div>

    </section>
    <div class="tags flex gap-3 flex-wrap items-center flex-row-reverse mt-4">
        <input id="shareLink" type="text" class="hidden">
        @component('component.btn.btnD',['title' => 'share','size' => 'lg'])
            @slot('action')
                onclick="copyUrl('shareLink',true)"
            @endslot
            @slot('icon')
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="icon-sm" viewBox="0 0 24 24">
                    <g fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 11.5a2.5 2.5 0 1 1-5 0a2.5 2.5 0 0 1 5 0Z"/>
                        <path stroke-linecap="round" d="M14.32 16.802L9 13.29m5.42-6.45L9.1 10.35" opacity=".5"/>
                        <path
                            d="M19 18.5a2.5 2.5 0 1 1-5 0a2.5 2.5 0 0 1 5 0Zm0-13a2.5 2.5 0 1 1-5 0a2.5 2.5 0 0 1 5 0Z"/>
                    </g>
                </svg>
            @endslot
        @endcomponent
        <div class="flex gap-3 flex-wrap">
            @foreach($conversation->tags as $tag)
                <a href="{{route('tag.show',['tag'=>$tag->name,'subject'=>'discuss'])}}"
                   class="card_cwc inline-flex items-center p-3 md:p-1.5 gap-3">
                    <p class="font-bold text-smid">
                        {{$tag->name}}
                    </p>
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-md text-blue-500" width="24" height="24"
                             viewBox="0 0 24 24">
                            <g fill="currentColor">
                                <path
                                    d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"
                                    opacity=".5"></path>
                                <path fill-rule="evenodd"
                                      d="M11.718 7.215a.75.75 0 0 0-1.436-.43l-.74 2.465H7a.75.75 0 0 0 0 1.5h2.092l-.75 2.5H6a.75.75 0 1 0 0 1.5h1.892l-.61 2.034a.75.75 0 0 0 1.436.431l.74-2.465h3.434l-.61 2.034a.75.75 0 0 0 1.436.431l.74-2.465H17a.75.75 0 0 0 0-1.5h-2.092l.75-2.5H18a.75.75 0 0 0 0-1.5h-1.892l.61-2.035a.75.75 0 0 0-1.436-.43l-.74 2.465h-3.434l.61-2.035Zm2.374 3.535l-.75 2.5H9.908l.75-2.5h3.434Z"
                                      clip-rule="evenodd"></path>
                            </g>
                        </svg>
                    </div>

                </a>
            @endforeach
        </div>
        <div class="flex gap-3 flex-wrap flex-row-reverse">

            @if($conversation->mentions->first())
                <div
                    class="card_cwc inline-flex items-center p-1 px-4 md:p-1.5 md:px-3 gap-3">
                    <p class="font-bold text-smid text-rose-500 ">
                        👉اmentioned
                    </p>

                </div>
                @foreach($conversation->mentions as $menstion)
                    @include('user::front.component.who.simple',['person' => $menstion])
                @endforeach
            @endif

        </div>

    </div>
</div>
