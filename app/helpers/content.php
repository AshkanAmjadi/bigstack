<?php


use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\DefaultAttributes\DefaultAttributesExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\MarkdownConverter;


if (! function_exists('markdown')) {
//todo هر بار ماژول میسازی تستش کن
    function markdown(string $str): string
    {

        $env = new Environment(config('commonmark'));
        // ۲) اضافه کردن اکستنشن‌های مورد نیاز
        $env->addExtension(new CommonMarkCoreExtension());
        $env->addExtension(new DefaultAttributesExtension());
        // 3) کانورت به HTML با حذف خودکار Raw HTML
        $converter = new MarkdownConverter($env);
        $html = $converter->convert($str)->getContent();

        return clean($html);

    }
}
