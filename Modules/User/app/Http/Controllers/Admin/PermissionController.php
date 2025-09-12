<?php

namespace Modules\User\App\Http\Controllers\Admin;

use App\facade\BaseValidation\BaseValidation;
use App\Http\Controllers\Controller;
use Modules\User\App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{


    private $prefix = 'admin.permissions.';
    private $model = 'permissions';
    private $name = 'permission';
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

        $permission = Permission::query();


        if ($keyword = \request('search')){
            $permission = $permission->where('name' , 'LIKE' , "%{$keyword}%")->orWhere('label' , 'LIKE' , "%{$keyword}%")->orWhere('id',$keyword);
        }


//        $permission = $permission->paginate(20);
        $permission = $permission->get();



        return view($this->module.$this->prefix.$this->model,compact($this->name));
    }

    public function create()
    {
        return view($this->module.$this->prefix.'add_'.$this->model);
    }

    public function store(Request $request)
    {
        $data = $this->validationPermission($request);

        Permission::query()->create($data);

        toast('اطلاعات ثبت شد 👍😉','success')->autoClose(5000)->position('bottom-end')->timerProgressBar();


        return redirect(route($this->prefix.'index'));
    }

    public function edit(Permission $permission)
    {
        return view($this->module.$this->prefix.$this->model.'_edit',compact($this->name));
    }

    public function update(Request $request,Permission $permission)
    {
        $data = $this->validationPermission($request,true,$permission);

        $permission->update($data);

        toast('اطلاعات بروز شد 👍😉','success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route($this->prefix.'index'));
    }

    public function destroy(Permission $permission)
    {

        $permission->delete();

        alert()->success('حذف شد','به صورت کامل حذف شد 👍😉')->persistent(true,false)->timerProgressBar();

        return back();

    }

    private function validationPermission ($request,$update = false,$object = null)
    {

        $unique_validation = 'unique:'.$this->model;

        if ($update) {
            $unique_validation = Rule::unique($this->model)->ignore($object->id);
        }


        $data = $request->validate([
            'name' => ['required','string','max:100','min:3',BaseValidation::validationForEnChar(),$unique_validation],
            'label' => ['required','string','max:100','min:3','persian_alpha_eng_num',$unique_validation],
        ]);



        return $data;

    }
}
