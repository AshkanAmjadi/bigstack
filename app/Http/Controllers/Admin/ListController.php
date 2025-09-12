<?php

namespace App\Http\Controllers\Admin;

use App\facade\BaseCat\BaseCat;
use App\facade\BaseImage\BaseImage;
use App\facade\BaseMethod\BaseMethod;
use App\facade\BaseSort\BaseSort;
use App\facade\BaseValidation\BaseValidation;
use App\Http\Controllers\Controller;
use Modules\Content\App\Models\Category;
use App\Models\Lists;
use Modules\Content\App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ListController extends Controller
{
    private $prefix = 'admin.list.';
    private $model = 'list';


    public function __construct()
    {
//        $this->middleware('can:show_' . $this->model)->only(['index']);
//        $this->middleware('can:create_' . $this->model)->only(['create', 'store']);
//        $this->middleware('can:edit_' . $this->model)->only(['edit', 'update', 'deleteImg']);
//        $this->middleware('can:delete_' . $this->model)->only(['destroy']);
//        $this->middleware('can:force_delete_' . $this->model)->only(['forceDelete']);
//        $this->middleware('can:restore_' . $this->model)->only(['restore']);
//        $this->middleware('can:icon_' . $this->model)->only(['showIcon', 'deleteIcon', 'setIcon']);
//        $this->middleware('can:banner_' . $this->model)->only(['showBanner', 'deleteBanner', 'setBanner']);
//        $this->middleware('can:sort_' . $this->model)->only(['sort', 'setsort']);
    }

    public function index(Request $request)
    {

        $parent_id = $request->parent_id ? $request->parent_id : 0;

        $nav = Lists::query()->where('parent_id', '=', $parent_id)->orderBy('sort')->get();

        $parent = $parent_id != 0 ? Lists::query()->find($parent_id) : null;


        if ($parent) {
            $level = BaseMethod::getLevel($parent);
        } else {
            $level = 0;
        }

        $allCat = BaseCat::getAll();

        if ($level >= 3) {
            abort(404);
        }


        return view($this->prefix . $this->model, compact('nav', 'parent_id', 'parent', 'level', 'allCat'));
    }


    public function store(Request $request)
    {


        $data = $this->validationLists($request);

//        dd();

//        dd($data);

        $save = Arr::only($data, ['name', 'type', 'parent_id', 'link', 'sort']);
        if ($data['type'] == 'link') {
            $obj = Lists::query()->create($save);

        } elseif ($save['type'] == 'category') {
            $cat = Category::query()->findOrFail($request->category);
            $obj = $cat->lists()->create($save);
            $obj->update(['link'=> route('category.show', ['category' => $cat->slug])]);

        } elseif ($save['type'] == 'page') {
            $obj = Page::query()->findOrFail($request->page)->lists()->create($save);

        }

        if ($obj) {
            BaseImage::saveBase64image(Arr::get($data, 'icon'), $obj, 'icon');
            BaseImage::saveBase64image(Arr::get($data, 'dark_icon'), $obj, 'dark_icon');
        }

        alert()->success('ثبت شد', 'همه چی به خوبی ثبت شد 👍😉')->persistent(true, false)->timerProgressBar();

        return redirect()->back();

    }

    public function update(Request $request, Lists $list)
    {


        $data = $this->validationLists($request, true, $list);

        $save = Arr::only($data, ['name', 'type', 'parent_id', 'link', 'sort']);

        if ($save['type'] == 'link') {

            $list->update(BaseMethod::changeData($save, [
                'listable_type' => null,
                'listable_id' => null
            ]));

        } elseif ($save['type'] == 'category') {
            $cat = Category::query()->findOrFail($request->category);

            $list->update(BaseMethod::changeData($save,
                [
                    'listable_type' => 'Modules\Content\App\Models\Category',
                    'listable_id' => $data['category'],
                    'link' => route('category.show', ['category' => $cat->slug])
                ]
            ));
        } elseif ($save['type'] == 'page') {
            $list->update(BaseMethod::changeData($save,
                [
                    'listable_type' => 'Modules\Content\App\Models\Page',
                    'listable_id' => $data['page']
                ]
            ));
        }

        BaseImage::saveBase64image(Arr::get($data, 'icon'), $list, 'icon');
        BaseImage::saveBase64image(Arr::get($data, 'dark_icon'), $list, 'dark_icon');

        toast('اطلاعات به روز شد 👍😉', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route($this->prefix . 'index', ['parent_id' => $data['parent_id']]));


    }


    private function validationLists($request, $update = false, $object = null)
    {

        $unique_validation = 'unique:' . $this->model;

        if ($update) {
            $unique_validation = Rule::unique($this->model)->ignore($object->id);
        }


//        dd($request->all());
//        BaseRequest::replaceToSpace($request, ['slug']);

        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:200'],
            'type' => [
                'required',
                Rule::in('category', 'page', 'link')
            ],
            'icon' => ['nullable', 'string', 'base64max:1024', 'base64image:image', 'base64mimes:jpg,jpeg,png,webp'],
            'dark_icon' => ['nullable', 'string', 'base64max:1024', 'base64image:image', 'base64mimes:jpg,jpeg,png,webp'],

            'parent_id' => [
                'required',
                'min:0',
                'max:999999999999999',
                'numeric',
                function ($attribute, $value, $fail) use ($update, $object) {

                    if ($update) {
                        if ($object->parent_id != $value) {
                            $fail('Something went wrong');
                        }

                    } else {
                        if ($value !== '0') {
                            $parent = Lists::query()->select('id', 'parent_id')->find($value);
                            if ($parent === null) {
                                $fail('Something went wrong');

                            }

                            if (BaseMethod::getLevel($parent) >= 3) {
                                $fail('این لیست دو پدر دارد');
                            }
                        }
                    }

                }

            ],
            'link' => [
                'string',
                'max:6000',
                'nullable',
                BaseValidation::validationForLink(),

            ],
            'category' => [

                'numeric',
                function ($attribute, $value, $fail) use ($update, $object, $request) {

                    if ($request->type == 'category' and !Category::query()->find($value)) {
                        $fail('دسته یافت نشد');
                    }


                }

            ],
            'page' => [
                'numeric',
                function ($attribute, $value, $fail) use ($update, $object, $request) {

                    if ($request->type == 'page' && !Page::query()->find($value)) {
                        $fail('صفحه یافت نشد');
                    }


                }

            ],

        ]);

        if (!$update) {
            $data = BaseSort::sortThanBrother(Lists::query(), $data);
        }


        return $data;

    }


    public function setsort(Request $request, $list)
    {

        $sort = BaseSort::validSort($request);


        $lists = Lists::query()->where('parent_id', $list)->get('id');

        BaseSort::baseSetSort($lists, $sort);

        toast('همه به خوبی مرتب شدن 👍😉', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();


//        dd('همه به خوبی مرتب شدن 👍😉');
        return redirect(route($this->prefix . 'index', ['parent_id' => $list]));

    }

    public function destroy(Lists $list)
    {

        BaseCat::deleteCatViaProduct($list);

        alert()->success('ثبت شد', 'لیست پاک شد 👍😉')->persistent(true, false)->timerProgressBar();


        return back();
    }

    public function deleteImg(Lists $lists)
    {

        BaseImage::baseDeleteImg($lists, \request()->type);

        return \request()->type;

    }

}
