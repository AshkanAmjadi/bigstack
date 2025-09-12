<?php


namespace App\facade\BaseQuery;


use Illuminate\Support\Facades\Facade;
/**
 * Class BaseMethod
 * @method static array queryWithUserData($query,$trashed,$onlyUpdatad = false)
 * @method static array activeQuery($query)
 * @method static array privateQuery($query)
 * @method static array activeAndUserObjQuery($query)
 * @method static array privateAndUserObjQuery($query)
 * @method static array filterQuery($items,$time = 'null',$type = 'new',$filter = 'all')
 * @method static array cardSubjectNeed($query,$needs)
 * @method static array tagFilter($query,$tags)
 * @method static string getPersionOfTable($table)
 * @method static string morphAlias(object|string $model)
 *
 * @see \App\facade\BaseValidation\BaseValidation
 */
class BaseQuery extends Facade
{


    protected static function getFacadeAccessor()
    {
        return 'BaseQueryService';

    }

}
