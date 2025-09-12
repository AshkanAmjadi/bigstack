<?php

namespace Modules\Content\App\Http\Controllers\Admin;

use App\facade\BaseImage\BaseImage;
use App\facade\BaseValidation\BaseValidation;
use App\Http\Controllers\Controller;
use Modules\Content\App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class PageController extends Controller
{

    private $prefix = 'admin.page.';
    private $model = 'page';
    private $table = 'page';
    private $name = 'page';

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


        $page = Page::query()->orderBy('id','desc')->withUserData();


        if ($keyword = \request('search')) {
            $page = $page->where('title', 'LIKE', "%{$keyword}%");
        }


        $list = $page->paginate(20);


        return view('content::'.$this->prefix . $this->model, compact('list'));
    }

    public function create()
    {

        return view('content::'."admin.$this->name.create.$this->name");

    }

    public function store(Request $request)
    {

        $data = $this->validationpage($request);

        $need_data = $this->getNeedData($data,['content']);

        $page = Page::query()->create($need_data);


        //save desc
        $descData =[];
        $descData['content'] = $data['content'];
        $descData['content'] = BaseImage::saveEditorJsImages($page,$descData['content']);
        $page->update($descData);


        alert()->success('ثبت شد', 'همه چی به خوبی ثبت شد 👍😉')->persistent(true, false)->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }

    public function edit(Page $page)
    {
        return view('content::'."admin.$this->name.create.$this->name", compact($this->model));

    }

    public function update(Request $request, Page $page)
    {
        $data = $this->validationpage($request, true, $page);

        $need_data = $this->getNeedData($data);

        $need_data['content'] = BaseImage::saveEditorJsImages($page,$need_data['content']);

        $page->update($need_data);


        toast('اطلاعات ثبت شد 👍😉', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }



    public function destroy(Page $page)
    {



//        $page->gallery()->delete();
//        $page->tags()->detach();
//        $page->usages()->detach();
//        $page->products()->detach();

        if ($page->lists->first()){
            alert()->error('حذف نشد', 'این مورد در لیست وجود دارد اول لیست های این مورد را حذف کنید')->persistent(true, false)->timerProgressBar();

            return redirect()->back();
        }

        $page->delete();


        alert()->success('حذف شد', 'به صورت کامل حذف شد 👍😉')->persistent(true, false)->timerProgressBar();

        return redirect()->back();
    }




    private function validationpage($request, $update = false, $object = null)
    {



        $unique_validation = 'unique:' . $this->table;

        if ($update) {
            $unique_validation = Rule::unique($this->table)->ignore($object->id);
        }

        $data = $request->validate([
            'page_title' => ['required', 'string', 'max:600', 'min:3', $unique_validation],
            'title' => ['required', 'string', 'max:600', 'min:3',$unique_validation],
            'slug' => ['required','string', 'max:1000', 'min:3',$unique_validation],
            'meta_description' => ['required', 'string', 'max:600', 'min:3',$unique_validation],
            'content' => [
                'string',
                'max:16777215',
                function ($attribute, $value, $fail) {
                    BaseValidation::editorjsValidation($attribute, $value, $fail);
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
        ]);




        $data = setCheckboxValue($data, ['active']);

        $data = removeSpace($data, ['slug'], '-');
        $data['keyword'] = isset($data['keyword']) ? implode(',', $data['keyword']) : null;




        return $data;

    }

    private function getNeedData($data,$delete =null)
    {
        $fillable = app(Page::class)->getFillable();
        if ($delete){
            $fillable = unsetValue($fillable,$delete);
        }
        return Arr::only($data,$fillable);
    }
//todo all comment with child eager loading
//    public function all($newsId)
//    {
//        $comments = NewsComment::where('news_id', $newsId)->get();
//        $comments_by_id = new Collection;
//
//        foreach ($comments as $comment)
//        {
//            $comments_by_id->put($comment->id, $comment);
//        }
//
//        foreach ($comments as $key => $comment)
//        {
//            $comments_by_id->get($comment->id)->children = new Collection;
//
//            if ($comment->parent_id != 0)
//            {
//                $comments_by_id->get($comment->parent_id)->children->push($comment);
//                unset($comments[$key]);
//            }
//        }
//
//        return $comments;
//    }


}
