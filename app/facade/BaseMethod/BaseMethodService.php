<?php


namespace App\facade\BaseMethod;


use App\facade\BaseValidation\BaseValidation;
use Modules\User\App\Models\User;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class BaseMethodService
{

    public function __construct()
    {

    }


//todo compile all Base set images method


    public function ajaxResponse($success = true, $errors = [])
    {
        if ($success) {
            return Response::json(array('success' => true), 200);
        } else {

            return Response::json(array(
                'success' => false,
                'errors' => $errors

            )); // 400 being the HTTP code for an invalid request.

        }


    }


    public function addBeforDo($data, $extra)
    {

//        dd($extra);

        $user = auth()->user();

        foreach ($extra as $extr) {


            if ($extr === 'added_by') {

                $data['added_by'] = $user->id;

            } elseif ($extr === 'updated_by') {

                $data['updated_by'] = $user->id;

            } elseif ($extr === 'deleted_by') {

                $data['deleted_by'] = $user->id;

            }

        }




        return $data;

    }
    public function changeData($data, $extra,$drop = [])
    {

//        dd($extra);


        foreach ($extra as $extr=>$value) {

            $data[$extr] = $value;

        }
        foreach ($drop as $extr) {

            unset($data[$extr]);

        }




        return $data;

    }

    public function addUserDataBeforDo($data)
    {

        return $this->addBeforDo($data, ['added_by', 'updated_by']);

    }

    public function addUpdatedDataBeforDo($data)
    {

        return $this->addBeforDo($data, ['updated_by']);

    }

    public function addDeleterData($data = [])
    {

        return $this->addBeforDo($data, ['deleted_by']);

    }

    public function setSomeValuesBySendedData(array $data, array $values = [])
    {
        foreach ($values as $key => $value) {
            $data[$key] = $data[$value];
        }

        return $data;
    }
    public function setAnotherIfNull($subject,array $data,$second)
    {
        if (!$data[$subject]){
            $data = $this->setSomeValuesBySendedData($data,[$subject=>$second]);
        }

        return $data;
    }

    public function createTagIfNotExsist($data, $tagObject)
    {


        if (!isset($data['tags']) || $data['tags'] == "" ||  $data['tags'] == []) {
            $data['tags']= [];
            return $data;
        }else {
            if (!is_array($data['tags']))
                {
                    $data['tags'] = explode(',',$data['tags']);
                }
        }

        foreach ($data['tags'] as $tagKey => $tag) {
            if (!BaseValidation::pregForNum($tag)) {
                $object = $tagObject->create(['name' => $tag]);
                $data['tags'][$tagKey] = '' . $object->id . '';
            }
        }


        return $data;


    }

    public function createAttrValueIfNotExsist(array $data)
    {


        foreach ($data['attrs'] as $attr => $items) {


            if (!$items['special']) {
                if ($items['value_id'] === null) {
                    unset($data['attrs'][$attr]);
                } elseif (!BaseValidation::pregForNum($items['value_id'])) {
                    $object = AttrValues::query()->firstOrCreate(['value' => $items['value_id'], 'attr_id' => $attr], ['attr_id' => $attr, 'value' => $items['value_id']]);
                    $data['attrs'][$attr]['value_id'] = $object->id;
                }
            }

            if ($items['value_id'] !== null) {
                $data['attrs'][$attr]['attr_id'] = $attr;
            }

            if ($items['special']) {
                $object = AttrValues::query()->firstOrCreate(['value' => 'بدون مقدار', 'attr_id' => $attr, 'useless' => '1'], ['attr_id' => $attr, 'value' => 'بدون مقدار', 'useless' => '1']);
                $data['attrs'][$attr]['value_id'] = $object->id;
                $data['attrs'][$attr]['attr_id'] = $attr;
            }


        }


        return $data;


    }


    public function getObject($subject, $class, $columns = ['*'])
    {

        if (is_string($subject) or is_integer($subject)) {
            $subject = $class::query()->select($columns)->find($subject);
            if (!$subject) {
                abort(404);
            }
        }


        return $subject;

    }

    public function gateAllowsAll(array $allows)
    {

        foreach ($allows as $allow) {
            if (!Gate::allows($allow)) {
                return false;
            }
        }

        return true;

    }

    public function gateAllowsSome(array $allows)
    {

        foreach ($allows as $allow) {
            if (Gate::allows($allow)) {
                return true;
            }
        }

        return false;

    }
    public function getLevel($object)
    {

        $level = 1;

        $first = $object->parent()->first(['id','parent_id']);

        if ($first === null){
            return $level;
        }else{
            $level = 2;
        }

        $second = $first->parent()->first(['id','parent_id']);

        if ($second === null){
            return $level;
        }else{
            $level = 3;
        }

        return $level;

    }
    public function setParseDate($data,$subject)
    {

        if (isset($data[$subject]) && $data[$subject] != ''){
            $date = Verta::parse($data[$subject]);

            $data['year'] = $date->year;
            $data['day'] = $date->day;
            $data['month'] = $date->month;
        }

        unset($data['birth']);

        return $data;

    }


    public function putParentsInCollection($subject,$collection){

        if ($parent = $subject->parentComment){
            $collection->put($parent->id,$parent);
            $this->putParentsInCollection($parent,$collection);
        }

    }
    public function sortComments($comments,$subj = 'parent'){


        $comments_by_id = new Collection;

        foreach ($comments as $comment)
        {
            $comments_by_id->put($comment->id, $comment);
        }


        foreach ($comments as $key => $comment)
        {
            $comments_by_id->get($comment->id)->children = new Collection;

            if ($comment->{$subj} != 0)
            {
                if ($comments_by_id->get($comment->{$subj})){
                    $comments_by_id->get($comment->{$subj})->children->push($comment);
                }
                unset($comments[$key]);
            }
        }



        return $comments;
    }


    public function treeTheElemantsByChild($collection,$column = 'parent'){


        foreach ($collection as $key => $subject){
            $subject->children = new Collection;
        }

        foreach ($collection as $key => $subject){

            if ($subject->{$column} != 0){
                $collection->get($subject->{$column})->children->push($subject) ;
                $collection->forget($key);
            }

        }

    }
    public function dangerIp(){




    }
    public function checkUserInfoIsOk($userId = null){


        if ($userId){

            $user = User::query()->find($userId);

        }else{
            $user = auth()->user();
        }

        if (
            !$user->name
            or !$user->day
            or !$user->month
            or !$user->year
            or !$user->gender
            or !$user->username
        ){

            return false;

        }else{
            return true;
        }

    }
    public function checkUserCanChangeUsername(){

        $data = collect();
        $data->can = (int)auth()->user()->username_set  + (60 * 60 * 24 * 365) < now()->timestamp;
        $data->diff =  secondsToTime((int)auth()->user()->username_set + (60 * 60 * 24 * 365) - now()->timestamp);

        return $data;
    }
    public function checkPrivate($subject){

        $ok = false;

        if (super() or auth()->id() == $subject->user_id){
            $ok = true;
        }else{
            $mentions = $subject->mention;
            foreach ($mentions as $mention){

                if ($mention == auth()->user()->username){

                    $ok = true;

                }

            }
        }

        return $ok ? : abort(404);

    }
    public function removeCacheDynamic($model,array $cached)
    {

        foreach ($cached as $cache){
            Cache::forget($model->getTable().$model->id.$cache);
        }

    }


    public function changesWithHistory( ?array $dirty = null, ?array $original = null, ?array $excludeFields = null): array
    {


        return collect($dirty)
            ->when($excludeFields, fn($collect) => $collect->except($excludeFields))
            ->mapWithKeys(function ($new, $field) use ($original) {
                return [
                    $field => [
                        'old' => $original[$field] ?? null,
                        'new' => $new,
                    ]
                ];
            })
            ->toArray();
    }



}
