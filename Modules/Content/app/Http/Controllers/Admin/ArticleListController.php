<?php

namespace Modules\Content\App\Http\Controllers\Admin;

use App\facade\BaseImage\BaseImage;
use App\facade\BaseValidation\BaseValidation;
use App\Http\Controllers\Controller;
use Modules\Content\App\Models\Article;
use Modules\Content\App\Models\ArticleList;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ArticleListController extends Controller
{

    private $prefix = 'admin.articleList.';
    private $model = 'articleList';
    private $table = 'article_list';

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


        $articleList = ArticleList::query()->withUserData();


        if ($keyword = \request('search')) {
            $articleList = $articleList->where('title', 'LIKE', "%{$keyword}%");
        }


        $list = $articleList->paginate(20);

//        dd($list);

        return view('content::'.$this->prefix . $this->model, compact('list'));
    }

    public function create()
    {

        return view('content::'."admin.$this->model.create.$this->model");


    }

    public function store(Request $request)
    {

        $data = $this->validationProduct($request);

        $need_data = $this->getNeedData($data);

        $object = ArticleList::query()->create($need_data);

        BaseImage::saveBase64image(Arr::get($data, 'banner'), $object, 'banner', false, null, null, true);
        BaseImage::saveBase64image(Arr::get($data, 'mobile_banner'), $object, 'mobile_banner', false, null, null, true);

        alert()->success('ثبت شد', 'همه چی به خوبی ثبت شد 👍😉')->persistent(true, false)->timerProgressBar();


        return redirect(route($this->prefix . 'index'));
    }


    public function edit(ArticleList $articleList)
    {
        return view('content::'."admin.$this->model.create.$this->model", compact($this->model));
    }

    public function update(Request $request, ArticleList $articleList)
    {
        $data = $this->validationProduct($request, true, $articleList);

        $need_data = $this->getNeedData($data);


        $articleList->update($need_data);


        BaseImage::saveBase64image(Arr::get($data, 'banner'), $articleList, 'banner', false, null, null, true);
        BaseImage::saveBase64image(Arr::get($data, 'mobile_banner'), $articleList, 'mobile_banner', false, null, null, true);

        toast('اطلاعات ثبت شد 👍😉', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }


    private function getNeedData($data)
    {
        $fillable = app(ArticleList::class)->getFillable();
        $fillable = unsetValue($fillable, ['banner', 'mobile_banner']);
        return Arr::only($data, $fillable);
    }

    public function destroy(ArticleList $articleList)
    {

        $articleList->delete();

        alert()->success('حذف شد', 'به صورت کامل حذف شد 👍😉')->persistent(true, false)->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }

    private function validationProduct($request, $update = false, $object = null)
    {


        $unique_validation = 'unique:' . $this->table;

        if ($update) {
            $unique_validation = Rule::unique($this->table)->ignore($object->id);
        }


        $data = $request->validate([
            'page_title' => ['required', 'string', 'max:600', 'min:3', $unique_validation],
            'title' => ['required', 'string', 'max:600', 'min:3', $unique_validation],
            'slug' => ['required', 'string', 'max:1000', 'min:3', $unique_validation],
            'meta_description' => ['required', 'string', 'max:600', 'min:3', $unique_validation],
            'articles' => [
                'required',
                'array',
                'max:3000000',
                function ($attribute, $value, $fail) {
                    BaseValidation::ArticleValidation($attribute, $value, $fail);
                }
            ],
            'active' => [
                'nullable',
                Rule::in('on')
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


        $data = setCheckboxValue($data, ['active']);

        $data['articles'] = implode(',', $data['articles']);

        $data['keyword'] = isset($data['keyword']) ? implode(',', $data['keyword']) : null;

        $data = removeSpace($data, ['slug'], '-');

        return $data;

    }

    public function search()
    {

        if ($keyword = \request('search')) {
            $articles = Article::query()
                ->where('title', 'LIKE', "%{$keyword}%")
                ->orWhere('meta_description', 'LIKE', "%{$keyword}%")
                ->orWhere('page_title', 'LIKE', "%{$keyword}%")
                ->orWhere('slug', 'LIKE', "%{$keyword}%")
                ->limit(50)
                ->get(['id', 'title', 'img']);
        } else {
            dd();
        }

        return view('content::'.'admin.articleList.search', compact('articles'));
    }


    public function deleteImg(ArticleList $articleList)
    {

        BaseImage::baseDeleteImg($articleList, \request()->type);

        return \request()->type;

    }


}
