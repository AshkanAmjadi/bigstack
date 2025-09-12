<?php

namespace App\Http\Controllers\Front;

use App\facade\BaseCat\BaseCat;
use App\facade\BaseMethod\BaseMethod;
use App\facade\BaseQuery\BaseQuery;
use App\facade\BaseValidation\BaseValidation;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Conversation;
use Modules\User\App\Models\User;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\Schema;
use Vinkla\Hashids\Facades\Hashids;

class ConversationController extends Controller
{
    use SEOTools;

    public $toAnswer = false;
    public $toAnswerObj = false;

    public function conversation($conversation)
    {

        $conversation = Conversation::query()->where('slug', '=', $conversation)->withCount('activeAnswers');
        $conversation = BaseQuery::cardSubjectNeed($conversation, ['mark', 'like']);
        $conversation = BaseQuery::privateAndUserObjQuery($conversation);
        $conversation = BaseQuery::activeAndUserObjQuery($conversation)->firstOrFail();

        $tags = BaseCat::getAllTag();

//        BaseMethod::checkPrivate($conversation);

        $conversation->setRelation('tags', Cache::rememberForever($conversation->getTable() . $conversation->id . 'tags', function () use ($conversation) {

            return $conversation->tags()->get(['id', 'name'])->map(function ($tag) {
                return $tag->unsetRelation('pivot');
            });

        }));
        $conversation->setRelation('user', Cache::rememberForever($conversation->getTable() . $conversation->id . 'user', function () use ($conversation) {

            return $conversation->user()->first(['id', 'name', 'avatar','updated_at','username']);

        }));
        $conversation->setRelation('mentions', Cache::rememberForever($conversation->getTable() . $conversation->id . 'mentions', function () use ($conversation) {

            return User::query()->whereIn('id',$conversation->mention)->get(['id', 'name', 'avatar','updated_at','username']);


        }));


        Cache::forget($conversation->getTable().$conversation->id.'related');

        $conversation->setAttribute('related', Cache::rememberForever($conversation->getTable().$conversation->id.'related',function () use ($conversation) {

            $related = Conversation::query()->inRandomOrder();
            $related = BaseQuery::activeQuery($related);
            return BaseQuery::tagFilter($related,$conversation->getRelation('tags')->pluck('name')->toArray())
                ->where('id', '!=', $conversation->id)
                ->limit(10)->get([
                    'id',
                    'title',
                    'slug',
                ]);

        }));


        $answers = $conversation->answers()->with([
            'user' => function ($query) {
                $query->select(['id', 'name', 'avatar','updated_at','username']);
            },
            'tacts'
        ]);

        $answers = BaseQuery::activeAndUserObjQuery($answers);
        $answers = $answers->paginate(10);

        if ($conversation->has_best) {
            $conversation->best_answer = $conversation->bestAnswer();
        }
        if (\request()->toAnswer){

            $answers->map(function ($answer){

                if ($answer->hash_id == \request()->toAnswer){

                    $this->toAnswer = $answer->hash_id;
                    $answer->toAnswer = true;
                    return $answer;
                }
                return $answer;

            });



            if (!$this->toAnswer){

                if ($conversation->has_best) {
                    if ($conversation->best_answer->hash_id == \request()->toAnswer){
                        $this->toAnswer = $conversation->best_answer->hash_id;
                        $conversation->best_answer->toAnswer = true;
                    }
                }

            }

            if (!$this->toAnswer){

                $ans =  Answer::query()->where('id','=',Hashids::connection('answer')->decode(\request()->toAnswer)[0])->with([
                    'user' => function ($query) {
                        $query->select(['id', 'name', 'avatar','updated_at','username']);
                    },
                    'tacts'
                ]);
                $ans = BaseQuery::activeAndUserObjQuery($ans)->firstOrFail();
                $ans->toAnswer = true;
                $this->toAnswerObj = $ans;
            }

        }

        $conversation->firstAnswers = $answers;




        $conversation->schema = Cache::rememberForever($conversation->getTable().$conversation->id.'schema',function () use ($conversation) {
            $graph = new Graph();


            $graph->organization()
                ->name(getOption('site_name'))
                ->logo(asset('assets/img/logo/logo.png'))
                ->alternateName(getOption('slogan'))
                ->url(route('home'));

            $QApageSuggestedAnswers = [];

            foreach ($conversation->firstAnswers->items() as $answer) {
                $tacts = $answer->tacts;
                $mines = $tacts->where('tact_value', '0')->count();
                $plus = $tacts->where('tact_value', '1')->count();
                array_push(
                    $QApageSuggestedAnswers,
                    Schema::answer()->text(editorJsFirstPar(editorJsDecode($answer, 'content')))
                        ->dateCreated(toSeoDate($answer->created_at))
                        ->upvoteCount($plus)
                        ->downvoteCount($mines)
                        ->url(route('conversation.show', ['conversation' => $conversation->slug]))
                        ->author(
                            Schema::person()->name($answer->user->name)
                        )
                );

            }

            $qeustion = Schema::question();


            if ($conversation->best_answer){
                $bastAnswer = $conversation->best_answer;
                $tacts = $bastAnswer->tacts;
                $mines = $tacts->where('tact_value', '0')->count();
                $plus = $tacts->where('tact_value', '1')->count();
                $qeustion->acceptedAnswer(
                    Schema::answer()->text(editorJsFirstPar(editorJsDecode($bastAnswer, 'content')))
                        ->dateCreated(toSeoDate($bastAnswer->created_at))
                        ->upvoteCount($plus)
                        ->downvoteCount($mines)
                        ->url(route('conversation.show', ['conversation' => $conversation->slug]))
                        ->author(
                            Schema::person()->name($bastAnswer->user->name)
                        )
                );
            }

            $qeustion = $qeustion->name($conversation->title)
                ->text(editorJsFirstPar(editorJsDecode($conversation, 'description')))
                ->answerCount($conversation->active_answers_count)->dateCreated(toSeoDate($conversation->created_at))
                ->author(Schema::person()->name($conversation->getRelation('user')->name))
                ->suggestedAnswer($QApageSuggestedAnswers);

            $graph->qAPage()->mainEntity($qeustion)->name($conversation->title);

            $breadCrump = [Schema::listItem()->position(1)->item(Schema::webPage()->name('home')->identifier(route('home')))];
            $catBreadCrump = [Schema::listItem()->position(2)->item(Schema::webPage()->name('Programming problems, bug fixes, ideas')->identifier(route('discuss.search')))];
            $thisBreadCrump = [Schema::listItem()->position(3)->item(Schema::webPage()->name($conversation->title)->identifier(route('conversation.show', ['conversation' => $conversation->slug])))];

            $breadCrump = array_merge($breadCrump, $catBreadCrump, $thisBreadCrump);
            $graph->breadcrumbList()->identifier(route('conversation.show', ['conversation' => $conversation->slug]))
                ->itemListElement($breadCrump);


            return json_encode($graph, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        });



        $this->seo()
            ->setTitle($conversation->title,false)
            ->setDescription(editorJsFirstPar(editorJsDecode($conversation, 'description')))
            ->setCanonical(route('conversation.show',['conversation' => $conversation->slug]));

        $this->seo()->opengraph()
            ->setUrl(route('conversation.show',['conversation' => $conversation->slug]));



        $toAnswer = $this->toAnswer;
        $toAnswerObj = $this->toAnswerObj;
        return view('front.conversation.conversation', compact('conversation', 'tags' ,'toAnswer','toAnswerObj' ));
    }

    public function conversations()
    {
        $this->seo()
            ->setTitle('Programming problems, bug fixes, ideas')
            ->setDescription('Questions raised by students and programmers')
            ->setCanonical(route('discuss.search'))
            ->opengraph()
            ->setUrl(route('discuss.search'))
            ->setType('website');

        $schema = Schema::webPage()->name('Programming problems, bug fixes, ideas')->description('Questions raised by students and programmers');
        $schema = json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        return view('front.conversation.search', compact('schema'));

    }


    public function getAnswerContent($answer)
    {

        $id = Hashids::connection('answer')->decode($answer)[0];

        $answer = Answer::query()->findOrFail($id);

        $users = $answer->mention ?  User::query()->whereIn('username',$answer->mention)->get(['name','avatar','username','id','updated_at','email'])->map(function ($user){
            $user->src = $user->avatar ? imgUrlMaker2($user,'avatar') : asset('assets/img/default.png');
            return $user;
        })->toArray() : [];

        return Response::json(['content'=>$answer->content,'mention'=>$users]);
    }

    public function searchUser(Request $request)
    {

        $keyword = $request->q;

        $users = User::query()->limit(6)
            ->where('username' , '!=' , null)
            ->where('name', 'LIKE', "%{$keyword}%")
            ->orWhere('username' , '!=' , null)
            ->where('username', 'LIKE', "%{$keyword}%");
        $users = $users->get(['name','avatar','username','id','updated_at','email']);
        $users = $users->map(function ($user){
            $user->src = $user->avatar ? imgUrlMaker2($user,'avatar') : asset('assets/img/default.png');
            return $user;
        })->toArray();


        return Response::json($users);

    }

    public function getConInfo($conversation)
    {

        $id = Hashids::connection('conversations')->decode($conversation)[0];


        $conversation = Conversation::query()->findOrFail($id);


        $users = $conversation->mention ?  User::query()->whereIn('id',$conversation->mention)->get(['name','avatar','username','id','updated_at','email'])->map(function ($user){
            $user->src = $user->avatar ? imgUrlMaker2($user,'avatar') : asset('assets/img/default.png');
            return $user;
        })->toArray() : [];


        return Response::json(['content' => $conversation->description, 'title' => $conversation->title, 'tags' => $conversation->tags->pluck('id')->toArray(),'mention'=>$users,'private' => $conversation->private]);
    }

    public function craft($conversation = null)
    {

        return view('front.conversation.craft',compact('conversation'));

    }

    public function seveAnswer()
    {

        if (!auth()->id()) {
            return view('errors.simpleErrorAllert', ['errors' => ['To send your answers and help your friends, come and login on our site 😊💕👈'. htmlAlink(route('auth.login'),'Join us')]]);
        }

        if (!BaseMethod::checkUserInfoIsOk()) {
            $linkForPanel = route('user-panel.index');
            $linkForPanel = "<a class='alink' href='$linkForPanel'>User Panel</a>";
            return view('errors.simpleErrorAllert', ['errors' => [
                "To submit an answer, complete your profile via $linkForPanel ❤️"
            ]]);
        }

        $validation = Validator::make(\request()->all(), [
            'content' => [
                'required',
                'string',
                'max:1500000',
                function ($attribute, $value, $fail) {
                    BaseValidation::editorjsValidation($attribute, $value, $fail, false, 1);
                }
            ],
            'mention' => [
                'array',
                'max:4',
            ],
            'mention.*' => [
                'exists:users,username',
            ],
            'conversation' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {

                    $con = Conversation::query()->select('id','active')->find($value, ['id']);
                    if (\request()->answer == 'add') {
                        if ($con === null) {
                            $fail('Something went wrong');
                        }else{
                            $con->active ?: $fail('This question is currently inactive');
                        }
                    }
                }
            ],
        ], [
            'content.min' => 'The content must be more than 3 characters'
        ]);


        if ($validation->fails()) {
            return view('errors.errorAllert', ['errors' => $validation->errors()->toArray()]);
        } else {

            if (\request()->answer == 'add') {

                if (inMention($validation->validated()['mention'],auth()->user()->username)){
                    return view('errors.simpleErrorAllert', ['errors' => ['You cannot refer to yourself as the doer.']]);

                }

                $answer = Conversation::query()->findOrFail(\request()->conversation)->answers()->create(
                    [
                        'content' => $validation->validated()['content'],
                        'user_id' => auth()->id(),
                        'mention' => $validation->validated()['mention'],

                    ]);

            } else {

                $id = Hashids::connection('answer')->decode(\request()->answer)[0];
                $answer = Answer::query()->with('user')->findOrFail($id);



                if (inMention($validation->validated()['mention'],$answer->user->username)){
                    return view('errors.simpleErrorAllert', ['errors' => ['You cannot refer to the questioner.']]);

                }

                if ($answer->user_id == auth()->id() or super()) {
                    if ($answer->user_id == auth()->id() and !$answer->active or super()) {


                        $answer->update([
                            'content' => $validation->validated()['content'],
                            'mention' => $validation->validated()['mention'],
                        ]);


                    } else {
                        return view('errors.simpleErrorAllert', ['errors' => ['The approved answer cannot be changed']]);
                    }
                } else {
                    return view('errors.simpleErrorAllert', ['errors' => ["You cannot modify this answer"]]);
                }

            }

        }

        return Response::json(['stat' => 'ok','id' => $answer->hash_id,'req' => \request()->answer]);

    }

