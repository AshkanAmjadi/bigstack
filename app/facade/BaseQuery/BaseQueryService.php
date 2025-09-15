<?php


namespace App\facade\BaseQuery;


use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\Relation;

class BaseQueryService
{



    function morphAlias(object|string $model): ?string {
        $class = is_object($model) ? get_class($model) : $model;
        $map = Relation::morphMap();

        // جستجوی کلید توسط مقدار
        return array_search($class, $map, true) ?: $class;
    }

    public function activeQuery($query)
    {
        if (super()) {
            return $query;
        } else {
            return $query->where('active', '=', true);
        }
    }
    public function privateQuery($query)
    {
        if (super()) {
            return $query;
        } else {
            return $query->where('private', '=', false);
        }
    }

    public function cardSubjectNeed($query, $needs)
    {

        foreach ($needs as $need) {

            if ($need == 'cat') {
                $query = $query
                    ->with(['cat']);
            } elseif ($need == 'star') {
                $query = $query
                    ->withAvg('stars', 'tact_value');
            } elseif ($need == 'service') {
                $query = $query
                    ->with(['service']);
            } elseif ($need == 'like') {
                $query = $query
                    ->withCount('likes')
                    ->with('liked');
            } elseif ($need == 'liked') {
                $query = $query
                    ->with('liked');
            } elseif ($need == 'mark') {
                $query = $query
                    ->with('marked');
            } elseif ($need == 'user') {
                $query = $query
                    ->with([
                        'user' => function ($query) {
                            $query->select(['id', 'name', 'avatar','username','updated_at']);
                        },
                    ]);

            }
        }

        return $query;

    }

    public function activeAndUserObjQuery($query)
    {

        if (super()) {
            return $query;
        } else {
            $auth = auth()->id();
            if ($auth) {
                return $query->whereRaw("(active = ? or user_id = ?)",[ true, $auth]);
            } else {
                return $query->where('active', '=', true);
            }
        }
    }public function privateAndUserObjQuery($query)
    {

        if (super()) {
            return $query;
        } else {
            $auth = auth()->user();
            if ($auth) {
                return $query->whereRaw("(private = ? or user_id = ? or mention LIKE ?)",[ false , $auth->id , '%"' . $auth->username .  '"%']);
            } else {
                return $query->where('private', '=', false);
            }
        }
    }

    public function queryWithUserData($query, $trashed, $onlyUpdatad = false)
    {

        $relations = [
            'updated_by' => function ($query) {
                $query->select(['id', 'name', 'avatar','updated_at','username']);
            }
        ];


        if (!$onlyUpdatad) {
            $relations['added_by'] = function ($query) {
                $query->select(['id', 'name', 'avatar','updated_at','username']);
            };
        }

        if ($trashed) {
            $relations['deleted_by'] = function ($query) {
                $query->select(['id', 'name', 'avatar','updated_at','username']);
            };
        }

//        dd($relations);

        return $query->with($relations);
    }

    public function filterQuery($items, $time = 'null', $type = 'new', $filter = 'all')
    {
        if ($time == 'last_week') {
            $items = $items->whereDate('updated_at', '>=', now()->subWeek());
        } elseif ($time == 'last_month') {
            $items = $items->whereDate('updated_at', '>=', now()->subMonth());
        } elseif ($time == 'last_year') {
            $items = $items->whereDate('updated_at', '>=', now()->subYear());
        }

        if ($type == 'popular') {

            $items = $items->orderBy('view', 'desc');

        } elseif ($type == 'updated') {

            $items = $items->orderBy('updated_at', 'desc');

        } elseif ($type == 'old') {

            $items = $items->orderBy('id');

        } elseif ($type == 'new') {

            $items = $items->orderBy('id', 'desc');

        } elseif ($type == 'star') {

            $items = $items->orderBy('stars_avg_tact_value', 'desc');

        } elseif ($type == 'most_liked') {

            $items = $items->orderByDesc('likes_count');

        } elseif ($type == 'more_commented') {

            $items = $items->withCount('activeComments')->orderByDesc('active_comments_count');

        } elseif ($type == 'more_answer') {

            $items = $items->orderByDesc('active_answers_count');

        }


        if ($filter == 'all') {

        } elseif ($filter == 'not_answered') {
            $items->having('active_answers_count', '=', 0);
        } elseif ($filter == 'i_answered') {
            $items->withCount('myAnswers')->having('my_answers_count', '>', 0);
        } elseif ($filter == 'solved') {
            $items->where('has_best', '=', true);
        } elseif ($filter == 'unsolved') {
            $items->where('has_best', '=', false);
        } elseif ($filter == 'myCon') {
            $items->where('user_id', '=', auth()->id());
        } elseif ($filter == 'mentioned') {
            $items->where('mention', 'LIKE', '%"' . auth()->user()->username .  '"%');
        } elseif ($filter == 'private') {
            $items->where('private', '=', true);
        }elseif ($filter == 'public') {
            $items->where('private', '=', false);
        }

        return $items;
    }

    public function tagFilter($query, $tags)
    {
        return $query->whereHas('tags', function ($query) use ($tags) {
            $query->whereIn('name', $tags);
        });
    }
    public function getPersionOfTable($table)
    {

        $appLang = 'en';

        if ($appLang === 'en') {
            $names = [
                'article' => 'Article',
                'project' => 'Project',
            ];
        } elseif ($appLang === 'fa'){
            $names = [
                'article' => 'مقاله',
                'project' => 'پروژه',
            ];
        }

        return $names[$table];
    }


}
