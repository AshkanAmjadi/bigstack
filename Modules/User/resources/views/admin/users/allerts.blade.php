<h2 class="font-bold text-felg mr-6 mb-2 md:mr-3">
    اعلان های کاربر ({{$user->name ? :$user->phone}})
</h2>
<div class="space-y-2">
    @forelse($user->allerts()->orderBy('id','desc')->get() as $allert)
        @component('component.allert.publicAllert',['type' => $allert->type])
            @slot('content')
                {!! clean($allert->content) !!}
            @endslot
            @slot('old')
                {{persianDateOld($allert->created_at)}}
            @endslot
            @slot('deleteAction')
                onclick="UserAllertDelete(this,{{$allert->id}})"
            @endslot
        @endcomponent
    @empty
        @component('component.divider.divider',['title' => 'اعلانی برای این کاربر ثبت نشده'])

        @endcomponent
    @endforelse
</div>
