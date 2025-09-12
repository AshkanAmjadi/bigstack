<?php

namespace Modules\Content\App\Http\Controllers\Admin;

use App\facade\BaseImage\BaseImage;
use App\facade\BaseMethod\BaseMethod;
use App\facade\BaseValidation\BaseValidation;
use App\Http\Controllers\Controller;
use Modules\Content\App\Models\Article;
use Modules\Content\App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{

    private $prefix = 'admin.article.';
    private $model = 'article';
    private $table = 'article';

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


        $article = Article::query()->with([
            'user' => function ($query){
            $query->select(['id','name','username','updated_at','avatar']);
            },
            'tags' => function ($query){
                $query->select(['id','name']);
            }
        ])->orderBy('id','desc')->withUserData();


        if ($keyword = \request('search')) {
            $article = $article->where('page_title', 'LIKE', "%{$keyword}%");
        }


        $list = $article->paginate(20);


        return view('content::'.$this->prefix . $this->model , compact('list'));
    }

    public function create()
    {

        return view('content::'.$this->prefix . 'create.' . $this->model);

    }

    public function store(Request $request)
    {



        $data = $this->validationProduct($request);

        $need_data = $this->getNeedData($data);

        $object = Article::query()->create($need_data);

        BaseImage::saveBase64image(Arr::get($data,'img'),$object,'img',false,null,null,true);

        $object->tags()->sync($data['tags']);

        alert()->success('ثبت شد', 'همه چی به خوبی ثبت شد 👍😉')->persistent(true, false)->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }


    public function edit(Article $article)
    {

;
        return view('content::'.$this->prefix . 'create.' . $this->model ,compact($this->model));

    }

    public function update(Request $request, Article $article)
    {

        $data = $this->validationProduct($request, true, $article);


        $need_data = $this->getNeedData($data);

        $article->update($need_data);


        BaseImage::saveBase64image(Arr::get($data,'img'),$article,'img',false,null,null,true);

        $article->tags()->sync($data['tags']);

        toast('اطلاعات ثبت شد 👍😉', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }


    public function destroy(Article $article)
    {

        $article->delete();

        alert()->success('حذف شد', 'به صورت کامل حذف شد 👍😉')->persistent(true, false)->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }



    private function validationProduct($request, $update = false, $object = null)
    {


        $unique_validation = 'unique:' . $this->table;
        $imgEdit = 'required';

        if ($update) {
            $unique_validation = Rule::unique($this->table)->ignore($object->id);
            $imgEdit = 'nullable';
        }

        $data = $request->validate([
            'page_title' => ['required', 'string', 'max:600', 'min:3', $unique_validation],
            'title' => ['required', 'string', 'max:600', 'min:3',$unique_validation],
            'slug' => ['required','string', 'max:1000', 'min:3',$unique_validation],
            'alt' => ['nullable','string', 'max:1000', 'min:3'],
            'caption' => ['nullable','string', 'max:1000', 'min:3'],
            'meta_description' => ['required', 'string', 'max:600', 'min:3',$unique_validation],
            'category' => [
                'required',
                'string',
                'max:30',
                function ($attribute, $value, $fail) {
                    if (Category::query()->select('id')->find($value, ['id']) === null) {
                        $fail('faction not found id:' . $value);
                    }
                }
            ],
            'read_time' => [
                'required',
                'numeric',
                'min:1',
                'max:180',
                BaseValidation::validationForNum()
            ],
            'tags' => [
                'array',
                'max:12',
                function ($attribute, $value, $fail) {
                    BaseValidation::tagsValidation($attribute, $value, $fail);
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

            'active' => [
                'nullable',
                Rule::in('on')
            ],
            'level' => [
                'nullable',
                Rule::in('0','1','2','3')
            ],
            'img' => [$imgEdit, 'string', 'base64max:3072', 'base64image:image', 'base64mimes:webp,png,jpeg,jpg',
                function ($attribute, $value, $fail) {
                    BaseValidation::base64ratio($attribute, $value, $fail,3,2);
                }
            ],

        ]);


        $data = BaseMethod::createTagIfNotExsist($data, Tag::query());
        $data = setCheckboxValue($data, [ 'active']);
        $data = removeSpace($data, ['slug'], '-');
        $data['keyword'] = isset($data['keyword']) ? implode(',',$data['keyword']) : null;



        return $data;

    }




    public function showDesc(Article $article)
    {

        return view('content::'.$this->prefix . 'description', compact($this->model));

    }

    public function setDesc(Request $request, Article $article)
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

        $data['description'] = BaseImage::saveEditorJsImages($article,$data['description']);

        $article->update($data);

        alert()->success('ثبت شد', 'توضیحات شما ثبت شد 👍😉')->persistent(true, false)->timerProgressBar();


        return redirect(route($this->prefix . 'index'));

    }


    public function getNeedData($data)
    {
        $fillable = app(Article::class)->getFillable();
        $fillable = unsetValue($fillable,'img');
        return Arr::only($data,$fillable);
    }



}
