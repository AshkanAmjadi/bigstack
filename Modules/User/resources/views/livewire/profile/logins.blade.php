<div class="card_c p-4 space-y-4">
    <div wire:click="logoutOther()">
        @component('component.btn.btnD',['title' => 'Delete All','color'=>'red','tabindex' => true])

        @endcomponent
    </div>
    @php($current = request()->user()->current_login)
    @foreach(request()->user()->all_logins as $log)
        <div class="card p-3  text-smid">
{{--            @if($log->is_suspicious)--}}

{{--                <div>--}}
{{--                    @include('component.badg.badg',['title' => 'مشکوک', 'color' => 'rose' ,'shadow'=>false])--}}
{{--                </div>--}}
{{--                <pre>--}}
{{--                <code dir="ltr" class="javascript">--}}
{{--                {{print_r($log->security_alerts,true)}}--}}
{{--            </code>--}}
{{--            </pre>--}}
{{--            @elseif($log->security_alerts)--}}
{{--                <pre>--}}
{{--                <code dir="ltr" class="javascript">--}}
{{--                {{print_r($log->security_alerts,true)}}--}}
{{--            </code>--}}
{{--            </pre>--}}
{{--            @endif--}}

            <div class="flexC justify-between gap-3">
                <div class="card_cwc p-3">
                    Device :
                    {{$log->device_type}}

                </div>
                <div class="card_cwc p-3">
                    Platform :
                    {{$log->platform}}
                </div>
                <div class="card_cwc p-3">
                    Browser :
                    {{$log->browser}}
                </div>
                <div class="card_cwc p-3">
                    IP:
                    {{$log->ip_address}}
                </div>
                <div class="card_cwc p-3">
                    Created :
                    {{persianDate($log->created_at)}}
                </div>
                <div class="card_cwc p-3">
                    Last Activity :
                    {{persianDate($log->last_activity_at)}}
                </div>


                @if($log->id == $current->id)
                    @component('component.btn.btnD',['title' => 'Current','color'=>'emerald'])

                    @endcomponent
                @else
                    @if(!$log->deleted_at)
                        <div wire:click="logoutLog({{$log->id}})">
                            @component('component.btn.btnD',['title' => 'Delelte','color'=>'red','tabindex' => true])

                            @endcomponent
                        </div>
                    @else
                        <div class="card_cwc p-3 text-rose-600 bold">
                            Deleted
                        </div>
                    @endif
                @endif
            </div>


        </div>
    @endforeach
    <div class="flexCC">
        @include('component.loading.fullPage')

    </div>
</div>

