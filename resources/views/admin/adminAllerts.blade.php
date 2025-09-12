
<h2 class="font-bold text-felg mr-6 mb-2 md:mr-3">
    اعلان ها
</h2>
<div class="space-y-2 ">
    @forelse(\App\Models\AdminAllert::query()->orderBy('id','desc')->get() as $allert)
        @component('component.allert.publicAllert',['type' => $allert->type])
            @slot('content')
                {!! clean($allert->content) !!}
            @endslot
            @slot('old')
                {{persianDateOld($allert->created_at)}}
            @endslot
            @slot('deleteAction')
                    onclick="AdminAllertDelete(this,{{$allert->id}})"
            @endslot
        @endcomponent
    @empty
        @component('component.divider.divider',['title' => 'اعلانی ثبت نشده'])

        @endcomponent
    @endforelse
</div>
