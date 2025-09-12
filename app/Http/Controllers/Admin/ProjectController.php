<?php

namespace App\Http\Controllers\Admin;

use App\facade\BaseImage\BaseImage;
use App\facade\BaseMethod\BaseMethod;
use App\facade\BaseValidation\BaseValidation;
use App\Http\Controllers\Controller;
use App\Models\Possible;
use App\Models\Project;
use Modules\Content\App\Models\Category;
use App\Models\Service;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{

    private $prefix = 'admin.project.';
    private $model = 'project';
    private $table = 'project';

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


        $project = Project::query()->with([
            'service' => function ($query) {
                $query->select(['id', 'name', 'img']);
            },
            'tags' => function ($query) {
                $query->select(['id', 'name']);
            }
        ])->orderBy('id', 'desc')->withUserData();


        if ($keyword = \request('search')) {
            $project = $project->where('page_title', 'LIKE', "%{$keyword}%");
        }


        $list = $project->paginate(20);


        return view($this->prefix . $this->model, compact('list'));
    }

    public function create()
    {

        return view($this->prefix . 'create.' . $this->model);

    }

    public function store(Request $request)
    {


        $data = $this->validationProduct($request);

        $need_data = $this->getNeedData($data);

        $object = Project::query()->create($need_data);

        BaseImage::saveBase64image(Arr::get($data, 'img'), $object, 'img', false, null, null, true);
        BaseImage::saveBase64image(Arr::get($data, 'banner'), $object, 'banner', false, null, null, true);
        BaseImage::saveBase64image(Arr::get($data, 'mobile_banner'), $object, 'mobile_banner', false, null, null, true);

        $object->tags()->sync($data['tags']);

        alert()->success('ثبت شد', 'همه چی به خوبی ثبت شد 👍😉')->persistent(true, false)->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }


    public function edit(Project $project)
    {

        ;
        return view($this->prefix . 'create.' . $this->model, compact($this->model));

    }

    public function update(Request $request, Project $project)
    {

//        dd($request->all());
        $data = $this->validationProduct($request, true, $project);

        $need_data = $this->getNeedData($data);


        $project->update($need_data);

        BaseImage::saveBase64image(Arr::get($data, 'img'), $project, 'img', false, null, null, true);
        BaseImage::saveBase64image(Arr::get($data, 'banner'), $project, 'banner', false, null, null, true);
        BaseImage::saveBase64image(Arr::get($data, 'mobile_banner'), $project, 'mobile_banner', false, null, null, true);

        $project->tags()->sync($data['tags']);

        toast('اطلاعات ثبت شد 👍😉', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }


    public function destroy(Project $project)
    {

        $project->delete();

        alert()->success('حذف شد', 'به صورت کامل حذف شد 👍😉')->persistent(true, false)->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }


    private function validationProduct($request, $update = false, $object = null)
    {

//        dd($request->all());

        $unique_validation = 'unique:' . $this->table;
        $imgEdit = 'required';

        if ($update) {
            $unique_validation = Rule::unique($this->table)->ignore($object->id);
            $imgEdit = 'nullable';
        }

        $data = $request->validate([
            'page_title' => ['required', 'string', 'max:600', 'min:3', $unique_validation],
            'title' => ['required', 'string', 'max:600', 'min:3', $unique_validation],
            'slug' => ['required', 'string', 'max:1000', 'min:3', $unique_validation],
            'meta_description' => ['required', 'string', 'max:600', 'min:3', $unique_validation],
            'service_id' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    if (Service::query()->select('id')->find($value) === null) {
                        $fail('سرویس پیدا نشد:' . $value);
                    }
                }
            ],
            'tags' => [
                'array',
                'min:1',
                'max:12',
                function ($attribute, $value, $fail) {
                    BaseValidation::tagsValidation($attribute, $value, $fail);
                }
            ],
            'preview_page' => [
                'required',
                'string',
                'max:6000',
                BaseValidation::validationForLink(),
            ],
            'active' => [
                'nullable',
                Rule::in('on')
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

            'img' => [$imgEdit, 'string', 'base64max:3072', 'base64image:image', 'base64mimes:webp,png,jpeg,jpg',
                function ($attribute, $value, $fail) {
                    BaseValidation::base64ratio($attribute, $value, $fail, 3, 2);
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

        ]);


        $data = BaseMethod::createTagIfNotExsist($data, Tag::query());

        $data = setCheckboxValue($data, ['active']);

        $data = removeSpace($data, ['slug'], '-');
        $data['keyword'] = isset($data['keyword']) ? implode(',', $data['keyword']) : null;

        return $data;

    }


    public function showDesc(Project $project)
    {

        return view($this->prefix . 'description', compact($this->model));

    }

    public function setDesc(Request $request, Project $project)
    {
//        dd($request->all());

        $data = $request->validate([
            'description' => [
                'string',
                'max:16777215',
                function ($attribute, $value, $fail) {
                    BaseValidation::editorjsValidation($attribute, $value, $fail);
                }
            ],
        ]);

        $data['description'] = BaseImage::saveEditorJsImages($project,$data['description']);


        $project->update($data);

        alert()->success('ثبت شد', 'توضیحات شما ثبت شد 👍😉')->persistent(true, false)->timerProgressBar();


        return redirect(route($this->prefix . 'index'));

    }

    public function showPossible(Project $project)
    {

        return view($this->prefix . 'possible', compact($this->model));

    }

    public function setPossible(Request $request, Project $project)
    {

        $data = $request->validate([
            'possible_ids' => [
                'array',
                function ($attribute, $value, $fail) {
                    BaseValidation::PossibleValidation($attribute, $value, $fail);

                }
            ],
        ]);

        BaseMethod::removeCacheDynamic($project, ['tags', 'possible', 'plans', 'added_by', 'service', 'schema']);

        if (isset($data['possible_ids'])) {
            $project->possible()->sync($data['possible_ids']);
        } else {
            $project->possible()->sync([]);
        }

        alert()->success('ثبت شد', 'امکانات پروژه ثبت شد 👍😉')->persistent(true, false)->timerProgressBar();


        return redirect(route($this->prefix . 'index'));

    }


    public function getNeedData($data)
    {
        $fillable = app(Project::class)->getFillable();
        $fillable = unsetValue($fillable, ['img', 'banner', 'mobile_banner']);
        return Arr::only($data, $fillable);
    }


}
