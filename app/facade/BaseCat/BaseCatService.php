<?php


namespace App\facade\BaseCat;


use App\facade\BaseMethod\BaseMethod;
use Modules\Content\App\Models\Category;
use App\Models\Lists;
use App\Models\Possible;
use App\Models\Service;
use App\Models\Tag;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Spatie\SchemaOrg\Schema;

class BaseCatService
{


    public function deleteCatViaProduct($mother, $forceDelete = false)
    {


        $childes = $mother->child()->get(['id', 'parent_id']);


        if ($childes->first()) {

            foreach ($childes as $key => $childe) {

                $this->deleteCatViaProduct($childe, $forceDelete);

            }

            $this->deleteCatWithAllRelate($mother, $forceDelete);

        } else {

            $this->deleteCatWithAllRelate($mother, $forceDelete);

        }

    }

    private function deleteCatWithAllRelate($object, $forceDelete)
    {


        $object->delete();


    }

    public function haveChild($category)
    {

        $category = BaseMethod::getObject($category, Category::class);

        return $category->child->count();

    }

    public function have2parent($category, $list = false)
    {


        $category = BaseMethod::getObject($category, Category::class);


        $first = $category->parent()->first(['id', 'parent_id']);

        if ($first === null) {
            return false;
        }

        $second = $first->parent()->first(['id', 'parent_id']);

        if ($second === null) {
            return false;
        }

        return true;

    }


    public function getAll()
    {


        if (!app()->has('allCat')) {
            app()->singleton('allCat', function () {
                return Category::query()->where('parent_id', 0)->allChildren()->get();
            });
        }

        return app('allCat');


    }

    public function getAllService()
    {


        if (!app()->has('allService')) {
            app()->singleton('allService', function () {
                return Cache::rememberForever('services', function () {
                    return Service::query()->get([
                        'id',
                        'name',
                        'img',
                        'purpose',
                        'banner',
                        'mobile_banner',
                        'url_page',
                        'project_page',
                        'active',
                        'updated_at',
                    ]);
                });
            });

        }

        return app('allService');


    }

    public function getAllPossible()
    {


        if (!app()->has('allPossible')) {
            app()->singleton('allPossible', function () {
                return Possible::query()->orderBy('sort')->get();
            });

        }

        return app('allPossible');


    }

    public function getAllSearchTag()
    {


        if (!app()->has('allSearchableTag')) {
            app()->singleton('allSearchableTag', function () {
                return Cache::rememberForever('searchableTag', function () {
                    return Tag::query()->where('searchable', '=', true)->get();
                });
            });

        }

        return app('allSearchableTag');


    }

    public function getAllTag()
    {


        if (!app()->has('allTag')) {
            app()->singleton('allTag', function () {
                return Cache::rememberForever('tags', function () {
                    return Tag::query()->get();
                });
            });

        }

        return app('allTag');


    }

    public function getAllHeaderLists()
    {


        if (!app()->has('headerLists')) {
            app()->singleton('headerLists', function () {
                return Cache::remember('headerLists', 60 * 60 * 6, function () {
                    return Lists::query()->where('parent_id', '=', 0)->where('header', 1)->with([
                        'child' => function ($query) {
                            $query->where('header', 1)->orderBy('sort')->with([
                                'child' => function ($query) {
                                    $query->where('header', 1)->orderBy('sort');
                                }
                            ]);
                        }
                    ])->orderBy('sort')->get()->map(function ($list) {


                        return $this->setListAttrs($list);

                    });
                });
            });

        }


        return app('headerLists');


    }




