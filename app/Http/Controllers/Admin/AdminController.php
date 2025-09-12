<?php

namespace App\Http\Controllers\Admin;

use App\facade\BaseImage\BaseImage;
use App\facade\BaseMethod\BaseMethod;
use App\Http\Controllers\Controller;
use App\Models\AdminAllert;
use App\Models\WebAllert;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{


    public function dashboard()
    {


        $allCat = \App\facade\BaseCat\BaseCat::getAll();

        return view('admin/dashboard/dashboard',compact('allCat'));

    }

    public function deleteAdminAllert(AdminAllert $adminAllert)
    {

        $adminAllert->delete();

    }
    public function deleteWebAllert(WebAllert $webAllert)
    {

        $webAllert->delete();

    }
//    public function adminAllert()
//    {
//        return view('admin.adminAllerts');
//    }







}
