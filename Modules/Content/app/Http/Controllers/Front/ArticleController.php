<?php

namespace Modules\Content\App\Http\Controllers\Front;

use App\facade\BaseCat\BaseCat;
use App\facade\BaseQuery\BaseQuery;
use App\Http\Controllers\Controller;
use Modules\Content\App\Models\Article;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Support\Facades\Cache;
use Modules\Content\App\Models\Page;
use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\Schema;

class ArticleController extends Controller
{
    use SEOTools;

//    public function search($article)
//    {
//
//    }
    public function article($article)
    {

        $article = Article::query()->where('slug','=',$article)->with(['starTacts',])->withCount('activeComments as commentNum');
        $article = BaseQuery::cardSubjectNeed($article,['mark','like']);
        $article = BaseQuery::activeQuery($article)->firstOrFail();




        $article->setRelation('cat', Cache::rememberForever($article->getTable().$article->id.'category',function () use ($article) {

            return $article->cat()->allParent()->first(['id','parent_id','page_title','title','slug']);

        }));
        $article->setRelation('tags', Cache::rememberForever($article->getTable().$article->id.'tags',function () use ($article) {

            return $article->tags()->get(['id','name'])->map(function ($tag) {
                return $tag->unsetRelation('pivot');
            });

        }));


        $article->setAttribute('related', Cache::remember($article->getTable().$article->id.'related',5 * 24 * 60 * 60,function () use ($article) {

            $related = Article::query()->inRandomOrder();
            $related = BaseQuery::activeQuery($related);
            return BaseQuery::tagFilter($related,$article->getRelation('tags')->pluck('name')->toArray())
                ->where('id', '!=', $article->id)
                ->limit(4)->get([
                'id',
                'title',
                'slug',
                'meta_description',
                'read_time',
                'img',
                'level',
                'category'
            ]);

        }));


        $article->setRelation('added_by', Cache::rememberForever($article->getTable().$article->id.'added_by',function () use ($article) {

            return $article->added_by()->first(['id','name','avatar','updated_at','username']);

        }));

        $cateBreadCrump = BaseCat::catBreadCrump($article->cat);


        $article->schema = Cache::rememberForever($article->getTable().$article->id.'schema',function () use ($article,$cateBreadCrump) {
            $graph = new Graph();

            $graph->organization()
                ->name(getOption('site_name'))
                ->logo(asset('assets/img/logo/logo.png'))
                ->alternateName(getOption('slogan'))
                ->url(route('home'));

            $graph->article()
                ->headline($article->title)
                ->mainEntityOfPage(Schema::webPage()->identifier(route('article.show',['article'=>$article->slug])))
                ->image(
                    [
                        semanticImgUrlMaker($article,'img',false),
                    ]
                )
                ->author(Schema::person()->name($article->getRelation('added_by')->name))
                ->datePublished(toSeoDate($article->created_at))
                ->dateModified(toSeoDate($article->updated_at))
                ->description($article->meta_description);


            $breadCrump = [Schema::listItem()->position(1)->item(Schema::webPage()->name('home')->identifier(route('home')))];
            $catBreadCrump = $cateBreadCrump->schema;
            $thisBreadCrump = [Schema::listItem()->position($cateBreadCrump->lastPos)->item(Schema::webPage()->name($article->page_title)->identifier(route('article.show',['article'=>$article->slug])))];

            $breadCrump = array_merge($breadCrump,$catBreadCrump,$thisBreadCrump);
            $graph->breadcrumbList()->identifier(route('article.show',['article'=>$article->slug]))
                ->itemListElement($breadCrump);

            return json_encode($graph,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        });

        $breadCrump = $cateBreadCrump->cats;


        $this->seo()
            ->setTitle($article->page_title)
            ->setDescription($article->meta_description)
            ->setCanonical(route('article.show',['article'=>$article->slug]));
        $this->seo()
            ->opengraph()
            ->setType('article')
            ->setUrl(route('article.show',['article'=>$article->slug]))
            ->addImage(semanticImgUrlMaker($article,'img',false));


        SEOMeta::addKeyword($article->keyword);
        SEOMeta::addMeta('article:published_time', $article->created_at->toW3CString(), 'property');
        SEOMeta::addMeta('article:section', $article->getRelation('cat')->title, 'property');
        SEOMeta::addMeta('article:author', $article->getRelation('added_by')->name, 'property');
        SEOMeta::addMeta('article:tag', implode(',',$article->getRelation('tags')->pluck('name')->toArray()), 'property');
        //seo
        return view('content::'.'front.article.article' , compact('article','breadCrump'));
    }
    public function page($page)
    {

        $page = Cache::rememberForever('page'.$page, function () use ($page) {
            $page = Page::query()->where('slug', '=', $page);
            return BaseQuery::activeQuery($page)->firstOrFail();
        });

        SEOMeta::addKeyword($page->keyword);


        $this->seo()
            ->setTitle("$page->page_title",false)
            ->setDescription($page->meta_description)
            ->setCanonical(route('page.show',['page' => $page->slug]))
            ->opengraph()
            ->setUrl(route('page.show',['page' => $page->slug]))
            ->setType('website');

        $schema =  Schema::webPage()->name($page->page_title)->description($page->meta_description);

        $page->schema = json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);


        return view('content::'.'front.page.page',compact('page'));

    }

}
