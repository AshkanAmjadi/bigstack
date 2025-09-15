<?php





use Illuminate\Support\Facades\File;



if (!function_exists('htmlAlink')){



    function htmlAlink($link,$text,$nofollow = false,$blank = true) {

        $nof = '';
        $blanktext = '';
        $norefer = '';
        if ($blank){
            $blanktext = 'target="_blank"';
            $norefer = 'noreferrer noopener';
        }
        if ($nofollow){
            $nof = 'nofollow';
        }

        return '<a href="'.$link.'" class="alink" rel="'.$nof.' '.$norefer.'" '.$blanktext.' >
     '.$text.'
      </a>';
    }



}
if (!function_exists('pp')){



    function pp(array|string|null $arr): string|null
    {
        if (!$arr){return null;}
        $retStr = '<ul>';
        if (is_array($arr)){
            foreach ($arr as $key=>$val){
                if (is_array($val)){
                    $retStr .= '<li>' . $key . ' => ' . pp($val) . '</li>';
                }else{
                    $retStr .= '<li>' . $key . ' => ' . $val . '</li>';
                }
            }
        }
        $retStr .= '</ul>';
        return $retStr;
    }


}


if (!function_exists('checkNumber')){



    function checkNumber($x,$type = 'positive') {
        if ($x > 0)
        {return $type == 'positive' ;}
        if ($x == 0)
        {return $type == 'zero' ;}
        if ($x < 0)
        {return  $type == 'negative';}
    }



}
if (!function_exists('splitLine')){



    function splitLine($string) {

        return preg_split("/\r\n|\n|\r/", $string);

    }



}
if (!function_exists('checkExpire')){



    function checkExpire($timestamp) {


        return now()->timestamp >= $timestamp;


    }



}
if (!function_exists('prepareForMultipleWhere')){



    function prepareForMultipleWhere($array) {


        $newArray = [];

        foreach ($array as $key => $value)

        return $array;

    }



}
if (!function_exists('unsetWhereNullArray')){



    function unsetWhereNullArray($array) {

        if (is_array($array)){

            foreach ($array as $key=>$value){

                if ($value === null){

                    unset($array[$key]);

                }elseif (is_array($value)){

                    $array[$key] = unsetWhereNullArray($value);

                }

            }

        }

        return $array;

    }



}

if (!function_exists('check_duplicate')){



    function check_duplicate($array) {
        $unique = array_unique($array);
        $duplicates = array_diff_assoc($array, $unique);

        return empty($duplicates);
    }

}
if (!function_exists('ifNotNull')){



    function ifNotNull($item) {
        if ($item){
            return $item;
        }
        return '';
    }

}
if (!function_exists('returnTest')){



    function returnTest() {
        return view('welcome');
    }

}

if (!function_exists('convertPersianToEnglish')){



    function convertPersianToEnglish($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        $output= str_replace($persian, $english, $string);
        return $output;
    }

}


if (!function_exists('convertEnglishToPersian')){



    function convertEnglishToPersian($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        $output= str_replace($english, $persian, $string);
        return $output;
    }

}


if (!function_exists('arrayChangeSimilarValues')){



    function arrayChangeSimilarValues($array,$old,$new) {

        foreach ($array as $item => $value){

            if ($array[$item] === $old){

                $array[$item] = $new;

            }

        }

        return $array;

    }

}


if (!function_exists('testFA')){



    function testFA(string $string)
    {
        if (preg_match('/^[^\x{600}-\x{6FF}]+$/u', str_replace("\\\\", "", $string))) {
            return false;
        }
        return true;
    }

}

