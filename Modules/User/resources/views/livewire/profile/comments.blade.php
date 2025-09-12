<div class="wraper w-full mt-5">


    <div class="grid grid-cols-3 2xl:grid-cols-3 1.5xl:gap-x-3 lg:grid-cols-2 gap-7 sm:grid-cols-1">

        @forelse($items as $item)
            @include('user::component.profileItems.profileComment',['want' => null,'comment' => $item ,'my' => true])
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