    public function saveConversation()
    {

        if (!auth()->id()) {
            return view('errors.simpleErrorAllert', [
                'errors' => ['To submit a question, please register on our website 😊💕👈' . htmlAlink(route('auth.login'), 'Login')]
            ]);
        }
        if (!BaseMethod::checkUserInfoIsOk()) {
            $linkForPanel = route('user-panel.index');
            $linkForPanel = "<a class='alink' href='$linkForPanel'>User Panel</a>";
            return view('errors.simpleErrorAllert', ['errors' => [
                "To submit a question, complete your profile via $linkForPanel ❤️"
            ]]);

        }

        $conversationId = null;

        if (\request('conversation') != 'add') {
            $conversationId  = Hashids::connection('conversations')->decode(\request('conversation'))[0];
            \request()->merge(['conversation' => strval($conversationId)]);
            $unique_validation = Rule::unique('conversations')->ignore($conversationId);
        } else {
            $unique_validation = 'unique:conversations';
        }

        $inMention= false;

        $validation = Validator::make(\request()->all(), [
            'title' => ['required', 'string', 'max:400', 'min:3', $unique_validation],
            'content' => [
                'required',
                'string',
                'min:59',
                'max:1500000',
                function ($attribute, $value, $fail) {
                    BaseValidation::editorjsValidation($attribute, $value, $fail, false, 1);
                }
            ],
            'conversation' => [
                'required',
                'string',

                function ($attribute, $value, $fail) {

                    if ($value != 'add') {
                        if (Conversation::query()->select('id')->find($value, ['id']) === null) {
                            $fail('Something went wrong');
                        }
                    }
                }
            ],
            'tags' => [
                'array',
                'min:1',
                'max:12',
                function ($attribute, $value, $fail) {
                    BaseValidation::tagsValidation($attribute, $value, $fail, false);
                }
            ],
            'mention' => [
                'array',
                'max:4',
            ],
            'mention.*' => [
                'exists:users,username',
            ],
            'private' => [
                'boolean',
            ],
        ], [
            'content.min' => 'The content must be more than 3 characters'
        ]);


        if ($validation->fails()) {
            return view('errors.errorAllert', ['errors' => $validation->errors()->toArray()]);
        } else {


            if (\request('conversation') == 'add') {

                if (inMention($validation->validated()['mention'],auth()->user()->username)){
                    return view('errors.simpleErrorAllert', ['errors' => ['You cannot refer to yourself as the doer.']]);

                }

                $conversation = Conversation::query()->create(
                    [
                        'title' => $validation->validated()['title'],
                        'description' => $validation->validated()['content'],
                        'slug' => preg_replace('/\s+/', '-', $validation->validated()['title']),
                        'user_id' => auth()->id(),
                        'mention' => User::query()->whereIn('username',$validation->validated()['mention'])->get('id')->pluck('id')->toArray(),
                        'private' => $validation->validated()['private'],
                    ]);

                $conversation->tags()->sync($validation->validated()['tags']);

                return Response::json(['stat' => 'ok', 'nextpage' => route('conversation.show',[$conversation->slug])]);


            } else {


                $conversation = Conversation::query()->with('user')->findOrFail($conversationId);


                if (inMention($validation->validated()['mention'],$conversation->user->username)){
                    return view('errors.simpleErrorAllert', ['errors' => ['You cannot refer to the questioner.']]);

                }


                if ($conversation->user_id == auth()->id() or super()) {
                    if ($conversation->user_id == auth()->id() and !$conversation->active or super()) {

                        $conversation->update([
                            'title' => $validation->validated()['title'],
                            'description' => $validation->validated()['content'],
                            'slug' => preg_replace('/\s+/', '-', $validation->validated()['title']),
                            'mention' => User::query()->whereIn('username',$validation->validated()['mention'])->get('id')->pluck('id')->toArray(),
                            'private' => $validation->validated()['private'],
                        ]);

                        $conversation->tags()->sync($validation->validated()['tags']);

                        return Response::json(['stat' => 'ok', 'nextpage' => route('conversation.show',[$conversation->slug]) ]);


                    } else {
                        return view('errors.simpleErrorAllert', ['errors' => ['The approved question cannot be changed']]);
                    }
                } else {
                    return view('errors.simpleErrorAllert', ['errors' => ['You cannot modify this question']]);
                }

            }

        }


    }

}
