<?php

namespace App\Livewire\Comment;

use App\Models\Comment;
use Livewire\Attributes\Locked;
use Livewire\Component;

class DeleteComm extends Component
{
    #[Locked]
    public $model = "App\Models\\";
    #[Locked]
    public $id ;
    #[Locked]
    public $name ;
    #[Locked]
    public $type ;
    #[Locked]
    public $comments = [] ;


    public function mount($id,$type,$name)
    {

        $this->model= resolve_model($type);
    }

    public function delete()
    {



        if (!in_array($this->type,modelCanCall())){
            abort(500);
        }

        $obj = $this->model::query()->findOrFail($this->id);

        if ($obj->user_id == auth()->id() or super()){
            if ($obj->user_id == auth()->id() and !$obj->active or super()){

                $this->pushIdForDeleteComments($obj);

                Comment::query()->whereIn('id',$this->comments)->each(function ($comm){
                    $comm->delete();
                });
                $this->dispatch('toast' ,title : $this->name.' حذف شد' , type : 'success');
                $this->dispatch('comment_deleted');

            }else{
                $this->dispatch('toast' ,title : $this->name.' تایید شده غیر قابل حذف است' , type : 'error');
            }
        }else{
            $this->dispatch('toast' ,title : 'شما نمیتونید این '.$this->name.' رو حذف بدید' , type : 'error');

        }


    }

    public function pushIdForDeleteComments($object){

        array_push($this->comments,$object->id);

        $childes = $object->child;
        if ($object->child->first()){
            foreach ($childes as $childe){
                $this->pushIdForDeleteComments($childe);
            }
        }


    }
    public function render()
    {
        return view('livewire.comment.delete-comm');
    }
}
