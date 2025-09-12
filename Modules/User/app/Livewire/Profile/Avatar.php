<?php

namespace Modules\User\App\Livewire\Profile;


use App\facade\BaseImage\BaseImage;
use App\facade\BaseValidation\BaseValidation;
use App\facade\Module\ModuleFacade;
use Modules\User\App\Models\User;
use Illuminate\Support\Facades\Validator;

use Livewire\Attributes\Locked;
use Livewire\Component;

class Avatar extends Component
{

    #[Locked]
    public $seted = false;
    public function setAvatar($img)
    {

        $validation = Validator::make(['avatar' => $img], [
            'avatar' => ['nullable', 'string', 'base64max:600', 'base64image:image', 'base64mimes:webp',
                function ($attribute, $value, $fail) {
                    BaseValidation::base64ratio($attribute, $value, $fail,1,1);
                }
            ],
        ]);


        if ($validation->fails()) {
            $this->dispatch(
                'toast',
                title: 'The image could not be uploaded due to various reasons (excessive size, invalid image type).',
                type: 'error'
            );
        } else {
            $this->seted = true;
            $USER = User::query()->findOrFail(auth()->id());

            // Existing code for uploading and saving
            // Add log entry
            ModuleFacade::logIfAvailable(
                subject: $USER,
                event: 'avatar_updated',
                description: 'Profile picture updated',
                logName: 'user',
                adminAsUser: true
            );

            BaseImage::saveBase64image(
                $validation->validated()['avatar'],
                $USER,
                'avatar',
                true,
                150,
                150
            );

            // TODO: Save the previous profile picture somewhere to record the change
            // First, store the old image in BaseImage and retrieve related info for further operations

            $this->dispatch(
                'toast',
                title: 'Image uploaded successfully.',
                type: 'success'
            );
        }



    }

    public function render()
    {

        if ($this->seted){
            $user = User::query()->findOrFail(auth()->id());
        }else{
            $user = auth()->user();
        }

        return view('user::livewire.profile.avatar',compact('user'));
    }
}
