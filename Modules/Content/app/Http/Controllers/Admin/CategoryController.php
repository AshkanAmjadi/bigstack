<?php

namespace Modules\Content\App\Http\Controllers\Admin;

use App\facade\BaseCat\BaseCat;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    private $prefix = 'admin.category.';
    private $model = 'category';


    public function __construct()
    {
//        $this->middleware('can:show_' . $this->model)->only(['index']);
//        $this->middleware('can:create_' . $this->model)->only(['create', 'store']);
//        $this->middleware('can:edit_' . $this->model)->only(['edit', 'update', 'deleteImg']);
//        $this->middleware('can:delete_' . $this->model)->only(['destroy']);
//        $this->middleware('can:restore_' . $this->model)->only(['restore']);
//        $this->middleware('can:icon_' . $this->model)->only(['showIcon', 'deleteIcon', 'setIcon']);
//        $this->middleware('can:banner_' . $this->model)->only(['showBanner', 'deleteBanner', 'setBanner']);
//        $this->middleware('can:sort_' . $this->model)->only(['sort', 'setsort']);
    }

    public function index(Request $request)
    {


        $allTag = BaseCat::getAllTag();


        return view('content::admin.category.category', compact('allTag' ));
    }





}
