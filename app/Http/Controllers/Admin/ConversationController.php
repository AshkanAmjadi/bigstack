<?php

namespace App\Http\Controllers\Admin;

use App\facade\BaseMethod\BaseMethod;
use App\facade\BaseValidation\BaseValidation;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ConversationController extends Controller
{

    private $prefix = 'admin.conversation.';
    private $model = 'conversation';
    private $table = 'conversations';
    private $name = 'conversation';

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


        $conversation = Conversation::query()->with([
            'user' => function ($query){
            $query->select(['id','name','username','updated_at','avatar']);
            }
        ])->orderBy('id','desc')->withUserData();


        if ($keyword = \request('search')) {
            $conversation = $conversation->where('title', 'LIKE', "%{$keyword}%");
        }


        $list = $conversation->paginate(20);


        return view($this->prefix . $this->model, compact('list'));
    }

    public function create()
    {

        return view("admin.$this->name.create.$this->name");

    }

    public function store(Request $request)
    {

        $data = $this->validationConversation($request);

        $need_data = $this->getNeedData($data);

        $object = Conversation::query()->create($need_data);

        $object->tags()->sync($data['tags']);

        $object->update(['new' => false]);

//        BaseImage::saveBase64image(Arr::get($data,'img'),$object,'img');

        alert()->success('ثبت شد', 'همه چی به خوبی ثبت شد 👍😉')->persistent(true, false)->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }

    public function edit(Conversation $conversation)
    {
        return view("admin.$this->name.create.$this->name", compact($this->model));

    }

    public function update(Request $request, Conversation $conversation)
    {
        $data = $this->validationConversation($request, true, $conversation);

        $need_data = $this->getNeedData($data);

        $conversation->update($need_data);

        $conversation->tags()->sync($data['tags']);

        toast('اطلاعات ثبت شد 👍😉', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }



    public function destroy(Conversation $conversation)
    {






        $conversation->delete();

        alert()->success('حذف شد', 'به صورت کامل حذف شد 👍😉')->persistent(true, false)->timerProgressBar();

        return redirect()->back();
    }




    private function validationConversation($request, $update = false, $object = null)
    {



        $unique_validation = 'unique:' . $this->table;

        if ($update) {
            $unique_validation = Rule::unique($this->table)->ignore($object->id);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:400', 'min:3', $unique_validation],
            'description' => [
                'string',
                'max:16777215',
                function ($attribute, $value, $fail) {
                    BaseValidation::editorjsValidation($attribute, $value, $fail);
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

            'active' => [
                'nullable',
                Rule::in('on')
            ],
        ]);

        $data = BaseMethod::createTagIfNotExsist($data, Tag::query());

        $data = setCheckboxValue($data, ['active']);

        $data = setSelectInputValue($data, ['tags'], []);

        $data = BaseMethod::setSomeValuesBySendedData($data, ['slug' => 'title']);

        $data = removeSpace($data, ['slug'], '-');




        return $data;

    }

    private function getNeedData($data)
    {
        $fillable = app(Conversation::class)->getFillable();
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
