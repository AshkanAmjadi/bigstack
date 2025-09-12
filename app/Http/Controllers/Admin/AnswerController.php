<?php

namespace App\Http\Controllers\Admin;

use App\facade\BaseImage\BaseImage;
use App\facade\BaseMethod\BaseMethod;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class AnswerController extends Controller
{

    private $prefix = 'admin.answer.';
    private $model = 'answer';
    private $table = 'answer';

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


        $answer = Answer::query()->with([
            'user' => function ($query){
            $query->select(['id','name','username','updated_at','avatar']);
            },
            'conversation' => function ($query){
            $query->select(['id','title','slug']);
            },
        ])->orderBy('id','desc');


        if ($keyword = \request('search')) {
            $answer = $answer->where('content', 'LIKE', "%{$keyword}%")->orWhere('title', 'LIKE', "%{$keyword}%");
        }


        $list = $answer->paginate(20);


        return view($this->prefix . $this->model , compact('list'));
    }

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
//        $object = Answer::query()->create($data);
//
//
//        $object->tags()->sync($data['tags']);
//
//        alert()->success('ثبت شد', 'همه چی به خوبی ثبت شد 👍😉')->persistent(true, false)->timerProgressBar();
//
//        return redirect(route($this->prefix . 'index'));
//    }


    public function edit(Answer $answer)
    {

        return view($this->prefix . 'create.' . $this->model ,compact($this->model));

    }

    public function update(Request $request, Answer $answer)
    {

        $data = $this->validationProduct($request, true, $answer);


        $answer->update($data);

        toast('اطلاعات ثبت شد 👍😉', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }


    public function destroy(Answer $answer)
    {

        $answer->delete();

        alert()->success('حذف شد', 'به صورت کامل حذف شد 👍😉')->persistent(true, false)->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }


    public function delete($object){

    }
    public function preview($answer){

        $answer = Answer::query()->with([
            'user' => function ($query){
                $query->select(['id','name','username','updated_at','avatar']);
            },
        ])->find($answer);
        $answers = new Collection;
        $answers->put($answer->id ,$answer);

        BaseMethod::putParentsInCollection($answer,$answers);
        BaseMethod::treeTheElemantsByChild($answers);
        $mainAnswer = $answer;

        return view('admin.answer.preview.preview' , compact('answers','mainAnswer'));
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
            'content' => ['required', 'string', 'max:16777215', 'min:3'],

            'active' => [
                'nullable',
                Rule::in('on')
            ],

        ]);



        $data = setCheckboxValue($data, [ 'active']);



        return $data;

    }



}
