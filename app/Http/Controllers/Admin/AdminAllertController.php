<?php

namespace App\Http\Controllers\Admin;

use App\facade\BaseImage\BaseImage;
use App\facade\BaseMethod\BaseMethod;
use App\Http\Controllers\Controller;
use App\Models\AdminAllert;
use App\Models\WebAllert;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class AdminAllertController extends Controller
{

    private $prefix = 'admin.adminAllert.';
    private $model = 'adminAllert';

    private $table = 'admin_allert';
    private $name = 'admin_allert';
    public function __construct()
    {
//        $this->middleware('can:show_' . $this->model)->only(['index']);
//        $this->middleware('can:create_' . $this->model)->only(['create', 'store']);
//        $this->middleware('can:edit_' . $this->model)->only(['edit', 'update']);
//        $this->middleware('can:delete_' . $this->model)->only(['destroy']);
//        $this->middleware('can:force_delete_' . $this->model)->only(['forceDelete']);
//        $this->middleware('can:restore_' . $this->model)->only(['restore']);
//        $this->middleware('can:banner_' . $this->model)->only(['showBanner', 'deleteBanner', 'setBanner']);
//        $this->middleware('can:description_' . $this->model)->only(['showDesc', 'setDesc', 'showDescGallery', 'setDescGallery', 'deleteDescGallery']);
    }


    public function index()
    {

        Carbon::
        //todo complete web_alerts in project

        $adminAllert = AdminAllert::query()->orderBy('id','desc');


        if ($keyword = \request('search')) {
            $adminAllert = $adminAllert->where('content', 'LIKE', "%{$keyword}%");
        }


        $list = $adminAllert->paginate(30);


        return view("admin.$this->name.$this->name", compact('list'));

    }



    public function destroy(AdminAllert $adminAllert)
    {

        $adminAllert->delete();

        alert()->success('حذف شد', 'به صورت کامل حذف شد 👍😉')->persistent(true, false)->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }









}
