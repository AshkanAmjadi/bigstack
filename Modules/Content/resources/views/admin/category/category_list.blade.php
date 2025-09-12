@foreach($allCat as $cat)


    @livewire('content::admin.category.category-item',['level' => 0 ,'cat' => $cat],key(''.now().''))


@endforeach
