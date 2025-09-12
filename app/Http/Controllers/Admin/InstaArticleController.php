<?php

namespace App\Http\Controllers\Admin;

use App\facade\BaseImage\BaseImage;
use App\facade\BaseMethod\BaseMethod;
use App\facade\BaseValidation\BaseValidation;
use App\Http\Controllers\Controller;
use Modules\Content\App\Models\Category;
use App\Models\InstaArticle;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class InstaArticleController extends Controller
{

    private $prefix = 'admin.instaArticle.';
    private $model = 'instaArticle';
    private $table = 'insta_articles';
    private $name = 'insta_article';

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


        $instaArticle = InstaArticle::query()->with([
            'category' => function ($query){
            $query->select(['id','name']);
            }
        ])->orderBy('id','desc')->withUserData();


        if ($keyword = \request('search')) {
            $instaArticle = $instaArticle->where('title', 'LIKE', "%{$keyword}%");
        }


        $list = $instaArticle->orderBy('id','desc')->paginate(20);

//        dd($list);

        return view("admin.$this->name.$this->name", compact('list'));
    }

    public function create()
    {

        return view("admin.$this->name.create.$this->name");

    }

    public function store(Request $request)
    {

        $data = $this->validationInstaArticle($request);

        $need_data = $this->getNeedData($data);

        $object = InstaArticle::query()->create($need_data);

        $object->tags()->sync($data['tags']);

        BaseImage::saveBase64image(Arr::get($data,'img'),$object,'img');

        alert()->success('ثبت شد', 'همه چی به خوبی ثبت شد 👍😉')->persistent(true, false)->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }

    public function edit(InstaArticle $instaArticle)
    {
        return view("admin.$this->name.create.$this->name", compact($this->model));
    }

    public function update(Request $request, InstaArticle $instaArticle)
    {
        $data = $this->validationInstaArticle($request, true, $instaArticle);

        $need_data = $this->getNeedData($data);

        $instaArticle->update($need_data);

        $instaArticle->tags()->sync($data['tags']);

        BaseImage::saveBase64image(Arr::get($data,'img'),$instaArticle,'img');

        toast('اطلاعات ثبت شد 👍😉', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }



    public function destroy(InstaArticle $instaArticle)
    {
        deleteDirIfExist(filePathMaker('image/' . $this->table . '/' . $instaArticle->id));

        $instaArticle->tags()->detach();

        $instaArticle->delete();

        alert()->success('حذف شد', 'به صورت کامل حذف شد 👍😉')->persistent(true, false)->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }

    private function validationInstaArticle($request, $update = false, $object = null)
    {

//        dd($request->all());

        $unique_validation = 'unique:' . $this->table;
        $imgEdit = 'required';

        if ($update) {
            $imgEdit = 'nullable';
            $unique_validation = Rule::unique($this->table)->ignore($object->id);
        }


        $data = $request->validate([
            'title' => ['required', 'string', 'max:300', 'min:3', $unique_validation],
            'caption' => ['required','string', 'max:65500', 'min:3'],
            'link' => [
                'required',
                'string',
                'max:6000',
                BaseValidation::validationForLink(),
                $unique_validation
            ],
            'category' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    if (Category::query()->select('id')->find($value, ['id']) === null) {
                        $fail('faction not found id:' . $value);
                    }
                }
            ],

            'tags' => [
                'array',
                'max:12',
                function ($attribute, $value, $fail) {
                    BaseValidation::tagsValidation($attribute, $value, $fail);
                }
            ],
//            'usages' => [
//                'array',
//                function ($attribute, $value, $fail) {
//                    BaseValidation::usagesValidation($attribute, $value, $fail);
//                }
//            ],
//            'products' => [
//                'array',
//                function ($attribute, $value, $fail) {
//                    BaseValidation::productsValidation($attribute, $value, $fail);
//                }
//            ],
            'active' => [
                'nullable',
                Rule::in('on')
            ],
            'img' => [$imgEdit, 'string', 'base64max:3072', 'base64image:image', 'base64mimes:webp,png,jpeg,jpg',
                function ($attribute, $value, $fail) {
                    BaseValidation::base64ratio($attribute, $value, $fail,5,4);
                }
            ],
        ]);


        $data = BaseMethod::createTagIfNotExsist($data, Tag::query());

        $data = setCheckboxValue($data, ['active']);

        //todo add select inputs to this
        $data = setSelectInputValue($data, ['tags'], []);



        return $data;

    }

    private function getNeedData($data)
    {
        $fillable = app(InstaArticle::class)->getFillable();
        $fillable = unsetValue($fillable,'img');
        return Arr::only($data,$fillable);
    }


}
