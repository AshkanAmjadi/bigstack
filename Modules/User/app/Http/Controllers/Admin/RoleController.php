<?php

namespace Modules\User\App\Http\Controllers\Admin;


use App\facade\BaseValidation\BaseValidation;
use App\Http\Controllers\Controller;
use Modules\User\App\Models\Permission;
use Modules\User\App\Models\Rule as RuleModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{


    private $prefix = 'admin.roles.';
    private $model = 'roles';
    private $name = 'role';
    private $module = 'user::';



    public function __construct()
    {
        $this->middleware('can:show_' . $this->model)->only(['index']);
        $this->middleware('can:create_' . $this->name)->only(['create', 'store']);
        $this->middleware('can:edit_' . $this->name)->only(['edit', 'update']);
        $this->middleware('can:delete_' . $this->name)->only(['destroy']);
    }


    public function index()
    {

        $role = RuleModel::query();


        if ($keyword = \request('search')){
            $role = $role->where('name' , 'LIKE' , "%{$keyword}%")->orWhere('label' , 'LIKE' , "%{$keyword}%")->orWhere('id',$keyword);
        }

//        if (\request('admin') == 1){
//            $role = $role->where('is_superuser' , 1)->orWhere('is_staff' ,1);
//        }

        $role = $role->paginate(20);



        return view($this->module.$this->prefix.$this->model,compact($this->name));
    }

    public function create()
    {
        return view($this->module.$this->prefix.'add_'.$this->model);
    }

    public function store(Request $request)
    {
        $data = $this->validationRole($request);

        $role = RuleModel::query()->create($data['data']);

        $role->permissions()->sync($data['permissions']);

        alert()->success('ثبت شد','همه چی به خوبی ثبت شد 👍😉')->persistent(true,false)->timerProgressBar();

        return redirect(route($this->prefix.'index'));
    }

    public function edit(Role $role)
    {
        return view($this->module.$this->prefix.$this->model.'_edit',compact($this->name));
    }

    public function update(Request $request,Role $role)
    {
        $data = $this->validationRole($request,true,$role);

        $role->update($data['data']);

        $role->permissions()->sync($data['permissions']);

        toast('اطلاعات ثبت شد 👍😉','success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route($this->prefix.'index'));
    }

    public function destroy(Role $role)
    {

        $role->delete();

        alert()->success('حذف شد','به صورت کامل حذف شد 👍😉')->persistent(true,false)->timerProgressBar();

        return back();

    }

    private function validationRole ($request,$update = false,$object = null)
    {

        $unique_validation = 'unique:'.$this->model;

        if ($update) {
            $unique_validation = Rule::unique($this->model)->ignore($object->id);
        }


        $data = $request->validate([
            'name' => ['required','string','max:100','min:3',BaseValidation::validationForEnChar(),$unique_validation],
            'label' => ['required','string','max:100','min:3','persian_alpha_eng_num',$unique_validation],
        ]);
        $permissions = $request->validate([
            'permissions' => [
                'array' ,
                function ($attribute, $value, $fail) {
                    foreach ($value as $item) {

                        if (BaseValidation::pregForNum($item)){
                            if (Permission::query()->select('id')->find($item) === null){
                                $fail($this->name.'not found id:'.$item);
                            }
                        }else{
                            $fail('its must be int');
                        }

                    }
                }
            ]
        ]);


        $newData['permissions'] = isset($permissions['permissions']) ? $permissions['permissions'] : [];
        $newData['data'] = $data;

        return $newData;

    }
}
