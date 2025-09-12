<?php

namespace App\Http\Controllers\Admin;

use App\facade\BaseImage\BaseImage;
use App\facade\BaseMethod\BaseMethod;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class CommentController extends Controller
{

    public $comments = [];
    private $prefix = 'admin.comment.';
    private $model = 'comment';
    private $table = 'comments';

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


        $comment = Comment::query()->with([
            'user' => function ($query){
            $query->select(['id','name','username','updated_at','avatar']);
            },
            'commentable'
        ])->orderBy('id','desc');


        if ($keyword = \request('search')) {
            $comment = $comment->where('content', 'LIKE', "%{$keyword}%")->orWhere('title', 'LIKE', "%{$keyword}%");
        }


        $list = $comment->paginate(30);


        return view($this->prefix . $this->model , compact('list'));
    }
//
//    public function create()
//    {
//
//        return view($this->prefix . 'create.' . $this->model);
//
//    }

//    public function store(Request $request)
//    {
//
//
//        $data = $this->validationProduct($request);
//
//
//        $object = Comment::query()->create($data);
//
//
//
//        alert()->success('ثبت شد', 'همه چی به خوبی ثبت شد 👍😉')->persistent(true, false)->timerProgressBar();
//
//        return redirect(route($this->prefix . 'index'));
//    }


    public function edit(Comment $comment)
    {

        return view($this->prefix . 'create.' . $this->model ,compact($this->model));

    }

    public function update(Request $request, Comment $comment)
    {

        $data = $this->validationProduct($request, true, $comment);


        $comment->update($data);

        toast('اطلاعات ثبت شد 👍😉', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }


    public function destroy(Comment $comment)
    {


        $this->pushIdForDeleteComments($comment);

        Comment::query()->whereIn('id',$this->comments)->each(function ($comm){
            $comm->delete();
        });

        alert()->success('حذف شد', 'به صورت کامل حذف شد 👍😉')->persistent(true, false)->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }

    public function pushIdForDeleteComments($object){

        array_push($this->comments,$object->id);

        $childes = $object->child;
        if ($object->child->first()){
            foreach ($childes as $childe){
                $this->pushIdForDeleteComments($childe);
            }
        }


    }
    public function preview($comment){

        $comment = Comment::query()->with([
            'user' => function ($query){
                $query->select(['id','name','username','updated_at','avatar']);
            },
        ])->find($comment);
        $comments = new Collection;
        $comments->put($comment->id ,$comment);

        BaseMethod::putParentsInCollection($comment,$comments);
        BaseMethod::treeTheElemantsByChild($comments);
        $mainComment = $comment;

        return view('admin.comment.preview.preview' , compact('comments','mainComment'));
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
            'title' => ['required', 'string', 'max:300', 'min:3'],
            'content' => ['required', 'string', 'max:65500', 'min:3'],

            'active' => [
                'nullable',
                Rule::in('on')
            ],

        ]);



        $data = setCheckboxValue($data, [ 'active']);



        return $data;

    }











}
