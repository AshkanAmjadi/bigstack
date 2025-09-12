<?php

namespace Modules\Content\App\Livewire\Admin\Category;

use App\facade\BaseCat\BaseCat;
use Modules\Content\App\Models\Category;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class CategoryItem extends Component
{
    #[Locked]
    public $cat;
    #[Locked]
    public $level;


    #[On('cat-edited')]
    public function cat_edited()

    {


    }
    public function delete()
    {

        BaseCat::deleteCatViaProduct(Category::query()->find($this->cat->id));


        $this->dispatch('cat-created');


        $this->dispatch('toast' ,title : 'حذف شد' , type : 'success')->self();




    }

    public function render()
    {
        return view('content::livewire.admin.category.category-item');
    }
}