if (!function_exists('imgUrlMaker')){

    function imgUrlMaker($subject,$type,$id,$ext)
    {
        return asset('image/'.$subject.'/'.$id.'/'.$type.'/'.$id.'.'.$ext);
    }

}
if (!function_exists('imgUrlMaker2')){

    function imgUrlMaker2($subject,$type)
    {
        if (!$subject){
            return null;
        }
        $id = $subject->hash_id;
        $ext = $subject->getAttribute($type);
        $table = $subject->getTable();
        $lastmod = $subject->updated_at ? '?lastmod:'.$subject->updated_at->timestamp : '';
        if ($ext){


            return asset("image/$table/$id/$type/$type.$ext").$lastmod;
        }else{
            return null;
        }
    }

}
if (!function_exists('logoSrcMaker')){



    function logoSrcMaker($subject)
    {
        return findInOption($subject,true)->value ? semanticImgUrlMaker(findInOption($subject,true),'value') : '';
    }

}
if (!function_exists('semanticImgUrlMaker')){



    function semanticImgUrlMaker($subject,$type,$lastmode = true)
    {
        if (!$subject){
            return null;
        }
        $id = $subject->hash_id;
        $ext = $subject->getAttribute($type);
        $table = $subject->getTable();
        $lastmod = $lastmode ? $subject->updated_at ? '?lastmod:'.$subject->updated_at->timestamp : '' : '';
        if ($ext){
            return asset("image/$table/$id/$type/$ext").$lastmod;
        }else{
            return null;
        }
    }

}
if (!function_exists('defaultImgUrlMaker')){



    function defaultImgUrlMaker($subject,$type)
    {
            return asset("image/defaults/$subject/$type.webp");
    }

}

//if (!function_exists('imgPathMaker')){
//
//
//
//    function imgPathMaker($subject,$type,$id,$ext)
//    {
//        return app('path.public') . '/image/'.$subject.'/'.$id.'/'.$type.'/'.$id.'.'.$ext;
//    }
//
//}
if (!function_exists('filePathMaker')){



    function filePathMaker($path)
    {
        return app('path.public') . '/' . $path;
    }

}
if (!function_exists('toSeoDate')){



    function toSeoDate($dateObject)
    {
        return $dateObject->tz('Asia/Tehran')->toAtomString();
    }

}
if (!function_exists('deleteFileIfExist')){



    function deleteFileIfExist($path)
    {

        if (File::exists($path)) {
            File::delete($path);
        }
    }

}
if (!function_exists('deleteDirIfExist')){



    function deleteDirIfExist($path)
    {



        if (File::exists($path)) {
            File::deleteDirectory($path);
        }
    }

}
if (!function_exists('fileExists')){



    function fileExists($path)
    {
        return File::exists($path);
    }

}



if (!function_exists('checkCurrentUrlAdm')){



    function checkCurrentUrlAdm($routeName , $param = [])
    {

        if (is_array($routeName)){


            foreach ($routeName as $name ){

                if (route('admin.'.$name) === url()->current()){
                    return true;
                }

            }


        }else{
            return route('admin.'.$routeName,$param) === url()->current();
        }

    }

}
if (!function_exists('checkCurrentUrl')){



    function checkCurrentUrl($routeName , $param = [])
    {

        if (is_array($routeName)){


            foreach ($routeName as $name ){

                if (route($name) === url()->current()){
                    return true;
                }

            }


        }else{
            return route($routeName,$param) === url()->current();
        }

    }

}
if (!function_exists('activeIf')){



    function activeIf($object)
    {


        return $object ? 'active' : '';


    }

}
if (!function_exists('returnIf')){



    function returnIf($object,$return = '',$false = '')
    {


        return $object ? $return : $false;


    }

}
if (!function_exists('adminRoute')){



    function adminRoute($name,$param = [])
    {


        return route('admin.'.$name,$param);


    }

}
if (!function_exists('changeKeyToValue')){



    function changeKeyToValue($array,$addOne = false)
    {
        $main = [];


        foreach ($array as $arr => $val){

            if ($addOne){
                $main[$val] = $arr + 1;
            }else{
                $main[$val] = $arr;
            }

        }


        return $main;
    }

}
if (!function_exists('toInt')){



    function toInt($obj)
    {
        return (int) $obj;
    }

}
if (!function_exists('getLastKey')){



    function getLastKey($arr)
    {
        return array_key_last($arr);
    }

}
if (!function_exists('getFirstKey')){



    function getFirstKey($arr)
    {
        return array_key_first($arr);
    }

}
if (!function_exists('moveImage')){



    function moveImage($file,$url,$name)
    {
        $file->move(public_path($url),$name);
    }

}

