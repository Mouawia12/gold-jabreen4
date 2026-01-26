<?php

return [
    'pdf' => [
        'enabled' => true,
        'binary' => env('WKHTMLTOPDF_BINARY', '/usr/bin/wkhtmltopdf'),
        'timeout' => false,
        'options' => [
            'encoding' => 'utf-8',
            'enable-local-file-access' => true,
            'page-size' => 'A4',
            'margin-top' => 8,
            'margin-right' => 8,
            'margin-bottom' => 8,
            'margin-left' => 8,
            'dpi' => 96,
            'zoom' => 1,
            'disable-smart-shrinking' => true,
        ],
    ],
    'image' => [
        'enabled' => true,
        'binary' => env('WKHTMLTOIMAGE_BINARY', '/usr/bin/wkhtmltoimage'),
        'timeout' => false,
        'options' => [],
    ],
];
