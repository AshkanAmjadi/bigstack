<?php


namespace App\facade\BaseCat;


use Illuminate\Support\Facades\Facade;
/**
 * Class BaseMethod
 * @method static string deleteCatViaProduct(collection $mother,bool $forceDelete = false)
 * @method static string haveChild(collection $category)
 * @method static string have2parent($category)
 * @method static string hasChild($category)
 * @method static string getAll()
 * @method static string getAllService()
 * @method static string getAllPossible()
 * @method static string getAllTag()
 * @method static string getAllHeaderLists()
 * @method static string getAllFooterLists()
 * @method static string getAllSearchTag()
 * @method static string exportAllCatIds($obj)
 * @method static string catBreadCrump($obj,$schema = false,$start = 2)
 * @method static string getFilters($filter)
 * @method static string getSearchCases($type)
 * @method static string getCat($name, $ids)
 * @see \App\facade\BaseCat\BaseCat
 */
class BaseCat extends Facade
{


    protected static function getFacadeAccessor()
    {
        return 'BaseCatService';

    }

}
