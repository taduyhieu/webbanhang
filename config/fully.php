<?php

return [
    'cache' => false,
    'per_page' => 10,
    'youtube_api_key' => 'AIzaSyCWxA4f-uv2u7sFRScx2PiSZvOOV8mIF6A',
    /*
      |--------------------------------------------------------------------------
      | Modules config
      |--------------------------------------------------------------------------
     */
    'modules' => [
        'photo_gallery' => [
            'thumb_size' => [
                'width' => 500,
                'height' => 500
            ],
            'image_dir' => '/uploads/dropzone/',
            'per_page' => 10,
        ],
        'slider' => [
            'image_size' => [
                'width' => null,
                'height' => 600
            ],
            'image_dir' => '/uploads/slider/',
        ],
        'banner' => [
            'image_size' => [
                'width' => null,
                'height' => 600
            ],
            'image_dir' => '/uploads/banner/',
        ],
        'news' => [
            'image_size' => [
                'width' => 1100,
                'height' => 720
            ],
            'image_dir' => '/uploads/news/',
            'per_page' => 10,
        ],
        'realestale-news' => [
            'image_size' => [
                'width' => 600,
                'height' => 400
            ],
            'image_dir' => '/uploads/newsrealestale/',
            'per_page' => 10,
        ],
        'category' => [
            'per_page' => 10,
        ],
        'survey' => [
            'per_page' => 10,
        ],
        'contact' => [
            'per_page' => 10,
        ],
        'video' => [
            'per_page' => 12,
        ],
        'menu' => [],
        'setting' => [],
        'user' => [
            'image_size' => [
                'width' => 600,
                'height' => 400
            ],
            'image_dir' => '/uploads/user/',
        ],
        'email' => [
            'send_to' => 'okhung466@gmail.com',
        ],
    ]
];
