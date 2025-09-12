@forelse($articles as $article)

    <div class="checkboxWraper img p-0">
{{--        <input type="checkbox" id="item20" hidden="">--}}
{{--        <label for="item20" class="box text-sm w-full !p-0">--}}
{{--            <div class="relative">--}}

{{--                <img class="rounded-md" src="img/images/rayban1.png" alt="">--}}

{{--                <span class="check border-teal-500 !absolute !ml-0 left-2 top-2"></span>--}}

{{--            </div>--}}
{{--        </label>--}}

        <input id="searchArticle{{$article->id}}" @if(in_array($article->id,\request()->articles)) checked @endif type="checkbox" name="article" value="{{$article->id}}" onchange="selectItem(this)">
        <label for="searchArticle{{$article->id}}" class="card_c w-full box py-5 px-3 mb-3 !flex items-center">
            <div class="border-4 w-1/4 md:w-1/3 dark:border-slate-700 rounded-lg overflow-hidden flex justify-center">
                @if($article->img)
                    <img class="w-full" src="{{semanticImgUrlMaker($article,'img')}}" alt="">
                @else
                    <h2 class="font-bold text-smid flex flex-wrap gap-1 opacity-50 my-5">
                        بدون عکس
                    </h2>
                @endif
            </div>
            <h2 class="title text-sm mr-4 font-semibold text-center w-3/4 md:w-2/3">
                {{$article->title}}
            </h2>
            <span class="check border-teal-500 !absolute !ml-0 left-2 bottom-2"></span>

        </label>
    </div>

@empty
    <div class="card_c py-5 px-3">
        <h2 class="text-sm mr-4 font-semibold text-center">مقاله ای یافت نشد</h2>
    </div>
@endforelse



