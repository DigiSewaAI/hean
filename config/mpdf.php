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
    
    // ✅ फन्ट डाइरेक्ट्री – public/fonts लाई प्रयोग गर्ने
    'fontDir' => [
        public_path('fonts'),
    ],
    
    // ✅ NotoSansDevanagari फन्ट दर्ता
    'fontdata' => [
        'notosansdevanagari' => [
            'R' => 'NotoSansDevanagari-Regular.ttf',
            'B' => 'NotoSansDevanagari-Bold.ttf',
            'I' => 'NotoSansDevanagari-Regular.ttf',
            'BI' => 'NotoSansDevanagari-Bold.ttf',
        ],
        'dejavusans' => [
            'R' => 'DejaVuSans.ttf',
            'B' => 'DejaVuSans-Bold.ttf',
            'I' => 'DejaVuSans.ttf',
            'BI' => 'DejaVuSans-Bold.ttf',
        ],
    ],
    
    // 🔥 यो सच्याउनुहोस् – mpdf को वास्तविक cache path
    'font_cache' => storage_path('app/mpdf/mpdf/ttfontdata'),
    
    'temp_dir' => storage_path('app/mpdf'),
    'autoScriptToLang' => true,
    'autoLangToFont' => true,
    'useSubstitutions' => true,
];