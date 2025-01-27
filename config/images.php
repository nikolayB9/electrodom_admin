<?php

return [
    'disk' => 'public',
    'user' => [
        'path_to_save' => '/images/user',
        'default' => '/assets/img/default-avatar-160x160.jpg',
        'extensions' => 'jpg,png',
        'mimes' => 'jpg,png',
        'maximum_size' => 512,
        'width' => 160,
        'height' => 160,
    ],
    'category' => [
        'path_to_save' => '/images/category',
        'default' => '/assets/img/default-category-160x160.png',
        'extensions' => 'jpg,png',
        'mimes' => 'jpg,png',
        'maximum_size' => 512,
        'width' => 160,
        'height' => 160,
    ],
    'product' => [
        'path_to_save' => '/images/product',
        'default' => '/assets/img/default-product-160x160.png',
        'extensions' => 'jpg,png',
        'mimes' => 'jpg,png',
        'maximum_size' => 512,
        'width' => 160,
        'height' => 160,
    ],
];
