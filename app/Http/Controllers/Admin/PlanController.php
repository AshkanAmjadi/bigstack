<?php

namespace App\Http\Controllers\Admin;

use App\facade\BaseImage\BaseImage;
use App\facade\BaseValidation\BaseValidation;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Possible;
use App\Models\Project;
use App\Rules\dangerChar;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PlanController extends Controller
{

    private $prefix = 'admin.plan.';

    private $model = 'plan';
    private $table = 'plan';
    private $name = 'plan';


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

    public function index($project)
    {
        $project = Project::query()->findOrFail($project, ['id', 'title']);

        $plan = $project->plans()->orderBy('id', 'desc')->withUserData();

        if ($keyword = \request('search')) {
            $plan = $plan->where('name', 'LIKE', "%{$keyword}%");
        }
//        if ($trashed){
//
//            $plan = $plan->onlyTrashed();
//        }

        $list = $plan->paginate(20);


        return view($this->prefix . $this->model, compact('list', 'project'));
    }

    public function create($project)
    {
        return view("admin.$this->name.create.$this->name", compact('project'));

    }

    public function store(Request $request, $project)
    {


        $data = $this->validationPlan($request);

        $need_data = $this->getNeedData($data);

        $object = Project::query()->find($project)->plans()->create($need_data);

        $object->possible()->sync($data['possible_ids']);


        alert()->success('ثبت شد', 'همه چی به خوبی ثبت شد 👍😉')->persistent(true, false)->timerProgressBar();


        return redirect(route($this->prefix . 'index',['project' => $project]));

    }


    public function edit($project ,Plan $plan)
    {

        return view("admin.$this->name.create.$this->name", compact($this->model,'project'));


    }

    public function update(Request $request,$project, Plan $plan)
    {


        $data = $this->validationPlan($request, true, $plan);

        $need_data = $this->getNeedData($data);

        $plan->update($need_data);

        $plan->possible()->sync($data['possible_ids']);


        toast('اطلاعات ثبت شد 👍😉', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route($this->prefix . 'index',['project' => $project]));

    }


    private function validationPlan($request, $update = false, $object = null)
    {

        $unique_validation = 'unique:' . $this->model;

        if ($update) {
            $unique_validation = Rule::unique($this->model)->ignore($object->id);
        }
        //delete price separatores
        $request->merge(['price' => Str::remove(',',$request->price)]);

        $data = $request->validate([

            'name' => ['required', 'string', 'max:400', 'min:3'],
            'price' => [
                'required',
                'numeric',
                'max:999999999999',
                'min:50000',

            ],
            'time' => [
                'nullable',
                'numeric',
                'max:24',
                'min:1',
            ],
            'active' => [
                'nullable',
                Rule::in('on')
            ],

            'infinity' => [
                'nullable',
                Rule::in('on')
            ],

            'suggest' => [
                'nullable',
                Rule::in('on')
            ],
            'possible_ids' => [
                'array',
                'max:1000',
                function ($attribute, $value, $fail) {
                    BaseValidation::PossibleValidation($attribute, $value, $fail);
                }
            ],

        ]);
        $data = setCheckboxValue($data, ['active', 'infinity', 'suggest']);
        $data = setArrayValue($data,'possible_ids');

//        $data = removeSpace($data,['name'],'_');

        return $data;

    }

    private function getNeedData($data)
    {
        $fillable = app(Plan::class)->getFillable();
//        $fillable = unsetValue($fillable, ['img', 'banner', 'mobile_banner']);
        return Arr::only($data, $fillable);
    }

    public function destroy($project,Plan $plan)
    {

        $plan->delete();

        alert()->success('حذف شد', 'به صورت کامل حذف شد 👍😉')->persistent(true, false)->timerProgressBar();

        return redirect(route($this->prefix . 'index',['project' => $project]));
    }


}
