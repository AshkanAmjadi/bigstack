<?php
namespace Modules\User\App\Livewire\Profile;


use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class Allerts extends Component
{
    use WithPagination;
    public function goToPage($page)
    {

        $val = Validator::make([
            'page' => $page
        ], [
            'page' => 'required|integer|min:1|max:999999999'
        ]);

        if ($val->fails()) {
            abort(500);
        }
        $this->setPage($page);
        $this->dispatch('toTitle', el: 'allertsHead');

    }


    public function render()
    {
        $items = auth()->user()->allerts()->orderBy('id','desc')->paginate(8);
        return view('user::livewire.profile.allerts',compact('items'));
    }
}
