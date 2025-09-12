<?php


namespace App\facade\BaseSort;



use App\facade\BaseMethod\BaseMethod;
use Illuminate\Support\Facades\Validator;


class BaseSortService
{


    public function sortThanBrother($brothers,$data)
    {

        $brothers = $brothers->where('parent_id', $data['parent_id'])->get('sort')->sortBy('sort');

        if ($brothers->count()){

            $data['sort'] = $brothers->last()->sort + 1;

        }else{

            $data['sort'] = 1;

        }

        return $data;
    }
    public function sortThanBrotherNoParent($brothers,$data)
    {

        $brothers = $brothers->get('sort')->sortBy('sort');

        if ($brothers->count()){

            $data['sort'] = $brothers->last()->sort + 1;

        }else{

            $data['sort'] = 1;

        }

        return $data;
    }

    public function validSort($request)
    {

        $sort = explode(',',$request->sort);

        $validation['sort'] = $sort;

        $validation = Validator::make($validation , [
            'sort' => [
                'array',
                'max:999999999999',
                function ($attribute, $value, $fail) {

                    foreach ($value as $key=>$val){


                        if (!is_integer($key) or !preg_match("/^[0-9]+$/",$val)){

                            $fail('The '.$attribute.' is invalid.');

                        }

                    }

                }

            ]
        ])->validate();

        return $sort;

    }
    public function baseSetSort($objects , $sort)
    {

        $sort = changeKeyToValue($sort,true);


        //ToDo check the sort is set by child id catrgorys

        foreach ($objects as $key=>$item){

            $item->update(BaseMethod::addUpdatedDataBeforDo(['sort' => $sort[$item->id]]));

        }

    }




}
