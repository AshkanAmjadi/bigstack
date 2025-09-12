<?php


namespace App\facade\BaseMethod;


use Illuminate\Support\Facades\Facade;


/**
 * Class BaseMethod
 * @method static array addBeforDo(array $data, array $extra)
 * @method static array changeData(array $data, array $extra,array $drop = [])
 * @method static array addUserDataBeforDo(array $data)
 * @method static array addUpdatedDataBeforDo(array $data)
 * @method static array addDeleterData(array $data = [])
 * @method static array setSomeValuesBySendedData(array $data ,array $values)
 * @method static array setAnotherIfNull($subject,array $data,$second)
 * @method static array createTagIfNotExsist(array $data ,$tagObject)
 * @method static array createAttrValueIfNotExsist(array $data)
 * @method static array getObject($subject,$class,$columns = ['*'])
 * @method static array gateAllowsAll(array $allows)
 * @method static array gateAllowsSome(array $allows)
 * @method static array getLevel($parent)
 * @method static array ajaxResponse($success = true, $errors = [])
 * @method static array setParseDate($data,$subject)
 * @method static array putParentsInCollection($subject,$collection)
 * @method static array sortComments($comments,$subj = 'parent')
 * @method static array treeTheElemantsByParent($collection,$column = 'parent')
 * @method static array dangerIp()
 * @method static array checkUserInfoIsOk($userId = null)
 * @method static array checkUserCanChangeUsername()
 * @method static array checkPrivate($subject)
 * @method static array removeCacheDynamic($model,array $cached)
 * @method static array changesWithHistory( ?array $dirty = null, ?array $original = null, ?array $excludeFields = null)
 *
 *
 * @see \App\facade\BaseMethod\BaseMethod
 */
class BaseMethod extends Facade
{


    protected static function getFacadeAccessor()
    {
        return 'BaseMethodService';

    }

}
