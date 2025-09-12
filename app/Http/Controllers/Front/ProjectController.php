<?php

namespace App\Http\Controllers\Front;

use App\facade\BaseQuery\BaseQuery;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Support\Facades\Cache;
use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\Schema;

class ProjectController extends Controller
{
    use SEOTools;

    public function project($project)
    {



        $project = Project::query()->where('slug', '=', $project)->with(['starTacts'])->withCount('activeComments as commentNum');
        $project = BaseQuery::cardSubjectNeed($project, ['mark', 'like']);
        $project = BaseQuery::activeQuery($project)->firstOrFail();

        $project->setRelation('tags', Cache::rememberForever($project->getTable() . $project->id . 'tags', function () use ($project) {

            return $project->tags()->get(['id', 'name'])->map(function ($tag) {
                return $tag->unsetRelation('pivot');
            });

        }));
        $project->setRelation('possible', Cache::rememberForever($project->getTable() . $project->id . 'possible', function () use ($project) {

            return $project->possible()->orderBy('sort')->get()->map(function ($possible) {
                return $possible->unsetRelation('pivot');
            });

        }));
        $project->setRelation('plans', Cache::rememberForever($project->getTable() . $project->id . 'plans', function () use ($project) {

            return $project->plans()->with(['possible'])->get()->map(function ($plans) {
                $plans->getRelation('possible')->map(function ($possible) {
                    return $possible->unsetRelation('pivot');
                });

                return $plans;
            });

        }));
        $project->setRelation('added_by', Cache::rememberForever($project->getTable() . $project->id . 'added_by', function () use ($project) {

            return $project->added_by()->first(['id', 'name','username', 'avatar','updated_at']);

        }));
        $project->setRelation('service', Cache::rememberForever($project->getTable() . $project->id . 'service', function () use ($project) {

            return $project->service()->first(['id', 'name']);

        }));
        $project->schema = Cache::rememberForever($project->getTable() . $project->id . 'schema', function () use ($project) {
            $graph = new Graph();


            $graph->organization()
                ->name(getOption('site_name'))
                ->logo(asset('assets/img/logo/logo.png'))
                ->alternateName(getOption('slogan'))
                ->url(route('home'));

            $graph->project()
                ->name($project->title)
                ->url(route('project.show', ['project' => $project->slug]))
                ->image(semanticImgUrlMaker($project, 'img', false))
                ->brand(Schema::brand()->name('lion web'));


            $breadCrump = [Schema::listItem()->position(1)->item(Schema::webPage()->name('home')->identifier(route('home')))];
            $catBreadCrump = [Schema::listItem()->position(2)->item(Schema::webPage()->name($project->getRelation('service')->name)->identifier(route('project.search', ['service' => $project->getRelation('service')->name])))];
            $thisBreadCrump = [Schema::listItem()->position(3)->item(Schema::webPage()->name($project->page_title)->identifier(route('project.show', ['project' => $project->slug])))];

            $breadCrump = array_merge($breadCrump, $catBreadCrump, $thisBreadCrump);
            $graph->breadcrumbList()->identifier(route('project.show', ['project' => $project->slug]))
                ->itemListElement($breadCrump);

            return json_encode($graph, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        });



        $this->seo()
            ->setTitle($project->page_title)
            ->setDescription($project->meta_description)
            ->setCanonical(route('project.show',['project'=>$project->slug]));
        $og = $this->seo()
            ->opengraph()
            ->setType('article')
            ->setUrl(route('project.show',['project'=>$project->slug]));

        $jsld = $this->seo()->jsonLd()
            ->setTitle($project->title)
            ->setDescription($project->meta_description)
            ->setSite(route('project.show',['project' => $project->slug]));

        if ($project->img){
            $og->addImage(semanticImgUrlMaker($project,'img',false));
            $jsld->addImage(semanticImgUrlMaker($project,'img',false));
        }
        if ($project->banner){
            $og->addImage(semanticImgUrlMaker($project,'banner',false));
            $jsld->addImage(semanticImgUrlMaker($project,'banner',false));
        }
        if ($project->mobile_banner){
            $og->addImage(semanticImgUrlMaker($project,'mobile_banner',false));
            $jsld->addImage(semanticImgUrlMaker($project,'mobile_banner',false));
        }

        SEOMeta::addKeyword($project->keyword);
        SEOMeta::addMeta('article:published_time', $project->created_at->toW3CString(), 'property');
        SEOMeta::addMeta('article:section', $project->getRelation('service')->name, 'property');
        SEOMeta::addMeta('article:author', $project->getRelation('added_by')->name, 'property');
        SEOMeta::addMeta('article:tag', implode(',',$project->getRelation('tags')->pluck('name')->toArray()), 'property');


        //seo
        return view('front.project.project', compact('project'));
    }

    public function projects()
    {
        $this->seo()
            ->setTitle('Projects and Portfolio')
            ->setDescription('In this section, various website designs are available for sale. You can browse, choose, and purchase your own website.')
            ->setCanonical(route('project.search'))
            ->opengraph()
            ->setUrl(route('project.search'))
            ->setType('website');

        $schema = Schema::webPage()
            ->name('Portfolio and Templates')
            ->description('Portfolio and completed projects by the Lion Web team');


        $schema = json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        return view('front.project.search', compact('schema'));

    }
}

