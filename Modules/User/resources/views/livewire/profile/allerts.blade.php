<div class="wraper w-full mt-5">


    <div class=" space-y-4">

        @forelse($items as $item)
            @component('component.allert.publicAllert',['type' => $item->type,'closeBtn'=>false,'new'=>$item->new])
                @slot('content')
                    {!! clean($item->content) !!}
                @endslot
                @slot('old')
                    {{persianDateOld($item->created_at)}}
                @endslot

            @endcomponent
            @php
                if ($item->new){
                    $item->update(['new'=>false]);
                }
            @endphp
        @empty
            @include('component.notFound.notFound')
        @endforelse

    </div>

    <div class="flexCC py-8">
        @include('component.pagination.livePagination',['list' => $items,'href'=>''])
    </div>
    <div class="flexCC">
        @include('component.loading.fullPage')
    </div>
</div>
