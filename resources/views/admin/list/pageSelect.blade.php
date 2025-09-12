    @php($selected = isset($l1) ? $l1->listable_id : null)

<select id="pageSelect" name="page"
        class="form-input text-smid w-full relative">
    @forelse(\Modules\Content\App\Models\Page::query()->get(['id','title']) as $page)
        <option {{ $selected == $page->id ? 'selected' : '' }} value="{{$page->id}}">{{$page->title}}</option>

    @empty
        <option>صفحه ای ثبت نشده</option>

    @endforelse
</select>