if (!function_exists('seeArray')){



    function seeArray($obj)
    {
        echo '<br>';
        print_r($obj);
        echo '<br>';
    }

}
if (!function_exists('seeAnything')){



    function seeAnything($obj)
    {
        echo '<br>';
        echo $obj;
        echo '<br>';
    }

}
if (!function_exists('setCheckboxValue')){



    function setCheckboxValue($data,array $array)
    {

//        dd($data);

        foreach ($array as $key =>$value){

            $data[$value] = isset($data[$value]);

        }


        return $data;

    }

}
if (!function_exists('setArrayValue')){



    function setArrayValue($data,$subject)
    {


        if (!isset($data[$subject])){
            $data[$subject] = [];
        }

        return $data;

    }

}
if (!function_exists('setSelectInputValue')){



    function setSelectInputValue($data,array $array,$set = null)
    {



        foreach ($array as $key =>$value){

            if (!isset($data[$value])){
                $data[$value] = $set;
            }

        }


        return $data;

    }

}
if (!function_exists('testSorting')){



    function testSorting($data,$filled)
    {

        $i = 0;

        foreach ($data[$filled] as $key=>$attr){

            if ($key != $i){
                return false;
            }

            $i++;
        }

        return $data;
    }

}
if (!function_exists('setSortAsValue')){



    function setSortAsValue($data,$filled)
    {
        $newData = [];

        foreach ($data[$filled] as $key=>$attr){

            $newData[$attr]['sort'] = $key + 1;

        }

        return$newData;
    }

}
if (!function_exists('json_array')){



    function json_array($string)
    {
        return json_decode($string,true);
    }

}
if (!function_exists('removeSpace')){



    function removeSpace($data,array $array = [],$replacement = '',$isArray = true)
    {


        if ($isArray){
            foreach ($array as $key =>$value){
                $data[$value] = preg_replace('/\s+/', $replacement, $data[$value]);
            }

            return $data;
        }else{
            return  preg_replace('/\s+/', $replacement, $data);
        }

    }

}
if (!function_exists('removeSpace2')){



    function removeSpace2($data,array $array = [],$replacement = '',$isArray = true)
    {


        if ($isArray){
            foreach ($array as $key =>$value){
                $data[$value] = preg_replace('/\s+/', $replacement, $data[$value]);
            }

            return $data;
        }else{
            return  preg_replace('/\s+/', $replacement, $data);
        }

    }

}
if (!function_exists('singleRemoveSpace')){



    function singleRemoveSpace($string,$replacement = '')
    {

        return preg_replace('/\s+/', $replacement, $string);

    }

}
if (!function_exists('persianDate')){



    function persianDate($value , $format = 'H:i - Y/n/j')
    {


        return verta($value)->timezone("Asia/Tehran")->format($format);


    }

}
if (!function_exists('persianDateOld')){



    function persianDateOld($value)
    {

        verta($value)->setLocale('en');
        return verta($value)->formatDifference();


    }

}
if (!function_exists('unsetValue')){



    function unsetValue($data,$del_val)
    {

        if (is_array($del_val)){

            foreach ($del_val as $value){
                if (($key = array_search($value, $data)) !== false) {
                    unset($data[$key]);
                }
            }

        }else{
            if (($key = array_search($del_val, $data)) !== false) {
                unset($data[$key]);
            }
        }

        return $data;

    }

}
if (!function_exists('removeEmptyOnArray')){



    function removeEmptyOnArray($data)
    {

        foreach ($data as $key => $value){
            if ($value == ''){
                unset($data[$key]);
            }
        }

        return $data;

    }

}
if (!function_exists('EmptyToNullOnArray')){



    function EmptyToNullOnArray($data)
    {

        foreach ($data as $key => $value){
            if ($value == ''){
                $data[$key] = null;
            }
        }

        return $data;

    }

}


if (!function_exists('str_match')){



    function str_match($string,$search)
    {
        return preg_match("/{$search}/i", $string);
    }

}


if (!function_exists('str_match_array')){

    function str_match_array($string,array $array)
    {

        foreach ($array as $value){

            if (preg_match("/{$value}/i", $string)){
                return $value;
            }

        }

        return false;


    }

}


if (!function_exists('unset_array')){

    function unset_array(array $array,array $willUnset)
    {

        foreach ($array as $key=>$value){

            if (in_array($key,$willUnset)){
                unset($array[$key]);
            }

        }

        return $array;

    }

}


if (!function_exists('getSocialOption')){

    function getSocialOption($active = true)
    {
        $option = app('custom_options')->where('description','social');
        if ($active){
            $option = $option->where('value' , true)->all();
        }

        return $option;

    }

}

