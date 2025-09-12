<?php

namespace Modules\Content\App\Http\Controllers\Admin;

use App\facade\BaseImage\BaseImage;
use App\facade\BaseSort\BaseSort;
use App\facade\BaseValidation\BaseValidation;
use App\Http\Controllers\Controller;
use Modules\Content\App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class SliderController extends Controller
{

    private $prefix = 'admin.slider.';

    private $model = 'slider';
    private $table = 'slider';
    private $name = 'slider';
    private $types = [
        'home' => 'اسلایدر صفحه اصلی'
    ];


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

        $type = \request()->type;

        if ($type){

            isset($this->types[$type]) ? : abort(404);

            $slider = Slider::query()->where('type','=',$type)->orderBy('sort');

            if ($keyword = \request('search')) {
                $slider = $slider->where('name', 'LIKE', "%{$keyword}%");
            }

            $list = $slider->get();
        }else{
            $list = $this->types;
        }

//dd('content::'.$this->prefix . $this->model);

        return view('content::admin.slider.slider', compact('list','type'));
    }

    public function create()
    {
        return view('content::'."admin.$this->name.create.$this->name");

    }

    public function store(Request $request)
    {


        $data = $this->validationSlider($request);


        $need_data = $this->getNeedData($data);

        $object =  Slider::query()->create($need_data);

        BaseImage::saveBase64image(Arr::get($data,'banner'),$object,'banner',false,null,null,true,'name');
        BaseImage::saveBase64image(Arr::get($data,'mobile_banner'),$object,'mobile_banner',false,null,null,true,'name');


        alert()->success('ثبت شد','همه چی به خوبی ثبت شد 👍😉')->persistent(true,false)->timerProgressBar();


        return redirect(route($this->prefix . 'index',['type'=>$request->type]));

    }


    public function edit(Slider $slider)
    {

        return view('content::'."admin.$this->name.create.$this->name", compact($this->model));


    }

    public function update(Request $request, Slider $slider)
    {


        $data = $this->validationSlider($request,true,$slider);


        $need_data = $this->getNeedData($data);

        $slider->update($need_data);

        BaseImage::saveBase64image(Arr::get($data,'banner'),$slider,'banner',false,null,null,true,'name');
        BaseImage::saveBase64image(Arr::get($data,'mobile_banner'),$slider,'mobile_banner',false,null,null,true,'name');

        $banner = $slider->banner;
        $mobile_banner = $slider->mobile_banner;

        $slider->update(['banner'=> $banner . '?lastmod:' . now()->timestamp,'mobile_banner' => $mobile_banner . '?lastmod:' . now()->timestamp]);

        toast('اطلاعات ثبت شد 👍😉','success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route($this->prefix . 'index',['type'=>$request->type]));


    }


    private function validationSlider ($request,$update = false,$object = null)
    {

        $type = $request->type;

        $type ? (isset($this->types[$type]) ? : abort(404)) : abort(404);

        $unique_validation = 'unique:'.$this->model;

        if ($update) {
            $unique_validation = Rule::unique($this->model)->ignore($object->id);
        }


        $data = $request->validate([

            'name' => ['required', 'string', 'max:400', 'min:3'],
            'type' => ['required', 'string', 'max:200', 'min:1'],
            'link' => [
                'nullable',
                'string',
                'max:6000',
                BaseValidation::validationForLink(),
            ],
            'follow' => [
                'nullable',
                Rule::in('on')
            ],
            'banner' => ['nullable', 'string', 'base64max:3072', 'base64image:image', 'base64mimes:webp,png,jpeg,jpg',
                function ($attribute, $value, $fail) {
                    BaseValidation::base64ratio($attribute, $value, $fail,15,7);
                }
            ],
            'mobile_banner' => ['nullable', 'string', 'base64max:3072', 'base64image:image', 'base64mimes:webp,png,jpeg,jpg',
                function ($attribute, $value, $fail) {
                    BaseValidation::base64ratio($attribute, $value, $fail,3,2);
                }
            ]

        ]);

        if (!$update) {
            $data = BaseSort::sortThanBrotherNoParent(Slider::query()->where('type' ,'=',$type), $data);
        }

        $data = setCheckboxValue($data, ['follow']);


        return $data;

    }
    private function getNeedData($data)
    {
        $fillable = app(Slider::class)->getFillable();
        $fillable = unsetValue($fillable,['banner','mobile_banner']);
        return Arr::only($data,$fillable);
    }

    public function setsort(Request $request)
    {

        $type = $request->type;

        $type ? (isset($this->types[$type]) ? : abort(404)) : abort(404);

        $sort = BaseSort::validSort($request);

        $sliders = Slider::query()->where('type','=',$type)->get('id');

        BaseSort::baseSetSort($sliders, $sort);

        toast('همه به خوبی مرتب شدن 👍😉', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();


        return redirect(route($this->prefix . 'index',['type'=>$request->type]));



    }
    public function destroy(Slider $slider)
    {

        $slider->delete();

        alert()->success('حذف شد','به صورت کامل حذف شد 👍😉')->persistent(true,false)->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }




}
