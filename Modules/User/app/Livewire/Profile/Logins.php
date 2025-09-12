<?php

namespace Modules\User\App\Livewire\Profile;



use App\facade\Module\ModuleFacade;
use App\Models\LoginTracking;
use App\Services\LoginSecurity\LoginTracker;
use Livewire\Component;
use Modules\User\app\Traits\CheckAuthTrait;

class Logins extends Component
{

    use CheckAuthTrait;

    public function logoutLog($id)
    {
        if (!$this->mustBeLoggedIn()) {return;}

        $currentLogin = app(LoginTracker::class)->loadCurrentLogin();
        if ($currentLogin->id == $id){
            $this->dispatch('toast', title: 'To end your session, it is recommended to use the logout button', type: 'error');

            return;
        }

        $login = LoginTracking::query()->find($id,['id','user_id','user_type']);

        if (!$login){
            $this->dispatch('toast', title: 'session not found!!!', type: 'error');
            return;
        }

        $user= auth()->user();
        if (
            auth()->id() == $login->user_id &&
            $login->user_type == $user->morphClass &&
            $user->status == 'active'
        ) {
            ModuleFacade::logIfAvailable(
                subject: $login,
                event: 'revoke_track',
                description: 'A session was revoked by the user',
                logName: 'user',
                level: 'notice',
            );

            $login->revoke('user');

            $this->dispatch(
                'toast',
                title: 'The selected session has been successfully revoked.',
                type: 'success'
            );
            return;
        }

        if ($user->status == 'quarantined') {
            $this->dispatch(
                'toast',
                title: 'Your account is quarantined. To lift the quarantine, log out and log back into the website in compliance with the rules.',
                type: 'error'
            );
        }

        $this->dispatch(
            'toast',
            title: 'You are not authorized to revoke this session.',
            type: 'error'
        );



    }
    public function logoutOther()
    {
        if (!auth()->id()) {
            $this->dispatch(
                'toast',
                title: 'Please register on the website 👈' . htmlAlink(route('auth.login'), 'Register'),
                type: 'info'
            );
            return;
        }

        $currentLogin = app(LoginTracker::class)->loadCurrentLogin();

        $user = auth()->user();
        if ($currentLogin && $user->status == 'active') {

            foreach (LoginTracking::query()->where('id', '!=', $currentLogin->id)->get() as $revoke) {
                ModuleFacade::logIfAvailable(
                    subject: $revoke,
                    event: 'revoke_other_tracks',
                    description: 'Other session revoked by the user',
                    logName: 'user',
                    level: 'notice',
                );
                $revoke->revoke();
            }

            $this->dispatch(
                'toast',
                title: 'All other sessions have been successfully revoked.',
                type: 'success'
            );
            return;
        }

        if ($user->status == 'quarantined') {
            $this->dispatch(
                'toast',
                title: 'Your account is quarantined. To lift the quarantine, log out and log back into the website in compliance with the rules.',
                type: 'error'
            );
        }

        $this->dispatch(
            'toast',
            title: 'You are not authorized to revoke this session.',
            type: 'error'
        );


    }

    public function render()
    {
        return view('user::livewire.profile.logins');
    }
}
