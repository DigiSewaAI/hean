<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// ✅ तिम्रो Excel file को path (यहाँ आफ्नो file name राख)
$inputFile = 'hostels_data.xlsx';
$outputFile = 'extracted_hostels.csv';

// Check if file exists
if (!file_exists($inputFile)) {
    die("Error: File '$inputFile' not found!\n");
}

echo "📂 Reading file: $inputFile\n";

// Load the spreadsheet
$spreadsheet = IOFactory::load($inputFile);
$sheet = $spreadsheet->getActiveSheet();
$rows = $sheet->toArray();

// Open CSV for writing
$output = fopen($outputFile, 'w');
if (!$output) {
    die("Error: Cannot create output file!\n");
}

// Write CSV headers
fputcsv($output, [
    'Hostel Name (Nepali)',
    'Owner Name',
    'Contact',
    'PAN',
    'Ward',
    'Capacity',
    'Province',
    'District',
    'Municipality',
    'Type'
]);

$count = 0;
foreach ($rows as $index => $row) {
    // Skip first row if it's header (S.N. etc.)
    if ($index == 0) {
        // Check if first cell contains "S.N." or similar
        if (strpos($row[0] ?? '', 'S.N.') !== false || strpos($row[0] ?? '', 'SN') !== false) {
            continue;
        }
    }

    $hostelName = trim($row[1] ?? '');   // Column B
    $ownerName = trim($row[3] ?? '');    // Column D
    $contact = trim($row[4] ?? '');      // Column E
    $pan = trim($row[5] ?? '');          // Column F
    $ward = trim($row[6] ?? '');         // Column G
    $capacity = trim($row[16] ?? '');    // Column Q (index 16 if A=0)

    // Skip if no hostel name
    if (empty($hostelName)) continue;

    // Write to CSV with default values
    fputcsv($output, [
        $hostelName,
        $ownerName,
        $contact,
        $pan,
        $ward,
        $capacity,
        'Bagmati',                       // Default Province
        'Kathmandu',                     // Default District
        'Kathmandu Metropolitan City',   // Default Municipality
        'co-ed'                          // Default Type
    ]);
    $count++;
}

fclose($output);
echo "✅ Extraction complete! Total: $count rows\n";
echo "📄 File saved as: $outputFile\n";