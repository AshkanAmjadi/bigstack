<?php

namespace App\Livewire\Admin;

use App\facade\BaseImage\BaseImage;
use App\facade\BaseValidation\BaseValidation;
use App\Models\Option;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Img extends Component
{
    public $option;
    public $obj = null;
    public $errors = null;



    public function setImage($img)
    {


        $validation = Validator::make(['img' => $img], [
            'img' => ['nullable', 'string', 'base64max:5000', 'base64image:image', 'base64mimes:webp,png,jpeg,jpg'
//                function ($attribute, $value, $fail) {
//                    BaseValidation::base64ratio($attribute, $value, $fail,1,1);
//                }
            ],
        ]);


        if ($validation->fails()){
            $this->errors = $validation->errors()->toArray();
        }else{

            $obj = Option::query()->where('name' , '=' , $this->option)->firstOrCreate(['name' => $this->option]);

            BaseImage::saveBase64image($validation->validated()['img'],$obj,'value',false,null,null,true,'name');
            $this->dispatch('toast', title: 'uploaded', type: 'success');

        }


    }

    public function render()
    {

        $this->obj = Option::query()->where('name' , '=' , $this->option)->first();





        return view('livewire.admin.img' );
    }
}