if (!function_exists('findInOption')){

    function findInOption($option,$obj = false)
    {

        return is_null(app('custom_options')->where('name',$option)->first()) ?
            '':
            ($obj ? app('custom_options')->where('name',$option)->first() : app('custom_options')->where('name',$option)->first()->value);

    }

}
if (!function_exists('getOption')){

    function getOption($option)
    {

        return is_null(app('custom_options')->where('name',$option)->first()) ? '':app('custom_options')->where('name',$option)->first();

    }

}


if (!function_exists('getAllTag')){

    function getAllTag()
    {

        return \App\facade\BaseCat\BaseCat::getAllTag();

    }

}



if (!function_exists('checkTagExist')){

    function checkTagExist($tags,$tagId)
    {

        if ($tags != ''){

            foreach (explode(',',$tags) as $key=>$tag){

                if ($tagId == $tag){
                    return true;
                }

            }

        }

        return false;

    }

}
if (!function_exists('base_web')){

    function base_web()
    {


        return url()->to('/') . '/';

    }

}


if (!function_exists('editorJsDecode')){

    function editorJsDecode($obj,$column)
    {
        return $obj->{$column} ? json_decode($obj->{$column},true) : null;
    }

}
if (!function_exists('editorJsFirstPar')){

    function editorJsFirstPar($blocks)
    {

        foreach ($blocks as $block){
            if ($block['type'] == 'paragraph'){
                return $block['data']['text'];
            }
            if ($block['type'] == 'allert'){
                return $block['data']['text'];
            }
        }

    }

}

if (!function_exists('mySubject')){

    function mySubject($num)
    {
        return $num == auth()->id();
    }

}
if (!function_exists('super')){

    function super()
    {
        if (!auth()->user()){
            return false;
        }
        return auth()->user()->superuser;
    }

}
if (!function_exists('iAmInMention')){

    function iAmInMention($subject)
    {

        if (!auth()->id()){
            return false;
        }

        $mentions = $subject->mention;
        if ($subject->user_id == auth()->id()){
            return false;
        }

        foreach ($mentions as $mention){

            if ($mention == auth()->user()->id){

                return true;

            }

        }
        return false;

    }

}
if (!function_exists('inMention')){

    function inMention($mentions,$mentioned)
    {

        foreach ($mentions as $mention){
            if ($mention == $mentioned){
                return true;
            }
        }

        return  false;

    }

}
if (!function_exists('late')){

    function late($time,$minuts)
    {
        return $time->timestamp + ($minuts*60) < now()->timestamp;
    }

}
if (!function_exists('modelCanCall')){

    function modelCanCall()
    {
        return [
            'Article',
            'Conversation',
            'Answer',
            'Project',
            'Comment',
        ];
    }

}
if (!function_exists('modelCanComment')){

    function modelCanComment()
    {
        return [
            'Article',
            'Project',
        ];
    }

}



if (!function_exists('secondsToTime')){

    function secondsToTime($iSeconds)
    {

        $s = floor($iSeconds % 60);
        $m = floor($iSeconds / 60 % 60);
        $h = floor($iSeconds / 60 / 60 % 24);
        $d = floor($iSeconds / 60 / 60 / 24 % 365);
        if ($s < 10) {
            $s = '0' . $s;
        }
        if ($m < 10) {
            $m = '0' . $m;
        }
        if ($h < 10) {
            $h = '0' . $h;
        }

        $s = " $s seconds ";
        $m = $m > 0 ? " $m  minutes and" : '';
        $h = $h > 0 ? " $h hours and" : '';
        $d = $d > 0 ? " $d days and" : '';


        return $d.$h.$m.$s;

    }
}


if (!function_exists('secondsToTime')){

    function secondsToTime($iSeconds)
    {

        $s = floor($iSeconds % 60);
        $m = floor($iSeconds / 60 % 60);
        $h = floor($iSeconds / 60 / 60 % 24);
        $d = floor($iSeconds / 60 / 60 / 24 % 365);
        if ($s < 10) {
            $s = '0' . $s;
        }
        if ($m < 10) {
            $m = '0' . $m;
        }
        if ($h < 10) {
            $h = '0' . $h;
        }

        $s = "$s ثانیه";
        $m = $m > 0 ? "$m دقیقه و" : '';
        $h = $h > 0 ? "$h ساعت و" : '';
        $d = $d > 0 ? "$d روز و" : '';


        return $d.$h.$m.$s;

    }
}










