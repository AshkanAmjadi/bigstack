<?php

namespace App\Http\Controllers\Admin;

use App\facade\BaseImage\BaseImage;
use App\facade\BaseValidation\BaseValidation;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Rules\dangerChar;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class TagController extends Controller
{

    private $prefix = 'admin.tag.';

    private $model = 'tag';
    private $table = 'tag';
    private $name = 'tag';


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

        $tag = Tag::query()->orderBy('id', 'desc')->withUserData();

        if ($keyword = \request('search')) {
            $tag = $tag->where('name', 'LIKE', "%{$keyword}%");
        }
//        if ($trashed){
//
//            $tag = $tag->onlyTrashed();
//        }

        $list = $tag->paginate(20);


        return view($this->prefix . $this->model, compact('list'));
    }

    public function create()
    {
        return view("admin.$this->name.create.$this->name");

    }

    public function store(Request $request)
    {

//        dd($request->all());

        $data = $this->validationTag($request);

        $need_data = $this->getNeedData($data);


        $object = Tag::query()->create($need_data);

        BaseImage::saveBase64image(Arr::get($data, 'img'), $object, 'img', false, null, null, true, 'name');
        BaseImage::saveBase64image(Arr::get($data, 'banner'), $object, 'banner', false, null, null, true, 'name');
        BaseImage::saveBase64image(Arr::get($data, 'mobile_banner'), $object, 'mobile_banner', false, null, null, true, 'name');

        alert()->success('ثبت شد', 'همه چی به خوبی ثبت شد 👍😉')->persistent(true, false)->timerProgressBar();


        return redirect(route($this->prefix . 'index'));

    }


    public function edit(Tag $tag)
    {

        return view("admin.$this->name.create.$this->name", compact($this->model));


    }

    public function update(Request $request, Tag $tag)
    {


        $data = $this->validationTag($request, true, $tag);

        $need_data = $this->getNeedData($data);

        $tag->update($need_data);

        BaseImage::saveBase64image(Arr::get($data, 'img'), $tag, 'img', false, null, null, true, 'name');
        BaseImage::saveBase64image(Arr::get($data, 'banner'), $tag, 'banner', false, null, null, true, 'name');
        BaseImage::saveBase64image(Arr::get($data, 'mobile_banner'), $tag, 'mobile_banner', false, null, null, true, 'name');

        toast('اطلاعات ثبت شد 👍😉', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route($this->prefix . 'index'));

    }


    private function validationTag($request, $update = false, $object = null)
    {

        $unique_validation = 'unique:' . $this->model;

        if ($update) {
            $unique_validation = Rule::unique($this->model)->ignore($object->id);
        }


        $data = $request->validate([
            'name' => ['required', 'string', 'max:250', 'min:3', $unique_validation, new dangerChar],
            'page_title' => ['nullable', 'string', 'max:600', 'min:3', $unique_validation],
            'meta_description' => ['nullable', 'string', 'max:600', 'min:3', $unique_validation],
            'img' => ['nullable', 'string', 'base64max:2048', 'base64image:image', 'base64mimes:webp,png,jpeg,jpg',
                function ($attribute, $value, $fail) {
                    BaseValidation::base64ratio($attribute, $value, $fail, 1, 1);
                }
            ],
            'banner' => ['nullable', 'string', 'base64max:3072', 'base64image:image', 'base64mimes:webp,png,jpeg,jpg',
                function ($attribute, $value, $fail) {
                    BaseValidation::base64ratio($attribute, $value, $fail, 15, 7);
                }
            ],
            'mobile_banner' => ['nullable', 'string', 'base64max:3072', 'base64image:image', 'base64mimes:webp,png,jpeg,jpg',
                function ($attribute, $value, $fail) {
                    BaseValidation::base64ratio($attribute, $value, $fail, 3, 2);
                }
            ],
            'keyword' => [
                'nullable',
                'array',
                'max:100',
            ],
            'keyword.*' => [
                'required',
                'string',
                'max:200',
                'min:3'
            ],

        ]);

        $data = removeSpace($data, ['name'], '_');
        $data['keyword'] = isset($data['keyword']) ? implode(',', $data['keyword']) : null;

        return $data;

    }

    private function getNeedData($data)
    {
        $fillable = app(Tag::class)->getFillable();
        $fillable = unsetValue($fillable, ['img', 'banner', 'mobile_banner']);
        return Arr::only($data, $fillable);
    }

    public function destroy(Tag $tag)
    {

        $tag->delete();

        alert()->success('حذف شد', 'به صورت کامل حذف شد 👍😉')->persistent(true, false)->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }

    public function deleteImg(Tag $tag)
    {

        BaseImage::baseDeleteImg($tag, \request()->type);

        return \request()->type;

    }


}
