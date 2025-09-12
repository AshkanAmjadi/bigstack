@if($subject->superuser)
    @component('component.badg.badg' ,['color' => 'rose'])
        @slot('title')
            Founder
        @endslot
    @endcomponent
@endif
@if($subject->boss)
    @component('component.badg.badg' ,['color' => 'orange'])
        @slot('title')
            Boss
        @endslot
    @endcomponent
@endif
@if($subject->staff)
    @component('component.badg.badg' ,['color' => 'blue'])
        @slot('title')
            Staff
        @endslot
    @endcomponent
@endif
@if(!$subject->superuser and !$subject->boss and !$subject->staff)
    @component('component.badg.badg' ,['color' => 'sky'])
        @slot('title')
            Member
        @endslot
    @endcomponent
@endif
