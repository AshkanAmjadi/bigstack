



<div class="comment  card_c p-2 my-7">
    <div class="wraper">
        <div class="row">
            @if(!$subject->children->count())

                @component('component.btn.btnD',['color'=>'indigo' ,'tabindex' => true])

                    @slot('title')
                        نظر فعلی
                    @endslot
                @endcomponent

            @endif
        </div>
        <h2 class="font-bold text-mid mr-6 mt-3 mb-2 md:mr-3">{{$subject->title}} - {{$subject->id}}</h2>
        <p class="px-3 md:p-2 text-smid font-medium ">
            {{$subject->content}}
        </p>
    </div>
</div>



@forelse($subject->children as $comment)
    <div class="row text-center my-2">
        @component('component.btn.btnD',['color'=>'indigo' ])
            @slot('title')
                In response to
            @endslot
            @slot('icon')
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="currentColor"><path d="M5 6.25a.75.75 0 0 0-.488 1.32l7 6c.28.24.695.24.976 0l7-6A.75.75 0 0 0 19 6.25H5Z" opacity=".5"/><path fill-rule="evenodd" d="M4.43 10.512a.75.75 0 0 1 1.058-.081L12 16.012l6.512-5.581a.75.75 0 1 1 .976 1.139l-7 6a.75.75 0 0 1-.976 0l-7-6a.75.75 0 0 1-.081-1.058Z" clip-rule="evenodd"/></g></svg>
            @endslot
        @endcomponent


    </div>
    @include('admin.comment.preview.items',['subject' => $comment])
@empty
@endforelse
