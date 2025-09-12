<?php
// config/commonmark.php



use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\CommonMark\Node\Block\ListBlock;
use League\CommonMark\Extension\Table\Table;
use League\CommonMark\Extension\Table\TableCell;
use League\CommonMark\Extension\Table\TableRow;
use League\CommonMark\Node\Block\Paragraph;


return [

    // ۱) تنظیمات عمومی
    'html_input'         => 'strip',  // <script> یا هر تگ HTML درون Markdown را پاک می‌کند
    'allow_unsafe_links' => false,    // لینک‌های javascript: و data: را اجازه نمی‌دهد

    // ۲) افزونه‌ها (اختیاری، برای پشتیبانی از {.class} در خود متن Markdown)

    'default_attributes' => [
        Heading::class => [
            'class' => static function (Heading $node) {
                // بسته به سطح تیتر کلاس متفاوت بده
                return match ($node->getLevel()) {
                    1 => 'font-bold text-sextr',
                    2 => 'font-bold text-felg',
                    3 => 'font-bold text-elg',
                    4 => 'font-bold text-lg',
                    5 => 'font-bold text-mid',
                    6 => 'font-bold text-smid',
                    default => null,
                };
            },
        ],

        // پاراگراف
        Paragraph::class => [
            'class' => ['paragraphSize',' font-normal ','indent-4 ','leading-8 px-2'],
        ],

        // بلاک لیست (ul یا ol)
        ListBlock::class => [
            'class' => ['listDesc paragraphSize font-semibold space-y-4 pr-4 py-2 border-r-2 border-blue-500'],
        ],

        // هر آیتم لیست (li)
//        ListItem::class => [
//            'class' => ['mb-1'],
//        ],

        // بلاک کد محصور شده با ``` یا ~~~
//        FencedCode::class => [
//            'class' => ['bg-gray-100', 'p-4', 'rounded', 'mb-4', 'overflow-x-auto'],
//        ],

    ],
];
