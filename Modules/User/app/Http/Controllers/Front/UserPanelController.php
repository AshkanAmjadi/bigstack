<?php

namespace Modules\User\App\Http\Controllers\Front;



use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Traits\SEOTools;
use Modules\User\App\Models\User;

class UserPanelController extends Controller
{

    use SEOTools;
    private $module = 'user::';




    public function index()
    {

        return view($this->module.'userPanel.profile.profile');

    }
    public function conversations()
    {

        return view($this->module.'userPanel.conversation.conversation');

    }
    public function comments()
    {

        return view($this->module.'userPanel.comments.comments');

    }
    public function allerts()
    {

        return view($this->module.'userPanel.userAllerts.userAllerts');

    }
    public function tacts()
    {

        return view($this->module.'userPanel.tacts.tacts');

    }
    public function logins()
    {


        return view($this->module.'userPanel.logins.logins');

    }

    public function userInfo($username)
    {



        $user = User::query()->where('username' , '=' , $username)->firstOrFail();


        $webname = findInOption('site_name');

        $this->seo()
            ->setTitle("User Profile | $user->name | @$username")
            ->setDescription("Profile page of $username on $webname website");

        return view($this->module.'front.profile.profile',compact('user'));


    }



}
