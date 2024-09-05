<?php

return [
    'name' => 'Little Scientist Toddler',
    'manifest' => [
        'name' => 'Little Scientist Toddler',
        'short_name' => 'Little Scientist Toddler',
        'start_url' =>  env('APP_URL',''),
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'fullscreen',
        'orientation'=> 'any',
        'status_bar'=> 'black',
        'icons' => [
            '72x72' => [
                'path' => '/images//icons/icon_toddler_72.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/images//icons/icon_toddler_96.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '/images//icons/icon_toddler_128.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/images//icons/icon_toddler_144.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '/images//icons/icon_toddler_152.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/images//icons/icon_toddler_192.png',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => '/images//icons/icon_toddler_384.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/images//icons/icon_toddler_512.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '/images//icons/icon_toddler_512.png',
            '750x1334' => '/images//icons/icon_toddler_512.png',
            '828x1792' => '/images//icons/icon_toddler_512.png',
            '1125x2436' => '/images//icons/icon_toddler_512.png',
            '1242x2208' => '/images//icons/icon_toddler_512.png',
            '1242x2688' => '/images//icons/icon_toddler_512.png',
            '1536x2048' => '/images//icons/icon_toddler_512.png',
            '1668x2224' => '/images//icons/icon_toddler_512.png',
            '1668x2388' => '/images//icons/icon_toddler_512.png',
            '2048x2732' => '/images//icons/icon_toddler_512.png',
        ],
        // 'shortcuts' => [
        //     [
        //         'name' => 'Shortcut Link 1',
        //         'description' => 'Shortcut Link 1 Description',
        //         'url' => '/',
        //         'icons' => [
        //             "src" => "/images/images//icons/icon-72x72.png",
        //             "purpose" => "any"
        //         ]
        //     ],
        //     [
        //         'name' => 'Shortcut Link 2',
        //         'description' => 'Shortcut Link 2 Description',
        //         'url' => '/'
        //     ]
        // ],
        // "screenshots" => [
        //     [
        //         "src" => "source/image1.png",
        //         "sizes" => "640x320",
        //         "type" => "image/png",
        //         "form_factor" => "wide",
        //         "label" => "Wonder Widgets"
        //     ]
        // ],
        'custom' => []
    ]
];
