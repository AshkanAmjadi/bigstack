<?php

namespace App\Http\Controllers;

use Modules\Content\App\Models\Article;
use Modules\Content\App\Models\ArticleList;
use Modules\Content\App\Models\Category;
use App\Models\Conversation;
use Modules\Content\App\Models\Page;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function articles()
    {
        Cache::forget('articles.sitemap');

        $list = Cache::remember('articles.sitemap', 12*60*60, function () {
             return Article::query()->where('active' , true)->get(['id', 'slug', 'page_title', 'updated_at','img']);
        });
        return response()->view('sitemap.articles',compact('list'))->header('Content-Type','text/xml');
    }
    public function sitemap()
    {
        return response()->view('sitemap.sitemap')->header('Content-Type','text/xml');
    }
    public function static()
    {
        return response()->view('sitemap.static')->header('Content-Type','text/xml');
    }
    public function category()
    {

        Cache::forget('category.sitemap');

        $list = Cache::remember('category.sitemap', 12*60*60, function () {
            return Category::query()->get(['id', 'slug', 'page_title', 'updated_at','img','banner','mobile_banner']);
        });
        return response()->view('sitemap.category',compact('list'))->header('Content-Type','text/xml');

    }
    public function tag()
    {
        Cache::forget('tag.sitemap');

        $list = Cache::remember('tag.sitemap', 12*60*60, function () {
            return Tag::query()->get(['id', 'name', 'page_title', 'updated_at','img','banner','mobile_banner']);
        });
        return response()->view('sitemap.tag',compact('list'))->header('Content-Type','text/xml');

    }
    public function articleList()
    {
        Cache::forget('article-list.sitemap');

        $list = Cache::remember('article-list.sitemap', 12*60*60, function () {
            return ArticleList::query()->where('active' , true)->get(['id', 'slug', 'page_title', 'updated_at','banner','mobile_banner']);
        });
        return response()->view('sitemap.articleList',compact('list'))->header('Content-Type','text/xml');

    }
    public function project()
    {
        Cache::forget('project.sitemap');

        $list = Cache::remember('project.sitemap', 12*60*60, function () {
            return Project::query()->where('active' , true)->get(['id', 'slug', 'page_title', 'updated_at','banner','mobile_banner']);
        });
        return response()->view('sitemap.project',compact('list'))->header('Content-Type','text/xml');

    }
    public function page()
    {
        Cache::forget('page.sitemap');

        $list = Cache::remember('page.sitemap', 12*60*60, function () {
            return Page::query()->where('active' , true)->get(['id', 'slug', 'updated_at']);
        });
        return response()->view('sitemap.page',compact('list'))->header('Content-Type','text/xml');

    }
    public function discussion()
    {
        Cache::forget('discussion.sitemap');

        $list = Cache::remember('discussion.sitemap', 12*60*60, function () {
            return Conversation::query()->where('active' , true)->get(['id', 'slug', 'title', 'updated_at']);
        });
        return response()->view('sitemap.discussion',compact('list'))->header('Content-Type','text/xml');

    }

}
