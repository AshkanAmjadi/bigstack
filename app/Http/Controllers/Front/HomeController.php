<?php

namespace App\Http\Controllers\Front;

use App\facade\BaseCat\BaseCat;
use App\facade\BaseMethod\BaseMethod;
use App\facade\BaseQuery\BaseQuery;
use App\Http\Controllers\Controller;
use Modules\Content\App\Models\Article;
use Modules\Content\App\Models\Category;
use App\Models\Comment;
use App\Models\Conversation;
use App\Models\Project;
use Modules\Content\App\Models\Slider;
use App\Models\Tag;
use Modules\User\App\Models\User;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{

    use SEOTools;

    public function test()
    {


        return view('test');


    }
    public function index()
    {





        $this->seo()
            ->setTitle(findInOption('slogan'))
            ->setCanonical(route('home'))
            ->opengraph()
            ->setUrl(route('home'))
            ->setType('website');
        $this->seo()->jsonLd()->setSite(route('home'));

        SEOMeta::addKeyword('ddd,dd');

        $conversations = Conversation::query()
            ->with([
                'user' => function ($query) {
                    $query->select(['id', 'name', 'avatar','updated_at','username']);
                },
                'tags' => function ($query) {
                    $query->select(['id', 'name']);
                },

            ])
            ->withCount('activeAnswers');

        $conversations = BaseQuery::cardSubjectNeed($conversations, ['mark', 'like']);
        $conversations = BaseQuery::privateAndUserObjQuery($conversations);
        $conversations = BaseQuery::activeQuery($conversations);
        $conversations = $conversations->limit(8)->get([
            'id',
            'title',
            'slug',
            'description',
            'user_id',
            'active',
            'new',
            'has_best',
            'view',
        ]);

        $articles = Article::query();
        $articles = BaseQuery::activeQuery($articles);
        $articles = BaseQuery::cardSubjectNeed($articles, ['cat', 'mark', 'star', 'like'])->orderBy('updated_at','desc')->limit(8)->get([
            'id',
            'page_title',
            'slug',
            'meta_description',
            'read_time',
            'img',
            'level',
            'category'
        ]);


//        $projects = Project::query()->with([
//            'tags' => function ($query) {
//                $query->select(['id', 'name']);
//            },
//        ]);
//        $projects = BaseQuery::activeQuery($projects);
//        $projects = BaseQuery::cardSubjectNeed($projects, ['mark', 'like', 'star','service'])
//            ->orderBy('updated_at','desc')->limit(8)->get([
//            'id',
//            'page_title',
//            'slug',
//            'meta_description',
//            'read_time',
//            'img',
//            'level',
//            'category'
//        ]);





        return view('front.home.home',compact('conversations','articles'));

    }



    public function seveComment()
    {

        if (!auth()->id()) {
            return view('errors.simpleErrorAllert', [
                'errors' => ['To submit a comment, please register on our website 😊💕👈' . htmlAlink(route('auth.login'), 'Register')]
            ]);
        }

        if (!BaseMethod::checkUserInfoIsOk()) {
            $linkForPanel = route('user-panel.index');
            $linkForPanel = "<a class='alink' href='$linkForPanel'>User Panel</a>";
            return view('errors.simpleErrorAllert', [
                'errors' => [
                    "To submit a comment, complete your profile via $linkForPanel ❤️"
                ]
            ]);
        }


        $modelValidation = Validator::make(request()->all(), [
            'model'=>[
                'required',
                Rule::in(modelCanComment()),
            ],
        ]);

        if ($modelValidation->fails()){

            abort(500);
        }

        $validation = Validator::make(\request()->all(),[
            'title'=>'nullable|min:3|max:300|string',
            'content'=>'required|min:3|max:65500|string',

            'parent' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {

                   if ($value != 0){
                       $parent = Comment::query()->find($value, ['id','active']);
                       if ($parent === null) {
                           $fail('Something went wrong');
                       }

                       if (!$parent->active) {
                           $fail('This comment is not yet active');
                       }

                   }
                }
            ],
            'subject' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {

            $model = resolve_model(\request()->model);

                    if ($model::query()->select('id')->find($value, ['id']) === null) {
                        $fail('Something went wrong');
                    }
                }
            ],
        ]);


        if ($validation->fails()){

            return view('errors.errorAllert',['errors' => $validation->errors()->toArray()]);
        }else{
            $model = resolve_model(\request()->model);

            $model::query()->findOrFail(\request()->subject)->comments()
                ->create(
                [
                    'content'=>$validation->validated()['content'],
                    'title'=>$validation->validated()['title'],
                    'parent'=>$validation->validated()['parent']
                ])
            ;

            return 'ok';
        }



    }





    public function tag($tag){



        $tags = BaseCat::getAllTag();
        $tag = Cache::rememberForever('tag.'.$tag,function () use ($tag){
            return Tag::query()->where('name','=',$tag)->firstOrFail();
        });

        $this->seo()
            ->setTitle("tag : $tag->name")
            ->setDescription($tag->meta_description)
            ->setCanonical(route('tag.show',['tag' => $tag->name]));
        $og = $this->seo()->opengraph()
            ->setUrl(route('tag.show',['tag' => $tag->name]))
            ->setType('website');

        $jsld = $this->seo()->jsonLd()
            ->setTitle($tag->name)
            ->setDescription($tag->meta_description)
            ->setSite(route('tag.show',['tag' => $tag->name]));

        SEOMeta::addKeyword($tag->keyword);

        if ($tag->img){
            $og->addImage(semanticImgUrlMaker($tag,'img',false));
            $jsld->addImage(semanticImgUrlMaker($tag,'img',false));
        }
        if ($tag->banner){
            $og->addImage(semanticImgUrlMaker($tag,'banner',false));
            $jsld->addImage(semanticImgUrlMaker($tag,'banner',false));
        }
        if ($tag->mobile_banner){
            $og->addImage(semanticImgUrlMaker($tag,'mobile_banner',false));
            $jsld->addImage(semanticImgUrlMaker($tag,'mobile_banner',false));
        }

        return view('front.tag.search',compact('tag','tags'));

    }

}


