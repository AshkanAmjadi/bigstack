<?php


namespace App\facade\BaseValidation;


use League\CommonMark\CommonMarkConverter;
use Modules\Content\App\Models\Article;
use App\Models\Possible;
use App\Models\Service;
use App\Models\Tag;
use App\Models\Usage;
use App\Rules\dangerChar;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BaseValidationService
{


    public function makeValidBanner($request)
    {

        $data = $request->validate([
            'banner' => 'required|file|image|mimes:jpg,jpeg,png,gif,webp|max:1024',
        ]);

        return $data;

    }

    public function makeValidIcon($request)
    {


        $data = $request->validate([
            'icon' => 'required|file|image|mimes:svg|max:1024',
        ]);

        return $data;

    }

    public function validationForImg($required = false)
    {

        return $required ? ['required', 'file', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:1024'] : ['file', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:1024'];

    }

    public function validationForIcon($required = false)
    {

        return $required ? ['required', 'file', 'image', 'mimes:svg', 'max:1024'] : ['nullable', 'file', 'image', 'mimes:svg', 'max:1024'];

    }

    public function validationForAudio($required = false)
    {

        return $required ? ['required', 'file', 'mimes:mpga,mp3,mp4a', 'max:500'] : ['nullable', 'file', 'mimes:mpga,mp3,mp4a', 'max:500'];

    }

    public function validationForBanner($required = false)
    {

        return $required ? ['required', 'file', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:1024'] : ['file', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:1024'];

    }

    public function validationForEnChar()
    {

        return 'regex:/^[A-Za-z][A-Za-z0-9(\s)_]+$/';

    }

    public function validationForHex()
    {

        return 'regex:/^#(([0-9a-fA-F]{2}){3}|([0-9a-fA-F]){3})$/';

    }

    public function validationForLink()
    {

        return 'regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i';

    }

    public function validationForPhone()
    {

        return 'regex:/(09)[0-9]{9}/';

    }

    public function validationForMelicode()
    {

        return 'regex:/\d{10}/';

    }

    public function validationForNum()
    {

        return 'regex:/^[0-9]+$/';

    }

    public function validationForUsername()
    {

        return '/^[A-Za-z][A-Za-z0-9_.]{5,31}$/';

    }

    public function pregForNum($value)
    {

        return preg_match("/^[0-9]+$/", $value);

    }

    public function pregForNumBetween($value, $start, $end, $operatorForLength = '')
    {

        $pattern = "/^[" . $start . "-" . $end . "]" . $operatorForLength . "$/";

        return preg_match($pattern, $value);

    }

    public function base64ratio($attribute, $value, $fail, int $w, int $h)
    {
        $img = getimagesize($value);
        $W = $img[0];
        $H = $img[1];

        $wanted = round($w / $h, 1);
        $curent = round($W / $H, 1);
        $curentPlus = $curent + 0.1;
        $curentMines = $curent - 0.1;

        if ($curent === $wanted || $curentPlus === $wanted || $curentMines === $wanted) {
            return true;
        } else {
            $fail('ابعاد تصویر مناسب نیست');
        }
    }

    public function tagsValidation($attribute, $value, $fail, $admin = true)
    {


        foreach ($value as $item) {

            if (BaseValidation::pregForNum($item)) {
                if (Tag::query()->select('id')->find($item) === null) {
                    $fail('Something went wrong');
                }
            } else {

                if ($admin) {
                    if (!Tag::query()->where('name', '=', $item)->first('id')) {
                        $validation = Validator::make(['item' => $item], [
                            'item' => [
                                'string',
                                'max:250',
                                'min:3',
                                new dangerChar
                            ]
                        ]);
                        if ($validation->fails()) {
                            $fail('Something went wrong');
                        }
                    } else {
                        $fail('Something went wrong');
                    }
                } else {
                    $fail('Something went wrong');

                }


            }

        }

    }

    public function usagesValidation($attribute, $value, $fail)
    {
        foreach ($value as $item) {

            if (BaseValidation::pregForNum($item)) {
                if (Usage::query()->select('id')->find($item) === null) {
                    $fail('usage not found id:' . $item);
                }
            }

        }

    }

    public function productsValidation($attribute, $value, $fail)
    {
        foreach ($value as $item) {

            if (BaseValidation::pregForNum($item)) {
                if (Product::query()->select('id')->find($item) === null) {
                    $fail('product not found id:' . $item);
                }
            }

        }

    }

    public function ArticleValidation($attribute, $value, $fail)
    {

        foreach ($value as $item) {

            if (BaseValidation::pregForNum($item)) {
                if (Article::query()->select('id')->find($item) === null) {
                    $fail('لیست ارسال شده مشکل دارد');
                }
            }

        }

    }

    public function PossibleValidation($attribute, $value, $fail)
    {

        foreach ($value as $item) {

            if (BaseValidation::pregForNum($item)) {
                if (Possible::query()->select('id')->find($item) === null) {
                    $fail('لیست ارسال شده مشکل دارد');
                }
            }

        }

    }

    public function ServiceValidation($attribute, $value, $fail)
    {

        foreach ($value as $item) {

            if (BaseValidation::pregForNum($item)) {
                if (Service::query()->select('id')->find($item) === null) {
                    $fail('لیست ارسال شده مشکل دارد');
                }
            }

        }

    }

    public function editorjsValidation($attribute, $value, $fail, $column = true, $maxImg = 100, $decode = true)
    {


        if ($decode) {
            $content = json_decode($value, true);
        } else {
            $content = $value;
        }
        $imageCount = 0;
        \Illuminate\Log\log('content', [
            $content
        ]);
        foreach ($content as $item) {


            $type = $item['type'];
            $data = $item['data'];
            if ($type === 'header3' || $type === 'header4') {
                $type = 'header';
            }

            if ($type === 'paragraph') {


                $valid = Validator::make([
                        'paragraph' => $data['text']
                    ]
                    ,
                    [
                        'paragraph' => ['required', 'min:3', 'string', 'max:30000']
                    ]);

                if ($valid->fails()) {
                    $errors = '';
                    foreach ($valid->errors()->getMessages() as $message) {
                        $errors = $errors . $message[0] . '.';
                    }
                    $fail($errors);
                }

            } elseif ($type === 'allert') {

                $valid = Validator::make([
                        'allert' => $data['text']
                    ]
                    ,
                    [
                        'allert' => ['required', 'min:3', 'string', 'max:3000']
                    ]);

                if ($valid->fails()) {
                    $errors = '';
                    foreach ($valid->errors()->getMessages() as $message) {
                        $errors = $errors . $message[0] . '.';
                    }
                    $fail($errors);
                }

            } elseif ($type === 'header') {

                $valid = Validator::make([
                        'header' => $data['text']
                    ]
                    ,
                    [
                        'header' => ['required', 'min:3', 'string', 'max:300']
                    ]);

                if ($valid->fails()) {
                    $errors = '';
                    foreach ($valid->errors()->getMessages() as $message) {
                        $errors = $errors . $message[0] . '.';
                    }
                    $fail($errors);
                }

            } elseif ($type === 'image') {

                $imageCount++;

                if (!File::exists(app('path.public') . $item['data']['url'])) {
                    $valid = Validator::make([
                            'imgs' => $item['data']['url']
                        ]
                        ,
                        [
                            'imgs' => ['required', 'string', 'base64max:512', 'base64image:image', 'base64mimes:webp,png,jpeg,jpg',]
                        ]);

                    if ($valid->fails()) {
                        $errors = '';
                        foreach ($valid->errors()->getMessages() as $message) {
                            $errors = $errors . $message[0] . '.';
                        }
                        $fail($errors);
                    }
                }


            } elseif ($type === 'list') {

                $valid = Validator::make([
                        'list' => $data['items']
                    ]
                    ,
                    [
                        'list' => ['required', 'array', 'max:200', 'min:1'],
                        'list.*' => ['string', 'min:3', 'max:2000']
                    ]);

                if ($valid->fails()) {
                    $errors = '';
                    foreach ($valid->errors()->getMessages() as $message) {
                        $errors = $errors . $message[0] . '.';
                    }
                    $fail($errors);
                }

            } elseif ($type === 'quote') {

                $valid = Validator::make([
                        'quote' => $data['text'],
                        'caption' => $data['caption'],
                    ]
                    ,
                    [
                        'quote' => ['required', 'min:3', 'string', 'max:3000'],
                        'caption' => ['required', 'min:3', 'string', 'max:100'],
                    ]);

                if ($valid->fails()) {
                    $errors = '';
                    foreach ($valid->errors()->getMessages() as $message) {
                        $errors = $errors . $message[0] . '.';
                    }
                    $fail($errors);
                }
            } elseif ($type === 'delimiter') {

                if ($data !== []) {
                    $fail('no no');
                }

            } elseif ($type === 'table') {

                $valid = Validator::make([
                        'table' => $data['content'],
                        'withHeadings' => $data['withHeadings'],
                    ]
                    ,
                    [
                        'table' => ['required', 'array', 'max:180', 'min:2'],//rows
                        'table.*' => ['array', 'max:12', 'min:2'],//cols
                        'table.*.*' => ['string', 'max:500', 'min:1'],//texts of vessel
                        'withHeadings' => ['required', 'boolean'],
                    ]);

                if ($valid->fails()) {
                    $errors = '';
                    foreach ($valid->errors()->getMessages() as $message) {
                        $errors = $errors . $message[0] . '.';
                    }
                    $fail($errors);
                }

            } elseif ($type === 'columns' && $column) {

                $valid = Validator::make([
                        'cols' => $data['cols'],
                    ]
                    ,
                    [
                        'cols' => ['required', 'array', 'max:3', 'min:2'],
                        'cols.*.blocks' => [
                            'required',
                            'array',
                            'max:120',
                            'min:1',
                            function ($attribute, $value, $fail) {
                                $this->editorjsValidation($attribute, $value, $fail, false, 0, false);
                            }
                        ],
                    ]);

                if ($valid->fails()) {
                    $errors = '';
                    foreach ($valid->errors()->getMessages() as $message) {
                        $errors = $errors . $message[0] . '.';
                    }
                    $fail($errors);
                }

            } elseif ($type === 'code') {

                $valid = Validator::make([
                        'code' => $data['code']
                    ]
                    ,
                    [
                        'code' => ['required', 'string', 'max:30000', 'min:3']
                    ]);

                if ($valid->fails()) {
                    $errors = '';
                    foreach ($valid->errors()->getMessages() as $message) {
                        $errors = $errors . $message[0] . '.';
                    }
                    $fail($errors);
                }

            } elseif ($type === 'easymde') {


                $valid = Validator::make([
                        'easymde' => $data['text']
                    ]
                    ,
                    [
                        'easymde' => ['required', 'string', 'max:30000', 'min:3']
                    ]);

                if ($valid->fails()) {
                    $errors = '';
                    foreach ($valid->errors()->getMessages() as $message) {
                        $errors = $errors . $message[0] . '.';
                    }
                    $fail($errors);
                }


                // 3) کانورت به HTML با حذف خودکار Raw HTML
                $converter = new CommonMarkConverter([
                    'html_input' => 'strip',   // اگر تگ HTML در markdown بود، حذف‌ش می‌کند
                    'allow_unsafe_links' => false,     // لینک‌های javascript: و data: را هم می‌گیرد
                ]);
                $html = $converter->convert($data['text'])->getContent();




            } else {
                $fail('Something went wrong!!!!');
            }

            if ($imageCount > $maxImg) {
                $fail('تعداد عکس یا ارسا عکس در این قسمت مجاز نیست.');
            }


        }

    }


}
