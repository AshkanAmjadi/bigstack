<?php

namespace App\Http\Controllers\Admin;

use App\facade\BaseMethod\BaseMethod;
use App\facade\BaseValidation\BaseValidation;
use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ColorController extends Controller
{
    private $prefix = 'admin.color.';
    private $model = 'color';

    public function __construct()
    {
        $this->middleware('can:show_'.$this->model)->only(['index']);
        $this->middleware('can:create_'.$this->model)->only(['create' , 'store']);
        $this->middleware('can:edit_'.$this->model)->only(['edit' , 'update']);
        $this->middleware('can:delete_'.$this->model)->only(['destroy']);
        $this->middleware('can:force_delete_'.$this->model)->only(['forceDelete']);
        $this->middleware('can:restore_'.$this->model)->only(['restore']);
    }


    public function index()
    {
        $trashed = false;

        if(\request('show') === 'trashed'){
            $trashed = true;
        }

        $color = Color::query()->withUserData($trashed);

        if ($keyword = \request('search')){
            $color = $color->where('name' , 'LIKE' , "%{$keyword}%")->orWhere('hex' , 'LIKE' , "%{$keyword}%")->orWhere('id',$keyword);
        }

//        if (\request('admin') == 1){
//            $color = $color->where('is_superuser' , 1)->orWhere('is_staff' ,1);
//        }

        if ($trashed){
            $color = $color->onlyTrashed();
        }

        $color = $color->paginate(20);



        return view($this->prefix.$this->model,compact($this->model,'trashed'));
    }

    public function create()
    {
        return view($this->prefix.'add_'.$this->model);
    }

    public function store(Request $request)
    {
        $data = $this->validationColor($request);

        Color::query()->create($data);

        alert()->success('ثبت شد','همه چی به خوبی ثبت شد 👍😉')->persistent(true,false)->timerProgressBar();

        return redirect(route($this->prefix.'index'));
    }

    public function edit(Color $color)
    {
        return view($this->prefix.$this->model.'_edit',compact($this->model));
    }

    public function update(Request $request,Color $color)
    {
        $data = $this->validationColor($request,true,$color);

        $color->update($data);

        toast('اطلاعات ثبت شد 👍😉','success')->autoClose(5000)->position('bottom-end')->timerProgressBar();


        return redirect(route($this->prefix.'index'));
    }

    public function destroy(Color $color)
    {

        $color->update(BaseMethod::addDeleterData());

        $color->delete();

        toast('حذف شد ولی هنوز کامل حذف نشده میتونی توی لیست حذف شده ها کامل حذفش کنی 🤔🤔','info')->autoClose(5000)->position('bottom-end')->timerProgressBar();


        return back();
    }

    public function forceDelete($color)
    {
        $color = BaseMethod::getObject($color,Color::class);



        $color->forceDelete();

        alert()->success('حذف شد','به صورت کامل حذف شد 👍😉')->persistent(true,false)->timerProgressBar();


        return back();
    }

    public function restore($color)
    {
        $color = BaseMethod::getObject($color,Color::class);

        $color->update(['deleted_by'=>null]);

        $color->restore();

        toast('به لیست اصلی اضافه شد 👍😉','success')->autoClose(5000)->position('bottom-end')->timerProgressBar();


        return back();
    }

    private function validationColor ($request,$update = false,$object = null)
    {

        $unique_validation = 'unique:'.$this->model;

        if ($update) {
            $unique_validation = Rule::unique($this->model)->ignore($object->id);
        }


        $data = $request->validate([
            'name' => ['required','string','max:25','min:3',BaseValidation::validationForEnChar(),$unique_validation],
            'name_fa' => ['required','string','max:25','min:3','persian_alpha',$unique_validation],
            'hex' => ['required','string',BaseValidation::validationForHex(),$unique_validation]
        ]);



        return $data;

    }
}
