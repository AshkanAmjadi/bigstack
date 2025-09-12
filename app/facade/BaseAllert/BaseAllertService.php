<?php


namespace App\facade\BaseAllert;




use App\Models\AdminAllert;

class BaseAllertService
{


    public function adminAllert($content,$type)
    {
        AdminAllert::query()->create(['content'=>$content,'type' => $type]);
    }
    public function userAllert($user,$content,$type)
    {
        $user->allerts()->create(['content'=>$content,'type' => $type]);
    }


}
