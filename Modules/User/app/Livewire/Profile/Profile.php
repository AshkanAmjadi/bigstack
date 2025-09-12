<?php

namespace Modules\User\App\Livewire\Profile;



use App\facade\BaseCat\BaseCat;
use App\facade\BaseQuery\BaseQuery;
use App\Models\Tag;
use Modules\User\App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class Profile extends Component
{

    use WithPagination;

    public $subject = 'about';
    #[Locked]
    public $subjects = [
        'about' => 'About Me',
        'con' => 'Discuss',
    ];

    public $username;
    #[Locked]
    protected $queryString = [
        'subject' => ['except' => 'about'],

    ];

    public function mount($username)
    {
        $this->username = $username;


        if (!isset($this->subjects[$this->subject])) {
            abort(500);
        }


    }


    public function goToPage($page)
    {


        $val = Validator::make([
            'page' => $page
        ], [
            'page' => 'required|integer|min:1|max:999999999'
        ]);

        if ($val->fails()) {
            abort(500);
        }


        $this->setPage($page);

    }
    public function goToSubject($subject)
    {

        if (!isset($this->subjects[$subject])) {
            abort(500);
        }

        $this->subject = $subject;

    }


    public function refresh()
    {

    }

    public function render()
    {


        $items = null;

        if ($this->subject == 'about'){

            $user = User::query()->where('username' , '=' , $this->username)->withCount([
                'comments',
                'conversations',
                'answers',
                'best_answers'
            ])->firstOrFail(['id','name','username','about_me']);



        }elseif ($this->subject == 'con'){

            $user = User::query()->where('username' , '=' , $this->username)->firstOrFail(['id','name','username','about_me']);


            $items =  BaseQuery::activeAndUserObjQuery($user->conversations())->with([
                'user' => function ($query) {
                    $query->select(['id', 'name', 'avatar','updated_at','username']);
                },
                'tags' => function ($query) {
                    $query->select(['id', 'name']);
                },

            ])
                ->withCount('activeAnswers');;
            $items = BaseQuery::privateAndUserObjQuery($items);
            $items = BaseQuery::cardSubjectNeed($items, ['mark', 'like']);
            $items = $items->paginate(8);


        }



        return view('user::livewire.profile.profile',['items'=>$items,'user'=>$user]);
    }
}
