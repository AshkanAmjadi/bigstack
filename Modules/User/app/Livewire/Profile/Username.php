<?php

namespace Modules\User\App\Livewire\Profile;



use App\facade\BaseMethod\BaseMethod;
use App\facade\BaseValidation\BaseValidation;
use App\facade\Module\ModuleFacade;
use Modules\User\App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Username extends Component
{

    public $errors = [];
    public $ok = false;
    public $canChange = false;
    public $newUsername = null;
    public $diffTimeForUsernameChane = null;


    public function mount()
    {

        if (auth()->user()->username) {

            $status = BaseMethod::checkUserCanChangeUsername();
            if ($status->can){
                $this->canChange = true;

            }else{

                $this->canChange = false;
                $this->diffTimeForUsernameChane = $status->diff;

            }

        } else {
            $this->canChange = true;
        }
    }

    protected function validateUsername($username)
    {
        $unique_validation = Rule::unique('users');

        $validate = Validator::make(['username' => $username], [
            'username' => [
                'required',
                'string',
                'min:5',
                'max:31',
                $unique_validation,
                function ($attribute, $value, $fail) {
                    if (!preg_match(BaseValidation::validationForUsername(), $value)) {
                        $fail('Minimum 5 characters and maximum 31 characters allowed; only English letters, numbers, ( _ ), and ( . ) are permitted.');
                    }
                }
            ],

        ]);

        return $validate;
    }

    public function setUsername()
    {
        $validate = $this->validateUsername($this->newUsername);


        if (BaseMethod::checkUserCanChangeUsername()->can) {
            $this->canChange = false;
            $this->errors = [];
            $this->ok = false;

            $username = $validate->validated()['username'];

            ModuleFacade::logIfAvailable(
                subject: auth()->user(),
                event: 'username_change',
                description: 'username change',
                logName: 'user',
                level: 'notice'
            );

            auth()->user()->update(['username' => $username, 'username_set' => now()->timestamp ]);



            $this->dispatch('toast', title: 'Your username has been successfully registered 😇', type: 'success');
        } else {

            $this->errors = [];
            $this->ok = false;
            $this->dispatch('toast', title: 'You cannot change your username.', type: 'error');

        }
    }

    public function username($username)
    {
        $username = strtolower($username);

        $this->ok = false;

        $validate = $this->validateUsername($username);

        if ($validate->fails()) {

            $this->errors = $validate->errors()->toArray();


        } else {

            $this->newUsername = $username;
            $this->errors = [];
            $this->ok = true;


        }
    }

    public function render()
    {
        return view('user::livewire.profile.username');
    }
}
