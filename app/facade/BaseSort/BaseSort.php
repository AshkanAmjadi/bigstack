<?php


namespace App\facade\BaseSort;


use Illuminate\Support\Facades\Facade;
/**
 * Class BaseMethod
 * @method static string sortThanBrother(collection $brothers,array $data)
 * @method static string sortThanBrotherNoParent(collection $brothers,array $data)
 * @method static string validSort(collection $request)
 * @method static string baseSetSort(collection $objects , array  $sort)
 *
 * @see \App\facade\BaseSort\BaseSort
 */
class BaseSort extends Facade
{


    protected static function getFacadeAccessor()
    {
        return 'BaseSortService';

    }

}
