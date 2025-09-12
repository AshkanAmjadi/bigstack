
<div class="space-y-2">

    <div class="flex text-lg mt-5 md:mt-0 gap-3 font-bold items-center">
        <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" class="icon-lg text-blue-500" height="24"
                 viewBox="0 0 24 24">
                <g fill="none" stroke="currentColor" stroke-width="1.5">
                    <path
                        d="M16 4c2.175.012 3.353.109 4.121.877C21 5.756 21 7.17 21 9.998v6c0 2.829 0 4.243-.879 5.122c-.878.878-2.293.878-5.121.878H9c-2.828 0-4.243 0-5.121-.878C3 20.24 3 18.827 3 15.998v-6c0-2.828 0-4.242.879-5.121C4.647 4.109 5.825 4.012 8 4"
                        opacity=".5"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9 13.4l1.714 1.6L15 11"></path>
                    <path
                        d="M8 3.5A1.5 1.5 0 0 1 9.5 2h5A1.5 1.5 0 0 1 16 3.5v1A1.5 1.5 0 0 1 14.5 6h-5A1.5 1.5 0 0 1 8 4.5v-1Z"></path>
                </g>
            </svg>
        </div>

        Articles
    </div>
    @php
        $chosen =  \Illuminate\Support\Facades\Cache::rememberForever('article.chosen',function (){
            return \Modules\Content\App\Models\Article::query()->active()->chosen()->limit(10)->get(['id','title','slug']);
        });
    @endphp
    @foreach($chosen as $article)
        <a href="{{route('article.show',['article'=>$article->slug])}}" class="DLLLL flex rounded-md pl-3 py-3 blueHover">
            <div class="pr-3 relative w-full">
                <h4 class="text-smid font-bold pr">{{$article->title}}</h4>
                <span class="indicator absolute w-1 h-full rounded-l-full bg-blue-500 right-0 top-0"></span>
            </div>
        </a>
    @endforeach

</div>
<a href="#" class="">
    <div class="card_c overflow-hidden mt-4 mb-4">
        <img class="w-full" src="{{semanticImgUrlMaker(\App\Models\Tag::query()->inRandomOrder()->first(),'mobile_banner')}}" alt="">

    </div>
</a>
<div class="space-y-4">
    <div class="flex text-lg mt-5 gap-3 font-bold items-center">
        <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" class="icon-lg text-blue-500" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><path d="m18.18 8.04l.463-.464a1.966 1.966 0 1 1 2.781 2.78l-.463.464M18.18 8.04s.058.984.927 1.853s1.854.927 1.854.927M18.18 8.04l-4.26 4.26c-.29.288-.434.433-.558.592c-.146.188-.271.39-.374.606c-.087.182-.151.375-.28.762l-.413 1.24l-.134.401m8.8-5.081l-4.26 4.26c-.29.29-.434.434-.593.558c-.188.146-.39.271-.606.374c-.182.087-.375.151-.762.28l-1.24.413l-.401.134m0 0l-.401.134a.53.53 0 0 1-.67-.67l.133-.402m.938.938l-.938-.938"/><path stroke-linecap="round" d="M8 13h2.5M8 9h6.5M8 17h1.5"/><path d="M3 10c0-3.771 0-5.657 1.172-6.828C5.343 2 7.229 2 11 2h2c3.771 0 5.657 0 6.828 1.172C21 4.343 21 6.229 21 10v4c0 3.771 0 5.657-1.172 6.828C18.657 22 16.771 22 13 22h-2c-3.771 0-5.657 0-6.828-1.172C3 19.657 3 17.771 3 14v-4Z" opacity=".5"/></g></svg>
        </div>

        Latest Articles
    </div>
    @php
       $newest =  \Illuminate\Support\Facades\Cache::rememberForever('article.newest',function (){
           return \Modules\Content\App\Models\Article::query()->active()->orderByDesc('updated_at')->limit(10)->get(['id','title','slug','updated_at']);
       })
 @endphp
    @foreach($newest as $article)
        <a href="{{route('article.show',['article'=>$article->slug])}}" class="DLLLL flex rounded-md pl-3 py-3 blueHover">
            <div class="pr-3 relative w-full">
                <h4 class="text-smid font-bold pr">{{$article->title}}</h4>
                <span class="indicator absolute w-1 h-full rounded-l-full bg-blue-500 right-0 top-0"></span>
            </div>
        </a>
    @endforeach

</div>



