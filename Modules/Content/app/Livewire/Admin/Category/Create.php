<?php

namespace Modules\Content\App\Livewire\Admin\Category;

use App\facade\BaseCat\BaseCat;
use App\facade\BaseImage\BaseImage;
use App\facade\BaseValidation\BaseValidation;
use Modules\Content\App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{

    use WithFileUploads;

    #[Locked]
    private $prefix = 'admin.category.';

    #[Locked]
    private $model = 'category';
    #[Locked]
    public $onEdit = false;

    #[Locked]
    public $category;
    #[Locked]
    public $parent_id = 0;

    #[Locked]
    public $img;
    #[Locked]
    public $banner;
    #[Locked]
    public $mobile_banner;
    #[Locked]
    public $title;
    #[Locked]
    public $slug;
    #[Locked]
    public $keyword;
    #[Locked]
    public $page_title;
    #[Locked]
    public $meta_description;


    public function mount($category = null)
    {
        if ($category){
            $this->category = $category;
            $this->parent_id = $category->parent_id;
            $this->keyword = $category->keyword;
            $this->onEdit = true;
            $this->img = $category->img ? semanticImgUrlMaker($category,'img'): null;
            $this->banner = $category->banner ? semanticImgUrlMaker($category,'banner'): null;
            $this->mobile_banner = $category->mobile_banner ? semanticImgUrlMaker($category,'mobile_banner'): null;
        }

    }

    public function setProperties(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }


    public function create($form)
    {


        $this->setProperties($form);
        $this->myValidation($form);

        $this->dispatch('cat-created');
        $this->dispatch('close_modal');
        $this->dispatch('toast' ,title : 'دسته بندی ساخته شد👍' , type : 'success');

    }
    public function edit($form)
    {


        $this->setProperties($form);
        $this->myValidation($form,true);

        $this->dispatch('toast' ,title : 'اطلاعات به روز شد👍' , type : 'success');
        $this->dispatch('cat-edited');
        $this->mount($this->category);

    }



    public function render()
    {
        $allTag = BaseCat::getAllTag();
        $this->dispatch('updatedDOM');
        return view('content::livewire.admin.category.create', compact('allTag'));

    }

    public function myValidation($data, $update = false)
    {



        $object = $update ? $this->category : 'not Update';


        $unique_validation = 'unique:' . $this->model;

        if ($update) {

            $unique_validation = Rule::unique($this->model)->ignore($object->id);
        }

        $validated = $this->validate(
            [
                'title' => ['required', 'string', 'min:3', 'max:200', $unique_validation],
                'page_title' => ['nullable', 'string', 'min:3', 'max:500', $unique_validation],
                'meta_description' => ['required', 'string', 'min:3', 'max:500',$unique_validation],
                'slug' => ['required', 'string', 'min:3', 'max:2000',$unique_validation],
                'keyword' => ['nullable', 'string', 'min:3', 'max:2000'],
                'parent_id' => [
                    'required',
                    'min:0',
                    'max:999999999999',
                    'numeric',
                    function ($attribute, $value, $fail) use ($update, $object) {

                        if ($update) {
                            if ($object->parent_id != $value) {
                                $fail('Something went wrong');
                            }

                        } else {
                            if ($value != '0') {
                                if (Category::query()->select('id')->find($value) === null) {
                                    $fail('Something went wrong');
                                }
                                if (BaseCat::have2parent($value)) {
                                    $fail('این دسته در حال حاظر دو پدر دارد');
                                }
                            }
                        }

                    }

                ],
//                'tag' => [
//                    'string',
//                    function ($attribute, $value, $fail) {
//                        BaseValidation::tagsValidation($attribute, $value, $fail);
//                    }
//                ],

                'img' => ['nullable', 'string', 'base64max:3072', 'base64image:image', 'base64mimes:webp,png,jpeg,jpg',
                    function ($attribute, $value, $fail) {
                        BaseValidation::base64ratio($attribute, $value, $fail,1,1);
                    }
                ],
                'banner' => ['nullable', 'string', 'base64max:3072', 'base64image:image', 'base64mimes:webp,png,jpeg,jpg',
                    function ($attribute, $value, $fail) {
                        BaseValidation::base64ratio($attribute, $value, $fail,15,7);
                    }
                ],
                'mobile_banner' => ['nullable', 'string', 'base64max:3072', 'base64image:image', 'base64mimes:webp,png,jpeg,jpg',
                    function ($attribute, $value, $fail) {
                        BaseValidation::base64ratio($attribute, $value, $fail,3,2);
                    }
                ]

            ]);



//        dd();
        $validated = removeSpace($validated, ['slug'], '-');

        $save = Arr::only($validated,['title','page_title','meta_description','parent_id','slug','keyword']);
//
        if (!$update){
            $obj = Category::query()->create($save);
        }else{
            $obj = $object;
            $object->update($save);
        }

        BaseImage::saveBase64image(Arr::get($validated,'img'),$obj,'img',false,null,null,true);
        BaseImage::saveBase64image(Arr::get($validated,'banner'),$obj,'banner',false,null,null,true);
        BaseImage::saveBase64image(Arr::get($validated,'mobile_banner'),$obj,'mobile_banner',false,null,null,true);


//        $data = BaseMethod::createTagIfNotExsist($data, Tag::query());


//        $obj->tags()->sync($data['tag']);




        return $validated;


    }
}