    public function getAllFooterLists()
    {


        if (!app()->has('footr')) {
            app()->singleton('footr', function () {
                return Cache::remember('footerLists', 60 * 60 * 6, function () {
                    return Lists::query()->where('parent_id', '=', 0)->where('footer', 1)->with([
                        'child' => function ($query) {
                            $query->where('footer', 1)->orderBy('sort')->with([
                                'child' => function ($query) {
                                    $query->where('footer', 1)->orderBy('sort');
                                }
                            ]);
                        }
                    ])->orderBy('sort')->get()->map(function ($list) {


                        return $this->setListAttrs($list);

                    });
                });
            });

        }

        return app('footr');


    }
    public function setListAttrs($list)
    {
        if ($list->type == 'category'){

            $list->category = $list->listable_type::find($list->listable_id);

        }
        if ($list->child->count()) {

            $list->child->map(function ($child) {

                return $this->setListAttrs($child);

            });

        }
        return $list;

    }

    public function hasChild($cat)
    {


        $child = $cat->child;

        return $child->first() ? $child : false;

    }

    public function catBreadCrump($obj, $start = 2)
    {

        $cats = new Collection;

        $cats->put($obj->id, $obj);
        if ($parent = $obj->getRelation('parent')) {

            $cats->put($parent->id, $parent);

            $cats = $this->putParent($parent, $cats);

        }


        $schema = [];


        foreach ($cats->sortBy('id') as $cat) {

            $schema = array_merge(
                $schema,
                [Schema::listItem()
                    ->position($start)
                    ->item(
                        Schema::webPage()
                            ->name(clean($cat->page_title))
                            ->identifier(route('category.show', ['category' => $cat->slug]))
                            ->url(route('category.show', ['category' => $cat->slug]))


                    )]
            );
            $start = $start + 1;
        }

        $collenct = new Collection;

        $collenct->cats = $cats->sortBy('id');
        $collenct->lastPos = $start++;
        $collenct->schema = $schema;
        return $collenct;


    }

    public function putParent($obj, $putColl)
    {

        if ($parent = $obj->getRelation('parent')) {

            $putColl->put($parent->id, $parent);

            $putColl = $this->putParent($parent, $putColl);

        }

        return $putColl;

    }

    public function exportAllCatIds($obj)
    {

        $array = array($obj->id);
        if (!$obj->child->first()) return $array;
        else return array_merge($array, $this->getChildrenIds($obj->child));

    }


    public function getChildrenIds($childs)
    {
        $array = array();
        foreach ($childs as $child) {
            array_push($array, $child->id);
            if ($child->child->first())
                $array = array_merge($array, $this->getChildrenIds($child->child));
        }
        return $array;
    }

    public function getFilters($filter)
    {

        $filters = [
            'times' => [
                'null' => 'No Limit',
                'last_week' => '1 Last week',
                'last_month' => '1 Month ago',
                'last_year' => '1 Year ago',
            ],
            'types' => [
                'new' => 'Newest',
                'popular' => 'Most popular',
                'star' => 'rate',
                'most_liked' => 'Like',
                'more_commented' => 'More Comments',
                'updated' => 'Latest',
                'old' => 'Oldest',
            ],
            'types_con' => [
                'new' => 'Newest',
                'popular' => 'Most popular',
                'most_liked' => 'Like',
                'more_answer' => 'More Answered',
                'updated' => 'Latest',
                'old' => 'Oldest',
            ],
            'filter_con' => [
                'all' => 'All',
                'not_answered' => 'Not Answered',
                'i_answered' => 'I Answered',
                'solved' => 'Solved',
                'unsolved' => 'Unsolved',
                'myCon' => 'My Questions',
                'mentioned' => 'Mentioned To Me',
            ]

        ];

        if (super()) {
            $filters['filter_con']['private'] = 'Private';
            $filters['filter_con']['public'] = 'Public';
        }

        return $filters[$filter];

    }


    public function getSearchCases($type)
    {

        if ($type == 'tag') {

            $cases = [
                'article' => 'Articles',
                'discuss' => 'Questions',
            ];


            if (findInOption('service')) {
                $cases['project'] = 'Project';
            }

            return $cases;

        }

    }

    public function getCat($name, $ids)
    {

        return Cache::rememberForever($name, function () use ($ids) {
            return Category::query()->whereIn('id', $ids)->get();
        });

    }


}
