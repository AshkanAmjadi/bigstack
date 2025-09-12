<?php


namespace App\facade\BaseValidation;


use Illuminate\Support\Facades\Facade;
/**
 * Class BaseMethod
 * @method static array makeValidBanner($request)
 * @method static array makeValidIcon($request)
 * @method static array validationForImg($required = false)
 * @method static array validationForIcon($required = false)
 * @method static array validationForBanner($required = false)
 * @method static array validationForEnChar()
 * @method static array validationForHex()
 * @method static array validationForPhone()
 * @method static array validationForLink()
 * @method static array validationForMelicode()
 * @method static array validationForNum()
 * @method static array validationForUsername()
 * @method static array pregForNum(string $value)
 * @method static array tagsValidation($attribute, $value, $fail,$admin = true)
 * @method static array usagesValidation($attribute, $value, $fail)
 * @method static array productsValidation($attribute, $value, $fail)
 * @method static array ArticleValidation($attribute, $value, $fail)
 * @method static array PossibleValidation($attribute, $value, $fail)
 * @method static array ServiceValidation($attribute, $value, $fail)
 * @method static array editorjsValidation($attribute, $value, $fail , $column = true,$maxImage = 100)
 * @method static array base64ratio($attribute, $value, $fail,int $w,int $h)
 *
 *
 * @see \App\facade\BaseValidation\BaseValidation
 */
class BaseValidation extends Facade
{


    protected static function getFacadeAccessor()
    {
        return 'BaseValidationService';

    }

}
