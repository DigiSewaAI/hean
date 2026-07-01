<?php

namespace App\Imports;

use App\Models\Hostel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\Importable;

class HostelsImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    use Importable;

    // हामी CSV को हेडर (पहिलो पंक्ति) प्रयोग गर्छौं
    public function headingRow(): int
    {
        return 1;
    }

    public function model(array $row)
    {
        // ===== हेडर अनुसार कलमहरू निकाल्नुहोस् =====
        // CSV मा हेडर: S.N., HOSTEL'S NAME, LOCATION, Ower Name, PHONE NO
        $sno = $row['s.n.'] ?? null;
        $englishName = $row['hostel\'s name'] ?? $row['hostels_name'] ?? null;
        $location = $row['location'] ?? null;
        $operator = $row['ower name'] ?? $row['owner_name'] ?? null;
        $contact = $row['phone no'] ?? $row['phone'] ?? null;

        // यदि S.N. छैन भने skip (हुन सक्छ कि खाली पंक्ति हो)
        if (!$sno) {
            return null;
        }

        // यदि English Name वा Contact छैन भने skip
        if (!$englishName || !$contact) {
            return null;
        }

        // ===== ठेगाना पार्स =====
        $district = 'Unknown';
        $municipality = 'Unknown';
        $ward = '0';

        if ($location) {
            if (preg_match('/^(.+?)[\s\-–]+(\d+)$/u', $location, $matches)) {
                $district = trim($matches[1]);
                $ward = $matches[2];
                $municipality = $district;
            } else {
                $district = $location;
                $municipality = $location;
            }
        }

        // ===== डिफल्ट मान =====
        $defaults = [
            'type' => null,
            'capacity' => 0,
            'rooms' => 0,
            'approved' => false,
            'featured' => false,
            'visible' => true,
            'owner_id' => null,
            'description' => 'Imported from CSV (web sheet)',
            'street' => null,
            'image' => null,
        ];

        // ===== डुप्लिकेट चेक =====
        $existing = Hostel::where('name_english', $englishName)
                          ->orWhere('contact', $contact)
                          ->first();

        if ($existing) {
            return null;
        }

        // ===== Hostel सिर्जना =====
        return new Hostel([
            'name_nepali'    => $englishName,
            'name_english'   => $englishName,
            'operator_name'  => $operator ?: $englishName,
            'district'       => $district,
            'municipality'   => $municipality,
            'ward'           => $ward,
            'street'         => $defaults['street'],
            'contact'        => $contact,
            'description'    => $defaults['description'],
            'approved'       => $defaults['approved'],
            'featured'       => $defaults['featured'],
            'visible'        => $defaults['visible'],
            'type'           => $defaults['type'],
            'capacity'       => $defaults['capacity'],
            'rooms'          => $defaults['rooms'],
            'owner_id'       => $defaults['owner_id'],
            'image'          => $defaults['image'],
        ]);
    }
}