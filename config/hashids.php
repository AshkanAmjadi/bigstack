<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Hashids Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'connections' => [

        'main' => [
            'salt' => '',
            'length' => 0,
            // 'alphabet' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
        ],

        'article' => [
            'salt' => 'art-id-lion',
            'length' => 20,
        ],

        'project' => [
            'salt' => 'prj-id-lion',
            'length' => 20,
        ],
        'category' => [
            'salt' => 'cat-id-lion',
            'length' => 20,
        ],
        'article_list' => [
            'salt' => 'artlist-id-lion',
            'length' => 20,
        ],
        'service' => [
            'salt' => 'srvc-id-lion',
            'length' => 20,
        ],
        'tag' => [
            'salt' => 'tag-id-lion',
            'length' => 20,
        ],
        'answer' => [
            'salt' => 'ans-id-lion',
            'length' => 20,
        ],
        'conversations' => [
            'salt' => 'con-id-lion',
            'length' => 20,
        ],
        'slider' => [
            'salt' => 'sl-id-lion',
            'length' => 20,
        ],
        'page' => [
            'salt' => 'pg-id-lion',
            'length' => 20,
        ],
        'users' => [
            'salt' => 'person-id-lion-8412841214051405',
            'length' => 30,
        ],
        'options' => [
            'salt' => 'opt-id-lion',
            'length' => 20,
        ],
        'web_allert' => [
            'salt' => 'weball-id-lion',
            'length' => 20,
        ],

    ],

];
