<?php

namespace Modules\Content\App\Livewire\Admin\Category;

use Modules\Content\App\Models\Category;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\Attributes\On;

class CatList extends Component
{


    #[Locked]
    public $parent;


    public function mount($parent)
    {

        $this->parent = $parent;

    }



    #[On('cat-created')]
    public function cat_created()
    {
        $this->dispatch('setDropDown');
    }



    public function render()
    {

       $allCat =Category::query()->where('parent_id','=',$this->parent)->allChild()->get();

       return view('content::livewire.admin.category.cat-list',['allCat' => $allCat]);
    }
}
