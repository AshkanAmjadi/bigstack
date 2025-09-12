<div class="actions flex justify-between">
    <div class="space-x-1 space-x-reverse">

        <form>
            <input class="form-input card_c border-none" type="text" name="search" id="" placeholder="جستوجو..." value="{{request('search')}}">
        </form>
    </div>
    <div class="space-x-1 space-x-reverse">

        @component('component.btn.linkBtn')
            @slot('href')
                {{route($prefix.'create')}}
            @endslot
            @slot('title')
                اضافه کردن {{$name_fa_fard}}
            @endslot
            @slot('icon')
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 mr-2"><g fill="currentColor"><path d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22Z" opacity=".5"/><path d="M12 8.25a.75.75 0 0 1 .75.75v2.25H15a.75.75 0 0 1 0 1.5h-2.25V15a.75.75 0 0 1-1.5 0v-2.25H9a.75.75 0 0 1 0-1.5h2.25V9a.75.75 0 0 1 .75-.75Z"/></g></svg>
            @endslot
        @endcomponent


    </div>

</div>


<form>

</form>
