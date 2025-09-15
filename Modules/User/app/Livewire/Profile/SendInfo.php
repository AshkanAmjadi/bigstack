<?php
namespace Modules\User\App\Livewire\Profile;



use App\facade\BaseMethod\BaseMethod;
use App\facade\BaseValidation\BaseValidation;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Component;

class SendInfo extends Component
{

    use WithRateLimiting;
    #[Locked]
    public $errors = null;



    public function getProfileData($data)
    {

        try {
            $this->rateLimit(5,12 * 60 * 60);
        } catch (TooManyRequestsException $exception) {
            $s = secondsToTime($exception->secondsUntilAvailable);
            $this->dispatch('toast', title: "You can change your profile 5 times within 12 hours. Try again in $s.", type: 'error');

            return;
        }
        $this->errors =null;

        if (!auth()->id()) {
            $this->dispatch('toast', title: '👈 To change your information on the site, please sign up 😊💕' . htmlAlink(route('auth.login'), 'Sign Up'), type: 'info');
            return;
        }

        $unique_validation = Rule::unique('users')->ignore(auth()->id());

        $validate = Validator::make($data,[
            'name' => ['required','string','min:3','max:100',$unique_validation],
            'insta_id' => ['string','min:3','max:255',$unique_validation],
            'about_me' => ['string','min:3','max:65000'],
            'email' => ['nullable','string','email','min:3','max:200',$unique_validation],
//            'melicode' => ['numeric','nullable','string',BaseValidation::validationForMelicode(),$unique_validation,'ir_national_id'],
            'birth' => [
                'required',
//                'persian_date',
                function ($attribute, $value, $fail) {
                    if (!preg_match("/^[0-9]{4}\/(|[0-1])[0-9]\/(|[0-3])[0-9]$/",$value))
                    {
                        $fail('date not valid');
                    }
                }
            ],
            'gender' => [
                'required',
                Rule::in('man' , 'woman','other' )
            ],
        ]);

        if ($validate->fails()){

            $this->errors = $validate->errors()->toArray();

        }else{

            $data = $validate->validated();
            $data = BaseMethod::setParseDate($data,'birth');
            if (auth()->user()->email_verify){
                unset($data['email']);
            }

            auth()->user()->update(EmptyToNullOnArray($data));

            $this->dispatch('toast', title: 'Your profile information has been successfully saved 😇', type: 'success');



        }
    }

    public function render()
    {
        return view('user::livewire.profile.send-info');
    }
}
