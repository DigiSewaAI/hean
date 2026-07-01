<?php

return [
    'default_font' => 'NotoSansDevanagari',
    'font_dir' => public_path('fonts'),
    'font_cache' => storage_path('fonts'),
    'enable_html5_parser' => true,
    'enable_remote' => false,
    'default_paper_size' => 'a4',
    'default_paper_orientation' => 'portrait',
    'dpi' => 150,
    'debug' => false,
    'log_output_file' => storage_path('logs/dompdf.log'),
    'enable_php' => false,
    'enable_javascript' => false,
];