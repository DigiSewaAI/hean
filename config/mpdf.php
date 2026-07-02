<?php
return [
    'mode' => 'utf-8',
    'format' => 'A4',
    'default_font_size' => 12,
    'default_font' => 'notosansdevanagari',
    'margin_left' => 10,
    'margin_right' => 10,
    'margin_top' => 10,
    'margin_bottom' => 10,
    'orientation' => 'P',
    'fontDir' => [public_path('fonts')],
    'fontdata' => [
        'notosansdevanagari' => [
            'R' => 'NotoSansDevanagari-Regular.ttf',
            'B' => 'NotoSansDevanagari-Bold.ttf',
        ]
    ],
    'font_cache' => storage_path('fonts'),
    'temp_dir' => storage_path('app/mpdf'),
    'autoScriptToLang' => true,
    'autoLangToFont' => true,
];