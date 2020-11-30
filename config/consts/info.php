<?php

return [
    'aws_s3' => [
        'icons' => [
            'url_local' => '/storage/icons/',
            'url_staging' => 'https://book-review-shibucha.s3.ap-northeast-1.amazonaws.com/icons/',
            'url_production' => 'https://book-review-production.s3.ap-northeast-1.amazonaws.com/icons/',
        ],
        'books' => [
            'url_local' => '/storage/books/',
            'url_staging' => 'https://book-review-shibucha.s3.ap-northeast-1.amazonaws.com/books/',
            'url_production' => 'https://book-review-production.s3.ap-northeast-1.amazonaws.com/books/',
        ],
    ],

    'storage_folders' => [
        'icons' => [
            'local' => 'public/icons',
            'staging' => 'icons',
            'production' => 'icons',
        ],
        'books' => [
            'local' => 'public/books',
            'staging' => 'books',
            'production' => 'books',
        ],
    ],
];
