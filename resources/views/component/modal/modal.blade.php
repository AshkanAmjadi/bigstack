<div class="modal none-show" data-modal="{{$modal}}" data-animation-show="ElIn" data-animation-hide="ElOut">
    <div class="modal-content cart medium mx-auto mt-20 relative last:pb-6 ElIn">

        <div class="close absolute top-4 left-4 bg-slate-200 cursor-pointer dark:bg-slate-700 p-1 rounded-md ">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                 stroke="currentColor" class="w-6 h-6 icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
            </svg>

        </div>


        <div class="box px-5 space-y-2 mt-5">
            {{$slot}}
        </div>

    </div>
</div>
