<?php

namespace Modules\Content\App\Http\Controllers\Front;

use App\facade\BaseCat\BaseCat;
use App\facade\BaseQuery\BaseQuery;
use App\Http\Controllers\Controller;
use Modules\Content\App\Models\ArticleList;
use Modules\Content\App\Models\Category;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Support\Facades\Cache;
use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\Schema;

class CategoryArticleController extends Controller
{

    use SEOTools;

    public function category($category)
    {


        $catInfo = Cache::rememberForever('category.'.$category.'.info',function () use($category){
            $cat = Category::query()->where('slug','=',$category)->exists();
            if ($cat){
                $mainCat =  Category::query()->where('slug','=',$category)
                    ->allParent(['id','title','page_title','parent_id','img','slug','updated_at'])
                    ->allChildren(['id','title','page_title','parent_id','img','slug','updated_at'])
                    ->firstOrFail(['id','title','page_title','banner','mobile_banner','slug','parent_id','img','meta_description','keyword','updated_at']);
                $catIds =  BaseCat::exportAllCatIds($mainCat);

                $breadCrump = [Schema::listItem()->position(1)->item(Schema::webPage()->name('خانه')->identifier(route('home')))];
                $cateBreadCrump = BaseCat::catBreadCrump($mainCat);

                $graph = new Graph();

                $graph->organization()
                    ->name(getOption('site_name'))
                    ->logo(asset('assets/img/logo/logo.png'))
                    ->alternateName(getOption('slogan'))
                    ->url(route('home'));

                $breadCrump = array_merge($breadCrump,$cateBreadCrump->schema);
                $graph->breadcrumbList()->identifier(route('category.show', ['category' => $mainCat->slug]))
                    ->itemListElement($breadCrump);

                $schema =  json_encode($graph,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);

                $breadCrump = $cateBreadCrump->cats;

                return ['catIds' => $catIds, 'mainCat' => $mainCat ,'schema' => $schema,'breadCrump' => $breadCrump];

            }else{
                return  false;
            }


        });

        if (!$catInfo){
            abort('404');
        }

        $schema = $catInfo['schema'];
        $breadCrump = $catInfo['breadCrump'];
        $mainCat = $catInfo['mainCat'];


        $this->seo()
            ->setTitle("Category $mainCat->title")
            ->setDescription($mainCat->meta_description)
            ->setCanonical(route('category.show',['category' => $mainCat->slug]));

        $og = $this->seo()->opengraph()
            ->setUrl(route('category.show',['category' => $mainCat->slug]))
            ->setType('website');

        $jsld = $this->seo()->jsonLd()
            ->setTitle($mainCat->page_title)
            ->setDescription($mainCat->meta_description)
            ->setSite(route('category.show',['category' => $mainCat->slug]));


        if ($mainCat->img){
            $og->addImage(semanticImgUrlMaker($mainCat,'img',false));
            $jsld->addImage(semanticImgUrlMaker($mainCat,'img',false));
        }
        if ($mainCat->banner){
            $og->addImage(semanticImgUrlMaker($mainCat,'banner',false));
            $jsld->addImage(semanticImgUrlMaker($mainCat,'banner',false));
        }
        if ($mainCat->mobile_banner){
            $og->addImage(semanticImgUrlMaker($mainCat,'mobile_banner',false));
            $jsld->addImage(semanticImgUrlMaker($mainCat,'mobile_banner',false));
        }
        SEOMeta::addKeyword($mainCat->keyword);

        return view('content::'.'front.category.category' , compact('category','schema','breadCrump'));


    }
    public function articleList($articleList)
    {

        $articleList = Cache::rememberForever('articleList'.$articleList, function () use ($articleList) {
            $articleList = ArticleList::query()->where('slug', '=', $articleList);
            return BaseQuery::activeQuery($articleList)->firstOrFail();
        });
        $this->seo()
            ->setTitle("Article List $articleList->title")
            ->setDescription($articleList->meta_description)
            ->setCanonical(route('articleList.show',['articleList' => $articleList->slug]));

        $og = $this->seo()->opengraph()
            ->setUrl(route('articleList.show',['articleList' => $articleList->slug]))
            ->setType('website');

        $jsld = $this->seo()->jsonLd()
            ->setTitle($articleList->title)
            ->setDescription($articleList->meta_description)
            ->setSite(route('articleList.show',['articleList' => $articleList->slug]));


        if ($articleList->banner){
            $og->addImage(semanticImgUrlMaker($articleList,'banner',false));
            $jsld->addImage(semanticImgUrlMaker($articleList,'banner',false));
        }
        if ($articleList->mobile_banner){
            $og->addImage(semanticImgUrlMaker($articleList,'mobile_banner',false));
            $jsld->addImage(semanticImgUrlMaker($articleList,'mobile_banner',false));
        }


        return view('content::'.'front.articleList.articleList' , compact('articleList'));


    }



}
