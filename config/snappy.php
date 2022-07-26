<?php

return [

    'pdf' => [
        'enabled' => true,
        'binary'  => base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64'),
//         'binary' => base_path('vendor/bin/wkhtmltopdf-amd64-osx'),
//        'binary' => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe"',
        'timeout' => false,
        'options' => array(
            'encoding' => 'utf-8',
            'margin-top' => 15,
            'margin-bottom' => 15,
            'print-media-type' => true
        ),
        'env'     => array(),
    ],
    'image' => [
        'enabled' => true,
        'binary'  => base_path('vendor/h4cc/wkhtmltoimage-amd64/bin/wkhtmltoimage-amd64'),
//        'binary' => base_path('vendor/bin/wkhtmltoimage-amd64-osx'),
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ],

];
