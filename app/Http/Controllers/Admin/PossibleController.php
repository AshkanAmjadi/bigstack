<?php

namespace App\Http\Controllers\Admin;

use App\facade\BaseImage\BaseImage;
use App\facade\BaseSort\BaseSort;
use App\facade\BaseValidation\BaseValidation;
use App\Http\Controllers\Controller;
use App\Models\Lists;
use App\Models\Possible;
use App\Rules\dangerChar;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class PossibleController extends Controller
{

    private $prefix = 'admin.possible.';

    private $model = 'possible';
    private $table = 'possible';
    private $name = 'possible';


    public function __construct()
    {
//        $this->middleware('can:show_'.$this->model)->only(['index']);
//        $this->middleware('can:create_'.$this->model)->only(['create' , 'store']);
//        $this->middleware('can:edit_'.$this->model)->only(['edit' , 'update', 'deleteImg']);
//        $this->middleware('can:delete_'.$this->model)->only(['destroy']);
//        $this->middleware('can:force_delete_'.$this->model)->only(['forceDelete']);
//        $this->middleware('can:restore_'.$this->model)->only(['restore']);
//        $this->middleware('can:icon_'.$this->model)->only(['showIcon','deleteIcon','setIcon']);
//        $this->middleware('can:banner_'.$this->model)->only(['showBanner','deleteBanner','setBanner']);
    }

    public function index()
    {

        $possible = Possible::query()->orderBy('sort')->withUserData();

        if ($keyword = \request('search')) {
            $possible = $possible->where('name', 'LIKE', "%{$keyword}%");
        }
//        if ($trashed){
//
//            $possible = $possible->onlyTrashed();
//        }

        $list = $possible->get();


        return view($this->prefix . $this->model, compact('list'));
    }

    public function create()
    {
        return view("admin.$this->name.create.$this->name");

    }

    public function store(Request $request)
    {

//        dd($request->all());

        $data = $this->validationPossible($request);

        $need_data = $this->getNeedData($data);

        $object =  Possible::query()->create($need_data);


        alert()->success('ثبت شد','همه چی به خوبی ثبت شد 👍😉')->persistent(true,false)->timerProgressBar();


        return redirect(route($this->prefix . 'index'));

    }


    public function edit(Possible $possible)
    {

        return view("admin.$this->name.create.$this->name", compact($this->model));


    }

    public function update(Request $request, Possible $possible)
    {


        $data = $this->validationPossible($request,true,$possible);

        $need_data = $this->getNeedData($data);

        $possible->update($need_data);


        toast('اطلاعات ثبت شد 👍😉','success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route($this->prefix . 'index'));

    }


    private function validationPossible ($request,$update = false,$object = null)
    {

        $unique_validation = 'unique:'.$this->model;

        if ($update) {
            $unique_validation = Rule::unique($this->model)->ignore($object->id);
        }


        $data = $request->validate([

            'name' => ['required', 'string', 'max:400', 'min:3',$unique_validation],
            'info_page' => [
                'nullable',
                'string',
                'max:6000',
                BaseValidation::validationForLink(),
            ],

        ]);

        if (!$update) {
            $data = BaseSort::sortThanBrotherNoParent(Possible::query(), $data);
        }

        return $data;

    }
    private function getNeedData($data)
    {
        $fillable = app(Possible::class)->getFillable();
//        $fillable = unsetValue($fillable,['img','banner','mobile_banner']);
        return Arr::only($data,$fillable);
    }

    public function setsort(Request $request)
    {

        $sort = BaseSort::validSort($request);

        $possibles = Possible::query()->get('id');

        BaseSort::baseSetSort($possibles, $sort);

        toast('همه به خوبی مرتب شدن 👍😉', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();


        return redirect(route($this->prefix . 'index'));


    }
    public function destroy(Possible $possible)
    {

        $possible->delete();

        alert()->success('حذف شد','به صورت کامل حذف شد 👍😉')->persistent(true,false)->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }




}
