<?php

namespace App\Http\Controllers\Admin;

use App\facade\BaseImage\BaseImage;
use App\facade\BaseValidation\BaseValidation;
use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{

    private $prefix = 'admin.option.';
    private $model = 'option';
    private $table = 'options';


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
//        $this->middleware('can:sort_'.$this->model)->only(['sort','setsort']);
//        $this->middleware('can:description_'.$this->model)->only(['showDesc','setDesc','showDescGallery','setDescGallery','deleteDescGallery']);
    }

    public function index()
    {

        return view('admin.option.option');

    }


    public function updateSocial(Request $request)
    {

        $data = $request->validate([
            '*_channel' => ['nullable',BaseValidation::validationForLink(),'string','min:3','max:1000'],
            '*_support' => ['nullable',BaseValidation::validationForLink(),'string','min:3','max:1000'],
            '*_link' => ['nullable',BaseValidation::validationForLink(),'string','min:3','max:1000'],
            '*_group' => ['nullable',BaseValidation::validationForLink(),'string','min:3','max:1000'],
            '*_bot' => ['nullable',BaseValidation::validationForLink(),'string','min:3','max:1000'],
            'instagram_id' => ['nullable','string','min:3','max:1000'],
            'youtube_name' => ['nullable','string','min:3','max:1000']

        ]);

        foreach ($data as $option => $value){

            Option::query()->updateOrCreate(['name' => $option],['value' => $value]);

        }
        toast('اطلاعات شبکه های اجتماعی ثبت شد 👍😉','success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route($this->prefix.'index'));

    }

    public function updateInfo(Request $request)
    {

        $data = $request->validate([
            'email' => ['nullable','string','email','min:3','max:1000'],
            'site_name' => ['nullable','string','min:3','max:1000'],
            'domain_name' => ['nullable','string','min:3','max:1000'],
            'site_generator' => ['nullable','string','min:3','max:1000'],
            'slogan' => ['nullable','string','min:3','max:1000'],
            'creator_name' => ['nullable','string','min:3','max:1000'],
            'creator_about' => ['nullable','string','min:3','max:1000'],
            'about_web' => ['nullable','string','min:3','max:1000'],

        ]);


        foreach ($data as $option => $value){

            Option::query()->updateOrCreate(['name' => $option],['value' => $value]);

        }
        toast('اطلاعات کلی ثبت شد 👍😉','success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route($this->prefix.'index'));


    }
    public function update(Request $request)
    {
        dd($request);


        $data = $this->validationBrand($request);

        $options = Option::all(['id','name','value']);

        foreach ($options as $option){
            if ($option->name === 'phone' and $option->value != $data['phone']){
                $option->update(['value'=>$data['phone']]);
            }
            if ($option->name === 'email' and $option->value != $data['email']){
                $option->update(['value'=>$data['email']]);
            }
            if ($option->name === 'currency' and $option->value != $data['currency']){
                $option->update(['value'=>$data['currency']]);
            }
            if ($option->name === 'instagram_link' and $option->value != $data['instagram_link']){
                $option->update(['value'=>$data['instagram_link']]);
            }
            if ($option->name === 'whatssapp_num' and $option->value != $data['whatssapp_num']){
                $option->update(['value'=>$data['whatssapp_num']]);
            }
            if ($option->name === 'address' and $option->value != $data['address']){
                $option->update(['value'=>$data['address']]);
            }
            if ($option->name === 'logo' and $data['logo'] !== null){
                BaseImage::baseSetOptionImg($option,$this->model,$request,$data,'logo','name');
            }
        }

        toast('اطلاعات ثبت شد 👍😉','success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route($this->prefix.'index'));
    }






    private function validationBrand ($request)
    {



        $data = $request->validate([
            'phone' => ['nullable','numeric',BaseValidation::validationForPhone(),'ir_mobile:zero'],
            'email' => ['nullable','string','email','min:3','max:100'],
            'instagram_link' => [
                'string',
                'max:500',
                BaseValidation::validationForLink()
            ],
            'whatsapp_num' => ['nullable','numeric',BaseValidation::validationForPhone(),'ir_mobile:zero'],
            'address' => ['nullable','string','min:3','max:400'],
            'logo' => BaseValidation::validationForIcon(),
            'logo_dark' => BaseValidation::validationForIcon(),
        ]);




        $data = setSelectInputValue($data ,['phone','email','currency','instagram_link','whatsapp_num','address','logo'] );


        return $data;

    }



}
