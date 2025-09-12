<?php

namespace App\Http\Controllers\Admin;

use App\facade\BaseImage\BaseImage;
use App\facade\BaseMethod\BaseMethod;
use App\Http\Controllers\Controller;
use App\Models\WebAllert;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class WebAllertController extends Controller
{

    private $prefix = 'admin.webAllert.';
    private $model = 'webAllert';

    private $table = 'web_allert';
    private $name = 'web_allert';
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

        //todo complete web_alerts in project

        $webAllert = WebAllert::query()->orderBy('id','desc');


        if ($keyword = \request('search')) {
            $webAllert = $webAllert->where('content', 'LIKE', "%{$keyword}%");
        }


        $list = $webAllert->paginate(20);


        return view("admin.$this->name.$this->name", compact('list'));

    }

    public function create()
    {

        return view("admin.$this->name.create.$this->name");


    }

    public function store(Request $request)
    {


        $data = $this->validationProduct($request);

        WebAllert::query()->create($data);

        alert()->success('ثبت شد', 'همه چی به خوبی ثبت شد 👍😉')->persistent(true, false)->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }


    public function edit(WebAllert $webAllert)
    {

        return view("admin.$this->name.create.$this->name", compact($this->model));

    }

    public function update(Request $request, WebAllert $webAllert)
    {

        $data = $this->validationProduct($request, true, $webAllert);

        $webAllert->update($data);

        toast('اطلاعات ثبت شد 👍😉', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }


    public function destroy(WebAllert $webAllert)
    {

        $webAllert->delete();

        alert()->success('حذف شد', 'به صورت کامل حذف شد 👍😉')->persistent(true, false)->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }





    private function validationProduct($request, $update = false, $object = null)
    {



        $data = $request->validate([
            'content' => ['required', 'string', 'max:2500', 'min:3'],
            'type' => ['required', 'string', 'max:25','min:3' , Rule::in(['danger','info','secondary','success','warning'])],
        ]);


        return $data;

    }



}
