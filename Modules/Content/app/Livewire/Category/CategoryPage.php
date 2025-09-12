<?php

namespace Modules\Content\App\Livewire\Category;

use App\facade\BaseCat\BaseCat;
use Modules\Content\App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Locked;
use Livewire\Component;

class CategoryPage extends Component
{
    #[Locked]
    public $category;
    #[Locked]
    public $catIds;

    public function mount($category)
    {


        $catInfo = Cache::get('category.'.$category.'.info');

        if (!$catInfo){
            abort('404');
        }

        $this->catIds = $catInfo['catIds'];
        $this->category = $catInfo['mainCat'];

    }
    public function render()
    {


        return view('content::livewire.category.category-page');
    }
}
